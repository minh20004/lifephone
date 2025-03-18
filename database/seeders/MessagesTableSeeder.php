<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('messages')->insert([
            [
                'conversationId' => 4,
                'senderId' => 1,  // Admin
                'senderType' => 'admin',
                'content' => encrypt('Hello, how can I help you?'),
                'iv' => 'randomiv12345', // Thực tế bạn nên tạo iv động
                'status' => 'unread',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'conversationId' => 4,
                'senderId' => 1,  // Admin
                'senderType' => 'admin',
                'content' => encrypt('Do you need assistance with something else?'),
                'iv' => 'randomiv12345', // Thực tế bạn nên tạo iv động
                'status' => 'unread',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'conversationId' => 5,
                'senderId' => 1,  // Admin khác
                'senderType' => 'admin',
                'content' => encrypt('Hi, how can I assist you today?'),
                'iv' => 'randomiv12345',
                'status' => 'unread',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'conversationId' => 5,
                'senderId' => 1,  // Admin khác
                'senderType' => 'admin',
                'content' => encrypt('Sorry, this conversation is closed.'),
                'iv' => 'randomiv12345',
                'status' => 'read',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'conversationId' => 4,  // Giả sử cuộc trò chuyện có ID 1
                'senderId' => 1,  // ID của customer 1
                'senderType' => 'customer',  // Người gửi là customer
                'content' => encrypt('Hello, I need help with my order.'),  // Mã hóa nội dung tin nhắn
                'iv' => 'randomivvector123',  // Vector khởi tạo (ví dụ)
                'status' => 'unread',  // Trạng thái tin nhắn
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'conversationId' => 5,
                'senderId' => 2,  // Giả sử customer 2
                'senderType' => 'customer',
                'content' => encrypt('Can you help me with the payment issue?'),
                'iv' => 'randomivvector456',
                'status' => 'unread',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'conversationId' => 5,  // Giả sử cuộc trò chuyện có ID 2
                'senderId' => 2,  // ID của customer 3
                'senderType' => 'customer',
                'content' => encrypt('I have a question about the delivery time.'),
                'iv' => 'randomivvector789',
                'status' => 'unread',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'conversationId' => 5,
                'senderId' => 2,  // Customer 3 gửi tin nhắn khác
                'senderType' => 'customer',
                'content' => encrypt('Please let me know the estimated delivery date.'),
                'iv' => 'randomivvector101',
                'status' => 'unread',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
