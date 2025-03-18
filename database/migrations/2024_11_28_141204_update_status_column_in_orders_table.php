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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', [
                'Chờ xác nhận',
                'Đã xác nhận',
                'Đang giao hàng',
                'Đã hoàn thành',
                'Đã hủy',
                'Chờ thanh toán',  // Trạng thái mới
                'Thanh toán thất bại'  // Trạng thái mới
            ])->default('Chờ xác nhận')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', [
                'Chờ xác nhận',
                'Đã xác nhận',
                'Đang giao hàng',
                'Đã hoàn thành',
                'Đã hủy',
            ])->default('Chờ xác nhận')->change();
        });
    }
};
