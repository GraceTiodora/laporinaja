<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('solutions', function (Blueprint $table) {
            $table->id('id_solution');
            $table->foreignId('id_report')->constrained('reports', 'id_report')->onDelete('cascade');
            $table->foreignId('id_user')->nullable()->constrained('users', 'id_user')->onDelete('set null');
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('solutions');
    }
};
