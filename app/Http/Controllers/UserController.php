<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ApplicantSkill;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('role:applicant', ['only' => ['update']]);
        $this->middleware('role:company', ['only' => ['show']]);
    }

    public function register(Request $request) {

        $validates = [
                    'first_name'    => 'required',
                    'last_name'     => 'required',
                    'business_name' => $request->get('is_company') ? 'required' : '',
                    'email'         => 'required|string|email|max:255|unique:users',
                    'password'      => 'required|string|min:6|confirmed',
                ];

        $validator = Validator::make($request->all(), $validates);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'business_name' => $request->get('business_name'),
            'is_company' => $request->get('is_company'),
            'is_applicant' => $request->get('is_applicant'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }

    public function login(Request $request) {

        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function profile() {

        try {

                if (! $user = JWTAuth::parseToken()->authenticate()) {
                        return response()->json(['user_not_found'], 404);
                }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                return response()->json(['token_absent'], $e->getStatusCode());

        }

        $user['skills'] = $user->applicantSkills();

        return response()->json(compact('user'));
    }

    public function show($id) {

        try {

                if (! $user = User::where('role', 'applicant')->find($id)) {
                        $code = 404;
                        $status = 'error';
                        $user = [];
                        return response()->json(compact('code', 'status', 'user'));
                }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                return response()->json(['token_absent'], $e->getStatusCode());

        }

        $code = 200;
        $status = 'success';
        $user['skills'] = $user->applicantSkills();

        return response()->json(compact('code', 'status', 'user'));
    }

    public function update(Request $request) {

        $user = JWTAuth::parseToken()->authenticate();

        if ($request->hasFile('profile_picture')) {
            
            //
            $validates = [
                    'profile_picture'   => 'mimes:jpeg,png|max:2048',
                    'resume'            => 'mimes:doc,docx,pdf|max:2048',
                ];

            $validator = Validator::make($request->all(), $validates);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $profile_picture = $request->file('profile_picture');
            $imageDestinationPath = 'images';
            $extension = $profile_picture->getClientOriginalExtension();
            $profile_picture->move($imageDestinationPath,"uid_".$user->id.".".$extension);
            $picture_url = url($imageDestinationPath.'/'."uid_".$user->id.".".$extension);

            $resume = $request->file('resume');
            $resumeDestinationPath = 'resumes';
            $extension = $resume->getClientOriginalExtension();
            $resume->move($resumeDestinationPath,"uid_".$user->id.".".$extension);
            $resume_url = url($resumeDestinationPath.'/'."uid_".$user->id.".".$extension);

            $user = User::where('id', $user->id)
                    ->update([
                        'profile_picture'   => $picture_url,
                        'resume'            => $resume_url,
                    ]);
        }

        $user = JWTAuth::parseToken()->authenticate();

        return response()->json(compact('user'),200);
    }

    public function logout() {

        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

}