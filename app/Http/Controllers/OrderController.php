<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use App\Models\Voucher;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;

// class OrderController extends Controller
// {
//     public function index(Request $request)
//     {
//         $searchTerm = $request->input('search');

//         $orders = Order::orderBy('created_at', 'desc');

//         if ($searchTerm) {
//             $orders->where(function($query) use ($searchTerm) {
//                 $query->where('order_code', 'like', '%' . $searchTerm . '%')
//                     ->orWhere('name', 'like', '%' . $searchTerm . '%');
//             });
//         }

//         $orders = $orders->get();

//         // Nhóm đơn hàng theo trạng thái
//         $groupedOrders = [
//             'Tất cả' => $orders,
//             'Chờ xác nhận' => $orders->where('status', 'Chờ xác nhận'),
//             'Đã xác nhận' => $orders->where('status', 'Đã xác nhận'),
//             'Đang giao hàng' => $orders->where('status', 'Đang giao hàng'),
//             'Đã hoàn thành' => $orders->where('status', 'Đã hoàn thành'),
//             'Đã hủy' => $orders->where('status', 'Đã hủy'),
//         ];

//         // Tính số lượng đơn hàng cho từng trạng thái
//         $orderCounts = array_map(fn($orders) => $orders->count(), $groupedOrders);

//         return view('admin.page.order.index', compact('groupedOrders', 'orderCounts'));
//     }
    
//     // public function storeOrder(Request $request)
//     // {
        
//     //     $request->validate([
//     //         'name' => 'required|string|max:255',
//     //         'phone' => 'required|string|max:20',
//     //         'email' => 'required|email',
//     //         'address' => 'required|string|max:255',
//     //         'payment_method' => 'required|string|in:COD,Online',
//     //         'description' => 'nullable|string',
//     //     ]);

//     //     // Lấy giỏ hàng từ session
//     //     $cart = session()->get('cart', []);
//     //     $voucher = session()->get('voucher', []);
//     //     $totalPrice = 0;
//     //     $totalQuantity = 0;
        
//     //     // Tính tổng giá trị giỏ hàng và tổng số lượng sản phẩm
//     //     foreach ($cart as $productId => $models) {
//     //         foreach ($models as $modelId => $colors) {
//     //             foreach ($colors as $colorId => $item) {
//     //                 $totalPrice += $item['price'] * $item['quantity'];
//     //                 $totalQuantity += $item['quantity'];
//     //             }
//     //         }
//     //     }

//     //     $discount = $voucher['discount'] ?? 0;
//     //     $totalAfterDiscount = $totalPrice - $discount;

//     //     // Lấy voucher_id từ mã giảm giá
//     //     $voucherId = isset($voucher['code']) ? Voucher::where('code', $voucher['code'])->first()->id : null;
//     //     // Tự động tạo mã đơn hàng
//     //     $orderCode = strtoupper(substr(uniqid(), -8));

//     //     // Kiểm tra khách đăng nhập hay không
//     //     $customerId = auth('customer')->check() ? auth('customer')->id() : null;

//     //     // Nếu khách hàng đã đăng nhập, lấy địa chỉ mặc định
//     //     $address = null;
//     //     if ($customerId) {
//     //         $address = Address::where('customer_id', $customerId)
//     //                         ->where('is_default', 1)
//     //                         ->first();
//     //     }

//     //     // Nếu không có địa chỉ mặc định, lưu địa chỉ mới từ form nếu khách hàng đăng nhập
//     //     if (!$address && $customerId) {
//     //         $address = Address::create([
//     //             'customer_id' => $customerId,
//     //             'name' => $request->name,
//     //             'phone_number' => $request->phone,
//     //             'address' => $request->address,
//     //             'is_default' => 1, // Đặt địa chỉ này làm mặc định
//     //         ]);
//     //     }

//     //     if (!$customerId) {
//     //         $order = Order::create([
//     //             'customer_id' => null, 
//     //             'name' => $request->name,
//     //             'phone' => $request->phone,
//     //             'email' => $request->email,
//     //             'address' => $request->address,
//     //             'payment_method' => $request->payment_method,
//     //             'total_price' => $totalAfterDiscount,
//     //             'status' => 'Chờ xác nhận', 
//     //             'voucher_id' => $voucherId, 
//     //             'description' => $request->description,
//     //             'order_code' => $orderCode, 
//     //         ]);
//     //     } else {
//     //         $order = Order::create([
//     //             'customer_id' => $customerId,
//     //             'name' => $request->name,
//     //             'phone' => $request->phone,
//     //             'email' => $request->email,
//     //             'address' => $request->address,
//     //             'payment_method' => $request->payment_method,
//     //             'total_price' => $totalAfterDiscount,
//     //             'status' => 'Chờ xác nhận',
//     //             'voucher_id' => $voucherId,
//     //             'description' => $request->description,
//     //             'order_code' => $orderCode,
//     //         ]);
//     //     }

//     //     foreach ($cart as $productId => $models) {
//     //         foreach ($models as $modelId => $colors) {
//     //             foreach ($colors as $colorId => $item) {
//     //                 $variantId = $item['variant_id'];
        
//     //                 OrderItem::create([
//     //                     'order_id' => $order->id,
//     //                     'product_id' => $productId,
//     //                     'variant_id' => $variantId, 
//     //                     'quantity' => $item['quantity'],
//     //                     'price' => $item['price'],
//     //                     'total_price' => $item['price'] * $item['quantity'],
//     //                 ]);
        
//     //                 // Trừ số lượng tồn kho
//     //                 $variant = ProductVariant::find($variantId);
//     //                 if ($variant) {
//     //                     if ($variant->stock < $item['quantity']) {
//     //                         return redirect()->back()->with('error', 'Số lượng sản phẩm trong kho không đủ.');
//     //                     }
//     //                     $variant->stock -= $item['quantity'];
//     //                     $variant->save();
//     //                 }
//     //             }
//     //         }
//     //     }
        
        

//     //     Mail::to($request->email)->send(new OrderConfirmationMail($order));
        
//     //     // Xóa giỏ hàng trong session sau khi đặt hàng
//     //     session()->forget('cart');
//     //     session()->forget('voucher');

//     //     return redirect()->route('order.success')->with('success', 'Đặt hàng thành công!');
//     // }
    
//     public function updateStatus(Request $request, $id)
//     {
//         $validated = $request->validate([
//             'status' => 'required|in:Chờ xác nhận,Đã xác nhận,Đang giao hàng,Đã hoàn thành,Đã hủy',
//         ]);
//         $order = Order::findOrFail($id);
//         if ($request->status === 'Đã hủy' && $order->status !== 'Đã hủy') {
//             // Hoàn trả số lượng sản phẩm vào kho
//             foreach ($order->orderItems as $orderItem) {
//                 $variant = ProductVariant::find($orderItem->variant_id);
//                 if ($variant) {
//                     $variant->stock += $orderItem->quantity;
//                     $variant->save();
//                 }
//             }
//         }
//         // $order = Order::findOrFail($id);
//         $order->status = $request->status;
//         $order->save();

//         return redirect()->route('orders.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
//     }
   

//     // public function vnpay_payment(Request $request){
//     //     $data=$request->all();
//     //     $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
//     //     $vnp_Returnurl = "http://127.0.0.1:8000/";
//     //     $vnp_TmnCode = "1NHYTOPK";//Mã website tại VNPAY 
//     //     $vnp_HashSecret = "WG5VFJQLI1CKOU3OG34QXM884LLS7L45"; //Chuỗi bí mật
//     //     $orderCode = strtoupper(substr(uniqid(), -8));
//     //     $vnp_TxnRef = $orderCode; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này 
//     //     // sang VNPAY
//     //     $vnp_OrderInfo = 'Thanh toán đơn hàng test';
//     //     $vnp_OrderType = "billpayment";
//     //     $vnp_Amount = $data['total_price'] * 100;
//     //     $vnp_Locale = 'vn';
//     //     $vnp_BankCode = 'NCB';
//     //     $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        
//     //     // $fullName = trim($_POST['txt_billing_fullname']);
        
//     //     $inputData = array(
//     //         "vnp_Version" => "2.1.0",
//     //         "vnp_TmnCode" => $vnp_TmnCode,
//     //         "vnp_Amount" => $vnp_Amount,
//     //         "vnp_Command" => "pay",
//     //         "vnp_CreateDate" => date('YmdHis'),
//     //         "vnp_CurrCode" => "VND",
//     //         "vnp_IpAddr" => $vnp_IpAddr,
//     //         "vnp_Locale" => $vnp_Locale,
//     //         "vnp_OrderInfo" => $vnp_OrderInfo,
//     //         "vnp_OrderType" => $vnp_OrderType,
//     //         "vnp_ReturnUrl" => $vnp_Returnurl,
//     //         "vnp_TxnRef" => $vnp_TxnRef
//     //     );
        
//     //     if (isset($vnp_BankCode) && $vnp_BankCode != "") {
//     //         $inputData['vnp_BankCode'] = $vnp_BankCode;
//     //     }
//     //     if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
//     //         $inputData['vnp_Bill_State'] = $vnp_Bill_State;
//     //     }
        
//     //     //var_dump($inputData);
//     //     ksort($inputData);
//     //     $query = "";
//     //     $i = 0;
//     //     $hashdata = "";
//     //     foreach ($inputData as $key => $value) {
//     //         if ($i == 1) {
//     //             $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
//     //         } else {
//     //             $hashdata .= urlencode($key) . "=" . urlencode($value);
//     //             $i = 1;
//     //         }
//     //         $query .= urlencode($key) . "=" . urlencode($value) . '&';
//     //     }
        
//     //     $vnp_Url = $vnp_Url . "?" . $query;
//     //     if (isset($vnp_HashSecret)) {
//     //         $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
//     //         $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
//     //     }
//     //     $returnData = array('code' => '00'
//     //         , 'message' => 'success'
//     //         , 'data' => $vnp_Url);
//     //         if (isset($_POST['redirect'])) {
//     //             header('Location: ' . $vnp_Url);
//     //             die();
//     //         } else {
//     //             echo json_encode($returnData);
//     //         }
//     //         // vui lòng tham khảo thêm tại code demo

//     // }
//     // public function storeOrderVNPay(Request $request)
//     // {
//     //     $request->validate([
//     //         'name' => 'required|string|max:255',
//     //         'phone' => 'required|string|max:20',
//     //         'email' => 'required|email',
//     //         'address' => 'required|string|max:255',
//     //         'description' => 'nullable|string',
//     //     ]);

//     //     $cart = session()->get('cart', []);
//     //     $voucher = session()->get('voucher', []);
//     //     $totalPrice = 0;

//     //     foreach ($cart as $productId => $models) {
//     //         foreach ($models as $modelId => $colors) {
//     //             foreach ($colors as $colorId => $item) {
//     //                 $totalPrice += $item['price'] * $item['quantity'];
//     //             }
//     //         }
//     //     }

//     //     $discount = $voucher['discount'] ?? 0;
//     //     $totalAfterDiscount = $totalPrice - $discount;

//     //     $voucherId = isset($voucher['code']) ? Voucher::where('code', $voucher['code'])->first()->id : null;

//     //     $orderCode = strtoupper(substr(uniqid(), -8));
//     //     $customerId = auth('customer')->check() ? auth('customer')->id() : null;

//     //     $order = Order::create([
//     //         'customer_id' => $customerId,
//     //         'name' => $request->name,
//     //         'phone' => $request->phone,
//     //         'email' => $request->email,
//     //         'address' => $request->address,
//     //         'payment_method' => 'Online',
//     //         'total_price' => $totalAfterDiscount,
//     //         'status' => 'Chờ thanh toán', // Trạng thái tạm thời
//     //         'voucher_id' => $voucherId,
//     //         'description' => $request->description,
//     //         'order_code' => $orderCode,
//     //     ]);

//     //     foreach ($cart as $productId => $models) {
//     //         foreach ($models as $modelId => $colors) {
//     //             foreach ($colors as $colorId => $item) {
//     //                 $variantId = $item['variant_id'];

//     //                 OrderItem::create([
//     //                     'order_id' => $order->id,
//     //                     'product_id' => $productId,
//     //                     'variant_id' => $variantId,
//     //                     'quantity' => $item['quantity'],
//     //                     'price' => $item['price'],
//     //                     'total_price' => $item['price'] * $item['quantity'],
//     //                 ]);
//     //             }
//     //         }
//     //     }

//     //     // Chuyển hướng tới VNPay
//     //     return $this->redirectVNPay($order->id, $totalAfterDiscount);
//     // }

//     // protected function redirectVNPay($orderId, $amount)
//     // {
//     //     $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
//     //     $vnp_TmnCode = "1NHYTOPK";
//     //     $vnp_HashSecret = "WG5VFJQLI1CKOU3OG34QXM884LLS7L45";
//     //     $vnp_Returnurl = route('vnpay.callback');

//     //     $vnp_TxnRef = strtoupper(substr(uniqid(), -8)); 
//     //     $vnp_OrderInfo = "Thanh toán đơn hàng #" . $orderId;
//     //     $vnp_Amount = $amount * 100;

//     //     $inputData = [
//     //         "vnp_Version" => "2.1.0",
//     //         "vnp_TmnCode" => $vnp_TmnCode,
//     //         "vnp_Amount" => $vnp_Amount,
//     //         "vnp_Command" => "pay",
//     //         "vnp_CreateDate" => date('YmdHis'),
//     //         "vnp_CurrCode" => "VND",
//     //         "vnp_IpAddr" => request()->ip(),
//     //         "vnp_Locale" => 'vn',
//     //         "vnp_OrderInfo" => $vnp_OrderInfo,
//     //         "vnp_OrderType" => "billpayment",
//     //         "vnp_ReturnUrl" => $vnp_Returnurl,
//     //         "vnp_TxnRef" => $vnp_TxnRef,
//     //     ];

//     //     ksort($inputData);
//     //     $query = http_build_query($inputData);
//     //     $vnp_Url = $vnp_Url . "?" . $query;

//     //     if ($vnp_HashSecret) {
//     //         $vnpSecureHash = hash_hmac('sha512', urldecode($query), $vnp_HashSecret);
//     //         $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;
//     //     }

//     //     return redirect($vnp_Url);
//     // }

//     // public function processPayment(Request $request)
//     // {
//     //     // Tạo đơn hàng tạm thời
//     //     $order = Order::create([
//     //         'customer_id' => auth('customer')->id(),
//     //         'name' => $request->name,
//     //         'phone' => $request->phone,
//     //         'email' => $request->email,
//     //         'address' => $request->address,
//     //         'payment_method' => 'Online',
//     //         'total_price' => $request->total_price,
//     //         'status' => 'Chờ thanh toán', // Trạng thái tạm thời
//     //         'order_code' => strtoupper(substr(uniqid(), -8)),
//     //     ]);
    
//     //     // Gọi hàm xử lý thanh toán VNPay
//     //     return $this->redirectVNPay($order->id, $order->total_price);
//     // }
    
    

//     public function show(string $id)
//     {
//         $order = Order::with(['orderItems.product', 'orderItems.variant'])->findOrFail($id);
//         return view('admin.page.order.order_show', compact('order'));
//     }



//     // public function storeOrder(Request $request)
//     // {
//     //     $request->validate([
//     //         'name' => 'required|string|max:255',
//     //         'phone' => 'required|string|max:20',
//     //         'email' => 'required|email',
//     //         'address' => 'required|string|max:255',
//     //         'payment_method' => 'required|string|in:COD,Online',
//     //         'description' => 'nullable|string',
//     //     ]);

//     //     $cart = session()->get('cart', []);
//     //     $voucher = session()->get('voucher', []);
//     //     $totalPrice = 0;
//     //     $totalQuantity = 0;

//     //     foreach ($cart as $productId => $models) {
//     //         foreach ($models as $modelId => $colors) {
//     //             foreach ($colors as $colorId => $item) {
//     //                 $totalPrice += $item['price'] * $item['quantity'];
//     //                 $totalQuantity += $item['quantity'];
//     //             }
//     //         }
//     //     }

//     //     $discount = $voucher['discount'] ?? 0;
//     //     $totalAfterDiscount = $totalPrice - $discount;
//     //     $voucherId = isset($voucher['code']) ? Voucher::where('code', $voucher['code'])->first()->id : null;
//     //     $orderCode = strtoupper(substr(uniqid(), -8));
//     //     $customerId = auth('customer')->check() ? auth('customer')->id() : null;

//     //     // Tạo địa chỉ mới nếu cần thiết
//     //     if (!$customerId) {
//     //         $orderAddress = $request->address;
//     //     } else {
//     //         $address = Address::where('customer_id', $customerId)->where('is_default', 1)->first();
//     //         if (!$address) {
//     //             $address = Address::create([
//     //                 'customer_id' => $customerId,
//     //                 'name' => $request->name,
//     //                 'phone_number' => $request->phone,
//     //                 'address' => $request->address,
//     //                 'is_default' => 1,
//     //             ]);
//     //         }
//     //         $orderAddress = $address->address;
//     //     }

//     //     $order = Order::create([
//     //         'customer_id' => $customerId,
//     //         'name' => $request->name,
//     //         'phone' => $request->phone,
//     //         'email' => $request->email,
//     //         'address' => $orderAddress,
//     //         'payment_method' => $request->payment_method,
//     //         'total_price' => $totalAfterDiscount,
//     //         'status' => $request->payment_method === 'Online' ? 'Chờ thanh toán' : 'Chờ xác nhận',
//     //         'voucher_id' => $voucherId,
//     //         'description' => $request->description,
//     //         'order_code' => $orderCode,
//     //     ]);

//     //     foreach ($cart as $productId => $models) {
//     //         foreach ($models as $modelId => $colors) {
//     //             foreach ($colors as $colorId => $item) {
//     //                 OrderItem::create([
//     //                     'order_id' => $order->id,
//     //                     'product_id' => $productId,
//     //                     'variant_id' => $item['variant_id'],
//     //                     'quantity' => $item['quantity'],
//     //                     'price' => $item['price'],
//     //                     'total_price' => $item['price'] * $item['quantity'],
//     //                 ]);
//     //             }
//     //         }
//     //     }

//     //     // Xóa giỏ hàng khỏi session
//     //     session()->forget('cart');
//     //     session()->forget('voucher');

//     //     // Nếu thanh toán bằng VNPay, chuyển hướng đến cổng thanh toán
//     //     if ($request->payment_method === 'Online') {
//     //         return $this->vnpay_payment($order); // Đảm bảo truyền $order
//     //     }

//     //     Mail::to($request->email)->send(new OrderConfirmationMail($order));
//     //     return redirect()->route('order.success')->with('success', 'Đặt hàng thành công!');
//     // }


//     // public function vnpay_payment($order)
//     // {
//     //     $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
//     //     $vnp_Returnurl = route('checkout'); // URL trả về sau thanh toán
//     //     $vnp_TmnCode = "1NHYTOPK"; // Mã website tại VNPay
//     //     $vnp_HashSecret = "WG5VFJQLI1CKOU3OG34QXM884LLS7L45"; // Chuỗi bí mật

//     //     $vnp_TxnRef = $order->order_code;
//     //     $vnp_OrderInfo = 'Thanh toán đơn hàng #' . $order->order_code;
//     //     $vnp_OrderType = 'billpayment';
//     //     $vnp_Amount = $order->total_price * 100; // Tính bằng đơn vị VNĐ x100
//     //     $vnp_Locale = 'vn';
//     //     $vnp_IpAddr = request()->ip();

//     //     $inputData = [
//     //         "vnp_Version" => "2.1.0",
//     //         "vnp_TmnCode" => $vnp_TmnCode,
//     //         "vnp_Amount" => $vnp_Amount,
//     //         "vnp_Command" => "pay",
//     //         "vnp_CreateDate" => date('YmdHis'),
//     //         "vnp_CurrCode" => "VND",
//     //         "vnp_IpAddr" => $vnp_IpAddr,
//     //         "vnp_Locale" => $vnp_Locale,
//     //         "vnp_OrderInfo" => $vnp_OrderInfo,
//     //         "vnp_OrderType" => $vnp_OrderType,
//     //         "vnp_ReturnUrl" => $vnp_Returnurl,
//     //         "vnp_TxnRef" => $vnp_TxnRef,
//     //     ];

//     //     ksort($inputData);
//     //     $query = "";
//     //     $hashdata = "";
//     //     foreach ($inputData as $key => $value) {
//     //         $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
//     //         $query .= urlencode($key) . "=" . urlencode($value) . '&';
//     //     }
//     //     $hashdata = ltrim($hashdata, '&');
//     //     $query = rtrim($query, '&');

//     //     $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
//     //     $vnp_Url = $vnp_Url . "?" . $query . '&vnp_SecureHash=' . $vnpSecureHash;

//     //     return redirect($vnp_Url);
//     // }






//     public function orderHistory(){
//         return view('client.page.order.order_history');
//     }
    


//     public function create()
//     {
//         //
//     }

//     public function store(Request $request)
//     {
//         //
//     }
//     public function edit(string $id)
//     {
//         //
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, string $id)
//     {
//         //
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(string $id)
//     {
//         //
//     }
// }










class OrderController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        $orders = Order::orderBy('created_at', 'desc');

        if ($searchTerm) {
            $orders->where(function($query) use ($searchTerm) {
                $query->where('order_code', 'like', '%' . $searchTerm . '%')
                    ->orWhere('name', 'like', '%' . $searchTerm . '%');
            });
        }

        $orders = $orders->get();

        // Nhóm đơn hàng theo trạng thái
        $groupedOrders = [
            'Tất cả' => $orders,
            'Chờ xác nhận' => $orders->where('status', 'Chờ xác nhận'),
            'Đã xác nhận' => $orders->where('status', 'Đã xác nhận'),
            'Đang giao hàng' => $orders->where('status', 'Đang giao hàng'),
            'Đã hoàn thành' => $orders->where('status', 'Đã hoàn thành'),
            'Đã hủy' => $orders->where('status', 'Đã hủy'),
            'Thanh toán thất bại' => $orders->where('status', 'Thanh toán thất bại'),
        ];

        // Tính số lượng đơn hàng cho từng trạng thái
        $orderCounts = array_map(fn($orders) => $orders->count(), $groupedOrders);

        return view('admin.page.order.index', compact('groupedOrders', 'orderCounts'));
    }
    // Hàm tạo đơn hàng
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Chờ xác nhận,Đã xác nhận,Đang giao hàng,Đã hoàn thành,Đã hủy',
        ]);
        $order = Order::findOrFail($id);
        if ($request->status === 'Đã hủy' && $order->status !== 'Đã hủy') {
            // Hoàn trả số lượng sản phẩm vào kho
            foreach ($order->orderItems as $orderItem) {
                $variant = ProductVariant::find($orderItem->variant_id);
                if ($variant) {
                    $variant->stock += $orderItem->quantity;
                    $variant->save();
                }
            }
        }
        // $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
    public function show(string $id)
    {
        $order = Order::with(['orderItems.product', 'orderItems.variant'])->findOrFail($id);
        return view('admin.page.order.order_show', compact('order'));
    }
    public function storeOrder(Request $request)
    {
        // Validate dữ liệu yêu cầu
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:COD,Online',
            'description' => 'nullable|string',
        ]);

        // Lấy thông tin giỏ hàng và voucher từ session
        $cart = session()->get('cart', []);
        $voucher = session()->get('voucher', []);
        $totalPrice = 0;
        $totalQuantity = 0;

        // Tính toán tổng giá trị và số lượng sản phẩm trong giỏ hàng
        foreach ($cart as $productId => $models) {
            foreach ($models as $modelId => $colors) {
                foreach ($colors as $colorId => $item) {
                    $totalPrice += $item['price'] * $item['quantity'];
                    $totalQuantity += $item['quantity'];
                }
            }
        }

        // Áp dụng giảm giá từ voucher
        $discount = $voucher['discount'] ?? 0;
        $totalAfterDiscount = $totalPrice - $discount;

        // Tạo mã đơn hàng
        $orderCode = strtoupper(substr(uniqid(), -8));

        // Lấy id voucher và customer_id nếu có đăng nhập
        $voucherId = isset($voucher['code']) ? Voucher::where('code', $voucher['code'])->first()->id : null;
        $customerId = auth('customer')->check() ? auth('customer')->id() : null;

        // Nếu người dùng đã đăng nhập, lấy địa chỉ mặc định
        $address = $customerId ? Address::where('customer_id', $customerId)->where('is_default', 1)->first() : null;
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

        // Lưu các sản phẩm trong đơn hàng
        foreach ($cart as $productId => $models) {
            foreach ($models as $modelId => $colors) {
                foreach ($colors as $colorId => $item) {
                    $variantId = $item['variant_id'];
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $productId,
                        'variant_id' => $variantId,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'total_price' => $item['price'] * $item['quantity'],
                    ]);

                    // Kiểm tra và giảm số lượng tồn kho
                    $variant = ProductVariant::find($variantId);
                    if ($variant && $variant->stock < $item['quantity']) {
                        return redirect()->back()->with('error', 'Số lượng sản phẩm trong kho không đủ.');
                    }

                    if ($variant) {
                        $variant->stock -= $item['quantity'];
                        $variant->save();
                    }
                }
            }
        }

        // Gửi email xác nhận đơn hàng
        Mail::to($request->email)->send(new OrderConfirmationMail($order));

        // Xóa giỏ hàng và voucher
        session()->forget('cart');
        session()->forget('voucher');

        return redirect()->route('order.success')->with('success', 'Đặt hàng thành công!');
    }

    // Hàm thanh toán VNPay
    public function vnpay_payment(Request $request)
    {
        $data = $request->all();
        $cart = session()->get('cart', []);
        $voucher = session()->get('voucher', []);

        // Tính toán tổng giá trị sau giảm giá
        $totalPrice = 0;
        foreach ($cart as $productId => $models) {
            foreach ($models as $modelId => $colors) {
                foreach ($colors as $colorId => $item) {
                    $totalPrice += $item['price'] * $item['quantity'];
                }
            }
        }
        $discount = $voucher['discount'] ?? 0;
        $totalAfterDiscount = $totalPrice - $discount;

        // Tạo mã đơn hàng
        $orderCode = strtoupper(substr(uniqid(), -8));
        $voucherId = isset($voucher['code']) ? Voucher::where('code', $voucher['code'])->first()->id : null;
        $customerId = auth('customer')->check() ? auth('customer')->id() : null;

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
        foreach ($cart as $productId => $models) {
            foreach ($models as $modelId => $colors) {
                foreach ($colors as $colorId => $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $productId,
                        'variant_id' => $item['variant_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'total_price' => $item['price'] * $item['quantity'],
                    ]);
                }
            }
        }

        // Chuẩn bị dữ liệu thanh toán VNPay
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_TmnCode = "1NHYTOPK";
        $vnp_HashSecret = "WG5VFJQLI1CKOU3OG34QXM884LLS7L45";
        $vnp_Amount = $totalAfterDiscount * 100; // VNPay yêu cầu số tiền tính bằng VND * 100

        // Tạo dữ liệu đầu vào cho VNPay
        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => "1NHYTOPK", // Mã của bạn trên VNPay
            "vnp_Amount" => $vnp_Amount, // Số tiền thanh toán (lưu ý: VNPay yêu cầu đơn vị là VND * 100)
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
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);  // Tạo chữ ký
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        // Trả về URL hoặc chuyển hướng người dùng
        $returnData = array(
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        );

        // Chuyển hướng người dùng đến VNPay
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }

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
                        $order->payment_method = 'VNPay';
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
                // Thanh toán thất bại
                $order = Order::where('order_code', $inputData['vnp_TxnRef'])->first();
                if ($order) {
                    // Cập nhật trạng thái đơn hàng là "Thanh toán thất bại"
                    $order->status = 'Thanh toán thất bại';
                    $order->payment_method = 'VNPay';
                    $order->payment_date = null; // Không có ngày thanh toán
                    $order->save();
                }

                // Chuyển hướng về trang checkout với thông báo thất bại
                return redirect()->route('order.failure')->with('error', 'Thanh toán thất bại: ' . ($inputData['vnp_Message'] ?? 'Lỗi không xác định'));
            }
        } else {
            // Nếu chữ ký không hợp lệ
            return redirect()->route('order.failure')->with('error', 'Chữ ký không hợp lệ!');
        }
    }

    
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

        // VNPay Configuration
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


    


    // public function vnpay_callback(Request $request)
    // {
    //     $inputData = $request->all();
    //     $vnp_HashSecret = "WG5VFJQLI1CKOU3OG34QXM884LLS7L45"; // Mã secret của bạn
    //     $vnp_SecureHash = $inputData['vnp_SecureHash'];

    //     unset($inputData['vnp_SecureHash']); // Loại bỏ chữ ký từ dữ liệu gốc
    //     ksort($inputData); // Sắp xếp các tham số theo thứ tự alphabet

    //     // Tạo lại chuỗi hashdata
    //     $query = "";
    //     $i = 0;
    //     $hashdata = "";
    //     foreach ($inputData as $key => $value) {
    //         if ($i == 1) {
    //             $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    //         } else {
    //             $hashdata .= urlencode($key) . "=" . urlencode($value);
    //             $i = 1;
    //         }
    //         $query .= urlencode($key) . "=" . urlencode($value) . '&';
    //     }

    //     // Tạo chữ ký hash
    //     if (isset($vnp_HashSecret)) {
    //         $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    //     }

    //     // Kiểm tra chữ ký
    //     if ($vnp_SecureHash === $vnpSecureHash) {
    //         // Nếu chữ ký hợp lệ, tiếp tục xử lý
    //         if (isset($inputData['vnp_ResponseCode']) && $inputData['vnp_ResponseCode'] == '00') {
    //             // Thanh toán thành công
    //             $order = Order::where('order_code', $inputData['vnp_TxnRef'])->first();
    //             if ($order) {
    //                 if ($order->status !== 'Chờ xác nhận') {
    //                     $order->status = 'Chờ xác nhận';
    //                     $order->additional_status = 'Đã thanh toán';
    //                     $order->payment_method = 'VNPay';
    //                     $order->payment_date = now();
    //                     $order->save();

    //                     // Xóa session giỏ hàng và mã giảm giá
    //                     session()->forget('cart');
    //                     session()->forget('voucher');

    //                     // Chuyển hướng về trang chủ với thông báo thành công
    //                     return redirect()->route('home')->with('success', 'Thanh toán thành công!');
    //                 }
    //             }
    //         } else {
    //             // Thanh toán thất bại
    //             $order = Order::where('order_code', $inputData['vnp_TxnRef'])->first();
    //             if ($order) {
    //                 // Cập nhật trạng thái đơn hàng là "Chờ thanh toán"
    //                 $order->status = 'Chờ thanh toán';
    //                 $order->payment_method = 'VNPay';
    //                 $order->payment_date = null; // Không có ngày thanh toán
    //                 $order->save();
    //             }

    //             // Chuyển hướng về trang checkout với thông báo thất bại
    //             return redirect()->route('checkout')->with('error', 'Thanh toán thất bại: ' . ($inputData['vnp_Message'] ?? 'Lỗi không xác định'));
    //         }
    //     } else {
    //         // Nếu chữ ký không hợp lệ
    //         return redirect()->route('checkout')->with('error', 'Chữ ký không hợp lệ!');
    //     }
    // }
    



    
}
