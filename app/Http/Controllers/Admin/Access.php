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
     *  admin注册
     */
    public function register(Request $req)
    {
        if (!$req->account || !$req->pwd || !$req->name) {

            return $this->resFail('Account or pwd is not null');
        }
        $res = Admin::where('account', $req->account)->first();
        if ($res) {

            return $this->resFail('This account is exist!');

        }

        $res =  Admin::Create(
            [
                'account' => request('account'),
                'name' => request('name'),
                'pwd' => bcrypt(request('pwd'))  //加密务必用Laravel中hepler提供的bcrypt
            ]
        );

        return $this->resSuccess('success');
       

    }
    /**
     *  登录
     * @param Request $request
     */
    public function login(Request $req)
    {

        config(['auth.defaults.guard' => 'admin']);
        //attempt方法用于验证帐号信息 成功则生成token值
        //attempt必须有"password"字段，无论你是自定义密码字段
        if (!$req->account || !$req->pwd) {
            return $this->resFail('Account or pwd is null');
        }

        //这里一定要写 password ,尽管数据库的字段是pwd
        $token = JWTAuth::attempt(['account'=> $req->account, 'password'=> $req->pwd]);

        if ($token) {
            return $this->resSuccess('success', [
                'token' => $token
            ]);
        }
        return $this->resFail('Account or Pwd is Error !');
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

        if(!$request->user()) {
            return 'no login';
        }

        return $request->user();
    }




}