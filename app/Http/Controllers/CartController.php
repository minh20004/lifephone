<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Color;
use App\Models\Order;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Capacity;
use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function index()
    {
        $cartItems = [];
        $totalQuantity = 0;
        $totalPrice = 0;

        // Kiểm tra nếu người dùng đã đăng nhập
        if (auth('customer')->check()) {
            // $customerId = auth()->id();
            $customerId = auth('customer')->id();
            

            // Lấy giỏ hàng từ cơ sở dữ liệu
            $cartItemsQuery = Cart::where('customer_id', $customerId)
                ->with(['product', 'variant.capacity', 'variant.color'])
                ->get();

            // Tính tổng số lượng và tổng giá trị
            $totalQuantity = $cartItemsQuery->sum('quantity');
            $totalPrice = $cartItemsQuery->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            foreach ($cartItemsQuery as $cartItem) {
                // Kiểm tra sự tồn tại của các mối quan hệ để tránh lỗi
                $product = optional($cartItem->product);
                $variant = optional($cartItem->variant);
                $capacity = optional($variant->capacity);
                $color = optional($variant->color);

                if ($product && $variant && $capacity && $color) {
                    $cartItems[] = [
                        'product' => $product,
                        'capacity' => $capacity,
                        'color' => $color,
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->price,
                        'itemTotal' => $cartItem->quantity * $cartItem->price,
                    ];
                }
            }
        } else {
            // Nếu người dùng chưa đăng nhập
            $cart = session()->get('cart', []);
            $productIds = array_keys($cart);

            $products = Product::findMany($productIds);
            $variants = ProductVariant::whereIn('product_id', $productIds)
                ->with(['capacity', 'color'])
                ->get()
                ->keyBy(function ($variant) {
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
        }

        // Tính toán giảm giá nếu có voucher
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

        if ($quantity > $variant->stock) {
            return back()->withErrors(['quantity' => 'Số lượng không được vượt quá số lượng tồn kho (' . $variant->stock . ' sản phẩm).']);
        }

        if (auth('customer')->check()) {
            // Người dùng đã đăng nhập
            $customerId = auth('customer')->id();

            $existingCartItem = Cart::where('customer_id', $customerId)
                ->where('product_id', $productId)
                ->where('variant_id', $variant->id)
                ->first();

            if ($existingCartItem) {
                $totalQuantity = $existingCartItem->quantity + $quantity;

                if ($totalQuantity > $variant->stock) {
                    return back()->withErrors(['quantity' => 'Số lượng trong giỏ hàng không thể vượt quá số lượng tồn kho (' . $variant->stock . ' sản phẩm).']);
                }

                $existingCartItem->update(['quantity' => $totalQuantity]);
            } else {
                Cart::create([
                    'customer_id' => $customerId,
                    'product_id' => $productId,
                    'variant_id' => $variant->id,
                    'quantity' => $quantity,
                    'price' => $variant->product->price + $variant->price_difference,
                ]);
            }
        } else {
            // Người dùng chưa đăng nhập
            $cart = session()->get('cart', []);
            $existingQuantity = 0;

            if (isset($cart[$productId][$modelId][$colorId])) {
                $existingQuantity = $cart[$productId][$modelId][$colorId]['quantity'];
            }

            $totalQuantity = $existingQuantity + $quantity;

            if ($totalQuantity > $variant->stock) {
                return back()->withErrors(['quantity' => 'Số lượng trong giỏ hàng không thể vượt quá số lượng tồn kho (' . $variant->stock . ' sản phẩm).']);
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

            if (isset($cart[$productId][$modelId][$colorId])) {
                $cart[$productId][$modelId][$colorId]['quantity'] += $quantity;
            } else {
                $cart[$productId][$modelId][$colorId] = $cartItem;
            }

            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }



    public function updateQuantity(Request $request)
    {
        $productId = $request->input('productId');
        $modelId = $request->input('modelId');
        $colorId = $request->input('colorId');
        $quantity = (int) $request->input('quantity');
        $totalPrice = 0;
        $cartItem = null;

        if (auth('customer')->check()) {
            $customerId = auth('customer')->id();
            $cartItem = Cart::where('customer_id', $customerId)
                ->where('product_id', $productId)
                ->where('variant_id', "{$modelId}-{$colorId}")
                ->first();

            if ($cartItem) {
                if ($quantity > 0) {
                    $cartItem->quantity = $quantity;
                    $cartItem->save();
                } else {
                    $cartItem->delete();
                }
            }

            // Tính tổng giá trị giỏ hàng sau khi thay đổi
            $cartItems = Cart::where('customer_id', $customerId)->get();
            foreach ($cartItems as $item) {
                $totalPrice += $item->price * $item->quantity;
            }
        } else {
            // Xử lý cho khách chưa đăng nhập
            $cart = session()->get('cart', []);
            if (isset($cart[$productId][$modelId][$colorId])) {
                if ($quantity > 0) {
                    $cart[$productId][$modelId][$colorId]['quantity'] = $quantity;
                } else {
                    unset($cart[$productId][$modelId][$colorId]);
                    if (empty($cart[$productId][$modelId])) unset($cart[$productId][$modelId]);
                    if (empty($cart[$productId])) unset($cart[$productId]);
                }
            }
            session()->put('cart', $cart);

            // Tính lại tổng giá trị giỏ hàng sau khi thay đổi
            foreach ($cart as $product) {
                foreach ($product as $model) {
                    foreach ($model as $color) {
                        $totalPrice += $color['price'] * $color['quantity'];
                    }
                }
            }
        }

        // Tính lại giá trị giảm giá
        $this->recalculateVoucher();

        // Trả về dữ liệu để cập nhật frontend
        return response()->json([
            'success' => true,
            'itemTotal' => $cartItem ? number_format($cartItem->price * $quantity, 0, ',', '.') : 0,
            'totalPrice' => number_format($totalPrice, 0, ',', '.'),
            'discount' => number_format(session('voucher.discount', 0), 0, ',', '.'),
            'totalAfterDiscount' => number_format(session('voucher.totalAfterDiscount', 0), 0, ',', '.'),
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
        $customerId = auth('customer')->id();

        // Nếu giỏ hàng rỗng
        if (empty($cart) && !$customerId) {
            return redirect()->route('cart.index')->withErrors('Giỏ hàng của bạn đang trống, không thể áp dụng mã giảm giá.');
        }

        // Kiểm tra mã voucher
        if (!$voucher || now()->lt($voucher->start_date) || now()->gt($voucher->end_date) || $voucher->usage_limit <= 0) {
            return redirect()->route('cart.index')->withErrors('Mã giảm giá không hợp lệ hoặc đã hết hạn!');
        }

        // Tính tổng giá trị giỏ hàng
        $totalPrice = 0;

        if ($customerId) {
            // Lấy giỏ hàng từ database nếu người dùng đã đăng nhập
            $cartItems = Cart::where('customer_id', $customerId)->get();
            foreach ($cartItems as $item) {
                $totalPrice += $item->price * $item->quantity;
            }
        } else {
            // Tính tổng giỏ hàng từ session cho khách chưa đăng nhập
            foreach ($cart as $product) {
                foreach ($product as $model) {
                    foreach ($model as $color) {
                        $totalPrice += $color['price'] * $color['quantity'];
                    }
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

        // Lưu voucher vào session (cho cả khách và người dùng đã đăng nhập)
        session()->put('voucher', [
            'code' => $voucherCode,
            'discount' => $discount,
            'totalAfterDiscount' => $totalAfterDiscount,
        ]);

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
        if (auth('customer')->check()) {
            $customerId = auth('customer')->id();
            $cartItem = Cart::where('customer_id', $customerId)
                            ->where('product_id', $productId)
                            ->where('variant_id', "{$modelId}-{$colorId}")
                            ->first();

            if ($cartItem) {
                $cartItem->delete();
            }
        } else {
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
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }
    
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []); // Giỏ hàng mặc định từ session
            $voucher = session()->get('voucher', []); // Voucher nếu có

            $totalPrice = 0;
            $totalQuantity = 0;
            $discount = $voucher['discount'] ?? 0;
            $outOfStockItems = [];  

            // Kiểm tra khách hàng đã đăng nhập hay chưa
            if (auth('customer')->check()) {
                // Nếu khách hàng đã đăng nhập, lấy giỏ hàng từ bảng Cart trong cơ sở dữ liệu
                $customerId = auth('customer')->id();
                // Giả sử bạn có một bảng Cart trong database để lưu giỏ hàng của người dùng
                $cartItems = Cart::where('customer_id', $customerId)->with(['product', 'variant.capacity', 'variant.color'])->get();

                foreach ($cartItems as $cartItem) {
                    $variant = $cartItem->variant;
                    if (!$variant) {
                        $outOfStockItems[] = 'Sản phẩm không hợp lệ hoặc không tồn tại.';
                        continue;
                    }

                    if ($cartItem->quantity > $variant->stock) {
                        $outOfStockItems[] = 'Số lượng của sản phẩm "' . $cartItem->product->name . '" vượt quá số lượng tồn kho. Tồn kho hiện tại: ' . $variant->stock . ' sản phẩm.';
                    }

                    $totalPrice += $cartItem->quantity * $cartItem->price;
                    $totalQuantity += $cartItem->quantity;
                }

            } else {
                // Nếu chưa đăng nhập, lấy giỏ hàng từ session
                foreach ($cart as $productId => $models) {
                    foreach ($models as $modelId => $colors) {
                        foreach ($colors as $colorId => $item) {
                            $variant = ProductVariant::where('product_id', $productId)
                                ->where('capacity_id', $modelId)
                                ->where('color_id', $colorId)
                                ->with(['capacity', 'color'])
                                ->first();

                            if (!$variant) {
                                $outOfStockItems[] = 'Sản phẩm không hợp lệ hoặc không tồn tại.';
                                continue;
                            }

                            if ($item['quantity'] > $variant->stock) {
                                $outOfStockItems[] = 'Số lượng của sản phẩm "' . $variant->product->name . '" vượt quá số lượng tồn kho. Tồn kho hiện tại: ' . $variant->stock . ' sản phẩm.';
                            }

                            $totalPrice += $item['price'] * $item['quantity'];
                            $totalQuantity += $item['quantity'];
                        }
                    }
                }
            }

            // Kiểm tra các sản phẩm vượt quá số lượng tồn kho
            if (!empty($outOfStockItems)) {
                return back()->withErrors(['quantity' => $outOfStockItems]);
            }

            $totalAfterDiscount = $totalPrice - $discount;
            $estimatedTotal = $totalAfterDiscount;

            $customer = auth('customer')->user();
            $addresses = $customer ? $customer->addresses : collect();
            $defaultAddress = $customer ? $addresses->firstWhere('is_default', 1) : null;

            return view('client.page.checkout.index', compact(
                'cart', 'totalPrice', 'totalQuantity', 'discount', 'estimatedTotal', 'defaultAddress', 'addresses'
            ));
    }







    public function saveAddress(Request $request)
    {
        $address = $request->only(['name', 'phone', 'address']);
        session()->put('selected_address', $address);

        return response()->json(['status' => 'success', 'message' => 'Địa chỉ đã được lưu vào session.']);
    }



    public function getCartItemCount()
    {
        $cart = session()->get('cart', []);
        $totalQuantity = 0;

        foreach ($cart as $productId => $models) {
            foreach ($models as $modelId => $colorModels) {
                foreach ($colorModels as $item) {
                    $totalQuantity += $item['quantity'];
                }
            }
        }

        return response()->json(['count' => $totalQuantity]);
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
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}