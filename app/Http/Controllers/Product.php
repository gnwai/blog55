<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Product\Product as ProductMod;

class Product extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * 使用debug
     */
    public function useDebugDemo()
    {
          $obj = ProductMod::find(1);


        if (!$obj->isQtyOverload()) {
            return $this->resFail($obj->getDebug());
        }

        if (!$obj->isStepCheckAble()) {
            return $this->resFail($obj->getDebug());
        }

        return 'ok';
//        return $obj->isQtyOverload();
    }
}
