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
        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('color_id')->nullable()->after('variant_id');
            $table->unsignedBigInteger('capacity_id')->nullable()->after('color_id');
            
            // Thiết lập khóa ngoại cho color_id và capacity_id
            $table->foreign('color_id')->references('id')->on('colors');
            $table->foreign('capacity_id')->references('id')->on('capacities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Xóa các khóa ngoại và cột đã thêm
            $table->dropForeign(['color_id']);
            $table->dropForeign(['capacity_id']);
            $table->dropColumn(['color_id', 'capacity_id']);
        });
    }
};
