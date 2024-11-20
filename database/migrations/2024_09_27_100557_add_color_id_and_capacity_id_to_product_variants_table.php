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
        // Schema::table('product_variants', function (Blueprint $table) {
        //     $table->unsignedBigInteger('color_id')->change();
        //     $table->unsignedBigInteger('capacity_id')->change();
        //     // Gắn khóa ngoại cho 'color_id' nếu cột đã tồn tại
        //     if (Schema::hasColumn('product_variants', 'color_id')) {
        //         $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');
        //     }

        //     // Gắn khóa ngoại cho 'capacity_id' nếu cột đã tồn tại
        //     if (Schema::hasColumn('product_variants', 'capacity_id')) {
        //         $table->foreign('capacity_id')->references('id')->on('capacities')->onDelete('cascade');
        //     }
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('product_variants', function (Blueprint $table) {
        //     $table->dropForeign('color_id');
        //     $table->dropColumn('color_id');

        //     $table->dropForeign('capacity_id');
        //     $table->dropColumn('capacity_id');

        // });
    }
};
