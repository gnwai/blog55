<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class Tester extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth');
    }


    public function wubuze()
    {
        return 'test-wubuze';
    }




    public function mail()
    {

        $order_id = ['asdf','asdgasd','121235123'];
        Mail::send(
            'mail_demo',  //邮件模板
            ['order_id'=>$order_id],
            function($message) use(&$sku){
                $message
                    ->to('1039289613@qq.com')
//                    ->cc('jackie@soffeedesign.com')
                    ->subject('sd-amazon 邮件配置测试');
        });

        return 'ok';
    }


}
