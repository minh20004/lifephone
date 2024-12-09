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
    // Kiểm tra nếu người dùng đã đăng nhập và là admin hoặc staff
    if (Auth::guard('admin')->check() && in_array(Auth::guard('admin')->user()->role, ['admin', 'staff'])) {
        return $next($request);
    }

    // Nếu không phải admin hay staff, chuyển hướng đến trang login với thông báo lỗi
    return redirect()->route('login')->withErrors('Bạn không có quyền truy cập.');
}
}
