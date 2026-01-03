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
        Schema::table('feedbacks', function (Blueprint $table) {
    $table->foreignId('forwarded_from_user_id')->nullable()->constrained('users')->onDelete('set null');
    $table->text('forward_note')->nullable();
});
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {
        $table->dropColumn(['forwarded_from_user_id', 'forward_note']);
        });
    }
};
