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
        $latestProducts = $latestProducts->paginate(6);

        return view('client.categories.shop-catalog', compact('latestProducts', 'colors', 'categories', 'capacities'));
    }




    public function getProductsByCategory($id, Request $request)
    {
        $colorId = $request->input('color_id'); // Lọc theo màu sắc
        $capacityId = $request->input('capacity_id'); // Lọc theo dung lượng
        $minPrice = $request->input('min_price'); // Giá tối thiểu
        $maxPrice = $request->input('max_price'); // Giá tối đa

        // Lấy danh sách danh mục, màu sắc, và dung lượng
        $categories = Category::withCount('products')->get();
        $colors = Color::all();
        $capacities = Capacity::withCount('products')->get();

        // Lọc sản phẩm
        // Lọc sản phẩm
        $productsByCategory = Product::where('category_id', $id)
            ->whereHas('variants', function ($query) use ($colorId, $capacityId, $minPrice, $maxPrice) {
                if ($colorId) {
                    $query->where('color_id', $colorId);
                }
                if ($capacityId) {
                    $query->where('capacity_id', $capacityId);
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

        // Trả về view
        return view('client.categories.products', compact(
            'productsByCategory',
            'categories',
            'colors',
            'capacities',
            'currentCategory',
            'productCount',
            'colorId',
            'capacityId',
            'minPrice',
            'maxPrice' // Thêm minPrice và maxPrice vào view
        ));
    }
}
