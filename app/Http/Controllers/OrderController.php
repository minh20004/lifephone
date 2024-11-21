<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Voucher;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(10); // Lấy tất cả đơn hàng, sắp xếp theo ngày tạo mới nhất
        return view('admin.page.order.index', compact('orders'));
    }
    
    public function storeOrder(Request $request)
    {
        // Validate dữ liệu từ form
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:COD,Online',
            'description' => 'nullable|string',
        ]);

        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);
        $voucher = session()->get('voucher', []);
        $totalPrice = 0;
        $totalQuantity = 0;
        
        // Tính tổng giá trị giỏ hàng và tổng số lượng sản phẩm
        foreach ($cart as $productId => $models) {
            foreach ($models as $modelId => $colors) {
                foreach ($colors as $colorId => $item) {
                    $totalPrice += $item['price'] * $item['quantity'];
                    $totalQuantity += $item['quantity'];
                }
            }
        }

        // Áp dụng voucher nếu có
        $discount = $voucher['discount'] ?? 0;
        $totalAfterDiscount = $totalPrice - $discount;

        // Lấy voucher_id từ mã giảm giá
        $voucherId = isset($voucher['code']) ? Voucher::where('code', $voucher['code'])->first()->id : null;

         // Tạo mã đơn hàng tự động
        $orderCode = strtoupper(substr(uniqid(), -8));

        // Tạo đơn hàng mới
        $order = Order::create([
            // 'user_id' => auth()->id(), // Lưu id người dùng đã đăng nhập
            'user_id' => 1, // Lưu id người dùng đã đăng nhập
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'total_price' => $totalAfterDiscount,
            'status' => 'Chờ xác nhận', 
            'voucher_id' => $voucherId, 
            'description' => $request->description,
            'order_code' => $orderCode, // Lưu mã đơn hàng
        ]);

        // Lưu các sản phẩm trong giỏ hàng vào order_items
        foreach ($cart as $productId => $models) {
            foreach ($models as $modelId => $colors) {
                foreach ($colors as $colorId => $item) {
                    $variantId = $item['variant_id'];
                    // Tạo OrderItem cho mỗi sản phẩm trong giỏ hàng
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $productId,
                        'variant_id' => $variantId, // Lưu thông tin biến thể ở đây
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'total_price' => $item['price'] * $item['quantity'],
                    ]);
                }
            }
        }

        Mail::to($request->email)->send(new OrderConfirmationMail($order));
        
        // Xóa giỏ hàng trong session sau khi đặt hàng
        session()->forget('cart');
        session()->forget('voucher');

        // Trả về thông báo thành công và chuyển đến trang thông báo
        return redirect()->route('order.success')->with('success', 'Đặt hàng thành công!');
    }
    // tự động lấy địa chỉ khách hàng
    // public function storeOrder(Request $request)
    // {
    //     // Kiểm tra xem người dùng đã đăng nhập chưa
    //     $user = auth()->user();

    //     // Nếu người dùng đã đăng nhập, lấy địa chỉ từ tài khoản
    //     $userAddress = $user ? $user->address : null;

    //     // Validate dữ liệu từ form
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'phone' => 'required|string|max:20',
    //         'email' => 'required|email',
    //         'address' => $userAddress ? 'nullable|string|max:255' : 'required|string|max:255',
    //         'payment_method' => 'required|string|in:COD,Online',
    //         'description' => 'nullable|string',
    //     ]);

    //     // Lấy giỏ hàng từ session
    //     $cart = session()->get('cart', []);
    //     $voucher = session()->get('voucher', []);
    //     $totalPrice = 0;
    //     $totalQuantity = 0;

    //     // Tính tổng giá trị giỏ hàng và tổng số lượng sản phẩm
    //     foreach ($cart as $productId => $models) {
    //         foreach ($models as $modelId => $colors) {
    //             foreach ($colors as $colorId => $item) {
    //                 $totalPrice += $item['price'] * $item['quantity'];
    //                 $totalQuantity += $item['quantity'];
    //             }
    //         }
    //     }

    //     // Áp dụng voucher nếu có
    //     $discount = $voucher['discount'] ?? 0;
    //     $totalAfterDiscount = $totalPrice - $discount;

    //     // Lấy voucher_id từ mã giảm giá
    //     $voucherRecord = isset($voucher['code']) ? Voucher::where('code', $voucher['code'])->first() : null;
    //     $voucherId = $voucherRecord ? $voucherRecord->id : null;

    //     // Tạo mã đơn hàng tự động
    //     $orderCode = strtoupper(substr(uniqid(), -8));

    //     // Tạo đơn hàng mới
    //     $order = Order::create([
    //         'user_id' => $user ? $user->id : null,
    //         'name' => $request->name,
    //         'phone' => $request->phone,
    //         'email' => $request->email,
    //         'address' => $userAddress ?? $request->address, // Sử dụng địa chỉ người dùng hoặc địa chỉ từ form
    //         'payment_method' => $request->payment_method,
    //         'total_price' => $totalAfterDiscount,
    //         'status' => 'Chờ xác nhận',
    //         'voucher_id' => $voucherId,
    //         'description' => $request->description,
    //         'order_code' => $orderCode,
    //     ]);

    //     // Lưu các sản phẩm trong giỏ hàng vào order_items
    //     foreach ($cart as $productId => $models) {
    //         foreach ($models as $modelId => $colors) {
    //             foreach ($colors as $colorId => $item) {
    //                 $variantId = $item['variant_id'];
    //                 OrderItem::create([
    //                     'order_id' => $order->id,
    //                     'product_id' => $productId,
    //                     'variant_id' => $variantId,
    //                     'quantity' => $item['quantity'],
    //                     'price' => $item['price'],
    //                     'total_price' => $item['price'] * $item['quantity'],
    //                 ]);
    //             }
    //         }
    //     }

    //     // Gửi email xác nhận
    //     try {
    //         Mail::to($request->email)->send(new OrderConfirmationMail($order));
    //     } catch (\Exception $e) {
    //         return redirect()->route('order.success')->with('warning', 'Đặt hàng thành công, nhưng không thể gửi email xác nhận.');
    //     }

    //     // Xóa giỏ hàng trong session sau khi đặt hàng
    //     session()->forget('cart');
    //     session()->forget('voucher');

    //     // Trả về thông báo thành công
    //     return redirect()->route('order.success')->with('success', 'Đặt hàng thành công!');
    // }
 




    
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Chờ xác nhận,Đã xác nhận,Đang giao hàng,Đã hoàn thành,Đã hủy',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }


    

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        $order = Order::with(['orderItems.product', 'orderItems.variant'])->findOrFail($id);
        return view('admin.page.order.order_show', compact('order'));
    }


    public function orderHistory(){
        return view('client.page.order.order_history');
    }

    public function edit(string $id)
    {
        //
    }

    

    
    public function destroy(string $id)
    {
        //
    }
}
