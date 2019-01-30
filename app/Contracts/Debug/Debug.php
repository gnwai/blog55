<?php

namespace App\Contracts\Debug;

trait Debug {


	/**
	 * 是否已经debug记录过日志
	 * @return boolean true 已debug过 反之为false
	 * */
	public function isDebug ():bool {
		return Base::isLog();
	}

	/**
	 * 设置debug
	 * */
	public function setDebug ($dat) {
		return Base::log($dat);
	}


	public function clearDebug() {
		Base::clear();
	}


	/**
	 * 获取debug
	 *
	 * @return 存储的dubug数据
	 * */
	public function getDebug () {
		if (Base::isLog()) {
			return Base::log(null);
		}
	}



}