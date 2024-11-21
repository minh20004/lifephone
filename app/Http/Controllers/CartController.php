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

        // Lấy ID sản phẩm từ giỏ hàng
        $productIds = array_keys($cart);

        // Lấy thông tin sản phẩm và biến thể
        $products = Product::findMany($productIds);
        $variants = ProductVariant::whereIn('product_id', $productIds)->with(['capacity', 'color'])->get()->keyBy(function ($variant) {
            return "{$variant->product_id}-{$variant->capacity_id}-{$variant->color_id}";
        });

        foreach ($cart as $productId => $models) {
            foreach ($models as $modelId => $colorModels) {
                foreach ($colorModels as $colorId => $item) {
                    $product = $products->find($productId);
                    $variantKey = "{$productId}-{$modelId}-{$colorId}";
                    $variant = $variants->get($variantKey);

                    if ($product && $variant) {
                        $itemTotal = $item['quantity'] * $item['price'];
                        $totalPrice += $itemTotal;
                        $totalQuantity += $item['quantity'];

                        $cartItems[] = [
                            'product' => $product,
                            'capacity' => $variant->capacity,
                            'color' => $variant->color,
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                            'itemTotal' => $itemTotal,
                            'image_url' => $item['image_url'] ?? '',
                        ];
                    }
                }
            }
        }

        // Tính toán giảm giá và tổng cộng
        $voucher = session()->get('voucher', []);
        $discount = $voucher['discount'] ?? 0;
        $totalAfterDiscount = $totalPrice - $discount;

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

        // Lấy thông tin biến thể
        $variant = ProductVariant::where('product_id', $productId)
            ->where('capacity_id', $modelId)
            ->where('color_id', $colorId)
            ->with(['capacity', 'color'])
            ->firstOrFail();

        // Tính giá
        $price = $variant->product->price + $variant->price_difference;

        // Thêm variant_id vào mảng giỏ hàng
        $cartItem = [
            'id' => $productId,
            'model_id' => $modelId,
            'color_id' => $colorId,
            'variant_id' => $variant->id, // Lưu variant_id
            'quantity' => $quantity,
            'price' => $price,
            'image_url' => $variant->product->image_url,
        ];

        $cart = session()->get('cart', []);
        if (isset($cart[$productId][$modelId][$colorId])) {
            $cart[$productId][$modelId][$colorId]['quantity'] += $quantity;
        } else {
            $cart[$productId][$modelId][$colorId] = $cartItem;
        }

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
        }

        session()->put('cart', $cart);

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

        // Tính lại giảm giá nếu có mã voucher
        $discount = 0;
        $totalAfterDiscount = $totalPrice; // Tổng tiền sau khi giảm giá
        if ($voucher = session()->get('voucher')) {
            if (!empty($voucher['discount'])) {
                $discount = $voucher['discount'];
            }

            if (!empty($voucher['code'])) {
                $voucherModel = Voucher::where('code', $voucher['code'])->first();
                if ($voucherModel) {
                    if ($voucherModel->discount_percentage) {
                        $discount = ($totalPrice * $voucherModel->discount_percentage) / 100;
                    } elseif ($voucherModel->discount_amount) {
                        $discount = $voucherModel->discount_amount;
                    }
                    $discount = min($discount, $totalPrice);
                    $totalAfterDiscount = $totalPrice - $discount;
                    session()->put('voucher', [
                        'code' => $voucherModel->code,
                        'discount' => $discount,
                        'totalAfterDiscount' => $totalAfterDiscount,
                    ]);
                }
            }
        }

        return response()->json([
            'totalPrice' => number_format($totalPrice, 0, ',', '.') . ' đ',
            'totalQuantity' => $totalQuantity,
            'totalAfterDiscount' => number_format($totalAfterDiscount, 0, ',', '.') . ' đ',
            'discount' => number_format($discount, 0, ',', '.') . ' đ',
        ]);
    }

    
    public function applyVoucher(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string|exists:vouchers,code',
        ]);

        $voucherCode = $request->input('voucher_code');
        $voucher = Voucher::where('code', $voucherCode)->first();

        // Lấy giỏ hàng
        $cart = session()->get('cart', []);

        // Nếu giỏ hàng rỗng
        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors('Giỏ hàng của bạn đang trống, không thể áp dụng mã giảm giá.');
        }

        // Kiểm tra mã voucher
        if (!$voucher || now()->lt($voucher->start_date) || now()->gt($voucher->end_date) || $voucher->usage_limit <= 0) {
            return redirect()->route('cart.index')->withErrors('Mã giảm giá không hợp lệ hoặc đã hết hạn!');
        }

        // Tính tổng giá trị giỏ hàng
        $totalPrice = 0;
        foreach ($cart as $product) {
            foreach ($product as $model) {
                foreach ($model as $color) {
                    $totalPrice += $color['price'] * $color['quantity'];
                }
            }
        }

        // Kiểm tra giá trị tối thiểu để áp dụng voucher
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

        $discount = min($discount, $totalPrice);
        $totalAfterDiscount = $totalPrice - $discount;

        // Lưu voucher vào session
        session()->put('voucher', [
            'code' => $voucherCode,
            'discount' => $discount,
            'totalAfterDiscount' => $totalAfterDiscount,
        ]);

        // Giảm số lần sử dụng còn lại của voucher
        $voucher->decrement('usage_limit');

        return redirect()->route('cart.index')->with('success', 'Mã giảm giá đã được áp dụng!');
    }

    
    public function remove($productId, $modelId, $colorId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId][$modelId][$colorId])) {
            unset($cart[$productId][$modelId][$colorId]);

            if (empty($cart[$productId][$modelId])) {
                unset($cart[$productId][$modelId]);
            }

            if (empty($cart[$productId])) {
                unset($cart[$productId]);
            }

            session()->put('cart', $cart);
        }

        // Kiểm tra nếu giỏ hàng rỗng, xóa voucher
        if (empty($cart)) {
            session()->forget('voucher');
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }

    public function checkout(Request $request)
    {
        // Lấy giỏ hàng và voucher từ session
        $cart = session()->get('cart', []);
        $voucher = session()->get('voucher', []);

        $totalPrice = 0;
        $totalQuantity = 0;
        $discount = $voucher['discount'] ?? 0;

        // Thêm thông tin chi tiết sản phẩm, dung lượng, màu sắc vào giỏ hàng
        foreach ($cart as $productId => $models) {
            foreach ($models as $modelId => $colors) {
                foreach ($colors as $colorId => $item) {
                    // Lấy thông tin sản phẩm, dung lượng, màu sắc
                    $product = Product::find($productId); // Tìm sản phẩm
                    $capacity = Capacity::find($modelId); // Tìm dung lượng
                    $color = Color::find($colorId); // Tìm màu sắc

                    // Thêm thông tin vào mảng giỏ hàng
                    $cart[$productId][$modelId][$colorId]['product_name'] = $product->name ?? 'Sản phẩm không tồn tại';
                    $cart[$productId][$modelId][$colorId]['capacity_name'] = $capacity->name ?? 'Không xác định';
                    $cart[$productId][$modelId][$colorId]['color_name'] = $color->name ?? 'Không xác định';

                    // Tính tổng giá và số lượng
                    $totalPrice += $item['price'] * $item['quantity'];
                    $totalQuantity += $item['quantity'];
                }
            }
        }

        // Tính toán tổng sau khi giảm giá
        $totalAfterDiscount = $totalPrice - $discount;

        // Tổng ước tính ban đầu (không tính vận chuyển)
        $estimatedTotal = $totalAfterDiscount;

        // Truyền dữ liệu ra view
        return view('client.page.checkout.index', compact(
            'cart', 'totalPrice', 'totalQuantity', 'discount', 'estimatedTotal'
        ));
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
