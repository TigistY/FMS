<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
       Schema::create('feedbacks', function (Blueprint $table) {
    $table->id();
   $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); 
   $table->foreignId('guest_id')->nullable()->constrained('guests')->onDelete('set null'); 
    $table->foreignId('unit_id')->constrained('units')->onDelete('cascade')->onDelete('cascade');
    $table->string('subject');
    $table->text('body');
    $table->boolean('is_anonymous')->default(false); 
    $table->timestamps();



    
});
    }

    
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
