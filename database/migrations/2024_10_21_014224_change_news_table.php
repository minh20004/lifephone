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
        Schema::table('news', function (Blueprint $table) {
            //
<<<<<<< Updated upstream
            $table->string('slug')->unique();
=======
>>>>>>> Stashed changes
            $table->timestamp('scheduled_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            //
<<<<<<< Updated upstream
            $table->dropColumn('slug');
=======
>>>>>>> Stashed changes
            $table->dropColumn('scheduled_at');

        });
    }
};
