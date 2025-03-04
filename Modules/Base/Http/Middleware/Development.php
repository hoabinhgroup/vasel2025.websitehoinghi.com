<?php

namespace Modules\Base\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;
use Auth;

class Development
{
	
	 public function handle($request, Closure $next, ...$guards)
    {
	   
       if (auth()->user() && in_array(auth()->id(), [1])) {
            \Debugbar::enable();
        }
        else {
            \Debugbar::disable();
        }

        return $next($request);
    }
    
}
