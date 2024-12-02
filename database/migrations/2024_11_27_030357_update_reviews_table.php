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
        Schema::table('reviews', function (Blueprint $table) {
            // Xóa khóa ngoại cũ và cột user_id
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // Thêm cột mới customer_id và thiết lập khóa ngoại
            $table->unsignedBigInteger('customer_id')->after('product_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Xóa khóa ngoại và cột customer_id
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');

            // Khôi phục cột user_id và khóa ngoại cũ
            $table->unsignedBigInteger('user_id')->after('product_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
