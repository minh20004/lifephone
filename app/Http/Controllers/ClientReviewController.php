<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ClientReviewController extends Controller
{public function showProductReviews($id)
    {    $product = Product::findOrFail($id);

        $reviews = Review::where('product_id', $id)->get();
        $reviewCount = $reviews->count();
        $averageRating = $reviews->avg('rating') ?? 0;
    

return view('client.page.detail-product.general', compact('reviews', 'reviewCount', 'averageRating'));

}
}