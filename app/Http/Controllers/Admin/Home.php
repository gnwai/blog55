<?php
namespace App\Http\Controllers\Admin;

use App\Model\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Home extends Controller {

    public function index()
    {
//        return 'Admin/Home/index';
        return view('admin/admin');
    }





}