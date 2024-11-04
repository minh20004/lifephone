<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Auth;
class chatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('client/layout/partials/footer');
    }
    // Khởi tạo cuộc trò chuyện
    public function startConversation(Request $request)
    {
        $request->validate([
            'userName' => 'required|string|max:255',
            'userPhone' => 'required|string|max:20',
        ]);

        // Tìm hoặc tạo một người dùng dựa trên số điện thoại hoặc email
        $user = User::firstOrCreate(
            ['email' => $request->input('userEmail')],
            [
                'name' => $request->input('userName'),
                'phone' => $request->input('userPhone'),
                'role' => 'customer'
            ]
        );

        // Tạo cuộc trò chuyện mới
        $conversation = Conversation::create(['customer_id' => $user->id]);

        return response()->json(['conversation_id' => $conversation->id]);
    }

    // Gửi tin nhắn
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'conversation_id' => $request->input('conversation_id'),
            'sender_id' => Auth::id(),
            'receiver_id' => 1, // ID của admin, hoặc điều chỉnh theo nhu cầu
            'message' => $request->input('message'),
            'is_read' => 0
        ]);

        return response()->json(['message' => $message]);
    }

    // Lấy danh sách tin nhắn của cuộc trò chuyện
    public function getMessages(Conversation $conversation)
    {
        $messages = $conversation->messages()->orderBy('created_at', 'asc')->get();
        return response()->json(['messages' => $messages]);
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
