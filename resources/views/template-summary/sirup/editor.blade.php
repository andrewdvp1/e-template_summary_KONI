@extends('layouts.app')

@section('content')
    <form action="{{ route('template-summary.sirup.export') }}" method="POST" id="sirupTemplateForm"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="draft_id" id="draft_id" value="{{ $draft->id ?? '' }}">

        <div class="max-w-5xl mx-auto flex flex-col gap-6 pb-24">

            {{-- Title Section --}}
            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="font-bold text-slate-900 dark:text-white">Judul Summary</h2>
                </div>
                <div class="p-6">
                    {{-- Main Title with blanks --}}
                    <div class="text-base leading-relaxed text-slate-700 dark:text-slate-300 template-text">
                        <p class="font-bold text-center text-base mb-2">
                            SUMMARY LAPORAN VALIDASI PROSES PEMBUATAN PRODUK
                            <input type="text" name="judul_nama_produk" class="template-input sync-input w-48 uppercase"
                                data-sync="nama_produk" placeholder="Anakonidin OBH 30 ml">
                        </p>
                        <p class="font-bold text-center text-base mb-4">
                            (<input type="text" name="judul_formula" class="template-input sync-input w-96"
                                data-sync="formula" placeholder="Formula Zat Aktif (Opsional)">) DI LINE
                            <input type="text" name="judul_line" class="template-input sync-input w-8" data-sync="line"
                                placeholder="1">
                            BAGIAN
                            <input type="text" name="judul_bagian" class="template-input sync-input w-96 uppercase"
                                data-sync="bagian" value="Production (Pharmaceutical II) Gedung B"
                                placeholder="Production (Pharmaceutical II) Gedung B">
                        </p>
                    </div>

                    {{-- Document Info Box --}}
                    <div class="mt-6 border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden">
                        <table class="w-full text-base">
                            <tbody>
                                <tr class="border-b border-slate-300 dark:border-slate-600">
                                    <td
                                        class="px-4 py-2 font-medium text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-900/50 w-40">
                                        Dokumen No.</td>
                                    <td class="px-4 py-2 border-l border-slate-300 dark:border-slate-600">
                                        <input type="text" name="dokumen_no" class="template-input w-48" placeholder="-">
                                    </td>
                                    <td
                                        class="px-4 py-2 font-medium text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-900/50 w-24 border-l border-slate-300 dark:border-slate-600">
                                        Tanggal</td>
                                    <td class="px-4 py-2 border-l border-slate-300 dark:border-slate-600">
                                        <input type="text" name="dokumen_tanggal" class="template-input w-40"
                                            placeholder="-">
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="px-4 py-2 font-medium text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-900/50">
                                        Pengganti No.</td>
                                    <td class="px-4 py-2 border-l border-slate-300 dark:border-slate-600">
                                        <input type="text" name="pengganti_no" class="template-input w-48"
                                            placeholder="-">
                                    </td>
                                    <td
                                        class="px-4 py-2 font-medium text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-900/50 border-l border-slate-300 dark:border-slate-600">
                                        Tanggal</td>
                                    <td class="px-4 py-2 border-l border-slate-300 dark:border-slate-600">
                                        <input type="text" name="pengganti_tanggal" class="template-input w-40"
                                            placeholder="-">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- BAB 1: PENDAHULUAN --}}
            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="font-bold text-slate-900 dark:text-white">1. PENDAHULUAN</h2>
                </div>
                <div class="p-6 flex flex-col gap-6">
                    {{-- 1.1 Tujuan --}}
                    <div>
                        <h3 class="font-semibold text-slate-800 dark:text-slate-200 mb-3">1.1 Tujuan</h3>
                        <div
                            class="ml-4 text-base leading-relaxed text-slate-700 dark:text-slate-300 template-text text-justify">
                            <p class="pl-8 -indent-8">
                                <span class="font-medium">1.1.1</span> Summary validasi ini bertujuan mendokumentasikan
                                hasil studi validasi/pembuktian terhadap kualitas dan reprodusibilitas proses pengolahan
                                produk
                                <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-40"
                                    data-sync="nama_produk" placeholder="Anakonidin OBH 30 ml">
                                di Line
                                <input type="text" name="tujuan_line" class="template-input sync-input w-8"
                                    data-sync="line" placeholder="2">
                                Bagian
                                <input type="text" name="tujuan_bagian" class="template-input sync-input w-96"
                                    data-sync="bagian" value="Produksi Farmasi I Line Soft Capsule Gedung A"
                                    placeholder="Production (Produksi Farmasi I Line Soft Capsule Gedung A">
                                yang diproduksi dengan
                                <input type="text" name="tujuan_mesin" class="template-input sync-input w-full"
                                    data-sync="mesin"
                                    value="Mesin Mixer dan Holding Tank Indo Laval 600 L, Mesin Blow and Suck Fillomatic Tornado 8 SA, Mesin Filling-capping Bausch and Stroebel FVF 5060"
                                    placeholder="Mesin Mixer dan Holding Tank Indo Laval 600 L, Mesin Blow and Suck Fillomatic Tornado 8 SA, Mesin Filling-capping Bausch and Stroebel FVF 5060">
                                dalam menghasilkan produk
                                <input type="text" name="tujuan_nama_produk_2" class="template-input sync-input w-40"
                                    data-sync="nama_produk" placeholder="Anakonidin OBH 30 ml">
                                dalam kemasan botol yang memenuhi persyaratan mutu yang tercantum dalam Spesifikasi Produk
                                dan Spesifikasi Kemasan yang berlaku.
                            </p>
                        </div>
                    </div>

                    {{-- 1.2 Batch Validasi --}}
                    <div>
                        <h3 class="font-semibold text-slate-800 dark:text-slate-200 mb-3">1.2 Batch Validasi</h3>
                        <div
                            class="text-base leading-relaxed text-slate-700 dark:text-slate-300 template-text text-justify mb-4">
                            <p>
                                Studi validasi dilakukan terhadap
                                <input type="text" name="batch_jumlah" class="template-input w-12"
                                    placeholder="tiga">
                                batch produksi dengan besaran batch
                                <input type="text" name="batch_besaran" class="template-input w-20"
                                    placeholder="600 L">
                                =
                                <input type="text" name="batch_jumlah_botol" class="template-input w-24"
                                    placeholder="20.000">
                                botol @
                                <input type="text" name="batch_volume_per_botol" class="template-input w-16"
                                    value="" placeholder="30 ml">,
                                yaitu
                                <input type="text" name="batch_kode_list" class="template-input sync-input w-64"
                                    data-sync="batch" placeholder="A26A01, A26A02, A26A03">:
                            </p>
                        </div>

                        {{-- Excel Paste Area --}}
                        <div class="border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden">
                            <div
                                class="px-4 py-3 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-300 dark:border-slate-600 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-slate-500 text-[20px]">table_chart</span>
                                    <span class="text-base font-medium text-slate-700 dark:text-slate-300">Tabel Identitas
                                        Bahan Baku Zat Aktif</span>
                                </div>
                                <button type="button" onclick="clearExcelTable('bahan_aktif')"
                                    class="text-xs text-slate-500 hover:text-red-600 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                    Clear
                                </button>
                            </div>

                            {{-- Paste Instructions --}}
                            <div id="paste_instructions_bahan_aktif" class="p-4">
                                <div
                                    class="border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-8 text-center">
                                    <span
                                        class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-2">content_paste</span>
                                    <p class="text-base font-medium text-slate-600 dark:text-slate-400 mb-1">Paste dari
                                        Excel</p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Copy data dari Excel (4
                                        kolom: Bahan aktif, Kode Bahan Baku, Nama Supplier, Negara) lalu paste di bawah</p>
                                    <textarea id="excel_paste_bahan_aktif" rows="4"
                                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-base focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none font-mono"
                                        placeholder="Paste data Excel disini (Ctrl+V)..." onpaste="handleExcelPaste(event, 'bahan_aktif')"></textarea>
                                </div>
                            </div>

                            {{-- Table Preview (hidden by default) --}}
                            <div id="table_preview_bahan_aktif" class="hidden">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-base" id="preview_table_bahan_aktif">
                                        <thead>
                                            <tr class="bg-slate-100 dark:bg-slate-700">
                                                <th
                                                    class="px-4 py-2 text-left font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-300 dark:border-slate-600">
                                                    Bahan aktif</th>
                                                <th
                                                    class="px-4 py-2 text-left font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-300 dark:border-slate-600">
                                                    Kode Bahan Baku</th>
                                                <th
                                                    class="px-4 py-2 text-left font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-300 dark:border-slate-600">
                                                    Nama Supplier</th>
                                                <th
                                                    class="px-4 py-2 text-left font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-300 dark:border-slate-600">
                                                    Negara</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_body_bahan_aktif">
                                            {{-- Rows will be inserted here by JS --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Hidden input to store table data --}}
                            <input type="hidden" name="tabel_bahan_aktif" id="hidden_data_bahan_aktif">
                        </div>
                    </div>
                </div>
            </div>

            {{-- BAB 2: RANGKUMAN HASIL --}}
            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div
                    class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <h2 class="font-bold text-slate-900 dark:text-white">2. RANGKUMAN HASIL</h2>
                    <span class="text-xs text-slate-400 dark:text-slate-500">Klik nomor untuk enable/disable</span>
                </div>
                <div class="p-6 flex flex-col gap-6">
                    {{-- 2.1 --}}
                    <div>
                        <!-- <h3 class="font-semibold text-slate-800 dark:text-slate-200 mb-3">2.1</h3> -->
                        <div
                            class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                            <p class="pl-8 -indent-8">
                                <span class="font-semibold">2.1.</span> Semua tahap dalam penimbangan bahan baku, mixing,
                                dan filling telah dilakukan sesuai prosedur pengolahan dan pengemasan yang berlaku.
                            </p>
                        </div>
                    </div>

                    {{-- 2.2 Hasil pemeriksaan sampel --}}
                    <div>
                        <h3 class="font-semibold text-slate-800 dark:text-slate-200 mb-3">2.2 Hasil pemeriksaan sampel</h3>
                        <input type="hidden" name="bab22_enabled_subab_keys" id="bab22_enabled_subab_keys"
                            value="">

                        {{-- 2.2.1 Mixing --}}
                        <div class="bab22-subab" id="bab22_subab_mixing" draggable="true" data-subab-type="default"
                            data-subab-id="1" data-subab-key="mixing" data-subab-title="Mixing"
                            data-closing-kind="template" data-template-stage="mixing">
                            <h4
                                class="font-medium text-slate-700 dark:text-slate-300 mb-4 flex items-center justify-between">
                                <span>
                                    <span
                                        class="bab22-number bab22-toggle-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                        onclick="toggleBab22Subab(this)" title="Klik untuk disable/enable">2.2.1</span>
                                    <span class="bab22-title">Mixing</span>
                                </span>
                                <span
                                    class="material-symbols-outlined text-[18px] text-slate-400 cursor-grab select-none">drag_indicator</span>
                            </h4>

                            {{-- Dynamic Tables Container --}}
                            <div class="mixing-tables-container flex flex-col gap-4">
                                {{-- Initial Table (Table 1) --}}
                                <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative"
                                    data-table-index="0" data-table-uid="table_1"
                                    onpaste="handleMixingPaste(event, this)">
                                    {{-- Three Dot Menu --}}
                                    <div class="absolute top-1 right-1 z-20 remove-table-btn">
                                        <button type="button" onclick="toggleTableMenu(this)"
                                            class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors"
                                            title="Opsi">
                                            <span class="material-symbols-outlined text-[20px] block">more_vert</span>
                                        </button>
                                        {{-- Dropdown Menu --}}
                                        <div
                                            class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30">
                                            <button type="button" onclick="removeMixingTable(this)"
                                                class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                                Hapus Tabel
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Excel / Screenshot Paste Area --}}
                                    <div class="p-6">
                                        {{-- Instructions & Drop Zone --}}
                                        <div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-8 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)">
                                            <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-2">content_paste</span>
                                            <p class="text-base font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p>
                                            <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Copy data dari Excel atau Screenshot lalu paste di bawah (Ctrl+V)</p>
                                            <div class="flex justify-center mb-4">
                                                <button type="button" onclick="triggerClipboardPaste(this)"
                                                    class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-[16px]">content_paste_go</span>
                                                    Tempel dari Clipboard
                                                </button>
                                            </div>
                                            <textarea rows="4"
                                                class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono"
                                                placeholder="Paste screenshot / tabel Excel di sini, atau ketik catatan... (Ctrl+V)"
                                                onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                                        </div>

                                        {{-- Hidden File Inputs untuk Backward Compatibility / Export --}}
                                        <input type="file" name="mixing_image_file[table_1]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                                        <input type="file" name="mixing_excel_file[table_1]" accept=".xlsx,.xls,.ods" class="hidden" onchange="updateFileName(this)">

                                        {{-- Full Width Preview Container (Hidden by default) --}}
                                        <div
                                            class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1">
                                            <img src="" alt="Preview"
                                                class="w-full h-auto rounded-md shadow-sm">
                                            <button type="button" onclick="removeImage(this)"
                                                class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10"
                                                title="Hapus Gambar">
                                                <span class="material-symbols-outlined text-[14px] block">close</span>
                                            </button>
                                        </div>

                                        <div
                                            class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3">
                                            <div class="overflow-auto max-h-[420px]">
                                                <table class="w-full text-sm border-collapse pasted-table-preview-table"></table>
                                            </div>
                                            <button type="button" onclick="removePastedTable(this)"
                                                class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10"
                                                title="Hapus Tabel Paste">
                                                <span class="material-symbols-outlined text-[14px] block">close</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="bab22_table_subab_key[table_1]" value="mixing">
                            <input type="hidden" name="existing_mixing_image_file[table_1]" value="">
                            <input type="hidden" name="mixing_pasted_table_json[table_1]" value="">
                            <input type="hidden" name="mixing_image_base64[table_1]" value="">

                            {{-- Add Table Button --}}
                            <button type="button" onclick="addMixingTableToSubab(this)"
                                class="mt-4 w-full py-3 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg text-slate-500 dark:text-slate-400 hover:border-red-400 hover:text-red-600 transition-colors flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">add</span>
                                <span class="text-sm font-medium">Tambah Tabel</span>
                            </button>

                            {{-- Closing Text --}}
                            <div
                                class="mt-6 text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                                <p>
                                    Atribut yang diuji pada tahap mixing sudah memberikan hasil yang
                                    <input type="text" name="mixing_hasil" class="template-input w-32" value=""
                                        placeholder="memenuhi">
                                    persyaratan menurut Spesifikasi Produk yang berlaku
                                    <input type="text" name="mixing_hasil_catatan" class="template-input w-64"
                                        value="" placeholder="">
                                    .
                                </p>
                            </div>
                        </div>

                        <div id="bab22_dynamic_subab_container" class="ml-4 flex flex-col gap-4"></div>
                        <div class="ml-4 mt-4">
                            <button type="button" onclick="addBab22CustomSubab()"
                                class="w-full py-3 border-2 border-dashed border-red-200 dark:border-red-800 rounded-lg text-red-600 dark:text-red-400 hover:border-red-400 hover:bg-red-50/40 dark:hover:bg-red-900/20 transition-colors flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">add</span>
                                <span class="text-sm font-medium">Tambah Subab/Proses</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BAB 3: KESIMPULAN --}}
            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div
                    class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <h2 class="font-bold text-slate-900 dark:text-white">3. KESIMPULAN</h2>
                    <span class="text-xs text-slate-400 dark:text-slate-500">Klik nomor untuk enable/disable</span>
                </div>
                <div class="p-6 flex flex-col gap-6" id="bab3_container">
                    {{-- Hidden input to track enabled sections --}}
                    <input type="hidden" name="kesimpulan_enabled_sections" id="kesimpulan_enabled_sections"
                        value="1,2,3,4,5">

                    {{-- 3.1 --}}
                    <div class="kesimpulan-section" data-section-id="1">
                        <div
                            class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify transition-opacity duration-200">
                            <p class="pl-8 -indent-8">
                                <span
                                    class="kesimpulan-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                    onclick="toggleKesimpulanSection(this)" title="Klik untuk disable/enable">3.1</span>
                                Telah dilakukan proses produksi terhadap produk
                                <input type="text" name="kesimpulan_nama_produk"
                                    class="template-input sync-input w-48" data-sync="nama_produk"
                                    placeholder="Anakonidin OBH 30 ml">,
                                yakni pada batch
                                <input type="text" name="kesimpulan_batch_codes"
                                    class="template-input sync-input w-48" data-sync="batch"
                                    placeholder="A26A01, A26A02, A26A03">
                                yang digunakan sebagai batch validasi proses.
                            </p>
                        </div>
                    </div>

                    {{-- 3.2 --}}
                    <div class="kesimpulan-section" data-section-id="2">
                        <div
                            class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify transition-opacity duration-200">
                            <p class="pl-8 -indent-8">
                                <span
                                    class="kesimpulan-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                    onclick="toggleKesimpulanSection(this)" title="Klik untuk disable/enable">3.2</span>
                                Atribut yang diuji pada tahap mixing (<input type="text"
                                    name="kesimpulan_mixing_atribut" class="template-input w-115"
                                    value = "bentuk, warna, aroma, kejernihan, pH, identifikasi, kadar zat aktif, kadar pengawet, batas mikroba"
                                    placeholder="bentuk, warna, aroma, kejernihan, pH, identifikasi, kadar zat aktif, kadar pengawet, batas mikroba">)
                                sudah memberikan hasil yang
                                <input type="text" name="kesimpulan_mixing_hasil" class="template-input w-32"
                                    value="" placeholder="memenuhi">
                                persyaratan menurut Spesifikasi Produk yang berlaku.
                            </p>
                        </div>
                    </div>

                    {{-- 3.3 Awal Filling-Capping --}}
                    <div class="kesimpulan-section" data-section-id="3">
                        <div
                            class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify transition-opacity duration-200">
                            <p class="pl-8 -indent-8">
                                <span
                                    class="kesimpulan-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                    onclick="toggleKesimpulanSection(this)" title="Klik untuk disable/enable">3.3</span>
                                Atribut yang diuji pada tahap awal filling-capping (<input type="text"
                                    name="kesimpulan_fillingawal_atribut" class="template-input w-115"
                                    value="bentuk, warna, aroma, pH, identifikasi, kadar zat aktif, kadar pengawet, batas mikroba"
                                    placeholder="bentuk, warna, aroma, pH, identifikasi, kadar zat aktif, kadar pengawet, batas mikroba">)
                                sudah memberikan hasil yang
                                <input type="text" name="kesimpulan_fillingawal_hasil" class="template-input w-32"
                                    value="" placeholder="memenuhi">
                                persyaratan menurut Spesifikasi Produk yang berlaku.
                            </p>
                        </div>
                    </div>

                    {{-- 3.4 Filling-Capping --}}
                    <div class="kesimpulan-section" data-section-id="4">
                        <div
                            class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify transition-opacity duration-200">
                            <p class="pl-8 -indent-8">
                                <span
                                    class="kesimpulan-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                    onclick="toggleKesimpulanSection(this)" title="Klik untuk disable/enable">3.4</span>
                                Atribut yang diuji pada tahap filling-capping produk suspensi ke dalam kemasan botol (<input
                                    type="text" name="kesimpulan_filling_atribut" class="template-input w-full"
                                    value = "bentuk, warna, aroma, pH, identifikasi, kadar zat aktif, kadar pengawet, batas mikroba, kebocoran botol, volume terpindahkan"
                                    placeholder="bentuk, warna, aroma, pH, identifikasi, kadar zat aktif, kadar pengawet, batas mikroba, kebocoran botol, volume terpindahkan">)
                                sudah memberikan hasil yang
                                <input type="text" name="kesimpulan_filling_hasil" class="template-input w-32"
                                    value="" placeholder="memenuhi">
                                persyaratan menurut Spesifikasi Produk dan Spesifikasi Kemasan yang berlaku.
                            </p>
                        </div>
                    </div>

                    {{-- 3.5 Final Conclusion --}}
                    <div class="kesimpulan-section" data-section-id="5">
                        <div
                            class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify transition-opacity duration-200">
                            <p class="pl-8 -indent-8">
                                <span
                                    class="kesimpulan-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                    onclick="toggleKesimpulanSection(this)" title="Klik untuk disable/enable">3.5</span>
                                Sesuai dengan hasil evaluasi terhadap kesesuaian pelaksanaan di setiap tahap proses
                                produksi, parameter proses dan hasil pemeriksaan atribut kualitas produk pada tahap
                                <input type="text" name="kesimpulan_tahap_proses" class="template-input w-full"
                                    value="mixing, awal filling-capping, selama filling-capping"
                                    placeholder="mixing, awal filling-capping, selama filling-capping">
                                yang memenuhi persyaratan, maka proses
                                pengolahan dan pengemasan produk
                                <input type="text" name="kesimpulan_final_produk"
                                    class="template-input sync-input w-48" data-sync="nama_produk"
                                    placeholder="Anakonidin OBH 30 ml">
                                menggunakan
                                <input type="text" name="kesimpulan_mesin" class="template-input sync-input w-full"
                                    data-sync="mesin"
                                    value="Mesin Mixer dan Holding Tank Indo Laval 600 L, Mesin Blow and Suck Fillomatic Tornado 8 SA, Mesin Filling-capping Bausch and Stroebel FVF 5060"
                                    placeholder="Mesin Mixer dan Holding Tank Indo Laval 600 L, Mesin Blow and Suck Fillomatic Tornado 8 SA, Mesin Filling-capping Bausch and Stroebel FVF 5060">
                                dengan formula zat aktif
                                (<input type="text" name="kesimpulan_formula" class="template-input sync-input w-96"
                                    data-sync="formula" placeholder="Formula Zat Aktif (Opsional)">)
                                dinyatakan
                                <input type="text" name="kesimpulan_status" class="template-input w-32 italic"
                                    placeholder="validated">.
                            </p>
                        </div>
                    </div>

                    {{-- Custom sections container --}}
                    <div id="custom_kesimpulan_container"></div>

                    {{-- Add section button --}}
                    <div class="flex justify-center">
                        <button type="button" onclick="addCustomKesimpulan()"
                            class="flex items-center justify-center gap-2 px-4 py-3 rounded-lg border-2 border-dashed border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 hover:border-red-400 hover:bg-red-50/40 dark:hover:bg-red-900/20 transition-colors">
                            <span class="material-symbols-outlined text-[20px]">add</span>
                            <span class="text-sm font-medium">Tambah Poin Kesimpulan</span>
                        </button>
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
        .template-input {
            display: inline-block;
            border: none;
            border-bottom: 2px solid #cbd5e1;
            background: transparent;
            padding: 2px 4px;
            margin: 0 2px;
            font-size: inherit;
            font-family: inherit;
            color: #1e293b;
            text-align: center;
            transition: border-color 0.2s, background-color 0.2s;
            font-weight: 700;
            /* Bold font for inputs */
        }

        .template-input:focus {
            outline: none;
            border-bottom-color: #dc2626;
            background-color: #fef2f2;
        }

        .template-input::placeholder {
            color: #94a3b8;
            font-style: italic;
        }

        .dark .template-input {
            color: #e2e8f0;
            border-bottom-color: #475569;
        }

        .dark .template-input:focus {
            background-color: rgba(220, 38, 38, 0.1);
        }

        .dark .template-input::placeholder {
            color: #64748b;
        }

        /* Date input styling */
        .template-input[type="date"] {
            padding: 1px 4px;
        }
    </style>

    {{-- Excel Paste Handler Script --}}
    <script>
        // Store table data
        const tableData = {};

        function handleExcelPaste(event, tableId) {
            // Jangan hentikan default jika Anda ingin teks tetap muncul di textarea sebentar
            // Namun untuk parsing Excel, kita butuh data clipboard-nya
            const clipboardData = event.clipboardData || window.clipboardData;
            const pastedData = clipboardData.getData('text');

            if (!pastedData || !pastedData.trim()) {
                return;
            }

            event.preventDefault(); // Hentikan paste teks mentah ke textarea jika data valid

            // Parse tab-separated values (Excel format)
            const rows = pastedData.trim().split(/\r?\n/).map(row => row.split('\t'));

            if (rows.length === 0) return;

            // Simpan ke hidden input
            tableData[tableId] = rows;
            const hiddenInput = document.getElementById('hidden_data_' + tableId);
            if (hiddenInput) {
                hiddenInput.value = JSON.stringify(rows);
            }

            // Update UI Preview
            const tbody = document.getElementById('table_body_' + tableId);
            if (tbody) {
                tbody.innerHTML = '';
                rows.forEach((row, index) => {
                    const tr = document.createElement('tr');
                    tr.className = index % 2 === 0 ? 'bg-white dark:bg-slate-800' : 'bg-slate-50 dark:bg-slate-900/50';
                    
                    // Ambil maksimal 4 kolom sesuai header
                    for (let i = 0; i < 4; i++) {
                        const td = document.createElement('td');
                        td.className = 'px-4 py-2 text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700';
                        td.textContent = row[i] || '';
                        tr.appendChild(td);
                    }
                    tbody.appendChild(tr);
                });

                // Toggle visibility
                document.getElementById('paste_instructions_' + tableId).classList.add('hidden');
                document.getElementById('table_preview_' + tableId).classList.remove('hidden');
            }
        }

        function clearExcelTable(tableId) {
            // Clear data
            tableData[tableId] = [];
            document.getElementById('hidden_data_' + tableId).value = '';

            // Clear table body
            document.getElementById('table_body_' + tableId).innerHTML = '';

            // Show paste area, hide table preview
            document.getElementById('paste_instructions_' + tableId).classList.remove('hidden');
            document.getElementById('table_preview_' + tableId).classList.add('hidden');
        }

        function focusClipboardField(container) {
            const textarea = container.querySelector('.clipboard-input-area');
            if (textarea) {
                textarea.focus();
            }
        }

        async function triggerClipboardPaste(button) {
            // Minta akses clipboard dari browser
            if (!navigator.clipboard || !navigator.clipboard.read) {
                alert('Browser Anda tidak mendukung akses clipboard otomatis. Silakan gunakan Ctrl+V langsung di area textarea.');
                return;
            }
            try {
                const clipboardItems = await navigator.clipboard.read();
                const tableItem = button.closest('.mixing-table-item');
                if (!tableItem) return;

                for (const clipboardItem of clipboardItems) {
                    // Cek apakah ada gambar di clipboard
                    for (const type of clipboardItem.types) {
                        if (type.startsWith('image/')) {
                            const blob = await clipboardItem.getType(type);
                            const imageInput = tableItem.querySelector('input[type="file"][accept*="image"]');
                            if (imageInput) {
                                const transfer = new DataTransfer();
                                transfer.items.add(new File([blob], 'pasted-image.png', { type: blob.type }));
                                imageInput.files = transfer.files;
                                previewImage(imageInput);
                            }
                            return;
                        }
                    }
                    // Cek apakah ada teks/tabel di clipboard
                    for (const type of clipboardItem.types) {
                        if (type === 'text/plain') {
                            const blob = await clipboardItem.getType(type);
                            const text = await blob.text();
                            if (text && text.includes('\t')) {
                                const rows = text
                                    .replace(/\r/g, '')
                                    .split('\n')
                                    .map(row => row.split('\t').map(cell => cell.trim()))
                                    .filter(row => row.some(cell => cell !== ''));
                                if (rows.length) {
                                    const tableUid = getTableUidFromItem(tableItem);
                                    const hiddenInput = tableUid ? tableItem.querySelector(
                                        `input[name="mixing_pasted_table_json[${escapeNameForSelector(tableUid)}]"]`) : null;
                                    if (hiddenInput) hiddenInput.value = JSON.stringify(rows);
                                    renderPastedTablePreview(tableItem, rows);
                                }
                            }
                            return;
                        }
                    }
                }
            } catch (err) {
                // Fallback: fokuskan textarea agar user bisa paste manual
                const textarea = button.closest('.mt-4')?.querySelector('.clipboard-input-area');
                if (textarea) textarea.focus();
                alert('Tidak bisa membaca clipboard otomatis. Silakan klik area teks di bawah tombol ini lalu tekan Ctrl+V.');
            }
        }

        function handleClipboardFieldPaste(event, textarea) {
            const clipboardData = event.clipboardData || event.originalEvent.clipboardData || window.clipboardData;
            if (!clipboardData) return;

            const items = clipboardData.items || [];
            let foundImage = false;

            for (let index in items) {
                const item = items[index];
                if (item.kind === 'file' && item.type.indexOf('image') !== -1) {
                    // Logika Handle Paste Gambar
                    const blob = item.getAsFile();
                    if (!blob) continue;

                    event.preventDefault();
                    foundImage = true;

                    const tableItem = textarea.closest('.mixing-table-item');
                    if (!tableItem) break;

                    // Isi input[type="file"] via DataTransfer agar gambar ikut ter-submit saat export
                    const imageInput = tableItem.querySelector('input[type="file"][accept*="image"]');
                    if (imageInput) {
                        try {
                            const transfer = new DataTransfer();
                            transfer.items.add(blob);
                            imageInput.files = transfer.files;
                            // previewImage akan menampilkan gambar DAN menyembunyikan upload-grid
                            previewImage(imageInput);
                        } catch (e) {
                            // Fallback: tampilkan preview via FileReader jika DataTransfer gagal
                            const reader = new FileReader();
                            reader.onload = function(ev) {
                                const previewBox = tableItem.querySelector('.image-preview-box');
                                const img = previewBox ? previewBox.querySelector('img') : null;
                                const grid = tableItem.querySelector('.mixing-upload-grid');
                                if (img && previewBox) {
                                    img.src = ev.target.result;
                                    previewBox.classList.remove('hidden');
                                }
                                if (grid) grid.classList.add('hidden');
                            };
                            reader.readAsDataURL(blob);
                        }
                    } else {
                        // Tidak ada file input, tampilkan preview saja
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            const previewBox = tableItem.querySelector('.image-preview-box');
                            const img = previewBox ? previewBox.querySelector('img') : null;
                            const pasteInstructions = tableItem.querySelector('.paste-instructions');
                            if (img && previewBox) {
                                img.src = ev.target.result;
                                previewBox.classList.remove('hidden');
                            }
                            if (pasteInstructions) pasteInstructions.classList.add('hidden');
                        };
                        reader.readAsDataURL(blob);
                    }
                    break;
                }
            }

            // Jika bukan gambar, cek apakah ada data tabel Excel (tab-separated)
            if (!foundImage) {
                const text = clipboardData.getData('text/plain') || clipboardData.getData('text');
                if (text && text.includes('\t')) {
                    // Ada data tabel dari Excel — proses sebagai tabel yang di-paste
                    const tableItem = textarea.closest('.mixing-table-item');
                    if (tableItem) {
                        event.preventDefault();
                        const rows = text
                            .replace(/\r/g, '')
                            .split('\n')
                            .map(row => row.split('\t').map(cell => cell.trim()))
                            .filter(row => row.some(cell => cell !== ''));

                        if (rows.length) {
                            const tableUid = getTableUidFromItem(tableItem);
                            const hiddenInput = tableUid ? tableItem.querySelector(
                                `input[name="mixing_pasted_table_json[${escapeNameForSelector(tableUid)}]"]`) : null;
                            if (hiddenInput) hiddenInput.value = JSON.stringify(rows);
                            renderPastedTablePreview(tableItem, rows);
                        }
                    }
                }
            }
        }

        function escapeNameForSelector(name) {
            return name.replace(/\\/g, '\\\\').replace(/"/g, '\\"');
        }

        function getTableUidFromItem(tableItem) {
            if (!tableItem) return null;

            if (tableItem.dataset.tableUid) {
                return tableItem.dataset.tableUid;
            }

            const hiddenMapInput = tableItem.querySelector('input[name^="bab22_table_subab_key["]');
            if (!hiddenMapInput) {
                return null;
            }

            const match = hiddenMapInput.name.match(/^bab22_table_subab_key\[(.+)\]$/);
            if (!match) {
                return null;
            }

            tableItem.dataset.tableUid = match[1];
            return match[1];
        }

        function getInputValue(input) {
            if (input.type === 'checkbox' || input.type === 'radio') {
                return input.checked ? '1' : '0';
            }
            return input.value ?? '';
        }

        function collectFormValues() {
            const values = {};
            document.querySelectorAll(
                    '#sirupTemplateForm input[name]:not([type="file"]), #sirupTemplateForm textarea[name], #sirupTemplateForm select[name]'
                )
                .forEach(input => {
                    if (input.name === 'draft_id' || input.name === '_token') {
                        return;
                    }
                    values[input.name] = getInputValue(input);
                });
            return values;
        }

        function restoreFormValues(values) {
            if (!values || typeof values !== 'object') {
                return;
            }

            Object.entries(values).forEach(([name, value]) => {
                if (name === 'draft_id' || name === '_token') {
                    return;
                }
                const selector = `[name="${escapeNameForSelector(name)}"]`;
                const fields = document.querySelectorAll(selector);
                fields.forEach(field => {
                    if (field.type === 'checkbox' || field.type === 'radio') {
                        field.checked = String(value) === '1';
                        return;
                    }
                    field.value = value ?? '';
                });
            });
        }

        function applyStoredImageToTable(tableItem, imageMeta) {
            if (!tableItem || !imageMeta || !imageMeta.url || !imageMeta.path) {
                return;
            }

            const tableUid = getTableUidFromItem(tableItem);
            if (!tableUid) {
                return;
            }

            const previewBox = tableItem.querySelector('.image-preview-box');
            const pasteInstructions = tableItem.querySelector('.paste-instructions');
            const img = previewBox ? previewBox.querySelector('img') : null;
            if (img && previewBox) {
                img.src = imageMeta.url;
                previewBox.classList.remove('hidden');
                if (pasteInstructions) pasteInstructions.classList.add('hidden');
            }

            let hiddenExisting = tableItem.querySelector(`input[name="existing_mixing_image_file[${tableUid}]"]`);
            if (!hiddenExisting) {
                hiddenExisting = document.createElement('input');
                hiddenExisting.type = 'hidden';
                hiddenExisting.name = `existing_mixing_image_file[${tableUid}]`;
                tableItem.appendChild(hiddenExisting);
            }
            hiddenExisting.value = imageMeta.path;
        }

        function collectDraftState() {
            const disabledFieldNames = [];
            document.querySelectorAll(
                    '#sirupTemplateForm input[name], #sirupTemplateForm textarea[name], #sirupTemplateForm select[name]')
                .forEach(field => {
                    if (field.disabled) {
                        disabledFieldNames.push(field.name);
                    }
                });

            const kesimpulanDisabledSectionIds = [];
            document.querySelectorAll('#bab3_container .kesimpulan-section.section-disabled').forEach(section => {
                if (section.dataset.sectionId) {
                    kesimpulanDisabledSectionIds.push(section.dataset.sectionId);
                }
            });

            const bab22Container = document.getElementById('bab22_dynamic_subab_container');
            const customKesimpulanContainer = document.getElementById('custom_kesimpulan_container');

            const storedFiles = {
                mixing_image_file: {},
                mixing_excel_file: {},
            };

            document.querySelectorAll('.mixing-table-item').forEach(tableItem => {
                const tableUid = getTableUidFromItem(tableItem);
                if (!tableUid) {
                    return;
                }

                // Prioritas 1: gambar dari existing (sudah di-upload ke server via Save Draft)
                const existingImageInput = tableItem.querySelector(
                    `input[name="existing_mixing_image_file[${tableUid}]"]`);
                if (existingImageInput && existingImageInput.value) {
                    const previewImageEl = tableItem.querySelector('.image-preview-box img');
                    storedFiles.mixing_image_file[tableUid] = {
                        path: existingImageInput.value,
                        url: previewImageEl ? previewImageEl.src : '',
                        name: '',
                    };
                }

                // Prioritas 2: gambar yang di-paste (base64, belum pernah di-save draft)
                const base64Input = tableItem.querySelector(
                    `input[name="mixing_image_base64[${escapeNameForSelector(tableUid)}]"]`);
                if (base64Input && base64Input.value) {
                    storedFiles.mixing_image_base64 = storedFiles.mixing_image_base64 || {};
                    storedFiles.mixing_image_base64[tableUid] = base64Input.value;
                }
            });

            return {
                counters: {
                    customKesimpulanCount,
                    bab22CustomSubabCounter,
                    bab22SubabIdCounter,
                    bab22TableUidCounter,
                },
                form_values: collectFormValues(),
                disabled_field_names: disabledFieldNames,
                kesimpulan_disabled_sections: kesimpulanDisabledSectionIds,
                bab22_container_html: bab22Container ? bab22Container.innerHTML : '',
                custom_kesimpulan_html: customKesimpulanContainer ? customKesimpulanContainer.innerHTML : '',
                table_data: tableData,
                stored_files: storedFiles,
            };
        }

        function restoreDraftState(state) {
            if (!state || typeof state !== 'object') {
                return;
            }

            const defaultMixing = document.getElementById('bab22_subab_mixing');
            const bab22Container = document.getElementById('bab22_dynamic_subab_container');
            const customKesimpulanContainer = document.getElementById('custom_kesimpulan_container');

            if (defaultMixing && defaultMixing.parentElement && defaultMixing.parentElement.id !==
                'bab22_dynamic_subab_container') {
                defaultMixing.remove();
            }

            if (bab22Container && typeof state.bab22_container_html === 'string' && state.bab22_container_html.trim() !==
                '') {
                bab22Container.innerHTML = state.bab22_container_html;
            }
            if (customKesimpulanContainer && typeof state.custom_kesimpulan_html === 'string') {
                customKesimpulanContainer.innerHTML = state.custom_kesimpulan_html;
            }

            Object.keys(tableData).forEach(key => delete tableData[key]);
            if (state.table_data && typeof state.table_data === 'object') {
                Object.entries(state.table_data).forEach(([key, value]) => {
                    tableData[key] = value;
                });
            }

            Object.entries(tableData).forEach(([tableId, rows]) => {
                const hiddenInput = document.getElementById('hidden_data_' + tableId);
                if (hiddenInput) {
                    hiddenInput.value = Array.isArray(rows) ? JSON.stringify(rows) : '';
                }

                if (tableId === 'bahan_aktif' && Array.isArray(rows) && rows.length > 0) {
                    const tbody = document.getElementById('table_body_bahan_aktif');
                    if (tbody) {
                        tbody.innerHTML = '';
                        rows.forEach((row, index) => {
                            const tr = document.createElement('tr');
                            tr.className = index % 2 === 0 ? 'bg-white dark:bg-slate-800' :
                                'bg-slate-50 dark:bg-slate-900/50';
                            while (row.length < 4) {
                                row.push('');
                            }
                            row.slice(0, 4).forEach(cellValue => {
                                const td = document.createElement('td');
                                td.className =
                                    'px-4 py-2 text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700';
                                td.textContent = (cellValue || '').trim();
                                tr.appendChild(td);
                            });
                            tbody.appendChild(tr);
                        });
                    }

                    const pasteBox = document.getElementById('paste_instructions_bahan_aktif');
                    const previewBox = document.getElementById('table_preview_bahan_aktif');
                    if (pasteBox && previewBox) {
                        pasteBox.classList.add('hidden');
                        previewBox.classList.remove('hidden');
                    }
                }
            });

            restoreFormValues(state.form_values || {});

            (state.disabled_field_names || []).forEach(name => {
                const selector = `[name="${escapeNameForSelector(name)}"]`;
                document.querySelectorAll(selector).forEach(field => {
                    field.setAttribute('disabled', 'disabled');
                    field.classList.add('opacity-50');
                });
            });

            const disabledSectionIds = new Set(state.kesimpulan_disabled_sections || []);
            document.querySelectorAll('#bab3_container .kesimpulan-section').forEach(section => {
                const sectionId = section.dataset.sectionId || '';
                if (disabledSectionIds.has(sectionId) && !section.classList.contains('section-disabled')) {
                    const numberEl = section.querySelector('.kesimpulan-number');
                    if (numberEl) {
                        toggleKesimpulanSection(numberEl);
                    }
                }
            });

            document.querySelectorAll('#bab22_dynamic_subab_container .bab22-subab').forEach(attachBab22DragEvents);

            const storedFiles = state.stored_files || {};

            // Restore gambar yang sudah di-upload ke server (existing)
            const storedImages = storedFiles.mixing_image_file || {};
            Object.entries(storedImages).forEach(([tableUid, imageMeta]) => {
                const mapInput = document.querySelector(
                    `input[name="bab22_table_subab_key[${escapeNameForSelector(tableUid)}]"]`);
                if (mapInput) {
                    applyStoredImageToTable(mapInput.closest('.mixing-table-item'), imageMeta);
                }
            });

            // Restore gambar base64 yang di-paste (belum pernah di-save ke server)
            const storedBase64Images = storedFiles.mixing_image_base64 || {};
            Object.entries(storedBase64Images).forEach(([tableUid, base64]) => {
                if (!base64) return;
                const mapInput = document.querySelector(
                    `input[name="bab22_table_subab_key[${escapeNameForSelector(tableUid)}]"]`);
                if (!mapInput) return;
                const tableItem = mapInput.closest('.mixing-table-item');
                if (!tableItem) return;

                const previewBox = tableItem.querySelector('.image-preview-box');
                const gridContainer = tableItem.querySelector('.mixing-upload-grid');
                const img = previewBox ? previewBox.querySelector('img') : null;
                const base64Input = tableItem.querySelector(
                    `input[name="mixing_image_base64[${escapeNameForSelector(tableUid)}]"]`);

                if (img && previewBox) {
                    img.src = base64;
                    previewBox.classList.remove('hidden');
                }
                if (gridContainer) gridContainer.classList.add('hidden');
                if (base64Input) base64Input.value = base64;
            });

            const counters = state.counters || {};
            customKesimpulanCount = Number(counters.customKesimpulanCount || customKesimpulanCount || 0);
            bab22CustomSubabCounter = Number(counters.bab22CustomSubabCounter || bab22CustomSubabCounter || 0);
            bab22SubabIdCounter = Number(counters.bab22SubabIdCounter || bab22SubabIdCounter || 1);
            bab22TableUidCounter = Number(counters.bab22TableUidCounter || bab22TableUidCounter || 1);

            renumberBab22Subab();
            renumberKesimpulanSections();
            updateRemoveButtonVisibility();
        }

        function setSaveDraftLoading(isLoading) {
            const btn = document.getElementById('saveDraftBtn');
            const textEl = document.getElementById('saveDraftText');
            if (!btn || !textEl) {
                return;
            }

            if (isLoading) {
                btn.setAttribute('disabled', 'disabled');
                btn.classList.add('opacity-70', 'cursor-wait');
                textEl.textContent = 'Menyimpan...';
            } else {
                btn.removeAttribute('disabled');
                btn.classList.remove('opacity-70', 'cursor-wait');
                textEl.textContent = 'Simpan Draft';
            }
        }

        async function saveDraft() {
            setSaveDraftLoading(true);

            try {
                const form = document.getElementById('sirupTemplateForm');
                const formData = new FormData(form);
                formData.delete('_token');
                formData.append('_token', CSRF_TOKEN);
                const state = collectDraftState();

                const product = (state.form_values.judul_nama_produk || '').trim() || 'Anakonidin';
                const formula = (state.form_values.judul_formula || '').trim();
                const line = (state.form_values.judul_line || '').trim() || '2';
                const bagian = (state.form_values.judul_bagian || state.form_values.tujuan_bagian || '').trim() ||
                    'Produksi Farmasi I Line Soft Capsule Gedung A';
                const formulaSegment = formula ? ` (${formula})` : '';
                const titleFallback =
                    `SUMMARY LAPORAN VALIDASI PROSES PEMBUATAN PRODUK ${product}${formulaSegment} DI LINE ${line} BAGIAN ${bagian.toUpperCase()}`;

                formData.append('draft_id', document.getElementById('draft_id').value || '');
                formData.append('draft_title', titleFallback);
                formData.append('draft_state', JSON.stringify(state));

                const response = await fetch(SAVE_DRAFT_URL, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                    body: formData,
                });

                const result = await response.json();
                if (!response.ok || !result.success) {
                    throw new Error(result.message || 'Gagal menyimpan draft');
                }

                if (result.draft_id) {
                    document.getElementById('draft_id').value = result.draft_id;
                }

                const storedFiles = result.stored_files || {};
                const imageMap = storedFiles.mixing_image_file || {};
                Object.entries(imageMap).forEach(([tableUid, imageMeta]) => {
                    const mapInput = document.querySelector(
                        `input[name="bab22_table_subab_key[${escapeNameForSelector(tableUid)}]"]`);
                    if (mapInput) {
                        applyStoredImageToTable(mapInput.closest('.mixing-table-item'), imageMeta);
                    }
                });

                if (result.redirect_url) {
                    const currentUrl = new URL(window.location.href);
                    const targetUrl = new URL(result.redirect_url, window.location.origin);
                    if (currentUrl.search !== targetUrl.search) {
                        window.history.replaceState({}, '', targetUrl.toString());
                    }
                }

                Swal.fire({
                    title: '<span class="text-slate-800 dark:text-white sm:text-2xl">Berhasil!</span>',
                    html: `<p class="text-slate-600 dark:text-slate-300">${result.message || 'Draft berhasil disimpan.'}</p>`,
                    icon: 'success',
                    iconColor: '#10b981',
                    background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#ffffff',
                    position: 'center',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700',
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInUp animate__faster'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutDown animate__faster'
                    }
                });
            } catch (error) {
                Swal.fire({
                    title: '<span class="text-slate-800 dark:text-white sm:text-xl">Gagal!</span>',
                    html: `<p class="text-slate-600 dark:text-slate-300">${error.message || 'Gagal menyimpan draft.'}</p>`,
                    icon: 'error',
                    iconColor: '#ef4444',
                    background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#ffffff',
                    position: 'center',
                    confirmButtonText: 'Tutup',
                    customClass: {
                        popup: 'rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700',
                        confirmButton: 'px-6 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold transition-colors'
                    },
                    buttonsStyling: false
                });
            } finally {
                setSaveDraftLoading(false);
            }
        }

        // ===========================================
        // BAB 3 KESIMPULAN TOGGLE SYSTEM
        // ===========================================

        let customKesimpulanCount = 0;

        function toggleKesimpulanSection(numberEl) {
            const sectionDiv = numberEl.closest('.kesimpulan-section');
            const isDisabled = sectionDiv.classList.toggle('section-disabled');

            // Visual feedback
            const contentDiv = sectionDiv.querySelector('div');
            if (isDisabled) {
                contentDiv.style.opacity = '0.35';
                contentDiv.style.textDecoration = 'line-through';
                numberEl.classList.add('bg-red-100', 'dark:bg-red-900/30', 'text-red-500', 'line-through');
                // Disable all inputs/textareas in this section
                sectionDiv.querySelectorAll('input, textarea').forEach(el => {
                    el.setAttribute('disabled', 'disabled');
                    el.classList.add('opacity-50');
                });
            } else {
                contentDiv.style.opacity = '1';
                contentDiv.style.textDecoration = 'none';
                numberEl.classList.remove('bg-red-100', 'dark:bg-red-900/30', 'text-red-500', 'line-through');
                // Re-enable all inputs/textareas in this section
                sectionDiv.querySelectorAll('input, textarea').forEach(el => {
                    el.removeAttribute('disabled');
                    el.classList.remove('opacity-50');
                });
            }

            renumberKesimpulanSections();
        }

        function addCustomKesimpulan() {
            customKesimpulanCount++;
            const customId = 'c' + customKesimpulanCount;
            const container = document.getElementById('custom_kesimpulan_container');

            const sectionHtml = `
            <div class="kesimpulan-section" data-section-id="${customId}" data-custom="true">
                <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify transition-opacity duration-200">
                    <div class="flex items-start gap-2">
                        <p class="pl-8 -indent-8 flex-1">
                            <span class="kesimpulan-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleKesimpulanSection(this)" title="Klik untuk disable/enable">3.X</span>
                        </p>
                        <textarea name="kesimpulan_custom_${customKesimpulanCount}" rows="3" class="w-full mt-1 resize-y px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all text-sm" style="vertical-align: top;"></textarea>
                        <button type="button" onclick="removeCustomKesimpulan(this)" class="mt-1 p-1 text-slate-400 hover:text-red-500 transition-colors flex-shrink-0" title="Hapus poin ini">
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </button>
                    </div>
                </div>
            </div>
        `;

            container.insertAdjacentHTML('beforeend', sectionHtml);
            renumberKesimpulanSections();

            // Focus the new textarea
            const newTextarea = container.lastElementChild.querySelector('textarea');
            if (newTextarea) newTextarea.focus();
        }

        function removeCustomKesimpulan(btn) {
            const sectionDiv = btn.closest('.kesimpulan-section');
            sectionDiv.remove();
            renumberKesimpulanSections();
        }

        function renumberKesimpulanSections() {
            const allSections = document.querySelectorAll('.kesimpulan-section');
            let activeIndex = 1;
            const enabledIds = [];

            allSections.forEach(section => {
                const numberEl = section.querySelector('.kesimpulan-number');
                const isDisabled = section.classList.contains('section-disabled');

                if (!isDisabled) {
                    numberEl.textContent = '3.' + activeIndex;
                    enabledIds.push(section.dataset.sectionId);
                    activeIndex++;
                } else {
                    // Keep showing original id for context
                    const originalId = section.dataset.sectionId;
                    numberEl.textContent = '3.' + originalId;
                }
            });

            // Update hidden input
            document.getElementById('kesimpulan_enabled_sections').value = enabledIds.join(',');
        }

        // ===========================================
        // MIXING DYNAMIC TABLES SYSTEM (Excel Upload)
        // ===========================================

        const PARSE_EXCEL_URL = "{{ route('template-summary.parse-excel', [], false) }}";
        const SAVE_DRAFT_URL = "{{ route('template-summary.sirup.draft', [], false) }}";
        const CSRF_TOKEN = "{{ csrf_token() }}";
        const INITIAL_DRAFT_STATE = @json($initialDraftState ?? null);

        async function handleExcelUpload(event, input) {
            const file = input.files[0];
            if (!file) return;

            const tableItem = input.closest('.mixing-table-item');
            const uploadArea = tableItem.querySelector('.upload-area');
            const loadingEl = tableItem.querySelector('.upload-loading');
            const fileNameEl = tableItem.querySelector('.file-name');
            const hiddenInput = tableItem.querySelector('.hidden-table-data');
            const tablePreview = tableItem.querySelector('.table-preview');
            const tbody = tableItem.querySelector('.preview-tbody');

            // Show loading
            loadingEl.classList.remove('hidden');
            fileNameEl.textContent = file.name;
            fileNameEl.classList.remove('hidden');

            try {
                const formData = new FormData();
                formData.append('file', file);
                formData.append('_token', CSRF_TOKEN);

                const response = await fetch(PARSE_EXCEL_URL, {
                    method: 'POST',
                    body: formData,
                });

                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.message || 'Upload gagal');
                }

                // Store data as JSON
                hiddenInput.value = JSON.stringify(result.data);

                // Render table preview
                renderTablePreview(tableItem, result.data);

                // Show preview, hide upload area
                uploadArea.classList.add('hidden');
                tablePreview.classList.remove('hidden');

            } catch (error) {
                alert('Error: ' + error.message);
                input.value = ''; // Reset file input
            } finally {
                loadingEl.classList.add('hidden');
            }

            updateRemoveButtonVisibility();
        }

        function renderTablePreview(tableItem, data) {
            const tbody = tableItem.querySelector('.preview-tbody');
            tbody.innerHTML = '';

            data.forEach((rowData, rowIndex) => {
                const tr = document.createElement('tr');
                tr.className = rowIndex % 2 === 0 ? 'bg-white dark:bg-slate-800' :
                    'bg-slate-50 dark:bg-slate-900/50';

                rowData.forEach(cellData => {
                    // Skip hidden cells (part of merged cell)
                    if (cellData.isHidden) return;

                    const isHeader = rowIndex === 0;
                    const cell = document.createElement(isHeader ? 'th' : 'td');
                    cell.className = isHeader ?
                        'px-4 py-2 text-left font-semibold text-slate-700 dark:text-slate-300 border border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-700' :
                        'px-4 py-2 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700';
                    cell.textContent = cellData.value || '';

                    if (cellData.colspan > 1) cell.colSpan = cellData.colspan;
                    if (cellData.rowspan > 1) cell.rowSpan = cellData.rowspan;

                    tr.appendChild(cell);
                });

                tbody.appendChild(tr);
            });
        }

        function updateFileName(input) {
            const fileNameDisplay = input.parentElement.querySelector('.file-name-display');
            if (input.files && input.files[0]) {
                fileNameDisplay.textContent = input.files[0].name;
                fileNameDisplay.classList.remove('text-slate-600', 'dark:text-slate-400');
                fileNameDisplay.classList.add('text-indigo-600', 'dark:text-indigo-400');
            } else {
                fileNameDisplay.textContent = 'Belum ada file dipilih';
                fileNameDisplay.classList.add('text-slate-600', 'dark:text-slate-400');
                fileNameDisplay.classList.remove('text-indigo-600', 'dark:text-indigo-400');
            }
        }

        let bab22CustomSubabCounter = 0;
        let bab22SubabIdCounter = 1;
        let bab22TableUidCounter = 1;
        let draggedBab22Subab = null;

        function getMixingTableTemplate(subabKey) {
            bab22TableUidCounter++;
            const tableUid = `table_${bab22TableUidCounter}`;
            return `
            <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative" data-table-uid="${tableUid}" onpaste="handleMixingPaste(event, this)">
                <div class="absolute top-1 right-1 z-20 remove-table-btn">
                    <button type="button" onclick="toggleTableMenu(this)"
                        class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors"
                        title="Opsi">
                        <span class="material-symbols-outlined text-[20px] block">more_vert</span>
                    </button>
                    <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30">
                        <button type="button" onclick="removeMixingTable(this)"
                            class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                            Hapus Tabel
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    <div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-8 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)">
                        <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-2">content_paste</span>
                        <p class="text-base font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Copy data dari Excel atau Screenshot lalu paste di bawah (Ctrl+V)</p>
                        <div class="flex justify-center mb-4">
                            <button type="button" onclick="triggerClipboardPaste(this)" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px]">content_paste_go</span>
                                Tempel dari Clipboard
                            </button>
                        </div>
                        <textarea rows="4" class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" placeholder="Paste screenshot / tabel Excel di sini, atau ketik catatan... (Ctrl+V)" onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                    </div>
                    <input type="file" name="mixing_image_file[${tableUid}]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                    <input type="file" name="mixing_excel_file[${tableUid}]" accept=".xlsx,.xls,.ods" class="hidden" onchange="updateFileName(this)">
                    <div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1">
                        <img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm">
                        <button type="button" onclick="removeImage(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Gambar">
                            <span class="material-symbols-outlined text-[14px] block">close</span>
                        </button>
                    </div>
                    <div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3">
                        <div class="overflow-auto max-h-[420px]">
                            <table class="w-full text-sm border-collapse pasted-table-preview-table"></table>
                        </div>
                        <button type="button" onclick="removePastedTable(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Tabel Paste">
                            <span class="material-symbols-outlined text-[14px] block">close</span>
                        </button>
                    </div>
                </div>
                <input type="hidden" name="bab22_table_subab_key[${tableUid}]" value="${subabKey}">
                <input type="hidden" name="existing_mixing_image_file[${tableUid}]" value="">
                <input type="hidden" name="mixing_pasted_table_json[${tableUid}]" value="">
                <input type="hidden" name="mixing_image_base64[${tableUid}]" value="">
            </div>`;
        }

        function renderPastedTablePreview(tableItem, rows) {
            const previewBox = tableItem.querySelector('.pasted-table-preview-box');
            const previewTable = tableItem.querySelector('.pasted-table-preview-table');
            const pasteInstructions = tableItem.querySelector('.paste-instructions');

            if (!previewBox || !previewTable || !Array.isArray(rows) || rows.length === 0) return;

            previewTable.innerHTML = '';
            rows.forEach((row, rowIndex) => {
                const tr = document.createElement('tr');
                (row || []).forEach(cellValue => {
                    const cell = document.createElement(rowIndex === 0 ? 'th' : 'td');
                    cell.className = rowIndex === 0 ?
                        'px-3 py-2 text-left font-semibold text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-700' :
                        'px-3 py-2 text-slate-700 dark:text-slate-300 border border-slate-300 dark:border-slate-700';
                    cell.textContent = cellValue || '';
                    tr.appendChild(cell);
                });
                previewTable.appendChild(tr);
            });

            previewBox.classList.remove('hidden');
            if (pasteInstructions) pasteInstructions.classList.add('hidden');
        }

        function removePastedTable(button) {
            const tableItem = button.closest('.mixing-table-item');
            if (!tableItem) return;

            const previewBox = tableItem.querySelector('.pasted-table-preview-box');
            const previewTable = tableItem.querySelector('.pasted-table-preview-table');
            const pasteInstructions = tableItem.querySelector('.paste-instructions');
            const tableUid = getTableUidFromItem(tableItem);
            const hiddenInput = tableUid ? tableItem.querySelector(
                `input[name="mixing_pasted_table_json[${escapeNameForSelector(tableUid)}]"]`) : null;

            if (previewTable) previewTable.innerHTML = '';
            if (hiddenInput) hiddenInput.value = '';
            if (previewBox) previewBox.classList.add('hidden');
            if (pasteInstructions) pasteInstructions.classList.remove('hidden');
        }

        function handleMixingPaste(event, tableItem) {
            if (!tableItem) return;

            const clipboardData = event.clipboardData || window.clipboardData;
            if (!clipboardData) return;

            const activeTag = document.activeElement?.tagName?.toLowerCase();
            if (activeTag === 'input' || activeTag === 'textarea') return;

            const items = clipboardData.items || [];
            for (const item of items) {
                if (item.type && item.type.startsWith('image/')) {
                    const imageFile = item.getAsFile();
                    if (!imageFile) continue;

                    event.preventDefault();
                    const imageInput = tableItem.querySelector('input[type="file"][accept*="image"]');
                    const transfer = new DataTransfer();
                    transfer.items.add(imageFile);
                    imageInput.files = transfer.files;
                    previewImage(imageInput);
                    return;
                }
            }

            const pastedText = clipboardData.getData('text/plain');
            if (!pastedText || !pastedText.includes('\t')) return;

            event.preventDefault();
            const rows = pastedText
                .replace(/\r/g, '')
                .split('\n')
                .map(row => row.split('\t').map(cell => cell.trim()))
                .filter(row => row.some(cell => cell !== ''));

            if (!rows.length) return;

            const tableUid = getTableUidFromItem(tableItem);
            const hiddenInput = tableUid ? tableItem.querySelector(
                `input[name="mixing_pasted_table_json[${escapeNameForSelector(tableUid)}]"]`) : null;

            if (hiddenInput) hiddenInput.value = JSON.stringify(rows);
            renderPastedTablePreview(tableItem, rows);
        }

        function previewImage(input) {
            const tableItem = input.closest('.mixing-table-item');
            const pasteInstructions = tableItem.querySelector('.paste-instructions');
            const previewBox = tableItem.querySelector('.image-preview-box');
            const img = previewBox.querySelector('img');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const base64 = e.target.result;
                    img.src = base64;
                    if (pasteInstructions) pasteInstructions.classList.add('hidden');
                    previewBox.classList.remove('hidden');

                    // Simpan base64 ke hidden input agar ikut ter-submit saat export
                    const tableUid = getTableUidFromItem(tableItem);
                    if (tableUid) {
                        const base64Input = tableItem.querySelector(
                            `input[name="mixing_image_base64[${escapeNameForSelector(tableUid)}]"]`);
                        if (base64Input) base64Input.value = base64;
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeImage(btn) {
            const previewBox = btn.closest('.image-preview-box');
            const tableItem = previewBox.closest('.mixing-table-item');
            const pasteInstructions = tableItem.querySelector('.paste-instructions');
            const imageInput = tableItem.querySelector('input[type="file"][accept*="image"]');
            const imageEl = previewBox.querySelector('img');
            const tableUid = getTableUidFromItem(tableItem);
            const existingImageInput = tableUid ?
                tableItem.querySelector(`input[name="existing_mixing_image_file[${tableUid}]"]`) :
                null;
            const base64Input = tableUid ?
                tableItem.querySelector(`input[name="mixing_image_base64[${escapeNameForSelector(tableUid)}]"]`) :
                null;

            if (imageEl && imageEl.dataset.blobUrl) {
                URL.revokeObjectURL(imageEl.dataset.blobUrl);
                delete imageEl.dataset.blobUrl;
            }

            if (imageInput) imageInput.value = '';
            if (existingImageInput) existingImageInput.value = '';
            if (base64Input) base64Input.value = '';
            if (imageEl) imageEl.src = '';

            previewBox.classList.add('hidden');
            if (pasteInstructions) pasteInstructions.classList.remove('hidden');
        }

        function addMixingTableToSubab(button) {
            const subab = button.closest('.bab22-subab');
            const container = subab.querySelector('.mixing-tables-container');
            const subabKey = subab.dataset.subabKey || 'mixing';
            container.insertAdjacentHTML('beforeend', getMixingTableTemplate(subabKey));
            updateRemoveButtonVisibility();
        }

        function removeMixingTable(button) {
            const tableItem = button.closest('.mixing-table-item');
            if (tableItem) {
                tableItem.remove();
            }
            updateRemoveButtonVisibility();
        }

        function toggleTableMenu(button) {
            const menu = button.nextElementSibling;
            const isHidden = menu.classList.contains('hidden');

            document.querySelectorAll('.table-dropdown-menu').forEach(m => {
                m.classList.add('hidden');
            });

            if (isHidden) {
                menu.classList.remove('hidden');
            }
        }

        function updateRemoveButtonVisibility() {
            const tables = document.querySelectorAll('.mixing-table-item');
            tables.forEach(table => {
                const removeBtn = table.querySelector('.remove-table-btn');
                if (removeBtn) removeBtn.classList.remove('hidden');
            });
        }

        function getDefaultClosingTemplate(stageText, fieldName, specText) {
            return `
                <div class="mt-6 text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                    <p>
                        Atribut yang diuji pada tahap ${stageText} sudah memberikan hasil yang
                        <input type="text" name="${fieldName}" class="template-input w-32" placeholder="memenuhi">
                        persyaratan menurut ${specText} yang berlaku
                        <input type="text" name="${fieldName}_catatan" class="template-input w-64" placeholder="">
                        .
                    </p>
                </div>`;
        }

        function toggleBab22Subab(numberEl) {
            const subab = numberEl.closest('.bab22-subab');
            const isDisabled = subab.classList.toggle('subab-disabled');
            const titleEl = subab.querySelector('.bab22-title');

            if (isDisabled) {
                subab.style.opacity = '0.35';
                if (titleEl) titleEl.style.textDecoration = 'line-through';
                numberEl.classList.add('bg-red-100', 'dark:bg-red-900/30', 'text-red-500', 'line-through');
                subab.querySelectorAll('input, textarea, button, select').forEach(el => {
                    el.setAttribute('disabled', 'disabled');
                    el.classList.add('opacity-50');
                });
            } else {
                subab.style.opacity = '1';
                if (titleEl) titleEl.style.textDecoration = 'none';
                numberEl.classList.remove('bg-red-100', 'dark:bg-red-900/30', 'text-red-500', 'line-through');
                subab.querySelectorAll('input, textarea, button, select').forEach(el => {
                    el.removeAttribute('disabled');
                    el.classList.remove('opacity-50');
                });
            }

            renumberBab22Subab();
        }

        function createBab22SubabElement(config) {
            const subab = document.createElement('div');
            subab.className = 'bab22-subab';
            subab.setAttribute('draggable', 'true');
            subab.dataset.subabType = config.type;
            subab.dataset.subabKey = config.key;
            bab22SubabIdCounter++;
            subab.dataset.subabId = String(bab22SubabIdCounter);

            const titleHtml = config.type === 'custom' ?
                `<input type="text" name="${config.key}_title" class="bab22-title-input template-input w-72 text-left" placeholder="Nama subab/proses">` :
                `<span class="bab22-title">${config.title}</span>`;

            const closingHtml = config.type === 'custom' ?
                `<div class="mt-6">
                    <textarea name="${config.key}_notes" rows="4" class="w-full resize-y px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all text-sm" placeholder="Isi kalimat atau hasil evaluasi akhir subab ini..."></textarea>
                </div>` :
                getDefaultClosingTemplate(config.stageText, config.resultField, config.specText);

            const removeSubabButton = config.type === 'custom' ?
                `<button type="button" onclick="removeBab22Subab(this)" class="flex items-center text-slate-400 hover:text-red-600 transition-colors" title="Hapus subab">
                    <span class="material-symbols-outlined text-[18px]">delete</span>
                </button>` :
                '';

            subab.innerHTML = `
                <h4 class="font-medium text-slate-700 dark:text-slate-300 mb-4 flex items-center justify-between">
                    <span>
                        <span class="bab22-number bab22-toggle-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleBab22Subab(this)" title="Klik untuk disable/enable">2.2.X</span>
                        ${titleHtml}
                    </span>
                    <span class="flex items-center gap-2">
                        ${removeSubabButton}
                        <span class="material-symbols-outlined text-[18px] text-slate-400 cursor-grab select-none">drag_indicator</span>
                    </span>
                </h4>
                <div class="mixing-tables-container flex flex-col gap-4">
                    ${getMixingTableTemplate(config.key)}
                </div>
                <button type="button" onclick="addMixingTableToSubab(this)"
                    class="mt-4 w-full py-3 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg text-slate-500 dark:text-slate-400 hover:border-red-400 hover:text-red-600 transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    <span class="text-sm font-medium">Tambah Tabel</span>
                </button>
                ${closingHtml}
            `;

            attachBab22DragEvents(subab);
            return subab;
        }

        function addBab22DefaultSubab(title, key, stageText, resultField, specText) {
            const container = document.getElementById('bab22_dynamic_subab_container');
            const subab = createBab22SubabElement({
                type: 'default',
                title,
                key,
                stageText,
                resultField,
                specText
            });
            container.appendChild(subab);
            renumberBab22Subab();
        }

        function addBab22CustomSubab() {
            bab22CustomSubabCounter++;
            const key = `bab22_custom_${bab22CustomSubabCounter}`;
            const container = document.getElementById('bab22_dynamic_subab_container');
            const subab = createBab22SubabElement({
                type: 'custom',
                key
            });
            container.appendChild(subab);
            renumberBab22Subab();
            const titleInput = subab.querySelector('.bab22-title-input');
            if (titleInput) titleInput.focus();
        }

        function removeBab22Subab(button) {
            const subab = button.closest('.bab22-subab');
            if (subab) {
                subab.remove();
                renumberBab22Subab();
            }
        }

        function attachBab22DragEvents(subab) {
            subab.addEventListener('dragstart', function() {
                draggedBab22Subab = this;
                this.classList.add('opacity-60');
            });
            subab.addEventListener('dragend', function() {
                this.classList.remove('opacity-60');
                draggedBab22Subab = null;
            });
        }

        function initBab22DragDrop() {
            const container = document.getElementById('bab22_dynamic_subab_container');
            if (!container) return;

            container.addEventListener('dragover', function(event) {
                event.preventDefault();
                const afterElement = getDragAfterElement(container, event.clientY);
                if (!draggedBab22Subab) return;
                if (!afterElement) {
                    container.appendChild(draggedBab22Subab);
                } else {
                    container.insertBefore(draggedBab22Subab, afterElement);
                }
            });

            container.addEventListener('drop', function(event) {
                event.preventDefault();
                renumberBab22Subab();
            });
        }

        function getDragAfterElement(container, y) {
            const draggableElements = [...container.querySelectorAll('.bab22-subab:not(.opacity-60)')];
            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                if (offset < 0 && offset > closest.offset) {
                    return {
                        offset,
                        element: child
                    };
                }
                return closest;
            }, {
                offset: Number.NEGATIVE_INFINITY,
                element: null
            }).element;
        }

        function renumberBab22Subab() {
            const subabs = document.querySelectorAll('#bab22_dynamic_subab_container .bab22-subab');
            let activeIndex = 1;
            const enabledSubabKeys = [];

            subabs.forEach((subab, index) => {
                const numberEl = subab.querySelector('.bab22-number');
                if (!numberEl) {
                    return;
                }

                const isDisabled = subab.classList.contains('subab-disabled');
                if (!isDisabled) {
                    numberEl.textContent = `2.2.${activeIndex}`;
                    activeIndex++;
                    enabledSubabKeys.push(subab.dataset.subabKey || `subab_${index + 1}`);
                } else {
                    const originalId = subab.dataset.subabId || String(index + 1);
                    numberEl.textContent = `2.2.${originalId}`;
                }
            });

            const enabledInput = document.getElementById('bab22_enabled_subab_keys');
            if (enabledInput) {
                enabledInput.value = enabledSubabKeys.join(',');
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.remove-table-btn')) {
                document.querySelectorAll('.table-dropdown-menu').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });

        // Handle sidebar collapse for fixed footer
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar-container');
            const footer = document.getElementById('actionFooter');

            if (sidebar && footer) {
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.attributeName === 'class') {
                            if (sidebar.classList.contains('sidebar-collapsed')) {
                                footer.style.left = '4.5rem';
                            } else {
                                footer.style.left = '14.5rem';
                            }
                        }
                    });
                });

                observer.observe(sidebar, {
                    attributes: true
                });

                // Initial check
                if (sidebar.classList.contains('sidebar-collapsed')) {
                    footer.style.left = '4.5rem';
                }
            }

            const bab22Container = document.getElementById('bab22_dynamic_subab_container');
            const firstBab22Subab = document.getElementById('bab22_subab_mixing');
            if (INITIAL_DRAFT_STATE) {
                restoreDraftState(INITIAL_DRAFT_STATE);
            } else {
                if (bab22Container && firstBab22Subab) {
                    bab22Container.prepend(firstBab22Subab);
                    attachBab22DragEvents(firstBab22Subab);
                }

                addBab22DefaultSubab(
                    'Awal filling-capping',
                    'filling_awal',
                    'awal filling-capping',
                    'filling_awal_hasil',
                    'Spesifikasi Produk'
                );
                addBab22DefaultSubab(
                    'Filling-capping',
                    'filling_capping',
                    'filling-capping',
                    'filling_capping_hasil',
                    'Spesifikasi Produk dan Spesifikasi Kemasan'
                );
            }
            initBab22DragDrop();
            renumberBab22Subab();

            // Input Synchronization Logic
            const syncInputs = document.querySelectorAll('.sync-input');

            // Group inputs by sync key
            const syncGroups = {};
            syncInputs.forEach(input => {
                const key = input.dataset.sync;
                if (!syncGroups[key]) {
                    syncGroups[key] = [];
                }
                syncGroups[key].push(input);
            });

            // Add event listeners
            Object.keys(syncGroups).forEach(key => {
                const group = syncGroups[key];

                group.forEach(input => {
                    input.addEventListener('input', function() {
                        const value = this.value;
                        group.forEach(otherInput => {
                            if (otherInput !== this) {
                                otherInput.value = value;
                            }
                        });
                    });
                });
            });

            // ===========================================
            // LINKED FIELDS SYNC SYSTEM
            // ===========================================

            /**
             * Sync all fields with the same data-sync value
             * Works for both inputs (sync-input) and displays (sync-display)
             */
            function syncLinkedFields(syncKey, newValue) {
                // Update all inputs with same sync key
                const syncInputs = document.querySelectorAll(`.sync-input[data-sync="${syncKey}"]`);
                syncInputs.forEach(input => {
                    if (input.value !== newValue) {
                        input.value = newValue;
                    }
                });

                // Update all display spans with same sync key
                const syncDisplays = document.querySelectorAll(`.sync-display[data-sync="${syncKey}"]`);
                syncDisplays.forEach(display => {
                    const placeholder = display.getAttribute('data-placeholder') || `[${syncKey}]`;
                    display.textContent = newValue.trim() || placeholder;

                    // Visual styling: italicize placeholder, normal for actual value
                    if (newValue.trim()) {
                        display.classList.remove('italic', 'text-slate-400');
                        display.classList.add('text-slate-900', 'dark:text-white');
                    } else {
                        display.classList.add('italic', 'text-slate-400');
                        display.classList.remove('text-slate-900', 'dark:text-white');
                    }
                });
            }

            // Attach event listeners to all sync inputs
            const allSyncInputs = document.querySelectorAll('.sync-input[data-sync]');
            allSyncInputs.forEach(input => {
                // Listen to both 'input' (real-time) and 'change' events
                input.addEventListener('input', function() {
                    const syncKey = this.getAttribute('data-sync');
                    syncLinkedFields(syncKey, this.value);
                });

                input.addEventListener('change', function() {
                    const syncKey = this.getAttribute('data-sync');
                    syncLinkedFields(syncKey, this.value);
                });
            });

            // Initialize displays on page load (in case of pre-filled values)
            const uniqueSyncKeys = [...new Set(
                Array.from(allSyncInputs).map(input => input.getAttribute('data-sync'))
            )];

            uniqueSyncKeys.forEach(syncKey => {
                const firstInput = document.querySelector(`.sync-input[data-sync="${syncKey}"]`);
                if (firstInput && firstInput.value) {
                    syncLinkedFields(syncKey, firstInput.value);
                }
            });

            // ===========================================
            // FORM SUBMIT: Pastikan semua base64 & tabel
            // ter-serialize ke hidden input sebelum export
            // ===========================================
            const sirupForm = document.getElementById('sirupTemplateForm');
            if (sirupForm) {
                sirupForm.addEventListener('submit', function() {
                    showExportModal();
                    // Pastikan setiap mixing-table-item sudah punya base64 di hidden input
                    document.querySelectorAll('.mixing-table-item').forEach(tableItem => {
                        const tableUid = getTableUidFromItem(tableItem);
                        if (!tableUid) return;

                        // Sync base64 dari img.src ke hidden input (jaga-jaga jika belum ter-set)
                        const previewBox = tableItem.querySelector('.image-preview-box');
                        const img = previewBox ? previewBox.querySelector('img') : null;
                        const base64Input = tableItem.querySelector(
                            `input[name="mixing_image_base64[${escapeNameForSelector(tableUid)}]"]`);

                        if (img && img.src && img.src.startsWith('data:image') && base64Input && !base64Input.value) {
                            base64Input.value = img.src;
                        }
                    });
                });
            }

            // Restore pasted table previews dari hidden input (setelah export/page load)
            document.querySelectorAll('.mixing-table-item').forEach(tableItem => {
                const tableUid = getTableUidFromItem(tableItem);
                if (!tableUid) return;

                // Restore pasted table JSON preview
                const pastedTableInput = tableItem.querySelector(
                    `input[name="mixing_pasted_table_json[${escapeNameForSelector(tableUid)}]"]`);
                if (pastedTableInput && pastedTableInput.value) {
                    try {
                        const rows = JSON.parse(pastedTableInput.value);
                        if (Array.isArray(rows) && rows.length) renderPastedTablePreview(tableItem, rows);
                    } catch (e) { /* abaikan parse error */ }
                }

                // Restore base64 image preview (gambar yang di-paste, belum di-save ke server)
                const base64Input = tableItem.querySelector(
                    `input[name="mixing_image_base64[${escapeNameForSelector(tableUid)}]"]`);
                if (base64Input && base64Input.value && base64Input.value.startsWith('data:image')) {
                    const previewBox = tableItem.querySelector('.image-preview-box');
                    const gridContainer = tableItem.querySelector('.mixing-upload-grid');
                    const img = previewBox ? previewBox.querySelector('img') : null;
                    if (img && previewBox) {
                        img.src = base64Input.value;
                        previewBox.classList.remove('hidden');
                    }
                    if (gridContainer) gridContainer.classList.add('hidden');
                }
            });
        });
        function showExportModal() {
            // Generate a unique token and inject it into the form
            const token = 'exp_' + Date.now();
            let tokenInput = document.getElementById('export_token_input');
            if (!tokenInput) {
                tokenInput = document.createElement('input');
                tokenInput.type = 'hidden';
                tokenInput.name = 'export_token';
                tokenInput.id = 'export_token_input';
                document.getElementById('sirupTemplateForm').appendChild(tokenInput);
            }
            tokenInput.value = token;

            // Clear any old cookie
            document.cookie = 'export_done=; Max-Age=0; path=/';

            document.getElementById('exportLoadingModal').classList.remove('hidden');

            // Poll for the cookie the server sets when download is ready
            const poll = setInterval(function () {
                if (document.cookie.split(';').some(c => c.trim().startsWith('export_done=' + token))) {
                    clearInterval(poll);
                    document.cookie = 'export_done=; Max-Age=0; path=/';
                    document.getElementById('exportLoadingModal').classList.add('hidden');
                }
            }, 500);
        }
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