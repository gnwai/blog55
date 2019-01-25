<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Mail;

//测试文件不要删除
class Demo extends Controller {


    public function test()
    {
        //引入文件
        $path = storage_path('app/public/file.json');  //json 文件



    }



    //邮件测试
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