<?php

namespace App\Model\Finance\Bill;

use App\Model as DIR;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $table = 'finance_bill_item';

    public $timestamps = false;

    protected $fillable = [
        'bill_id'=> 'bill_id',
	    'order_id' => 'order_id', // 关联单据
	    'item_id' => 'item_id', // 关联明细 有可能为0 如预付款
	    'qty' => 'qty',
	    'amount' => 'amount',
	    'note' => 'note',
    ];

    ###### 作用域查询


    ###### relationship


    /**
     * 对账单关联
     * */
    public function bill ()
    {
        return $this->belongsTo(Core::class, 'bill_id', 'id');
    }


    /**
     * 采购订单
     * */
    public function puchaseOrder ()
    {
        return $this->hasOne(DIR\Purchase\Order::class, 'id', 'order_id');
    }


    /**
     * 采购明细
     * */
    public function purchaseItem ()
    {
        return $this->hasOne(DIR\Purchase\OrderItem::class, 'id', 'item_id');
    }



    ###### Model约束 创建数据

    /**
     * 【未完成 待定】生成对账单明细： 采购支付明细
     * @param $attribute array 参数属性
     * */
    public static function makePurchaseItem ($attribute=[])
    {

    }


}
