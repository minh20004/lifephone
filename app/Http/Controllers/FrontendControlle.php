<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Capacity;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontendControlle extends Controller
{
    public function index()
    {
        //8 sản phẩm mới nhất
        $latestProducts = Product::orderBy('created_at', 'desc')->take(8)->get();

        //10 sản phẩm thịnh hành dựa vào lượt xem
        $trendingProducts = Product::orderBy('views', 'desc')->take(10)->get();

        //sản phẩm thịnh hành
        if ($trendingProducts->count() < 10) {
            $randomProducts = Product::whereNotIn('id', $trendingProducts->pluck('id'))
                ->inRandomOrder()
                ->take(10 - $trendingProducts->count())
                ->get();
            $trendingProducts = $trendingProducts->merge($randomProducts);
        }
         // Lấy danh sách danh mục (với giới hạn số lượng nếu cần)
        $categories = Category::take(11)->get();
        return view('index', compact('latestProducts', 'trendingProducts', 'categories'));
    }


    public function index_cate_all()
    {
        $categories = Category::with(['products' => function ($query) {
            $query->take(5); // Lấy 5 sản phẩm liên quan
        }])->paginate(8);

        return view('client/page/category/cate-all', compact('categories'));
    }

    public function getProductsByCategory($id, Request $request)
    {
        // Lọc theo các tham số
        $capacityId = $request->input('capacity_id');
        $minPrice = $request->get('min_price', 1000000);
        $maxPrice = $request->get('max_price', 10000000);
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

    
    public function filter(Request $request)
    {
        $products = Product::whereIn('capacity_id', $request->capacities)->get();
        return response()->json($products);
    }
    
}
