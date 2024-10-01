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
        Schema::table('product_variants', function (Blueprint $table) {
            $table->foreignId('color_id')->after('product_id')->constrained('colors')->onDelete('cascade');
            $table->foreignId('capacity_id')->after('color_id')->constrained('capacities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropForeign('color_id');
            $table->dropColumn('color_id');

            $table->dropForeign('capacity_id');
            $table->dropColumn('capacity_id');

        });
    }
};
