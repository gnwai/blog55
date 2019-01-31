<?php
namespace App\Service\SyncCommand;

use Illuminate\Support\Facades\DB;

abstract class Sync {

	use Common\Boot;
	use Common\Start;
	use Common\Run;
	use Common\End;

	private $config = [
		'SYNC_TYPE' => '记录类型',
		'TIME_ZONE' => '时区',
		'TIME_INIT' => '初始时间',
		'TIME_STEP' => '步长间隔',
		'TIME_WARD' => '安全时间设置',
	];

	function __construct()
	{
		// 必填参数检测
		foreach ($this->config as $key=>&$val) {
			if ( !defined('static::'.$key)) {
                $this->debug('INIT ERROR: '.$val.'['.$key.']未设置');
				return;
			}
		}
	}

	public $debug;

	public function debug ($error=null)
	{
		if (isset($error) ) {
			$this->record && $this->setData($error);
			$this->debug = $error;
		} else {
			return $this->debug;
		}
	}

	/**
	 * 执行同步业务 最终调用方法
	 * */
	final public function handle ($ecNo, $data=null):bool
	{

		#1 检测初始化过程中是否异常
		if ( $this->debug()) {

			return false;
		}




		#2 初始化启动
		$this->boot($ecNo, $data);

		#3 开始
		if (!$this->start()) {
			return false;
		}
		$this->done('start');


		#4 组织参数 发起api请求
		if (!$this->run()) {
			return false;
		}
		$this->done('run');

		#5 存储数据
		DB::transaction(function (){
			if (!$this->end()) {
				throw new \Exception('Error happened in the "End" part.');
			}
			$this->done('end');
		});

		/*
		DB::beginTransaction();
		try {
			if (!$this->end()) {
				throw new \Exception('Error happened in the "End" part.');
			}
			$this->done('end');
			DB::commit();

		} catch (\Exception $e) {
			DB::rollBack();
			return false;
		}
		*/

		// 清除历史记录
//			self::clearHistory();

		return true;
	}


	abstract function run():bool;
	abstract function end():bool;

}
