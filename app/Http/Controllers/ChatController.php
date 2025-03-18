<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Customer;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class chatController extends Controller
{
  function chatBoard(Request $request){
    $customerId = $request->input('customerId');

    $admin = User::first();

    $existingConversation = Conversation::where('customerId', $customerId)
                                         ->where('userId', $admin->id)
                                         ->first();

    if ($existingConversation) {
        return response()->json([
            'message' => 'Khách hàng đã có cuộc trò chuyện với admin rồi.',
            'conversationId' => $existingConversation->id,
        ], 201);
    }

    $conversation = Conversation::create([
        'userId' => $admin->id,
        'customerId' => $customerId,
        'status' => 'on',
    ]);

    return response()->json([
        'message' => 'Cuộc trò chuyện đã được tạo thành công.',
        'conversationId' => $conversation->id,
    ], 201);
  }

  function indexChatBoard(){
    $admin = User::first();
    $conversations = Conversation::where('userId', $admin->id)->get();
    $customers = Customer::all();
    $messages = Message::all();
    return view('admin.page.chatBoard.chatBoard', compact('conversations', 'customers', 'messages', 'admin'));
  }

}
