<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\Redis;
//use App\Contracts\EventPusher;

class Tester extends Controller
{

    protected $pusher;
    public function __construct()
    {

//        $this->middleware('auth');
//        $this->pusher = $pusher;
    }



    //test
    public function wubuze(Request $req) {





        return 1;
        Redis::set('name', 'wubuze');


        return Redis::get('name');

        return 1;

    }



    #使用debug
    public function useDebug()
    {
        #保存debug
        self::debug('要保存的信息');

        #获取debug
        return self::debug();
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
