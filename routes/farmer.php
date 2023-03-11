<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsFarmerLogin;
use App\Http\Middleware\IsFarmerLogout;

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

Route::group(['namespace' => 'Farmer', 'middleware' => [IsFarmerLogout::class]], function () {
    Route::get('/', 'AuthController@login');
    Route::get('login', 'AuthController@login');
    Route::post('login', 'AuthController@loginProcess');

    Route::get('register', 'AuthController@register');
    Route::post('register', 'AuthController@registerProcess');

    Route::get('forgot-password', 'AuthController@forgotPassword');
    Route::post('forgot-password', 'AuthController@forgotPasswordProcess');
    
    Route::get('reset-password', 'AuthController@resetPassword');
    Route::post('reset-password', 'AuthController@resetPasswordProcess');
});



Route::group(['namespace' => 'Farmer', 'middleware' => [IsFarmerLogin::class]], function() {
    Route::get('logout', 'AuthController@logout');
    
    Route::get('dashboard', 'HomeController@index');

    Route::get('setting', 'SettingController@index');

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

    // Produce
    Route::group(['prefix' => 'produce'], function() {
        Route::get('/', 'ProduceController@produceList');
        Route::get('list', 'ProduceController@produceList');
        
        Route::get('create', 'ProduceController@produceCreate');
        Route::post('create', 'ProduceController@produceCreateProcess');

        Route::get('edit/{slug}', 'ProduceController@produceEdit');
        Route::post('update', 'ProduceController@produceEditProcess');

        Route::get('delete/{slug}', 'ProduceController@produceDelete');
        Route::get('change-status/{slug}', 'ProduceController@produceChangeStatus');

        Route::get('get-produce-name-variant/{produceSlug}', 'ProduceController@getProduceNameVariant');
    });

});

