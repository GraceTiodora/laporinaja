<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, change enum to VARCHAR to allow any value
        DB::statement("ALTER TABLE reports MODIFY COLUMN status VARCHAR(50) NOT NULL");

        // Update existing data to Indonesian
        DB::table('reports')->where('status', 'pending')->update(['status' => 'Baru']);
        DB::table('reports')->where('status', 'in_progress')->update(['status' => 'Dalam Pengerjaan']);
        DB::table('reports')->where('status', 'resolved')->update(['status' => 'Selesai']);
        DB::table('reports')->where('status', 'rejected')->update(['status' => 'Ditolak']);

        // Change back to enum with Indonesian values
        DB::statement("ALTER TABLE reports MODIFY COLUMN status ENUM('Baru', 'Dalam Pengerjaan', 'Selesai', 'Ditolak') DEFAULT 'Baru' NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Change to VARCHAR first
        DB::statement("ALTER TABLE reports MODIFY COLUMN status VARCHAR(50) NOT NULL");

        // Revert to English values
        DB::table('reports')->where('status', 'Baru')->update(['status' => 'pending']);
        DB::table('reports')->where('status', 'Dalam Pengerjaan')->update(['status' => 'in_progress']);
        DB::table('reports')->where('status', 'Selesai')->update(['status' => 'resolved']);
        DB::table('reports')->where('status', 'Ditolak')->update(['status' => 'rejected']);

        // Change back to original enum
        DB::statement("ALTER TABLE reports MODIFY COLUMN status ENUM('pending', 'in_progress', 'resolved', 'rejected') DEFAULT 'pending' NOT NULL");
    }
};
