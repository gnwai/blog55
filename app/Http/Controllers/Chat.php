<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


# 聊天室 使用 GatewayWorker
class Chat extends Controller
{

    /**
     * 聊天首页 服务端不在此项目中
     * @ https://www.workerman.net/workerman-chat
     */
    public function index()
    {
        return view('webIm/chat');

    }




}
