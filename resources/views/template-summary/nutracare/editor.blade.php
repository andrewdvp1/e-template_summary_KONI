@extends('layouts.app')

@section('content')
    <form action="{{ route('template-summary.nutracare.export') }}" method="POST" id="nutracareTemplateForm"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="draft_id" id="draft_id" value="{{ $draft->id ?? '' }}">

        <div class="max-w-5xl mx-auto flex flex-col gap-6 pb-24">

            {{-- Title Section --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="font-bold text-slate-900 dark:text-white">Judul Summary</h2>
                </div>
                <div class="p-6">
                    <div class="text-base leading-relaxed text-slate-700 dark:text-slate-300 template-text">
                        <p class="font-bold text-center text-base mb-2">
                            SUMMARY LAPORAN VALIDASI PROSES 
                            <br>
                            PEMBUATAN PRODUK
                            <input type="text" name="judul_nama_produk" class="template-input sync-input w-48 uppercase" data-sync="nama_produk" placeholder="Nutracare EPO 500 Soft Capsule">
                            <br>
                        </p>
                    </div>
                    <div class="mt-6 border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden">
                        <table class="w-full text-base"><tbody>
                            <tr class="border-b border-slate-300 dark:border-slate-600">
                                <td class="px-4 py-2 font-medium text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-900/50 w-40">Dokumen No.</td>
                                <td class="px-4 py-2 border-l border-slate-300 dark:border-slate-600"><input type="text" name="dokumen_no" class="template-input w-48" placeholder="-"></td>
                                <td class="px-4 py-2 font-medium text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-900/50 w-24 border-l border-slate-300 dark:border-slate-600">Tanggal</td>
                                <td class="px-4 py-2 border-l border-slate-300 dark:border-slate-600"><input type="text" name="dokumen_tanggal" class="template-input w-40" placeholder="-"></td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-medium text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-900/50">Pengganti No.</td>
                                <td class="px-4 py-2 border-l border-slate-300 dark:border-slate-600"><input type="text" name="pengganti_no" class="template-input w-48" placeholder="-"></td>
                                <td class="px-4 py-2 font-medium text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-900/50 border-l border-slate-300 dark:border-slate-600">Tanggal</td>
                                <td class="px-4 py-2 border-l border-slate-300 dark:border-slate-600"><input type="text" name="pengganti_tanggal" class="template-input w-40" placeholder="-"></td>
                            </tr>
                        </tbody></table>
                    </div>
                </div>
            </div>

            {{-- BAB 1: PENDAHULUAN --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="font-bold text-slate-900 dark:text-white">1. PENDAHULUAN</h2>
                </div>
                <div class="p-6 flex flex-col gap-6">
                    <div>
                        <h3 class="font-semibold text-slate-800 dark:text-slate-200 mb-3">1.1. Tujuan</h3>
                        <div class="ml-4 text-base leading-relaxed text-slate-700 dark:text-slate-300 template-text text-justify">
                            <p>Summary laporan validasi ini bertujuan mendokumentasikan hasil studi validasi/pembuktian terhadap kualitas proses pengolahan produk
                                <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-48" data-sync="nama_produk" placeholder="Nutracare EPO 500 Soft Capsule">
                                dengan besar bets <input type="text" name="tujuan_besar_bets" class="template-input w-20" placeholder="30,015 Kg">,
                                di bagian <input type="text" name="tujuan_bagian" class="template-input sync-input w-72" data-sync="bagian" value="Production Farmasi I Line Soft Capsule Gedung A" placeholder="Production Farmasi I Line Soft Capsule Gedung A">,
                                dalam menghasilkan produk yang memenuhi persyaratan mutu internal Konimex, pemerintah dan persyaratan kapabilitas proses yang sudah ditentukan secara konsisten.
                            </p>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-800 dark:text-slate-200 mb-3">1.2. Batch Validasi</h3>
                        <div class="text-base leading-relaxed text-slate-700 dark:text-slate-300 template-text text-justify mb-4">
                            <p>Studi validasi dilakukan terhadap
                                <input type="text" name="batch_jumlah" class="template-input w-12" placeholder="2">
                                bets produksi yaitu batch
                                <input type="text" name="batch_kode_list" class="template-input sync-input w-64" data-sync="batch" placeholder="JAN26A01 dan JAN26A02">,
                                dengan besaran batch <input type="text" name="batch_besaran" class="template-input w-24" placeholder="30,015 Kg">
                                = <input type="text" name="batch_jumlah_kapsul" class="template-input w-24" placeholder="60.000">
                                Soft Capsule @ <input type="text" name="batch_bobot_isi" class="template-input w-24" placeholder="500,25 mg"> (bobot isi).
                            </p>
                        </div>
                        <div class="border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden">
                            <div class="px-4 py-3 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-300 dark:border-slate-600 flex items-center justify-between">
                                <div class="flex items-center gap-2"><span class="material-symbols-outlined text-slate-500 text-[20px]">table_chart</span><span class="text-base font-medium text-slate-700 dark:text-slate-300">Tabel Identitas Bahan Baku Zat Aktif</span></div>
                                <button type="button" onclick="clearExcelTable('bahan_aktif')" class="text-xs text-slate-500 hover:text-red-600 flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">delete</span>Clear</button>
                            </div>
                            <div id="paste_instructions_bahan_aktif" class="p-4">
                                <div class="border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-8 text-center">
                                    <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-2">content_paste</span>
                                    <p class="text-base font-medium text-slate-600 dark:text-slate-400 mb-1">Paste dari Excel</p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Copy data dari Excel (4 kolom: Bahan aktif, Kode Bahan Baku, Nama Supplier, Negara) lalu paste di bawah</p>
                                    <textarea id="excel_paste_bahan_aktif" rows="4" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-base focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none font-mono" placeholder="Paste data Excel disini (Ctrl+V)..." onpaste="handleExcelPaste(event, 'bahan_aktif')"></textarea>
                                </div>
                            </div>
                            <div id="table_preview_bahan_aktif" class="hidden">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-base" id="preview_table_bahan_aktif">
                                        <thead><tr class="bg-slate-100 dark:bg-slate-700">
                                            <th class="px-4 py-2 text-left font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-300 dark:border-slate-600">Bahan aktif</th>
                                            <th class="px-4 py-2 text-left font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-300 dark:border-slate-600">Kode Bahan Baku</th>
                                            <th class="px-4 py-2 text-left font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-300 dark:border-slate-600">Nama Supplier</th>
                                            <th class="px-4 py-2 text-left font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-300 dark:border-slate-600">Negara</th>
                                        </tr></thead>
                                        <tbody id="table_body_bahan_aktif"></tbody>
                                    </table>
                                </div>
                            </div>
                            <input type="hidden" name="tabel_bahan_aktif" id="hidden_data_bahan_aktif">
                        </div>
                    </div>
                </div>
            </div>

            {{-- BAB 2: HASIL DAN EVALUASI VALIDASI PROSES --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="font-bold text-slate-900 dark:text-white">2. HASIL DAN EVALUASI VALIDASI PROSES</h2>
                </div>
                <div class="p-6 flex flex-col gap-6">
                    <input type="hidden" name="bab22_enabled_subab_keys" id="bab22_enabled_subab_keys" value="">

                    {{-- 2.1 Pelaksanaan Proses Produksi --}}
                    <div>
                        <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify mb-3">
                            <p class="pl-8 -indent-8"><span class="font-semibold">2.1.</span> Pelaksanaan Proses Produksi:</p>
                        </div>
                        <div class="ml-4">
                            @include('template-summary.nutracare._table', ['uid' => 'tbl_pelaksanaan'])
                        </div>
                    </div>

                    {{-- 2.2 --}}
                    <div>
                        <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                            <p class="pl-8 -indent-8"><span class="font-semibold">2.2.</span> Seluruh tahapan pengolahan dan pengemasan primer telah dilakukan sesuai dengan prosedur pengolahan dan pengemasan yang berlaku.</p>
                        </div>
                    </div>

                    {{-- 2.3 Hasil pemeriksaan sampel --}}
                    <div>
                        <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify mb-3">
                            <p class="pl-8 -indent-8"><span class="font-semibold">2.3.</span> Hasil pemeriksaan sampel pada masing-masing tahapan adalah sebagai berikut:</p>
                        </div>

                        {{-- 2.3.1 Enkapsulasi --}}
                        <div class="ml-4 mt-2">
                            <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify mb-3">
                                <p class="pl-10 -indent-10"><span class="font-semibold">2.3.1.</span> Enkapsulasi (Sebelum pengeringan)</p>
                            </div>
                            <div class="ml-6 flex flex-col gap-4">
                                <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                                    <p class="pl-12 -indent-12"><span class="font-medium">2.3.1.1.</span>&nbsp; Hasil enkapsulasi memiliki keseragaman bobot (isi) dengan syarat kualitas <input type="text" name="enkapsulasi_bobot_syarat" class="template-input w-48" placeholder="500,25 ± 37,52 mg">.</p>
                                </div>
                                <div>
                                    <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify mb-3">
                                        <p class="pl-12 -indent-12"><span class="font-medium">2.3.1.2.</span>&nbsp; Dilakukan sampling pada <input type="text" name="enkapsulasi_sampling_lokasi" class="template-input w-8" placeholder="3"> lokasi (awal, tengah, akhir) dengan jumlah <input type="text" name="enkapsulasi_sampling_jumlah" class="template-input w-8" placeholder="20"> butir soft capsule pada setiap pengambilan sampel, dengan hasil sebagai berikut:</p>
                                    </div>
                                    <div class="ml-10">
                                        @include('template-summary.nutracare._table', ['uid' => 'tbl_enkapsulasi_212'])
                                    </div>
                                </div>
                                <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                                    <p class="pl-12 -indent-12"><span class="font-medium">2.3.1.3.</span>&nbsp; Seluruh hasil pemeriksaan sampel tahap enkapsulasi (sebelum pengeringan) produk <input type="text" name="enkapsulasi_nama_produk" class="template-input sync-input w-48" data-sync="nama_produk" placeholder="Nutracare EPO 500 Soft Capsule"> dengan besar bets <input type="text" name="enkapsulasi_besar_bets" class="template-input w-24" placeholder="30,015 Kg">, bets <input type="text" name="enkapsulasi_batch_list" class="template-input sync-input w-48" data-sync="batch" placeholder="JAN26A01 dan JAN26A02"> memenuhi spesifikasi produk yang ditetapkan.</p>
                                </div>
                            </div>
                        </div>

                        {{-- 2.3.2 Tahap Pengeringan --}}
                        <div class="ml-4 mt-6">
                            <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify mb-3">
                                <p class="pl-10 -indent-10"><span class="font-semibold">2.3.2.</span> Tahap Pengeringan</p>
                            </div>
                            <div class="ml-6 flex flex-col gap-4">
                                <div>
                                    <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify mb-3">
                                        <p class="pl-12 -indent-12"><span class="font-medium">2.3.2.1.</span>&nbsp; Syarat kualitas produk setelah tahap pengeringan memiliki syarat mutu sesuai Spesifikasi Produk <input type="text" name="pengeringan_spesifikasi_no" class="template-input w-64" placeholder="Nutracare EPO 500 Soft Capsule no AI-F03-3-A0014-02"> tanggal <input type="text" name="pengeringan_spesifikasi_tanggal" class="template-input w-28" placeholder="22-11-2025">, sebagai berikut:</p>
                                    </div>
                                    <div class="ml-10">
                                        @include('template-summary.nutracare._table', ['uid' => 'tbl_spesifikasi_pengeringan'])
                                    </div>
                                    <div class="mt-3 ml-10 p-3 bg-slate-50 dark:bg-slate-900/30 rounded-lg text-sm text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                        <p class="font-semibold">Keterangan:</p><p>R = Release, S = Stabilitas.</p>
                                        <p class="font-semibold mt-2">Referensi:</p>
                                        <p>(1)&nbsp;&nbsp;&nbsp;: Standar internal Konimex</p>
                                        <p>(2)&nbsp;&nbsp;&nbsp;: Peraturan BPOM Nomor 29 Tahun 2023 tentang Persyaratan Keamanan dan Mutu Obat Bahan Alam.</p>
                                        <p>(3)&nbsp;&nbsp;&nbsp;: <input type="text" name="pengeringan_referensi_3" class="template-input w-full text-left" value="USP 43, halaman 4980, Evening Primrose Oil Capsules" placeholder="USP 43, halaman 4980, Evening Primrose Oil Capsules"></p>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify mb-3">
                                        <p class="pl-12 -indent-12"><span class="font-medium">2.3.2.2.</span>&nbsp; Hasil enkapsulasi setelah tahap pengeringan, berupa soft capsule yang telah dikeringkan pada tumbler dryer, secara urut ditampung dalam tray-tray dan dikeringkan di ruang pengering, sehingga menjadi soft capsule kering. Tray dibagi menjadi <input type="text" name="pengeringan_jumlah_tray" class="template-input w-8" placeholder="10"> kelompok dan dilakukan sampling sebanyak <input type="text" name="pengeringan_sampling_per_tray" class="template-input w-8" placeholder="30"> soft capsule per kelompok untuk semua pemeriksaan atribut di atas, dengan kondisi aktual pengeringan sebagai berikut:</p>
                                    </div>
                                    <div class="ml-10">
                                        @include('template-summary.nutracare._table', ['uid' => 'tbl_kondisi_pengeringan'])
                                    </div>
                                </div>
                                <div>
                                    <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify mb-3">
                                        <p class="pl-12 -indent-12"><span class="font-medium">2.3.2.3.</span>&nbsp; Hasil pemeriksaan sampel untuk pemeriksaan atribut sebagai berikut:</p>
                                    </div>
                                    <div class="ml-6 flex flex-col gap-4">
                                        <div>
                                            <p class="text-base text-slate-800 dark:text-slate-300 mb-2 ml-6"><span class="font-medium">2.3.2.3.1</span>&nbsp; Pemeriksaan keseragaman bobot</p>
                                            <div class="ml-10">@include('template-summary.nutracare._table', ['uid' => 'tbl_keseragaman_bobot'])</div>
                                        </div>
                                        <div>
                                            <p class="text-base text-slate-800 dark:text-slate-300 mb-2 ml-6"><span class="font-medium">2.3.2.3.2</span>&nbsp; Pemeriksaan Fisik</p>
                                            <div class="ml-10">@include('template-summary.nutracare._table', ['uid' => 'tbl_pemeriksaan_fisik'])</div>
                                        </div>
                                        <div>
                                            <p class="text-base text-slate-800 dark:text-slate-300 mb-2 ml-6"><span class="font-medium">2.3.2.3.3</span>&nbsp; Pemeriksaan Identifikasi Fatty Acid Profile, positif teridentifikasi asam lemak dengan komposisi:</p>
                                            <div class="ml-10">@include('template-summary.nutracare._table', ['uid' => 'tbl_fatty_acid'])</div>
                                        </div>
                                        <div>
                                            <p class="text-base text-slate-800 dark:text-slate-300 mb-2 ml-6"><span class="font-medium">2.3.2.3.4</span>&nbsp; Pemeriksaan Aflatoksin Total</p>
                                            <div class="ml-10">@include('template-summary.nutracare._table', ['uid' => 'tbl_aflatoksin'])</div>
                                        </div>
                                        <div>
                                            <p class="text-base text-slate-800 dark:text-slate-300 mb-2 ml-6"><span class="font-medium">2.3.2.3.5</span>&nbsp; Pemeriksaan Cemaran Logam Berat</p>
                                            <div class="ml-10">@include('template-summary.nutracare._table', ['uid' => 'tbl_logam_berat'])</div>
                                        </div>
                                        <div>
                                            <p class="text-base text-slate-800 dark:text-slate-300 mb-2 ml-6"><span class="font-medium">2.3.2.3.6</span>&nbsp; Pemeriksaan Mikrobiologi</p>
                                            <div class="ml-10">@include('template-summary.nutracare._table', ['uid' => 'tbl_mikrobiologi'])</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                                    <p class="pl-12 -indent-12"><span class="font-medium">2.3.2.4.</span>&nbsp; Seluruh hasil pemeriksaan sampel pengeringan produk <input type="text" name="pengeringan_nama_produk" class="template-input sync-input w-48" data-sync="nama_produk" placeholder="Nutracare EPO 500 Soft Capsule"> dengan besar bets <input type="text" name="pengeringan_besar_bets" class="template-input w-24" placeholder="30,015 Kg">, bets <input type="text" name="pengeringan_batch_list" class="template-input sync-input w-48" data-sync="batch" placeholder="JAN26A01 dan JAN26A02"> memenuhi spesifikasi produk yang ditetapkan.</p>
                                </div>
                            </div>
                        </div>

                        {{-- 2.3.3 Tahap Kemas Primer --}}
                        <div class="ml-4 mt-6">
                            <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify mb-3">
                                <p class="pl-10 -indent-10"><span class="font-semibold">2.3.3.</span> Tahap Kemas Primer</p>
                            </div>
                            <div class="ml-6 flex flex-col gap-4">
                                <div>
                                    <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify mb-3">
                                        <p class="pl-12 -indent-12"><span class="font-medium">2.3.3.1.</span>&nbsp; Spesifikasi kemasan <input type="text" name="kemasan_nama_produk" class="template-input sync-input w-48" data-sync="nama_produk" placeholder="Nutracare EPO 500 Soft Capsule"> untuk kemasan botol mengacu Spesifikasi Kemasan <input type="text" name="kemasan_spesifikasi_no" class="template-input w-64" placeholder="Nutracare EPO 500 Soft Capsule no. AI-F04-3-A0007-02"> tanggal <input type="text" name="kemasan_spesifikasi_tanggal" class="template-input w-28" placeholder="06-01-2026">, sebagai berikut:</p>
                                    </div>
                                    <div class="ml-10">
                                        @include('template-summary.nutracare._table', ['uid' => 'tbl_spesifikasi_kemasan'])
                                    </div>
                                    <div class="mt-3 ml-10 p-3 bg-slate-50 dark:bg-slate-900/30 rounded-lg text-sm text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                        <p class="font-semibold">Keterangan:</p><p>R = Release,</p>
                                        <p class="font-semibold mt-2">Referensi:</p>
                                        <p>(1)&nbsp;&nbsp;&nbsp;: Standar internal Konimex</p>
                                    </div>
                                </div>
                                <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                                    <p class="pl-12 -indent-12"><span class="font-medium">2.3.3.2.</span>&nbsp; Sampling dilakukan pada <input type="text" name="kemasan_sampling_lokasi" class="template-input w-8" placeholder="10"> lokasi untuk 1 bets. Sampel diambil sebanyak <input type="text" name="kemasan_sampling_jumlah" class="template-input w-8" placeholder="1"> botol tiap kali sampling. Kemudian dilakukan pengujian dengan pengecekan jumlah soft capsule dan desipack per botol dan pemeriksaan elegansi dan kondisi aluseal.</p>
                                </div>
                                <div>
                                    <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify mb-3">
                                        <p class="pl-12 -indent-12"><span class="font-medium">2.3.3.3.</span>&nbsp; Hasil pemeriksaan sampel sebagai berikut:</p>
                                    </div>
                                    <div class="ml-10">
                                        @include('template-summary.nutracare._table', ['uid' => 'tbl_hasil_kemasan'])
                                    </div>
                                </div>
                                <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                                    <p class="pl-12 -indent-12"><span class="font-medium">2.3.3.4.</span>&nbsp; Seluruh hasil pemeriksaan sampel tahap kemas primer <input type="text" name="kemasan_nama_produk_2" class="template-input sync-input w-48" data-sync="nama_produk" placeholder="Nutracare EPO 500 Soft Capsule"> dengan besar bets <input type="text" name="kemasan_besar_bets" class="template-input w-24" placeholder="30,015 Kg">, bets <input type="text" name="kemasan_batch_list" class="template-input sync-input w-48" data-sync="batch" placeholder="JAN26A01 dan JAN26A02"> telah memenuhi spesifikasi yang ditetapkan.</p>
                                </div>
                            </div>
                        </div>

                        <div id="bab23_dynamic_subab_container" class="ml-4 flex flex-col gap-6 mt-4"></div>
                        <div class="ml-4 mt-3">
                            <button type="button" onclick="addBab23Subab()"
                                class="w-full py-3 border-2 border-dashed border-red-200 dark:border-red-800 rounded-lg text-red-600 dark:text-red-400 hover:border-red-400 hover:bg-red-50/40 dark:hover:bg-red-900/20 transition-colors flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">add</span>
                                <span class="text-sm font-medium">Tambah Subab (2.3.x)</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BAB 3: KESIMPULAN --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <h2 class="font-bold text-slate-900 dark:text-white">3. KESIMPULAN</h2>
                    <span class="text-xs text-slate-400 dark:text-slate-500">Klik nomor untuk enable/disable</span>
                </div>
                <div class="p-6 flex flex-col gap-6" id="bab3_container">
                    <input type="hidden" name="kesimpulan_enabled_sections" id="kesimpulan_enabled_sections" value="1,2">
                    <div class="kesimpulan-section" data-section-id="1">
                        <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify transition-opacity duration-200">
                            <p class="pl-8 -indent-8">
                                <span class="kesimpulan-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleKesimpulanSection(this)" title="Klik untuk disable/enable">3.1</span>
                                Telah dilakukan proses produksi terhadap produk
                                <input type="text" name="kesimpulan_nama_produk" class="template-input sync-input w-48" data-sync="nama_produk" placeholder="Nutracare EPO 500 Soft Capsule">,
                                bets <input type="text" name="kesimpulan_batch_codes" class="template-input sync-input w-48" data-sync="batch" placeholder="JAN26A01 dan JAN26A02">
                                yang digunakan sebagai batch validasi proses.
                            </p>
                        </div>
                    </div>
                    <div class="kesimpulan-section" data-section-id="2">
                        <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify transition-opacity duration-200">
                            <p class="pl-8 -indent-8">
                                <span class="kesimpulan-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleKesimpulanSection(this)" title="Klik untuk disable/enable">3.2</span>
                                Proses terbukti pada
                                <input type="text" name="kesimpulan_jumlah_bets" class="template-input w-12" placeholder="2">
                                bets pemeriksaan, dapat menghasilkan produk jadi
                                <input type="text" name="kesimpulan_nama_produk_2" class="template-input sync-input w-48" data-sync="nama_produk" placeholder="Nutracare EPO 500 Soft Capsule">
                                yang memenuhi spesifikasi dalam Spesifikasi Produk dan Spesifikasi Kemasan
                                <input type="text" name="kesimpulan_nama_produk_3" class="template-input sync-input w-48" data-sync="nama_produk" placeholder="Nutracare EPO 500 Soft Capsule">
                                sehingga dinyatakan <input type="text" name="kesimpulan_status" class="template-input w-32 italic" placeholder="validated">.
                            </p>
                        </div>
                    </div>
                    <div id="custom_kesimpulan_container"></div>
                    <div class="flex justify-center">
                        <button type="button" onclick="addCustomKesimpulan()"
                            class="flex items-center justify-center gap-2 px-4 py-3 rounded-lg border-2 border-dashed border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 hover:border-red-400 hover:bg-red-50/40 dark:hover:bg-red-900/20 transition-colors">
                            <span class="material-symbols-outlined text-[20px]">add</span>
                            <span class="text-sm font-medium">Tambah Poin Kesimpulan</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- BAB 4: SARAN --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="font-bold text-slate-900 dark:text-white">4. SARAN</h2>
                </div>
                <div class="p-6">
                    <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                        <p class="pl-8 -indent-8">
                            <span class="font-semibold">4.1.</span>&nbsp;
                            Apabila dikemudian hari dilakukan perubahan pada proses produksi produk
                            <input type="text" name="saran_nama_produk" class="template-input sync-input w-56" data-sync="nama_produk" placeholder="Nutracare EPO 500 Soft Capsule">,
                            maka perubahan tersebut harus diberitahukan ke pihak-pihak terkait dengan mekanisme sesuai pedoman pengendalian perubahan yang berlaku.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Fixed Footer Actions --}}
        <div class="fixed flex justify-end bottom-0 right-0 bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] z-40 transition-[left] duration-300 ease-in-out"
            style="left: 14.5rem;" id="actionFooter">
            <div class="flex px-8 py-4 items-center justify-end max-w-5xl">
                <div class="flex items-center gap-3">
                    <button type="button" id="saveDraftBtn" onclick="saveDraft()"
                        class="px-5 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold transition-all text-sm flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        <span id="saveDraftText">Simpan Draft</span>
                    </button>
                    <button type="submit"
                        class="px-6 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold text-sm shadow-sm flex items-center gap-2 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">description</span>
                        Export ke Word
                    </button>
                </div>
            </div>
        </div>
    </form>

    {{-- Custom Styles for Template Inputs --}}
    <style>
        .template-input { display: inline-block; border: none; border-bottom: 2px solid #cbd5e1; background: transparent; padding: 2px 4px; margin: 0 2px; font-size: inherit; font-family: inherit; color: #1e293b; text-align: center; transition: border-color 0.2s, background-color 0.2s; font-weight: 700; }
        .template-input:focus { outline: none; border-bottom-color: #dc2626; background-color: #fef2f2; }
        .template-input::placeholder { color: #94a3b8; font-style: italic; }
        .dark .template-input { color: #e2e8f0; border-bottom-color: #475569; }
        .dark .template-input:focus { background-color: rgba(220, 38, 38, 0.1); }
        .dark .template-input::placeholder { color: #64748b; }
        .template-input[type="date"] { padding: 1px 4px; }
    </style>

    {{-- Excel Paste Handler Script --}}
    <script>
        const tableData = {};
        function handleExcelPaste(event, tableId) { event.preventDefault(); const pastedData = (event.clipboardData || window.clipboardData).getData('text'); if (!pastedData.trim()) return; const rows = pastedData.trim().split('\n').map(row => row.split('\t')); if (rows.length === 0) return; tableData[tableId] = rows; document.getElementById('hidden_data_' + tableId).value = JSON.stringify(rows); const tbody = document.getElementById('table_body_' + tableId); tbody.innerHTML = ''; rows.forEach((row, index) => { const tr = document.createElement('tr'); tr.className = index % 2 === 0 ? 'bg-white dark:bg-slate-800' : 'bg-slate-50 dark:bg-slate-900/50'; while (row.length < 4) row.push(''); row.slice(0, 4).forEach(cell => { const td = document.createElement('td'); td.className = 'px-4 py-2 text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700'; td.textContent = cell.trim(); tr.appendChild(td); }); tbody.appendChild(tr); }); document.getElementById('paste_instructions_' + tableId).classList.add('hidden'); document.getElementById('table_preview_' + tableId).classList.remove('hidden'); document.getElementById('excel_paste_' + tableId).value = ''; }
        function clearExcelTable(tableId) { tableData[tableId] = []; document.getElementById('hidden_data_' + tableId).value = ''; document.getElementById('table_body_' + tableId).innerHTML = ''; document.getElementById('paste_instructions_' + tableId).classList.remove('hidden'); document.getElementById('table_preview_' + tableId).classList.add('hidden'); }
        function focusClipboardField(container) { const textarea = container.querySelector('.clipboard-input-area'); if (textarea) textarea.focus(); }
        async function triggerClipboardPaste(button) { if (!navigator.clipboard || !navigator.clipboard.read) { alert('Browser Anda tidak mendukung akses clipboard otomatis. Silakan gunakan Ctrl+V langsung di area textarea.'); return; } try { const clipboardItems = await navigator.clipboard.read(); const tableItem = button.closest('.mixing-table-item'); if (!tableItem) return; for (const clipboardItem of clipboardItems) { for (const type of clipboardItem.types) { if (type.startsWith('image/')) { const blob = await clipboardItem.getType(type); const imageInput = tableItem.querySelector('input[type="file"][accept*="image"]'); if (imageInput) { const transfer = new DataTransfer(); transfer.items.add(new File([blob], 'pasted-image.png', { type: blob.type })); imageInput.files = transfer.files; previewImage(imageInput); } return; } } for (const type of clipboardItem.types) { if (type === 'text/plain') { const blob = await clipboardItem.getType(type); const text = await blob.text(); if (text && text.includes('\t')) { const rows = text.replace(/\r/g, '').split('\n').map(row => row.split('\t').map(cell => cell.trim())).filter(row => row.some(cell => cell !== '')); if (rows.length) { const tableUid = getTableUidFromItem(tableItem); const hiddenInput = tableUid ? tableItem.querySelector(`input[name="mixing_pasted_table_json[${escapeNameForSelector(tableUid)}]"]`) : null; if (hiddenInput) hiddenInput.value = JSON.stringify(rows); renderPastedTablePreview(tableItem, rows); } } return; } } } } catch (err) { alert('Tidak bisa membaca clipboard otomatis. Silakan klik area teks di bawah tombol ini lalu tekan Ctrl+V.'); } }
        function handleClipboardFieldPaste(event, textarea) { const clipboardData = event.clipboardData || event.originalEvent.clipboardData || window.clipboardData; if (!clipboardData) return; const items = clipboardData.items || []; let foundImage = false; for (let index in items) { const item = items[index]; if (item.kind === 'file' && item.type.indexOf('image') !== -1) { const blob = item.getAsFile(); if (!blob) continue; event.preventDefault(); foundImage = true; const tableItem = textarea.closest('.mixing-table-item'); if (!tableItem) break; const imageInput = tableItem.querySelector('input[type="file"][accept*="image"]'); if (imageInput) { try { const transfer = new DataTransfer(); transfer.items.add(blob); imageInput.files = transfer.files; previewImage(imageInput); } catch (e) { const reader = new FileReader(); reader.onload = function(ev) { const previewBox = tableItem.querySelector('.image-preview-box'); const img = previewBox ? previewBox.querySelector('img') : null; const pasteInstructions = tableItem.querySelector('.paste-instructions'); if (img && previewBox) { img.src = ev.target.result; previewBox.classList.remove('hidden'); } if (pasteInstructions) pasteInstructions.classList.add('hidden'); }; reader.readAsDataURL(blob); } } break; } } if (!foundImage) { const text = clipboardData.getData('text/plain') || clipboardData.getData('text'); if (text && text.includes('\t')) { const tableItem = textarea.closest('.mixing-table-item'); if (tableItem) { event.preventDefault(); const rows = text.replace(/\r/g, '').split('\n').map(row => row.split('\t').map(cell => cell.trim())).filter(row => row.some(cell => cell !== '')); if (rows.length) { const tableUid = getTableUidFromItem(tableItem); const hiddenInput = tableUid ? tableItem.querySelector(`input[name="mixing_pasted_table_json[${escapeNameForSelector(tableUid)}]"]`) : null; if (hiddenInput) hiddenInput.value = JSON.stringify(rows); renderPastedTablePreview(tableItem, rows); } } } } }
        function escapeNameForSelector(name) { return name.replace(/\\/g, '\\\\').replace(/"/g, '\\"'); }
        function getTableUidFromItem(tableItem) { if (!tableItem) return null; if (tableItem.dataset.tableUid) return tableItem.dataset.tableUid; const hiddenMapInput = tableItem.querySelector('input[name^="bab22_table_subab_key["]'); if (!hiddenMapInput) return null; const match = hiddenMapInput.name.match(/^bab22_table_subab_key\[(.+)\]$/); if (!match) return null; tableItem.dataset.tableUid = match[1]; return match[1]; }
        function getInputValue(input) { if (input.type === 'checkbox' || input.type === 'radio') return input.checked ? '1' : '0'; return input.value ?? ''; }
        function collectFormValues() { const values = {}; document.querySelectorAll('#nutracareTemplateForm input[name]:not([type="file"]), #nutracareTemplateForm textarea[name], #nutracareTemplateForm select[name]').forEach(input => { if (input.name === 'draft_id' || input.name === '_token') return; values[input.name] = getInputValue(input); }); return values; }
        function restoreFormValues(values) { if (!values || typeof values !== 'object') return; Object.entries(values).forEach(([name, value]) => { if (name === 'draft_id' || name === '_token') return; const selector = `[name="${escapeNameForSelector(name)}"]`; document.querySelectorAll(selector).forEach(field => { if (field.type === 'checkbox' || field.type === 'radio') { field.checked = String(value) === '1'; return; } field.value = value ?? ''; }); }); }
        function applyStoredImageToTable(tableItem, imageMeta) { if (!tableItem || !imageMeta || !imageMeta.url || !imageMeta.path) return; const tableUid = getTableUidFromItem(tableItem); if (!tableUid) return; const previewBox = tableItem.querySelector('.image-preview-box'); const pasteInstructions = tableItem.querySelector('.paste-instructions'); const img = previewBox ? previewBox.querySelector('img') : null; if (img && previewBox) { img.src = imageMeta.url; previewBox.classList.remove('hidden'); if (pasteInstructions) pasteInstructions.classList.add('hidden'); } let hiddenExisting = tableItem.querySelector(`input[name="existing_mixing_image_file[${tableUid}]"]`); if (!hiddenExisting) { hiddenExisting = document.createElement('input'); hiddenExisting.type = 'hidden'; hiddenExisting.name = `existing_mixing_image_file[${tableUid}]`; tableItem.appendChild(hiddenExisting); } hiddenExisting.value = imageMeta.path; }
        function collectDraftState() { const disabledFieldNames = []; document.querySelectorAll('#nutracareTemplateForm input[name], #nutracareTemplateForm textarea[name], #nutracareTemplateForm select[name]').forEach(field => { if (field.disabled) disabledFieldNames.push(field.name); }); const kesimpulanDisabledSectionIds = []; document.querySelectorAll('#bab3_container .kesimpulan-section.section-disabled').forEach(section => { if (section.dataset.sectionId) kesimpulanDisabledSectionIds.push(section.dataset.sectionId); }); const customKesimpulanContainer = document.getElementById('custom_kesimpulan_container'); const storedFiles = { mixing_image_file: {} }; document.querySelectorAll('.mixing-table-item').forEach(tableItem => { const tableUid = getTableUidFromItem(tableItem); if (!tableUid) return; const existingImageInput = tableItem.querySelector(`input[name="existing_mixing_image_file[${tableUid}]"]`); if (existingImageInput && existingImageInput.value) { const previewImageEl = tableItem.querySelector('.image-preview-box img'); storedFiles.mixing_image_file[tableUid] = { path: existingImageInput.value, url: previewImageEl ? previewImageEl.src : '', name: '' }; } const base64Input = tableItem.querySelector(`input[name="mixing_image_base64[${escapeNameForSelector(tableUid)}]"]`); if (base64Input && base64Input.value) { storedFiles.mixing_image_base64 = storedFiles.mixing_image_base64 || {}; storedFiles.mixing_image_base64[tableUid] = base64Input.value; } }); return { counters: { customKesimpulanCount, bab22CustomSubabCounter: 0, bab22SubabIdCounter: 1, bab22TableUidCounter: 1 }, form_values: collectFormValues(), disabled_field_names: disabledFieldNames, kesimpulan_disabled_sections: kesimpulanDisabledSectionIds, bab22_container_html: '', custom_kesimpulan_html: customKesimpulanContainer ? customKesimpulanContainer.innerHTML : '', table_data: tableData, stored_files: storedFiles }; }
        function restoreDraftState(state) { if (!state || typeof state !== 'object') return; const customKesimpulanContainer = document.getElementById('custom_kesimpulan_container'); if (customKesimpulanContainer && typeof state.custom_kesimpulan_html === 'string') customKesimpulanContainer.innerHTML = state.custom_kesimpulan_html; Object.keys(tableData).forEach(key => delete tableData[key]); if (state.table_data && typeof state.table_data === 'object') Object.entries(state.table_data).forEach(([key, value]) => { tableData[key] = value; }); Object.entries(tableData).forEach(([tableId, rows]) => { const hiddenInput = document.getElementById('hidden_data_' + tableId); if (hiddenInput) hiddenInput.value = Array.isArray(rows) ? JSON.stringify(rows) : ''; if (tableId === 'bahan_aktif' && Array.isArray(rows) && rows.length > 0) { const tbody = document.getElementById('table_body_bahan_aktif'); if (tbody) { tbody.innerHTML = ''; rows.forEach((row, index) => { const tr = document.createElement('tr'); tr.className = index % 2 === 0 ? 'bg-white dark:bg-slate-800' : 'bg-slate-50 dark:bg-slate-900/50'; while (row.length < 4) row.push(''); row.slice(0, 4).forEach(cellValue => { const td = document.createElement('td'); td.className = 'px-4 py-2 text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700'; td.textContent = (cellValue || '').trim(); tr.appendChild(td); }); tbody.appendChild(tr); }); } const pasteBox = document.getElementById('paste_instructions_bahan_aktif'); const previewBox = document.getElementById('table_preview_bahan_aktif'); if (pasteBox && previewBox) { pasteBox.classList.add('hidden'); previewBox.classList.remove('hidden'); } } }); restoreFormValues(state.form_values || {}); (state.disabled_field_names || []).forEach(name => { const selector = `[name="${escapeNameForSelector(name)}"]`; document.querySelectorAll(selector).forEach(field => { field.setAttribute('disabled', 'disabled'); field.classList.add('opacity-50'); }); }); const disabledSectionIds = new Set(state.kesimpulan_disabled_sections || []); document.querySelectorAll('#bab3_container .kesimpulan-section').forEach(section => { const sectionId = section.dataset.sectionId || ''; if (disabledSectionIds.has(sectionId) && !section.classList.contains('section-disabled')) { const numberEl = section.querySelector('.kesimpulan-number'); if (numberEl) toggleKesimpulanSection(numberEl); } }); const storedFiles = state.stored_files || {}; const storedImages = storedFiles.mixing_image_file || {}; Object.entries(storedImages).forEach(([tableUid, imageMeta]) => { const mapInput = document.querySelector(`input[name="bab22_table_subab_key[${escapeNameForSelector(tableUid)}]"]`); if (mapInput) applyStoredImageToTable(mapInput.closest('.mixing-table-item'), imageMeta); }); const storedBase64Images = storedFiles.mixing_image_base64 || {}; Object.entries(storedBase64Images).forEach(([tableUid, base64]) => { if (!base64) return; const mapInput = document.querySelector(`input[name="bab22_table_subab_key[${escapeNameForSelector(tableUid)}]"]`); if (!mapInput) return; const tableItem = mapInput.closest('.mixing-table-item'); if (!tableItem) return; const previewBox = tableItem.querySelector('.image-preview-box'); const img = previewBox ? previewBox.querySelector('img') : null; const base64Input = tableItem.querySelector(`input[name="mixing_image_base64[${escapeNameForSelector(tableUid)}]"]`); if (img && previewBox) { img.src = base64; previewBox.classList.remove('hidden'); } if (base64Input) base64Input.value = base64; }); const counters = state.counters || {}; customKesimpulanCount = Number(counters.customKesimpulanCount || 0); renumberKesimpulanSections(); }

        function setSaveDraftLoading(isLoading) { const btn = document.getElementById('saveDraftBtn'); const textEl = document.getElementById('saveDraftText'); if (!btn || !textEl) return; if (isLoading) { btn.setAttribute('disabled', 'disabled'); btn.classList.add('opacity-70', 'cursor-wait'); textEl.textContent = 'Menyimpan...'; } else { btn.removeAttribute('disabled'); btn.classList.remove('opacity-70', 'cursor-wait'); textEl.textContent = 'Simpan Draft'; } }
        async function saveDraft() { setSaveDraftLoading(true); try { const form = document.getElementById('nutracareTemplateForm'); const formData = new FormData(form); formData.delete('_token'); formData.append('_token', CSRF_TOKEN); const state = collectDraftState(); const product = (state.form_values.judul_nama_produk || '').trim() || 'Nutracare EPO 500 Soft Capsule'; const formula = (state.form_values.judul_formula || '').trim(); const line = (state.form_values.judul_line || '').trim() || '6'; const bagian = (state.form_values.judul_bagian || state.form_values.tujuan_bagian || '').trim() || 'Production Pharma III Gedung B'; const formulaSegment = formula ? ` (${formula})` : ''; const titleFallback = `SUMMARY LAPORAN VALIDASI PROSES PEMBUATAN PRODUK ${product}${formulaSegment} DI LINE ${line} BAGIAN ${bagian.toUpperCase()}`; formData.append('draft_id', document.getElementById('draft_id').value || ''); formData.append('draft_title', titleFallback); formData.append('draft_state', JSON.stringify(state)); const response = await fetch(SAVE_DRAFT_URL, { method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF_TOKEN }, body: formData }); const result = await response.json(); if (!response.ok || !result.success) throw new Error(result.message || 'Gagal menyimpan draft'); if (result.draft_id) document.getElementById('draft_id').value = result.draft_id; const storedFiles = result.stored_files || {}; const imageMap = storedFiles.mixing_image_file || {}; Object.entries(imageMap).forEach(([tableUid, imageMeta]) => { const mapInput = document.querySelector(`input[name="bab22_table_subab_key[${escapeNameForSelector(tableUid)}]"]`); if (mapInput) applyStoredImageToTable(mapInput.closest('.mixing-table-item'), imageMeta); }); if (result.redirect_url) { const currentUrl = new URL(window.location.href); const targetUrl = new URL(result.redirect_url, window.location.origin); if (currentUrl.search !== targetUrl.search) window.history.replaceState({}, '', targetUrl.toString()); } Swal.fire({ title: '<span class="text-slate-800 dark:text-white sm:text-2xl">Berhasil!</span>', html: `<p class="text-slate-600 dark:text-slate-300">${result.message || 'Draft berhasil disimpan.'}</p>`, icon: 'success', iconColor: '#10b981', background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#ffffff', position: 'center', showConfirmButton: false, timer: 2000, timerProgressBar: true, customClass: { popup: 'rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700' }, showClass: { popup: 'animate__animated animate__fadeInUp animate__faster' }, hideClass: { popup: 'animate__animated animate__fadeOutDown animate__faster' } }); } catch (error) { Swal.fire({ title: '<span class="text-slate-800 dark:text-white sm:text-xl">Gagal!</span>', html: `<p class="text-slate-600 dark:text-slate-300">${error.message || 'Gagal menyimpan draft.'}</p>`, icon: 'error', iconColor: '#ef4444', background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#ffffff', position: 'center', showConfirmButton: true, confirmButtonColor: '#ef4444', confirmButtonText: 'OK', customClass: { popup: 'rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700' } }); } finally { setSaveDraftLoading(false); } }
        let bab22TableUidCounter = 1;
        function getMixingTableTemplate(subabKey) { bab22TableUidCounter++; const tableUid = `table_${bab22TableUidCounter}`; return `<div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative" data-table-uid="${tableUid}" onpaste="handleMixingPaste(event, this)"><div class="absolute top-1 right-1 z-20 remove-table-btn"><button type="button" onclick="toggleTableMenu(this)" class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors" title="Opsi"><span class="material-symbols-outlined text-[20px] block">more_vert</span></button><div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30"><button type="button" onclick="removeMixingTable(this)" class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span>Hapus Tabel</button></div></div><div class="p-6"><div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-8 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)"><span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-2">content_paste</span><p class="text-base font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p><p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Copy data dari Excel atau Screenshot lalu paste di bawah (Ctrl+V)</p><div class="flex justify-center mb-4"><button type="button" onclick="triggerClipboardPaste(this)" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">content_paste_go</span>Tempel dari Clipboard</button></div><textarea rows="4" class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" placeholder="Paste screenshot / tabel Excel di sini, atau ketik catatan... (Ctrl+V)" onpaste="handleClipboardFieldPaste(event, this)"></textarea></div><input type="file" name="mixing_image_file[${tableUid}]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)"><div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1"><img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm"><button type="button" onclick="removeImage(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Gambar"><span class="material-symbols-outlined text-[14px] block">close</span></button></div><div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3"><div class="overflow-auto max-h-[420px]"><table class="w-full text-sm border-collapse pasted-table-preview-table"></table></div><button type="button" onclick="removePastedTable(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Tabel Paste"><span class="material-symbols-outlined text-[14px] block">close</span></button></div></div><input type="hidden" name="bab22_table_subab_key[${tableUid}]" value="${subabKey}"><input type="hidden" name="existing_mixing_image_file[${tableUid}]" value=""><input type="hidden" name="mixing_pasted_table_json[${tableUid}]" value=""><input type="hidden" name="mixing_image_base64[${tableUid}]" value=""></div>`; }
        function renderPastedTablePreview(tableItem, rows) { const previewBox = tableItem.querySelector('.pasted-table-preview-box'); const previewTable = tableItem.querySelector('.pasted-table-preview-table'); const pasteInstructions = tableItem.querySelector('.paste-instructions'); if (!previewBox || !previewTable || !Array.isArray(rows) || rows.length === 0) return; previewTable.innerHTML = ''; rows.forEach((row, rowIndex) => { const tr = document.createElement('tr'); (row || []).forEach(cellValue => { const cell = document.createElement(rowIndex === 0 ? 'th' : 'td'); cell.className = rowIndex === 0 ? 'px-3 py-2 text-left font-semibold text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-700' : 'px-3 py-2 text-slate-700 dark:text-slate-300 border border-slate-300 dark:border-slate-700'; cell.textContent = cellValue || ''; tr.appendChild(cell); }); previewTable.appendChild(tr); }); previewBox.classList.remove('hidden'); if (pasteInstructions) pasteInstructions.classList.add('hidden'); }
        function removePastedTable(button) { const tableItem = button.closest('.mixing-table-item'); if (!tableItem) return; const previewBox = tableItem.querySelector('.pasted-table-preview-box'); const previewTable = tableItem.querySelector('.pasted-table-preview-table'); const pasteInstructions = tableItem.querySelector('.paste-instructions'); const tableUid = getTableUidFromItem(tableItem); const hiddenInput = tableUid ? tableItem.querySelector(`input[name="mixing_pasted_table_json[${escapeNameForSelector(tableUid)}]"]`) : null; if (previewTable) previewTable.innerHTML = ''; if (hiddenInput) hiddenInput.value = ''; if (previewBox) previewBox.classList.add('hidden'); if (pasteInstructions) pasteInstructions.classList.remove('hidden'); }
        function handleMixingPaste(event, tableItem) { if (!tableItem) return; const clipboardData = event.clipboardData || window.clipboardData; if (!clipboardData) return; const activeTag = document.activeElement?.tagName?.toLowerCase(); if (activeTag === 'input' || activeTag === 'textarea') return; const items = clipboardData.items || []; for (const item of items) { if (item.type && item.type.startsWith('image/')) { const imageFile = item.getAsFile(); if (!imageFile) continue; event.preventDefault(); const imageInput = tableItem.querySelector('input[type="file"][accept*="image"]'); const transfer = new DataTransfer(); transfer.items.add(imageFile); imageInput.files = transfer.files; previewImage(imageInput); return; } } const pastedText = clipboardData.getData('text/plain'); if (!pastedText || !pastedText.includes('\t')) return; event.preventDefault(); const rows = pastedText.replace(/\r/g, '').split('\n').map(row => row.split('\t').map(cell => cell.trim())).filter(row => row.some(cell => cell !== '')); if (!rows.length) return; const tableUid = getTableUidFromItem(tableItem); const hiddenInput = tableUid ? tableItem.querySelector(`input[name="mixing_pasted_table_json[${escapeNameForSelector(tableUid)}]"]`) : null; if (hiddenInput) hiddenInput.value = JSON.stringify(rows); renderPastedTablePreview(tableItem, rows); }
        function previewImage(input) { const tableItem = input.closest('.mixing-table-item'); const pasteInstructions = tableItem.querySelector('.paste-instructions'); const previewBox = tableItem.querySelector('.image-preview-box'); const img = previewBox.querySelector('img'); if (input.files && input.files[0]) { const reader = new FileReader(); reader.onload = function(e) { const base64 = e.target.result; img.src = base64; if (pasteInstructions) pasteInstructions.classList.add('hidden'); previewBox.classList.remove('hidden'); const tableUid = getTableUidFromItem(tableItem); if (tableUid) { const base64Input = tableItem.querySelector(`input[name="mixing_image_base64[${escapeNameForSelector(tableUid)}]"]`); if (base64Input) base64Input.value = base64; } }; reader.readAsDataURL(input.files[0]); } }
        function removeImage(btn) { const previewBox = btn.closest('.image-preview-box'); const tableItem = previewBox.closest('.mixing-table-item'); const pasteInstructions = tableItem.querySelector('.paste-instructions'); const imageInput = tableItem.querySelector('input[type="file"][accept*="image"]'); const imageEl = previewBox.querySelector('img'); const tableUid = getTableUidFromItem(tableItem); const existingImageInput = tableUid ? tableItem.querySelector(`input[name="existing_mixing_image_file[${tableUid}]"]`) : null; const base64Input = tableUid ? tableItem.querySelector(`input[name="mixing_image_base64[${escapeNameForSelector(tableUid)}]"]`) : null; if (imageInput) imageInput.value = ''; if (existingImageInput) existingImageInput.value = ''; if (base64Input) base64Input.value = ''; if (imageEl) imageEl.src = ''; previewBox.classList.add('hidden'); if (pasteInstructions) pasteInstructions.classList.remove('hidden'); }
        function removeMixingTable(button) { const tableItem = button.closest('.mixing-table-item'); if (tableItem) tableItem.remove(); }
        function toggleTableMenu(button) { const menu = button.nextElementSibling; const isHidden = menu.classList.contains('hidden'); document.querySelectorAll('.table-dropdown-menu').forEach(m => m.classList.add('hidden')); if (isHidden) menu.classList.remove('hidden'); }
        function updateRemoveButtonVisibility() { document.querySelectorAll('.mixing-table-item').forEach(table => { const removeBtn = table.querySelector('.remove-table-btn'); if (removeBtn) removeBtn.classList.remove('hidden'); }); }
        function updateFileName(input) { }
        let customKesimpulanCount = 0;
        function toggleKesimpulanSection(numberEl) { const section = numberEl.closest('.kesimpulan-section'); const isDisabled = section.classList.toggle('section-disabled'); if (isDisabled) { section.style.opacity = '0.35'; numberEl.classList.add('line-through', 'text-red-500'); section.querySelectorAll('input, textarea, button, select').forEach(el => { el.setAttribute('disabled', 'disabled'); el.classList.add('opacity-50'); }); } else { section.style.opacity = '1'; numberEl.classList.remove('line-through', 'text-red-500'); section.querySelectorAll('input, textarea, button, select').forEach(el => { el.removeAttribute('disabled'); el.classList.remove('opacity-50'); }); } renumberKesimpulanSections(); }
        function renumberKesimpulanSections() { const sections = document.querySelectorAll('#bab3_container .kesimpulan-section'); let activeIndex = 1; const enabledIds = []; sections.forEach((section, index) => { const numberEl = section.querySelector('.kesimpulan-number'); if (!numberEl) return; const isDisabled = section.classList.contains('section-disabled'); if (!isDisabled) { numberEl.textContent = `3.${activeIndex}`; activeIndex++; enabledIds.push(section.dataset.sectionId || String(index + 1)); } else { numberEl.textContent = `3.${section.dataset.sectionId || String(index + 1)}`; } }); const enabledInput = document.getElementById('kesimpulan_enabled_sections'); if (enabledInput) enabledInput.value = enabledIds.join(','); }
        function addCustomKesimpulan() { customKesimpulanCount++; const customId = 'c' + customKesimpulanCount; const container = document.getElementById('custom_kesimpulan_container'); const div = document.createElement('div'); div.className = 'kesimpulan-section'; div.dataset.sectionId = customId; div.innerHTML = `<div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify transition-opacity duration-200 flex items-start gap-2"><span class="kesimpulan-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors whitespace-nowrap mt-0.5" onclick="toggleKesimpulanSection(this)" title="Klik untuk disable/enable">3.X</span><textarea name="kesimpulan_custom_${customKesimpulanCount}" rows="2" class="flex-1 resize-y px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all text-sm" placeholder="Isi poin kesimpulan..."></textarea><button type="button" onclick="this.closest('.kesimpulan-section').remove(); renumberKesimpulanSections();" class="text-slate-400 hover:text-red-600 transition-colors mt-1" title="Hapus"><span class="material-symbols-outlined text-[18px]">delete</span></button></div>`; container.appendChild(div); renumberKesimpulanSections(); }

        let bab23SubabCounter = 1, bab23SubSubabCounter = 100;
        function getBab23TableTemplate(uid) { return `<div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative" data-table-uid="${uid}" onpaste="handleMixingPaste(event, this)"><div class="absolute top-1 right-1 z-20 remove-table-btn"><button type="button" onclick="toggleTableMenu(this)" class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors" title="Opsi"><span class="material-symbols-outlined text-[20px] block">more_vert</span></button><div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30"><button type="button" onclick="removeMixingTable(this)" class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span>Hapus Tabel</button></div></div><div class="p-6"><div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-6 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)"><span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-2">content_paste</span><p class="text-base font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p><p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Copy dari Excel atau Screenshot lalu paste (Ctrl+V)</p><div class="flex justify-center mb-4"><button type="button" onclick="triggerClipboardPaste(this)" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">content_paste_go</span>Tempel dari Clipboard</button></div><textarea rows="4" class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)" onpaste="handleClipboardFieldPaste(event, this)"></textarea></div><input type="file" name="mixing_image_file[${uid}]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)"><div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1"><img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm"><button type="button" onclick="removeImage(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Gambar"><span class="material-symbols-outlined text-[14px] block">close</span></button></div><div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3"><div class="overflow-auto max-h-[420px]"><table class="w-full text-sm border-collapse pasted-table-preview-table"></table></div><button type="button" onclick="removePastedTable(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Tabel Paste"><span class="material-symbols-outlined text-[14px] block">close</span></button></div></div><input type="hidden" name="bab22_table_subab_key[${uid}]" value="bab23"><input type="hidden" name="existing_mixing_image_file[${uid}]" value=""><input type="hidden" name="mixing_pasted_table_json[${uid}]" value=""><input type="hidden" name="mixing_image_base64[${uid}]" value=""></div>`; }
        function addBab23Subab() { bab23SubabCounter++; const key = `bab23_subab_dyn_${bab23SubabCounter}`; const container = document.getElementById('bab23_dynamic_subab_container'); const el = document.createElement('div'); el.className = 'bab23-subab'; el.dataset.subabKey = key; el.innerHTML = `<div class="flex items-center gap-2 mb-3"><span class="bab23-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors whitespace-nowrap" onclick="toggleBab23Subab(this)" title="Klik untuk disable/enable">2.3.X</span><input type="text" name="${key}_title" class="template-input flex-1 font-semibold" placeholder="Judul subab"><button type="button" onclick="removeBab23Subab(this)" class="text-slate-400 hover:text-red-600 transition-colors" title="Hapus subab"><span class="material-symbols-outlined text-[18px]">delete</span></button></div><div class="bab23-subsubab-container ml-4 flex flex-col gap-4"></div><div class="ml-4 mt-3"><button type="button" onclick="addBab23SubSubab(this)" class="w-full py-2 border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-lg text-slate-400 dark:text-slate-500 hover:border-blue-400 hover:text-blue-600 transition-colors flex items-center justify-center gap-2 text-sm"><span class="material-symbols-outlined text-[18px]">add</span>Tambah Sub-subab</button></div>`; container.appendChild(el); el.querySelector(`input[name="${key}_title"]`).focus(); }
        function removeBab23Subab(button) { const subab = button.closest('.bab23-subab'); if (subab) subab.remove(); }
        function toggleBab23Subab(numberEl) { const subab = numberEl.closest('.bab23-subab'); const isDisabled = subab.classList.toggle('subab-disabled'); subab.style.opacity = isDisabled ? '0.35' : '1'; numberEl.classList.toggle('line-through', isDisabled); numberEl.classList.toggle('text-red-500', isDisabled); subab.querySelectorAll('input, textarea, button, select').forEach(el => { isDisabled ? el.setAttribute('disabled', 'disabled') : el.removeAttribute('disabled'); }); }
        function addBab23SubSubab(button) { bab23SubSubabCounter++; const subab = button.closest('.bab23-subab'); const container = subab.querySelector('.bab23-subsubab-container'); const subabKey = subab.dataset.subabKey || `bab23_${bab23SubabCounter}`; const key = `${subabKey}_sub_${bab23SubSubabCounter}`; const el = document.createElement('div'); el.className = 'bab23-subsubab'; el.dataset.subsubabKey = key; el.innerHTML = `<div class="flex items-start gap-2 mb-2"><span class="bab23-subsubab-number font-medium text-slate-700 dark:text-slate-300 cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors whitespace-nowrap mt-0.5" onclick="toggleBab23SubSubab(this)" title="Klik untuk disable/enable">2.3.X.X</span><input type="text" name="${key}_title" class="template-input flex-1" placeholder="Judul sub-subab (opsional)"><button type="button" onclick="removeBab23SubSubab(this)" class="text-slate-400 hover:text-red-600 transition-colors mt-1" title="Hapus"><span class="material-symbols-outlined text-[18px]">delete</span></button></div><div class="ml-10"><textarea name="${key}_text" rows="3" class="w-full resize-y px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all text-sm mb-2" placeholder="Isi teks sub-subab ini..."></textarea><div class="bab23-tables-container flex flex-col gap-3"></div><button type="button" onclick="addBab23Table(this)" class="mt-2 w-full py-2 border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-lg text-slate-400 dark:text-slate-500 hover:border-blue-400 hover:text-blue-600 transition-colors flex items-center justify-center gap-2 text-sm"><span class="material-symbols-outlined text-[18px]">add_photo_alternate</span>Tambah Tabel / Screenshot</button></div>`; container.appendChild(el); }
        function removeBab23SubSubab(button) { const subsubab = button.closest('.bab23-subsubab'); if (subsubab) subsubab.remove(); }
        function toggleBab23SubSubab(numberEl) { const subsubab = numberEl.closest('.bab23-subsubab'); const isDisabled = subsubab.classList.toggle('subsubab-disabled'); subsubab.style.opacity = isDisabled ? '0.35' : '1'; numberEl.classList.toggle('line-through', isDisabled); numberEl.classList.toggle('text-red-500', isDisabled); subsubab.querySelectorAll('input, textarea, button, select').forEach(el => { isDisabled ? el.setAttribute('disabled', 'disabled') : el.removeAttribute('disabled'); }); }
        function addBab23Table(button) { bab23SubSubabCounter++; const uid = `bab23_tbl_${bab23SubSubabCounter}`; let container = button.previousElementSibling; if (!container || !container.classList.contains('bab23-tables-container')) { container = document.createElement('div'); container.className = 'bab23-tables-container flex flex-col gap-3 mb-2'; button.insertAdjacentElement('beforebegin', container); } container.insertAdjacentHTML('beforeend', getBab23TableTemplate(uid)); }
        document.addEventListener('click', function(event) { if (!event.target.closest('.remove-table-btn')) document.querySelectorAll('.table-dropdown-menu').forEach(menu => menu.classList.add('hidden')); });
        const PARSE_EXCEL_URL = "{{ route('template-summary.parse-excel', [], false) }}";
        const SAVE_DRAFT_URL = "{{ route('template-summary.nutracare.draft', [], false) }}";
        const CSRF_TOKEN = "{{ csrf_token() }}";
        const INITIAL_DRAFT_STATE = @json($initialDraftState ?? null);
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar-container');
            const footer = document.getElementById('actionFooter');
            if (sidebar && footer) { const observer = new MutationObserver(function(mutations) { mutations.forEach(function(mutation) { if (mutation.attributeName === 'class') { footer.style.left = sidebar.classList.contains('sidebar-collapsed') ? '4.5rem' : '14.5rem'; } }); }); observer.observe(sidebar, { attributes: true }); if (sidebar.classList.contains('sidebar-collapsed')) footer.style.left = '4.5rem'; }
            if (INITIAL_DRAFT_STATE) { restoreDraftState(INITIAL_DRAFT_STATE); } else { renumberKesimpulanSections(); }
            const allSyncInputs = document.querySelectorAll('.sync-input[data-sync]');
            const syncGroups = {}; allSyncInputs.forEach(input => { const key = input.getAttribute('data-sync'); if (!syncGroups[key]) syncGroups[key] = []; syncGroups[key].push(input); });
            Object.keys(syncGroups).forEach(key => { const group = syncGroups[key]; group.forEach(input => { input.addEventListener('input', function() { const value = this.value; group.forEach(other => { if (other !== this) other.value = value; }); }); }); });
            const nutracareForm = document.getElementById('nutracareTemplateForm');
            if (nutracareForm) { nutracareForm.addEventListener('submit', function() { showExportModal(); document.querySelectorAll('.mixing-table-item').forEach(tableItem => { const tableUid = getTableUidFromItem(tableItem); if (!tableUid) return; const previewBox = tableItem.querySelector('.image-preview-box'); const img = previewBox ? previewBox.querySelector('img') : null; const base64Input = tableItem.querySelector(`input[name="mixing_image_base64[${escapeNameForSelector(tableUid)}]"]`); if (img && img.src && img.src.startsWith('data:image') && base64Input && !base64Input.value) base64Input.value = img.src; }); }); }
            document.querySelectorAll('.mixing-table-item').forEach(tableItem => { const tableUid = getTableUidFromItem(tableItem); if (!tableUid) return; const pastedTableInput = tableItem.querySelector(`input[name="mixing_pasted_table_json[${escapeNameForSelector(tableUid)}]"]`); if (pastedTableInput && pastedTableInput.value) { try { const rows = JSON.parse(pastedTableInput.value); if (Array.isArray(rows) && rows.length) renderPastedTablePreview(tableItem, rows); } catch (e) {} } const base64Input = tableItem.querySelector(`input[name="mixing_image_base64[${escapeNameForSelector(tableUid)}]"]`); if (base64Input && base64Input.value && base64Input.value.startsWith('data:image')) { const previewBox = tableItem.querySelector('.image-preview-box'); const img = previewBox ? previewBox.querySelector('img') : null; if (img && previewBox) { img.src = base64Input.value; previewBox.classList.remove('hidden'); } } });
        });
        function showExportModal() { const token = 'exp_' + Date.now(); let tokenInput = document.getElementById('export_token_input'); if (!tokenInput) { tokenInput = document.createElement('input'); tokenInput.type = 'hidden'; tokenInput.name = 'export_token'; tokenInput.id = 'export_token_input'; document.getElementById('nutracareTemplateForm').appendChild(tokenInput); } tokenInput.value = token; document.cookie = 'export_done=; Max-Age=0; path=/'; document.getElementById('exportLoadingModal').classList.remove('hidden'); const poll = setInterval(function () { if (document.cookie.split(';').some(c => c.trim().startsWith('export_done=' + token))) { clearInterval(poll); document.cookie = 'export_done=; Max-Age=0; path=/'; document.getElementById('exportLoadingModal').classList.add('hidden'); } }, 500); }
    </script>

    {{-- Export Loading Modal --}}
    <div id="exportLoadingModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="bg-slate-800 rounded-2xl shadow-2xl px-10 py-8 flex flex-col items-center gap-4 min-w-[320px]">
            <div class="w-16 h-16 rounded-full border-4 border-slate-600 border-t-red-500 animate-spin"></div>
            <div class="text-center">
                <p class="text-white font-bold text-lg">Memproses Export</p>
                <p class="text-slate-400 text-sm mt-1">Mohon tunggu, dokumen sedang dibuat...</p>
            </div>
            <div class="w-full flex items-center gap-3 bg-slate-700/60 rounded-xl px-4 py-3">
                <span class="material-symbols-outlined text-red-400 text-[22px]">description</span>
                <span class="text-slate-300 text-sm">Menghasilkan dokumen Word</span>
            </div>
        </div>
    </div>
@endsection