<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PassportAuthController;
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

Route::group(['middleware' => ['cors', 'json.response']], function () {

    Route::post('register', 'App\Http\Controllers\Auth\PassportAuthController@register');
    Route::post('login', 'App\Http\Controllers\Auth\PassportAuthController@login');
    Route::post('logout', 'App\Http\Controllers\Auth\PassportAuthController@logout');
    
});

Route::middleware('auth:api')->group(function () {
    // our routes to be protected will go in here

    Route::post('registerStudent', 'App\Http\Controllers\Controller@registerStudent');
    Route::post('updateStudentDetails', 'App\Http\Controllers\Controller@updateStudentDetails');
    Route::get('getStudentDetailsByAdmissionNumber', 'App\Http\Controllers\Controller@getStudentDetailsByAdmissionNumber');
    Route::get('getFeesDetails/{admission_number}','App\Http\Controllers\Controller@getFeesDetails');
    Route::get('getAttendanceStatus/{admission_number}/{startDate}/{endDate}','App\Http\Controllers\AttendenceController@getAttendanceStatus');
    Route::post('logout', 'App\Http\Controllers\Auth\PassportAuthController@logout');
   
});
