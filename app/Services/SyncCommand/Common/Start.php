<?php
namespace App\Service\SyncCommand\Common;

use Carbon\Carbon;
use App\Model\SyncRecord as Model;

trait Start {


	/*
    |--------------------------------------------------------------------------
    | 部件I： 记录初始化
    |--------------------------------------------------------------------------
	|
    */

	/**
	 * @param
	 * @return true if success, null if cannot continue, false if last record is error.
	 * */
	public function start ():bool
	{

		switch ( @static::SYNC_MODE) {
			case 'force': // 强制模式
				return true;

			case 'fix': // 修复模式
				if (!$this->record->isContinuable()) {
					$this->record->delete();
					$this->boot($this->record->ec_id, $this->record->data);
					return true;
				}

			default: // 接续模式
				if (!$this->record->isContinuable() ) {
					return (boolean)$this->debug([
						'code' => -2,
						'msg' => '接续失败，上一条Record未完成。',
						'dat' => $this->record->toArray(),
					]);
				}
				if (!$this->is_under_time_limit()) {
					return (boolean)$this->debug([
						'code' => -3,
						'msg' => '新Record超出限制时间。',
						'dat' => $this->record->toArray(),
					]);
				}
				return true;
		}



	}




	/**
	 * step4 判断轮询在时间上是否允许接续
	 * */
	private function is_under_time_limit () {
		return $this->getEndTime(true)<=time()-static::TIME_WARD*60;
	}


}