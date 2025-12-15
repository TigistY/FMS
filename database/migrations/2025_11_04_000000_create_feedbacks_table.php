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
            
            // ሪፖርተሩ የተመዘገበ ተጠቃሚ ከሆነ
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); 
            // ሪፖርተሩ እንግዳ ከሆነ (Guest)
            $table->foreignId('guest_id')->nullable()->constrained('guests')->onDelete('set null'); 

            // 🆕 Polymorphic Recipient: ቅሬታው የደረሰበትን አካል (College, Department, or Directory) ለመለየት
            $table->morphs('recipient'); 

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
