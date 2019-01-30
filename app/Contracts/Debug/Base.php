<?php

namespace App\Contracts\Debug;

class Base {

	// debug记录
	private static $log ;

	// debug状态
	private static $status=false;

	/**
	 * debug记录 仅在开启debug模式时才有效
	 * @param $dat 需要记录的debug数据
	 * @return mixed debug记录的log数据 仅在传入参数为空时返回
	 * */
	static function log ($dat) {
		if ( $dat ) {
			self::$status = true;
			self::$log =& $dat;
		} else {
			return self::$log;
		}
	}


	/**
	 * 是否已经debug记录过日志
	 * */
	static function isLog ():bool {
		return self::$status;
	}


	static function clear ()
	{
		self::$status = false;
	}


}