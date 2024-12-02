<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function signin()
    {
        return view('client.page.account.signin');
    }

    public function signup()
    {
        return view('client.page.account.signup');
    }

    public function postSignup(Request $req)
    {

        // Validate
        $req->merge(['password' => Hash::make($req->password)]);
        try {
            User::create($req->all());
        } catch (\Throwable $th) {
            // return redirect()->back()->with('msg', 'Đã đăng kí thành công!');
        }
        return redirect()->back()->with('msg', 'Đã đăng kí thành công!');
    }

    public function postSignin(Request $req)
    {
        $email = $req->email;
        $password = $req->password;
        $status = Auth::attempt(['email' => $email, 'password' => $password]);
        if ($status) {
            $user = Auth::user();
            if ($user->role == 'user') {
                // return redirect()->route('admin.home');
                return redirect()->route('user.home');
            }else {
                return redirect()->route('admin.home');
            }
        }
        return redirect()->back()->with('msg', 'Lỗi đăng nhập!. Vui lòng kiểm tra lại tài khoản.');
        
    }

    
}
