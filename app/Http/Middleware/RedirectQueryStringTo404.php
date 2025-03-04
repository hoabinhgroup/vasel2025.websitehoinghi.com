<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectQueryStringTo404
{
	public function handle(Request $request, Closure $next)
	{
		$queryString = $request->getQueryString();
		
		// Kiểm tra xem có query string hay không
		if (!empty($queryString)) {
			abort(404); // Redirect về trang lỗi 404
		}
		
		return $next($request);
	}
}
