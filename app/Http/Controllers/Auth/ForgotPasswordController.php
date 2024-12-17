<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetEmail;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = Customer::where('email', $request->email)->firstOrFail();

        $token = Str::random(60);
        $user->verification_token = $token;
        $user->save();

        Mail::to($user->email)->send(new PasswordResetEmail($token));

        // return view('client.page.auth.signin-customer');
        return redirect()->route('customer.login');
    }
}
