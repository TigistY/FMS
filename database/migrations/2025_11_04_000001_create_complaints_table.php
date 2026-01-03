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
        //aseflagi
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            
            // ሪፖርተሩ የተመዘገበ ተጠቃሚ ከሆነ
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            // ሪፖርተሩ እንግዳ ከሆነ (Guest)
            $table->foreignId('guest_id')->nullable()->constrained('guests')->onDelete('set null');
            
            $table->boolean('is_anonymous')->default(false);
            
            // 🆕 Polymorphic Recipient: ቅሬታው የደረሰበትን አካል ለመለየት
            $table->morphs('recipient'); 

            $table->string('subject');
            $table->text('body');
            
           $table->string('status')->default('Pending')->change();
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