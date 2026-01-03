<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('feedbacks', function (Blueprint $table) {
        // status ኮለምን ከሌለ ይጨምራል
        if (!Schema::hasColumn('feedbacks', 'status')) {
            $table->string('status')->default('New')->after('body');
        }
    });
}

public function down()
{
    Schema::table('feedbacks', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};
