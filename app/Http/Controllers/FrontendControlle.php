<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontendControlle extends Controller
{
        public function index()
    {
        // Fetch the latest 8 products ordered by creation date
        $latestProducts = Product::orderBy('created_at', 'desc')->take(8)->get();
        
        // Fetch the top 10 trending products ordered by views
        // $trendingProducts = Product::with('category')
        //     ->orderBy('views', 'desc')
        //     ->take(10)
        //     ->get();
            
        // Return the view with both latest and trending products
        return view('index', compact('latestProducts'));
    }

}
