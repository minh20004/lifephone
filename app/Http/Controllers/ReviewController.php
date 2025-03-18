<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $listReview = Review::with('loadAllProduct')->paginate(10);
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
        }
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:500',
        ]);
        
        $userId = auth()->id();
        
        // Kiểm tra xem khách hàng đã mua sản phẩm này chưa
        $orderItems = OrderItem::whereHas('order', function ($query) use ($userId) {
            $query->where('customer_id', $userId)
                  ->where('status', 'Đã hoàn thành'); // Điều kiện trạng thái đơn hàng
        })->where('product_id', $productId)->get();
        
        if ($orderItems->isEmpty()) {
            return redirect()->back()->with('error', 'Bạn chưa mua sản phẩm này nên không thể đánh giá.');
        }
        
        // Kiểm tra nếu khách hàng đã bình luận cho bất kỳ lần mua nào
        $existingReview = Review::where('product_id', $productId)
                                ->where('customer_id', $userId)
                                ->exists();
        
        if ($existingReview) {
            return redirect()->back()->with('error', 'Bạn đã đánh giá sản phẩm này.');
        }
        
        // Lưu đánh giá mới
        Review::create([
            'product_id' => $productId,
            'customer_id' => $userId,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);
        
        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


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
        return redirect()->route('review_admin.index');
    }
    public function like(Request $request)
    {
        $review = Review::find($request->review_id);
        if ($review) {
            $review->increment('likes');
            return response()->json(['success' => true, 'likes' => $review->likes]);
        }

        return response()->json(['success' => false]);
    }

    public function dislike(Request $request)
    {
        $review = Review::find($request->review_id);
        if ($review) {
            $review->increment('dislikes');
            return response()->json(['success' => true, 'dislikes' => $review->dislikes]);
        }

        return response()->json(['success' => false]);
}
public function showDeletedReviews()
{
    // Lấy tất cả review đã bị xóa mềm
    $deletedReviews = Review::onlyTrashed()
        ->paginate(10); // Phân trang nếu cần

    return view('admin.page.review.deleted', compact('deletedReviews'));
}
public function restoreReview($id)
{
    $review = Review::onlyTrashed()->findOrFail($id);

    // Khôi phục review
    $review->restore();

    return redirect()->route('reviews.deleted')->with('success', 'Review đã được khôi phục.');
}
public function respond(Request $request, $id)
{
    $request->validate([
        'admin_response' => 'required|string|max:1000',
    ]);

    $review = Review::findOrFail($id);
    $review->admin_response = $request->admin_response;
    $review->save();

    return redirect()->route('review_admin.index')->with('success', 'Phản hồi đã được gửi!');
}
public function showCustomerReviews($customerId)
{
    // Lấy tất cả các đánh giá của người dùng với ID cụ thể
    $customerReviews = Review::with('product')
        ->where('customer_id', $customerId)
        ->paginate(5); 

    // Trả về view và truyền dữ liệu đánh giá
    return view('client.page.auth.page.review', [
        'customerReviews' => $customerReviews
    ]);
}
}