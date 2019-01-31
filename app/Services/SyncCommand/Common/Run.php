<?php
namespace App\Service\SyncCommand\Common;

use App\Model\SyncRecord as Model;

trait Run {

	/**
	 * 设置流程
	 * */
	private function done ($step)
	{
		switch (strtolower($step)) {
			case 'start' :
				$this->record = new Model($this->record->toArray());
				$this->record->stepStart();
				break;
			case 'run' :
				$this->record->stepRun();
				break;
			case 'end' :
				$this->record->stepEnd();
				break;
			default :
				return;
		}

		$this->record->save();
	}


}