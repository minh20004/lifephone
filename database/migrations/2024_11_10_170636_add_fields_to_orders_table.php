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
            $table->string('name')->after('user_id')->nullable();
            $table->text('address')->after('name')->nullable();
            $table->string('phone', 20)->after('address')->nullable();
            $table->string('email')->after('phone')->nullable();
            $table->text('description')->after('email')->nullable();
            $table->string('payment_method', 50)->after('description')->nullable(); //phương thức thanh toán
            $table->string('shipping_method', 50)->after('payment_method')->nullable();//phương thức vận chuyển
            $table->decimal('shipping_fee', 10, 2)->after('shipping_method')->nullable(); // lưu phí vận chuyển
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'name', 
                'address', 
                'phone', 
                'email', 
                'description', 
                'payment_method', 
                'shipping_method', 
                'shipping_fee'
            ]);
        });
    }
};
