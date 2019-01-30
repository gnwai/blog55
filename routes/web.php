<?php

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

Route::get('/', function () {
    return view('welcome');

});

#demo
Route::any('/upload/index', 'UploadFile@index');
Route::get('/webSend/index', 'WebSend@index');
Route::get('/chat/index', 'Chat@index');





Route::group(['prefix' => 'home'], function () {

    Route::any('/index', 'HomeController@index');
    Route::any('/room', 'HomeController@room');
    Route::any('/workerman', 'HomeController@workerman');


    #商品和标签 多对多的demo
    Route::any('/productMark', 'HomeController@productMark');


});


Route::group(['prefix' => 'product'], function () {


    Route::any('useDebugDemo', 'Product@useDebugDemo');


});




Auth::routes();


