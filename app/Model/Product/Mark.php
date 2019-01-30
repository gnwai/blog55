<?php

namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{

    public $table = 'product_mark';

    public $timestamps = false;


    protected $fillable = [
        'name'=> 'name',
        'img' => 'img',
        'note' => 'note',
    ];

    const PRODUCT_LINK_TABLE= 'product_mark_link';







}
