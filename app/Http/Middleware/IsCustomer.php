<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsCustomer
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('customer')->check()) {
            return $next($request);
        }

        return redirect()->route('customer.login')->withErrors('Bạn không có quyền truy cập.');
    }
}
