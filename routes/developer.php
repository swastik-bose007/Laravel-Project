<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsDeveloperLogin;
use App\Http\Middleware\IsDeveloperLogout;

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

Route::group(['namespace' => 'Developer', 'middleware' => [IsDeveloperLogout::class]], function () {
    Route::get('/', 'AuthController@login');
    Route::get('login', 'AuthController@login');
    Route::post('login', 'AuthController@loginProcess');

    Route::get('forgot-password', 'AuthController@forgotPassword');
    Route::post('forgot-password', 'AuthController@forgotPasswordProcess');
    
    Route::get('reset-password', 'AuthController@resetPassword');
    Route::post('reset-password', 'AuthController@resetPasswordProcess');
});



Route::group(['namespace' => 'Developer', 'middleware' => [IsDeveloperLogin::class]], function() {
    Route::get('logout', 'AuthController@logout');
    Route::get('profile', 'ProfileController@viewProfile');
    
    Route::get('dashboard', 'HomeController@index');
    Route::get('setting', 'SettingController@index');
    Route::get('error-logs', 'ErrorLogsController@index');
});

