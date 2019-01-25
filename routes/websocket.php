<?php

use Illuminate\Http\Request;
use SwooleTW\Http\Websocket\Facades\Websocket;

/*
|--------------------------------------------------------------------------
| Websocket Routes
|--------------------------------------------------------------------------
|
| Here is where you can register websocket events for your application.
|
*/

Websocket::on('connect', function ($websocket, Request $request) {

    \Log::info('websocket 连接成功333');
    // called while socket on connect
});

Websocket::on('disconnect', function ($websocket) {
    \Log::info('websocket 连接关闭');
    // called while socket on disconnect
});


Websocket::on('message', function ($websocket, Request $request, $data) {
    \Log::info('接收到数据'.json_encode($request->all()));
    // called while socket on disconnect
});

Websocket::on('example', function ($websocket, $data) {
    \Log::info('aaaa');
    $websocket->emit('new_msg', $data);
});

// Websocket::on('test', 'ExampleController@method');