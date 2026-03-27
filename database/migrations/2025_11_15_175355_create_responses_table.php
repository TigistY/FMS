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
         Schema::create('responses', function (Blueprint $table) {
            $table->id();

            // Polymorphic Relationship: Replaces 'feedback_id'.
            // Adds 'respondable_type' (string) and 'respondable_id' (unsignedBigInteger).
            $table->morphs('respondable');
            $table->foreignId('responder_id')->constrained('users')->onDelete('restrict');
            $table->text('response_text');
            $table->boolean('is_public')->default(false);
            $table->string('status_at_response');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};