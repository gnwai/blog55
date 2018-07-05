<?php
namespace App\Http\Controllers\Admin;

use App\Model\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class Access extends Controller {


//注册成功
    public function register(Request $request)
    {
        $input = $request->all();
        $input['pwd'] = bcrypt($input['pwd']);
        $user = Admin::create($input);//注意这里是  admin 表
        $success['token'] =  $user->createToken('admin')->accessToken;
        $success['name'] =  $user->name;

        return response()->json(['success'=>$success], 200);
    }

    //登入不能用,
    public function login()
    {
        //attempt 方法 not exist
        Config::set('auth.defaults.guard', 'admin');

        if(Auth::attempt(['account' => request('account'), 'pwd' => request('pwd')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('admin')->accessToken;
            return response()->json(['success' => $success], 200);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }



    public function getUser(Request $request)
    {
        $user = $request->user();
        return response()->json(['success' => $user], 200);
    }



}