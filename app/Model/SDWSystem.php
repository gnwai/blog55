<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SDWSystem extends Model
{

    protected $table = 'sdw_system';

    protected $guarded = [];

    public $timestamps = false;
    protected $primaryKey = '';
    public $incrementing = false;

	use \jdavidbakr\ReplaceableModel\ReplaceableModel;


}
