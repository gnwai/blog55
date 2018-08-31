<?php

namespace App\Http\Middleware;

use App\Model\Admin;
use Closure;

class Online
{

	use \G2B2G\Contracts\Eloquent\Translate\Responser;


	public function handle($req, Closure $next, $guard='')
	{
        //		Config::set('auth.providers.users.model', \App\Model\SDWEmployee::class);
        config(['auth.defaults.guard' => $guard]);

//		return $next($req);
		$token = $req->header('dev-token');
//
		if ($token) { //本地测试 by wubuze

			$res = Admin::first();
			$res && auth()->login($res);
		} else {
			$res = $req->user();
		}

        $user = auth($guard)->user();

		return $user ? $next($req) : $this->resAlert('You are offline , please login.');
	}



}
