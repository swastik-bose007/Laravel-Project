<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdminLogin;
use App\Http\Middleware\IsAdminLogout;

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

Route::group(['namespace' => 'Admin', 'middleware' => [IsAdminLogout::class]], function () {
    Route::get('/', 'AuthController@login');
    Route::get('login', 'AuthController@login');
    Route::post('login', 'AuthController@loginProcess');

    Route::get('forgot-password', 'AuthController@forgotPassword');
    Route::post('forgot-password', 'AuthController@forgotPasswordProcess');
    
    Route::get('reset-password', 'AuthController@resetPassword');
    Route::post('reset-password', 'AuthController@resetPasswordProcess');
});



Route::group(['namespace' => 'Admin', 'middleware' => [IsAdminLogin::class]], function() {
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
    
    // User Management
    Route::group(['prefix' => 'user-management', 'middleware' => [IsAdminLogin::class]], function() {
        Route::get('/', 'UserController@userlist');
        Route::get('list', 'UserController@userList');
        
        Route::get('create', 'UserController@userCreate');
        Route::post('create', 'UserController@userCreateProcess');

        Route::get('edit/{slug}', 'UserController@userEdit');
        Route::post('update', 'UserController@userEditProcess');

        Route::get('delete/{slug}', 'UserController@userDelete');
        Route::get('change-status/{slug}', 'UserController@userChangeStatus');
    });

    // Category Management
    Route::group(['prefix' => 'category-management', 'middleware' => [IsAdminLogin::class]], function() {
        Route::get('/', 'CategoryController@categoryList');
        Route::get('list', 'CategoryController@categoryList');
        
        Route::get('create', 'CategoryController@categoryCreate');
        Route::post('create', 'CategoryController@categoryCreateProcess');

        Route::get('edit/{slug}', 'CategoryController@categoryEdit');
        Route::post('update', 'CategoryController@categoryEditProcess');

        Route::get('delete/{slug}', 'CategoryController@categoryDelete');
        Route::get('change-status/{slug}', 'CategoryController@categoryChangeStatus');


    });

    // Weight
    Route::group(['prefix' => 'weight-unit', 'middleware' => [IsAdminLogin::class]], function() {

        Route::get('/', 'WeightController@weightUnitList');
        Route::get('list', 'WeightController@weightUnitList');

        Route::get('add', 'WeightController@weightUnitCreate');
        Route::post('add', 'WeightController@weightUnitCreateProcess');

        Route::get('edit/{slug}', 'WeightController@weightUnitEdit');
        Route::post('update', 'WeightController@weightUnitEditProcess');

        Route::get('delete/{slug}', 'WeightController@weightUnitDelete');
        Route::get('change-status/{slug}', 'WeightController@weightUnitChangeStatus');
    });

    // Media Library
    Route::group(['prefix' => 'media', 'middleware' => [IsAdminLogin::class]], function() {

        Route::get('/', 'MediaController@mediaLibraryList');
        Route::get('list', 'MediaController@mediaLibraryList');

        Route::get('create/{slug}', 'MediaController@mediaLibraryCreate');
        Route::post('create', 'MediaController@mediaLibraryCreateProcess');

        Route::get('delete/{slug}', 'MediaController@mediaLibraryDelete');
    });


    // Produce Name
    Route::group(['prefix' => 'produce-name','middleware' => [IsAdminLogin::class]], function() {
        Route::get('/', 'ProduceNameController@produceNameList');
        Route::get('list', 'ProduceNameController@produceNameList');
        
        Route::get('create', 'ProduceNameController@produceNameCreate');
        Route::post('create', 'ProduceNameController@produceNameCreateProcess');

        Route::get('edit/{slug}', 'ProduceNameController@produceNameEdit');
        Route::post('update', 'ProduceNameController@produceNameEditProcess');

        Route::get('delete/{slug}', 'ProduceNameController@produceNameDelete');
        Route::get('change-status/{slug}', 'ProduceNameController@produceNameChangeStatus');

        Route::get('deleteimage/{id}', 'ProduceNameController@produceDeleteImage');

        // Manage Variant
        Route::group(['prefix' => 'variant','middleware' => [IsAdminLogin::class]], function() {
            Route::get('//{slug}', 'VariantController@variantList');
            Route::get('list/{slug}', 'VariantController@variantList');
            
            Route::get('create/{slug}', 'VariantController@variantCreate');
            Route::post('create', 'VariantController@variantCreateProcess');

            Route::get('edit/{slug}', 'VariantController@variantEdit');
            Route::post('update', 'VariantController@variantEditProcess');

            Route::get('delete/{slug}', 'VariantController@variantDelete');
            Route::get('change-status/{slug}', 'VariantController@variantChangeStatus');
        });
    });
    
});

