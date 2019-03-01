<?php

namespace App\Model\Purchase;

use Illuminate\Database\Eloquent\Builder;

class Fee extends OrderItem
{

    protected $fillable = [
        'order_id'=> 'order_id',
        'price' => 'price', // 价格
        'note' =>  'note', // 名称款项
    ];

    protected $hidden = [
//        'order_id'=> 'order_id',
        'product_id' => 'product_id',
        'sku' => 'sku',
        'vendor_sku' => 'vendor_sku',
        'qty_ctn' =>  'qty_ctn',
        'ctn' =>  'ctn',
        'ctn_volume' =>  'ctn_volume',
        'qty' =>  'qty',
        'moq' =>  'moq',
//        'price' =>  'price',
        'remark' =>  'remark',
        'sdw' =>  'sdw',
        'type' =>  'type',
        'qc_qty' =>  'qc_qty',
        'ctn_length' =>  'ctn_length',
        'ctn_width' =>  'ctn_width',
        'ctn_height' =>  'ctn_height',
        'ctn_g_weight' =>  'ctn_g_weight',
        'ctn_n_weight' =>  'ctn_n_weight',
        'shipped_qty' =>  'shipped_qty',
//        'note' =>  'note',  // 其他说明
        'return_qty' =>  'return_qty',
        'status' =>  'status',
    ];


    function __construct ($attribute=[])
    {
        parent::__construct($attribute);
        $this->product_id = 0;
        $this->qty = 1;
    }


    protected static function boot ()
    {
        static::addGlobalScope('type', function (Builder $builder){
            $builder->select('*')
                ->where('product_id', 0)
                ->selectAmount();
        });
    }


    public function scopeSelectAmount($query)
    {
        return $query->addSelect(\DB::raw('price as amount, note as name'));
    }


}
