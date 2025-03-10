<?php

namespace App\Http\Middleware;

use Closure;

class BackendLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $language = \Session::get("backend-locale", config("app.locale"));

        // Lấy dữ liệu lưu trong Session, không có thì trả về default lấy trong config

        config(["app.locale" => $language]);

        return $next($request);
    }
}
