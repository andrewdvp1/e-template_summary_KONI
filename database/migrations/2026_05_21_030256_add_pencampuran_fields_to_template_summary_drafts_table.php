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
            $table->text('pencampuran_bobot_syarat')->nullable();
            $table->text('pencampuran_sampling_lokasi')->nullable();
            $table->text('pencampuran_sampling_jumlah')->nullable();
            $table->text('pencampuran_212_table_json')->nullable();
            $table->text('pencampuran_nama_produk')->nullable();
            $table->text('pencampuran_besar_bets')->nullable();
            $table->text('pencampuran_batch_list')->nullable();
            $table->text('pencampuran_1331_text')->nullable();
            $table->text('pencampuran_1332_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_summary_drafts', function (Blueprint $table) {
            $table->dropColumn([
                'pencampuran_bobot_syarat',
                'pencampuran_sampling_lokasi',
                'pencampuran_sampling_jumlah',
                'pencampuran_212_table_json',
                'pencampuran_nama_produk',
                'pencampuran_besar_bets',
                'pencampuran_batch_list',
                'pencampuran_1331_text',
                'pencampuran_1332_text',
            ]);
        });
    }
};
