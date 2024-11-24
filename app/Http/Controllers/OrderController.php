<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Voucher;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(10); 
        return view('admin.page.order.index', compact('orders'));
    }
    
    
    public function storeOrder(Request $request)
    {
        // Kiểm tra và xác thực dữ liệu từ form
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

        $voucherId = isset($voucher['code']) ? Voucher::where('code', $voucher['code'])->first()->id : null;

        $orderCode = strtoupper(substr(uniqid(), -8));

        // Kiểm tra khách đăng nhập hay không
        $customerId = auth('customer')->check() ? auth('customer')->id() : null;

        // Tạo đơn hàng mới
        $order = Order::create([
            'customer_id' => $customerId, // Lưu id người dùng đã đăng nhập
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'total_price' => $totalAfterDiscount,
            'status' => 'Chờ xác nhận',
            'voucher_id' => $voucherId,
            'description' => $request->description,
            'order_code' => $orderCode,
        ]);

        // Lưu các sản phẩm trong giỏ hàng vào bảng order_items
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

                    // Trừ số lượng sản phẩm trong kho
                    $variant = ProductVariant::find($variantId);
                    if ($variant) {
                        $variant->stock -= $item['quantity']; // Giảm số lượng của sản phẩm
                        $variant->save(); // Cập nhật số lượng còn lại trong kho
                    }
                }
            }
        }

        // Gửi email xác nhận đơn hàng
        Mail::to($request->email)->send(new OrderConfirmationMail($order));
        
        // Xóa giỏ hàng trong session sau khi đặt hàng
        session()->forget('cart');
        session()->forget('voucher');

        // Trả về thông báo thành công và chuyển đến trang thông báo
        return redirect()->route('order.success')->with('success', 'Đặt hàng thành công!');
    }

 

    
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

    public function show(string $id)
    {
        $order = Order::with(['orderItems.product', 'orderItems.variant'])->findOrFail($id);
        return view('admin.page.order.order_show', compact('order'));
    }


    // public function orderHistory(){
    //     return view('client.page.order.order_history');
    // }
    


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
