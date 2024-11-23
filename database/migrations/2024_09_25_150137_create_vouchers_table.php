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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('discount_percentage', 5, 2);
            $table->decimal('max_discount_amount', 10, 2);
            $table->decimal('min_order_value', 10, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('usage_limit');
            // $table->softDeletes(); // Dòng này sẽ tự động thêm cột deleted_at    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
