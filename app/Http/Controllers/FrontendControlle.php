<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
          return view('index', compact('latestProducts', 'trendingProducts'));
    }
    
    
}
