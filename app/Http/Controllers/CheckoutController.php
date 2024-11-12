<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    
    public function index()
    {
        return view('client.page.checkout.index');
    }

    
    public function create()
    {
        //
    }

    
    // public function store(Request $request)
    // {
    //     //
    // }
    // public function placeOrder(Request $request)
    // {
    //     // Validate the incoming request data
    //     $request->validate([
    //         'shipping_name' => 'required|string|max:255',
    //         'shipping_phone' => 'required|string|max:15',
    //         'shipping_email' => 'required|email',
    //         'shipping_address' => 'required|string|max:500',
    //         'shipping_method' => 'required|string',
    //         'payment_method' => 'required|string',
    //         'total_price' => 'required|numeric',
    //         'shipping_cost' => 'required|numeric',
    //         'voucher_id' => 'nullable|exists:vouchers,id', // Assuming you have a vouchers table
    //     ]);

    //     // Step 1: Create the order in the `orders` table
    //     $order = new Order();
    //     $order->user_id = Auth::id(); // Assuming the user is logged in
    //     $order->name = $request->shipping_name;
    //     $order->phone = $request->shipping_phone;
    //     $order->email = $request->shipping_email;
    //     $order->address = $request->shipping_address;
    //     $order->shipping_method = $request->shipping_method;
    //     $order->payment_method = $request->payment_method;
    //     $order->shipping_fee = $request->shipping_cost;
    //     $order->total_price = $request->total_price;
    //     $order->status = 'Chờ xác nhận'; // Default status
    //     $order->voucher_id = $request->voucher_id;
    //     $order->save();

    //     // Step 2: Store order items in the `order_items` table
    //     $cart = session('cart'); // Assuming you store the cart in session
    //     foreach ($cart as $cartItem) {
    //         foreach ($cartItem['items'] as $item) {
    //             OrderItem::create([
    //                 'order_id' => $order->id,
    //                 'product_id' => $item['product_id'],
    //                 'variant_id' => $item['variant_id'],
    //                 'quantity' => $item['quantity'],
    //                 'price' => $item['price'],
    //             ]);
    //         }
    //     }

    //     // Step 3: Clear the cart after order is placed
    //     session()->forget('cart');

    //     // Step 4: Redirect to the confirmation page (optional)
    //     return redirect()->route('order.confirmation', ['order' => $order->id]);
    // }
    // public function orderConfirmation($orderId)
    // {
    //     // Lấy thông tin đơn hàng từ cơ sở dữ liệu
    //     $order = Order::with('orderItems.product')->findOrFail($orderId);

    //     // Trả về view xác nhận đơn hàng
    //     return view('checkout.confirmation', compact('order'));
    // }
    // public function placeOrder(Request $request)
    // {
    //     // Validate the incoming request data
    //     $request->validate([
    //         'shipping_name' => 'required|string|max:255',
    //         'shipping_phone' => 'required|string|max:15',
    //         'shipping_email' => 'required|email',
    //         'shipping_address' => 'required|string|max:500',
    //         'shipping_method' => 'required|string',
    //         'payment_method' => 'required|string',
    //         'total_price' => 'required|numeric',
    //         'shipping_cost' => 'required|numeric',
    //         'voucher_id' => 'nullable|exists:vouchers,id', // Nếu bạn sử dụng voucher
    //     ]);

    //     // Tính tổng giá trị nếu có voucher (nếu voucher được áp dụng)
    //     $voucher = null;
    //     $discount = 0;
    //     if ($request->voucher_id) {
    //         $voucher = Voucher::find($request->voucher_id);
    //         $discount = $voucher->discount ?? 0; // Nếu có giảm giá
    //     }

    //     // Tính toán giá trị đơn hàng sau khi giảm giá (nếu có)
    //     $totalPrice = $request->total_price - $discount;

    //     // Step 1: Tạo đơn hàng trong bảng `orders`
    //     $order = Order::create([
    //         'user_id' => Auth::id(), // Nếu người dùng đã đăng nhập
    //         'name' => $request->shipping_name,
    //         'phone' => $request->shipping_phone,
    //         'email' => $request->shipping_email,
    //         'address' => $request->shipping_address,
    //         'shipping_method' => $request->shipping_method,
    //         'payment_method' => $request->payment_method,
    //         'shipping_fee' => $request->shipping_cost,
    //         'total_price' => $totalPrice, // Tổng giá đã tính toán
    //         'status' => 'Chờ xác nhận', // Trạng thái mặc định
    //         'voucher_id' => $voucher ? $voucher->id : null, // Nếu có voucher, lưu voucher_id
    //     ]);

    //     // Step 2: Lưu các mục đơn hàng trong bảng `order_items`
    //     $cart = session('cart'); // Giả sử giỏ hàng được lưu trong session
    //     foreach ($cart as $cartItem) {
    //         foreach ($cartItem['items'] as $item) {
    //             // Kiểm tra tồn kho trước khi lưu đơn hàng
    //             $product = Product::find($item['product_id']);
    //             if ($product && $product->quantity < $item['quantity']) {
    //                 return redirect()->route('cart.index')->withErrors('Sản phẩm ' . $product->name . ' không đủ số lượng.');
    //             }

    //             // Tạo bản ghi cho từng mục trong đơn hàng
    //             OrderItem::create([
    //                 'order_id' => $order->id,
    //                 'product_id' => $item['product_id'],
    //                 'variant_id' => $item['variant_id'],
    //                 'quantity' => $item['quantity'],
    //                 'price' => $item['price'],
    //             ]);

    //             // Giảm số lượng sản phẩm trong kho (nếu cần)
    //             if ($product) {
    //                 $product->quantity -= $item['quantity'];
    //                 $product->save();
    //             }
    //         }
    //     }

    //     // Step 3: Xóa giỏ hàng sau khi đặt hàng
    //     session()->forget('cart');

    //     // Step 4: Chuyển hướng đến trang xác nhận đơn hàng (optional)
    //     return redirect()->route('order.confirmation', ['order' => $order->id]);
    // }
    // public function store(Request $request)
    // {
    //     // Validate form data
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'phone' => 'required|string|max:15',
    //         'address' => 'required|string|max:255',
    //         'shipping_method' => 'required|string',
    //         'payment_method' => 'required|string',
    //     ]);

    //     // Lấy giỏ hàng từ session
    //     $cart = session('cart', []);
    //     $cartTotal = 0;

    //     // Tính tổng giá trị giỏ hàng
    //     foreach ($cart as $item) {
    //         if (isset($item['price'], $item['quantity'])) {
    //             $cartTotal += $item['price'] * $item['quantity'];
    //         }
    //     }

    //     // Lấy phí vận chuyển dựa trên phương thức đã chọn
    //     $shippingCost = 0;
    //     if ($request->shipping_method == 'courier') {
    //         $shippingCost = 35000; // Giao hàng chuyển phát nhanh
    //     } elseif ($request->shipping_method == 'pickup') {
    //         $shippingCost = 0; // Nhận hàng từ cửa hàng, miễn phí
    //     }

    //     // Tính tổng đơn hàng (bao gồm giá trị giỏ hàng + phí vận chuyển)
    //     $totalPrice = $cartTotal + $shippingCost;

    //     // Tạo đơn hàng
    //     $order = Order::create([
    //         'user_id' => null, // Khách không cần đăng nhập, không có user_id
    //         'name' => $request->name,
    //         'phone' => $request->phone,
    //         'address' => $request->address,
    //         'description' => $request->input('description', ''), // Nếu có mô tả
    //         'payment_method' => $request->payment_method,
    //         'shipping_method' => $request->shipping_method,
    //         'shipping_fee' => $shippingCost,
    //         'total_price' => $totalPrice,
    //         'status' => 'Pending',
    //         'voucher_id' => null, // Chưa áp dụng voucher
    //     ]);

    //     // Lưu các sản phẩm trong giỏ hàng vào bảng `order_items`
    //     foreach ($cart as $item) {
    //         if (isset($item['product_id'], $item['price'], $item['quantity'])) {
    //             $order->orderItems()->create([
    //                 'order_id' => $item['order_id'],
    //                 'product_id' => $item['product_id'],
    //                 'variant_id' => $item['variant_id'] ?? null, // Nếu có biến thể (size, color, ...), lưu lại
    //                 'quantity' => $item['quantity'],
    //                 'price' => $item['price'],
    //                 'total_price' => $item['price'] * $item['quantity'], // Tính giá trị cho từng mục trong đơn hàng
    //             ]);
    //         }
    //     }

    //     // Xóa giỏ hàng sau khi lưu đơn hàng
    //     session()->forget('cart');

    //     // Điều hướng đến trang xác nhận đơn hàng
    //     return redirect()->route('home')->with('success', 'Đơn hàng của bạn đã được lưu thành công!');
    // }
    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'shipping_method' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        // Lấy giỏ hàng từ session
        $cart = session('cart', []);
        $cartTotal = 0;

        // Tính tổng giá trị giỏ hàng
        foreach ($cart as $item) {
            if (isset($item['price'], $item['quantity'])) {
                $cartTotal += $item['price'] * $item['quantity'];
            }
        }

        // Lấy phí vận chuyển dựa trên phương thức đã chọn
        $shippingCost = 0;
        if ($request->shipping_method == 'courier') {
            $shippingCost = 35000; // Giao hàng chuyển phát nhanh
        } elseif ($request->shipping_method == 'pickup') {
            $shippingCost = 0; // Nhận hàng từ cửa hàng, miễn phí
        }

        // Tính tổng đơn hàng (bao gồm giá trị giỏ hàng + phí vận chuyển)
        $totalPrice = $cartTotal + $shippingCost;

        // Tạo đơn hàng
        $order = Order::create([
            'user_id' => null, // Khách không cần đăng nhập, không có user_id
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'description' => $request->input('description', ''), // Nếu có mô tả
            'payment_method' => $request->payment_method,
            'shipping_method' => $request->shipping_method,
            'shipping_fee' => $shippingCost,
            'total_price' => $totalPrice,
            'status' => 'Pending',
            'voucher_id' => null, // Chưa áp dụng voucher
        ]);

        // Lưu các sản phẩm trong giỏ hàng vào bảng `order_items`
        foreach ($cart as $item) {
            if (isset($item['product_id'], $item['price'], $item['quantity'])) {
                $order->orderItems()->create([  // Dùng mối quan hệ orderItems() để lưu vào bảng order_items
                    'order_id' => $order->id,  // Lưu đúng order_id
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'] ?? null, // Nếu có biến thể (size, color, ...), lưu lại
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'], // Tính giá trị cho từng mục trong đơn hàng
                ]);
            }
        }

        // Xóa giỏ hàng sau khi lưu đơn hàng
        session()->forget('cart');

        // Điều hướng đến trang xác nhận đơn hàng
        return redirect()->route('home')->with('success', 'Đơn hàng của bạn đã được lưu thành công!');
    }



    public function orderConfirmation($orderId)
    {
        // Lấy thông tin đơn hàng từ cơ sở dữ liệu
        $order = Order::with('orderItems.product')->findOrFail($orderId);

        // Trả về view xác nhận đơn hàng
        return view('checkout.confirmation', compact('order'));
    }
    public function show(string $id)
    {
        //
    }

  
    public function edit(string $id)
    {
        //
    }

 
    public function update(Request $request, string $id)
    {
        //
    }

  
    public function destroy(string $id)
    {
        //
    }
}
