<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * MASTER MIGRATION - Ini adalah schema authoritative untuk aplikasi
     * Semua perubahan database harus dilakukan di sini, bukan di multiple migrations
     * Format Status: 'Baru', 'Diproses', 'Selesai', 'Ditolak' (Indonesian, consistent)
     */
    public function up(): void
    {
        // Migration ini tidak perlu, tables sudah dibuat oleh 2025_01_01 migrations
        // Ini adalah placeholder atau digunakan hanya jika setup baru dimulai
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('cache');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('solutions');
        Schema::dropIfExists('votes');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('users');
        Schema::enableForeignKeyConstraints();
    }
};
