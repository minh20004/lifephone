<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra nếu người dùng đã đăng nhập qua guard admin
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();

            // Kiểm tra quyền admin hoặc staff
            if (in_array($user->role, ['admin', 'staff'])) {
                if (!$user->is_active) {
                    Auth::guard('admin')->logout();
                    return redirect()->route('login')
                        ->withErrors('Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.');
                }
                return $next($request);
            }
        }
        return redirect()->route('login')->withErrors('Bạn không có quyền truy cập.');
    }
}
