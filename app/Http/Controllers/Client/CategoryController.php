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
    public function shop()
    {
        // Lấy danh sách các danh mục và đếm số lượng sản phẩm trong mỗi danh mục
        $categories = Category::withCount('products')->get();
        $colors = Color::all();
        $capacities = Capacity::withCount('products')->get();

        // Lấy các sản phẩm, phân trang và load danh mục, biến thể sản phẩm với màu sắc
        $latestProducts = Product::with([
            'variants' => function ($query) {
                $query->select('id', 'product_id', 'price_difference', 'color_id', 'capacity_id') // Lấy giá và các thông tin cần thiết
                    ->with([
                        'color:id,name',     // Thông tin màu sắc
                        'capacity:id,name'  // Thông tin dung lượng
                    ]);
            }
        ])
            ->select('id', 'name', 'image_url', 'category_id') // Chỉ lấy các cột cần thiết từ bảng products
            ->orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo
            ->paginate(9); // Phân trang 10 sản phẩm mỗi trang

        // Trả về view với các dữ liệu cần thiết
        return view('client.categories.shop-catalog', compact('latestProducts', 'categories', 'colors', 'capacities'));
    }


    public function getProductsByCategory($id, Request $request)
    {
        $colorId = $request->input('color_id');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $capacityIds = explode(',', $request->input('capacity_ids', ''));

        // Lấy danh sách danh mục kèm số lượng sản phẩm
        $categories = Category::withCount('products')->get();
        $colors = Color::all();
        $capacities = Capacity::withCount('products')->get();

        // Lọc sản phẩm theo danh mục, màu sắc, giá và dung lượng
        $productsByCategory = Product::where('category_id', $id)
            ->when($colorId, function ($query, $colorId) {
                $query->whereHas('variants', function ($subQuery) use ($colorId) {
                    $subQuery->where('color_id', $colorId);
                });
            })
            ->when($minPrice, function ($query, $minPrice) {
                $query->whereHas('variants', function ($subQuery) use ($minPrice) {
                    $subQuery->where('price_difference', '>=', $minPrice);
                });
            })
            ->when($maxPrice, function ($query, $maxPrice) {
                $query->whereHas('variants', function ($subQuery) use ($maxPrice) {
                    $subQuery->where('price_difference', '<=', $maxPrice);
                });
            })
            ->when($capacityIds, function ($query, $capacityIds) {
                $query->whereHas('variants', function ($subQuery) use ($capacityIds) {
                    $subQuery->whereIn('capacity_id', $capacityIds);
                });
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

        $currentCategory = Category::findOrFail($id);
        $productCount = $productsByCategory->total();

        return view('client.categories.products', compact(
            'productsByCategory',
            'categories',
            'colors',
            'capacities',
            'currentCategory',
            'productCount',
            'colorId',
            'minPrice',
            'maxPrice',
            'capacityIds'
        ));
    }
}
