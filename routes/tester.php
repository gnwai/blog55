<?php

#测试

Route::get('/wubuze', 'Tester@wubuze');
Route::post('/wubuze', 'Tester@wubuze');
Route::get('/showLog', 'Tester@showLog');
Route::get('/clearLog', 'Tester@clearLog');

Route::get('/mail', 'Tester@mail');

