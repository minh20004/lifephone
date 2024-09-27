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
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade'); // liên kết với bảng users
            $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade'); // liên kết với bảng conversations
            $table->text('message');
            $table->boolean('is_read')->default(0); // trạng thái chưa đọc (mặc định 0)
            $table->timestamps();
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
