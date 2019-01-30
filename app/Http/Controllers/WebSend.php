<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Workerman\Worker;
use PHPSocketIO\SocketIO;
use Workerman\Lib\Timer;

# 浏览器推送 使用 SocketIO
class WebSend extends Controller
{

    public function __construct()
    {

    }

    /**
     * 聊天首页
     */
    public function index()
    {
        return view('webIm/index');

    }


    /**
     * 启动   php artisan webSend:http start
     */
    public function start()
    {

        if(strpos(strtolower(PHP_OS), 'win') === 0)
        {
            exit("start.php not support windows, please use start_for_win.bat\n");
        }
        // 标记是全局启动
        define('GLOBAL_START', 1);


        // 全局数组保存uid在线数据
        $uidConnectionMap = array();
        // 记录最后一次广播的在线用户数
        $last_online_count = 0;
        // 记录最后一次广播的在线页面数
        $last_online_page_count = 0;

        // PHPSocketIO服务
        $sender_io = new SocketIO(2120);

        // 客户端发起连接事件时，设置连接socket的各种事件回调
        $sender_io->on('connection', function($socket){
            // 当客户端发来登录事件时触发
            $socket->on('login', function ($uid)use($socket){
//                \Log::info('login:'.$uid);
                global $uidConnectionMap, $last_online_count, $last_online_page_count;
                // 已经登录过了
                if(isset($socket->uid)){
                    \Log::info($uid.'已经登入过了');
                    return;
                }
                // 更新对应uid的在线数据
                $uid = (string)$uid;
                if(!isset($uidConnectionMap[$uid]))
                {
                    $uidConnectionMap[$uid] = 0;
                }
                // 这个uid有++$uidConnectionMap[$uid]个socket连接
                ++$uidConnectionMap[$uid];
                // 将这个连接加入到uid分组，方便针对uid推送数据
                $socket->join($uid);
                $socket->uid = $uid;

                #wbz
                $last_online_count = count($uidConnectionMap);
                $last_online_page_count = array_sum($uidConnectionMap);

                // 更新这个socket对应页面的在线数据
                $socket->emit('update_online_count', "当前<b>{$last_online_count}</b>人在线，共打开<b>{$last_online_page_count}</b>个页面");
            });


            $socket->on('msg', function ($msg)use($socket){
                \Log::info('信息:'.$msg);
                \Log::info('uid:'.$socket->uid);

                #发送给当前用户
                $socket->emit('new_msg', $socket->uid.':'.$msg);
                #发给其他所有客户端
//                $socket->broadcast->emit('new_msg', $socket->uid.':'.$msg);
            });

            // 当客户端断开连接是触发（一般是关闭网页或者跳转刷新导致）
            $socket->on('disconnect', function () use($socket) {
                if(!isset($socket->uid))
                {
                    return;
                }
                global $uidConnectionMap, $sender_io;
                // 将uid的在线socket数减一
                if(--$uidConnectionMap[$socket->uid] <= 0)
                {
                    unset($uidConnectionMap[$socket->uid]);
                }
            });



        });



        /*$sender_io->on('workerStart', function(){

            // 一个定时器，定时向所有uid推送当前uid在线数及在线页面数
            Timer::add(1, function(){
                global $uidConnectionMap, $sender_io, $last_online_count, $last_online_page_count;
                $online_count_now = count($uidConnectionMap);


                $online_page_count_now = array_sum($uidConnectionMap);
                // 只有在客户端在线数变化了才广播，减少不必要的客户端通讯
                if($last_online_count != $online_count_now || $last_online_page_count != $online_page_count_now)
                {
                    $sender_io->emit('update_online_count', "当前<b>{$online_count_now}</b>人在线，共打开<b>{$online_page_count_now}</b>个页面");
                    $last_online_count = $online_count_now;
                    $last_online_page_count = $online_page_count_now;
                }
            });


        });*/




        // 运行所有服务
        Worker::runAll();





    }



    public function aaa()
    {

    }




}
