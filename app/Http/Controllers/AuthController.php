<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;

class AuthController extends Controller
{
//  admin ------------------------------------------------------------------------------------------------------------------------------
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
    
//  khách hàng ------------------------------------------------------------------------------------------------------------------------------

    public function showLogin_customer()
    {
        return view('client/page/auth/signin-customer'); 
    }

    public function file_customer()
    {
        return view('client/page/auth/page/file-customer'); 
    }

    public function customerLogin(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        // Kiểm tra nếu thông tin đăng nhập hợp lệ
        if (Auth::guard('customer')->attempt($credentials)) {
            $customer = Auth::guard('customer')->user();
    
            if (!$customer->is_verified) {
                // Nếu tài khoản chưa xác nhận, đăng xuất và trả về thông báo lỗi
                Auth::guard('customer')->logout();
                return redirect()->route('customer.login')->withErrors(['email' => 'Tài khoản chưa được xác nhận. Vui lòng kiểm tra email để kích hoạt tài khoản.']);
            }
    
            // Nếu tài khoản đã xác nhận, đăng nhập thành công
            return redirect()->route('customer.file')->with('success', 'Đăng nhập thành công!');
        }
    
        return redirect()->back()->withErrors(['email' => 'Thông tin đăng nhập không đúng.']);
    }
    
    public function customerLogout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('home');
    }

    // Customer CRUD operations  -----------------------------------------------------------------------------------------------------------
    public function indexCustomer()
    {
        $customers = Customer::latest('id')->paginate(10);
        return view('admin.page.customer.list', compact('customers'));
    }

    public function createCustomer()
    {
        return view('client/page/auth/add');
    }

    // Đăng ký khách hàng
    public function storeCustomer(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $verificationToken = Str::random(64);

        $customer = Customer::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_token' => $verificationToken,
        ]);

        // Gửi email xác nhận
        Mail::send('email.verify', ['token' => $verificationToken], function ($message) use ($customer) {
            $message->to($customer->email)->subject('Xác nhận tài khoản của bạn');
        });
        return redirect()->route('customer.login')->with('success', 'Vui lòng kiểm tra email để xác nhận tài khoản!');
    }

    // Xác nhận email
    public function verifyCustomer($token)
    {
        $customer = Customer::where('verification_token', $token)->first();
    
        if (!$customer) {
            return redirect()->route('customer.login')->withErrors(['email' => 'Token xác nhận không hợp lệ hoặc đã hết hạn.']);
        }
    
        // Kích hoạt tài khoản và xóa token
        $customer->is_verified = true;
        $customer->verification_token = null; // Xóa token sau khi xác nhận
        $customer->save();
    
        return redirect()->route('customer.login')->with('success', 'Tài khoản của bạn đã được kích hoạt thành công!');
    }
    
    //gửi lại email xác nhận
    public function resendVerificationEmail(Request $request)
    {
        $customer = Customer::where('email', $request->email)->first();
    
        if (!$customer) {
            return redirect()->route('customer.login')->withErrors(['email' => 'Không tìm thấy tài khoản với email này.']);
        }
    
        // Kiểm tra nếu tài khoản đã được xác nhận
        if ($customer->is_verified) {
            return redirect()->route('customer.login')->with('success', 'Tài khoản của bạn đã được xác nhận.');
        }
    
        // Tạo lại token xác nhận duy nhất và lưu vào cơ sở dữ liệu
        $verificationToken = Str::random(60); 
        $customer->verification_token = $verificationToken;
        $customer->save();
    
        // Gửi email xác nhận
        Mail::to($customer->email)->send(new VerifyEmail($customer));
    
        return redirect()->route('customer.login')->with('success', 'Đã gửi lại email xác nhận. Vui lòng kiểm tra email của bạn.');
    }
    
    public function editCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.page.customer.edit', compact('customer'));
    }

    // Hàm xử lý cập nhật thông tin khách hàng
    public function updateCustomer(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|regex:/^\d{10}$/|max:15',
            'address' => 'required|string',
            'gender' => 'required|in:male,female,other',
        ], [
            'phone.regex' => 'Số điện thoại phải có đúng 10 chữ số!',
        ]);

        try {
            $customer = Customer::findOrFail($id);
            $data = $request->except('avatar');

            if ($request->hasFile('avatar')) {
                if ($customer->avatar) {
                    Storage::delete($customer->avatar);
                }
                $data['avatar'] = Storage::put('avatars', $request->file('avatar'));
            }

            $customer->update($data);

            // Gửi thông báo thành công
            return redirect()->route('customer.profile')->with('success', 'Cập nhật thông tin thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã có lỗi xảy ra, vui lòng thử lại!');
        }
    }
    
    // Hàm xử lý cập nhật số điện thoại email khách hàng
    public function updateContact(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^\+?\d{10,15}$/',  // Kiểm tra số điện thoại hợp lệ
        ]);
    
        try {
            $user = Customer::findOrFail($id);
            $user->update([
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
    
            return redirect()->route('customer.profile')->with('success', 'Cập nhật thông tin liên hệ thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã có lỗi xảy ra, vui lòng thử lại!');
        }
    }

    public function destroyCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customer.index')->with('success', 'Khách hàng đã được xóa!');
    }
// quản lý hồ sơ khách hàng ------------------------------------------------------------------------------------------------------------------------------
    public function address()
    {
        return view('client.page.auth.page.address');
    }
// Đơn hàng bên khách hàng---------------------------------------------------------------------------------------------------------------------------------------------

    public function orderHistory(){
        return view('client.page.auth.page.order_history');

    }
}



