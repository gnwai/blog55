<?php

namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    public $table = 'product';

    public $timestamps = false;

    use \App\Contracts\PropertyTranslater;

    protected $fillable = [
        'name'=> 'name',
        'cover' => 'cover',
    ];


    use \App\Contracts\Debug\Debug;

    const MARK_TYPE = 0;



    use MarkTrait;


    protected static $translation = [
        'step' => [
            0 => '待审核',
            1 => '合格',
            -1 => '不合格',
        ],
        'status' => [
            0 => '异常报告',
            1 => '正常验收',
        ],
    ];


    /**
     * QC数量是否超出采购总数
     * */
    public function isQtyOverload ():bool
    {
//        $qty = $this->purchaseItem->qty-$this->purchaseItem->qc_qty;
        $qty = 10;  //如果该值小于表中的qty则报错
        return $qty>=$this->qty ?: (bool)$this->setDebug('验收数量为'.$this->qty.'，超出可验收数量'.$qty.'。');
    }


    public function isStepCheckAble ()
    {
        if ($this->step) { #表中的step == 0 可以审核, 其他状态不能审核
            self::setDebug('该QC报告为“'.$this->translateProperty('step').'”，不可审核。');
        }
        return !(bool)$this->step;
    }


}
