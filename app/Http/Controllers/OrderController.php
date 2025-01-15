<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\OrderItem;
use App\Models\VoucherUsage;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\UserNotification;
use App\Models\OrderNotification;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    // public function index(Request $request)
    // {
    //     $searchTerm = $request->input('search');
    //     $perPage = 10;
    //     $id_staff = Auth::guard('admin')->user()->id;

    //     // Query cơ bản
    //     $baseQuery = Order::orderBy('created_at', 'desc');
    //     if ($searchTerm) {
    //         $baseQuery->where(function($query) use ($searchTerm) {
    //             $query->where('order_code', 'like', '%' . $searchTerm . '%')
    //                 ->orWhere('name', 'like', '%' . $searchTerm . '%');
    //         });
    //     }

    //     // Nhóm đơn hàng theo trạng thái với phân trang riêng biệt
    //     $groupedOrders = [
    //         'Tất cả' => $baseQuery->paginate($perPage)->appends($request->query()),
    //         'Chờ xác nhận' => Order::where('status', 'Chờ xác nhận')
    //             ->orderBy('created_at', 'desc')
    //             ->paginate($perPage)
    //             ->appends($request->query()),
    //         'Đã xác nhận' => Order::where('status', 'Đã xác nhận')
    //             ->where('user_id', $id_staff)
    //             ->orderBy('created_at', 'desc')
    //             ->paginate($perPage)
    //             ->appends($request->query()),
    //         'Đang giao hàng' => Order::where('status', 'Đang giao hàng')
    //             ->where('user_id', $id_staff)
    //             ->orderBy('created_at', 'desc')
    //             ->paginate($perPage)
    //             ->appends($request->query()),
    //         'Đã hoàn thành' => Order::where('status', 'Đã hoàn thành')
    //             ->where('user_id', $id_staff)
    //             ->orderBy('created_at', 'desc')
    //             ->paginate($perPage)
    //             ->appends($request->query()),
    //         'Đã hủy' => Order::where('status', 'Đã hủy')
    //             ->where('user_id', $id_staff)
    //             ->orderBy('created_at', 'desc')
    //             ->paginate($perPage)
    //             ->appends($request->query()),
    //         'Thanh toán thất bại' => Order::where('status', 'Thanh toán thất bại')
    //             ->where('user_id', $id_staff)
    //             ->orderBy('created_at', 'desc')
    //             ->paginate($perPage)
    //             ->appends($request->query()),
    //     ];

    //     // Tính số lượng đơn hàng cho từng trạng thái
    //     $orderCounts = [
    //         'Tất cả' => Order::count(),
    //         'Chờ xác nhận' => Order::where('status', 'Chờ xác nhận')->count(),
    //         'Đã xác nhận' => Order::where('status', 'Đã xác nhận')->where('user_id', $id_staff)->count(),
    //         'Đang giao hàng' => Order::where('status', 'Đang giao hàng')->where('user_id', $id_staff)->count(),
    //         'Đã hoàn thành' => Order::where('status', 'Đã hoàn thành')->where('user_id', $id_staff)->count(),
    //         'Đã hủy' => Order::where('status', 'Đã hủy')->where('user_id', $id_staff)->count(),
    //         'Thanh toán thất bại' => Order::where('status', 'Thanh toán thất bại')->where('user_id', $id_staff)->count(),
    //     ];

    //     return view('admin.page.order.index', compact('groupedOrders', 'orderCounts'));
    // }

    // public function updateStatus(Request $request, $id)
    // {
    //     // Validate trạng thái đơn hàng
    //     $validated = $request->validate([
    //         'status' => 'required|in:Chờ xác nhận,Đã xác nhận,Đang giao hàng,Đã hoàn thành,Đã hủy',
    //     ]);

    //     // Lấy đơn hàng theo id
    //     $order = Order::findOrFail($id);

    //     if ($order->status === $request->status) {
    //         return back()->withErrors(['status' => 'Trạng thái đơn hàng hiện tại đã trùng với trạng thái mới.']);
    //     }

    //     // Nếu trạng thái được cập nhật là 'Đã hủy', hoàn trả số lượng sản phẩm vào kho
    //     if ($request->status === 'Đã hủy' && $order->status !== 'Đã hủy') {
    //         foreach ($order->orderItems as $orderItem) {
    //             $variant = ProductVariant::find($orderItem->variant_id);
    //             if ($variant) {
    //                 $variant->stock += $orderItem->quantity;
    //                 $variant->save();
    //             }
    //         }
    //     }

    //     // Cập nhật trạng thái và người cập nhật (user_id)
    //     $order->status = $request->status;
    //     $order->user_id = Auth::id(); // Lấy ID của người đăng nhập hiện tại
    //     $order->save();

    //     // Chuyển hướng về trang danh sách đơn hàng với thông báo thành công
    //     return redirect()->route('orders.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    // }
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $perPage = 10;
        $currentUser = Auth::guard('admin')->user();

        // Query cơ bản
        $baseQuery = Order::orderBy('created_at', 'desc');
        if ($searchTerm) {
            $baseQuery->where(function ($query) use ($searchTerm) {
                $query->where('order_code', 'like', '%' . $searchTerm . '%')
                    ->orWhere('name', 'like', '%' . $searchTerm . '%');
            });
        }

        // Xây dựng điều kiện truy vấn dựa trên vai trò
        $isAdmin = $currentUser->role === 'admin';

        $groupedOrders = [
            'Tất cả' => Order::when(!$isAdmin, fn($query) => $query->where('user_id', $currentUser->id))
                ->whereNotIn('status', ['Chờ thanh toán', 'Thanh toán thất bại'])
                ->orderBy('created_at', 'desc')
                ->paginate($perPage)
                ->appends($request->query()),
            'Chờ xác nhận' => Order::where('status', 'Chờ xác nhận')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage)
                ->appends($request->query()),
            'Đã xác nhận' => Order::where('status', 'Đã xác nhận')
                ->when(!$isAdmin, fn ($query) => $query->where('user_id', $currentUser->id))
                ->orderBy('created_at', 'desc')
                ->paginate($perPage)
                ->appends($request->query()),
            'Đang giao hàng' => Order::where('status', 'Đang giao hàng')
                ->when(!$isAdmin, fn ($query) => $query->where('user_id', $currentUser->id))
                ->orderBy('created_at', 'desc')
                ->paginate($perPage)
                ->appends($request->query()),
            'Đã hoàn thành' => Order::where('status', 'Đã hoàn thành')
                ->when(!$isAdmin, fn ($query) => $query->where('user_id', $currentUser->id))
                ->orderBy('created_at', 'desc')
                ->paginate($perPage)
                ->appends($request->query()),
            'Đã hủy' => Order::where('status', 'Đã hủy')
                ->when(!$isAdmin, fn ($query) => $query->where('user_id', $currentUser->id))
                ->orderBy('created_at', 'desc')
                ->paginate($perPage)
                ->appends($request->query()),
        ];

        $orderCounts = [
            'Tất cả' => Order::when(!$isAdmin, fn($query) => $query->where('user_id', $currentUser->id))
                ->whereNotIn('status', ['Chờ thanh toán', 'Thanh toán thất bại'])
                ->count(),
            'Chờ xác nhận' => Order::where('status', 'Chờ xác nhận')->count(),
            'Đã xác nhận' => Order::where('status', 'Đã xác nhận')
                ->when(!$isAdmin, fn ($query) => $query->where('user_id', $currentUser->id))
                ->count(),
            'Đang giao hàng' => Order::where('status', 'Đang giao hàng')
                ->when(!$isAdmin, fn ($query) => $query->where('user_id', $currentUser->id))
                ->count(),
            'Đã hoàn thành' => Order::where('status', 'Đã hoàn thành')
                ->when(!$isAdmin, fn ($query) => $query->where('user_id', $currentUser->id))
                ->count(),
            'Đã hủy' => Order::where('status', 'Đã hủy')
                ->when(!$isAdmin, fn ($query) => $query->where('user_id', $currentUser->id))
                ->count(),
        ];

        return view('admin.page.order.index', compact('groupedOrders', 'orderCounts'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Validate trạng thái đơn hàng
        $validated = $request->validate([
            'status' => 'required|in:Chờ xác nhận,Đã xác nhận,Đang giao hàng,Đã hoàn thành,Đã hủy',
        ]);
    
        // Lấy đơn hàng theo id
        $order = Order::findOrFail($id);
    
        if ($order->status === $request->status) {
            return back()->withErrors(['status' => 'Trạng thái đơn hàng hiện tại đã trùng với trạng thái mới.']);
        }
    
        // Nếu trạng thái được cập nhật là 'Đã hủy', hoàn trả số lượng sản phẩm vào kho
        if ($request->status === 'Đã hủy' && $order->status !== 'Đã hủy') {
            foreach ($order->orderItems as $orderItem) {
                $variant = ProductVariant::find($orderItem->variant_id);
                if ($variant) {
                    $variant->stock += $orderItem->quantity;
                    $variant->save();
                }
            }
        }
    
        // Cập nhật trạng thái và người cập nhật (user_id)
        $order->status = $request->status;
        $order->user_id = Auth::id(); // Lấy ID của người đăng nhập hiện tại
        $order->save();
    
        // Chuyển hướng về trang danh sách đơn hàng với thông báo thành công
        return redirect()->route('orders.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
    



    public function show(string $id)
    {
        $order = Order::with(['orderItems.product', 'orderItems.variant'])->findOrFail($id);
        return view('admin.page.order.order_show', compact('order'));
    }


    // public function storeOrder(Request $request) // lỗi voucher
    // {
    //     // Validate dữ liệu yêu cầu
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'phone' => 'required|string|max:20',
    //         'email' => 'required|email',
    //         'address' => 'required|string|max:255',
    //         'payment_method' => 'required|string|in:COD,Online',
    //         'description' => 'nullable|string',
    //     ],[
    //         'name' => "Tên người nhận không được để trống",
    //         'phone' => "Số điện thoại không được để trống",
    //         'email' => "Email không được để trống",
    //         'address' => "Địa chỉ không được để trống",
    //     ]);

    //     $customerId = auth('customer')->check() ? auth('customer')->id() : null;

    //     // Lấy giỏ hàng từ session hoặc cơ sở dữ liệu tùy theo người dùng đã đăng nhập hay chưa
    //     $cartItems = [];
    //     if ($customerId) {
    //         // Người dùng đã đăng nhập, lấy giỏ hàng từ cơ sở dữ liệu
    //         $cartItems = Cart::where('customer_id', $customerId)->where('is_checked', true)->get();
    //         if ($cartItems->isEmpty()) {
    //             return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống.');
    //         }
    //     } else {
    //         // Người dùng chưa đăng nhập, lấy giỏ hàng từ session
    //         $cartItems = session()->get('cart', []);
    //         $checkedItems = [];

    //         // Duyệt qua giỏ hàng để lọc các sản phẩm có is_checked = true
    //         foreach ($cartItems as $productId => $models) {
    //             foreach ($models as $modelId => $colors) {
    //                 foreach ($colors as $colorId => $item) {
    //                     if ($item['is_checked'] === true) {  // Kiểm tra điều kiện is_checked
    //                         $checkedItems[] = $item;  // Thêm sản phẩm vào mảng checkedItems
    //                     }
    //                 }
    //             }
    //         }

    //         $cartItems = $checkedItems;  // Gán lại giỏ hàng với các sản phẩm đã chọn
    //         if (empty($cartItems)) {
    //             return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống.');
    //         }
    //     }

    //     $voucher = session()->get('voucher', []);
    //     $totalPrice = 0;
    //     $totalQuantity = 0;

    //     // Tính toán tổng giá trị và số lượng sản phẩm trong giỏ hàng
    //     if ($customerId) {
    //         // Dữ liệu từ database
    //         foreach ($cartItems as $item) {
    //             $totalPrice += $item->price * $item->quantity;
    //             $totalQuantity += $item->quantity;
    //         }
    //     } else {
    //         // Dữ liệu từ session
    //         foreach ($cartItems as $productId => $models) {
    //             if (is_array($models)) {
    //                 foreach ($models as $modelId => $colors) {
    //                     if (is_array($colors)) {
    //                         foreach ($colors as $colorId => $cartItem) {
    //                             // Kiểm tra nếu dữ liệu giỏ hàng hợp lệ
    //                             if (isset($cartItem['price'], $cartItem['quantity'])) {
    //                                 $totalPrice += $cartItem['price'] * $cartItem['quantity'];
    //                                 $totalQuantity += $cartItem['quantity'];
    //                             } else {
    //                                 return redirect()->back()->with('error', 'Dữ liệu giỏ hàng không hợp lệ.');
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     // Áp dụng giảm giá từ voucher
    //     $discount = $voucher['discount'] ?? 0;
    //     $totalAfterDiscount = $totalPrice - $discount;

    //     // Tạo mã đơn hàng
    //     $orderCode = strtoupper(substr(uniqid(), -8));

    //     // Lấy voucher_id nếu có voucher
    //     $voucherId = isset($voucher['code']) ? Voucher::where('code', $voucher['code'])->first()->id : null;

    //     // Lấy địa chỉ của người dùng đăng nhập hoặc từ form
    //     $address = $customerId
    //         ? Address::where('customer_id', $customerId)->where('is_default', 1)->first()
    //         : null;

    //     if (!$address && $customerId) {
    //         $address = Address::create([
    //             'customer_id' => $customerId,
    //             'name' => $request->name,
    //             'phone_number' => $request->phone,
    //             'address' => $request->address,
    //             'is_default' => 1,
    //         ]);
    //     }

    //     // Tạo đơn hàng
    //     $order = Order::create([
    //         'customer_id' => $customerId,
    //         'name' => $request->name,
    //         'phone' => $request->phone,
    //         'email' => $request->email,
    //         'address' => $request->address,
    //         'payment_method' => $request->payment_method,
    //         'total_price' => $totalAfterDiscount,
    //         'status' => $request->payment_method === 'COD' ? 'Chờ xác nhận' : 'Chờ thanh toán',
    //         'voucher_id' => $voucherId,
    //         'description' => $request->description,
    //         'order_code' => $orderCode,
    //     ]);

    //     // Lưu các sản phẩm trong đơn hàng
    //     if ($customerId) {
    //         // Lưu từ database
    //         foreach ($cartItems as $item) {
    //             $product = Product::find($item->product_id);
    //             $variant = ProductVariant::find($item->variant_id);
                
    //             OrderItem::create([
    //                 'order_id' => $order->id,
    //                 'product_id' => $item->product_id,
    //                 'variant_id' => $item->variant_id,
    //                 'name' => $product ? $product->name : 'Sản phẩm không xác định',
    //                 'image_url' => $product ? $product->image_url : null,
    //                 'quantity' => $item->quantity,
    //                 'price' => $item->price,
    //                 'total_price' => $item->price * $item->quantity,
    //                 'color_name' => $variant ? $variant->color->name : null, // Lấy tên màu sắc
    //                 'capacity_name' => $variant ? $variant->capacity->name : null, // Lấy tên dung lượng
    //             ]);

    //             // Kiểm tra và giảm tồn kho
    //             if ($variant && $variant->stock < $item->quantity) {
    //                 return redirect()->back()->with('error', 'Số lượng sản phẩm trong kho không đủ.');
    //             }

    //             if ($variant) {
    //                 $variant->stock -= $item->quantity;
    //                 $variant->save();
    //             }
    //         }
    //     } else {
    //         // Lưu từ session
    //         foreach ($cartItems as $productId => $models) {
    //             if (is_array($models)) {
    //                 foreach ($models as $modelId => $colors) {
    //                     if (is_array($colors)) {
    //                         foreach ($colors as $colorId => $cartItem) {
    //                             $product = Product::find($productId);
    //                             $variant = ProductVariant::find($cartItem['variant_id']);

    //                             OrderItem::create([
    //                                 'order_id' => $order->id,
    //                                 'product_id' => $productId,
    //                                 'variant_id' => $cartItem['variant_id'],
    //                                 'name' => $product ? $product->name : 'Sản phẩm không xác định',
    //                                 'image_url' => $cartItem['image_url'],
    //                                 'quantity' => $cartItem['quantity'],
    //                                 'price' => $cartItem['price'],
    //                                 'total_price' => $cartItem['price'] * $cartItem['quantity'],
    //                                 'color_name' => $variant ? $variant->color->name : null, // Lấy tên màu sắc
    //                                 'capacity_name' => $variant ? $variant->capacity->name : null, // Lấy tên dung lượng
    //                             ]);

    //                             // Kiểm tra và giảm tồn kho
    //                             if ($variant && $variant->stock < $cartItem['quantity']) {
    //                                 return redirect()->back()->with('error', 'Số lượng sản phẩm trong kho không đủ.');
    //                             }

    //                             if ($variant) {
    //                                 $variant->stock -= $cartItem['quantity'];
    //                                 $variant->save();
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //     }
    //     OrderNotification::create([
    //         'order_id' => $order->id,
    //         'is_read' => false,
    //     ]);
    //     // Gửi email xác nhận đơn hàng
    //     Mail::to($request->email)->send(new OrderConfirmationMail($order));

    //     // Xóa giỏ hàng và voucher trong session
    //     if ($customerId) {
    //         Cart::where('customer_id', $customerId)->where('is_checked', true)->delete();
    //     } else {
    //         session()->forget('cart');
    //     }
    //     session()->forget('voucher');

    //     return redirect()->route('order.success')->with('success', 'Đặt hàng thành công!');
    // }
    public function storeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:COD,Online',
            'description' => 'nullable|string',
        ],[
            'name' => "Tên người nhận không được để trống",
            'phone' => "Số điện thoại không được để trống",
            'email' => "Email không được để trống",
            'address' => "Địa chỉ không được để trống",
        ]);

        $customerId = auth('customer')->check() ? auth('customer')->id() : null;

        // Lấy giỏ hàng từ session hoặc cơ sở dữ liệu tùy theo người dùng đã đăng nhập hay chưa
        $cartItems = [];
        if ($customerId) {
            // Người dùng đã đăng nhập, lấy giỏ hàng từ cơ sở dữ liệu
            $cartItems = Cart::where('customer_id', $customerId)->where('is_checked', true)->get();
            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống.');
            }
        } else {
            // Người dùng chưa đăng nhập, lấy giỏ hàng từ session
            $cartItems = session()->get('cart', []);
            $checkedItems = [];

            // Duyệt qua giỏ hàng để lọc các sản phẩm có is_checked = true
            foreach ($cartItems as $productId => $models) {
                foreach ($models as $modelId => $colors) {
                    foreach ($colors as $colorId => $item) {
                        if ($item['is_checked'] === true) {  // Kiểm tra điều kiện is_checked
                            $checkedItems[] = $item;  // Thêm sản phẩm vào mảng checkedItems
                        }
                    }
                }
            }

            $cartItems = $checkedItems;  // Gán lại giỏ hàng với các sản phẩm đã chọn
            if (empty($cartItems)) {
                return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống.');
            }
        }

        $voucher = session()->get('voucher', []);
        $totalPrice = 0;
        $totalQuantity = 0;

        // Tính toán tổng giá trị và số lượng sản phẩm trong giỏ hàng
        if ($customerId) {
            foreach ($cartItems as $item) {
                $totalPrice += $item->price * $item->quantity;
                $totalQuantity += $item->quantity;
            }
        } else {
            // Dữ liệu từ session
            foreach ($cartItems as $productId => $models) {
                if (is_array($models)) {
                    foreach ($models as $modelId => $colors) {
                        if (is_array($colors)) {
                            foreach ($colors as $colorId => $cartItem) {
                                if (isset($cartItem['price'], $cartItem['quantity'])) {
                                    $totalPrice += $cartItem['price'] * $cartItem['quantity'];
                                    $totalQuantity += $cartItem['quantity'];
                                } else {
                                    return redirect()->back()->with('error', 'Dữ liệu giỏ hàng không hợp lệ.');
                                }
                            }
                        }
                    }
                }
            }
        }

        // Áp dụng giảm giá từ voucher
        $discount = $voucher['discount'] ?? 0;
        $totalAfterDiscount = $totalPrice - $discount;

        // Tạo mã đơn hàng
        $orderCode = strtoupper(substr(uniqid(), -8));

        // Lấy voucher_id nếu có voucher
        $voucherId = null;
        if (isset($voucher['code'])) {
            $voucherModel = Voucher::where('code', $voucher['code'])->first();
            if ($voucherModel) {
                $voucherId = $voucherModel->id;
            }
        }

        // Lấy địa chỉ của người dùng đăng nhập hoặc từ form
        $address = $customerId
            ? Address::where('customer_id', $customerId)->where('is_default', 1)->first()
            : null;

        if (!$address && $customerId) {
            $address = Address::create([
                'customer_id' => $customerId,
                'name' => $request->name,
                'phone_number' => $request->phone,
                'address' => $request->address,
                'is_default' => 1,
            ]);
        }

        // Tạo đơn hàng
        $order = Order::create([
            'customer_id' => $customerId,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'total_price' => $totalAfterDiscount,
            'status' => $request->payment_method === 'COD' ? 'Chờ xác nhận' : 'Chờ thanh toán',
            'voucher_id' => $voucherId,
            'description' => $request->description,
            'order_code' => $orderCode,
        ]);

        if ($customerId) {
            foreach ($cartItems as $item) {
                $product = Product::find($item->product_id);
                $variant = ProductVariant::find($item->variant_id);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'name' => $product ? $product->name : 'Sản phẩm không xác định',
                    'image_url' => $product ? $product->image_url : null,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total_price' => $item->price * $item->quantity,
                    'color_name' => $variant ? $variant->color->name : null, 
                    'capacity_name' => $variant ? $variant->capacity->name : null, 
                ]);

                // Kiểm tra và giảm tồn kho
                if ($variant && $variant->stock < $item->quantity) {
                    return redirect()->back()->with('error', 'Số lượng sản phẩm trong kho không đủ.');
                }

                if ($variant) {
                    $variant->stock -= $item->quantity;
                    $variant->save();
                }
            }
        } else {
            foreach ($cartItems as $productId => $models) {
                if (is_array($models)) {
                    foreach ($models as $modelId => $colors) {
                        if (is_array($colors)) {
                            foreach ($colors as $colorId => $cartItem) {
                                $product = Product::find($productId);
                                $variant = ProductVariant::find($cartItem['variant_id']);

                                OrderItem::create([
                                    'order_id' => $order->id,
                                    'product_id' => $productId,
                                    'variant_id' => $cartItem['variant_id'],
                                    'name' => $product ? $product->name : 'Sản phẩm không xác định',
                                    'image_url' => $cartItem['image_url'],
                                    'quantity' => $cartItem['quantity'],
                                    'price' => $cartItem['price'],
                                    'total_price' => $cartItem['price'] * $cartItem['quantity'],
                                    'color_name' => $variant ? $variant->color->name : null, 
                                    'capacity_name' => $variant ? $variant->capacity->name : null, 
                                ]);

                                // Kiểm tra và giảm tồn kho
                                if ($variant && $variant->stock < $cartItem['quantity']) {
                                    return redirect()->back()->with('error', 'Số lượng sản phẩm trong kho không đủ.');
                                }

                                if ($variant) {
                                    $variant->stock -= $cartItem['quantity'];
                                    $variant->save();
                                }
                            }
                        }
                    }
                }
            }

        }

        // Lưu thông tin sử dụng voucher và giảm số lượng sử dụng
        if ($voucherId && $customerId) {
            $voucher = Voucher::find($voucherId);
            if ($voucher) {
                VoucherUsage::create([
                    'customer_id' => $customerId,
                    'voucher_id' => $voucherId,
                ]);
                
                $voucher->decrement('usage_limit');
                $voucher->save();
            }
        }

        OrderNotification::create([
            'order_id' => $order->id,
            'is_read' => false,
        ]);
        Mail::to($request->email)->send(new OrderConfirmationMail($order));

        if ($customerId) {
            Cart::where('customer_id', $customerId)->where('is_checked', true)->delete();
        } else {
            session()->forget('cart');
        }
        session()->forget('voucher');

        return redirect()->route('order.success')->with('success', 'Đặt hàng thành công!');
    }



    public function vnpay_payment(Request $request)
    {
        $data = $request->all();
        $voucher = session()->get('voucher', []);
        $customerId = auth('customer')->check() ? auth('customer')->id() : null;

        // Lấy giỏ hàng tùy theo người dùng đã đăng nhập hay chưa
        if ($customerId) {
            // Người dùng đã đăng nhập, lấy giỏ hàng từ cơ sở dữ liệu
            $cart = Cart::where('customer_id', $customerId)
                ->with(['product', 'variant'])
                ->where('is_checked', true)
                ->get()
                ->groupBy(['product_id', 'variant_id']);
        } else {
            // Người dùng chưa đăng nhập, lấy giỏ hàng từ session
            $cart = session()->get('cart', []);
        }

        // Tính toán tổng giá trị sau giảm giá
        $totalPrice = 0;
        if ($customerId) {
            foreach ($cart as $productId => $variants) {
                foreach ($variants as $variantId => $items) {
                    foreach ($items as $item) {
                        $totalPrice += $item->price * $item->quantity;
                    }
                }
            }
        } else {
            foreach ($cart as $productId => $models) {
                foreach ($models as $modelId => $colors) {
                    foreach ($colors as $colorId => $item) {
                        $totalPrice += $item['price'] * $item['quantity'];
                    }
                }
            }
        }

        $discount = $voucher['discount'] ?? 0;
        $totalAfterDiscount = $totalPrice - $discount;

        // Tạo mã đơn hàng
        $orderCode = strtoupper(substr(uniqid(), -8));
        $voucherId = isset($voucher['code']) ? Voucher::where('code', $voucher['code'])->first()->id : null;

        // Tạo đơn hàng với trạng thái "Chờ thanh toán"
        $order = Order::create([
            'customer_id' => $customerId,
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'address' => $data['address'],
            'payment_method' => 'Online',
            'total_price' => $totalAfterDiscount,
            'status' => 'Chờ thanh toán',
            'voucher_id' => $voucherId,
            'description' => $data['description'],
            'order_code' => $orderCode,
        ]);

        // Lưu sản phẩm trong đơn hàng
        if ($customerId) {
            // Người dùng đã đăng nhập, lưu từ cơ sở dữ liệu
            foreach ($cart as $productId => $variants) {
                foreach ($variants as $variantId => $items) {
                    foreach ($items as $item) {
                        $product = Product::find($item->product_id);
                        $variant = ProductVariant::find($variantId);

                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $productId,
                            'variant_id' => $variantId,
                            'name' => $product ? $product->name : 'Sản phẩm không xác định',
                            'image_url' => $product ? $product->image_url : null,
                            'quantity' => $item->quantity,
                            'price' => $item->price,
                            'total_price' => $item->price * $item->quantity,
                            'color_name' => $variant ? $variant->color->name : null,
                            'capacity_name' => $variant ? $variant->capacity->name : null,
                        ]);
                    }
                }
            }
        } else {
            // Người dùng chưa đăng nhập, lưu từ session
            foreach ($cart as $productId => $models) {
                foreach ($models as $modelId => $colors) {
                    foreach ($colors as $colorId => $item) {
                        $product = Product::find($productId);
                        $variant = ProductVariant::find($item['variant_id']);

                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $productId,
                            'variant_id' => $item['variant_id'],
                            'name' => $product ? $product->name : 'Sản phẩm không xác định',
                            'image_url' => $item['image_url'],
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                            'total_price' => $item['price'] * $item['quantity'],
                            'color_name' => $variant ? $variant->color->name : null,
                            'capacity_name' => $variant ? $variant->capacity->name : null,
                        ]);
                    }
                }
            }
        }

        // Chuẩn bị dữ liệu thanh toán VNPay
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_TmnCode = "1NHYTOPK";
        $vnp_HashSecret = "WG5VFJQLI1CKOU3OG34QXM884LLS7L45";
        $vnp_Amount = $totalAfterDiscount * 100;

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => "Thanh toán đơn hàng " . $orderCode,
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" => route('order.vnpay_callback'),
            "vnp_TxnRef" => $orderCode,
        ];

        ksort($inputData);
        $query = "";
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            $hashdata .= ($hashdata ? '&' : '') . urlencode($key) . "=" . urlencode($value);
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= '?' . $query . 'vnp_SecureHash=' . $vnpSecureHash;

        return redirect($vnp_Url);
    }

    public function vnpay_callback(Request $request)
    {
        $inputData = $request->all();
        $vnp_HashSecret = "WG5VFJQLI1CKOU3OG34QXM884LLS7L45"; // Mã secret của bạn
        $vnp_SecureHash = $inputData['vnp_SecureHash'];

        unset($inputData['vnp_SecureHash']); // Loại bỏ chữ ký từ dữ liệu gốc
        ksort($inputData); // Sắp xếp các tham số theo thứ tự alphabet

        // Tạo lại chuỗi hashdata
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        // Tạo chữ ký hash
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        }

        // Kiểm tra chữ ký
        if ($vnp_SecureHash === $vnpSecureHash) {
            // Nếu chữ ký hợp lệ, tiếp tục xử lý
            if (isset($inputData['vnp_ResponseCode']) && $inputData['vnp_ResponseCode'] == '00') {
                // Thanh toán thành công
                $order = Order::where('order_code', $inputData['vnp_TxnRef'])->first();
                if ($order) {
                    if ($order->status !== 'Chờ xác nhận') {
                        $order->status = 'Chờ xác nhận';
                        $order->additional_status = 'Đã thanh toán';
                        $order->payment_method = 'Thanh toán trực tuyến (VNPay)';
                        $order->payment_date = now();
                        $order->save();

                        // Giảm số lượng sản phẩm trong kho
                        foreach ($order->orderItems as $orderItem) {
                            $variant = ProductVariant::find($orderItem->variant_id);
                            if ($variant) {
                                $variant->stock -= $orderItem->quantity;
                                $variant->save();
                            }
                        }
                        if (auth('customer')->check()) {
                            Cart::where('customer_id', auth('customer')->id())->where('is_checked', true)->delete();
                        }
                        OrderNotification::create([
                            'order_id' => $order->id,
                            'is_read' => false,
                        ]);
                        // Gửi email xác nhận đơn hàng
                        Mail::to($order->email)->send(new OrderConfirmationMail($order));

                        // Xóa session giỏ hàng và mã giảm giá
                        session()->forget('cart');
                        session()->forget('voucher');

                        // Chuyển hướng về trang chủ với thông báo thành công
                        return redirect()->route('order.success')->with('success', 'Thanh toán thành công!');
                    }
                }
            } else {
                // Thanh toán thất bại - xóa đơn hàng
                $order = Order::where('order_code', $inputData['vnp_TxnRef'])->first();
                if ($order) {
                    $order->delete();
                }

                // Chuyển hướng về trang checkout với thông báo thất bại
                return redirect()->route('order.failure')->with('error', 'Thanh toán thất bại: ' . ($inputData['vnp_Message'] ?? 'Lỗi không xác định'));
            }
        } else {
            // Nếu chữ ký không hợp lệ
            return redirect()->route('order.failure')->with('error', 'Chữ ký không hợp lệ!');
        }
    }


    // thanh toán lai
    public function retryPayment($id)
    {
        $order = Order::findOrFail($id);

        // Kiểm tra trạng thái đơn hàng
        if ($order->status !== 'Thanh toán thất bại') {
            return redirect()->back()->with('error', 'Chỉ có thể thanh toán lại đơn hàng thất bại.');
        }

        // Tạo một đối tượng Request giả
        $request = new \Illuminate\Http\Request();
        $request->merge(['order_id' => $order->id]); // Thêm order_id vào request

        // Điều hướng đến hàm khởi tạo thanh toán VNPay
        return $this->initiatePayment($request);
    }

    public function initiatePayment(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        // Kiểm tra trạng thái đơn hàng
        if ($order->status !== 'Thanh toán thất bại') {
            return redirect()->back()->with('error', 'Chỉ có thể thanh toán lại đơn hàng thất bại.');
        }

        // Cấu hình VNPay
        $vnp_TmnCode = "1NHYTOPK"; // Mã website của bạn tại VNPay
        $vnp_HashSecret = "WG5VFJQLI1CKOU3OG34QXM884LLS7L45"; // Chuỗi bí mật dùng để mã hóa
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"; // URL thanh toán VNPay (sandbox hoặc production)
        $vnp_ReturnUrl = route('order.vnpay_callback'); // URL nhận kết quả thanh toán

        // Thông tin giao dịch
        $vnp_TxnRef = $order->id; // Mã đơn hàng
        $vnp_OrderInfo = "Thanh toán lại đơn hàng #{$order->order_code}";
        $vnp_Amount = $order->total_price * 100; // Số tiền (VNPay tính theo VND, nhân 100)
        $vnp_Locale = 'vn'; // Ngôn ngữ
        $vnp_IpAddr = request()->ip(); // Địa chỉ IP của người dùng

        // Tạo URL với các tham số cần thiết
        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        // Sắp xếp các tham số theo thứ tự alphabet
        ksort($inputData);

        // Tạo chuỗi dữ liệu để tạo chữ ký
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        // Tạo URL yêu cầu thanh toán VNPay
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html" . "?" . $query;

        // Tạo chữ ký an toàn cho yêu cầu
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);  // Tạo chữ ký
        $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;

        // Chuyển hướng người dùng đến VNPay
        return redirect()->to($vnp_Url); // Chuyển hướng đến VNPay thay vì trả về JSON
    }



    

    public function showCheckoutPage()
    {
        $vouchers = Voucher::where('start_date', '<=', now())
            ->where('usage_limit', '>', 0)
            ->get();

        return view('client.page.checkout.index', compact('vouchers'));
    }




    // voucher
    public function getVoucherByCode($code)
    {
        // Tìm voucher theo mã, có điều kiện voucher hợp lệ và còn lượt sử dụng
        return Voucher::where('code', $code)
                    ->where('start_date', '<=', now())  
                    ->where('end_date', '>=', now())  
                    ->where('usage_limit', '>', 0)  
                    ->first();  
    }


    public function applyVoucher(Request $request)
    {
        if (!auth('customer')->check()) {
            return redirect()->route('customer.login')->with('error', 'Bạn phải đăng nhập để sử dụng voucher.');
        }

        if ($request->has('selected_voucher')) {
            $voucher = $this->getVoucherByCode($request->selected_voucher);
        } elseif ($request->has('voucher_code')) {
            $voucher = $this->getVoucherByCode($request->voucher_code);
        } else {
            return redirect()->back()->with('error', 'Không có mã giảm giá được chọn.');
        }

        if (!$voucher) {
            return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn.');
        }

        // Tính tổng giá trị của các sản phẩm được chọn
        $cartTotal = $this->calculateCartTotal();
        
        if ($cartTotal < $voucher->min_order_value) {
            return redirect()->back()->with('error', 'Đơn hàng không đủ điều kiện áp dụng mã giảm giá.');
        }

        $customer = auth('customer')->user();
        $existingVoucherUsage = VoucherUsage::where('customer_id', $customer->id)
            ->where('voucher_id', $voucher->id)
            ->exists();

        if ($existingVoucherUsage) {
            return redirect()->back()->with('error', 'Bạn đã sử dụng mã giảm giá này rồi.');
        }

        // Tính số tiền giảm giá dựa trên tổng giá trị sản phẩm được chọn
        $discount = $cartTotal * ($voucher->discount_percentage / 100);

        // Kiểm tra và áp dụng giới hạn số tiền giảm tối đa
        if ($voucher->max_discount_amount > 0 && $discount > $voucher->max_discount_amount) {
            $discount = $voucher->max_discount_amount;
        }

        session()->put('voucher', [
            'code' => $voucher->code,
            'discount' => $discount,
        ]);

        $estimatedTotal = $cartTotal - $discount;

        return redirect()->route('checkout')->with([
            'success' => 'Mã giảm giá đã được áp dụng.',
            'discount' => number_format($discount, 0, ',', '.'),
            'totalPrice' => number_format($cartTotal, 0, ',', '.'),
            'estimatedTotal' => number_format($estimatedTotal, 0, ',', '.')
        ]);
    }





    private function calculateCartTotal()
    {
        $customerId = auth('customer')->check() ? auth('customer')->id() : null;
        $total = 0;

        if ($customerId) {
            // Nếu khách hàng đã đăng nhập, lấy dữ liệu giỏ hàng từ cơ sở dữ liệu
            $cartItems = Cart::where('customer_id', $customerId)
                ->where('is_checked', true) // Chỉ tính tổng cho các sản phẩm được chọn
                ->get();
            
            return $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });
        }

        // Nếu khách hàng chưa đăng nhập, lấy dữ liệu giỏ hàng từ session
        $cartItems = session()->get('cart', []);

        foreach ($cartItems as $productId => $models) {
            foreach ($models as $modelId => $colors) {
                foreach ($colors as $colorId => $cartItem) {
                    // Chỉ tính tổng cho các sản phẩm được chọn
                    if (isset($cartItem['is_checked']) && $cartItem['is_checked'] === true) {
                        $total += $cartItem['price'] * $cartItem['quantity'];
                    }
                }
            }
        }

        return $total;
    }





}