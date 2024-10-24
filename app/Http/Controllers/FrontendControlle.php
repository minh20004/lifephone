<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontendControlle extends Controller
{
        public function index()
    {
          // Lấy 8 sản phẩm mới nhất
          $latestProducts = Product::orderBy('created_at', 'desc')->take(8)->get();

          // Lấy 10 sản phẩm thịnh hành dựa vào lượt xem
          $trendingProducts = Product::orderBy('views', 'desc')->take(10)->get();

          // Kiểm tra nếu số lượng sản phẩm thịnh hành ít hơn 10
          if ($trendingProducts->count() < 10) {
              // Tính số sản phẩm ngẫu nhiên cần lấy thêm
              $randomProducts = Product::whereNotIn('id', $trendingProducts->pluck('id'))
                  ->inRandomOrder()
                  ->take(10 - $trendingProducts->count())
                  ->get();

              // Hợp nhất các sản phẩm thịnh hành với sản phẩm ngẫu nhiên
              $trendingProducts = $trendingProducts->merge($randomProducts);
          }
          return view('index', compact('latestProducts', 'trendingProducts'));
    }
      
    
}
