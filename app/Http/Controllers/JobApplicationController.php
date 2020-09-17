<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use App\Models\JobPost;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use App\Models\ApplicantSkill;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class JobApplicationController extends Controller
{
    public function __construct() {
        $this->middleware('role:applicant', ['only' => ['jobApplications']]);
        $this->middleware('role:company', ['only' => ['jobApplicants']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jobApplications()
    {
        $applications = JobApplication::where('user_id', $user->id)->get();
        $code = 200;
        $status = 'success';
        return response()->json(compact('code', 'status', 'applications'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jobApplicants($job_id)
    {
        // $user = JWTAuth::parseToken()->authenticate();
        $jobApplicants = JobApplication::where('job_id', $job_id)->get();
        foreach ($jobApplicants as $key => $value) {
            $jobApplicants[$key]['user_details'] = User::where('id', $jobApplicants[$key]['user_id'])->first();
        }
        $code = 200;
        $status = 'success';
        return response()->json(compact('code', 'status', 'jobApplicants'));
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
    public function store($id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $applications = JobPost::create([
            'user_id'           => $user->id,
            'job_id'           => $user->id,
        ]);

        return response()->json(compact('applications'),200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
