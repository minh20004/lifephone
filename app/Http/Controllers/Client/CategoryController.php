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
        $minPrice = $request->get('min_price', 1000000); // Mặc định 0 nếu không có giá trị
        $maxPrice = $request->get('max_price', 10000000); // Mặc định giá tối đa

        // Lấy danh mục và số lượng sản phẩm trong mỗi danh mục
        $categories = Category::withCount('products')->get();

        // Lấy sản phẩm đã lọc theo giá
        $latestProducts = Product::with(['variants.color', 'variants.capacity'])
            ->whereHas('variants', function ($query) use ($minPrice, $maxPrice) {
                $query->whereBetween('price_difference', [$minPrice, $maxPrice]);
            })
            ->paginate(6); // Phân trang, mỗi trang 9 sản phẩm

        // Lấy sản phẩm mới nhất
        $newestProducts = Product::with(['variants.color', 'variants.capacity'])
            ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian tạo
            ->paginate(6);

        return view('client.categories.shop-catalog', compact('categories', 'latestProducts', 'newestProducts'));
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



// public function getProductsByCategory($id)
    // {
    //     $products = Product::where('category_id', $id)->get();
    //     dd($products); // Dừng lại và hiển thị kết quả
    // }
    public function search(Request $request)
    {
        $searchTerm = $request->query('search');

        // Lấy tất cả danh mục, màu sắc và dung lượng (nếu cần)
        $categories = Category::withCount('products')->get();
        $colors = Color::all();
        $capacities = Capacity::withCount('products')->get();

        // Lấy danh sách sản phẩm cùng với danh mục và các biến thể
        $latestProducts = Product::with([
            'category:id,name', // Eager load danh mục với id và name
            'variants.color:id,name', // Eager load màu sắc (color) thông qua biến thể sản phẩm
            'variants.capacity:id,name' // Eager load dung lượng (capacity)
        ])
        ->when($searchTerm, function ($query) use ($searchTerm) {
            return $query->where(function($q) use ($searchTerm) {
                // Tìm kiếm trong tên, mã sản phẩm và mô tả
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('product_code', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhereHas('category', function($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('variants.color', function($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('variants.capacity', function($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        })
        ->orderByRaw('CASE WHEN name LIKE ? THEN 0 ELSE 1 END', ["%{$searchTerm}%"])
        ->orderByRaw('CASE WHEN product_code LIKE ? THEN 0 ELSE 1 END', ["%{$searchTerm}%"])
        ->orderBy('category_id')
        ->paginate(10);

        return view('client.categories.searchProduct', compact('latestProducts', 'categories', 'colors', 'capacities'));
    }
}