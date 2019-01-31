<?php
namespace App\Service\SyncCommand\Common;

trait End {

	/*
    |--------------------------------------------------------------------------
    | 部件III： 保存数据、更新记录、流程结束
    |--------------------------------------------------------------------------
	|
    */






	/**
	 * 删除record
	 * */
/*	protected static function deleteRecord()
	{
		// 清除当前record
		@self::$record->id && self::$record->delete();
	}
*/


	/**
	 * 清除record记录
	 * */
/*	protected static function clearHistory()
	{
		if (defined('static::SYNC_CLEAN') && static::SYNC_CLEAN) {
			if (self::$record->id) {
				$where = [
					'type' => self::$record->type,
					'ec_id' => self::$record->ec_id,
					'status' => SyncRecord::STATUS_END,
				];
				self::$record->data && $where['data'] = self::$record->data;
				return SyncRecord::where($where)->where('id', '<', self::$record->id)->delete();
			}
		}
	}
*/


}