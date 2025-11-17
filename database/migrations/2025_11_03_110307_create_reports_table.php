<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reports', function (Blueprint $table) {
            $table->id('id_report');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('id_category')->nullable()->constrained('categories', 'id_category')->onDelete('set null');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->string('lokasi');
            $table->enum('status', ['baru', 'diproses', 'selesai', 'ditolak'])->default('baru');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('reports');
    }
};
