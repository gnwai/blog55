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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/', 'Home@index');

Route::post('/register', 'Access@register');
Route::post('/login', 'Access@login');

Route::group(['middleware' => 'jwt:admin'], function(){

    Route::get('/get-user', 'Access@index');
    Route::group(['prefix' => 'xxxx'], function(){
//        Route::get('get-details', 'Passport@getDetails');
    });
});

