<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class chatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     return view('');
    // }
    protected $adminId = 1; // Giả định admin có ID là 1

    public function startConversation(Request $request)
    {
        // Kiểm tra hoặc lưu thông tin người dùng từ form
        $user = User::firstOrCreate(
            ['email' => $request->userEmail],
            [
                'name' => $request->userName,
                'phone' => $request->userPhone,
                'gender' => $request->userGender,
            ]
        );

        // Tạo cuộc hội thoại giữa người dùng và admin
        $conversation = Conversation::firstOrCreate(
            ['customer_id' => $user->id, 'admin_id' => $this->adminId]
        );

        // Lưu tin nhắn mở đầu nếu có
        if ($request->userMessage) {
            Message::create([
                'sender_id' => $user->id,
                'receiver_id' => $this->adminId,
                'conversation_id' => $conversation->id,
                'message' => $request->userMessage,
                'is_read' => false,
            ]);
        }

        return response()->json(['conversation_id' => $conversation->id]);
    }

    public function sendMessage(Request $request, $conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        $senderId = Auth::id();
        $receiverId = $this->adminId; // Đảm bảo tin nhắn được gửi đến admin

        // Lưu tin nhắn
        $message = Message::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'conversation_id' => $conversationId,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return response()->json($message);
    }

    public function getMessages($conversationId)
    {
        // Lấy tất cả tin nhắn trong cuộc hội thoại
        $messages = Message::where('conversation_id', $conversationId)
                           ->orderBy('created_at', 'asc')
                           ->get();

        return response()->json($messages);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}
