<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*
 ****************************************************
 *************** Start Admin Routes  **************
 ****************************************************
*/

Route::group(['namespace' => 'Admin', 'middleware' => 'assign.guard:admin'], function () {
    Route::get('/', [
        'uses' => 'AuthController@getLogin',
        'as' => 'login'
    ]);
    Route::get('login/change/locale', [
        'uses' => 'AuthController@getChangeLocale',
        'as' => 'admin.login.change.locale'
    ]);
});

Route::group(['namespace' => 'Admin', 'prefix' => env('URL_PREFIX'), 'middleware' => 'assign.guard:admin'], function () {
    
    /* Start Unsecured Routes */
        Route::get('/', [
            'uses' => 'AuthController@getLogin',
            'as' => 'login'
        ]);
        Route::get('/login', [
            'uses' => 'AuthController@getLogin',
            'as' => 'admin.login'
        ]);
        Route::post('/login', [
            'uses' => 'AuthController@postLogin',
            'as' => 'admin.login'
        ]);
        Route::get('/forgot/password', [
            'uses' => 'AuthController@getForgotPassword',
            'as' => 'admin.forgot.password'
        ]);
        Route::post('/forgot/password', [
            'uses' => 'AuthController@postForgotPassword',
            'as' => 'admin.forgot.password'
        ]);
        Route::get('/password/reset/request/{token}', [
            'uses' => 'AuthController@getResetPassword',
            'as' => 'admin.password.reset.request'
        ]);
        Route::post('/password/reset', [
            'uses' => 'AuthController@postResetPassword',
            'as' => 'admin.password.reset'
        ]);
    /* End Unsecured Routes */

    // Secured Routes
    Route::group(['middleware' => ['auth:admin', 'optimizeImages']], function () {
        /* Start Cropper Routes */
            Route::get('/cropper/init/{width}/{height}/{name}/{enable_ratio}', [
                'uses' => 'CropperController@getIndex',
                'as' => 'admin.image.cropper'
            ]);
        /* End Cropper Routes */

        /* Start Dashboard Routes */
            Route::get('/dashboard', [
                'uses' => 'DashboardController@getIndex',
                'as' => 'admin.dashboard'
            ]);
            Route::get('/dashboard/stats', [
                'uses' => 'DashboardController@getStats',
                'as' => 'admin.dashboard.stats'
            ]);
            Route::get('/dashboard/users/graph', [
                'uses' => 'DashboardController@getUsersGraph',
                'as' => 'admin.dashboard.users.graph'
            ]);
            Route::get('/change/locale', [
                'uses' => 'DashboardController@getChangeLocale',
                'as' => 'admin.change.locale'
            ]);
        /* End Dashboard Routes */
        
        
        /* Start Profile Routes */
            Route::get('/profile', [
                'uses' => 'ProfileController@getDetails',
                'as' => 'admin.profile.details'
            ]);
            Route::post('/profile', [
                'uses' => 'ProfileController@postUpdate',
                'as' => 'admin.profile.update'
            ]);
            Route::post('/profile/change_password', [
                'uses' => 'ProfileController@postChangePassword',
                'as' => 'admin.profile.change_password'
            ]);
            Route::get('/logout', [
                'uses' => 'ProfileController@getLogout',
                'as' => 'admin.logout'
            ]);
        /* End Profile Routes */

        
        /* Start Sub Admin Routes */
            Route::get('sub_admins', [
                'uses' => 'SubAdminController@getIndex',
                'as' => 'admin.sub_admins.index'
            ]);

            Route::get('sub_admins/create', [
                'uses' => 'SubAdminController@getCreate',
                'as' => 'admin.sub_admins.create'
            ]);

            Route::post('sub_admins/create', [
                'uses' => 'SubAdminController@postCreate',
                'as' => 'admin.sub_admins.create'
            ]);

            Route::get('sub_admins/list', [
                'uses' => 'SubAdminController@getList',
                'as' => 'admin.sub_admins.list'
            ]);

            Route::get('sub_admins/update/{id?}', [
                'uses' => 'SubAdminController@getUpdate',
                'as' => 'admin.sub_admins.update'
            ]);

            Route::post('sub_admins/update/{id?}', [
                'uses' => 'SubAdminController@postUpdate',
                'as' => 'admin.sub_admins.update'
            ]);

            Route::get('sub_admins/delete/{id?}', [
                'uses' => 'SubAdminController@getDelete',
                'as' => 'admin.sub_admins.delete'
            ]);

            Route::get('sub_admins/view/{id?}', [
                'uses' => 'SubAdminController@getView',
                'as' => 'admin.sub_admins.view'
            ]);

            Route::post('sub_admins/reset-password/{id?}', [
                'uses' => 'SubAdminController@postPasswordReset',
                'as' => 'admin.sub_admins.password_reset'
            ]);

            Route::get('sub_admins/reset-password/{id?}', [
                'uses' => 'SubAdminController@getPasswordReset',
                'as' => 'admin.sub_admins.password_reset'
            ]);
        /* End Sub Admin Routes */
    
    
        /* Start Navigation Routes */
            Route::get('navigation', [
                'uses' => 'NavigationController@getIndex',
                'as' => 'admin.navigation.index'
            ]);
    
            Route::get('navigation/create', [
                'uses' => 'NavigationController@getCreate',
                'as' => 'admin.navigation.create'
            ]);
    
            Route::post('navigation/create', [
                'uses' => 'NavigationController@postCreate',
                'as' => 'admin.navigation.create'
            ]);
    
            Route::get('navigation/list', [
                'uses' => 'NavigationController@getList',
                'as' => 'admin.navigation.list'
            ]);
    
            Route::get('navigation/update/{id?}', [
                'uses' => 'NavigationController@getUpdate',
                'as' => 'admin.navigation.update'
            ]);
    
            Route::post('navigation/update/{id?}', [
                'uses' => 'NavigationController@postUpdate',
                'as' => 'admin.navigation.update'
            ]);
        /* End Navigation Routes */
    
    
        /* Start Role Routes */
            Route::get('role', [
                'uses' => 'RoleController@getIndex',
                'as' => 'admin.role.index'
            ]);
    
            Route::get('role/create', [
                'uses' => 'RoleController@getCreate',
                'as' => 'admin.role.create'
            ]);
    
            Route::post('role/create', [
                'uses' => 'RoleController@postCreate',
                'as' => 'admin.role.create'
            ]);
    
            Route::get('role/list', [
                'uses' => 'RoleController@getList',
                'as' => 'admin.role.list'
            ]);
    
            Route::get('role/update/{id?}', [
                'uses' => 'RoleController@getUpdate',
                'as' => 'admin.role.update'
            ]);
    
            Route::post('role/update/{id?}', [
                'uses' => 'RoleController@postUpdate',
                'as' => 'admin.role.update'
            ]);
    
            Route::get('role/permission/{id?}', [
                'uses' => 'RoleController@getPermission',
                'as' => 'admin.role.permission'
            ]);
    
            Route::post('role/permission/{id?}', [
                'uses' => 'RoleController@savePermission',
                'as' => 'admin.role.permission.save'
            ]);
        /* End Role Routes */
        
        
        /* Start User Routes */
            Route::get('users', [
                'uses' => 'UserController@getIndex',
                'as' => 'admin.users.index'
            ]);
    
            Route::get('users/list', [
                'uses' => 'UserController@getList',
                'as' => 'admin.users.list'
            ]);
    
            Route::get('users/create', [
                'uses' => 'UserController@getCreate',
                'as' => 'admin.users.create'
            ]);
    
            Route::post('users/create', [
                'uses' => 'UserController@postCreate',
                'as' => 'admin.users.create'
            ]);
    
            Route::get('users/update/{id?}', [
                'uses' => 'UserController@getUpdate',
                'as' => 'admin.users.update'
            ]);
    
            Route::post('users/update/{id?}', [
                'uses' => 'UserController@postUpdate',
                'as' => 'admin.users.update'
            ]);
    
            Route::get('users/delete/{id?}', [
                'uses' => 'UserController@getDelete',
                'as' => 'admin.users.delete'
            ]);
    
            Route::get('users/view/{id?}', [
                'uses' => 'UserController@getView',
                'as' => 'admin.users.view'
            ]);
    
            Route::post('users/reset-password/{id?}', [
                'uses' => 'UserController@postPasswordReset',
                'as' => 'admin.users.password_reset'
            ]);
    
            Route::get('users/reset-password/{id?}', [
                'uses' => 'UserController@getPasswordReset',
                'as' => 'admin.users.password_reset'
            ]);
        /* End User Routes */
    
        /* Start App Settings Routes */
            Route::get('settings', [
                'uses' => 'SettingController@getIndex',
                'as' => 'admin.settings.index'
            ]);
            Route::post('settings', [
                'uses' => 'SettingController@postUpdate',
                'as' => 'admin.settings.update'
            ]);
        /* End App Settings Routes */
    
    
        /* Start FAQ Routes */
            Route::get('faq', [
                'uses' => 'FaqController@getIndex',
                'as' => 'admin.faq.index'
            ]);
    
            Route::get('faq/list', [
                'uses' => 'FaqController@getList',
                'as' => 'admin.faq.list'
            ]);
    
            Route::get('faq/create', [
                'uses' => 'FaqController@getCreate',
                'as' => 'admin.faq.create'
            ]);
    
            Route::post('faq/create', [
                'uses' => 'FaqController@postCreate',
                'as' => 'admin.faq.create'
            ]);
    
            Route::get('faq/update/{id?}', [
                'uses' => 'FaqController@getUpdate',
                'as' => 'admin.faq.update'
            ]);
    
            Route::post('faq/update/{id?}', [
                'uses' => 'FaqController@postUpdate',
                'as' => 'admin.faq.update'
            ]);
    
            Route::get('faq/delete/{id?}', [
                'uses' => 'FaqController@getDelete',
                'as' => 'admin.faq.delete'
            ]);
        /* End FAQ Routes */
    
    
        /* Start Countries Routes */
            Route::get('countries', [
                'uses' => 'CountryController@getIndex',
                'as' => 'admin.countries.index'
            ]);
    
            Route::get('countries/list', [
                'uses' => 'CountryController@getList',
                'as' => 'admin.countries.list'
            ]);
    
            Route::get('countries/create', [
                'uses' => 'CountryController@getCreate',
                'as' => 'admin.countries.create'
            ]);
    
            Route::post('countries/create', [
                'uses' => 'CountryController@postCreate',
                'as' => 'admin.countries.create'
            ]);
    
            Route::get('countries/update/{id?}', [
                'uses' => 'CountryController@getUpdate',
                'as' => 'admin.countries.update'
            ]);
    
            Route::post('countries/update/{id?}', [
                'uses' => 'CountryController@postUpdate',
                'as' => 'admin.countries.update'
            ]);
    
            Route::get('countries/delete/{id?}', [
                'uses' => 'CountryController@getDelete',
                'as' => 'admin.countries.delete'
            ]);
        /* End Countries Routes */
    
    
        /* Start Coupon Routes */
            Route::get('coupons', [
                'uses' => 'CouponController@getIndex',
                'as' => 'admin.coupons.index'
            ]);
    
            Route::get('coupons/list', [
                'uses' => 'CouponController@getList',
                'as' => 'admin.coupons.list'
            ]);
    
            Route::get('coupons/create', [
                'uses' => 'CouponController@getCreate',
                'as' => 'admin.coupons.create'
            ]);
    
            Route::post('coupons/create', [
                'uses' => 'CouponController@postCreate',
                'as' => 'admin.coupons.create'
            ]);
    
            Route::get('coupons/update/{id?}', [
                'uses' => 'CouponController@getUpdate',
                'as' => 'admin.coupons.update'
            ]);
    
            Route::post('coupons/update/{id?}', [
                'uses' => 'CouponController@postUpdate',
                'as' => 'admin.coupons.update'
            ]);
    
            Route::get('coupons/delete/{id?}', [
                'uses' => 'CouponController@getDelete',
                'as' => 'admin.coupons.delete'
            ]);
        /* End Coupon Routes */
    });
});