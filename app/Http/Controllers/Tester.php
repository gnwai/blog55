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

    public function showLog( Request $req ) {

		// 这里使用 base_path()方法来定义路径 别用相对路径
		 $file = base_path('storage/logs/laravel.log') ;
		echo file_get_contents($file);

	}

    /** 删除log */
	public function clearLog (){
	
		$file = base_path('storage/logs/laravel.log') ;
		echo file_put_contents($file,'');
		echo 'ok';
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
