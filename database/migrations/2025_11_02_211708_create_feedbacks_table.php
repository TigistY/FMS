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
       Schema::create('feedbacks', function (Blueprint $table) {
    $table->id();
   $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // የተመዘገበ ከሆነ
   $table->foreignId('guest_id')->nullable()->constrained('guests')->onDelete('set null'); // እንግዳ ከሆነ
    $table->foreignId('unit_id')->constrained('units')->onDelete('cascade')->onDelete('cascade');
    $table->string('subject');
    $table->text('body');
    $table->boolean('is_anonymous')->default(false); //comment('true ከሆነ user_id እና guest_email_id ባዶ መሆን አለባቸው');
    $table->timestamps();



    //enzhi ke compalin table lay nw miyaseflgute
    //$table->timestamp('due_date')->nullable(); // ቅሬታው ምላሽ መስጠት ያለበት ቀን
   // $table->enum('status', ['Pending', 'Assigned', 'In Progress', 'Resolved', 'Closed'])->default('Pending');
    //$table->enum('priority', ['Low', 'Medium', 'High', 'Urgent'])->default('Medium');
    
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
