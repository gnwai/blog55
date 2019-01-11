<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class Tester extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth');
    }



    //test
    public function wubuze() {


        $accessKey ="";
        $secretKey = "";
        $bucket = "";

        $auth = new Auth($accessKey, $secretKey);
        $token = $auth->uploadToken($bucket);

        $name = mt_rand(1,9999);
//        return view('Tester.wubuze', ['token' => $token, 'name' => $name]);

        // 要上传文件的本地路径
        $filePath = public_path('/storage/user-photo/20180717-0813-982.jpeg');
        // 上传到七牛后保存的文件名
        $key = '20180717-0813-982.jpeg';
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。

        $arr  = $uploadMgr->putFile($token, $key, $filePath);

        \Log::info($arr);

        return list($ret, $err) = $arr;







        #swoole  使用  https://laravel-china.org/topics/10939/use-swoole-to-speed-up-your-laravel-application
        #
        $path = storage_path('app/public/file.json');  //json 文件

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
