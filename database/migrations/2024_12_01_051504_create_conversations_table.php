<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userId')->constrained('users')->onDelete('cascade');  // Liên kết với bảng users (admin)
            $table->foreignId('customerId')->constrained('customers')->onDelete('cascade');  // Liên kết với bảng customers
            $table->enum('status', ['on', 'off'])->default('on');  // Trạng thái cuộc trò chuyện
            $table->timestamps();  // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversations');
    }
}
