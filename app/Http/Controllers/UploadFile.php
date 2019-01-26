<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use UploadFile\File\Uploader;

#上传文件或图片
class UploadFile extends Controller
{

    # 上传图片,需要先配置 config/storage 文件
    # 如果没有该文件先执行命令  php artisan vendor:publish
    public function index(Request $req)
    {
        $module = config('storage.'.$req->input('module'));
        if (!$module) { return '图片module目录不存在!'; }


        Uploader::init($req->file('file'));

        $file = Uploader::upload($module['dir'], $req->input('fileName'), $module['public']);
        $res =  $file->setUrl();

        return $this->resSuccess('ok', $res);
    }





}
