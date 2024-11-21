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
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); // ID tự động tăng
            $table->string('email')->unique(); // Email duy nhất
            $table->string('phone')->nullable(); // Số điện thoại (có thể để trống)
            $table->text('address')->nullable(); // Địa chỉ (có thể để trống)
            $table->enum('gender', ['male', 'female', 'other'])->default('other'); // Giới tính
            $table->string('avatar')->nullable(); // Đường dẫn ảnh đại diện
            $table->string('password'); // Mật khẩu
            $table->timestamps(); // Thêm created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
