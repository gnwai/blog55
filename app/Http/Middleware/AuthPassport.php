<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AuthPassport
{
    function __construct()
	{
//		Config::set('auth.defaults.guard', 'api');
		// Config::set('auth.providers.users.model', \App\Model\SDWEmployee::class);
    }
    
    public function handle($req, Closure $next, $guard='api')
	{
        Config::set('auth.defaults.guard', $guard);
		// return $next($req);
		// $token = $req->get('dev-token');
        // $res = $req->user($guard);
        $res = $req->user();
        // $res  = Auth::user($guard);
        if ( $res ) {
            return $next($req);
        }

        return response()->json(['status'=> 'error' ], 200);
    
		
	}
}
