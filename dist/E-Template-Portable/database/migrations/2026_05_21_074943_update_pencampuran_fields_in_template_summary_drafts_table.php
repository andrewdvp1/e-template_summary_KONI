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
        Schema::table('template_summary_drafts', function (Blueprint $table) {
            // Add new fields for section 2.3.1.3
            $table->text('pencampuran_sampling_titik')->nullable();
            $table->text('pencampuran_sampling_waktu')->nullable();
            $table->text('pencampuran_pemeriksaan_jenis')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_summary_drafts', function (Blueprint $table) {
            $table->dropColumn([
                'pencampuran_sampling_titik',
                'pencampuran_sampling_waktu',
                'pencampuran_pemeriksaan_jenis',
            ]);
        });
    }
};
