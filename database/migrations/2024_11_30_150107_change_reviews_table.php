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
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('capacity_id')->nullable();
    
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('set null');
            $table->foreign('capacity_id')->references('id')->on('capacities')->onDelete('set null');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            //
        });
    }
};
