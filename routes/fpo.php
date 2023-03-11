<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsFpoLogin;
use App\Http\Middleware\IsFpoLogout;

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

Route::group(['namespace' => 'Fpo', 'middleware' => [IsFpoLogout::class]], function () {
    Route::get('/', 'AuthController@login');
    Route::get('login', 'AuthController@login');
    Route::post('login', 'AuthController@loginProcess');

    Route::get('forgot-password', 'AuthController@forgotPassword');
    Route::post('forgot-password', 'AuthController@forgotPasswordProcess');
    
    Route::get('reset-password', 'AuthController@resetPassword');
    Route::post('reset-password', 'AuthController@resetPasswordProcess');

    Route::get('register', 'AuthController@register');
    Route::post('register', 'AuthController@registerProcess');
});



Route::group(['namespace' => 'Fpo', 'middleware' => [IsFpoLogin::class]], function() {
    Route::get('logout', 'AuthController@logout');
    
    Route::get('dashboard', 'HomeController@index');

    Route::get('setting', 'SettingController@index');

    // Produce
    Route::group(['prefix' => 'fpo'], function() {
        Route::get('/', 'FpoController@fpolist');
        Route::get('list', 'FpoController@fpoList');
        
        Route::get('create', 'FpoController@fpoCreate');
        Route::post('create', 'FpoController@fpoCreateProcess');

        Route::get('edit/{slug}', 'FpoController@fpoEdit');
        Route::post('update', 'FpoController@fpoEditProcess');

        Route::get('delete/{slug}', 'FpoController@fpoDelete');
        Route::get('change-status/{slug}', 'FpoController@fpoChangeStatus');
    });

    // Profile
    Route::group(['prefix' => 'profile'], function() {
        Route::get('/', 'ProfileController@index');
        Route::post('update', 'ProfileController@profileUpdate');
        Route::post('change-password', 'ProfileController@changePassword');

        Route::get('image-update/{slug}', 'ProfileController@profileImageUpdate');
        Route::post('image-update', 'ProfileController@profileImageUpdateProcess');

        Route::get('set-profile-image/{slug}', 'ProfileController@setProfilePicture');
        Route::get('set-demo-profile-image', 'ProfileController@setDemoProfilePicture');
        Route::get('delete-profile-image/{slug}', 'ProfileController@deleteProfilePicture');
    });
});

