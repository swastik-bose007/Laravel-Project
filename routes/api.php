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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group([
    'prefix' => 'seller/v1',
    'namespace' => 'Api\Seller\v1',
    'middleware' => []], function () {

        // auth
        Route::group(['prefix' => 'auth', 'middleware' => []], function () {
            Route::post('login', 'AuthController@login', ['as' => 'login']);
            Route::post('register', 'AuthController@register', ['as' => 'login']);
            Route::post('logout', 'AuthController@logout');
            Route::post('forgot-password', 'AuthController@forgotPassword');
            Route::post('reset-password', 'AuthController@resetPassword');
            Route::post('check-reset-token', 'AuthController@checkToken');
        });

        // onboarding
        Route::group(['prefix' => 'onboarding', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-step', 'OnboardingController@getStep');
            Route::post('add-creadit-card-details', 'OnboardingController@addCreaditCardDetails');
            Route::post('skip-creadit-card-details', 'OnboardingController@skipCreaditCardDetails');
            Route::post('skip-stripe', 'OnboardingController@skipStripe');
            Route::post('start-free-trial', 'OnboardingController@startFreeTrial');

            Route::post('onboarding-add-card', 'OnboardingController@addNewCard');
        });

        // Dashboard
        Route::group(['prefix' => 'dashboard', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-dashboard', 'DashboardController@getDashboard');
            Route::post('dashboard-count', 'DashboardController@dashboardCount');
        });

        // User Profile
        Route::group(['prefix' => 'profile', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('picture-update', 'ProfileController@pictureUpdate');
            Route::post('data-update', 'ProfileController@dataUpdate');
            Route::post('change-password', 'ProfileController@changePassword');
            Route::post('store-status-chnage', 'ProfileController@storeStatusChnage');
            Route::post('update-order-message', 'ProfileController@updateOrderMessage');
            Route::post('get-followers-list', 'ProfileController@getFollowersList');
            Route::post('get-profile', 'ProfileController@getProfile');
        });

        // shipping handling
        Route::group(['prefix' => 'shipping-handling', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('create-shipping', 'ShippingHandlingController@createShipping');
            Route::post('get-shipping', 'ShippingHandlingController@getShipping');
            Route::post('get-all', 'ShippingHandlingController@getShipping');
        });

        // policy
        Route::group(['prefix' => 'policy', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-all', 'PolicyController@getAllPolicy');
            Route::post('get-single', 'PolicyController@getSingle');
            Route::post('create-new', 'PolicyController@createNew');
            Route::post('update', 'PolicyController@updatePolicy');
            Route::post('contact-us/update', 'PolicyController@contactUsUpdate');
            Route::post('return-policy/update', 'PolicyController@returnPolicyUpdate');
            Route::post('shipping-handling-policy/update', 'PolicyController@shippingHandlingPolicyUpdate');
            Route::post('delete', 'PolicyController@deletePolicy');
        });

        // card
        Route::group(['prefix' => 'card', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('add-card', 'CardController@addNewCard');
            Route::post('get-card', 'CardController@getCard');
            Route::post('delete-card', 'CardController@deleteCard');
            Route::post('set-default-card', 'CardController@setDefaultCard');
            Route::post('add-card-app', 'CardController@addNewCardSellerApp');
        });


        // category
        Route::group(['prefix' => 'category', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-single-category', 'CategoryController@getSingleCategory');
            Route::post('get-all-category', 'CategoryController@getAllCategory');
            Route::post('create-category', 'CategoryController@createCategory');
            Route::post('update-category', 'CategoryController@updateCategory');
            Route::post('delete-category', 'CategoryController@deleteCategory');
            Route::post('status-change-category', 'CategoryController@statusChangeCategory');
            Route::post('new-request', 'CategoryController@newRequest');

            Route::post('get-parent-category', 'CategoryController@getParentCategory');
            Route::post('get-child-category', 'CategoryController@getChildCategory');
        });

        // seller category []
        Route::group(['prefix' => 'seller-category', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('create', 'CategorySellerController@createCategory');//of no use right now
            Route::post('delete', 'CategorySellerController@deleteCategory');//of no use right now
            Route::post('get-all', 'CategorySellerController@getAllCategory');
            Route::post('status-change', 'CategorySellerController@statusChangeCategory');//of no use right now
        });

        // product
        Route::group(['prefix' => 'product', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('product-by-category', 'ProductController@productByCategory');
            Route::post('get-parent-category', 'ProductController@getParentCategory');
            Route::post('get-child-category', 'ProductController@getChildCategory');
            Route::post('get-single-product', 'ProductController@getSingleProduct');
            Route::post('create-product', 'ProductController@createProduct');
            Route::post('update-product', 'ProductController@updateProduct');
            Route::post('update-product-status', 'ProductController@updateProductStatus');
            Route::post('delete-product', 'ProductController@deleteProduct');
            Route::post('delete-product-image', 'ProductController@deleteProductImage'); 
            Route::post('get-seller-product', 'ProductController@getSellerProduct');
        });

        // product
        Route::group(['prefix' => 'product-variant', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-variants-and-combination', 'ProductVariantController@getProductVariantsCombination');
            Route::post('generate-combination', 'ProductVariantController@generateCombination');
            Route::post('update-combination', 'ProductVariantController@updateCombination');
            Route::post('remove-combination', 'ProductVariantController@removeCombination');
            Route::post('restore-combination', 'ProductVariantController@restoreCombination');
            Route::post('delete-combination', 'ProductVariantController@deleteCombination');
            Route::post('delete-combination-image', 'ProductVariantController@deleteCombinationImage'); 
        });

        // Notification
        Route::group(['prefix' => 'notification', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-notification', 'NotificationController@getNotification');
            Route::post('get-single-notification', 'NotificationController@getSingleNotification');  
            Route::post('seen-notification', 'NotificationController@seenNotification');
            Route::post('count-unseen-notification', 'NotificationController@countUnseenNotification');  
        });

        // Orders
        Route::group(['prefix' => 'orders', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-all-order', 'OrderController@getAllOrder');
            Route::post('get-single-order', 'OrderController@getSingleOrder');
            Route::post('get-single-order-for-package', 'OrderController@getSingleOrderForPackage');

            Route::post('itmes-accept-reject', 'OrderController@itmesAcceptReject');
            Route::post('create-package', 'OrderController@createPackage');

            Route::post('get-all-return-order', 'OrderController@getReturnOrderList');
            Route::post('get-single-order-return', 'OrderController@getSingleOrderReturn');
        });


        // Subscription
        Route::group(['prefix' => 'subscription', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('create-subscription', 'SubscriptionController@createSubscription');
            Route::post('get-subscription-details', 'SubscriptionController@getSubscriptionDetails');
            Route::post('subscription-status-change', 'SubscriptionController@subscriptionStatusChange');
            Route::post('delete-subscription', 'SubscriptionController@deleteSubscription');
            Route::post('re-subscription', 'SubscriptionController@reSubscription');
        });

        // post
        Route::group(['prefix' => 'post', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-single', 'PostController@getSinglePost');
            Route::post('get-all', 'PostController@getAllPost');
            Route::post('create', 'PostController@createPost');
            Route::post('update', 'PostController@updatePost');
            Route::post('delete', 'PostController@deletePost');
        });
});



//for admin
Route::group([
    'prefix' => 'admin/v1',
    'namespace' => 'Api\Admin\v1',
    'middleware' => []], function () {

        // auth
        Route::group(['prefix' => 'auth', 'middleware' => []], function () {
            Route::post('login', 'AuthController@login', ['as' => 'login']);
            Route::post('logout', 'AuthController@logout');
        });

        // Dashboard
        Route::group(['prefix' => 'dashboard', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('/', 'DashboardController@index');
        });

        //user roll management
        Route::group(['prefix' => 'roles', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-role-list','RolesController@getAllRoles');
            Route::post('get-single-role', 'RolesController@getSingleRole');
            Route::post('create-role', 'RolesController@createRoles');
            Route::post('update-role', 'RolesController@updateRoles');
            Route::post('delete-role', 'RolesController@deleteRoles');
            Route::post('restore-roles', 'RolesController@restoreRoles');
            Route::post('change-status', 'RolesController@changeStatus');
        });

        // Profile
        Route::group(['prefix' => 'profile', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('change-password', 'ProfileController@changePassword');
            Route::post('update-admin-profile', 'ProfileController@updateAdmin');
        });
        
        // User Management
        Route::group(['prefix' => 'users', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-single-user', 'UsersController@getSingleUser');
            Route::post('get-user-list', 'UsersController@getUserList');
            Route::post('change-status',    'UsersController@changeStatus');
            Route::post('delete-user', 'UsersController@deleteUser');
            Route::post('update-user', 'UsersController@updateUser');
            Route::post('update-user-role', 'UsersController@updateUserRole');
            Route::post('add-user', 'UsersController@createUser');
            Route::post('send-password', 'UsersController@sendPassword');
        });

        //category management
        Route::group(['prefix' => 'categories', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-category-list', 'CategoryController@getCategoryList');
            Route::post('get-single-category', 'CategoryController@getSingleCategory');
            Route::post('create-category', 'CategoryController@createCategory');
            Route::post('update-category', 'CategoryController@updateCategory');
            Route::post('delete-category', 'CategoryController@deleteCategory');
            Route::post('restore-category', 'CategoryController@restoreCategory');
            Route::post('status-change', 'CategoryController@statusChangeCategory'); //need to modify in controller
            Route::post('status-change-subcategory', 'CategoryController@statusChangeSubCategory');
            Route::post('get-all-sub-category', 'CategoryController@getSubCategoryList');
            Route::post('create-sub-category', 'CategoryController@createSubCategory');
            Route::post('update-sub-category', 'CategoryController@updateSubCategory');
            Route::post('get-single-sub-category', 'CategoryController@getSingleSubCategory');
            Route::post('get-request-category-list', 'CategoryController@getRequestCategory');
            Route::post('delete-request-category', 'CategoryController@deleteRequestCategory');
            Route::post('get-single-request-category', 'CategoryController@getSingleRequestCategory');
            Route::post('decline-request-category', 'CategoryController@declineRequestedCategory');
            Route::post('resolve-request-category', 'CategoryController@resolveRequestedCategory');
        });       

        //product management
        Route::group(['prefix' => 'products', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-product-list','ProductsController@getAllProduct');
            Route::post('change-status', 'ProductsController@changeStatus');
            Route::post('get-single-product','ProductsController@getSingleProduct');
        });

        //Notification
        Route::group(['prefix' => 'notification', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('send-notification', 'NotificationController@sendNotification');
            Route::post('delete-notification', 'NotificationController@deleteNotification');
            Route::post('get-notification', 'NotificationController@getNotification');
        });
        
    });



    //for shopper
Route::group([
    'prefix' => 'shopper/v1',
    'namespace' => 'Api\Shopper\v1',
    'middleware' => []], function () {

        // auth
        Route::group(['prefix' => 'auth', 'middleware' => []], function () {
            Route::post('register', 'AuthController@register', ['as' => 'login']);
            Route::post('login', 'AuthController@login', ['as' => 'login']);
            Route::post('logout', 'AuthController@logout');
            Route::post('forget-password', 'AuthController@forgotPassword');
            Route::post('reset-password', 'AuthController@resetPassword');
        });

         // User Profile
         Route::group(['prefix' => 'profile', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-profile', 'ProfileController@getProfile');
            Route::post('edit-profile', 'ProfileController@editUser');
            Route::post('change-password', 'ProfileController@changePassword');
            Route::post('get-onboarding-step', 'ProfileController@getOnBoarding');
            Route::post('get-store-list', 'ProfileController@getStoreList');   
            Route::post('picture-update', 'ProfileController@pictureUpdate');
        });

         // card
         Route::group(['prefix' => 'card', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('add-card', 'CardController@addNewCard');
            Route::post('get-card', 'CardController@getCard');
            Route::post('get-single-card', 'CardController@getSingleCard');
            Route::post('delete-card', 'CardController@deleteCard');
            Route::post('set-default-card', 'CardController@setDefaultCard');
        });

        // User Address
        Route::group(['prefix' => 'address', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('add-address', 'AddressController@createAddress');
            Route::post('edit-address', 'AddressController@editAddress');
            Route::post('get-address-list', 'AddressController@getAddressList');
            Route::post('delete-address', 'AddressController@deleteAddress');
            Route::post('set-default', 'AddressController@setDefaultAddress');
        });

        // User Follow
        Route::group(['prefix' => 'follow', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('follow-unfollow-seller', 'FollowController@followUnfollowSeller');
            Route::post('get-following-list', 'FollowController@getFollowingSellerList');
        });

         // Shopping Cart
         Route::group(['prefix' => 'cart', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('add-cart', 'CartController@addCartItem');
            Route::post('update-cart', 'CartController@updateCartItem');
            Route::post('get-cart', 'CartController@getCartItem');
            Route::post('delete-cart', 'CartController@deleteCart');
            Route::post('checkout-cart', 'CartController@checkoutCart');
            Route::post('example-charge', 'CartController@exampleCharge');
        });

         // Timeline
         Route::group(['prefix' => 'timeline', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('timeline-post', 'TimelineController@getTimelineData');
        });

         // Product review
         Route::group(['prefix' => 'review', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('add-review', 'ReviewController@reviewProduct');
            Route::post('delete-review', 'ReviewController@deleteReview');
            Route::post('product-review-list', 'ReviewController@getSingleReviewList');
        });

         // View product
         Route::group(['prefix' => 'product', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-product-list', 'ProductController@getProductList');
            Route::post('like-unlike-product', 'ProductController@likeUnlikeProduct');
        });

        //Seller
        Route::group(['prefix' => 'seller', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-single-seller', 'SellerController@getSingleSeller');
            Route::post('contact-us', 'SellerController@sellerContactUs');
            Route::post('product-by-category', 'SellerController@productByCategory');
            Route::post('get-parent-category', 'SellerController@getParentCategory');
        });

         //Notification
         Route::group(['prefix' => 'notification', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-notification', 'NotificationController@getNotification');
        });

        //Return
        Route::group(['prefix' => 'return', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('return-order', 'ReturnController@returnOrder');
        });

        // Orders
        Route::group(['prefix' => 'orders', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-orders', 'OrderController@getAllOrder');
            Route::post('get-all-return-order', 'OrderController@getReturnOrderList');
            Route::post('get-single-order', 'OrderController@getSingleOrder');
            Route::post('get-single-order-return', 'OrderController@getSingleOrderReturn');
        });

        // shipping handling
        Route::group(['prefix' => 'shipping-handling', 'middleware' => [IsApiLogin::class]], function() {
            Route::post('get-shipping', 'ShippingHandlingController@getShipping');
            Route::post('get-all', 'ShippingHandlingController@getShipping');
        });

    });