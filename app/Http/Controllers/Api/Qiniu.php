<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class Qiniu extends Controller {

    //测试
    public function index()
    {
        $accessKey ="";
        $secretKey = "";
        $bucket = "";

        $auth = new Auth($accessKey, $secretKey);
        $token = $auth->uploadToken($bucket);

        $name = mt_rand(1,9999);
//        return view('Tester.wubuze', ['token' => $token, 'name' => $name]);

        // 要上传文件的本地路径
        $filePath = public_path('/storage/user-photo/20180717-0813-982.jpeg');
        // 上传到七牛后保存的文件名
        $key = '20180717-0813-982.jpeg';
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。

        $arr  = $uploadMgr->putFile($token, $key, $filePath);

        \Log::info($arr);

        return list($ret, $err) = $arr;

    }




}