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
            // Section 2.3.1.2 - Identifikasi fields
            $table->text('pencampuran_spesifikasi_nama')->nullable();
            $table->text('pencampuran_no_dokumen')->nullable();
            $table->text('pencampuran_tanggal_dokumen')->nullable();
            $table->text('pencampuran_identifikasi')->nullable();
            
            // Section 2.3.1.3 - Identifikasi jenis
            $table->text('pencampuran_identifikasi_jenis')->nullable();
            
            // Section 2.3.3.3 - Sampling fields
            $table->text('kemasan_sampling_titik')->nullable();
            $table->text('kemasan_sampling_waktu')->nullable();
            
            // Section 2.3.3.3.1 - Table
            $table->text('kemasan_3331_table_json')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_summary_drafts', function (Blueprint $table) {
            $table->dropColumn([
                'pencampuran_spesifikasi_nama',
                'pencampuran_no_dokumen',
                'pencampuran_tanggal_dokumen',
                'pencampuran_identifikasi',
                'pencampuran_identifikasi_jenis',
                'kemasan_sampling_titik',
                'kemasan_sampling_waktu',
                'kemasan_3331_table_json',
            ]);
        });
    }
};
