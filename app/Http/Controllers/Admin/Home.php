<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class Home extends Controller {

    public function index()
    {
//        return 'Admin/Home/index';
        return view('admin/admin');
    }


}