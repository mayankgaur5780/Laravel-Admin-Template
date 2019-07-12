<?php

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
Route::group(['prefix' => 'v1', 'namespace' => 'API\v1', 'middleware' => 'detect.api.locale'], function () {
    /* Start Locations Routes */
        Route::get('/countries/list', 'CountryController@index');
    /* End Locations Routes */

    /* Start Auth Logic */
        Route::post('/login', 'UserOauthController@signIn');
        Route::post('/otp/verify', 'UserOauthController@verifyOtp');
        Route::post('/otp/resend', 'UserOauthController@resendOTP');
    /* End Auth Logic */


    /* Start CMS Routes */
        Route::get('/cms/about_us', 'CmsController@getAboutUs');
        Route::get('/cms/terms_condition', 'CmsController@getTermsCondition');
        Route::get('/cms/privacy_policy', 'CmsController@getPrivacyPolicy');
        Route::get('/cms/faq', 'CmsController@getFaq');
    /* End CMS Routes */
});

Route::group(['prefix' => 'v1', 'namespace' => 'API\v1', 'middleware' => ['detect.api.locale']], function () {

    Route::get('/token/refresh', 'UserOauthController@refreshJwtToken');
    Route::post('/logout', 'UserOauthController@signOut');


    /* Start User Profile Routes */
        Route::post('/user/profile/update', 'UserController@updateProfile');
        Route::post('/user/profile_image/update', 'UserController@updateProfileImage');
    /* End User Profile Routes */


    /* Start Notifications Routes */
        Route::get('/notifications', 'NotificationController@index');
        Route::get('/notifications/delete/all', 'NotificationController@deleteAll');
        Route::post('/notifications/delete', 'NotificationController@delete');
    /* End Notifications Routes */


    /* Start Coupon Routes */
        Route::post('/coupon/apply', 'CouponController@index');
    /* End Coupon Routes */
});