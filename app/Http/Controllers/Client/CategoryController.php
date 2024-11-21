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

        // Lấy 10 sản phẩm mới nhất và load danh mục và biến thể sản phẩm với màu sắc
        $latestProducts = Product::with([
            'variants.color:id,name',
            'variants.capacity:id,name',
        ])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // dd($latestProducts->toArray());

        // Trả về view với các dữ liệu cần thiết
        return view('client.categories.shop-catalog', compact('latestProducts', 'categories', 'colors', 'capacities'));
    }


    public function getProductsByCategory($id)
    {
        // Lấy danh sách danh mục và đếm số lượng sản phẩm
        $categories = Category::withCount('products')->get();
        $colors = Color::all();
        $capacities = Capacity::withCount('products')->get();

        // Lọc sản phẩm theo danh mục `$id` và load các quan hệ cần thiết
        $productsByCategory = Product::with([
            'category:id,name', // Eager load danh mục với id và name
            'variants.color:id,name', // Eager load màu sắc (color) thông qua biến thể sản phẩm
            'variants.capacity:id,name'
        ])
            ->where('category_id', $id) // Lọc theo danh mục
            ->orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo mới nhất
            ->get();

        // Lấy thông tin danh mục hiện tại
        $currentCategory = Category::findOrFail($id);

        // Trả về view với các dữ liệu cần thiết
        return view('client.categories.products', compact('productsByCategory', 'categories', 'colors', 'capacities', 'currentCategory'));
    }
}
