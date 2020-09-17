<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function() {

	Route::get('job/post', 		'App\Http\Controllers\JobPostController@index');
	Route::get('job/post/{id}', 	'App\Http\Controllers\JobPostController@show');

	Route::post('register', 	'App\Http\Controllers\UserController@register');
	Route::post('login', 		'App\Http\Controllers\UserController@login');

	Route::group(['middleware' => ['jwt.verify']], function() {
	
    	Route::get('user/my-profile', 	'App\Http\Controllers\UserController@profile');
    	Route::post('user/update', 	'App\Http\Controllers\UserController@update');
    	Route::get('user/details/{id}', 	'App\Http\Controllers\UserController@show');

    	Route::get('job/skills', 	'App\Http\Controllers\SkillController@index');
    	Route::post('job/skills', 	'App\Http\Controllers\SkillController@store');

    	Route::get('user/job/application', 	'App\Http\Controllers\JobApplicationController@jobApplications');
    	Route::post('user/job/application/{$id}', 	'App\Http\Controllers\JobApplicationController@store');

    	Route::post('company/job/post', 	'App\Http\Controllers\JobPostController@store');
    	Route::get('company/jobs', 	'App\Http\Controllers\JobPostController@postedJobs');
    	Route::get('company/job/applicants/{job_id}', 	'App\Http\Controllers\JobApplicationController@jobApplicants');
    	

    	Route::post('logout', 		'App\Http\Controllers\UserController@logout');
    	// Route::get('closed', 		'App\Http\Controllers\JobPostController@closed');

	});

});