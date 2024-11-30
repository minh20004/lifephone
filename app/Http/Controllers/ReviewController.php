<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function store(Request $request, $productId)
    {
        if (!auth()->check()) {
            return redirect()->route('customer.login')->with('error', 'Vui lòng đăng nhập để đánh giá.');
        } else {
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
    {
        $product = Product::findOrFail($id);

        $reviews = Review::where('product_id', $id)->get();
        $reviewCount = $reviews->count();
        $averageRating = $reviews->avg('rating') ?? 0;


        return view('client.page.detail-product.general', compact('reviews', 'reviewCount', 'averageRating'));
    }
    public function like(Request $request, $reviewId)
{
    $customer_id  = auth()->id(); // Lấy ID của người dùng hiện tại

    // Kiểm tra nếu người dùng đã like hoặc dislike bài review này
    $existing = DB::table('likes_dislikes')
        ->where('review_id', $reviewId)
        ->where('customer_id ', $customer_id )
        ->first();

    if ($existing) {
        return response()->json(['message' => 'Bạn đã thực hiện hành động này rồi!'], 403);
    }

    // Thêm like
    DB::table('likes_dislikes')->insert([
        'review_id' => $reviewId,
        'customer_id ' => $customer_id ,
        'type' => 'like',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Tăng số lượt like
    Review::where('id', $reviewId)->increment('likes');

    return response()->json(['message' => 'Like thành công!', 'likes' => Review::find($reviewId)->likes]);
}

public function dislike(Request $request, $reviewId)
{
    $customer_id = auth()->id();

    // Kiểm tra nếu người dùng đã like hoặc dislike bài review này
    $existing = DB::table('likes_dislikes')
        ->where('review_id', $reviewId)
        ->where('customer_id ', $customer_id)
        ->first();

    if ($existing) {
        return response()->json(['message' => 'Bạn đã thực hiện hành động này rồi!'], 403);
    }

    // Thêm dislike
    DB::table('likes_dislikes')->insert([
        'review_id' => $reviewId,
        'customer_id ' => $customer_id,
        'type' => 'dislike',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Tăng số lượt dislike
    Review::where('id', $reviewId)->increment('dislikes');

    return response()->json(['message' => 'Dislike thành công!', 'dislikes' => Review::find($reviewId)->dislikes]);
}

}
