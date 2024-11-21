<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\RateLimiter;

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
            'role' => 'required|in:admin,staff,customer',
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
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }
    
// khách hàng ------------------------------------------------------------------------------------------------------------------------------

    public function showLogin_customer()
    {
        return view('client/page/auth/signin-customer'); 
    }

    public function file_customer()
    {
        return view('client/page/auth/file-customer'); 
    }

    public function customerLogin(Request $request)
    {
        // Rate limit the login attempts (for example, max 5 attempts per minute)
        if (RateLimiter::tooManyAttempts('login|' . $request->ip(), 5)) {
            return back()->withErrors(['email' => 'Too many login attempts. Please try again later.']);
        }

        // Validate the incoming request data
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Retrieve only the necessary fields from the request
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the customer using the custom guard 'customer'
        if (Auth::guard('customer')->attempt($credentials)) {
            // Authentication successful, redirect to the home page with a success message
            RateLimiter::clear('login|' . $request->ip()); // Clear the rate limit after successful login
            return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
        }

        // Failed login, increment the login attempts count
        RateLimiter::hit('login|' . $request->ip());

        // Authentication failed, redirect back with an error message
        return redirect()->back()->withErrors(['email' => 'Thông tin đăng nhập không đúng.']);
    }

    public function customerLogout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('home');
    }

    // Customer CRUD operations

    public function indexCustomer()
    {
        $customers = Customer::latest('id')->paginate(10);
        return view('admin.page.customer.list', compact('customers'));
    }

    public function createCustomer()
    {
        return view('client/page/auth/add');
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'gender' => 'required|in:male,female,other',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['email', 'phone', 'address', 'gender']);
        $data['password'] = bcrypt($request->password);

        if ($request->hasFile('avatar')) {
            if (!Storage::exists('avatars')) {
                Storage::makeDirectory('avatars');
            }
            $data['avatar'] = Storage::put('avatars', $request->file('avatar'));
        }

        Customer::create($data);

        return redirect()->route('customer.add')->with('success', 'Khách hàng đã được thêm thành công!');
    }

    public function editCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.page.customer.edit', compact('customer'));
    }

    public function updateCustomer(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:customers,email,'.$id,
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'gender' => 'required|in:male,female,other',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $customer = Customer::findOrFail($id);
        $data = $request->except('avatar');

        if ($request->hasFile('avatar')) {
            if ($customer->avatar) {
                Storage::delete($customer->avatar);
            }
            $data['avatar'] = Storage::put('avatars', $request->file('avatar'));
        }

        $customer->update($data);

        return redirect()->route('admin.customer.index')->with('success', 'Thông tin khách hàng đã được cập nhật!');
    }

    public function destroyCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customer.index')->with('success', 'Khách hàng đã được xóa!');
    }
}
