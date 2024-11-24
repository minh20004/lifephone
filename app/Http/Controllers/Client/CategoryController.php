<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Capacity;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class   CategoryController extends Controller
{
    // Phương thức lấy tất cả các danh mục

    // Phương thức lấy 10 sản phẩm mới nhất cùng với thông tin danh mục của chúng
    public function shop(Request $request)
    {
        $colorId = $request->input('color_id');

        // Lấy danh sách các màu và các danh mục
        $colors = Color::all();
        $categories = Category::withCount('products')->get();
        $capacities = Capacity::withCount('products')->get();

        // Lấy sản phẩm, phân trang và lọc theo màu nếu có color_id
        $latestProducts = Product::with([
            'variants' => function ($query) {
                $query->select('id', 'product_id', 'price_difference', 'color_id', 'capacity_id')
                    ->with([
                        'color:id,name',
                        'capacity:id,name'
                    ]);
            }
        ])
            ->select('id', 'name', 'image_url', 'category_id')
            ->orderBy('created_at', 'desc');

        // Nếu có color_id, thêm điều kiện lọc theo màu
        if ($colorId) {
            $latestProducts->whereHas('variants', function ($query) use ($colorId) {
                $query->where('color_id', $colorId);
            });
        }

        // Phân trang 9 sản phẩm mỗi trang
        $latestProducts = $latestProducts->paginate(9);

        return view('client.categories.shop-catalog', compact('latestProducts', 'colors', 'categories', 'capacities'));
    }




    public function getProductsByCategory($id, Request $request)
{
    $colorId = $request->input('color_id'); // Nhận ID màu từ request
    $capacityIds = $request->input('capacity_ids', []); // Nhận danh sách ID dung lượng từ request
    $minPrice = $request->input('min_price', 0); // Giá tối thiểu, mặc định là 0
    $maxPrice = $request->input('max_price', null); // Giá tối đa, null nếu không được đặt

    // Lấy danh sách danh mục kèm số lượng sản phẩm
    $categories = Category::withCount('products')->get();

    // Lấy danh sách màu sắc và dung lượng
    $colors = Color::all();
    $capacities = Capacity::withCount('products')->get();

    // Lọc sản phẩm theo danh mục, màu sắc, dung lượng và khoảng giá
    $productsByCategory = Product::where('category_id', $id)
        ->whereHas('variants', function ($query) use ($colorId, $capacityIds, $minPrice, $maxPrice) {
            if ($colorId) {
                $query->where('color_id', $colorId);
            }
            if (!empty($capacityIds)) {
                $query->whereIn('capacity_id', $capacityIds);
            }
            if ($minPrice) {
                $query->where('price_difference', '>=', $minPrice);
            }
            if ($maxPrice) {
                $query->where('price_difference', '<=', $maxPrice);
            }
        })
        ->with([
            'category:id,name',
            'variants' => function ($query) {
                $query->select('id', 'product_id', 'price_difference', 'color_id', 'capacity_id')
                    ->with(['color:id,name', 'capacity:id,name']);
            }
        ])
        ->select('id', 'name', 'image_url', 'category_id')
        ->orderBy('created_at', 'desc')
        ->paginate(9);

    // Lấy thông tin danh mục hiện tại
    $currentCategory = Category::findOrFail($id);

    // Lấy số lượng sản phẩm trong danh mục
    $productCount = $productsByCategory->total();

    // Trả về view với các dữ liệu cần thiết
    return view('client.categories.products', compact(
        'productsByCategory',
        'categories',
        'colors',
        'capacities',
        'currentCategory',
        'productCount',
        'colorId',
        'capacityIds',
        'minPrice',
        'maxPrice'
    ));
}
   
}
