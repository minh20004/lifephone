<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function shop()
    {
        // Lấy 10 sản phẩm mới nhất và chỉ lấy tên danh mục
        $latestProducts = Product::with('category:id,name') // Chỉ lấy id và tên của danh mục
                                  ->orderBy('created_at', 'desc')
                                  ->take(10)
                                  ->get();

        return view('client.categories.shop-catalog', compact('latestProducts'));
    }
}
