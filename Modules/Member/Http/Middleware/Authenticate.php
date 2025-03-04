<?php

namespace Modules\Member\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as BaseAuthenticate;
use Illuminate\Support\Arr;
use Auth;

class Authenticate extends BaseAuthenticate
{
  public function handle($request, Closure $next, ...$guards)
  {

	if (Auth::guard('member')->check()) {
		return $next($request);
	}
	
	$redirectUrl = request()->url();
	
	return redirect()->route('member.login', ['memberUrl' => $redirectUrl]); 
  }

 
}
