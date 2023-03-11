<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdministrationLogin;
use App\Http\Middleware\IsAdministrationLogout;

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

Route::group(['namespace' => 'Administration', 'middleware' => [IsAdministrationLogout::class]], function () {
    Route::get('/', 'AuthController@login');
    Route::get('login', 'AuthController@login');
    Route::post('login', 'AuthController@loginProcess');

    Route::get('forgot-password', 'AuthController@forgotPassword');
    Route::post('forgot-password', 'AuthController@forgotPasswordProcess');
    
    Route::get('reset-password', 'AuthController@resetPassword');
    Route::post('reset-password', 'AuthController@resetPasswordProcess');
});



Route::group(['namespace' => 'Administration', 'middleware' => [IsAdministrationLogin::class]], function() {
    Route::get('logout', 'AuthController@logout');
    
    Route::get('dashboard', 'HomeController@index');


    Route::group(['namespace' => 'Inventory', 'prefix' => 'inventory', 'middleware' => [IsAdministrationLogin::class]], function() {
        
        Route::get('incoming-purchase', 'IncomingPurchaseController@index');
        Route::get('outgoing-orders', 'OutgoingOrdersController@index');
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

    Route::get('purchase', 'PurchaseController@index');
    Route::get('sales', 'SalesController@index');
    Route::get('revenue', 'RevenueController@index');
    Route::get('setting', 'SettingController@index');
});

