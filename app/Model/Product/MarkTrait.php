<?php

namespace App\Model\Product;


trait MarkTrait
{

    public function mark()
    {
        $tb = Mark::PRODUCT_LINK_TABLE;

        return $this->belongsToMany(Mark::class, $tb,  'id', 'mark_id')
            ->withPivot('type')
            ->wherePivot('type', self::MARK_TYPE);
    }


    /**
     * 更新中间表  product_mark_link
     */
    public  function markLink(array $markId=[])
    {
        $markId = array_flip($markId);
        foreach ($markId as $id=>&$val) {
            $val = [
                'type' => self::MARK_TYPE
            ];
        }
        $this->mark()->sync($markId);
    }







}
