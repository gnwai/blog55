<?php

namespace App\Model\Purchase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
//use App\Contracts\Eloquent\Process\ModelProperty;

class OrderItem extends Model
{
//    use ModelProperty;

    protected $table = 'purchase_order_item';

    const TYPE = 0;

    public $timestamps = false;

    protected $guarded = [];

    protected $fillable = [

        'order_id'=> 'order_id',
        'product_id' => 'product_id',
        'sku' => 'sku',
        'vendor_sku' => 'vendor_sku',
        'qty_ctn' =>  'qty_ctn',
        'ctn' =>  'ctn',
        'ctn_volume' =>  'ctn_volume',
        'qty' =>  'qty',
        'moq' =>  'moq',
        'price' =>  'price',
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
        'note' =>  'note',  //其他说明
    ];


    protected $translate = [
        'is_disassembled',
        'is_ab_box',
    ];

    protected $casts = [
        'sdw' => 'array'
    ];

    function __construct(array $attributes = [])
    {
        $fillable = [];
        foreach ($this->fillable as $val) {
            $fillable[$val] = '';
        }

        $attributes = array_merge($fillable, $attributes);

        parent::__construct($attributes);
    }


    protected static function boot()
    {
        static::addGlobalScope('type', function (Builder $builder){
            $builder->where('product_id', '!=', 0);
        });
    }


    use \App\Contracts\Debug\Debug;


    /**
     * 是否允许QC
     * */
    public function isQcAble ():bool
    {
    	if ($this->qc_qty<=$this->qty ) {
    		return true;
	    }

	    return (bool)$this->setDebug('验收失败：当前验收总数为“'.$this->qc_qty.'”,超出采购总数“'.($this->qc_qty-$this->qty).'”。');
    }



    /**
     * 是否允许创建货代单
     * */
    public function isTransportAble ():bool
    {
	    if ($this->ctn>=$this->shipped_qty) {
	    	return true;
	    }
	    return (bool) $this->setDebug('发货失败：当前发货总数为“'.$this->shipped_qty.'”,超出采购总数“'.$this->qty.'”。');

    }


    ### scope 作用域查询

	/**
	 * 计算 return_qty 费用
	 * */
	public function scopeSelectReturnAmount ($query)
	{
		return $query->addSelect(\DB::raw('return_qty*price as return_amount'));
	}

    /**
     * 计算amount
     * */
    public function scopeSelectAmount ($query)
    {
        return $query->addSelect(\DB::raw('qty*price as amount'));
    }


	/**
	 * 统计 amount
	 * */
	public function scopeCountAmount ($query) {
		return $query->addSelect(\DB::raw('sum(qty*price) as totalAmount'));
	}


	/**
	 * 计算 未QC数量
	 * */
	public function scopeSelectToQcQty ($query)
	{
		return $query->addSelect(\DB::raw('qty-qc_qty-return_qty as to_qc_qty'));
	}


	/**
	 * 检索 外箱体积
	 * */
	public function scopeSelectCtnVolume ($query, $unit='cm')
	{

	    switch ($unit) {
            case 'cm':
                return $query->addSelect(\DB::raw('ctn_width*ctn_height*ctn_length as ctn_volume_'.$unit));
                break;
            case 'inch':
                return $query->addSelect(\DB::raw('ctn_width*ctn_height*ctn_length*10 as ctn_volume_'.$unit));
                break;
        }

	}


	/**
	 * 检索 重量
	 * */
	public function scopeSelectCtnWeight ($query, $unit='kg')
	{
        switch ($unit) {
            case 'kg':
                return $query->addSelect(\DB::raw('ctn_g_weight as ctn_weight_'.$unit));
                break;
            case 'lb':
                return $query->addSelect(\DB::raw('round(ctn_g_weight*2.2046226,2) as ctn_weight_'.$unit));
                break;
        }

	}


    /**
     * where QC 是否完成 列表
     * */
    public function scopeWhereToQc ($query, $done=true)
    {
        return $done ? $query->whereRaw('qty=qc_qty') : $query->whereRaw('qty!=qc_qty');
    }


    /**
     * 计算 未发货箱数
     * */
    public function scopeSelectToShipQty ($query)
    {
        return $query->addSelect(\DB::raw('ctn-shipped_qty as to_ship_qty'));
    }


	/**
	 * where 是否发货完毕 列表
	 * @param $transport boolean 默认true，检索可发货的明细，否则检索已发货完毕的明细。
	 * */
	public function scopeWhereToTransport ($query, $transport=true)
	{
		return $query->whereRaw($transport ? 'ctn!=shipped_qty' : 'ctn=shipped_qty');
	}





    public function product() {
        return $this->hasOne('App\Product','id', 'product_id') ;
    }








	const MARK_TYPE = 1;

	use \App\Model\Product\MarkTrait;




}
