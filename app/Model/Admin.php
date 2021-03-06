<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public $table = 'admin';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'account',
        'pwd',
        'address',
        'date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pwd',
    ];

    protected $casts = [
        'address' => 'array',
        'active' => 'boolean'
    ];



    public function setAccountAttribute($val)
    {

        return $this->attributes['account'] = $val.rand(1,999);
    }

    public function getDateAttribute($val)
    {
        if (!$val) {
            return date('Y-m-d H:i:s');
        }

        return $val;
    }


    //  JWT-Auth默认要实现的方法
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    // JWT-Auth默认要实现的方法
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     *  重写的方法
     */
    public function getAuthPassword()
    {
        return $this->getAttribute('pwd');  # 表中密码字段是pwd
    }

}
