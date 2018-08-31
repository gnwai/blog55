<?php

namespace App\Http\Controllers\Common;

//use App\Jobs\Qiniu;
//use App\Plugin\Qiniu\Integration as QiniuSDK;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use UploadFile\File\Uploader;

/**
 * 全局上传组件
 * */

class Upload extends Controller
{

    private static $policyFields = [
        'callbackUrl',
        'callbackBody',
        'callbackHost',
        'callbackBodyType',

        'returnUrl',
        'returnBody',

        'endUser',
        'saveKey',
        'insertOnly',

        'detectMime',
        'mimeLimit',
        'fsizeMin',
        'fsizeLimit',

        'persistentOps',
        'persistentNotifyUrl',
        'persistentPipeline',

        'deleteAfterDays',
        'fileType',
        'isPrefixalScope',
    ];


    // 请求七牛Token（可用于富文本编辑器文件上传）
//    public function requestQiniuUploadToken (Request $req)
//    {
//        $bucket = 'sd-b2b-content';
//        $exp = $req->input('exp') ?: 3600*6;
//        return $this->resSuccess('七牛Token获取成功。', [
//            'token' => $this->make_qiniu_token($bucket, null, $exp),
//            'domain' => QiniuSDK::configBucket($bucket),
//            'expireTimestamp' => $exp+time()
//        ]);
//    }


//    private function make_qiniu_token($bucket, $key=null, $exp=3600, $policy=null, $strictPolicy=true)
//    {
//        QiniuSDK::init();
//        return QiniuSDK::makeUploadToken($bucket, $key, $exp, $policy, $strictPolicy);
//    }



    public function uploadFile (Request $req )
    {

        if ( !$req->hasFile('file')) {
            return $this->resFail('No file uploaded.');
        }

        $module = config('storage.'.$req->input('module'));
        if (!$module) {
            return $this->resFail('The module is not exist.');
        }

        Uploader::init($req->file('file'));
        $file = Uploader::upload($module['dir'], $req->input('fileName'), $module['public']);
        $file->setUrl();

        //上传到qiniu  关闭上线后开启
//        dispatch(
////			(new Qiniu($file) )->delay(5)->onConnection('redis')->onQueue('qiniu-uploadFile')
//            (new Qiniu($file) )
//        );

        return $this->resSuccess('File is uploaded successfully！',
            @[
                'id' => $file->id,
                'url' => $file->url,
                'top' => $file->top,
                'name' => $file->file.'.'.$file->type,
            ]);
    }


}
