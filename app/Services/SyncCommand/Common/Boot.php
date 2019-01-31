<?php
namespace App\Service\SyncCommand\Common;

use Carbon\Carbon;
use App\Model\SyncRecord as Model;

trait Boot {

	private $record;

	private function record($mod, $func, $data)
	{
		$record = Model::ec($mod)->type($func)->data($data)->orderBy('id', 'desc')->first();
		if (!$record) {
			$record = new Model([
				'ec_id' => $mod,
				'type' => $func,
				'data' => $data,
			]);
		}
		return $record;
	}


	/**
	 * 启动初始化
	 * */
	private function boot ($mod, $data)
	{
		// 初始化记录
		$this->record = self::record($mod, static::SYNC_TYPE, $data);
		// 设置开始时间
		$this->record->start_time = @$this->record->end_time ?: static::TIME_INIT;
		// 设置结束时间
		$this->setEndTime(0, true);
	}



	/**
	 * step2 设置record的初始时间
	 * */
	protected function setStartTime ($time=null)
	{
		$this->record->start_time = $time ?: (Carbon::now(static::TIME_ZONE))->toDateTimeString();
	}


	/**
	 * step3 设置record的结束时间
	 * @param $time string|int 具体时间或步长
	 * @param $isStep boolean 是否是步长模式
	 * */
	protected function setEndTime ($time=null, $isStep=false)
	{
		if ($isStep) {
			if (!$this->record->start_time) return $this->debug('未设置初始时间，无法通过步长计算结束时间。');
			$this->record->end_time = (Carbon::createFromFormat('Y-m-d H:i:s', $this->record->start_time))->addMinutes($time ?: static::TIME_STEP)->toDateTimeString();
		} else {
			$this->record->end_time = $time ?: (Carbon::now(static::TIME_ZONE))->toDateTimeString();
		}
		return true;
	}



	/**
	 * step3.2 获取起始时间
	 * @param $toTimestamp boolean 是否是timestamp格式。
	 * */
	protected function getStartTime ($toTimestamp=false)
	{
		return $toTimestamp ? Carbon::createFromFormat('Y-m-d H:i:s', $this->record->start_time, static::TIME_ZONE)->getTimestamp() : $this->record->start_time;
	}


	/**
	 * step3.3 获取结束时间时间
	 * */
	protected function getEndTime ($toTimestamp=false)
	{
		return $toTimestamp ? Carbon::createFromFormat('Y-m-d H:i:s', $this->record->end_time, static::TIME_ZONE)->getTimestamp() : $this->record->end_time;
	}



	/**
	 * step3.4 获取ec_id
	 * */
	protected function getEcid ()
	{
		return $this->record->ec_id;
	}



	/**
	 * step3.5 设置data数据
	 * @param $dat.
	 * */
	protected function setData ($dat)
	{
		$this->record->data = is_array($dat) ? json_encode($dat) : $dat;
	}


	protected function getData ()
	{
		return $this->record->data;
	}


	protected function getId ()
	{
		return $this->record->id;
	}


}