<?php
namespace App\Http\Controllers\Api;

use App\User as UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class User extends Controller {

    public function userList()
    {
        $user = UserModel::get();
        return $this->resSuccess('success', $user);
    }


}