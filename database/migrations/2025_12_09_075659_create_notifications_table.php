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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('report_id')->nullable()->constrained('reports')->onDelete('cascade');
            $table->string('type'); // 'status_update', 'new_comment', 'report_approved', etc
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // Extra data (old_status, new_status, etc)
            $table->boolean('read')->default(false);
            $table->timestamps();
            
            $table->index(['user_id', 'read']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
