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
        // 'Positive', 'Negative' ወይም 'Suggestion' የሚሉ ዳታዎችን እንዲይዝ
        $table->string('feedback_type')->after('status'); 
    });
}

public function down(): void
{
    Schema::table('feedbacks', function (Blueprint $table) {
        $table->dropColumn('feedback_type');
    });
}
};
