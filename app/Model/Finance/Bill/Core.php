<?php

namespace App\Model\Finance\Bill;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Core extends Model
{

    protected $table = 'finance_bill';

//    public $timestamps = false;
    const UPDATED_AT = null;


    protected $guarded = [

    ];


    protected $fillable = [
        'bank' => 'bank', // 支付银行
        'invoice_no' => 'invoice_no', // 发票号 默认null
        'bill_no' => 'bill_no', // 支付流水号
        'object_id' => 'object_id', // 付款对象
//	    'type' => 'type', // 类型
        'status' => 'status', // 状态
        'amount' => 'amount', // 总金额
        'note' => 'note', // 备注 默认null
        'created_at' => 'created_at',
        'payed_at' => 'payed_at',
    ];


    protected static function boot()
    {
        if (defined('static::TYPE')) {
            static::addGlobalScope('type', function (Builder $builder) {
                $builder->where('type', static::TYPE);
            });
        }
    }

    use \Peak\Plugin\PropertyTranslater;


    protected static $translation = [
        'type' => [
            -1 => '采购付款',
        ],
        'status' => [
            0 => '未支付',
            1 => '未销账',
            2 => '已销账',
        ],
    ];



    /**
     * type检索
     * @param $type mixed array多个type或int，单个type
     * */
    public function scopeWhereType($query, $type)
    {
        return is_array($type) ? $query->whereIn('type', $type) : $query->where('type', $type);
    }


    ###### relationship

    /**
     * 关联明细
     * */
    public function items()
    {
        return $this->hasMany(Item::class, 'bill_id', 'id');
    }



    /**
     * 关联供应商
     * */
    public function objectVendor ()
    {

    }

}