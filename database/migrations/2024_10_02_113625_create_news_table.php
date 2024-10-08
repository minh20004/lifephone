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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->text('content');
            $table->foreignId('author_id')->constrained('users'); // Liên kết tới bảng users
            $table->foreignId('category_news_id')->constrained('category_news'); // Liên kết tới bảng categories
            $table->string('thumbnail')->nullable();
            $table->string('slug')->unique();
            $table->enum('status', ['published', 'draft', 'pending'])->default('draft'); // Cột status với kiểu enum
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
            $table->integer('views')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
