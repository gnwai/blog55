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

// 上传文件
Route::post('uploadFile', '\App\Http\Controllers\Common\Upload@uploadFile');

Route::group(['middleware' => 'jwt:admin'], function(){

    Route::get('/get-user', 'Access@index');

    Route::group(['prefix' => 'user'], function(){
        Route::post('edit', 'Home@editUser');
        Route::get('list', 'Home@userList');
    });


    //system setting
    Route::group(['prefix' => 'system'], function(){
        Route::get('list', 'System@category');
        Route::get('detail', 'System@group');
        Route::post('save', 'System@save');
    });


});



Auth::routes333();

Route::get('/home-tetetetetete', 'HomeController@index')->name('home');
