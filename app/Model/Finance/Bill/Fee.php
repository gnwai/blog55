<?php

namespace App\Model\Finance\Bill;

use Illuminate\Database\Eloquent\Builder;

class Fee extends Core
{

    protected static function boot ()
    {
        parent::boot();

        if (!defined('static::TYPE')) {
            static::addGlobalScope('type', function (Builder $builder){
                $builder->where('type', '<', 0);
            });
        }

    }


    /**
     * 查询采购付款对账单
     * */
    public function scopeWherePurchase ($query)
    {
        return $this->scopeWhereType($query, -1);
    }

    use \Peak\Plugin\PropertyTranslater;
    use \App\Model\Common;


    protected static $translation = [
        'type' => [
            -1 => '首款',
            -2 => '尾款',
        ]
    ];




    public function vendor()
    {
        return $this->belongsTo(\App\Model\Purchase\Vendor::class, 'object_id', 'id');
    }


}
