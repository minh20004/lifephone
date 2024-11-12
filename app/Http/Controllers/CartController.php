<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Order;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Capacity;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $totalQuantity = 0; 
        $totalPrice = 0;

        // Tính toán giỏ hàng
        $productIds = array_keys($cart);
        $products = Product::findMany($productIds);
        $capacities = Capacity::all()->keyBy('id');
        $colors = Color::all()->keyBy('id');

        foreach ($cart as $productId => $models) {
            foreach ($models as $modelId => $colorModels) {
                foreach ($colorModels as $colorId => $item) {
                    $product = $products->find($productId);
                    $capacity = $capacities->get($item['model_id']);
                    $color = $colors->get($colorId);

                    if ($product && $capacity && $color) {
                        $itemTotal = $item['quantity'] * $item['price'];
                        $totalPrice += $itemTotal;
                        $totalQuantity += $item['quantity'];

                        $cartItems[] = [
                            'product' => $product,
                            'capacity' => $capacity,
                            'color' => $color,
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                            'itemTotal' => $itemTotal,
                            'image_url' => $item['image_url'] ?? '',
                        ];
                    }
                }
            }
        }

        // Lấy thông tin voucher từ session
        $voucher = session()->get('voucher', []);
        $discount = $voucher['discount'] ?? 0;
        $totalAfterDiscount = $voucher['totalAfterDiscount'] ?? $totalPrice;

        // Truyền dữ liệu vào view
        return view('client.page.cart.index', compact('cartItems', 'totalQuantity', 'totalPrice', 'discount', 'totalAfterDiscount'));
    }


    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'model-options' => 'required|integer|exists:capacities,id',
            'color-options' => 'required|integer|exists:colors,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $modelId = $request->input('model-options');
        $colorId = $request->input('color-options');
        $quantity = $request->input('quantity');

        // Lấy thông tin sản phẩm và biến thể
        $product = Product::find($productId);
        $variant = ProductVariant::where('product_id', $productId)
            ->where('capacity_id', $modelId) 
            ->where('color_id', $colorId) 
            ->first();

        if (!$product || !$variant) {
            return redirect()->route('cart.index')->withErrors('Sản phẩm không tồn tại!');
        }

        // Tính giá
        $price = $product->price + $variant->price_difference; // Thêm price_difference vào giá cơ bản

        // Tạo một mảng giỏ hàng
        $cartItem = [
            'id' => $productId,
            'model_id' => $modelId,
            'color_id' => $colorId,
            'quantity' => $quantity,
            'price' => $price,
            'image_url' => $product->image_url // Thêm URL hình ảnh vào giỏ hàng
        ];

        // Kiểm tra xem giỏ hàng có tồn tại trong session không, nếu không thì tạo mới
        $cart = session()->get('cart', []);

        // Cập nhật số lượng hoặc thêm sản phẩm mới
        if (isset($cart[$productId][$modelId][$colorId])) {
            // Cập nhật số lượng nếu đã tồn tại
            $cart[$productId][$modelId][$colorId]['quantity'] += $quantity;
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            $cart[$productId][$modelId][$colorId] = $cartItem;
        }

        // Lưu vào session
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }


    public function updateQuantity(Request $request)
    {
        $productId = $request->input('productId');
        $modelId = $request->input('modelId');
        $colorId = $request->input('colorId');
        $quantity = (int) $request->input('quantity');
    
        $cart = session()->get('cart', []);
    
        if (isset($cart[$productId][$modelId][$colorId])) {
            if ($quantity > 0) {
                $cart[$productId][$modelId][$colorId]['quantity'] = $quantity;
            } else {
                unset($cart[$productId][$modelId][$colorId]);
    
                if (empty($cart[$productId][$modelId])) {
                    unset($cart[$productId][$modelId]);
                }
                if (empty($cart[$productId])) {
                    unset($cart[$productId]);
                }
            }
    
            session()->put('cart', $cart);
        }
    
        // Tính tổng tiền và tổng số lượng
        $totalPrice = 0;
        $totalQuantity = 0;
        foreach ($cart as $product) {
            foreach ($product as $model) {
                foreach ($model as $color) {
                    $totalPrice += $color['price'] * $color['quantity'];
                    $totalQuantity += $color['quantity'];
                }
            }
        }
    
        $itemTotal = $cart[$productId][$modelId][$colorId]['price'] * $quantity ?? 0;
    
        return response()->json([
            'itemTotal' => number_format($itemTotal, 0, ',', '.') . ' đ',
            'totalPrice' => number_format($totalPrice, 0, ',', '.') . ' đ',
            'totalQuantity' => $totalQuantity,
        ]);
    }
    


    public function applyVoucher(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string|exists:vouchers,code',
        ]);

        $voucherCode = $request->input('voucher_code');
        $voucher = Voucher::where('code', $voucherCode)->first();

        // Kiểm tra mã voucher có tồn tại và còn hiệu lực không
        if (!$voucher || now()->lt($voucher->start_date) || now()->gt($voucher->end_date) || $voucher->usage_limit <= 0) {
            return redirect()->route('cart.index')->withErrors('Mã giảm giá không hợp lệ hoặc đã hết hạn!');
        }

        // Tính tổng giá trị giỏ hàng trước khi áp dụng voucher
        $cart = session()->get('cart', []);
        $totalPrice = 0;
        foreach ($cart as $product) {
            foreach ($product as $model) {
                foreach ($model as $color) {
                    $totalPrice += $color['price'] * $color['quantity'];
                }
            }
        }

        // Kiểm tra giá trị đơn hàng tối thiểu
        if ($totalPrice < $voucher->min_order_value) {
            return redirect()->route('cart.index')->withErrors('Giá trị đơn hàng chưa đạt mức tối thiểu để áp dụng mã giảm giá.');
        }

        // Tính toán giảm giá
        $discount = 0;
        if ($voucher->discount_percentage) {
            $discount = ($totalPrice * $voucher->discount_percentage) / 100;
        } elseif ($voucher->discount_amount) {
            $discount = $voucher->discount_amount;
        }

        // Đảm bảo giảm giá không vượt quá tổng giá trị đơn hàng
        $discount = min($discount, $totalPrice);

        // Tính tổng sau khi áp dụng giảm giá
        $totalAfterDiscount = $totalPrice - $discount;

        // Lưu mã voucher và giảm giá vào session để hiển thị trong giỏ hàng
        session()->put('voucher', [
            'code' => $voucherCode,
            'discount' => $discount,
            'totalAfterDiscount' => $totalAfterDiscount,
        ]);

        // Giảm số lần sử dụng còn lại của voucher
        $voucher->decrement('usage_limit');

        return redirect()->route('cart.index')->with('success', 'Mã giảm giá đã được áp dụng!');
    }

    public function checkout(Request $request)
    {
        // Lấy giỏ hàng và voucher từ session
        $cart = session()->get('cart', []);
        $voucher = session()->get('voucher', []);
        
        $totalPrice = 0;
        $totalQuantity = 0;
        $defaultShippingCost = 35000; // Chi phí vận chuyển mặc định
        $discount = $voucher['discount'] ?? 0;

        // Tính tổng giá và tổng số lượng sản phẩm
        foreach ($cart as $product) {
            foreach ($product as $model) {
                foreach ($model as $item) {
                    $totalPrice += $item['price'] * $item['quantity'];
                    $totalQuantity += $item['quantity'];
                }
            }
        }

        // Tính toán tổng sau khi giảm giá
        $totalAfterDiscount = $totalPrice - $discount;

        // Tạo một danh sách các phương thức vận chuyển có thể chọn
        $shippingMethods = [
            ['name' => 'Giao hàng chuyển phát nhanh', 'cost' => 35000],
            ['name' => 'Nhận hàng từ cửa hàng', 'cost' => 0],
        ];

        // Chi phí vận chuyển mặc định
        $shippingCost = $defaultShippingCost;

        // Tổng ước tính ban đầu
        $estimatedTotal = $totalAfterDiscount + $shippingCost;

        return view('client.page.checkout.index', compact(
            'cart', 'totalPrice', 'totalQuantity', 'discount', 'shippingCost', 'estimatedTotal', 'shippingMethods'
        ));
    }



    public function remove($productId, $modelId, $colorId)
    {
        $cart = session()->get('cart', []);

        // Kiểm tra xem sản phẩm, model và màu sắc có tồn tại trong giỏ hàng không
        if (isset($cart[$productId][$modelId][$colorId])) {
            unset($cart[$productId][$modelId][$colorId]); // Xóa model và màu sắc cụ thể

            if (empty($cart[$productId][$modelId])) {
                unset($cart[$productId][$modelId]);
            }

            if (empty($cart[$productId])) {
                unset($cart[$productId]);
            }

            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }






    /**
     * Show the form for creating a new resource.
     */
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
