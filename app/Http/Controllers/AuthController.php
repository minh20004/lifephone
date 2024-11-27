<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Customer;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
//  admin ------------------------------------------------------------------------------------------------------------------------------
    public function Dashboards()
    {
        return view('admin.index');
    }   

    public function index()
    {
        // Kiểm tra role của người dùng
        if (Auth::user()->role !== 'admin') {
            return back()->withErrors('Bạn không có quyền truy cập vào trang này.');
        } 
        $users = User::latest('id')->paginate(10);
        return view('admin.page.member.list-member', compact('users'));
    }

    public function hoso()
    {
        // $user = User::findOrFail($id);
        return view('admin.page.member.profile.index');
    }
    // Show form to create a new user
    public function create()
    {
        // Kiểm tra role của người dùng
        if (Auth::user()->role !== 'admin') {
            return back()->withErrors('Bạn không có quyền truy cập vào trang này.');
        }   
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
            'role' => 'required|in:admin,staff',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Lấy dữ liệu cần thiết từ request
        $data = $request->only(['name', 'email', 'role']);  // Lưu thêm 'role'
        $data['password'] = bcrypt($request->password); // Mã hóa mật khẩu

        // Kiểm tra xem có file avatar không
        if ($request->hasFile('avatar')) {
            if (!Storage::exists('avatars')) {
                Storage::makeDirectory('avatars');
            }
            $data['avatar'] = Storage::put('avatars', $request->file('avatar'));
        }

        // Tạo người dùng mới với thông tin đã xác thực
        User::create($data);

        return redirect()->route('admins.index')->with('success', 'Thêm người dùng thành công');
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
    
    // hàm xử lý đăng nhập admin
    // public function adminLogin(Request $request)
    // {

    //     $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);

    //     $credentials = $request->only('email', 'password');

    //     if (Auth::guard('admin')->attempt($credentials)) {
    //         $admin = Auth::guard('admin')->user();

    //         if ($admin->role === 'admin') {

    //             return redirect()->route('admin.home')->with('success', 'Đăng nhập thành công!');
    //         } else {

    //             Auth::guard('admin')->logout();
    //             return redirect()->route('login')->withErrors(['email' => 'Bạn không có quyền truy cập trang admin.']);
    //         }
    //     }

    //     return redirect()->back()->withErrors(['email' => 'Thông tin đăng nhập không đúng.']);
    // }
    public function adminLogin(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        // Lấy thông tin email và mật khẩu từ request
        $credentials = $request->only('email', 'password');
    
        // Thử đăng nhập với guard 'admin'
        if (Auth::guard('admin')->attempt($credentials)) {
            // Lấy thông tin người dùng đã đăng nhập
            $user = Auth::guard('admin')->user();
    
            // Kiểm tra vai trò của người dùng
            if ($user->role === 'admin') {
                // Nếu là admin, chuyển hướng đến trang quản trị admin
                return redirect()->route('admin.home')->with('success', 'Đăng nhập thành công!');
            } elseif ($user->role === 'staff') {
                // Nếu là staff, chuyển hướng đến trang quản lý staff
                return redirect()->route('admin.home')->with('success', 'Đăng nhập thành công!');
            } else {
                // Nếu không phải admin hoặc staff, đăng xuất và thông báo lỗi
                Auth::guard('admin')->logout();
                return redirect()->route('login')->withErrors(['email' => 'Bạn không có quyền truy cập.']);
            }
        }
    
        // Nếu thông tin đăng nhập không đúng
        return redirect()->back()->withErrors(['email' => 'Thông tin đăng nhập không đúng.']);
    }
    
    public function adminLogout()
    {
        Auth::guard('admin')->logout();
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
            // 'phone' => 'required|regex:/^\d{10}$/|max:15',
            // 'address' => 'required|string',
            'gender' => 'required|in:male,female,other',
        ],
        );
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

    // Hàm xử lý cập nhật ảnh đại diện khách hàng
    public function updateAvatar(Request $request, $id)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        try {
            $customer = Customer::findOrFail($id);
            $data = $request->except('avatar');
    
            if ($request->hasFile('avatar')) {

                if ($customer->avatar) {
                    Storage::delete($customer->avatar); 
                }
    
                $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }
    
            $customer->update($data);
    
            return redirect()->route('customer.profile')->with('success', 'Cập nhật thông tin thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã có lỗi xảy ra, vui lòng thử lại!');
        }
    }
    
    // Hàm xử lý xóa ảnh đại diện khách hàng
    public function deleteAvatar($id)
    {
        try {
            $customer = Customer::findOrFail($id);

            if ($customer->avatar) {

                Storage::delete($customer->avatar);

                $customer->update(['avatar' => null]);
            }

            return redirect()->route('customer.profile')->with('success', 'Ảnh đại diện đã được xóa thành công!');
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

    // Hàm xử lý cập nhật địa chỉ khách hàng
    public function updateAddress(Request $request, $id)
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để cập nhật địa chỉ!');
        }

        $user = Auth::user(); // Lấy người dùng hiện tại
        if ($user->id != $id) {
            return redirect()->route('customer.profile')->with('error', 'Bạn không có quyền truy cập vào thông tin này!');
        }

        // Tiến hành cập nhật địa chỉ
        $request->validate([
            'address' => 'required|string|max:255',
        ]);

        try {
            $customer = Customer::findOrFail($id);
            $customer->update([
                'address' => $request->input('address')
            ]);

            return redirect()->route('customer.profile')->with('success', 'Cập nhật địa chỉ thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã có lỗi xảy ra, vui lòng thử lại!');
        }
    }

    // Hàm xử lý cập nhật mật khẩu khách hàng
    public function changePassword(Request $request, $id)
    {
        // Xác thực dữ liệu
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // Xác nhận mật khẩu mới
        ]);

        // Lấy người dùng hiện tại
        $user = Customer::findOrFail($id);

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }

        // Cập nhật mật khẩu mới
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Đổi mật khẩu thành công!');
    }

    // Hàm xử lý Xóa khách hàng
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

    
    
    public function history(Request $request)
    {
        // Kiểm tra khách đăng nhập hay không
        $customerId = auth('customer')->check() ? auth('customer')->id() : null;
    
        if (!$customerId) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem lịch sử đơn hàng.');
        }
    
        // Lấy mã đơn hàng từ request
        $searchCode = $request->input('order_code');
    
        // Nếu có tìm kiếm theo mã đơn hàng
        if ($searchCode) {
            $ordersAll = Order::where('customer_id', $customerId)
                            ->where('order_code', 'LIKE', '%' . $searchCode . '%') // Tìm kiếm mã gần đúng
                            ->get();
        } else {
            // Lấy toàn bộ đơn hàng của khách hàng
            $ordersAll = Order::where('customer_id', $customerId)
                            ->orderBy('created_at', 'desc')
                            ->get();
        }
        
        
    
        $totalOrders = Order::where('customer_id', $customerId)->count();
    
        // Phân loại đơn hàng theo trạng thái
        $ordersPending = Order::where('customer_id', $customerId)
                            ->where('status', 'Chờ xác nhận')
                            ->orderBy('created_at', 'desc')
                            ->get();
    
        $ordersConfirmed = Order::where('customer_id', $customerId)
                                ->where('status', 'Đã Xác Nhận')
                                ->orderBy('created_at', 'desc')
                                ->get();
    
        $ordersShipping = Order::where('customer_id', $customerId)
                                ->where('status', 'Đang giao hàng')
                                ->orderBy('created_at', 'desc')
                                ->get();
    
        $ordersCompleted = Order::where('customer_id', $customerId)
                                ->where('status', 'Hoàn Thành')
                                ->orderBy('created_at', 'desc')
                                ->get();
    
        $ordersCancelled = Order::where('customer_id', $customerId)
                                ->where('status', 'Đã Hủy')
                                ->orderBy('created_at', 'desc')
                                ->get();
    
        $ordersRefund = Order::where('customer_id', $customerId)
                            ->where('status', 'Trả hàng/Hoàn tiền')
                            ->orderBy('created_at', 'desc')
                            ->get();
    
        // Đếm số lượng đơn hàng cho từng trạng thái (sẽ được hiển thị trên Tabs)
        $countOrders = [
            'pending' => $ordersPending->count(),
            'confirmed' => $ordersConfirmed->count(),
            'shipping' => $ordersShipping->count(),
            'completed' => $ordersCompleted->count(),
            'cancelled' => $ordersCancelled->count(),
            'refund' => $ordersRefund->count(),
        ];
    
        return view('client.page.auth.page.order-history.order_history', compact(
            'ordersAll', 'ordersPending', 'ordersConfirmed', 'ordersShipping',
            'ordersCompleted', 'ordersCancelled', 'ordersRefund',
            'searchCode', 'countOrders', 'totalOrders'
        ));
    }
    



    public function detail($id)
    {
        // Xác định khách hàng hiện tại (nếu cần)
        $customerId = auth('customer')->check() ? auth('customer')->id() : null;

        // Tìm đơn hàng
        $order = Order::with(['orderItems.product', 'orderItems.variant.color', 'orderItems.variant.capacity', 'voucher'])
                    ->where('customer_id', $customerId) // Đảm bảo chỉ lấy đơn hàng của khách hiện tại
                    ->find($id);

        // Nếu không tìm thấy đơn hàng
        if (!$order) {
            return redirect()->route('order.history')->with('error', 'Đơn hàng không tồn tại hoặc bạn không có quyền xem.');
        }

        return view('client.page.auth.page.order-history.order_detail', compact('order'));
    }
    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        // Chỉ cho phép hủy khi trạng thái là "Chờ xác nhận"
        if ($order->status != 'Chờ xác nhận' ) {
            return redirect()->route('order.history')->with('error', 'Không thể hủy đơn hàng này!');
        }

        // Thay đổi trạng thái đơn hàng thành "Chờ xác nhận hủy"
        $order->status = 'Đã Hủy';
        $order->save();

        // Hoàn trả số lượng sản phẩm vào kho
        foreach ($order->orderItems as $orderItem) {
            $variant = ProductVariant::find($orderItem->variant_id);
            if ($variant) {
                $variant->stock += $orderItem->quantity;
                $variant->save();
            }
        }

        return redirect()->route('order.history')->with('success', 'Đơn hàng của bạn đã được yêu cầu hủy và đang chờ xác nhận.');
    }

    public function publicHistory(Request $request)
    {
        $searchCode = $request->input('order_code');

        if ($searchCode) {
            $orders = Order::where('order_code', 'LIKE', '%' . $searchCode . '%') // Tìm kiếm mã gần đúng
                            ->with(['orderItems.product', 'orderItems.variant.color', 'orderItems.variant.capacity'])
                            ->orderBy('created_at', 'desc')
                            ->get();
        } else {
            $orders = collect(); // Trả về danh sách rỗng
        }

        return view('client.page.auth.page.order-history.public-order.public_order_history', compact('orders', 'searchCode'));
    }
    
    public function publicDetail($id)
    {
        // Xác định khách hàng hiện tại (nếu cần)
        $customerId = auth('customer')->check() ? auth('customer')->id() : null;

        // Tìm đơn hàng
        $order = Order::with(['orderItems.product', 'orderItems.variant.color', 'orderItems.variant.capacity', 'voucher'])
                    ->where('customer_id', $customerId) // Đảm bảo chỉ lấy đơn hàng của khách hiện tại
                    ->find($id);

        // Nếu không tìm thấy đơn hàng
        if (!$order) {
            return redirect()->route('order.history')->with('error', 'Đơn hàng không tồn tại hoặc bạn không có quyền xem.');
        }

        return view('client.page.auth.page.order-history.public-order.public_order_detail', compact('order'));
    }


    


    public function wish_list(){
        return view('client.page.auth.page.wishList');
    }

}



