<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversationId')->constrained('conversations')->onDelete('cascade');  // Liên kết với bảng conversations
            $table->foreignId('senderId');  // ID người gửi
            $table->enum('senderType', ['admin', 'customer']);  // Xác định người gửi là admin hay customer
            $table->text('content');  // Nội dung tin nhắn
            $table->string('iv', 32);  // Vector khởi tạo (IV) cho mã hóa
            $table->enum('status', ['unread', 'read'])->default('unread');  // Trạng thái tin nhắn
            $table->timestamps();  // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
