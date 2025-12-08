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
        
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            
        
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('guest_id')->nullable()->constrained('guests')->onDelete('set null');
            $table->boolean('is_anonymous')->default(false);
        
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->string('subject');
            $table->text('body');
        
            $table->enum('status', ['Pending', 'Assigned', 'In Progress', 'Resolved', 'Closed'])->default('Pending');
            $table->enum('priority', ['Low', 'Medium', 'High', 'Urgent'])->default('Medium');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};