<?php

namespace App\Http\Controllers;


trait Debuger
{

    private static $debug;

    public static function debug ($dat=null)
    {
        if ($dat) {
            self::$debug = $dat;
        } else {
            return self::$debug;
        }
    }


}