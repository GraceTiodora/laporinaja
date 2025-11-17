<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('comments', function (Blueprint $table) {
            $table->id('id_comment');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('id_report')->constrained('reports', 'id_report')->onDelete('cascade');
            $table->text('isi');
            $table->timestamp('tanggal_comment')->useCurrent();
            $table->unsignedBigInteger('target_comment')->nullable();
            $table->timestamps();

            $table->foreign('target_comment')->references('id_comment')->on('comments')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('comments');
    }
};
