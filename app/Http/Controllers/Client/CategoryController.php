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

    public function shop(Request $request)
    {
        // Lấy các tham số lọc
        $minPrice = $request->get('min_price', 1); // Mặc định 0 nếu không có giá trị
        $maxPrice = $request->get('max_price', 1000); // Mặc định giá tối đa

        // Lấy danh mục và số lượng sản phẩm trong mỗi danh mục
        $categories = Category::withCount('products')->get();

        // Lấy sản phẩm đã lọc theo giá
        $latestProducts = Product::with(['variants.color', 'variants.capacity'])
            ->whereHas('variants', function ($query) use ($minPrice, $maxPrice) {
                $query->whereBetween('price_difference', [$minPrice, $maxPrice]);
            })
            ->paginate(6); // Phân trang, mỗi trang 9 sản phẩm

        // Lấy sản phẩm mới nhất
        $newestProducts = Product::latest('created_at')->paginate(6);

        return view('client.categories.shop-catalog', compact('categories', 'latestProducts', 'newestProducts'));
    }

    public function getProductsByCategory($id, Request $request)
    {
        // Lọc theo các tham số
        $capacityId = $request->input('capacity_id');
        $minPrice = $request->get('min_price', 1);
        $maxPrice = $request->get('max_price', 1000);
        $perPage = $request->get('per_page', 6);  // Số sản phẩm mỗi trang
        $category = Category::findOrFail($id);
        $products = $category->products()->paginate(12);
        // Lấy danh sách sản phẩm với các bộ lọc
        $productsByCategory = Product::where('category_id', $id)
            ->whereHas('variants', function ($query) use ($capacityId, $minPrice, $maxPrice) {
                if ($capacityId) {
                    $query->where('capacity_id', $capacityId);
                }
                $query->whereBetween('price_difference', [$minPrice, $maxPrice]);
            })
            ->with(['variants.capacity'])
            ->paginate($perPage);  // Phân trang

        // Các đối tượng khác (categories, capacities)
        $categories = Category::withCount('products')->get();
        $capacities = Capacity::withCount('products')->get();
        $currentCategory = Category::findOrFail($id);

        // Trả về view
        return view('client.categories.products', compact(
            'productsByCategory',
            'categories',
            'products',
            'capacities',
            'currentCategory'
        ));
    }
}
