<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $user = auth()->user();
        if (!$user->role == 'admin') {
            return redirect('/');
        }
        return $request;
        // return $request->expectsJson() ? null : route('login');
    }
}
