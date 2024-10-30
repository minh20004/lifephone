<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use App\Models\Capacity;
use Illuminate\Http\Request;
use App\Models\ProductVariant;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
{
    $cart = session()->get('cart', []);
    $cartItems = [];
    $totalQuantity = 0; 
    $totalPrice = 0; 

    // Lấy danh sách sản phẩm, màu sắc và dung lượng từ cơ sở dữ liệu
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
                    // Tính tổng tiền cho sản phẩm hiện tại và thêm vào tổng tiền giỏ hàng
                    $itemTotal = $item['quantity'] * $item['price'];
                    $totalPrice += $itemTotal;

                    // Cập nhật tổng số lượng
                    $totalQuantity += $item['quantity'];

                    // Thêm sản phẩm vào giỏ hàng
                    $cartItems[] = [
                        'product' => $product,
                        'capacity' => $capacity,
                        'color' => $color,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'itemTotal' => $itemTotal, // Tổng tiền của sản phẩm này
                        'image_url' => $item['image_url'] ?? '',
                    ];
                }
            }
        }
    }

    // Tính tổng ước tính (có thể thêm logic cho giảm giá ở đây)
    // $estimatedTotal = $totalPrice - 110; // Ví dụ giảm giá $110

    // Truyền các biến vào view để hiển thị
    return view('client.page.cart.index', compact('cartItems', 'totalQuantity', 'totalPrice', ));
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
            // Cập nhật số lượng trong giỏ hàng nếu có sản phẩm tồn tại
            $cart[$productId][$modelId][$colorId]['quantity'] = $quantity;
            session()->put('cart', $cart); // Lưu lại giỏ hàng mới vào session
        }

        $itemTotal = $cart[$productId][$modelId][$colorId]['price'] * $quantity;

        // Tính tổng tiền của tất cả sản phẩm trong giỏ hàng
        $totalPrice = 0;
        foreach ($cart as $product) {
            foreach ($product as $model) {
                foreach ($model as $color) {
                    $totalPrice += $color['price'] * $color['quantity'];
                }
            }
        }

        return response()->json([
            'itemTotal' => number_format($itemTotal, 0, ',', '.') . ' đ',
            'totalPrice' => number_format($totalPrice, 0, ',', '.') . ' đ',
        ]);
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
