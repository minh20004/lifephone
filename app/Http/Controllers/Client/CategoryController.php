<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Capacity;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Phương thức lấy tất cả các danh mục

    // Phương thức lấy 10 sản phẩm mới nhất cùng với thông tin danh mục của chúng
    public function shop()
    {
        // Lấy danh sách các danh mục và đếm số lượng sản phẩm trong mỗi danh mục
        $categories = Category::withCount('products')->get();
        $colors = Color::all();
        $capacities = Capacity::withCount('products')->get();

        // Lấy 10 sản phẩm mới nhất và load danh mục và biến thể sản phẩm với màu sắc
        $latestProducts = Product::with([
            'category:id,name', // Eager load danh mục với id và name
            'variants.color:id,name', // Eager load màu sắc (color) thông qua biến thể sản phẩm
            'variants.capacity:id,name'
        ])
            ->orderBy('created_at', 'desc') // Lấy theo thứ tự mới nhất
            ->take(10) // Giới hạn 10 sản phẩm
            ->get();

        // Trả về view với các dữ liệu cần thiết
        return view('client.categories.shop-catalog', compact('latestProducts', 'categories', 'colors', 'capacities'));
    }
    public function filterByCategory(Request $request)
    {
        $categoryId = $request->get('category_id');

        // Lấy danh sách sản phẩm theo danh mục
        $products = Product::where('category_id', $categoryId)->with('variants.color', 'variants.capacity')->get();

        return response()->json($products);
    }
    public function filter(Request $request)
{
    $products = Product::whereIn('capacity_id', $request->capacities)->get();
    return response()->json($products);
}


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
// public function getProductsByCategory($id)
    // {
    //     $products = Product::where('category_id', $id)->get();
    //     dd($products); // Dừng lại và hiển thị kết quả
    // }
}