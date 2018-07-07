<?php
namespace App\Http\Controllers\Admin;

use App\Model\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Tymon\JWTAuth\Facades\JWTAuth;

class Access extends Controller {


    /**
     *  注册
     */
    public function register()
    {
        Admin::create([
            'name' => 'admin',
            'account' => 'admin@qq.com',        //此处例子假设以手机为账号
            'pwd' => bcrypt('123456')  //加密务必用Laravel中hepler提供的bcrypt
        ]);
    }
    /**
     *  登录
     * @param Request $request
     */
    public function login(Request $request)
    {

        config(['auth.defaults.guard' => 'admin']);
        //attempt方法用于验证帐号信息 成功则生成token值
        //attempt必须有"password"字段，无论你是自定义密码字段
        $token = JWTAuth::attempt(['account'=>'admin@qq.com','password'=>123456]);
        return response(json_encode(['token'=>$token]),200);
    }
    /**
     * 访问内部页面
     * 附上Header "Authorization" : "Bearer token值" 注意Bearer与token值间的空格
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        //return Auth::id();  //直接获取用户id
//        return Auth::guard('admin')->user();  //直接获取用户model

        return $request->user();
    }




}