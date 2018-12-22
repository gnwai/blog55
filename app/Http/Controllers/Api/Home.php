<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class Home extends Controller {

    public function index()
    {
        return 'aaaaa';
        return 'Api/Home/index';

        //跨域中间件
        //barryvdh/laravel-cors

        //有用
//        $guzzle = new GuzzleHttp\Client;
//        $response = $guzzle->get('http://mysite/api/user', [
//            'headers' => [
//                'Authorization' => 'Bearer DntgHWoEanBSYeMv',
//            ],
//        ]);
//
//        print_r( json_decode((string) $response->getBody(), true));
    }




}