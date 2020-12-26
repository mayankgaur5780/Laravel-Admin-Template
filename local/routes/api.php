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

Route::group(['prefix' => 'v1/user', 'namespace' => 'API\v1\User','middleware' => 'assign.guard:api_user'], function () {});
Route::group(['prefix' => 'v1/vendor', 'namespace' => 'API\v1\Vendor','middleware' => 'assign.guard:api_vendor'], function () {});