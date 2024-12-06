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
        Schema::table('comments', function (Blueprint $table) {
              // Thêm cột user_id liên kết khóa ngoại với bảng users (cho phép null)
              $table->unsignedBigInteger('user_id')->nullable()->after('customer_id');
              $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
  
              // Cập nhật cột customer_id để cho phép null
              $table->unsignedBigInteger('customer_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // Khôi phục cột customer_id về trạng thái không null (nếu cần)
            $table->unsignedBigInteger('customer_id')->nullable(false)->change();
        });
    }
};
