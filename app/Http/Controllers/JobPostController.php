<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use App\Models\JobPost;
use Illuminate\Http\Request;
use App\Models\ApplicantSkill;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class JobPostController extends Controller
{
    public function __construct() {
        $this->middleware('role:company', ['only' => ['store']]);
        $this->middleware('role:company', ['only' => ['postedJobs']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobPosts = JobPost::get();
        foreach ($jobPosts as $key => $value) {
            $jobPosts[$key]['company_details'] = User::where('id', $jobPosts[$key]['user_id'])->first();
        }
        $code = 200;
        $status = 'success';
        return response()->json(compact('code', 'status', 'jobPosts'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function postedJobs()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $jobPosts = JobPost::where('user_id', $user->id)->get();
        $userDetails = [];
        foreach ($jobPosts as $key => $value) {
            $jobPosts[$key]['company_details'] = User::where('id', $jobPosts[$key]['user_id'])->first();
        }
        $code = 200;
        $status = 'success';
        return response()->json(compact('code', 'status', 'jobPosts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $validates = [
                    'job_title'         => 'required',
                    'job_description'   => 'required',
                    'salary'            => 'required|numeric',
                    'location'          => 'required',
                    'country'           => 'required',
                    'deadline'          => 'required|date',
                ];

        $validator = Validator::make($request->all(), $validates);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $skills = JobPost::create([
            'user_id'           => $user->id,
            'job_title'         => $request->get('job_title'),
            'job_description'   => $request->get('job_description'),
            'salary'            => $request->get('salary'),
            'location'          => $request->get('location'),
            'country'           => $request->get('country'),
            'deadline'          => $request->get('deadline'),
        ]);

        return response()->json(compact('skills'),200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jobPost = JobPost::find($id);
        $userDetails = [];
        $jobPost['company_details'] = User::where('id', $jobPost['user_id'])->first();

        $code = 200;
        $status = 'success';
        return response()->json(compact('code', 'status', 'jobPost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
