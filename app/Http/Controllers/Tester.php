<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\Redis;
use UploadFile\File\Uploader;

class Tester extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth');
    }



    //test
    public function wubuze(Request $req) {


        $module = config('storage.'.$req->input('module')); if (!$module) { return 'error'; }


        Uploader::init($req->file('file'));

        $file = Uploader::upload($module['dir'], $req->input('fileName'), $module['public']);
        $file->setUrl();


        return 1;
        Redis::set('name', 'wubuze');


        return Redis::get('name');

        return 1;

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






}
