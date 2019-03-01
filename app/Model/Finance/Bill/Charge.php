<?php

namespace App\Model\Finance\Bill;

use Illuminate\Database\Eloquent\Builder;

abstract class Charge extends Core
{

    protected static function boot ()
    {
        parent::boot();

        if (!defined('static::TYPE')) {
            static::addGlobalScope('type', function (Builder $builder){
                $builder->where('type', '>', 0);
            });
        }

    }





}
