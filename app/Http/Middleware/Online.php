<?php

namespace App\Http\Middleware;

use Closure;

class Online
{

//	use \App\Contracts\Http\Responser;

	function __construct()
	{
//		Config::set('auth.providers.users.model', \App\Model\SDWEmployee::class);
	}

	public function handle($req, Closure $next, $guard='admin')
	{
//		return $next($req);
//		$token = $req->get('dev-token');
//
//		if ($token && config('app.env')=='local') { //本地测试 by wubuze
//
//			$res = SDWEmployee::where('token', $token)->first();
//			$res && auth()->login($res);
//		} else {
//			$res = $req->user();
//		}
        config(['auth.defaults.guard' => $guard]);

        $user = auth($guard)->user();
        if ($user) {
            return $next($req);
        }

        return response(json_encode(['status'=> 'error']), 201);

//		return $res ? $next($req) : $this->resAlert('You are offline or online expired, please login.');
	}



}
