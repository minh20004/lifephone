<?php

namespace App\Http\Controllers;

use App\Models\Cart;
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
        session()->put('cart', $cart);

        // Tính lại giảm giá nếu có mã voucher
        $voucher = session()->get('voucher', []);
        if ($voucher && !empty($voucher['code'])) {
            $this->recalculateVoucher();
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
        ],[
            'color-options' => 'Màu sắc không được để trống'
        ]);

        $productId = $request->input('product_id');
        $modelId = $request->input('model-options');
        $colorId = $request->input('color-options');
        $quantity = $request->input('quantity');

        $variant = ProductVariant::where('product_id', $productId)
            ->where('capacity_id', $modelId)
            ->where('color_id', $colorId)
            ->with(['capacity', 'color'])
            ->firstOrFail();
        
        // Kiểm tra xem người dùng có vuwowth quá sl không
        if ($quantity > $variant->stock) {
            return back()->withErrors(['quantity' => 'Số lượng không được vượt quá số lượng tồn kho ('.$variant->stock_quantity.' sản phẩm).']);
        }
        // Kiểm tra xem trong giỏ hàng đã có sản phẩm này chưa và số lượng đã có trong giỏ hàng
        $cart = session()->get('cart', []);
        $existingQuantity = 0;
        if (isset($cart[$productId][$modelId][$colorId])) {
            $existingQuantity = $cart[$productId][$modelId][$colorId]['quantity'];
        }

        // Kiểm tra xem tổng số lượng trong giỏ hàng có vượt quá số lượng tồn kho không
        $totalQuantity = $existingQuantity + $quantity;
        if ($totalQuantity > $variant->stock) {
            return back()->withErrors(['quantity' => 'Số lượng trong giỏ hàng không thể vượt quá số lượng tồn kho ('.$variant->stock.' sản phẩm).']);
        }

        $price = $variant->product->price + $variant->price_difference;

        $cartItem = [
            'id' => $productId,
            'model_id' => $modelId,
            'color_id' => $colorId,
            'variant_id' => $variant->id, 
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

        // Cập nhật hoặc xóa sản phẩm trong giỏ hàng
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
        $itemTotal = 0;

        foreach ($cart as $pid => $product) {
            foreach ($product as $mid => $model) {
                foreach ($model as $cid => $color) {
                    $totalPrice += $color['price'] * $color['quantity'];
                    $totalQuantity += $color['quantity'];

                    // Tính giá trị của sản phẩm hiện tại
                    if ($pid == $productId && $mid == $modelId && $cid == $colorId) {
                        $itemTotal = $color['price'] * $color['quantity'];
                    }
                }
            }
        }

        // Tính giảm giá nếu có voucher
        $discount = 0;
        $totalAfterDiscount = $totalPrice; // Tổng tiền sau giảm giá
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
            'itemTotal' => number_format($itemTotal, 0, ',', '.') . ' đ', // Giá trị tổng của sản phẩm
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
        if ($request->input('remove_voucher')) {
            session()->forget('voucher');
            return redirect()->route('cart.index')->with('success', 'Mã giảm giá đã được xóa!');
        }
        
        // Giảm số lần sử dụng còn lại của voucher
        $voucher->decrement('usage_limit');

        return redirect()->route('cart.index')->with('success', 'Mã giảm giá đã được áp dụng!');
    }

    private function recalculateVoucher()
    {
        $cart = session()->get('cart', []);
        $totalPrice = 0;

        foreach ($cart as $product) {
            foreach ($product as $model) {
                foreach ($model as $color) {
                    $totalPrice += $color['price'] * $color['quantity'];
                }
            }
        }

        $voucher = session()->get('voucher');
        $discount = 0;

        if ($voucher) {
            $voucherModel = Voucher::where('code', $voucher['code'])->first();

            if ($voucherModel) {
                if ($voucherModel->discount_percentage) {
                    $discount = ($totalPrice * $voucherModel->discount_percentage) / 100;
                } elseif ($voucherModel->discount_amount) {
                    $discount = $voucherModel->discount_amount;
                }
                $discount = min($discount, $totalPrice);
            }
        }

        $totalAfterDiscount = $totalPrice - $discount;

        session()->put('voucher', [
            'code' => $voucher['code'],
            'discount' => $discount,
            'totalAfterDiscount' => $totalAfterDiscount,
        ]);
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
        $cart = session()->get('cart', []);
        $voucher = session()->get('voucher', []);

        $totalPrice = 0;
        $totalQuantity = 0;
        $discount = $voucher['discount'] ?? 0;
        $outOfStockItems = [];  

        foreach ($cart as $productId => $models) {
            foreach ($models as $modelId => $colors) {
                foreach ($colors as $colorId => $item) {
                    // Tìm variant sản phẩm (sản phẩm, dung lượng, màu sắc)
                    $variant = ProductVariant::where('product_id', $productId)
                        ->where('capacity_id', $modelId)
                        ->where('color_id', $colorId)
                        ->with(['capacity', 'color'])
                        ->first();

                    // Kiểm tra nếu không tìm thấy variant sản phẩm
                    if (!$variant) {
                        $outOfStockItems[] = 'Sản phẩm không hợp lệ hoặc không tồn tại.';
                        continue;
                    }

                    // Kiểm tra nếu số lượng yêu cầu vượt quá số lượng tồn kho
                    if ($item['quantity'] > $variant->stock) {
                        // Thêm thông báo lỗi vào mảng lỗi
                        $outOfStockItems[] = 'Số lượng của sản phẩm "' . $variant->product->name . '" vượt quá số lượng tồn kho. Tồn kho hiện tại: ' . $variant->stock . ' sản phẩm.';
                    }

                    // Tính tổng giá trị vad tổng số lượng
                    $totalPrice += $item['price'] * $item['quantity'];
                    $totalQuantity += $item['quantity'];
                }
            }
        }

        $customer = auth('customer')->check() ? auth('customer')->user() : null;
        // vượt quá số lượng tồn kho quay lại và báo lỗi
        if (!empty($outOfStockItems)) {
            return back()->withErrors(['quantity' => $outOfStockItems]);
        }

        $totalAfterDiscount = $totalPrice - $discount;

        $estimatedTotal = $totalAfterDiscount;

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