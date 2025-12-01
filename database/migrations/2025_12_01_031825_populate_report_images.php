<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $imageDir = public_path('images/reports');
        $files = File::files($imageDir);
        
        // Sort files by creation time (timestamp in filename)
        usort($files, fn($a, $b) => (int)basename($a->getFilename(), '.' . $a->getExtension()) 
                                  <=> (int)basename($b->getFilename(), '.' . $b->getExtension()));
        
        // Get reports with null image, sorted by ID
        $reports = DB::table('reports')->whereNull('image')->orderBy('id')->get();
        
        // Assign files to reports
        foreach ($reports as $index => $report) {
            if (isset($files[$index])) {
                $filename = $files[$index]->getFilename();
                DB::table('reports')
                    ->where('id', $report->id)
                    ->update(['image' => 'images/reports/' . $filename]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            //
        });
    }
};
