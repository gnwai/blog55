<?php
namespace App\Service\SyncCommand\Amazon\Finance;

use App\Model\Amz\Finance\Group;
use App\Service\SyncCommand\Sync;
use App\Service\MWS\SDK;
//use App\Services\ApiSync\Amazon\Finance\GroupCache;
use Carbon\Carbon;
use App\Service\MWS\Marketplace as ECSite;
use App\Model\SyncRecord as ApiRecord;

class Finance extends Sync{


    const SYNC_MODE = 'force'; // 强制同步模式 开启或关闭 开启后将忽略上一条record的状态和所有时间限制
    const SYNC_TYPE = 'amz:downloadFinanceGroup'; // record类型

    const TIME_ZONE = 'UTC'; // 时区
    const TIME_INIT = '2018-08-01 00:00:00'; // 初始时间
    const TIME_STEP = 6; // 时间步长 分钟
    const TIME_WARD = 5; // 安全时间



    private $api;
    protected $orderItem, $order;


    /** 强制模式: 需要重新start 方法, 重新设置开始时间和结束时间
     * @return bool
     */
    public function start():bool
    {

        if ( parent::start()) {
            $this->setStartTime( #开始时间是上个月的第一天
//                (Carbon::now(self::TIME_ZONE))->lastOfMonth()->addDays(-36)->startOfMonth()->toDateTimeString()
                Carbon::now(self::TIME_ZONE)->subMonth()->firstOfMonth()->toDateTimeString()
            );
            $this->setEndTime(Carbon::today()->toDateTimeString());  #结束时间是今天
            return true;
        }

        return false;

    }

    /**
     * 发起api请求 获取结果
     * */
    public function run ():bool
    {

        return 1;
        $this->api = new SDK($this->getEcid());
        $this->api = $this->api->finance();

        //取100条数据
        $res = $this->api->ListFinancialEventGroups(
            self::getStartTime(), self::getEndTime()
        );

        if ($res) {
            $this->order = $this->api->result;
        } else {
            $this->debug($this->api->result);
            return false;
        }


        return true;

    }




    /**
     * 存储数据 同步结束
     * */
    public function end():bool
    {

        return 1;
        if (!$this->order) {
            return true; // 没有订单
        }

        $ecId = ECSite::get($this->getEcid())['id'];
        $this->order = json_decode(json_encode($this->order), 1);

//        \Log::info($this->order); return true;
		$cache = new GroupCache();

        foreach ($this->order as $i=>&$order) {
            if (isset($order['ConvertedTotal'])) {
                $order['ConvertedCurrency'] =  $order['ConvertedTotal']['CurrencyCode'];
                $order['ConvertedTotal'] =  $order['ConvertedTotal']['CurrencyAmount'];
            } else {
                $order['ConvertedTotal'] =  0;
            }

            if (isset($order['OriginalTotal'])) {
                $order['OriginalCurrency'] =  $order['OriginalTotal']['CurrencyCode'];
                $order['OriginalTotal'] =  $order['OriginalTotal']['CurrencyAmount'];
            } else {
                $order['OriginalTotal'] = 0;
            }

            if (isset($order['BeginningBalance'])) {
                $order['BeginningBalanceCurrency'] =  $order['BeginningBalance']['CurrencyCode'];
                $order['BeginningBalance'] =  $order['BeginningBalance']['CurrencyAmount'];
            }

            $order['ec_id'] = $ecId;

	        $order = (new Group($order));
	        $order->ProcessingStatus = $order->getProperty('ProcessingStatus', $order->ProcessingStatus);

            # 更新账期
	        $qry = Group::where('FinancialEventGroupId', $order->FinancialEventGroupId)->first();

            if ($qry) {
                Group::where('FinancialEventGroupId', $order->FinancialEventGroupId)->update($order->toArray());
	            unset ($this->order[$i]);
            } else {

	            # 新增缓存
	            $cache->add($order->FinancialEventGroupId, $this->getEcid());

	            $order = $order->toArray();

            }

        }




		if ($this->order) {
			# 新增账期
			Group::insert($this->order);

			# 初始化明细轮询记录
			/*foreach ($this->order as &$order) {
				$order = [
					'type' => \App\Service\SyncCommand\Amazon\Finance\FinanceDetail::SYNC_TYPE,
					'ec_id' => $this->getEcid(),
					'data' => $order['FinancialEventGroupId'],
					'start_time' => null,
					'end_time' => $order['FinancialEventGroupStart'],
					'step' => ApiRecord::STEP_END
				];
			}*/
/*			ApiRecord::insert($this->order);*/
		}

        return true;

    }

}
