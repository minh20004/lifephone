<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Review;
use Illuminate\Http\Request;

class CommentController extends Controller
{

          public function store(Request $request)
        {
            $request->validate([
                'review_id' => 'required|exists:reviews,id',
                'comment' => 'required|min:5',
            ]);
    
            Comment::create([
                'review_id' => $request->review_id,
                'customer_id' => auth()->id(),
                'comment' => $request->comment,
            ]);
    
            return back()->with('success', 'Phản hồi đã được gửi.');
        }
        public function reply(Request $request, $commentId)
        {
            $customer_id = auth()->check() ? auth()->id() : null;  // Nếu đã đăng nhập thì lấy customer_id từ auth, nếu không thì để null
        
            $reply = new Comment();
            $reply->review_id= $commentId;
            $reply->customer_id = $customer_id; // Nếu không có đăng nhập, để null
            $reply->comment = $request->comment;
            $reply->save();
        
            return redirect()->back()->with('success', 'Phản hồi đã được gửi!');
        }
        public function replyAsAdmin(Request $request, $reviewId)
        {
            // Validate dữ liệu nhập
            $request->validate([
                'comment' => 'required|string|max:1000',
            ]);
    
            // Tạo một phản hồi mới
            $replyAsAdmin = new Comment();
            $replyAsAdmin->review_id = $reviewId; // Gắn với review được phản hồi
            $replyAsAdmin->user_id = auth()->user()->id; // Lấy ID admin (người đăng nhập)
            $replyAsAdmin->customer_id = null; // Phản hồi từ admin, không gắn với customer
            $replyAsAdmin->comment = $request->comment; // Nội dung phản hồi
            $replyAsAdmin->is_admin_reply = true; // Đánh dấu đây là phản hồi của admin
            $replyAsAdmin->save();
    
            // Chuyển hướng với thông báo thành công
            return redirect()->back()->with('success', 'Phản hồi từ Admin đã được gửi!');
        }
        public function showComments($reviewId)
    {
        // Lấy bình luận và các phản hồi liên quan
        $review = Review::with('comments.loadAllUser', 'comments.loadAllCustomer')->findOrFail($reviewId);
    
        // Lấy danh sách phản hồi
        $comments = $review->comments;
    
        // Trả về view
        return view('admin.reviews.comments', compact('review', 'comments'));
    }
    }

