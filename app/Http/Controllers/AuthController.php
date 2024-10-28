<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function index()
    {
        $users = User::latest('id')->paginate(2);
        return view('admin.page.member.list-member', compact('users'));
    }
    public function hoso()
    {
        // $user = User::findOrFail($id);
        return view('admin.page.member.file');
    }
    // Show form to create a new user
    public function create()
    {
        return view('admin.page.member.add');
    }

    // Store a new user
    public function store(Request $request)
    {
        // Xác thực dữ liệu yêu cầu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'email']);
        $data['password'] = bcrypt($request->password); // Mã hóa mật khẩu

        if ($request->hasFile('avatar')) {
            if (!Storage::exists('avatars')) {
                Storage::makeDirectory('avatars');
            }
            $data['avatar'] = Storage::put('avatars', $request->file('avatar'));
        }
        
        User::create($data);

        return redirect()->route('admins.index')->with('success', 'Thêm thành công');
    }

    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.page.member.edit', compact('user'));
    }
    // Update an existing user
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,staff,customer',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($id);
        $data = $request->except('avatar');

        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu cần
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }
            // Lưu ảnh mới
            $data['avatar'] = Storage::put('avatars', $request->file('avatar'));
        }

        $user->update($data);

        return redirect()->route('admins.index')->with('success', 'Cập nhật thông tin thành công');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.thanh-vien')->with('success', 'User deleted successfully.');
    }
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.home')->with('success', 'Đăng nhập thành công!');
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors('Bạn không có quyền truy cập trang admin.');
            }
        } else {
            return redirect()->back()->withErrors('Thông tin đăng nhập không đúng.');
        }
    }

    public function adminLogout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
