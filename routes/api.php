<?php

use Illuminate\Http\Request;

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


Route::get('index', 'Home@index');

Route::post('login', 'Passport@login');
Route::post('register', 'Passport@register');

// Route::group(['middleware' => 'auth:api'], function(){
Route::group(['middleware' => 'authPt:api'], function(){
    Route::get('/get-user', 'Passport@getUser');
    Route::group(['prefix' => 'other'], function(){
//        Route::get('get-details', 'Passport@getDetails');
//        Route::get('get-details', 'Passport@getDetails');
       Route::get('get-list', 'Passport@list');
       Route::get('get-last', 'Passport@last');
    });
});



//token 方式登入 api_token  Bearer token  在Header部分
Route::middleware('auth:tok')->get('/user-token', function (Request $request) {
    return $request->user();
});