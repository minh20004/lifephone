<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id'); // Thêm cột user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Thiết lập khóa ngoại
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Xóa khóa ngoại
            $table->dropColumn('user_id');   // Xóa cột user_id
        });
    }
}
