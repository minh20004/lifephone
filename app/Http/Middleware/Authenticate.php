<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    // protected function redirectTo(Request $request): ?string
    // {
    //     return $request->expectsJson() ? null : route('login');
    // }
    // protected function redirectTo(Request $request): ?string
    // {
    //     if ($request->expectsJson()) {
    //         return null;
    //     }

    //     // Kiểm tra nếu URL bắt đầu với admin thì chuyển hướng đến login admin
    //     if ($request->is('admin/*')) {
    //         return route('admin.login');
    //     }

    //     // Ngược lại, chuyển hướng đến login của người dùng
    //     return route('customer.login');
    // }
    protected function redirectTo(Request $request): ?string
    {
        $user = auth()->user();
        if (!$user->role == 'admin') {
            return redirect('/');
        }
        return $request;
        // return $request->expectsJson() ? null : route('login');
        if ($request->expectsJson()) {
            return null;
        }

        // Kiểm tra xem người dùng đã đăng nhập với guard admin chưa
        if (auth('admin')->check()) {
            return null;
        }

        // Kiểm tra xem người dùng đã đăng nhập với guard customer chưa
        if (auth('customer')->check()) {
            return null;
        }

        // Nếu không, chuyển hướng đến login
        if ($request->is('admin/*')) {
            return route('admin.login');
        }

        return route('customer.login');
    }

}
