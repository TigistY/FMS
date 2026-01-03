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
        Schema::table('complaints', function (Blueprint $table) {
            $table->unsignedBigInteger('forwarded_from_user_id')->nullable(); // ያስተላለፈው ሰው
        $table->text('forward_note')->nullable(); // ለምን እንደተላለፈ ማብራሪያ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
        $table->dropColumn(['forwarded_from_user_id', 'forward_note']);
        });
    }
};
