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
}