<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ]);

        $user = Customer::where('verification_token', $request->token)->first();

        if (!$user) {
            return response()->json(['message' => 'Token không hợp lệ'], 404);
        }

        $user->password = bcrypt($request->password);
        $user->verification_token = null;
        $user->save();

        return view('client.page.auth.signin-customer');
    }
}
