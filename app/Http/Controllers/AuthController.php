<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Mail\NewStaffNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\News;

class AuthController extends Controller
{
//  admin ------------------------------------------------------------------------------------------------------------------------------  
    // Thống kê của admin
    public function Dashboards(Request $request)
    {
        // Lấy ngày bắt đầu và kết thúc từ request
        $startDate = $request->input('start_date') 
            ? Carbon::parse($request->input('start_date'))->startOfDay()
            : Carbon::now()->startOfMonth();

        $endDate = $request->input('end_date') 
            ? Carbon::parse($request->input('end_date'))->endOfDay()
            : Carbon::now()->endOfMonth();

        // Format ngày tháng để hiển thị
        $formattedStartDate = $startDate->format('d/m/Y');
        $formattedEndDate = $endDate->format('d/m/Y');

        // Tính toán khoảng thời gian trước đó (1 tháng trước)
        $previousStartDate = $startDate->copy()->subMonth();
        $previousEndDate = $endDate->copy()->subMonth();

        // Thống kê số lượng đơn hàng theo trạng thái trong khoảng thời gian hiện tại
        $currentOrdersByStatus = [
            'Chờ xác nhận' => Order::where('status', 'Chờ xác nhận')->whereBetween('updated_at', [$startDate, $endDate])->count(),
            'Đã xác nhận' => Order::where('status', 'Đã xác nhận')->whereBetween('updated_at', [$startDate, $endDate])->count(),
            'Đang giao hàng' => Order::where('status', 'Đang giao hàng')->whereBetween('updated_at', [$startDate, $endDate])->count(),
            'Đã hoàn thành' => Order::where('status', 'Đã hoàn thành')->whereBetween('updated_at', [$startDate, $endDate])->count(),
            'Đã hủy' => Order::where('status', 'Đã hủy')->whereBetween('updated_at', [$startDate, $endDate])->count(),
        ];

        // Thống kê số lượng đơn hàng theo trạng thái trong khoảng thời gian trước đó
        $previousOrdersByStatus = [
            'Chờ xác nhận' => Order::where('status', 'Chờ xác nhận')->whereBetween('updated_at', [$previousStartDate, $previousEndDate])->count(),
            'Đã xác nhận' => Order::where('status', 'Đã xác nhận')->whereBetween('updated_at', [$previousStartDate, $previousEndDate])->count(),
            'Đang giao hàng' => Order::where('status', 'Đang giao hàng')->whereBetween('updated_at', [$previousStartDate, $previousEndDate])->count(),
            'Đã hoàn thành' => Order::where('status', 'Đã hoàn thành')->whereBetween('updated_at', [$previousStartDate, $previousEndDate])->count(),
            'Đã hủy' => Order::where('status', 'Đã hủy')->whereBetween('updated_at', [$previousStartDate, $previousEndDate])->count(),
        ];

        // Thống kê số người dùng đăng ký trong khoảng thời gian hiện tại
        $currentCustomerCount = Customer::whereBetween('created_at', [$startDate, $endDate])->count();

        // Thống kê số người dùng đăng ký trong khoảng thời gian trước đó
        $previousCustomerCount = Customer::whereBetween('created_at', [$previousStartDate, $previousEndDate])->count();

        // Tổng số người dùng đăng ký
        $totalCustomers = Customer::count();

        // Tính phần trăm thay đổi số lượng người dùng đăng ký
        $customerChangePercentage = $this->calculatePercentageChange($previousCustomerCount, $currentCustomerCount);
        
        // Thu nhập trong khoảng thời gian hiện tại
        $currentIncome = Order::where('status', 'Đã hoàn thành')->whereBetween('updated_at', [$startDate, $endDate])->sum('total_price');

        // Thu nhập trong khoảng thời gian trước đó
        $previousIncome = Order::where('status', 'Đã hoàn thành')
        ->whereBetween('updated_at', [$previousStartDate, $previousEndDate])
        ->sum('total_price');

        // Lấy thu nhập từng ngày trong khoảng thời gian
        $incomePerDay = Order::where('status', 'Đã hoàn thành')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->selectRaw('DATE(updated_at) as date, SUM(total_price) as daily_income')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Tạo dãy ngày từ startDate đến endDate
        $datesRange = [];
        $currentDate = Carbon::parse($startDate);
        $endDateCarbon = Carbon::parse($endDate);

        while ($currentDate <= $endDateCarbon) {
            $datesRange[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        // Lấy thu nhập cho từng ngày và thêm 0 nếu không có thu nhập
        $dailyIncome = [];
        foreach ($datesRange as $date) {
            $income = $incomePerDay->firstWhere('date', $date);
            $dailyIncome[$date] = $income ? $income->daily_income : 0;
        }

        // Xử lý tính phần trăm thay đổi thu nhập cho từng ngày
        $dailyChanges = [];
        for ($i = 1; $i < count($datesRange); $i++) {
            $previousIncome = $dailyIncome[$datesRange[$i - 1]];
            $currentIncome = $dailyIncome[$datesRange[$i]];

            // Tính phần trăm thay đổi, tránh chia cho 0
            if ($previousIncome == 0 && $currentIncome > 0) {
                $percentageChange = '100';
            } elseif ($previousIncome == 0 && $currentIncome == 0) {
                $percentageChange = '0';
            } else {
                $percentageChange = number_format((($currentIncome - $previousIncome) / $previousIncome) * 100, 2) . '%';
            }

            // Chuyển đổi định dạng ngày thành d/m/Y
            $formattedDate = Carbon::parse($datesRange[$i])->format('d/m/Y');

            // Định dạng thu nhập để không hiển thị phần .00 khi là số nguyên
            $formattedPreviousIncome = (intval($previousIncome) == $previousIncome) ? number_format($previousIncome, 0) : number_format($previousIncome, 2);
            $formattedCurrentIncome = (intval($currentIncome) == $currentIncome) ? number_format($currentIncome, 0) : number_format($currentIncome, 2);

            // Lưu thông tin vào mảng
            $dailyChanges[] = [
                'date' => $formattedDate,
                'previous_income' => $formattedPreviousIncome,  
                'current_income' => $formattedCurrentIncome,
                'percentage_change' => $percentageChange  
            ];
        }
        
        //Tính tổng tiền thời điểm thống kê
        $totalIncome = Order::where('status', 'Đã hoàn thành')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->sum('total_price');

        // Tính phần trăm thay đổi thu nhập
        $incomeChangePercentage = $this->calculatePercentageChange($previousIncome, $currentIncome);

        // Tính phần trăm thay đổi số lượng đơn hàng
        $orderChangePercentage = [];
        foreach ($currentOrdersByStatus as $status => $currentCount) {
            $previousCount = $previousOrdersByStatus[$status] ?? 0;
            $orderChangePercentage[$status] = $this->calculatePercentageChange($previousCount, $currentCount);
        }
        
        $totalProducts = Product::count();
        $totalNews = News::count();
        // Tạo mảng các ngày trong khoảng thời gian đã chọn
        $dates = [];
        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $dates[] = $currentDate->format('d/m/Y');
            $currentDate->addDay();
        }

        // Tính toán thu nhập cho từng ngày trong khoảng thời gian
        $incomeData = [];
        foreach ($dates as $date) {
            $incomeData[] = Order::where('status', 'Đã hoàn thành')
                                ->whereDate('updated_at', Carbon::createFromFormat('d/m/Y', $date))
                                ->sum('total_price');
        }

        // Lấy dữ liệu nhân viên và thống kê theo ngày, tháng, năm
        $employees = User::where('role', 'staff') // Lọc chỉ những người dùng là nhân viên
        ->withCount([
            'orders' => function ($query) use ($startDate, $endDate) {
                // Đếm các đơn hàng có trạng thái "Đã hoàn thành" trong khoảng thời gian
                $query->where('status', 'Đã hoàn thành')
                    ->whereBetween('updated_at', [$startDate, $endDate]); // Lọc theo ngày
            }
        ])
        ->withSum([
            'orders' => function ($query) use ($startDate, $endDate) {
                // Tính tổng thu nhập từ các đơn hàng có trạng thái "Đã hoàn thành" trong khoảng thời gian
                $query->where('status', 'Đã hoàn thành')
                    ->whereBetween('updated_at', [$startDate, $endDate]); // Lọc theo ngày
            }
        ], 'total_price')
        ->get();


        return view('admin.index', compact(
            'currentOrdersByStatus',
            'previousOrdersByStatus',
            'previousIncome',
            'currentIncome',
            'incomeChangePercentage',
            'orderChangePercentage',
            'currentCustomerCount',
            'previousCustomerCount',
            'totalCustomers',
            'customerChangePercentage',
            'startDate',
            'endDate',
            'formattedStartDate',
            'formattedEndDate',
            'totalProducts',
            'dates',
            'incomeData',
            'incomePerDay',
            'dailyChanges',
            'datesRange',
            'currentDate',
            'dailyIncome',
            'totalIncome',
            'employees',
            'totalNews'

        ));
    }
 
    //phần trăm thu nhập
    private function calculatePercentageChange($previousIncome, $currentIncome)
    {
        if ($previousIncome == 0) {
            return $currentIncome > 0 ? 100 : 0;  // Nếu thu nhập trước đó bằng 0, giới hạn tăng 100%.
        }

        $percentageChange = (($currentIncome - $previousIncome) / $previousIncome) * 100;

        // Giới hạn phần trăm thay đổi tối đa là 100% và làm tròn đến 2 chữ số
        $percentageChange = min($percentageChange, 100);
        
        return round($percentageChange, 2);
    }

    // thống kê của nhân viên
    public function staff(Request $request)
    {
        // Lấy ngày bắt đầu và kết thúc từ request (hoặc sử dụng mặc định)
        $startDate = $request->input('start_date') 
            ? Carbon::parse($request->input('start_date'))->startOfDay()
            : Carbon::now()->startOfMonth();

        $endDate = $request->input('end_date') 
            ? Carbon::parse($request->input('end_date'))->endOfDay()
            : Carbon::now()->endOfMonth();

        // Format ngày tháng để hiển thị
        $formattedStartDate = $startDate->format('d/m/Y');
        $formattedEndDate = $endDate->format('d/m/Y');

        // Tính toán khoảng thời gian trước đó (1 tháng trước)
        $previousStartDate = $startDate->copy()->subMonth();
        $previousEndDate = $endDate->copy()->subMonth();

        // Lấy thông tin nhân viên hiện tại (có thể liên kết với đơn hàng)
        $userId = auth()->user()->id;

        // Thống kê số lượng đơn hàng theo trạng thái cho nhân viên trong khoảng thời gian hiện tại
        $currentOrdersByStatus = [
            'Chờ xác nhận' => Order::where('user_id', $userId)
                                    ->where('status', 'Chờ xác nhận')
                                    ->whereBetween('updated_at', [$startDate, $endDate])
                                    ->count(),
            'Đã xác nhận' => Order::where('user_id', $userId)
                                ->where('status', 'Đã xác nhận')
                                ->whereBetween('updated_at', [$startDate, $endDate])
                                ->count(),
            'Đang giao hàng' => Order::where('user_id', $userId)
                                    ->where('status', 'Đang giao hàng')
                                    ->whereBetween('updated_at', [$startDate, $endDate])
                                    ->count(),
            'Đã hoàn thành' => Order::where('user_id', $userId)
                                    ->where('status', 'Đã hoàn thành')
                                    ->whereBetween('updated_at', [$startDate, $endDate])
                                    ->count(),
            'Đã hủy' => Order::where('user_id', $userId)
                            ->where('status', 'Đã hủy')
                            ->whereBetween('updated_at', [$startDate, $endDate])
                            ->count(),
        ];

        // Thống kê số lượng đơn hàng theo trạng thái cho nhân viên trong khoảng thời gian trước đó
        $previousOrdersByStatus = [
            'Chờ xác nhận' => Order::where('user_id', $userId)
                                    ->where('status', 'Chờ xác nhận')
                                    ->whereBetween('updated_at', [$previousStartDate, $previousEndDate])
                                    ->count(),
            'Đã xác nhận' => Order::where('user_id', $userId)
                                ->where('status', 'Đã xác nhận')
                                ->whereBetween('updated_at', [$previousStartDate, $previousEndDate])
                                ->count(),
            'Đang giao hàng' => Order::where('user_id', $userId)
                                    ->where('status', 'Đang giao hàng')
                                    ->whereBetween('updated_at', [$previousStartDate, $previousEndDate])
                                    ->count(),
            'Đã hoàn thành' => Order::where('user_id', $userId)
                                    ->where('status', 'Đã hoàn thành')
                                    ->whereBetween('updated_at', [$previousStartDate, $previousEndDate])
                                    ->count(),
            'Đã hủy' => Order::where('user_id', $userId)
                            ->where('status', 'Đã hủy')
                            ->whereBetween('updated_at', [$previousStartDate, $previousEndDate])
                            ->count(),
        ];

        // Thu nhập của nhân viên trong khoảng thời gian hiện tại (dựa trên các đơn hàng đã hoàn thành)
        $currentIncome = Order::where('user_id', $userId) // Thay 'assigned_to' bằng 'user_id'
            ->where('status', 'Đã hoàn thành')
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->sum('total_price');

        // Thu nhập của nhân viên trong khoảng thời gian trước đó
        $previousIncome = Order::where('user_id', $userId) // Thay 'assigned_to' bằng 'user_id'
            ->where('status', 'Đã hoàn thành')
            ->whereBetween('updated_at', [$previousStartDate, $previousEndDate])
            ->sum('total_price');

        // Tính phần trăm thay đổi thu nhập
        $incomeChangePercentage = $this->calculatePercentageChange($previousIncome, $currentIncome);

        // Tính phần trăm thay đổi số lượng đơn hàng
        $orderChangePercentage = [];
        foreach ($currentOrdersByStatus as $status => $currentCount) {
            $previousCount = $previousOrdersByStatus[$status] ?? 0;
            $orderChangePercentage[$status] = $this->calculatePercentageChange($previousCount, $currentCount);
        }
        $dates = Order::selectRaw('DATE(created_at) as date, SUM(total_price) as income')
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->pluck('date');

        $incomeData = Order::selectRaw('DATE(created_at) as date, SUM(total_price) as income')
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->pluck('income');

        $totalProducts = Product::count();
        $totalNews = News::count();
        // Truyền dữ liệu vào view
        return view('admin.staff', compact(
            'currentOrdersByStatus',
            'previousOrdersByStatus',  // Đảm bảo biến này đã được khai báo và gán giá trị
            'previousIncome',
            'currentIncome',
            'incomeChangePercentage',
            'orderChangePercentage',
            'startDate',
            'endDate',
            'formattedStartDate',
            'formattedEndDate',
            'dates',
            'incomeData',
            'totalProducts',
            'totalNews'
        ));
    }

    public function showEmployeeOrders($employeeId, Request $request)
    {
        // Khởi tạo mảng $orders rỗng để tránh lỗi khi không có đơn hàng
        $orders = collect();

        // Lấy thông tin nhân viên
        $employee = User::findOrFail($employeeId);

        // Kiểm tra quyền của admin và nhân viên
        if (Auth::guard('admin')->check()) {
            // Admin có thể xem tất cả đơn hàng của nhân viên
            $orders = Order::where('user_id', $employeeId)
                ->where('status', 'Đã hoàn thành') // Lọc theo trạng thái "Đã hoàn thành"
                ->whereBetween('updated_at', [
                    $request->input('start_date', now()->startOfMonth()),
                    $request->input('end_date', now()->endOfMonth())
                ]) // Lọc theo thời gian
                ->get();
        } elseif (Auth::guard('employee')->check()) {
            // Nhân viên chỉ có thể xem đơn hàng của chính mình
            $orders = Order::where('user_id', Auth::guard('employee')->user()->id)
                ->where('status', 'Đã hoàn thành')
                ->whereBetween('updated_at', [
                    $request->input('start_date', now()->startOfMonth()),
                    $request->input('end_date', now()->endOfMonth())
                ])
                ->get();
        } else {
            // Nếu không phải admin hay nhân viên, chuyển hướng về login
            return redirect()->route('login')->withErrors('Bạn không có quyền truy cập.');
        }

        // Kiểm tra nếu không có đơn hàng
        if ($orders->isEmpty()) {
            return redirect()->back()->with('message', 'Không có đơn hàng nào trong khoảng thời gian này.');
        }

        // Truyền danh sách đơn hàng và thông tin nhân viên vào view
        return view('admin.page.order.employee_orders', compact('orders', 'employee'));
    }


    

    
    public function showOrderDetails($orderId)
    {
        // Lấy thông tin chi tiết của đơn hàng
        $order = Order::with(['orderItems.product', 'orderItems.variant'])
            ->findOrFail($orderId);

        // Truyền thông tin đơn hàng vào view
        return view('admin.page.order.employee_order_show', compact('order'));
    }



    // hiển thị trang thống kê nhân viên
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

    // Thêm nhân viên
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
        $data = $request->only(['name', 'email', 'role']); 
        $data['password'] = bcrypt($request->password);
    
        // Kiểm tra xem có file avatar không
        if ($request->hasFile('avatar')) {
            if (!Storage::exists('avatars')) {
                Storage::makeDirectory('avatars');
            }
            $data['avatar'] = Storage::put('avatars', $request->file('avatar'));
        }
    
        // Tạo người dùng mới với thông tin đã xác thực
        $user = User::create($data);
    
        // Gửi email thông báo
        // Mail::to($user->email)->send(new NewStaffNotification($user));
    
        return redirect()->route('admins.index')->with('success', 'Thêm người dùng thành công');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.page.member.edit', compact('user'));
    }
    // Update an existing user
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'email' => 'required|string|email|max:255|unique:users,email,'.$id,
    //         'name' => 'required|string|max:255',
    //         'role' => 'required|in:admin,staff,customer',
    //         'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $user = User::findOrFail($id);
    //     $data = $request->except('avatar');

    //     if ($request->hasFile('avatar')) {
    //         // Xóa ảnh cũ nếu cần
    //         if ($user->avatar) {
    //             Storage::delete($user->avatar);
    //         }
    //         // Lưu ảnh mới
    //         $data['avatar'] = Storage::put('avatars', $request->file('avatar'));
    //     }

    //     $user->update($data);

    //     return redirect()->route('admins.index')->with('success', 'Cập nhật thông tin thành công');
    // }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }
            // Lưu ảnh mới
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        return redirect()->back()->with('success', 'Cập nhật hồ sơ thành công!');
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
    public function adminLogin(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::guard('admin')->attempt($credentials)) {

            $user = Auth::guard('admin')->user();
    
            if ($user->role === 'admin') {

                return redirect()->route('admin.home')->with('success', 'Đăng nhập thành công!');
            } elseif ($user->role === 'staff') {

                return redirect()->route('admin.staff')->with('success', 'Đăng nhập thành công!');
            } else {

                Auth::guard('admin')->logout();
                return redirect()->route('login')->withErrors(['email' => 'Bạn không có quyền truy cập.']);
            }
        }
    
        return redirect()->back()->withErrors(['email' => 'Thông tin đăng nhập không đúng.']);
    }

    public function verify($token)
    {
        // Tìm người dùng với remember_token
        $user = User::where('remember_token', $token)->first();

        // Kiểm tra xem người dùng có tồn tại không
        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Liên kết xác minh không hợp lệ.']);
        }

        // Cập nhật thời gian xác minh email
        if (!$user->hasVerifiedEmail()) {
            $user->email_verified_at = now();
            $user->remember_token = null;  // Xóa token sau khi xác minh thành công
            $user->save();
        }

        return redirect()->route('login')->with('success', 'Tài khoản của bạn đã được xác minh thành công. Vui lòng đăng nhập.');
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

        if (auth('customer')->attempt($credentials)) {
            // Xóa session voucher khi đăng nhập thành công
            session()->forget('voucher');
        }
    
        // Kiểm tra nếu thông tin đăng nhập hợp lệ
        if (Auth::guard('customer')->attempt($credentials)) {
            $customer = Auth::guard('customer')->user();

            if (!$customer->is_verified) {

                Auth::guard('customer')->logout();
                return redirect()->route('customer.login')->withErrors(['email' => 'Tài khoản chưa được xác nhận. Vui lòng kiểm tra email để kích hoạt tài khoản.']);
            }

            return redirect()->route('customer.file')->with('success', 'Đăng nhập thành công!');
        }

        return redirect()->back()->withErrors(['email' => 'Thông tin đăng nhập không đúng.']);
    }

    public function customerLogout()
    {
        $customerId = auth('customer')->id();
    
    // Xóa voucher trong session khi người dùng đăng xuất
        session()->forget('voucher');

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

    // Thay đổi email
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|string',
        ]);

        $customer = Auth::guard('customer')->user();

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->password, $customer->password)) {
            return back()->withErrors(['password' => 'Mật khẩu hiện tại không chính xác']);
        }

        // Tạo token xác nhận thay đổi email



        
        $verificationToken = Str::random(64);

        // Lưu token và email mới vào session
        session([
            'verification_token' => $verificationToken,
            'email' => $request->email,
        ]);

        // Gửi email xác nhận thay đổi email
        Mail::send('email.verify_email_change', ['token' => $verificationToken], function ($message) use ($request) {
            $message->to($request->email)->subject('Xác nhận thay đổi email');
        });

        return back()->with('success', 'Vui lòng kiểm tra email mới để xác nhận thay đổi.');
    }

    // Gửi lại email để thay đổi
    // public function verifyEmailChange($token)
    // {
    //     $customer = Auth::guard('customer')->user();
    //     $storedToken = session('verification_token');
    //     $newEmail = session('email');

    //     if (!$customer || $token !== $storedToken) {
    //         return redirect()->route('customer.profile')->withErrors(['email' => 'Token xác nhận không hợp lệ hoặc đã hết hạn.']);
    //     }

    //     // Cập nhật email mới vào cơ sở dữ liệu
    //     $customer->update([
    //         'email' => $newEmail,
    //     ]);

    //     // Xóa token và email mới khỏi session
    //     session()->forget(['verification_token', 'email']);

    //     return redirect()->route('customer.profile')->with('success', 'Email của bạn đã được thay đổi thành công.');
    // }
    




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

    function indexChatBoard(){
        $admin = User::first();
        $conversations = Conversation::where('userId', $admin->id)->get();
        $customers = Customer::all();
        $messages = Message::all();
        return view('admin.page.chatBoard.chatBoard', compact('conversations', 'customers', 'messages', 'admin'));
    }
}
