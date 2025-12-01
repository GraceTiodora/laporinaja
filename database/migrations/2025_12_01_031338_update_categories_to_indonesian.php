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
        DB::table('categories')->where('id', 1)->update(['name' => 'Infrastruktur', 'slug' => 'infrastruktur', 'description' => 'Masalah infrastruktur']);
        DB::table('categories')->where('id', 2)->update(['name' => 'Keamanan', 'slug' => 'keamanan', 'description' => 'Masalah keamanan publik']);
        DB::table('categories')->where('id', 3)->update(['name' => 'Sanitasi', 'slug' => 'sanitasi', 'description' => 'Masalah sanitasi dan kebersihan']);
        DB::table('categories')->where('id', 4)->update(['name' => 'Taman', 'slug' => 'taman', 'description' => 'Masalah taman dan ruang hijau']);
        DB::table('categories')->where('id', 5)->update(['name' => 'Aksesibilitas', 'slug' => 'aksesibilitas', 'description' => 'Masalah aksesibilitas']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            //
        });
    }
};
