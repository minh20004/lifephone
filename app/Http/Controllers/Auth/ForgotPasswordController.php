<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetEmail;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email không tồn tại'], 404);
        }

        $token = Str::random(60);
        $user->password_reset_token = $token;
        $user->save();

        // gửi email đến người dùng
        Mail::to($user->email)->send(new PasswordResetEmail($token));

        return response()->json(['message' => 'Yêu cầu quên mật khẩu đã được gửi']);
    }
}
