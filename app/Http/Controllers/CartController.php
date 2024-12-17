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

        if (auth('customer')->check()) {
            $customerId = auth('customer')->id();
            $cartItemsQuery = Cart::where('customer_id', $customerId)
                ->with(['product', 'variant.capacity', 'variant.color'])
                ->get();

            $totalQuantity = $cartItemsQuery->sum('quantity');
            $totalPrice = $cartItemsQuery->sum(function ($item) {
                return $item->quantity * $item->price;
            });

            foreach ($cartItemsQuery as $cartItem) {
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

        return view('client.page.cart.index', compact('cartItems', 'totalQuantity', 'totalPrice'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'model-options' => 'required|integer|exists:capacities,id',
            'color-options' => 'required|integer|exists:colors,id',
            'quantity' => 'required|integer|min:1',
        ],[
            'color-options' => 'Vui lòng chọn màu sắc sản phẩm'
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

    // public function updateQuantity(Request $request) //lỗi
    // {
    //     $productId = $request->input('productId');
    //     $modelId = $request->input('modelId');
    //     $colorId = $request->input('colorId');
    //     $quantity = (int) $request->input('quantity');
    //     $totalPrice = 0;

    //     if (auth('customer')->check()) {
    //         $customerId = auth('customer')->id();
    //         $cartItem = Cart::where('customer_id', $customerId)
    //             ->where('product_id', $productId)
    //             ->where('variant_id', "{$modelId}-{$colorId}")
    //             ->first();

    //         if ($cartItem) {
    //             if ($quantity > 0) {
    //                 $cartItem->quantity = $quantity;
    //                 $cartItem->save();
    //             } else {
    //                 $cartItem->delete();
    //             }
    //         }

    //         $cartItems = Cart::where('customer_id', $customerId)->get();
    //         foreach ($cartItems as $item) {
    //             $totalPrice += $item->price * $item->quantity;
    //         }
    //     } else {
    //         $cart = session()->get('cart', []);
    //         if (isset($cart[$productId][$modelId][$colorId])) {
    //             if ($quantity > 0) {
    //                 $cart[$productId][$modelId][$colorId]['quantity'] = $quantity;
    //             } else {
    //                 unset($cart[$productId][$modelId][$colorId]);
    //                 if (empty($cart[$productId][$modelId])) unset($cart[$productId][$modelId]);
    //                 if (empty($cart[$productId])) unset($cart[$productId]);
    //             }
    //         }
    //         session()->put('cart', $cart);

    //         foreach ($cart as $product) {
    //             foreach ($product as $model) {
    //                 foreach ($model as $color) {
    //                     $totalPrice += $color['price'] * $color['quantity'];
    //                 }
    //             }
    //         }
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'itemTotal' => number_format($cartItem ? $cartItem->price * $quantity : $color['price'] * $quantity),
    //         'totalPrice' => number_format($totalPrice)
    //     ]);
    // }

    public function updateQuantity(Request $request)
    {
        $productId = $request->input('productId');
        $modelId = $request->input('modelId');
        $colorId = $request->input('colorId');
        $quantity = (int) $request->input('quantity');
        $totalPrice = 0;

        if (auth('customer')->check()) {
            $customerId = auth('customer')->id();
            $cartItem = Cart::where('customer_id', $customerId)
                ->where('product_id', $productId)
                ->whereHas('variant', function ($query) use ($modelId, $colorId) {
                    $query->where('capacity_id', $modelId)->where('color_id', $colorId);
                })
                ->first();

            if ($cartItem) {
                if ($quantity > 0) {
                    $cartItem->quantity = $quantity;
                    $cartItem->save();
                } else {
                    $cartItem->delete();
                }
            }

            $cartItems = Cart::where('customer_id', $customerId)->get();
            foreach ($cartItems as $item) {
                $totalPrice += $item->price * $item->quantity;
            }
        } else {
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

            foreach ($cart as $product) {
                foreach ($product as $model) {
                    foreach ($model as $color) {
                        $totalPrice += $color['price'] * $color['quantity'];
                    }
                }
            }
        }

        $itemTotal = $quantity > 0 ? number_format($cartItem ? $cartItem->price * $quantity : $cart[$productId][$modelId][$colorId]['price'] * $quantity, 0, ',', '.') : '0';

        return response()->json([
            'success' => true,
            'itemTotal' => $itemTotal,
            'totalPrice' => number_format($totalPrice, 0, ',', '.')
        ]);
    }
    
    public function remove($productId)
    {
        if (auth('customer')->check()) {
            // Lấy thông tin của khách hàng đã đăng nhập
            $customerId = auth('customer')->id();
            
            // Tìm sản phẩm trong giỏ hàng của người dùng
            $cartItem = Cart::where('customer_id', $customerId)
                            ->where('product_id', $productId)
                            ->first();

            if ($cartItem) {
                // Xóa sản phẩm khỏi giỏ hàng
                $cartItem->delete();
            }

            // Kiểm tra nếu giỏ hàng trống sau khi xóa
            $remainingItems = Cart::where('customer_id', $customerId)->count();
            if ($remainingItems === 0) {
                return redirect()->route('cart.index')->with('info', 'Giỏ hàng của bạn hiện trống.');
            }

        } else {
            // Xử lý cho giỏ hàng trong session nếu người dùng chưa đăng nhập
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                unset($cart[$productId]);

                // Cập nhật lại session nếu giỏ hàng không còn sản phẩm
                if (empty($cart)) {
                    session()->forget('cart');
                } else {
                    session()->put('cart', $cart);
                }
            }
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }



    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []); 
        $outOfStockItems = [];  
        $cartItems = [];
        $totalPrice = 0;
        $totalQuantity = 0;

        // Kiểm tra khách hàng đã đăng nhập hay chưa
        if (auth('customer')->check()) {
            $customerId = auth('customer')->id();
            $cartItems = Cart::where('customer_id', $customerId)
                ->with(['product', 'variant.capacity', 'variant.color'])
                ->get();

            foreach ($cartItems as $cartItem) {
                $variant = $cartItem->variant;

                if (!$variant) {
                    $outOfStockItems[] = 'Sản phẩm không hợp lệ hoặc không tồn tại.';
                    continue;
                }

                if ($cartItem->quantity > $variant->stock) {
                    $outOfStockItems[] = 'Số lượng của sản phẩm "' . $cartItem->product->name . '" vượt quá số lượng tồn kho. Tồn kho hiện tại: ' . $variant->stock . ' sản phẩm.';
                }

                $cartItem->image_url = $cartItem->product->image_url ?? 'default_image.jpg'; // Gán ảnh sản phẩm
                $totalPrice += $cartItem->quantity * $cartItem->price;
                $totalQuantity += $cartItem->quantity;
            }

        } else {
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

        if (!empty($outOfStockItems)) {
            return back()->withErrors(['quantity' => $outOfStockItems]);
        }

        // Kiểm tra voucher
        $voucher = session('voucher', null);
        if ($voucher) {
            $voucherDetails = Voucher::where('code', $voucher['code'])->first();

            if ($totalPrice < $voucherDetails->min_order_value) {
                session()->forget('voucher');
                return back()->with('error', 'Giỏ hàng không đủ điều kiện để áp dụng mã giảm giá.');
            }
        }

        $estimatedTotal = $totalPrice;

        $vouchers = Voucher::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('usage_limit', '>', 0)
            ->get();

        $customer = auth('customer')->user();
        $addresses = $customer ? $customer->addresses : collect();
        $defaultAddress = $customer ? $addresses->firstWhere('is_default', 1) : null;

        return view('client.page.checkout.index', compact(
            'cart', 'cartItems', 'totalPrice', 'totalQuantity', 'estimatedTotal', 'defaultAddress', 'addresses', 'vouchers'
        ));
    }





    public function saveAddress(Request $request)
    {
        $address = $request->only(['name', 'phone', 'address']);
        session()->put('selected_address', $address);

        return response()->json(['status' => 'success', 'message' => 'Địa chỉ đã được lưu vào session.']);
    }



    // hiển thị và tính toán số lượng trong giỏ hàng 
    public function getCartItemCount()
    {
        $totalQuantity = 0;

        if (auth('customer')->check()) {
            $customerId = auth('customer')->id();
            $totalQuantity = Cart::where('customer_id', $customerId)->sum('quantity');
        } else {
            $cart = session()->get('cart', []);
            foreach ($cart as $productId => $models) {
                foreach ($models as $modelId => $colorModels) {
                    foreach ($colorModels as $item) {
                        $totalQuantity += $item['quantity'];
                    }
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