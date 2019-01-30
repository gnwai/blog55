<?php

namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    public $table = 'product';

    public $timestamps = false;


    protected $fillable = [
        'name'=> 'name',
        'cover' => 'cover',
    ];


    const MARK_TYPE = 0;



    use MarkTrait;


}
