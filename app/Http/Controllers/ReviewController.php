<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listReview = Review::paginate(10);
        return view('admin.page.review.index', compact('listReview'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request ,$productId)
    {
        if (!auth()->check()) {
            return redirect()->route('customer.login')->with('error', 'Vui lòng đăng nhập để đánh giá.');
        }
        else{
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:500',
        ]);

        // Lấy user ID của người dùng đăng nhập
        $userId = auth()->id();

        // Lưu đánh giá vào database
        Review::create([
            'product_id' => $productId,
            'customer_id' => $userId,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi.');
    }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->route('review.index');
    }
    public function showProductReviews($id)
    {    $product = Product::findOrFail($id);

        $reviews = Review::where('product_id', $id)->get();
        $reviewCount = $reviews->count();
        $averageRating = $reviews->avg('rating') ?? 0;
    

return view('client.page.detail-product.general', compact('reviews', 'reviewCount', 'averageRating'));

}
}