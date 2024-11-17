<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Voucher;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    
    public function index()
    {
        return view('client.page.checkout.index');
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

        // Tạo đơn hàng mới
        $order = Order::create([
            'user_id' => auth()->id(), // Lưu id người dùng đã đăng nhập
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'total_price' => $totalAfterDiscount,
            'status' => 'Chờ xác nhận', 
            'voucher_id' => $voucherId, // Lưu voucher_id nếu có
            'description' => $request->description,
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

        // Xóa giỏ hàng trong session sau khi đặt hàng
        session()->forget('cart');
        session()->forget('voucher');

        // Trả về thông báo thành công và chuyển đến trang thông báo
        return redirect()->route('home')->with('success', 'Đặt hàng thành công!');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
