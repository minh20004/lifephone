<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
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
    return view('client.categories.shop-catalog', compact('latestProducts', 'categories', 'colors'));
}

    

    // public function getProductsByCategory($id)
    // {
    //     $products = Product::where('category_id', $id)->get();
    //     dd($products); // Dừng lại và hiển thị kết quả
    // }
}
