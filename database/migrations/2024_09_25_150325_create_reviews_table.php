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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // Chỉ giữ một lần khai báo id
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId(column: 'user_id')->constrained(table: 'users')->onDelete(action: 'cascade');
            $table->integer('rating')->default(value: 1); // Thang điểm 1-5
            $table->text('comment')->nullable();
            $table->timestamps(); // Chỉ giữ một lần khai báo timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
