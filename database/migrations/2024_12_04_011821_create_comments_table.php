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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_id'); // Khóa ngoại
            $table->unsignedBigInteger('customer_id');  // Người dùng viết phản hồi
            $table->text('comment');                // Nội dung phản hồi
            $table->timestamps();
        
            // Thiết lập khóa ngoại
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
