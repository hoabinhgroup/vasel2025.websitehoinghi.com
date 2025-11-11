<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RegistrationClosed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra config để xem đăng ký có được bật hay không
        $registrationEnabled = config('registration.enabled', false);

        if (!$registrationEnabled) {
            // Kiểm tra nếu đường dẫn là các form đăng ký
            $registrationRoutes = [
                'speaker-registration',
                'speaker-registration-submit',
                'speaker-registration-vn',
                'speaker-registration-vn-submit',
                'delegate-registration',
                'delegate-registration-submit',
                'delegate-registration-vn',
                'delegate-registration-vn-submit'
            ];

            $currentPath = $request->path();

            if (in_array($currentPath, $registrationRoutes)) {
                // Trả về thông báo form đã đóng
                return response()->view('Vasel2025::partials.registration-closed', [
                    'message_en' => config('registration.close_message.en'),
                    'message_vn' => config('registration.close_message.vn')
                ], 403);
            }
        }

        return $next($request);
    }
}
