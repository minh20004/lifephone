<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // List all users
    public function index()
    {
        $users = User::all();
        return view('admin.page.member.list-member', compact('users'));
    }

    // Show form to create a new user
    public function create()
    {
        return view('admin.page.member.add');
    }

    // Store a new user
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'role' => 'required|in:admin,staff,customer',
    ]);

    // Tạo người dùng mới
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),  // Mã hóa mật khẩu
        'role' => $request->role,
    ]);

    return redirect()->route('admin.thanh-vien')->with('success', 'Thêm thành viên thành công');
}


    // Show form to edit an existing user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.page.member.edit', compact('user'));
    }

    // Update an existing user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:admin,staff,customer',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('admin.thanh-vien')->with('success', 'User updated successfully.');
    }

    // Delete a user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.thanh-vien')->with('success', 'User deleted successfully.');
    }
}
