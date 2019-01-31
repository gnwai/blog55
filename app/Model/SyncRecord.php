<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SyncRecord extends Model
{

    protected $table = 'sync_record';
	public $timestamps = false;
	protected $guarded = [
		'id'
	];

    public function setDataAttribute($val) {
    	$this->attributes['data'] = is_array($val)||is_object($val) ? json_encode($val) : $val;
    }

    public function getDataAttribute ($val)
    {
	    return json_decode($val) ?: $val;
    }


	### 状态修改

	const STEP_START = 1;
	const STEP_RUN = 2;
	const STEP_END = 3;

	public function stepStart ()
	{
		$this->step = self::STEP_START;
		return $this;
	}

	public function stepRun ()
	{
		$this->step = self::STEP_RUN;
		return $this;
	}

	public function stepEnd ()
	{
		$this->step = self::STEP_END;
		return $this;
	}


	// 是否可持续
	public function isContinuable ()
	{
		return $this->id ? $this->step==self::STEP_END : true;
	}


	/**
	 * 查询条件作用域
	 * */

	public function scopeEc ($query, $ecNo)
	{
		return $query->where('ec_id', $ecNo);
	}

	public function scopeType ($query, $type)
	{
		return $query->where('type', $type);
	}

	public function scopeData ($query, $data=null)
	{
		return $data ? $query->where('data', $data) : $query;
	}



}
