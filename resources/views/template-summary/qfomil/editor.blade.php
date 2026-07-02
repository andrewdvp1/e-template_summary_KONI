@extends('layouts.app')

@section('content')
    <form action="{{ route('template-summary.qfomil.export') }}" method="POST" id="qfomilTemplateForm"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="draft_id" id="draft_id" value="{{ $draft->id ?? '' }}">
        <input type="hidden" name="draft_line" id="draft_line" value="{{ $draftLine ?? ''  }}">

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
                                data-sync="nama_produk" data-sync-master="1" placeholder="Q-FOMIL">
                           
                        </p>
                        <p class="font-bold text-center text-base mb-4">
                             DI LINI
                            <input type="text" name="judul_line" class="template-input sync-input w-54" data-sync="line"
                                placeholder="OBAT DALAM" value="Obat Dalam">
                            BAGIAN
                            <input type="text" name="judul_bagian" class="template-input sync-input w-128 uppercase"
                                data-sync="bagian" value="Production NATPRO & EXTRACTION BANGUNAN IOT NATPRO"
                                placeholder="PRODUCTION NATPRO & EXTRACTION BANGUNAN IOT NATPRO">
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
                class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden bab-section" id="bab1_card">
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <h2 class="font-bold text-slate-900 dark:text-white">
                        <span class="bab-section-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleBabSection('bab1_card')" title="Klik untuk disable/enable">1.</span>
                        PENDAHULUAN
                    </h2>
                    <span class="text-xs text-slate-400 dark:text-slate-500">Klik nomor untuk enable/disable</span>
                </div>
                <input type="hidden" name="bab1_enabled_sections" id="bab1_enabled_sections" value="1,2">
                <div class="p-6 flex flex-col gap-6">
                    {{-- 1.1 Tujuan --}}
                    <div class="bab1-section" data-section-id="1">
                        <h3 class="font-semibold text-slate-800 dark:text-slate-200 mb-3">
                            <span class="bab1-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                onclick="toggleBab1Section(this)" title="Klik untuk disable/enable">1.1</span>
                            Tujuan
                        </h3>
                        
                            <p>
                               Summary validasi ini bertujuan mendokumentasikan
                                hasil studi validasi/pembuktian terhadap kualitas dan reprodusibilitas proses pengolahan produk
                                <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                    data-sync="nama_produk" placeholder="Q-Fomil">
                                di Lini
                                <input type="text" name="tujuan_line" class="template-input sync-input w-54"
                                    data-sync="line" value="Obat Dalam" placeholder="Obat Dalam">
                                Bagian
                                <input type="text" name="tujuan_bagian" class="template-input sync-input w-128"
                                    data-sync="bagian" value="Production Natpro & Extraction"
                                    placeholder="Production Natpro & Extraction">
                                dalam menghasilkan produk yang memenuhi persyaratan mutu yang tercantum dalam Spesifikasi Produk dan Kemasan 
                                <input type="text" name="tujuan_nama_produk_2" class="template-input sync-input w-55"
                                    data-sync="nama_produk" placeholder="Q-Fomil">
                                <input type="text" name="varian_produk" class="template-input sync-input w-48"
                                    data-sync="varian" placeholder="kemasan botol">
                                yang berlaku.
                            </p>
                        
                    {{-- 1.2 Batch Validasi --}}
                    <div class="bab1-section" data-section-id="2">
                        <h3 class="font-semibold text-slate-800 dark:text-slate-200 mb-3">
                            <span class="bab1-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                onclick="toggleBab1Section(this)" title="Klik untuk disable/enable">1.2</span>
                            Batch Validasi
                        </h3>
                        <div class="bab1-section-content transition-opacity duration-200">
                        <div
                            class="text-base leading-relaxed text-slate-700 dark:text-slate-300 template-text text-justify mb-4">
                            <p>
                                Studi validasi dilakukan terhadap
                                <input type="text" name="batch_jumlah" class="template-input w-12"
                                    placeholder="satu">
                                batch produksi yaitu batch
                                <input type="text" name="batch_besaran" class="template-input w-56"
                                    placeholder="DEC25A01"> 
                                dengan besaran batch
                                <input type="text" name="batch_besaran" class="template-input w-20"
                                    placeholder="21 kg">   
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
                        </div>{{-- end bab1-section-content --}}
                    </div>{{-- end bab1-section 1.2 --}}
                </div>
            </div>

                       {{-- BAB 2: HASIL DAN EVALUASI PROSES --}}
            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden bab-section" id="bab2_card">
                <div
                    class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <h2 class="font-bold text-slate-900 dark:text-white">
                        <span class="bab-section-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleBabSection('bab2_card')" title="Klik untuk disable/enable">2.</span>
                        HASIL DAN EVALUASI PROSES
                    </h2>
                    <span class="text-xs text-slate-400 dark:text-slate-500">Klik nomor untuk enable/disable</span>
                </div>
                <div class="p-6 flex flex-col gap-6">
                    <input type="hidden" name="bab2_enabled_sections" id="bab2_enabled_sections" value="1,2,3">

                    {{-- 2.1 --}}
                    <div class="bab2-section" data-section-id="1">
                        <div class="bab2-section-content text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify transition-opacity duration-200">
                            <p class="pl-8 -indent-8">
                                <span class="bab2-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                    onclick="toggleBab2Section(this)" title="Klik untuk disable/enable">2.1.</span> 
                            Seluruh tahapan pengolahan dan pengemasan primer 
                             <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                    data-sync="nama_produk" placeholder="Q-Fomil">
                            batch 
                            <input type="text" name="batch_besaran" class="template-input w-56"
                                    placeholder="DEC25A01"> 
                            yaitu
                            <input type="text" name="rangkuman_metode" class="template-input sync-input w-full"
                                    data-sync="rangkuman"
                                    value="penimbangan bahan baku, pencampuran, pencetakan, penyalutan, dan pengemasan primer (stripping)"
                                    placeholder="penimbangan bahan baku, pencampuran, pencetakan, penyalutan, dan pengemasan primer (stripping)">
                            telah dilakukan sesuai MBR Pengolahan
                            <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                    data-sync="nama_produk" placeholder="Q-Fomil">
                            , no. dokumen
                                <input type="text" name="pencampuran_no_dokumen" class="template-input sync-input w-53"
                                    data-sync="no_dokumen" placeholder="CE-00467-01-NL">
                                , tanggal
                                <input type="text" name="pencampuran_tanggal_dokumen" class="template-input sync-input w-53"
                                    data-sync="tanggal_dokumen" placeholder="07-11-2025">
                            telah dilakukan sesuai prosedur pengolahan dan pengemasan yang berlaku.</p>
                        </div>
                    </div>

                     {{-- 2.2 Pelaksanaan Proses Produksi --}}
                    <div class="bab2-section" data-section-id="2">
                        <h3 class="font-semibold text-slate-800 dark:text-slate-200 mb-3">
                            <span class="bab2-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                onclick="toggleBab2Section(this)" title="Klik untuk disable/enable">2.2</span>
                            Pelaksanaan Proses Produksi
                        </h3>
                        <div class="bab2-section-content transition-opacity duration-200">
                        <input type="hidden" name="bab22_enabled_subab_keys" id="bab22_enabled_subab_keys"
                            value="">

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

                    {{-- 2.3 Hasil Pemeriksaan Sampel --}}
                    <div class="bab2-section mt-6" data-section-id="3">
                        <h3 class="font-semibold text-slate-800 dark:text-slate-200 mb-4">
                            <span class="bab2-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                onclick="toggleBab2Section(this)" title="Klik untuk disable/enable">2.3</span>
                           Hasil pemeriksaan sampel pada masing-masing tahapan adalah sebagai berikut :
                        </h3>
                        <div class="bab2-section-content transition-opacity duration-200">

                            {{-- 2.3.1 Tahap Pencampuran --}}
                            <div class="ml-4 mb-6 p-4 bg-slate-50 dark:bg-slate-900/30 rounded-lg border border-slate-200 dark:border-slate-700">
                                <h4 class="font-semibold text-slate-700 dark:text-slate-300 mb-4">2.3.1 Tahap Pencampuran Akhir</h4>

                                {{-- 2.3.1.1 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.1.1</span>
                                        Proses pencampuran 
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                        data-sync="nama_produk" placeholder="Q-Fomil">
                                        batch
                                        <input type="text" name="batch_name" class="template-input sync-input w-52" 
                                        data-sync="batch" placeholder="DEC25A01">
                                        dilakukan dengan mesin
                                        <input type="text" name="tujuan_mesin" class="template-input sync-input w-64" 
                                        data-sync="mesin" value="Double Cone Mixer DC 40" placeholder="Double Cone Mixer DC 40.">.
                                    </p>
                                </div>

                                {{-- 2.3.1.2 --}}
                                <div class="ml-4 mb-4">
                                    <p 
                                    class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.1.2</span>
                                        Berdasarkan acuan Spesifikasi Produk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                        data-sync="nama_produk" placeholder="Q-Fomil">,
                                        no. dokumen
                                        <input type="text" name="pencampuran_no_dokumen" class="template-input w-44" placeholder="EA-F03-3-00261-00">,
                                        tanggal
                                        <input type="text" name="pencampuran_tanggal_dokumen" class="template-input w-28" placeholder="19-01-2024">,
                                        produk antara hasil lubrikasi memiliki spesifikasi sebagai berikut:

                                    </p>
                                    <div class="mixing-tables-container flex flex-col gap-3 ml-4">
                                <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative mt-3"
                                    data-table-uid="tbl_pencampuran_212" onpaste="handleMixingPaste(event, this)">
                                    <div class="absolute top-1 right-1 z-20 remove-table-btn">
                                        <button type="button" onclick="toggleTableMenu(this)" class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors" title="Opsi"><span class="material-symbols-outlined text-[20px] block">more_vert</span></button>
                                        <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30"><button type="button" onclick="removeMixingTable(this)" class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span>Hapus Tabel</button></div>
                                    </div>
                                    <div class="p-4">
                                        <div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-4 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)">
                                            <span class="material-symbols-outlined text-3xl text-slate-300 dark:text-slate-600 mb-1">content_paste</span>
                                            <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p>
                                            <div class="flex justify-center mb-2"><button type="button" onclick="triggerClipboardPaste(this)" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">content_paste_go</span>Tempel dari Clipboard</button></div>
                                            <textarea rows="3" class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)" onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                                        </div>
                                        <input type="file" name="mixing_image_file[tbl_pencampuran_212]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                                        <div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1"><img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm"><button type="button" onclick="removeImage(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Gambar"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                        <div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3"><div class="overflow-auto max-h-[420px]"><table class="w-full text-sm border-collapse pasted-table-preview-table"></table></div><button type="button" onclick="removePastedTable(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Tabel Paste"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                    </div>
                                    <input type="hidden" name="bab22_table_subab_key[tbl_pencampuran_212]" value="pencampuran_212">
                                    <input type="hidden" name="existing_mixing_image_file[tbl_pencampuran_212]" value="">
                                    <input type="hidden" name="mixing_pasted_table_json[tbl_pencampuran_212]" value="">
                                    <input type="hidden" name="mixing_image_base64[tbl_pencampuran_212]" value="">
                                </div>
                                    </div>
                                </div>

                                {{-- 2.3.1.3 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.1.3</span>
                                        Pada tahap lubrikasi dilakukan sampling sebanyak
                                        <input type="text" name="pencampuran_sampling_titik" class="template-input w-12" placeholder="7">
                                        titik lokasi
                                        <textarea 
                                        name="pencampuran_sampling_waktu_213" rows="3" class="template-input w-full resize-y text-base font-bold" 
                                        placeholder="(3 titik di lokasi bagian atas dan 3 titik dilokasi bagian bawah dengan sudut radial ±120°, serta 1 titik di lokasi tengah vat/ kontainer)">
                                        (3 titik di lokasi bagian atas dan 3 titik dilokasi bagian bawah dengan sudut radial ±120°, serta 1 titik di lokasi tengah vat/ kontainer)</textarea>,
                                        kemudian dilakukan pemeriksaan
                                        <input type="text" name="pencampuran_pemeriksaan_jenis" class="template-input w-180" 
                                        placeholder="Kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12">
                                        dengan hasil sebagai berikut:
                                    </p>

                                     <div class="mixing-tables-container flex flex-col gap-3 ml-4">
                                <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative mt-3"
                                    data-table-uid="tbl_pencampuran_213" onpaste="handleMixingPaste(event, this)">
                                    <div class="absolute top-1 right-1 z-20 remove-table-btn">
                                        <button type="button" onclick="toggleTableMenu(this)" class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors" title="Opsi"><span class="material-symbols-outlined text-[20px] block">more_vert</span></button>
                                        <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30"><button type="button" onclick="removeMixingTable(this)" class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span>Hapus Tabel</button></div>
                                    </div>
                                    <div class="p-4">
                                        <div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-4 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)">
                                            <span class="material-symbols-outlined text-3xl text-slate-300 dark:text-slate-600 mb-1">content_paste</span>
                                            <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p>
                                            <div class="flex justify-center mb-2"><button type="button" onclick="triggerClipboardPaste(this)" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">content_paste_go</span>Tempel dari Clipboard</button></div>
                                            <textarea rows="3" class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)" onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                                        </div>
                                        <input type="file" name="mixing_image_file[tbl_pencampuran_213]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                                        <div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1"><img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm"><button type="button" onclick="removeImage(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Gambar"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                        <div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3"><div class="overflow-auto max-h-[420px]"><table class="w-full text-sm border-collapse pasted-table-preview-table"></table></div><button type="button" onclick="removePastedTable(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Tabel Paste"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                    </div>
                                    <input type="hidden" name="bab22_table_subab_key[tbl_pencampuran_213]" value="pencampuran_213">
                                    <input type="hidden" name="existing_mixing_image_file[tbl_pencampuran_213]" value="">
                                    <input type="hidden" name="mixing_pasted_table_json[tbl_pencampuran_213]" value="">
                                    <input type="hidden" name="mixing_image_base64[tbl_pencampuran_213]" value="">
                                </div>
                                    </div>
                                </div>

                                    {{-- 2.3.1.3.1 --}}
                                    <div class="ml-6 mb-3">
                                        <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                            <span class="font-semibold">2.3.1.3.1</span>
                                            Tabel data hasil pemeriksaan kadar zat aktif
                                            
                                        </p>
                                        <div class="mixing-tables-container flex flex-col gap-3 ml-4">
                                <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative mt-3"
                                    data-table-uid="tbl_pencampuran_1331" onpaste="handleMixingPaste(event, this)">
                                    <div class="absolute top-1 right-1 z-20 remove-table-btn">
                                        <button type="button" onclick="toggleTableMenu(this)" class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors" title="Opsi"><span class="material-symbols-outlined text-[20px] block">more_vert</span></button>
                                        <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30"><button type="button" onclick="removeMixingTable(this)" class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span>Hapus Tabel</button></div>
                                    </div>
                                    <div class="p-4">
                                        <div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-4 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)">
                                            <span class="material-symbols-outlined text-3xl text-slate-300 dark:text-slate-600 mb-1">content_paste</span>
                                            <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p>
                                            <div class="flex justify-center mb-2"><button type="button" onclick="triggerClipboardPaste(this)" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">content_paste_go</span>Tempel dari Clipboard</button></div>
                                            <textarea rows="3" class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)" onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                                        </div>
                                        <input type="file" name="mixing_image_file[tbl_pencampuran_1331]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                                        <div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1"><img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm"><button type="button" onclick="removeImage(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Gambar"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                        <div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3"><div class="overflow-auto max-h-[420px]"><table class="w-full text-sm border-collapse pasted-table-preview-table"></table></div><button type="button" onclick="removePastedTable(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Tabel Paste"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                    </div>
                                    <input type="hidden" name="bab22_table_subab_key[tbl_pencampuran_1331]" value="pencampuran_1331">
                                    <input type="hidden" name="existing_mixing_image_file[tbl_pencampuran_1331]" value="">
                                    <input type="hidden" name="mixing_pasted_table_json[tbl_pencampuran_1331]" value="">
                                    <input type="hidden" name="mixing_image_base64[tbl_pencampuran_1331]" value="">
                                </div>
                                        </div>
                                    </div>
                                    
                                    {{-- 2.3.1.3.1.1 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.1.3.1.1</span>
                                        Parameter kadar
                                        <input type="text" name="pemeriksaan_bahan_baku" class="template-input sync-input w-180"
                                        data-sync="bahan_baku" placeholder="((6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6 HCl, dan Vitamin B12">,
                                        pada tahap lubrikasi produk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                        data-sync="nama_produk" placeholder="Q-Fomil">,
                                        bukan merupakan syarat release, tetapi hanya sebagai pendataan selama proses.
                                        
                                    </p>
                                </div>
                                    

                                    {{-- 2.3.1.3.2 --}}
                                    <div class="ml-6 mb-3">
                                        <p class="text-base text-slate-700 dark:text-slate-300">
                                            <span class="font-semibold">2.3.1.3.1.2</span>
                                            Seluruh hasil pemeriksaan kadar 
                                            <input type="text" name="pemeriksaan_bahan_baku" class="template-input sync-input w-180"
                                            data-sync="bahan_baku" placeholder="((6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6 HCl, dan Vitamin B12">,
                                            pada tahap lubrikasi akhir produk
                                            <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                            data-sync="nama_produk" placeholder="Q-Fomil">,
                                            batch
                                            <input type="text" name="batch_name" class="template-input sync-input w-52" data-sync="batch" placeholder=" AUG25A01">
                                            sudah memberikan hasil yang memenuhi persyaratan Spesifikasi Produk yang berlaku.

                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- 2.3.2 Tahap Pencetakan --}}
                            <div class="ml-4 mb-0 p-4 bg-slate-50 dark:bg-slate-900/30 rounded-lg border border-slate-200 dark:border-slate-700">
                                <h4 class="font-semibold text-slate-700 dark:text-slate-300 mb-4">2.3.2 Tahap Pencetakan</h4>

                                {{-- 2.3.2.1 --}}
                                <div class="ml-4 mb-4 subsec-232" data-subsec-id="1">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold subsec-232-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleSubsec232(this)" title="Klik untuk disable/enable">2.3.2.1</span>
                                        Tahap pencetakan produk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                            data-sync="nama_produk" placeholder="Q-Fomil">
                                        menggunakan mesin
                                        <input type="text" name="tujuan_mesin_kapsulasi" class="template-input w-64" 
                                        value="cetak Hanseaten PII/S" placeholder="cetak Hanseaten PII/S">.
                                    </p>
                                </div>

                                {{-- 2.3.2.2 --}}
                                <div class="ml-4 mb-4 subsec-232" data-subsec-id="2">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold subsec-232-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleSubsec232(this)" title="Klik untuk disable/enable">2.3.2.2</span>
                                        Spesifikasi Produk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                            data-sync="nama_produk" placeholder="Q-Fomil">
                                        pada tahap pencetakan sesuai dengan Spesifikasi Produk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                            data-sync="nama_produk" placeholder="Q-Fomil">,
                                        no. dokumen
                                        <input type="text" name="kapsulasi_no_dokumen" class="template-input w-44" placeholder="EA-F03-3-00261-00">,
                                        tanggal
                                        <input type="text" name="kapsulasi_tanggal_dokumen" class="template-input w-28" placeholder="19-01-2024">
                                        produk antara hasil pencetakan memiliki spesifikasi sebagai berikut:
                                    </p>
                                    <div class="mixing-tables-container flex flex-col gap-3 ml-4">
                                        <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative mt-3"
                                            data-table-uid="tbl_kapsulasi_222" onpaste="handleMixingPaste(event, this)">
                                            <div class="absolute top-1 right-1 z-20 remove-table-btn">
                                                <button type="button" onclick="toggleTableMenu(this)" class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors" title="Opsi"><span class="material-symbols-outlined text-[20px] block">more_vert</span></button>
                                                <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30"><button type="button" onclick="removeMixingTable(this)" class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span>Hapus Tabel</button></div>
                                            </div>
                                            <div class="p-4">
                                                <div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-4 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)">
                                                    <span class="material-symbols-outlined text-3xl text-slate-300 dark:text-slate-600 mb-1">content_paste</span>
                                                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p>
                                                    <div class="flex justify-center mb-2"><button type="button" onclick="triggerClipboardPaste(this)" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">content_paste_go</span>Tempel dari Clipboard</button></div>
                                                    <textarea rows="3" class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)" onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                                                </div>
                                                <input type="file" name="mixing_image_file[tbl_kapsulasi_222]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                                                <div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1"><img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm"><button type="button" onclick="removeImage(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Gambar"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                                <div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3"><div class="overflow-auto max-h-[420px]"><table class="w-full text-sm border-collapse pasted-table-preview-table"></table></div><button type="button" onclick="removePastedTable(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Tabel Paste"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                            </div>
                                            <input type="hidden" name="bab22_table_subab_key[tbl_kapsulasi_222]" value="kapsulasi_222">
                                            <input type="hidden" name="existing_mixing_image_file[tbl_kapsulasi_222]" value="">
                                            <input type="hidden" name="mixing_pasted_table_json[tbl_kapsulasi_222]" value="">
                                            <input type="hidden" name="mixing_image_base64[tbl_kapsulasi_222]" value="">
                                        </div>
                                    </div>
                                </div>

                                {{-- 2.3.2.3 --}}
                                <div class="ml-4 mb-4 subsec-232" data-subsec-id="3">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold subsec-232-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleSubsec232(this)" title="Klik untuk disable/enable">2.3.2.3</span>
                                        Pada proses pencetakan dilakukan pengambilan sampel sebanyak
                                        <input type="text" name="kapsulasi_sampling_titik" class="template-input w-12" placeholder="10">
                                        kali sepanjang proses pencetakan.
                                    </p>
                                </div>

                                {{-- 2.3.2.4 --}}
                                <div class="ml-4 mb-4 subsec-232" data-subsec-id="4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold subsec-232-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleSubsec232(this)" title="Klik untuk disable/enable">2.3.2.4</span>
                                        Sampel yang didapat kemudian dilakukan pemeriksaan
                                        <textarea name="pencampuran_sampling_waktu_234" rows="3" class="template-input w-full resize-y text-base font-bold"
                                            placeholder="pemerian kaplet inti (bentuk, warna), ukuran, kekerasan, tebal, kerapuhan, waktu hancur, kadar air, keseragaman bobot, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12.">pemerian kaplet inti (bentuk, warna), ukuran, kekerasan, tebal, kerapuhan, waktu hancur, kadar air, keseragaman bobot, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12.</textarea>
                                    </p>
                                </div>

                                {{-- 2.3.2.5 --}}
                                <div class="ml-4 mb-4 subsec-232" data-subsec-id="5">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold subsec-232-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleSubsec232(this)" title="Klik untuk disable/enable">2.3.2.5</span>
                                        Data pemeriksaan dan evaluasi pada proses pencetakan untuk parameter
                                        <textarea name="pencampuran_sampling_waktu_235" rows="3" class="template-input w-full resize-y text-base font-bold"
                                            placeholder="pemerian kaplet inti (bentuk, warna), ukuran, kekerasan, tebal, kerapuhan, waktu hancur, kadar air, keseragaman bobot">pemerian kaplet inti (bentuk, warna), ukuran, kekerasan, tebal, kerapuhan, waktu hancur, kadar air, keseragaman bobot</textarea>
                                        adalah sebagai berikut:
                                    </p>
                                    <div class="mixing-tables-container flex flex-col gap-3 ml-4">
                                        <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative mt-3"
                                            data-table-uid="tbl_kapsulasi_2231" onpaste="handleMixingPaste(event, this)">
                                            <div class="absolute top-1 right-1 z-20 remove-table-btn">
                                                <button type="button" onclick="toggleTableMenu(this)" class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors" title="Opsi"><span class="material-symbols-outlined text-[20px] block">more_vert</span></button>
                                                <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30"><button type="button" onclick="removeMixingTable(this)" class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span>Hapus Tabel</button></div>
                                            </div>
                                            <div class="p-4">
                                                <div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-4 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)">
                                                    <span class="material-symbols-outlined text-3xl text-slate-300 dark:text-slate-600 mb-1">content_paste</span>
                                                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p>
                                                    <div class="flex justify-center mb-2"><button type="button" onclick="triggerClipboardPaste(this)" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">content_paste_go</span>Tempel dari Clipboard</button></div>
                                                    <textarea rows="3" class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)" onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                                                </div>
                                                <input type="file" name="mixing_image_file[tbl_kapsulasi_2231]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                                                <div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1"><img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm"><button type="button" onclick="removeImage(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Gambar"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                                <div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3"><div class="overflow-auto max-h-[420px]"><table class="w-full text-sm border-collapse pasted-table-preview-table"></table></div><button type="button" onclick="removePastedTable(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Tabel Paste"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                            </div>
                                            <input type="hidden" name="bab22_table_subab_key[tbl_kapsulasi_2231]" value="kapsulasi_2231">
                                            <input type="hidden" name="existing_mixing_image_file[tbl_kapsulasi_2231]" value="">
                                            <input type="hidden" name="mixing_pasted_table_json[tbl_kapsulasi_2231]" value="">
                                            <input type="hidden" name="mixing_image_base64[tbl_kapsulasi_2231]" value="">
                                        </div>
                                    </div>
                                </div>

                            </div>{{-- end box 2.3.2 --}}

                            {{-- 2.3.2.6 — di luar kotak sesuai permintaan --}}
                            <div class="ml-4 mt-4 mb-4 subsec-232" data-subsec-id="6">
                                <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                    <span class="font-semibold subsec-232-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleSubsec232(this)" title="Klik untuk disable/enable">2.3.2.6</span>
                                    Data pemeriksaan tahap pencetakan untuk parameter
                                    <input type="text" name="pencampuran_identifikasi"
                                        class="template-input w-76" placeholder="identifikasi dan kadar">
                                    adalah sebagai berikut:
                                </p>
                                <div class="mixing-tables-container flex flex-col gap-3 ml-4">
                                    <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative mt-3"
                                        data-table-uid="tbl_kapsulasi_2232" onpaste="handleMixingPaste(event, this)">
                                        <div class="absolute top-1 right-1 z-20 remove-table-btn">
                                            <button type="button" onclick="toggleTableMenu(this)" class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors" title="Opsi"><span class="material-symbols-outlined text-[20px] block">more_vert</span></button>
                                            <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30"><button type="button" onclick="removeMixingTable(this)" class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span>Hapus Tabel</button></div>
                                        </div>
                                        <div class="p-4">
                                            <div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-4 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)">
                                                <span class="material-symbols-outlined text-3xl text-slate-300 dark:text-slate-600 mb-1">content_paste</span>
                                                <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p>
                                                <div class="flex justify-center mb-2"><button type="button" onclick="triggerClipboardPaste(this)" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">content_paste_go</span>Tempel dari Clipboard</button></div>
                                                <textarea rows="3" class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)" onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                                            </div>
                                            <input type="file" name="mixing_image_file[tbl_kapsulasi_2232]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                                            <div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1"><img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm"><button type="button" onclick="removeImage(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Gambar"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                            <div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3"><div class="overflow-auto max-h-[420px]"><table class="w-full text-sm border-collapse pasted-table-preview-table"></table></div><button type="button" onclick="removePastedTable(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Tabel Paste"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                        </div>
                                        <input type="hidden" name="bab22_table_subab_key[tbl_kapsulasi_2232]" value="kapsulasi_2232">
                                        <input type="hidden" name="existing_mixing_image_file[tbl_kapsulasi_2232]" value="">
                                        <input type="hidden" name="mixing_pasted_table_json[tbl_kapsulasi_2232]" value="">
                                        <input type="hidden" name="mixing_image_base64[tbl_kapsulasi_2232]" value="">
                                    </div>
                                </div>

                                {{-- 2.3.2.6.1 --}}
                                <div class="ml-4 mt-4 mb-3">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.2.6.1</span>
                                        Parameter <textarea name="pencampuran_sampling_waktu_2361" rows="3" class="template-input w-full resize-y text-base font-bold"
                                            placeholder="ukuran, tebal, identifikasi, dan kadar zat aktif ((6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12)">
                                            ukuran, tebal, identifikasi, dan kadar zat aktif ((6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12)</textarea>
                                        pada tahap pencetakan produk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                            data-sync="nama_produk" placeholder="Q-Fomil">
                                        bukan merupakan syarat release, tetapi hanya sebagai pendataan selama proses.
                                    </p>
                                </div>

                                {{-- 2.3.2.6.2 --}}
                                <div class="ml-4 mb-3">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.2.6.2</span>
                                        Seluruh hasil pemeriksaan
                                        <textarea name="pencampuran_sampling_waktu_2362" rows="3" class="template-input w-full resize-y text-base font-bold"
                                            placeholder="pemerian kaplet inti (bentuk, warna), ukuran, kekerasan, tebal, kerapuhan, waktu hancur, kadar air, keseragaman bobot, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12">pemerian kaplet inti (bentuk, warna), ukuran, kekerasan, tebal, kerapuhan, waktu hancur, kadar air, keseragaman bobot, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12</textarea>
                                        pada tahap pencetakan produk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                            data-sync="nama_produk" placeholder="Q-Fomil">
                                        batch
                                        <input type="text" name="batch_besaran_2362" class="template-input w-56" placeholder="DEC25A01">
                                        sudah memberikan hasil yang memenuhi persyaratan Spesifikasi Produk yang berlaku.
                                    </p>
                                </div>
                            </div>{{-- end subsec-232 2.3.2.6 --}}

                            {{-- 2.3.3 Tahap Penyalutan --}}
                            <div class="ml-4 mb-6 p-4 bg-slate-50 dark:bg-slate-900/30 rounded-lg border border-slate-200 dark:border-slate-700">
                                <h4 class="font-semibold text-slate-700 dark:text-slate-300 mb-4">2.3.3 Tahap Penyalutan</h4>

                                {{-- 2.3.3.1 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.3.1</span>
                                        Tahap penyalutan produk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                        data-sync="nama_produk" placeholder="Q-Fomil">
                                        menggunakan mesin
                                        <input type="text" name="tujuan_mesin_kemas" class="template-input w-52" 
                                        value="coating Rama Cota" placeholder="coating Rama Cota">.
                                        
                                    </p>
                                </div>

                                {{-- 2.3.3.2 --}}
                                <div class="ml-4 mb-4">
                                    <p 
                                    
                                    class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.3.2</span>
                                        Spesifikasi Produk 
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                        data-sync="nama_produk" placeholder="Q-Fomil">
                                        pada tahap penyalutan sesuai dengan Spesifikasi Produk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                        data-sync="nama_produk" placeholder="Q-Fomil">,
                                        no. dokumen
                                        <input type="text" name="kemasan_no_dokumen_produk" 
                                        class="template-input w-44" placeholder="EA-F03-3-00261-00">,
                                        tanggal
                                        <input type="text" name="kemasan_tanggal_dokumen_produk" 
                                        class="template-input w-28" placeholder="19-01-2024">
                                        produk antara hasil pencetakan memiliki spesifikasi sebagai berikut:

                                    </p>
                                    <div class="mixing-tables-container flex flex-col gap-3 ml-4">
                                <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative mt-3"
                                    data-table-uid="tbl_kemasan_332" onpaste="handleMixingPaste(event, this)">
                                    <div class="absolute top-1 right-1 z-20 remove-table-btn">
                                        <button type="button" onclick="toggleTableMenu(this)" class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors" title="Opsi"><span class="material-symbols-outlined text-[20px] block">more_vert</span></button>
                                        <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30"><button type="button" onclick="removeMixingTable(this)" class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span>Hapus Tabel</button></div>
                                    </div>
                                    <div class="p-4">
                                        <div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-4 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)">
                                            <span class="material-symbols-outlined text-3xl text-slate-300 dark:text-slate-600 mb-1">content_paste</span>
                                            <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p>
                                            <div class="flex justify-center mb-2"><button type="button" onclick="triggerClipboardPaste(this)" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">content_paste_go</span>Tempel dari Clipboard</button></div>
                                            <textarea rows="3" class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)" onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                                        </div>
                                        <input type="file" name="mixing_image_file[tbl_kemasan_332]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                                        <div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1"><img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm"><button type="button" onclick="removeImage(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Gambar"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                        <div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3"><div class="overflow-auto max-h-[420px]"><table class="w-full text-sm border-collapse pasted-table-preview-table"></table></div><button type="button" onclick="removePastedTable(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Tabel Paste"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                    </div>
                                    <input type="hidden" name="bab22_table_subab_key[tbl_kemasan_332]" value="kemasan_332">
                                    <input type="hidden" name="existing_mixing_image_file[tbl_kemasan_332]" value="">
                                    <input type="hidden" name="mixing_pasted_table_json[tbl_kemasan_332]" value="">
                                    <input type="hidden" name="mixing_image_base64[tbl_kemasan_332]" value="">
                                </div>
                                    </div>
                                </div>

                                {{-- 2.3.3.3 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.3.3</span>
                                        Pada proses penyalutan dilakukan pengambilan sampel sebanyak
                                        <input type="text" name="kemasan_sampling_titik" class="template-input w-12" placeholder="5">
                                        lokasi dalam panci penyalut yang mewakili bagian
                                         <input type="text" name="lokasi_sampling_penyalutan" class="template-input w-150" placeholder="depan kiri, depan kanan, tengah, belakang kiri, dan belakang kanan">.
                                    </p>
                                </div>

                                {{-- 2.3.3.4 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.3.4</span>
                                        Sampel yang didapat kemudian dilakukan pemeriksaan
                                        <textarea 
                                        name="pencampuran_sampling_waktu_334" rows="3" class="template-input w-full resize-y text-base font-bold" 
                                        placeholder=" pemerian kaplet salut (bentuk, warna), ukuran, kekerasan, tebal, waktu hancur, kadar air, keseragaman bobot, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12, dan cemaran logam berat.">
                                         pemerian kaplet salut (bentuk, warna), ukuran, kekerasan, tebal, waktu hancur, kadar air, keseragaman bobot, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12, dan cemaran logam berat.</textarea>
                                        
                                    </p>
                                </div>

                                {{-- 2.3.3.5 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.3.5</span>
                                        Data pemeriksaan dan evaluasi pada proses kapsulasi untuk parameter
                                    <input type="text" name="param_penyalutan_335" class="template-input w-full"
                                    value="pemerian kaplet inti (bentuk, warna), ukuran, kekerasan, tebal, waktu hancur, kadar air, keseragaman bobot"
                                    placeholder="pemerian kaplet inti (bentuk, warna), ukuran, kekerasan, tebal, waktu hancur, kadar air, keseragaman bobot">
                                     adalah sebagai berikut:
                                    </p>

                                    <div class="mixing-tables-container flex flex-col gap-3 ml-4">
                                <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative mt-3"
                                    data-table-uid="tbl_kemasan_3331" onpaste="handleMixingPaste(event, this)">
                                    <div class="absolute top-1 right-1 z-20 remove-table-btn">
                                        <button type="button" onclick="toggleTableMenu(this)" class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors" title="Opsi"><span class="material-symbols-outlined text-[20px] block">more_vert</span></button>
                                        <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30"><button type="button" onclick="removeMixingTable(this)" class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span>Hapus Tabel</button></div>
                                    </div>
                                    <div class="p-4">
                                        <div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-4 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)">
                                            <span class="material-symbols-outlined text-3xl text-slate-300 dark:text-slate-600 mb-1">content_paste</span>
                                            <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p>
                                            <div class="flex justify-center mb-2"><button type="button" onclick="triggerClipboardPaste(this)" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">content_paste_go</span>Tempel dari Clipboard</button></div>
                                            <textarea rows="3" class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)" onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                                        </div>
                                        <input type="file" name="mixing_image_file[tbl_kemasan_3331]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                                        <div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1"><img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm"><button type="button" onclick="removeImage(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Gambar"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                        <div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3"><div class="overflow-auto max-h-[420px]"><table class="w-full text-sm border-collapse pasted-table-preview-table"></table></div><button type="button" onclick="removePastedTable(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Tabel Paste"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                    </div>
                                    <input type="hidden" name="bab22_table_subab_key[tbl_kemasan_3331]" value="kemasan_3331">
                                    <input type="hidden" name="existing_mixing_image_file[tbl_kemasan_3331]" value="">
                                    <input type="hidden" name="mixing_pasted_table_json[tbl_kemasan_3331]" value="">
                                    <input type="hidden" name="mixing_image_base64[tbl_kemasan_3331]" value="">
                                </div>
                                    </div>
                                </div>

                                {{-- 2.3.3.6 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.3.6</span>
                                        Data pemeriksaan tahap penyalutan untuk parameter
                                        <input type="text" name="pencampuran_spesifikasi_nama" 
                                        class="template-input w-56" placeholder="cemaran logam berat">
                                        
                                    </p>

                                    <div class="mixing-tables-container flex flex-col gap-3 ml-4">
                                <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative mt-3"
                                    data-table-uid="tbl_kemasan_3332" onpaste="handleMixingPaste(event, this)">
                                    <div class="absolute top-1 right-1 z-20 remove-table-btn">
                                        <button type="button" onclick="toggleTableMenu(this)" class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors" title="Opsi"><span class="material-symbols-outlined text-[20px] block">more_vert</span></button>
                                        <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30"><button type="button" onclick="removeMixingTable(this)" class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span>Hapus Tabel</button></div>
                                    </div>
                                    <div class="p-4">
                                        <div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-4 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)">
                                            <span class="material-symbols-outlined text-3xl text-slate-300 dark:text-slate-600 mb-1">content_paste</span>
                                            <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p>
                                            <div class="flex justify-center mb-2"><button type="button" onclick="triggerClipboardPaste(this)" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">content_paste_go</span>Tempel dari Clipboard</button></div>
                                            <textarea rows="3" class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)" onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                                        </div>
                                        <input type="file" name="mixing_image_file[tbl_kemasan_3332]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                                        <div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1"><img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm"><button type="button" onclick="removeImage(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Gambar"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                        <div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3"><div class="overflow-auto max-h-[420px]"><table class="w-full text-sm border-collapse pasted-table-preview-table"></table></div><button type="button" onclick="removePastedTable(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Tabel Paste"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                    </div>
                                    <input type="hidden" name="bab22_table_subab_key[tbl_kemasan_3332]" value="kemasan_3332">
                                    <input type="hidden" name="existing_mixing_image_file[tbl_kemasan_3332]" value="">
                                    <input type="hidden" name="mixing_pasted_table_json[tbl_kemasan_3332]" value="">
                                    <input type="hidden" name="mixing_image_base64[tbl_kemasan_3332]" value="">
                                </div>
                                    </div>
                                </div>

                                {{-- 2.3.3.7 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.3.7</span>
                                        Data pemeriksaan tahap penyalutan untuk parameter
                                         <input type="text" name="pencampuran_identifikasi" 
                                         class="template-input w-76" placeholder="identifikasi dan kadar">
                                        adalah sebagai berikut: 
                                        
                                    </p>

                                    <div class="mixing-tables-container flex flex-col gap-3 ml-4">
                                <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative mt-3"
                                    data-table-uid="tbl_kemasan_3335" onpaste="handleMixingPaste(event, this)">
                                    <div class="absolute top-1 right-1 z-20 remove-table-btn">
                                        <button type="button" onclick="toggleTableMenu(this)" class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors" title="Opsi"><span class="material-symbols-outlined text-[20px] block">more_vert</span></button>
                                        <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30"><button type="button" onclick="removeMixingTable(this)" class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span>Hapus Tabel</button></div>
                                    </div>
                                    <div class="p-4">
                                        <div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-4 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)">
                                            <span class="material-symbols-outlined text-3xl text-slate-300 dark:text-slate-600 mb-1">content_paste</span>
                                            <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p>
                                            <div class="flex justify-center mb-2"><button type="button" onclick="triggerClipboardPaste(this)" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">content_paste_go</span>Tempel dari Clipboard</button></div>
                                            <textarea rows="3" class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)" onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                                        </div>
                                        <input type="file" name="mixing_image_file[tbl_kemasan_3335]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                                        <div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1"><img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm"><button type="button" onclick="removeImage(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Gambar"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                        <div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3"><div class="overflow-auto max-h-[420px]"><table class="w-full text-sm border-collapse pasted-table-preview-table"></table></div><button type="button" onclick="removePastedTable(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Tabel Paste"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                    </div>
                                    <input type="hidden" name="bab22_table_subab_key[tbl_kemasan_3335]" value="kemasan_3335">
                                    <input type="hidden" name="existing_mixing_image_file[tbl_kemasan_3335]" value="">
                                    <input type="hidden" name="mixing_pasted_table_json[tbl_kemasan_3335]" value="">
                                    <input type="hidden" name="mixing_image_base64[tbl_kemasan_3335]" value="">
                                </div>
                                    </div>
                                </div>

                                 {{-- 2.3.3.7.1 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.3.7.1</span>
                                        Parameter
                                        <input type="text" name="pencampuran_ukuran" 
                                         class="template-input w-36" placeholder="ukuran dan tebal">
                                        pada tahap penyalutan produk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                            data-sync="nama_produk" placeholder="Q-Fomil">
                                        bukan merupakan syarat release, tetapi hanya sebagai pendataan selama proses.

                                    </p>
                                </div>
                                
                                 {{-- 2.3.3.7.2 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.3.7.2</span>
                                        Seluruh hasil pemeriksaan
                                        <textarea 
                                        name="pencampuran_sampling_waktu_3372" rows="3" class="template-input w-full resize-y text-base font-bold" 
                                        placeholder="pemerian kaplet salut (bentuk, warna), ukuran, kekerasan, tebal, waktu hancur, kadar air, keseragaman bobot, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12">
                                        pemerian kaplet salut (bentuk, warna), ukuran, kekerasan, tebal, waktu hancur, kadar air, keseragaman bobot, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12</textarea>
                                        pada tahap pencetakan produk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                        data-sync="nama_produk" placeholder="Q-Fomil">
                                        batch
                                        <input type="text" name="batch_besaran" class="template-input w-56"
                                        placeholder="DEC25A01">
                                       sudah memberikan hasil yang memenuhi persyaratan Spesifikasi Produk yang berlaku.
                                    </p>
                                </div>
                                

                                {{-- 2.3.4 Tahap Kemas Primer --}}
                            <div class="ml-4 mb-6 p-4 bg-slate-50 dark:bg-slate-900/30 rounded-lg border border-slate-200 dark:border-slate-700">
                                <h4 class="font-semibold text-slate-700 dark:text-slate-300 mb-4">2.3.4 Tahap Kemas Primer</h4>

                                {{-- 2.3.4.1 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.4.1</span>
                                        Tahap kemas primer (strip) produk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-48"
                                        data-sync="nama_produk" placeholder="Q-Fomil">
                                        menggunakan mesin
                                        <input type="text" name="tujuan_mesin_kemas_primer" class="template-input w-40" 
                                        value="Uhlmann HS 40" placeholder="Uhlmann HS 40">.
                                        
                                    </p>
                                </div>

                                {{-- 2.3.4.2 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.4.2</span>
                                        Pada proses pengemasan primer (strip) dilakukan
                                        <input type="text" name="kapsulasi_sampling_titik" 
                                        class="template-input w-12" placeholder="10">
                                        kali sampling yang mewakili
                                        <input type="text" name="kapsulasi_sampling_waktu" 
                                        class="template-input w-70" placeholder="awal, tengah, dan akhir">
                                        selama proses pengemasan primer.
                                        
                                    </p>
                                </div>

                                {{-- 2.3.4.3 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.4.3</span>
                                        Spesifikasi Produk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                        data-sync="nama_produk" placeholder="Q-Fomil">
                                        pada proses pengemasan primer (strip) sesuai dengan Spesifikasi Kemasan
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                        data-sync="nama_produk" placeholder="Q-Fomil">,
                                        No. Dokumen
                                        <input type="text" name="pencampuran_no_dokumen" class="template-input sync-input w-53"
                                        data-sync="no_dokumen" placeholder="EC-F04-3-00189-01">,
                                        tanggal
                                        <input type="text" name="pencampuran_tanggal_dokumen" class="template-input sync-input w-53"
                                        data-sync="tanggal_dokumen" placeholder="03-05-2025">
                                        ditambah dengan pemeriksaan cemaran mikroba sesuai Spesifikasi Produk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                        data-sync="nama_produk" placeholder="Q-Fomil">,
                                        No.Dokumen 
                                        <input type="text" name="pencampuran_no_dokumen" class="template-input sync-input w-53"
                                        data-sync="no_dokumen" placeholder="EA-F03-3-00261-00">,
                                        tanggal
                                        <input type="text" name="pencampuran_tanggal_dokumen" class="template-input sync-input w-53"
                                        data-sync="tanggal_dokumen" placeholder="19-01-2024">,
                                        adalah sebagai berikut:
                                        
                                    </p>

                                    <div class="mixing-tables-container flex flex-col gap-3 ml-4">
                                <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative mt-3"
                                    data-table-uid="tbl_kemasan_3333" onpaste="handleMixingPaste(event, this)">
                                    <div class="absolute top-1 right-1 z-20 remove-table-btn">
                                        <button type="button" onclick="toggleTableMenu(this)" class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors" title="Opsi"><span class="material-symbols-outlined text-[20px] block">more_vert</span></button>
                                        <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30"><button type="button" onclick="removeMixingTable(this)" class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span>Hapus Tabel</button></div>
                                    </div>
                                    <div class="p-4">
                                        <div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-4 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)">
                                            <span class="material-symbols-outlined text-3xl text-slate-300 dark:text-slate-600 mb-1">content_paste</span>
                                            <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p>
                                            <div class="flex justify-center mb-2"><button type="button" onclick="triggerClipboardPaste(this)" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">content_paste_go</span>Tempel dari Clipboard</button></div>
                                            <textarea rows="3" class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)" onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                                        </div>
                                        <input type="file" name="mixing_image_file[tbl_kemasan_3333]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                                        <div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1"><img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm"><button type="button" onclick="removeImage(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Gambar"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                        <div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3"><div class="overflow-auto max-h-[420px]"><table class="w-full text-sm border-collapse pasted-table-preview-table"></table></div><button type="button" onclick="removePastedTable(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Tabel Paste"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                    </div>
                                    <input type="hidden" name="bab22_table_subab_key[tbl_kemasan_3333]" value="kemasan_3333">
                                    <input type="hidden" name="existing_mixing_image_file[tbl_kemasan_3333]" value="">
                                    <input type="hidden" name="mixing_pasted_table_json[tbl_kemasan_3333]" value="">
                                    <input type="hidden" name="mixing_image_base64[tbl_kemasan_3333]" value="">
                                </div>
                                    </div>
                                </div>

                                {{-- 2.3.4.4 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.4.4</span>
                                        Sampel yang didapat kemudian dilakukan pemeriksaan
                                        <input type="text" name="param_kemas_344" class="template-input w-115"
                                        value="isi dalam 1 strip, elegance strip, dan cemaran mikroba"
                                        placeholder="isi dalam 1 strip, elegance strip, dan cemaran mikroba">.
                                        
                                    </p>
                                </div>

                                {{-- 2.3.4.5 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.4.5</span>
                                        Data hasil pemeriksaan isi dalam 1 (botol) adalah sebagai berikut:
                                        
                                    </p>
                                    <div class="mixing-tables-container flex flex-col gap-3 ml-4">
                                <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative mt-3"
                                    data-table-uid="tbl_kemasan_3336" onpaste="handleMixingPaste(event, this)">
                                    <div class="absolute top-1 right-1 z-20 remove-table-btn">
                                        <button type="button" onclick="toggleTableMenu(this)" class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors" title="Opsi"><span class="material-symbols-outlined text-[20px] block">more_vert</span></button>
                                        <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30"><button type="button" onclick="removeMixingTable(this)" class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span>Hapus Tabel</button></div>
                                    </div>
                                    <div class="p-4">
                                        <div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-4 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)">
                                            <span class="material-symbols-outlined text-3xl text-slate-300 dark:text-slate-600 mb-1">content_paste</span>
                                            <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p>
                                            <div class="flex justify-center mb-2"><button type="button" onclick="triggerClipboardPaste(this)" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">content_paste_go</span>Tempel dari Clipboard</button></div>
                                            <textarea rows="3" class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)" onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                                        </div>
                                        <input type="file" name="mixing_image_file[tbl_kemasan_3336]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                                        <div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1"><img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm"><button type="button" onclick="removeImage(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Gambar"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                        <div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3"><div class="overflow-auto max-h-[420px]"><table class="w-full text-sm border-collapse pasted-table-preview-table"></table></div><button type="button" onclick="removePastedTable(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Tabel Paste"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                    </div>
                                    <input type="hidden" name="bab22_table_subab_key[tbl_kemasan_3336]" value="kemasan_3336">
                                    <input type="hidden" name="existing_mixing_image_file[tbl_kemasan_3336]" value="">
                                    <input type="hidden" name="mixing_pasted_table_json[tbl_kemasan_3336]" value="">
                                    <input type="hidden" name="mixing_image_base64[tbl_kemasan_3336]" value="">
                                </div>
                                    </div>

                                </div>
                                    
                                {{-- 2.3.4.5.1 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.4.5.1</span>
                                        Secara keseluruhan, atribut yang diuji pada tahap kemas primer 
                                        <input type="text" name="param_kemas_3451" class="template-input w-86"
                                        value="isi dalam 1 strip, elegance strip" placeholder="isi dalam 1 strip, elegance strip">.
                                        produk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                        data-sync="nama_produk" placeholder="Q-Fomil">
                                        pada batch
                                        <input type="text" name="batch_besaran" class="template-input w-56"
                                        placeholder="DEC25A01">
                                        sudah memberikan hasil yang memenuhi persyaratan menurut Spesifikasi Kemasan yang berlaku
                                    </p>
                                </div>

                                {{-- 2.3.4.6 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.4.6</span>
                                        Data hasil pengujian cemaran mikroba adalah sebagai berikut:
                                        
                                    </p>
                                    <div class="mixing-tables-container flex flex-col gap-3 ml-4">
                                <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative mt-3"
                                    data-table-uid="tbl_kemasan_3334" onpaste="handleMixingPaste(event, this)">
                                    <div class="absolute top-1 right-1 z-20 remove-table-btn">
                                        <button type="button" onclick="toggleTableMenu(this)" class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors" title="Opsi"><span class="material-symbols-outlined text-[20px] block">more_vert</span></button>
                                        <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30"><button type="button" onclick="removeMixingTable(this)" class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors"><span class="material-symbols-outlined text-[18px]">delete</span>Hapus Tabel</button></div>
                                    </div>
                                    <div class="p-4">
                                        <div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-4 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)">
                                            <span class="material-symbols-outlined text-3xl text-slate-300 dark:text-slate-600 mb-1">content_paste</span>
                                            <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p>
                                            <div class="flex justify-center mb-2"><button type="button" onclick="triggerClipboardPaste(this)" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2"><span class="material-symbols-outlined text-[16px]">content_paste_go</span>Tempel dari Clipboard</button></div>
                                            <textarea rows="3" class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)" onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                                        </div>
                                        <input type="file" name="mixing_image_file[tbl_kemasan_3334]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                                        <div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1"><img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm"><button type="button" onclick="removeImage(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Gambar"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                        <div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3"><div class="overflow-auto max-h-[420px]"><table class="w-full text-sm border-collapse pasted-table-preview-table"></table></div><button type="button" onclick="removePastedTable(this)" class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10" title="Hapus Tabel Paste"><span class="material-symbols-outlined text-[14px] block">close</span></button></div>
                                    </div>
                                    <input type="hidden" name="bab22_table_subab_key[tbl_kemasan_3334]" value="kemasan_3334">
                                    <input type="hidden" name="existing_mixing_image_file[tbl_kemasan_3334]" value="">
                                    <input type="hidden" name="mixing_pasted_table_json[tbl_kemasan_3334]" value="">
                                    <input type="hidden" name="mixing_image_base64[tbl_kemasan_3334]" value="">
                                </div>
                                    </div>
                                </div>

                                    {{-- 2.3.4.6.1 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.4.6.1</span>
                                        Secara keseluruhan, atribut yang diuji pada tahap kemas primer
                                        <input type="text" name="param_kemas_3461" class="template-input w-86"
                                        value="pemeriksaan cemaran mikroba" placeholder="pemeriksaan cemaran mikroba">.
                                        Produk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                        data-sync="nama_produk" placeholder="Q-Fomil">
                                        pada batch
                                        <input type="text" name="batch_besaran" class="template-input w-56"
                                        placeholder="DEC25A01">
                                        sudah memberikan hasil yang memenuhi persyaratan menurut Spesifikasi Produk yang berlaku.

                                    </p>
                                </div>

                            </div>

                        </div>{{-- end bab2-section-content 2.3 --}}
                    </div>{{-- end bab2-section 2.3 --}}

                </div>{{-- end p-6 BAB 2 --}}
            </div>{{-- end bab2_card --}}


                 {{-- BAB 3: KESIMPULAN --}}
            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden bab-section" id="bab3_card">
                <div
                    class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <h2 class="font-bold text-slate-900 dark:text-white">
                        <span class="bab-section-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleBabSection('bab3_card')" title="Klik untuk disable/enable">3.</span>
                        KESIMPULAN
                    </h2>
                    <span class="text-xs text-slate-400 dark:text-slate-500">Klik nomor untuk enable/disable</span>
                </div>
                <div class="p-6 flex flex-col gap-6" id="bab3_container">
                    {{-- Hidden input to track enabled sections --}}
                    <input type="hidden" name="kesimpulan_enabled_sections" id="kesimpulan_enabled_sections"
                        value="1,2,3,4">

                    {{-- 3.1 --}}
                    <div class="kesimpulan-section" data-section-id="1">
                        <div
                            class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify transition-opacity duration-200">
                            <p 
                            class="pl-8 -indent-8">
                                <span
                                    class="kesimpulan-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                    onclick="toggleKesimpulanSection(this)" title="Klik untuk disable/enable">3.1</span>
                                Telah dilakukan validasi proses pengolahan dan pengemasan primer produk 
                                <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                data-sync="nama_produk" placeholder="Q-Fomil">,
                                batch
                                <input type="text" name="batch_besaran" class="template-input w-56"
                                placeholder="DEC25A01"> 
                                 <input type="text" name="rangkuman_metode" class="template-input sync-input w-full"
                                    data-sync="rangkuman"
                                    value="penimbangan bahan baku, pencampuran, pencetakan, penyalutan, dan pengemasan primer (stripping)"
                                    placeholder="penimbangan bahan baku, pencampuran, pencetakan, penyalutan, dan pengemasan primer (stripping)">
                                <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                        data-sync="nama_produk" placeholder="Q-Fomil">,
                                No. Dokumen
                                <input type="text" name="pencampuran_no_dokumen" class="template-input sync-input w-53"
                                    data-sync="no_dokumen" placeholder="CE-00466-00-PC">, 
                                tanggal
                                <input type="text" name="pencampuran_tanggal_dokumen" class="template-input sync-input w-53"
                                    data-sync="tanggal_dokumen" placeholder=" 12-07-2025">
                                dan MBR Pengemasan
                                <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                        data-sync="nama_produk" placeholder="Q-Fomil">
                                 No. Dokumen
                                <input type="text" name="pencampuran_no_dokumen" class="template-input sync-input w-53"
                                    data-sync="no_dokumen" placeholder="CE-00467-01-NL">, 
                                tanggal
                                <input type="text" name="pencampuran_tanggal_dokumen" class="template-input sync-input w-53"
                                    data-sync="tanggal_dokumen" placeholder="07-11-2025">.
                                
                            </p>

                            <div class="kesimpulan-sub-point ml-4" data-sub-point-id="3.1.1">
                                <div class="kesimpulan-content text-base leading-relaxed text-slate-700 dark:text-slate-300 template-text text-justify transition-opacity duration-200">
                                    <div class="flex items-start gap-2">
                                <span class="kesimpulan-sub-number font-bold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                onclick="toggleKesimpulanSubPoint(this)" title="Klik untuk disable/enable">3.1.1</span> 
                                <p 

                                style="text-align:left;">
                               Berdasarkan pemeriksaan batch validasi 
                                <input type="text" name="batch_besaran" class="template-input w-56"
                                    placeholder="DEC25A01"> 
                                terhadap parameter mutu produk pada tahap lubrikasi antara lain
                                 <input type="text" name="param_lubrikasi_311" class="template-input sync-input w-full"   
                                    value="kadar zat aktif (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12"
                                    placeholder="kadar zat aktif (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12">
                                didapatkan seluruh hasil pengujian
                                <input type="text" name="kemasan_hasil" class="template-input w-36" 
                                value="" placeholder="memenuhi">
                                 spesifikasi produk yang berlaku.
                            
                                </p>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="kesimpulan-sub-point ml-4" data-sub-point-id="3.1.2">
                                <div class="kesimpulan-content text-base leading-relaxed text-slate-700 dark:text-slate-300 template-text text-justify transition-opacity duration-200">
                                    <div class="flex items-start gap-2">
                                <span class="kesimpulan-sub-number font-bold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                onclick="toggleKesimpulanSubPoint(this)" title="Klik untuk disable/enable">3.1.2</span> 
                                <p>

                                Berdasarkan pemeriksaan batch validasi
                                <input type="text" name="batch_besaran" class="template-input w-56"
                                placeholder="DEC25A01">
                                terhadap parameter mutu produk pada tahap pencetakan, antara lain
                                <textarea name="param_pencetakan_312" rows="3" class="template-input w-full resize-y text-base font-bold" 
                                placeholder="pemerian kaplet inti (bentuk, warna), ukuran, kekerasan, tebal, kerapuhan, waktu hancur, kadar air, keseragaman bobot, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12">
                                pemerian kaplet inti (bentuk, warna), ukuran, kekerasan, tebal, kerapuhan, waktu hancur, kadar air, keseragaman bobot, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12</textarea>
                                didapatkan seluruh hasil pengujian telah 
                                <input type="text" name="kemasan_hasil" class="template-input w-36" 
                                value="" placeholder="memenuhi">
                                spesifikasi produk yang berlaku. 

                                </p>
                                        </div>
                                    </div>
                                </div>

                        <div class="kesimpulan-sub-point ml-4" data-sub-point-id="3.1.3">
                                <div class="kesimpulan-content text-base leading-relaxed text-slate-700 dark:text-slate-300 template-text text-justify transition-opacity duration-200">
                                    <div class="flex items-start gap-2">
                                <span class="kesimpulan-sub-number font-bold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                onclick="toggleKesimpulanSubPoint(this)" title="Klik untuk disable/enable">3.1.3</span> 
                                <p>

                                Berdasarkan pemeriksaan batch validasi
                                <input type="text" name="batch_besaran" class="template-input w-56"
                                placeholder="DEC25A01">
                                terhadap parameter mutu produk pada tahap penyalutan, antara lain
                                <textarea name="param_penyalutan_313" rows="3" class="template-input w-full resize-y text-base font-bold" 
                                placeholder="pemerian kaplet salut (bentuk, warna), ukuran, kekerasan, tebal, waktu hancur, kadar air, keseragaman bobot, cemaran logam berat, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12">
                                pemerian kaplet salut (bentuk, warna), ukuran, kekerasan, tebal, waktu hancur, kadar air, keseragaman bobot, cemaran logam berat, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12</textarea>
                                didapatkan seluruh hasil pengujian
                                <input type="text" name="kemasan_hasil" class="template-input w-36" 
                                value="" placeholder="memenuhi">
                                spesifikasi produk yang berlaku. 

                                </p>
                                        </div>
                                </div>
                        </div>
                        
                        <div class="kesimpulan-sub-point ml-4" data-sub-point-id="3.1.4">
                                <div class="kesimpulan-content text-base leading-relaxed text-slate-700 dark:text-slate-300 template-text text-justify transition-opacity duration-200">
                                    <div class="flex items-start gap-2">
                                <span class="kesimpulan-sub-number font-bold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                onclick="toggleKesimpulanSubPoint(this)" title="Klik untuk disable/enable">3.1.4</span> 
                                <p>

                                Berdasarkan pemeriksaan batch validasi
                                <input type="text" name="batch_besaran" class="template-input w-56"
                                placeholder="DEC25A01">
                                terhadap parameter mutu produk pada tahap pengemasan primer, antara lain
                                 <input type="text" name="param_kemas_314" class="template-input w-150"
                                value="isi dalam 1 strip, kebocoran strip, elegance strip, dan cemaran mikroba" placeholder="isi dalam 1 strip, kebocoran strip, elegance strip, dan cemaran mikroba,">,
                                didapatkan seluruh hasil pengujian
                                <input type="text" name="kemasan_hasil" class="template-input w-36" 
                                value="" placeholder="memenuhi">
                                spesifikasi produk yang berlaku. 

                                </p>
                                        </div>
                                </div>
                        </div>

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
                                Berdasarkan pemeriksaan pada batch validasi
                                <input type="text" name="batch_besaran" class="template-input w-56"
                                placeholder="DEC25A01">,
                                proses terbukti dapat menghasilkan produk jadi
                                <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                        data-sync="nama_produk" placeholder="Q-Fomil">
                                yang 
                                <input type="text" name="kemasan_hasil" class="template-input w-36" 
                                value="" placeholder="memenuhi">
                                spesifikasi sesuai dengan Spesifikasi Produk
                                <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                        data-sync="nama_produk" placeholder="Q-Fomil">,
                                No. Dokumen
                                <input type="text" name="pencampuran_no_dokumen" class="template-input sync-input w-53"
                                    data-sync="no_dokumen" placeholder="EA-F03-3-00261-00">
                                tanggal
                                <input type="text" name="pencampuran_tanggal_dokumen" class="template-input sync-input w-53"
                                    data-sync="tanggal_dokumen" placeholder="19-01-2024">
                                dan Spesifikasi Kemasan
                                <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-53"
                                        data-sync="nama_produk" placeholder="Q-Fomil">
                                No. Dokumen 
                                <input type="text" name="pencampuran_no_dokumen" class="template-input sync-input w-53"
                                    data-sync="no_dokumen" placeholder="EC-F04-3-00189-01">,
                                tanggal
                                <input type="text" name="pencampuran_tanggal_dokumen" class="template-input sync-input w-53"
                                    data-sync="tanggal_dokumen" placeholder="03-05-2025">.
                                sehingga dinyatakan 
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
            event.preventDefault();

            // Get pasted data
            const pastedData = (event.clipboardData || window.clipboardData).getData('text');

            if (!pastedData.trim()) {
                return;
            }

            // Parse tab-separated values
            const rows = pastedData.trim().split('\n').map(row => row.split('\t'));

            if (rows.length === 0) {
                return;
            }

            // Store data
            tableData[tableId] = rows;
            document.getElementById('hidden_data_' + tableId).value = JSON.stringify(rows);

            // Build table preview
            const tbody = document.getElementById('table_body_' + tableId);
            tbody.innerHTML = '';

            rows.forEach((row, index) => {
                const tr = document.createElement('tr');
                tr.className = index % 2 === 0 ? 'bg-white dark:bg-slate-800' : 'bg-slate-50 dark:bg-slate-900/50';

                // Ensure we have 4 columns
                while (row.length < 4) {
                    row.push('');
                }

                row.slice(0, 4).forEach(cell => {
                    const td = document.createElement('td');
                    td.className =
                        'px-4 py-2 text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700';
                    td.textContent = cell.trim();
                    tr.appendChild(td);
                });

                tbody.appendChild(tr);
            });

            // Show table preview, hide paste area
            document.getElementById('paste_instructions_' + tableId).classList.add('hidden');
            document.getElementById('table_preview_' + tableId).classList.remove('hidden');

            // Clear textarea
            document.getElementById('excel_paste_' + tableId).value = '';
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
            if (!navigator.clipboard || !navigator.clipboard.read) {
                alert('Browser Anda tidak mendukung akses clipboard otomatis. Silakan gunakan Ctrl+V langsung di area textarea.');
                return;
            }
            try {
                const clipboardItems = await navigator.clipboard.read();
                const tableItem = button.closest('.mixing-table-item');
                if (!tableItem) return;

                for (const clipboardItem of clipboardItems) {
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
                    const blob = item.getAsFile();
                    if (!blob) continue;

                    event.preventDefault();
                    foundImage = true;

                    const tableItem = textarea.closest('.mixing-table-item');
                    if (!tableItem) break;

                    const imageInput = tableItem.querySelector('input[type="file"][accept*="image"]');
                    if (imageInput) {
                        try {
                            const transfer = new DataTransfer();
                            transfer.items.add(blob);
                            imageInput.files = transfer.files;
                            previewImage(imageInput);
                        } catch (e) {
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
                    } else {
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

            if (!foundImage) {
                const text = clipboardData.getData('text/plain') || clipboardData.getData('text');
                if (text && text.includes('\t')) {
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
                    '#qfomilTemplateForm input[name]:not([type="file"]), #qfomilTemplateForm textarea[name], #qfomilTemplateForm select[name]'
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

            // After restoring, trigger input event on nama_produk master to sync all fields
            const namaProdukMaster = document.querySelector(
                '.sync-input[data-sync="nama_produk"][data-sync-master="1"]'
            );
            if (namaProdukMaster && namaProdukMaster.value) {
                namaProdukMaster.dispatchEvent(new Event('input', { bubbles: true }));
            }

            // Sync contenteditable fields from their hidden inputs
            if (values['bab1_112_text']) {
                const editor = document.getElementById('bab1_112_editor');
                if (editor) editor.innerText = values['bab1_112_text'];
            }
            if (values['kesimpulan_zat_aktif']) {
                const editor = document.getElementById('kesimpulan_zat_aktif_editor');
                if (editor) editor.innerText = values['kesimpulan_zat_aktif'];
            }
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
                    '#qfomilTemplateForm input[name], #qfomilTemplateForm textarea[name], #qfomilTemplateForm select[name]')
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

            const bab1DisabledSectionIds = [];
            document.querySelectorAll('.bab1-section.section-disabled').forEach(section => {
                if (section.dataset.sectionId) {
                    bab1DisabledSectionIds.push(section.dataset.sectionId);
                }
            });

            const bab2DisabledSectionIds = [];
            document.querySelectorAll('.bab2-section.section-disabled').forEach(section => {
                if (section.dataset.sectionId) {
                    bab2DisabledSectionIds.push(section.dataset.sectionId);
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
                bab1_disabled_sections: bab1DisabledSectionIds,
                bab2_disabled_sections: bab2DisabledSectionIds,
                subsec232_disabled_ids: Array.from(document.querySelectorAll('.subsec-232.subsec-disabled')).map(s => s.dataset.subsecId).filter(Boolean),
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

            const bab1DisabledIds = new Set(state.bab1_disabled_sections || []);
            document.querySelectorAll('.bab1-section').forEach(section => {
                const sectionId = section.dataset.sectionId || '';
                if (bab1DisabledIds.has(sectionId) && !section.classList.contains('section-disabled')) {
                    const numberEl = section.querySelector('.bab1-number');
                    if (numberEl) toggleBab1Section(numberEl);
                }
            });

            const bab2DisabledIds = new Set(state.bab2_disabled_sections || []);
            document.querySelectorAll('.bab2-section').forEach(section => {
                const sectionId = section.dataset.sectionId || '';
                if (bab2DisabledIds.has(sectionId) && !section.classList.contains('section-disabled')) {
                    const numberEl = section.querySelector('.bab2-number');
                    if (numberEl) toggleBab2Section(numberEl);
                }
            });

            // Restore disabled state subsection 2.3.2.x
            restoreSubsec232DisabledState(state.subsec232_disabled_ids || []);

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
            renumberSubsec232();
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
                const form = document.getElementById('qfomilTemplateForm');
                const formData = new FormData(form);
                formData.delete('_token');
                formData.append('_token', CSRF_TOKEN);
                const state = collectDraftState();

                const product = (state.form_values.judul_nama_produk || '').trim() || 'Q-Fomil';
                const line = (state.form_values.judul_line || '').trim() || 'Obat Dalam';
                const bagian = (state.form_values.judul_bagian || state.form_values.tujuan_bagian || '').trim() ||
                    'Natural Product & Extraction';
                const titleFallback =
                    `SUMMARY LAPORAN VALIDASI PROSES PEMBUATAN PRODUK ${product} DI LINI ${line} BAGIAN ${bagian.toUpperCase()}`;

                formData.append('draft_id', document.getElementById('draft_id').value || '');
                formData.append('draft_line', document.getElementById('draft_line').value || '');
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

        function toggleBabSection(cardId) {
            const card = document.getElementById(cardId);
            if (!card) return;
            const isDisabled = card.classList.toggle('bab-disabled');
            const numberEl = card.querySelector(':scope > div > h2 .bab-section-number');
            if (isDisabled) {
                card.style.opacity = '0.4';
                if (numberEl) numberEl.classList.add('line-through', 'text-red-500');
                card.querySelectorAll('input, textarea, button, select').forEach(el => {
                    if (!el.closest('.px-6.py-4')) {
                        el.setAttribute('disabled', 'disabled');
                        el.classList.add('opacity-50');
                    }
                });
            } else {
                card.style.opacity = '1';
                if (numberEl) numberEl.classList.remove('line-through', 'text-red-500');
                card.querySelectorAll('input, textarea, button, select').forEach(el => {
                    el.removeAttribute('disabled');
                    el.classList.remove('opacity-50');
                });
            }
            renumberAllBabs();
        }

        function renumberAllBabs() {
            const babCards = document.querySelectorAll('.bab-section');
            let babIdx = 1;
            babCards.forEach(card => {
                const isDisabled = card.classList.contains('bab-disabled');
                const numberEl = card.querySelector(' .bab-section-number');
                if (numberEl) return;
                if (!isDisabled) {
                    numberEl.textContent = babIdx + '.';
                    babIdx++;
                } else{
                    numberEl.textContent = babIdx + '.';
                }
                    
            });
            // Update sub-section numbers
            renumberBab1Sections();
            renumberBab2Sections();
            renumberKesimpulanSections();
        }

        function toggleBab2Section(numberEl) {
            const sectionDiv = numberEl.closest('.bab2-section');
            const isDisabled = sectionDiv.classList.toggle('section-disabled');
            const contentDiv = sectionDiv.querySelector('.bab2-section-content');
            const titleEl = sectionDiv.querySelector('h3');

            if (isDisabled) {
                if (contentDiv) { contentDiv.style.opacity = '0.35'; contentDiv.style.textDecoration = 'line-through'; }
                if (titleEl) titleEl.style.textDecoration = 'line-through';
                numberEl.classList.add('bg-red-100', 'text-red-500', 'line-through');
                sectionDiv.querySelectorAll('input, textarea, button, select').forEach(el => {
                    el.setAttribute('disabled', 'disabled');
                    el.classList.add('opacity-50');
                });
            } else {
                if (contentDiv) { contentDiv.style.opacity = '1'; contentDiv.style.textDecoration = 'none'; }
                if (titleEl) titleEl.style.textDecoration = 'none';
                numberEl.classList.remove('bg-red-100', 'text-red-500', 'line-through');
                sectionDiv.querySelectorAll('input, textarea, button, select').forEach(el => {
                    el.removeAttribute('disabled');
                    el.classList.remove('opacity-50');
                });
            }
            renumberBab2Sections();
        }

        function renumberBab2Sections() {
            const bab2Card = document.getElementById('bab2_card');
            const bab2NumEl = bab2Card ? bab2Card.querySelector('.bab-section-number') : null;
            const bab2Prefix = bab2NumEl ? bab2NumEl.textContent.replace('.', '') : '2';

            const allSections = document.querySelectorAll('.bab2-section');
            let activeIndex = 1;
            const enabledIds = [];

            allSections.forEach(section => {
                const numberEl = section.querySelector('.bab2-number');
                const isDisabled = section.classList.contains('section-disabled');
                if (!isDisabled) {
                    numberEl.textContent = section.dataset.sectionId === '1' ? bab2Prefix + '.' + activeIndex + '.' : bab2Prefix + '.' + activeIndex;
                    enabledIds.push(section.dataset.sectionId);
                    activeIndex++;
                } else {
                    numberEl.textContent = section.dataset.sectionId === '1' ? bab2Prefix + '.' + section.dataset.sectionId + '.' : bab2Prefix + '.' + section.dataset.sectionId;
                }
            });

            const hiddenInput = document.getElementById('bab2_enabled_sections');
            if (hiddenInput) hiddenInput.value = enabledIds.join(',');
        }

        // ===========================================
        // SUBSECTION 2.3.2 TOGGLE + RENUMBER SYSTEM
        // ===========================================
        function toggleSubsec232(numberEl) {
            const subsec = numberEl.closest('.subsec-232');
            if (!subsec) return;
            const isDisabled = subsec.classList.toggle('subsec-disabled');
            if (isDisabled) {
                subsec.style.opacity = '0.35';
                numberEl.classList.add('bg-red-100', 'text-red-500', 'line-through');
                subsec.querySelectorAll('input, textarea, button, select').forEach(el => {
                    if (!el.classList.contains('subsec-232-number')) {
                        el.setAttribute('disabled', 'disabled');
                        el.classList.add('opacity-50');
                    }
                });
            } else {
                subsec.style.opacity = '1';
                numberEl.classList.remove('bg-red-100', 'text-red-500', 'line-through');
                subsec.querySelectorAll('input, textarea, button, select').forEach(el => {
                    el.removeAttribute('disabled');
                    el.classList.remove('opacity-50');
                });
            }
            renumberSubsec232();
            saveSubsec232DisabledState();
        }

        function renumberSubsec232() {
            const all = document.querySelectorAll('.subsec-232');
            let idx = 1;
            all.forEach(subsec => {
                const numEl = subsec.querySelector('.subsec-232-number');
                if (!numEl) return;
                const isDisabled = subsec.classList.contains('subsec-disabled');
                if (!isDisabled) {
                    numEl.textContent = '2.3.2.' + idx;
                    idx++;
                } else {
                    // Tetap tampilkan nomor asli (dari data-subsec-id) saat disabled
                    numEl.textContent = '2.3.2.' + (subsec.dataset.subsecId || '?');
                }
            });
        }

        function saveSubsec232DisabledState() {
            const disabledIds = [];
            document.querySelectorAll('.subsec-232.subsec-disabled').forEach(s => {
                if (s.dataset.subsecId) disabledIds.push(s.dataset.subsecId);
            });
            let hiddenInput = document.getElementById('subsec232_disabled_ids');
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'subsec232_disabled_ids';
                hiddenInput.id = 'subsec232_disabled_ids';
                document.getElementById('qfomilTemplateForm').appendChild(hiddenInput);
            }
            hiddenInput.value = disabledIds.join(',');
        }

        function restoreSubsec232DisabledState(disabledIds) {
            if (!Array.isArray(disabledIds) || disabledIds.length === 0) return;
            const disabledSet = new Set(disabledIds.map(String));
            document.querySelectorAll('.subsec-232').forEach(subsec => {
                if (disabledSet.has(String(subsec.dataset.subsecId)) && !subsec.classList.contains('subsec-disabled')) {
                    const numEl = subsec.querySelector('.subsec-232-number');
                    if (numEl) toggleSubsec232(numEl);
                }
            });
        }

        function toggleBab1Section(numberEl) {
            const sectionDiv = numberEl.closest('.bab1-section');
            const isDisabled = sectionDiv.classList.toggle('section-disabled');
            const contentDiv = sectionDiv.querySelector('.bab1-section-content');
            const titleEl = sectionDiv.querySelector('h3');

            if (isDisabled) {
                if (contentDiv) { contentDiv.style.opacity = '0.35'; contentDiv.style.textDecoration = 'line-through'; }
                if (titleEl) titleEl.style.textDecoration = 'line-through';
                numberEl.classList.add('bg-red-100', 'text-red-500', 'line-through');
                sectionDiv.querySelectorAll('input, textarea').forEach(el => {
                    el.setAttribute('disabled', 'disabled');
                    el.classList.add('opacity-50');
                });
            } else {
                if (contentDiv) { contentDiv.style.opacity = '1'; contentDiv.style.textDecoration = 'none'; }
                if (titleEl) titleEl.style.textDecoration = 'none';
                numberEl.classList.remove('bg-red-100', 'text-red-500', 'line-through');
                sectionDiv.querySelectorAll('input, textarea').forEach(el => {
                    el.removeAttribute('disabled');
                    el.classList.remove('opacity-50');
                });
            }
            renumberBab1Sections();
        }

        function toggleBab1Point(numberEl) {
            const pointDiv = numberEl.closest('.bab1-point');
            if (!pointDiv) return;
            const isDisabled = pointDiv.classList.toggle('point-disabled');
            const contentDiv = pointDiv.querySelector('.bab1-section-content');
            if (isDisabled) {
                if (contentDiv) { contentDiv.style.opacity = '0.35'; contentDiv.style.textDecoration = 'line-through'; }
                numberEl.classList.add('bg-red-100', 'text-red-500', 'line-through');
                pointDiv.querySelectorAll('input, textarea').forEach(el => {
                    el.setAttribute('disabled', 'disabled');
                    el.classList.add('opacity-50');
                });
            } else {
                if (contentDiv) { contentDiv.style.opacity = '1'; contentDiv.style.textDecoration = 'none'; }
                numberEl.classList.remove('bg-red-100', 'text-red-500', 'line-through');
                pointDiv.querySelectorAll('input, textarea').forEach(el => {
                    el.removeAttribute('disabled');
                    el.classList.remove('opacity-50');
                });
            }
            renumberBab1Points();
        }

        function renumberBab1Points() {
            // Renumber points within each bab1-section
            document.querySelectorAll('.bab1-section').forEach(section => {
                const sectionNumEl = section.querySelector(':scope > h3 .bab1-number');
                const sectionNum = sectionNumEl ? sectionNumEl.textContent : '1.1';
                const points = section.querySelectorAll('.bab1-point');
                let idx = 1;
                points.forEach(point => {
                    const numEl = point.querySelector('.bab1-point-number');
                    const isDisabled = point.classList.contains('point-disabled');
                    if (numEl) numEl.textContent = sectionNum + '.' + idx;
                    if (!isDisabled) idx++;
                });
            });
        }

        function toggleKesimpulanSubPoint(numberEl) {
            const subPoint = numberEl.closest('.kesimpulan-sub-point');
            if (!subPoint) return;
            const isDisabled = subPoint.classList.toggle('sub-point-disabled');
            const contentDiv = subPoint.querySelector('.kesimpulan-content');
            if (isDisabled) {
                if (contentDiv) { contentDiv.style.opacity = '0.35'; contentDiv.style.textDecoration = 'line-through'; }
                numberEl.classList.add('bg-red-100', 'text-red-500', 'line-through');
                subPoint.querySelectorAll('input, textarea').forEach(el => {
                    el.setAttribute('disabled', 'disabled');
                    el.classList.add('opacity-50');
                });
            } else {
                if (contentDiv) { contentDiv.style.opacity = '1'; contentDiv.style.textDecoration = 'none'; }
                numberEl.classList.remove('bg-red-100', 'text-red-500', 'line-through');
                subPoint.querySelectorAll('input, textarea').forEach(el => {
                    el.removeAttribute('disabled');
                    el.classList.remove('opacity-50');
                });
            }
            renumberKesimpulanSubPoints();
        }

        function renumberKesimpulanSubPoints() {
            // Renumber sub-points within each kesimpulan-section
            document.querySelectorAll('.kesimpulan-section').forEach(section => {
                const sectionNumEl = section.querySelector('.kesimpulan-number');
                const sectionNum = sectionNumEl ? sectionNumEl.textContent : '';
                const subPoints = section.querySelectorAll('.kesimpulan-sub-point');
                let idx = 1;
                subPoints.forEach(sp => {
                    const numEl = sp.querySelector('.kesimpulan-sub-number');
                    const isDisabled = sp.classList.contains('sub-point-disabled');
                    if (numEl) numEl.textContent = sectionNum + '.' + idx;
                    if (!isDisabled) idx++;
                });
            });
        }

        function renumberBab1Sections() {
            const bab1Card = document.getElementById('bab1_card');
            const bab1NumEl = bab1Card ? bab1Card.querySelector('.bab-section-number') : null;
            const bab1Prefix = bab1NumEl ? bab1NumEl.textContent.replace('.', '') : '1';

            const allSections = document.querySelectorAll('.bab1-section');
            let activeIndex = 1;
            const enabledIds = [];

            allSections.forEach(section => {
                const numberEl = section.querySelector('.bab1-number');
                const isDisabled = section.classList.contains('section-disabled');
                if (!isDisabled) {
                    numberEl.textContent = bab1Prefix + '.' + activeIndex;
                    enabledIds.push(section.dataset.sectionId);
                    activeIndex++;
                } else {
                    numberEl.textContent = bab1Prefix + '.' + section.dataset.sectionId;
                }
            });

            const hiddenInput = document.getElementById('bab1_enabled_sections');
            if (hiddenInput) hiddenInput.value = enabledIds.join(',');
            renumberBab1Points();
        }

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
            const bab3Card = document.getElementById('bab3_card');
            const bab3NumEl = bab3Card ? bab3Card.querySelector('.bab-section-number') : null;
            const bab3Prefix = bab3NumEl ? bab3NumEl.textContent.replace('.', '') : '3';

            const allSections = document.querySelectorAll('.kesimpulan-section');
            let activeIndex = 1;
            const enabledIds = [];

            allSections.forEach(section => {
                const numberEl = section.querySelector('.kesimpulan-number');
                const isDisabled = section.classList.contains('section-disabled');

                if (!isDisabled) {
                    numberEl.textContent = bab3Prefix + '.' + activeIndex;
                    enabledIds.push(section.dataset.sectionId);
                    activeIndex++;
                } else {
                    const originalId = section.dataset.sectionId;
                    numberEl.textContent = bab3Prefix + '.' + originalId;
                }
            });

            // Update hidden input
            document.getElementById('kesimpulan_enabled_sections').value = enabledIds.join(',');
            renumberKesimpulanSubPoints();
        }

        // ===========================================
        // MIXING DYNAMIC TABLES SYSTEM (Excel Upload)
        // ===========================================

        const PARSE_EXCEL_URL = "{{ route('template-summary.parse-excel', [], false) }}";
        const SAVE_DRAFT_URL = "{{ route('template-summary.qfomil.draft', [], false) }}";
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
                        persyaratan menurut ${specText} yang berlaku.
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
               // addBab22DefaultSubab(
               //     'Filling-capping',
               //     'filling_capping',
               //     'filling-capping',
               //     'filling_capping_hasil',
               //     'Spesifikasi Produk dan Spesifikasi Kemasan'
                //);
            }
            initBab22DragDrop();
            //renumberBab22Subab();
            renumberSubsec232();

            // ===========================================
            // INPUT SYNCHRONIZATION (pola konidinobh)
            // ===========================================

            // Group all sync-input by data-sync key, sync dua arah real-time
            const syncInputs = document.querySelectorAll('.sync-input');
            const syncGroups = {};
            syncInputs.forEach(input => {
                const key = input.dataset.sync;
                if (!key) return;
                if (!syncGroups[key]) syncGroups[key] = [];
                syncGroups[key].push(input);
            });

            Object.keys(syncGroups).forEach(key => {
                const group = syncGroups[key];
                group.forEach(input => {
                    input.addEventListener('input', function() {
                        const value = this.value;
                        group.forEach(other => {
                            if (other !== this) other.value = value;
                        });
                    });
                });
            });

            // Inisialisasi nilai awal dari master field ke semua follower
            const uniqueSyncKeys = [...new Set(Object.keys(syncGroups))];
            uniqueSyncKeys.forEach(syncKey => {
                const masterEl = syncKey === 'nama_produk'
                    ? document.querySelector('.sync-input[data-sync="nama_produk"][data-sync-master="1"]')
                    : document.querySelector(`.sync-input[data-sync="${syncKey}"]`);
                if (masterEl && masterEl.value.trim()) {
                    syncGroups[syncKey].forEach(input => { input.value = masterEl.value; });
                }
            });

            // ===========================================
            // FORM SUBMIT: Pastikan semua base64 & tabel
            // ter-serialize ke hidden input sebelum export
            // ===========================================
            const qfomilForm = document.getElementById('qfomilTemplateForm');
            if (qfomilForm) {
                qfomilForm.addEventListener('submit', function() {
                    showExportModal();
                    document.querySelectorAll('.mixing-table-item').forEach(tableItem => {
                        const tableUid = getTableUidFromItem(tableItem);
                        if (!tableUid) return;

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

                const pastedTableInput = tableItem.querySelector(
                    `input[name="mixing_pasted_table_json[${escapeNameForSelector(tableUid)}]"]`);
                if (pastedTableInput && pastedTableInput.value) {
                    try {
                        const rows = JSON.parse(pastedTableInput.value);
                        if (Array.isArray(rows) && rows.length) renderPastedTablePreview(tableItem, rows);
                    } catch (e) { /* abaikan parse error */ }
                }

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

        // ==============================================
        // SYNC NAMA PRODUK — berjalan langsung (global)
        // Menangani kasus DOMContentLoaded sudah fired
        // ==============================================
        (function initSyncNamaProduk() {
            function doSync() {
                const allSyncInputs = document.querySelectorAll('.sync-input');
                if (!allSyncInputs.length) return;

                const groups = {};
                allSyncInputs.forEach(input => {
                    const key = input.dataset.sync;
                    if (!key) return;
                    if (!groups[key]) groups[key] = [];
                    groups[key].push(input);
                });

                Object.keys(groups).forEach(key => {
                    const group = groups[key];
                    group.forEach(input => {
                        // Hindari duplikat listener
                        if (input._syncBound) return;
                        input._syncBound = true;
                        input.addEventListener('input', function() {
                            const value = this.value;
                            group.forEach(other => {
                                if (other !== this) other.value = value;
                            });
                        });
                    });
                });

                // Inisialisasi nilai awal dari master
                Object.keys(groups).forEach(key => {
                    const masterEl = key === 'nama_produk'
                        ? document.querySelector('.sync-input[data-sync="nama_produk"][data-sync-master="1"]')
                        : groups[key][0];
                    if (masterEl && masterEl.value.trim()) {
                        groups[key].forEach(inp => { inp.value = masterEl.value; });
                    }
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', doSync);
            } else {
                doSync(); // DOM sudah siap
            }
        })();

        function showExportModal() {
            const token = 'exp_' + Date.now();
            let tokenInput = document.getElementById('export_token_input');
            if (!tokenInput) {
                tokenInput = document.createElement('input');
                tokenInput.type = 'hidden';
                tokenInput.name = 'export_token';
                tokenInput.id = 'export_token_input';
                document.getElementById('qfomilTemplateForm').appendChild(tokenInput);
            }
            tokenInput.value = token;

            document.cookie = 'export_done=; Max-Age=0; path=/';
            document.getElementById('exportLoadingModal').classList.remove('hidden');

            const startTime = Date.now();
            const minDisplayTime = 1500; // Minimum 1.5 detik

            const poll = setInterval(function () {
                if (document.cookie.split(';').some(c => c.trim().startsWith('export_done=' + token))) {
                    const elapsedTime = Date.now() - startTime;
                    const remainingTime = Math.max(0, minDisplayTime - elapsedTime);
                    
                    setTimeout(function() {
                        clearInterval(poll);
                        document.cookie = 'export_done=; Max-Age=0; path=/';
                        document.getElementById('exportLoadingModal').classList.add('hidden');
                        showExportSuccessModal();
                    }, remainingTime);
                }
            }, 500);
        }

        function showExportSuccessModal() {
            const modal = document.getElementById('exportSuccessModal');
            modal.classList.remove('hidden');
            setTimeout(function() {
                modal.classList.add('hidden');
            }, 3000);
        }

        // Pasang form submit listener secara independen
        // agar tidak terpengaruh error di blok DOMContentLoaded lain
        (function() {
            function attachExportListener() {
                const form = document.getElementById('qfomilTemplateForm');
                if (form && !form._exportListenerAttached) {
                    form._exportListenerAttached = true;
                    form.addEventListener('submit', function() {
                        showExportModal();
                    });
                }
            }
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', attachExportListener);
            } else {
                attachExportListener();
            }
        })();
    </script>

    {{-- Export Loading Modal --}}
    <div id="exportLoadingModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl px-10 py-8 flex flex-col items-center gap-4 min-w-[320px]">
            <div class="w-16 h-16 rounded-full border-4 border-slate-300 dark:border-slate-600 border-t-red-500 dark:border-t-red-400 animate-spin"></div>
            <div class="text-center">
                <p class="text-slate-900 dark:text-white font-bold text-lg">Memproses Export</p>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Mohon tunggu, dokumen sedang dibuat...</p>
            </div>
            <div class="w-full flex items-center gap-3 bg-slate-100 dark:bg-slate-700/60 rounded-xl px-4 py-3">
                <span class="material-symbols-outlined text-red-500 dark:text-red-400 text-[22px]">description</span>
                <span class="text-slate-400 dark:text-slate-400 text-sm">Menghasilkan dokumen Word</span>
            </div>
        </div>
    </div>

    {{-- Export Success Modal --}}
    <div id="exportSuccessModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl px-10 py-8 flex flex-col items-center gap-4 min-w-[320px]">
            <div class="w-16 h-16 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                <span class="material-symbols-outlined text-green-500 dark:text-green-400 text-[40px]">check_circle</span>
            </div>
            <div class="text-center">
                <p class="text-slate-900 dark:text-white font-bold text-lg">Export Berhasil!</p>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Dokumen Word berhasil diunduh.</p>
            </div>
        </div>
    </div>

     {{-- ============================================================
         SYNC INPUT SCRIPT — script terpisah & independen
         Berjalan terlepas dari error apapun di script utama.
         Saat satu field nama produk diubah, semua field lain ikut.
         ============================================================ --}}
    <script>
        (function() {
            // Listener input: saat salah satu sync-input diubah, semua group yang sama ikut
            document.addEventListener('input', function(e) {
                var el = e.target;
                if (!el || !el.classList.contains('sync-input')) return;
                var key = el.getAttribute('data-sync');
                if (!key) return;
                var val = el.value;
                var others = document.querySelectorAll('.sync-input[data-sync="' + key + '"]');
                for (var i = 0; i < others.length; i++) {
                    if (others[i] !== el) others[i].value = val;
                }
            });

            // Saat halaman siap: sebarkan nilai dari field master ke semua follower
            function spreadMasterValues() {
                var keys = [];
                var inputs = document.querySelectorAll('.sync-input[data-sync]');
                for (var i = 0; i < inputs.length; i++) {
                    var k = inputs[i].getAttribute('data-sync');
                    if (k && keys.indexOf(k) === -1) keys.push(k);
                }
                for (var j = 0; j < keys.length; j++) {
                    var key = keys[j];
                    var master = (key === 'nama_produk')
                        ? document.querySelector('.sync-input[data-sync="nama_produk"][data-sync-master="1"]')
                        : document.querySelector('.sync-input[data-sync="' + key + '"]');
                    if (!master || !master.value.trim()) continue;
                    var followers = document.querySelectorAll('.sync-input[data-sync="' + key + '"]');
                    for (var k2 = 0; k2 < followers.length; k2++) {
                        followers[k2].value = master.value;
                    }
                }
            }

            // Jalankan setelah DOM siap + delay kecil untuk subab dinamis
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() { setTimeout(spreadMasterValues, 300); });
            } else {
                setTimeout(spreadMasterValues, 300);
            }
        })();
    </script>
@endsection


