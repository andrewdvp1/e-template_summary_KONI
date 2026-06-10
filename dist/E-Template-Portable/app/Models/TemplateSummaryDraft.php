<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateSummaryDraft extends Model
{
    protected $fillable = [
        'draft_type',
        'draft_line',
        'title',
        'payload',
        'batch_name',
        'batch_satuan',
        'batch_jumlah_kapsul',
        'pencampuran_bobot_syarat',
        'pencampuran_sampling_lokasi',
        'pencampuran_sampling_jumlah',
        'pencampuran_212_table_json',
        'pencampuran_nama_produk',
        'pencampuran_besar_bets',
        'pencampuran_batch_list',
        'pencampuran_1331_text',
        'pencampuran_1332_text',
        'pencampuran_spesifikasi_nama',
        'pencampuran_spesifikasi_pemeriksaan',
        'pencampuran_no_dokumen',
        'pencampuran_tanggal_dokumen',
        'pencampuran_identifikasi',
        'pencampuran_identifikasi_jenis',
        'pencampuran_sampling_titik',
        'pencampuran_sampling_waktu',
        'pencampuran_pemeriksaan_jenis',
        'kemasan_sampling_titik',
        'kemasan_sampling_waktu',
        'kemasan_3331_table_json',
        'last_saved_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'last_saved_at' => 'datetime',
    ];
}