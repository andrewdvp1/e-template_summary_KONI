@extends('layouts.app')

@section('content')
    <form action="{{ route('template-summary.zingiberis.export') }}" method="POST" id="zingiberisTemplateForm"
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
                            <input type="text" name="judul_nama_produk" class="template-input sync-input w-128 uppercase"
                                data-sync="nama_produk" data-sync-master="1" placeholder="ZINGIBERIS OFFICINALIS POWDER EXTRACT 2:1 (ZOS-32) HOF">
                           
                        </p>
                        <p class="font-bold text-center text-base mb-4">
                            BAGIAN
                            <input type="text" name="judul_bagian" class="template-input sync-input w-128 uppercase"
                            data-sync="bagian" value="Production Natpro & Extraction Bangunan IOT Natpro"
                                placeholder="Production Natpro & Extraction Bangunan IOT Natpro">
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
                                <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                    data-sync="nama_produk" placeholder="Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF">
                                di Lini
                                <input type="text" name="tujuan_line" class="template-input sync-input w-40"
                                    data-sync="line" value="Ekstraksi" placeholder="Ekstraksi">
                                Bagian
                                <input type="text" name="tujuan_bagian" class="template-input sync-input w-128"
                                    data-sync="bagian" value="Production Natpro & Extraction"
                                    placeholder="Production Natpro & Extraction">
                                dalam menghasilkan produk yang memenuhi persyaratan mutu yang tercantum dalam Spesifikasi Produk Ekstrak yang berlaku.
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
                                <input type="text" name="batch_besaran" class="template-input w-35"
                                    placeholder="DEC25A07"> 
                                dengan besaran
                                <input type="text" name="batch_bahan" class="template-input w-56"
                                    placeholder="Rimpang Jahe Segar"> 
                                sebesar
                                 <input type="text" name="berat_biomassa_bab1" class="template-input w-24"
                                    placeholder="501.19">
                                kg
                                (<input type="text" name="batch_bahan" class="template-input w-76"
                                    placeholder="Besaran Rimpang Jahe Segar">
                                yang diproses pada batch
                                <input type="text" name="batch_besaran" class="template-input w-35"
                                    placeholder="DEC25A07">)
  
                            </p>
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
                    <input type="hidden" name="bab2_enabled_sections" id="bab2_enabled_sections" value="1,2">

                    {{-- 2.1 --}}
                    <div class="bab2-section" data-section-id="1">
                        <div class="bab2-section-content text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify transition-opacity duration-200">
                            <p class="pl-8 -indent-8">
                                <span class="bab2-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                    onclick="toggleBab2Section(this)" title="Klik untuk disable/enable">2.1.</span> 
                            Seluruh tahapan pengolahan  
                             <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                    data-sync="nama_produk" placeholder=" Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF">
                            yaitu 
                             <input type="text" name="pencampuran_tahapan" class="template-input w-128"
                                    placeholder="ekstraksi, evaporasi, sterilisasi, granulasi, dan pengemasan">
                            telah dilakukan sesuai dengan MBR Proses
                            <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                    data-sync="nama_produk" placeholder=" Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF">,
                            No. Dokumen
                                <input type="text" name="pencampuran_no_dokumen" class="template-input sync-input w-53"
                                    data-sync="no_dokumen" placeholder="CG-00087-04-PC">,
                            tanggal
                                <input type="text" name="pencampuran_tanggal_dokumen" class="template-input sync-input w-53"
                                    data-sync="tanggal_dokumen" placeholder="29-09-2025">,
                            MBR Pengemasan
                            <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                    data-sync="nama_produk" placeholder=" Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF">,
                            <input type="text" name="pencampuran_tempat" class="template-input w-56"
                                    placeholder="Fiber Drum">
                            No. Dokumen
                                <input type="text" name="pencampuran_no_dokumen" class="template-input sync-input w-53"
                                    data-sync="no_dokumen" placeholder=" CG-00090-01-NL">,
                            tanggal
                                <input type="text" name="pencampuran_tanggal_dokumen" class="template-input sync-input w-53"
                                    data-sync="tanggal_dokumen" placeholder="05-07-2023">
                           </p>
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
                          Hasil pemeriksaan sampel pada masing-masing tahapan adalah sebagai berikut:
                        </h3>
                        <div class="bab2-section-content transition-opacity duration-200">

                            {{-- 2.3.1 Tahap Ekstraksi --}}
                            <div class="ml-4 mb-6 p-4 bg-slate-50 dark:bg-slate-900/30 rounded-lg border border-slate-200 dark:border-slate-700">
                                <h4 class="font-semibold text-slate-700 dark:text-slate-300 mb-4">2.3.1 Tahap Ekstraksi</h4>

                                {{-- 2.3.1.1 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.1.1</span>
                                        Tahap ekstraksi produk
                                         <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                        data-sync="nama_produk" placeholder=" Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF">
                                        batch
                                        <input type="text" name="batch_name" class="template-input sync-input w-35" 
                                        data-sync="batch" placeholder="DEC25A07">
                                        menggunakan
                                        @php
                                            $stageEkstraksi = $stages->first(fn($s) => str_contains(strtolower($s->name), 'ekstr'));
                                        @endphp
                                        <select name="tujuan_mesin" class="template-input sync-input w-64" data-sync="mesin">
                                            <option value="">-- Pilih Mesin Ekstraksi --</option>
                                            @if($stageEkstraksi)
                                                @foreach($stageEkstraksi->machines as $machine)
                                                    <option value="{{ $machine->name }}"
                                                        {{ (old('tujuan_mesin', $draft?->payload['form_values']['tujuan_mesin'] ?? '') === $machine->name) ? 'selected' : '' }}>
                                                        {{ $machine->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        dengan bobot Biomassa hasil preproses parut yang diekstraksi sebesar 
                                        <input type="text" name="berat_biomassa" class="template-input w-24"
                                        placeholder="109.65">
                                        kg

                                    </p>
                                </div>

                                {{-- 2.3.1.2 --}}
                                <div class="ml-4 mb-4">
                                    <p 
                                    class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.1.2</span>
                                        Proses ekstraksi dengan
                                        <select name="tujuan_mesin_ekstraksi_2" class="template-input w-64">
                                            <option value="">-- Pilih Mesin Ekstraksi --</option>
                                            @if($stageEkstraksi ?? $stages->first(fn($s) => str_contains(strtolower($s->name), 'ekstr')))
                                                @foreach(($stageEkstraksi ?? $stages->first(fn($s) => str_contains(strtolower($s->name), 'ekstr')))->machines as $machine)
                                                    <option value="{{ $machine->name }}"
                                                        {{ (old('tujuan_mesin_ekstraksi_2', $draft?->payload['form_values']['tujuan_mesin_ekstraksi_2'] ?? '') === $machine->name) ? 'selected' : '' }}>
                                                        {{ $machine->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        dilakukan selama
                                        <input type="text" name="pencampuran_waktu" class="template-input w-24"
                                        placeholder="90">
                                        menit setelah suhu tercapai
                                        <input type="text" name="pencampuran_suhu" class="template-input w-24"
                                        placeholder="70">°C.
                                

                                    </p>
                                   
                                </div>

                                {{-- 2.3.1.3 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.1.3</span>
                                        Pengambilan sampel dilakukan setelah proses pencampuran antara miscella hasil preproses partu dan hasil ekstraksi biomassa. 
                                        Dengan hasil akhir sebesar 
                                        <input type="text" name="berat_hasil_ekstraksi" class="template-input w-24"
                                        placeholder="599.81">
                                        kg
                                    </p>
                                </div>

                                {{-- 2.3.1.4 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.1.4</span>
                                        <input type="text" name="ipc_jenis_ekstraksi" 
                                        class="template-input w-76 mt-1" value="Pemerian dan bobot tetap pada">
                                        produk antara hasil ekstraksi bukan merupakan syarat release QC (spesifikasi pemeriksaan rutin),
                                        tetapi merupakan monitoring in proces control (IPC) pada akhir proses ekstraksi
                                        sehingga tetap dilakukan pemeriksaan tetapi hanya digunakan sebagai pendataan seperti yang tercantum pada MBR Proses
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                        data-sync="nama_produk" placeholder=" Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF">
                                        No. Dokumen
                                        <input type="text" name="pencampuran_no_dokumen" class="template-input sync-input w-53"
                                        data-sync="no_dokumen" placeholder="CG-00087-04-PC">,
                                        tanggal
                                        <input type="text" name="pencampuran_tanggal_dokumen" class="template-input sync-input w-53"
                                        data-sync="tanggal_dokumen" placeholder="29-09-2025">
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
                                </div>  
                            </div>

                            {{-- 2.3.1.5 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.1.5</span>
                                        Dilakukan pengambilan sampel ketika proses ekstraksi telah selesai dengan hasil sebagai berikut:
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
                                </div>  
                            
                            {{-- 2.3.1.6 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.1.6</span>
                                        Hasil
                                        <input type="text" name="hasil_jenis_ekstraksi" 
                                        class="template-input w-86 mt-1" value="pemeriksaan pemerian dan bobot tetap">
                                        seluruh sampel produk antara hasil ekstraksi dari batch
                                        <input type="text" name="batch_besaran_2362" 
                                        class="template-input w-35" placeholder="DEC25A07">
                                        telah memenuhi syarat spesifikasi IPC.
                                    </p>
                                </div>



                            {{-- 2.3.2 Tahap Evaporasi --}}
                            <div class="ml-4 mb-0 p-4 bg-slate-50 dark:bg-slate-900/30 rounded-lg border border-slate-200 dark:border-slate-700">
                                <h4 class="font-semibold text-slate-700 dark:text-slate-300 mb-4">2.3.2 Tahap Evaporasi</h4>

                                {{-- 2.3.2.1 --}}
                                <div class="ml-4 mb-4 subsec-232" data-subsec-id="1">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold subsec-232-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleSubsec232(this)" title="Klik untuk disable/enable">2.3.2.1</span>
                                        Tahap evaporasi untuk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                        data-sync="nama_produk" placeholder="Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF">
                                        batch
                                        <input type="text" name="batch_besaran_2362" 
                                        class="template-input w-35" placeholder=" DEC25A07">
                                        dilakukan menggunakan
                                        @php
                                            $stageEvaporasi = $stages->first(fn($s) => str_contains(strtolower($s->name), 'evapo'));
                                        @endphp
                                        <select name="tujuan_mesin_evaporasi" class="template-input w-64">
                                            <option value="">-- Pilih Mesin Evaporasi --</option>
                                            @if($stageEvaporasi)
                                                @foreach($stageEvaporasi->machines as $machine)
                                                    <option value="{{ $machine->name }}"
                                                        {{ (old('tujuan_mesin_evaporasi', $draft?->payload['form_values']['tujuan_mesin_evaporasi'] ?? '') === $machine->name) ? 'selected' : '' }}>
                                                        {{ $machine->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        
                                    </p>
                                </div>

                                {{-- 2.3.2.2 --}}
                                <div class="ml-4 mb-4 subsec-232" data-subsec-id="2">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold subsec-232-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleSubsec232(this)" title="Klik untuk disable/enable">2.3.2.2</span>
                                        Proses evaporasi dengan
                                        <select name="tujuan_mesin_evaporasi_2" class="template-input w-64">
                                            <option value="">-- Pilih Mesin Evaporasi --</option>
                                            @foreach(($stageEvaporasi ?? $stages->first(fn($s) => str_contains(strtolower($s->name), 'evapo')))?->machines ?? [] as $machine)
                                                <option value="{{ $machine->name }}"
                                                    {{ (old('tujuan_mesin_evaporasi_2', $draft?->payload['form_values']['tujuan_mesin_evaporasi_2'] ?? '') === $machine->name) ? 'selected' : '' }}>
                                                    {{ $machine->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        dilakukan dengan parameter
                                        <input type="text" name="pencampuran_parameter" 
                                        class="template-input w-full" placeholder="flowrate 4 m3/h, suhu preheating 70°C, suhu heating 80°C, dan tekanan vakum -0.750 bar">. 
                                        Dengan hasil akhir tahap evaporasi sebesar
                                        <input type="text" name="berat_hasil_evaporasi" class="template-input w-24"
                                        placeholder=" 223.9"> kg
                                    </p>
                                    
                                </div>

                                {{-- 2.3.2.3 --}}
                                <div class="ml-4 mb-4 subsec-232" data-subsec-id="3">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold subsec-232-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleSubsec232(this)" title="Klik untuk disable/enable">2.3.2.3</span>
                                         <input type="text" name="ipc_jenis_evaporasi" 
                                        class="template-input w-76 mt-1" value="Pemerian dan bobot tetap">
                                        pada produk antara hasil evaporasi bukan merupakan syarat release QC (spesifikasi pemeriksaan rutin),
                                        tetapi merupakan monitoring in proces control (IPC) pada akhir proses evaporasi 
                                        ehingga tetap dilakukan pemeriksaan tetapi hanya digunakan sebagai pendataan seperti yang tercantum pada MBR Proses
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                        data-sync="nama_produk" placeholder="Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF">
                                        No. Dokumen
                                        <input type="text" name="pencampuran_no_dokumen" class="template-input sync-input w-53"
                                        data-sync="no_dokumen" placeholder="CG-00087-04-PC">,
                                        tanggal
                                        <input type="text" name="pencampuran_tanggal_dokumen" class="template-input sync-input w-53"
                                        data-sync="tanggal_dokumen" placeholder=" 29-09-2025">. 
                                        
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

                                {{-- 2.3.2.4 --}}
                                <div class="ml-4 mb-4 subsec-232" data-subsec-id="4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold subsec-232-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleSubsec232(this)" title="Klik untuk disable/enable">2.3.2.4</span>
                                       Dilakukan pengambilan sampel  ketika proses evaporasi selesai dengan hasil sebagai berikut:
                                        
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

                                {{-- 2.3.2.5 --}}
                                <div class="ml-4 mb-4 subsec-232" data-subsec-id="5">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold subsec-232-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleSubsec232(this)" title="Klik untuk disable/enable">2.3.2.5</span>
                                        Hasil akhir evaporasi dari batch
                                        <input type="text" name="batch_besaran_2362" 
                                        class="template-input w-35" placeholder=" DEC25A07">
                                        akan digranulasi dengan
                                        @php
                                            $stageGranulasi = $stages->first(fn($s) => str_contains(strtolower($s->name), 'granul'));
                                        @endphp
                                        <select name="tujuan_mesin_granulasi" class="template-input w-64">
                                            <option value="">-- Pilih Mesin Granulasi --</option>
                                            @if($stageGranulasi)
                                                @foreach($stageGranulasi->machines as $machine)
                                                    <option value="{{ $machine->name }}"
                                                        {{ (old('tujuan_mesin_granulasi', $draft?->payload['form_values']['tujuan_mesin_granulasi'] ?? '') === $machine->name) ? 'selected' : '' }}>
                                                        {{ $machine->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        sehingga digunakan syarat
                                        <input type="text" name="pencampuran_syarat_evaporasi" 
                                        class="template-input w-34" placeholder="15-20%">
                                        
                                    </p>
                                </div>

                            

                            {{-- 2.3.2.6” di luar kotak sesuai permintaan --}}
                            <div class="ml-4 mt-4 mb-4 subsec-232" data-subsec-id="6">
                                <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                    <span class="font-semibold subsec-232-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleSubsec232(this)" title="Klik untuk disable/enable">2.3.2.6</span>
                                    Hasil pemeriksaan
                                    <input type="text" name="hasil_pemerian_evaporasi" 
                                        class="template-input w-56 mt-1" value="pemerian">
                                    seluruh sampel produk antara hasil evaporasi dari batch
                                    <input type="text" name="batch_besaran_2362" 
                                        class="template-input w-35" placeholder="DEC25A07">
                                    <input type="text" name="hasil_ipc_evaporasi_1" class="template-input w-36" 
                                    value="" placeholder="telah memenuhi">
                                    syarat spesifikasi IPC.
                                    
                                </p>
                                
                                </div>
                             {{-- 2.3.2.7 â€” di luar kotak sesuai permintaan --}}
                            <div class="ml-4 mt-4 mb-4 subsec-232" data-subsec-id="6">
                                <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                    <span class="font-semibold subsec-232-number cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors" onclick="toggleSubsec232(this)" title="Klik untuk disable/enable">2.3.2.7</span>
                                    Hasil pemeriksaan
                                    <input type="text" name="hasil_bobot_tetap_evaporasi" 
                                        class="template-input w-56 mt-1" value="bobot tetap">
                                    seluruh sampel produk antara hasil evaporasi dari batch
                                    <input type="text" name="batch_besaran_2362" 
                                        class="template-input w-35" placeholder="DEC25A07">
                                    <input type="text" name="hasil_ipc_evaporasi_2" class="template-input w-36" 
                                    value="" placeholder="tidak memenuhi">
                                    syarat spesifikasi IPC yaitu 
                                    <input type="text" name="pencampuran_syarat_evaporasi" 
                                        class="template-input w-34" placeholder="15-20%">
                                </p>
                                </div>
                                
                            </div>{{-- end subsec-232 2.3.2.7 --}}
                            </div>{{-- end box 2.3.2 --}}

                            {{-- 2.3.3 Tahap Sterilisasi --}}
                            <div class="ml-4 mb-6 p-4 bg-slate-50 dark:bg-slate-900/30 rounded-lg border border-slate-200 dark:border-slate-700">
                                <h4 class="font-semibold text-slate-700 dark:text-slate-300 mb-4">2.3.3 Tahap Sterilisasi</h4>

                                {{-- 2.3.3.1 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.3.1</span>
                                        Tahap sterilisasi untuk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                        data-sync="nama_produk" placeholder="Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF">
                                        batch
                                        <input type="text" name="batch_besaran" class="template-input w-35"
                                        placeholder="DEC25A07">
                                        dengan menggunakan mesin
                                        @php
                                            $stageSterilisasi = $stages->first(fn($s) => str_contains(strtolower($s->name), 'steril'));
                                        @endphp
                                        <select name="tujuan_mesin_sterilisasi" class="template-input w-64">
                                            <option value="">-- Pilih Mesin Sterilisasi --</option>
                                            @if($stageSterilisasi)
                                                @foreach($stageSterilisasi->machines as $machine)
                                                    <option value="{{ $machine->name }}"
                                                        {{ (old('tujuan_mesin_sterilisasi', $draft?->payload['form_values']['tujuan_mesin_sterilisasi'] ?? '') === $machine->name) ? 'selected' : '' }}>
                                                        {{ $machine->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        
                                    </p>
                                </div>

                                {{-- 2.3.3.2 --}}
                                <div class="ml-4 mb-4">
                                    <p 
                                    
                                    class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.3.2</span>
                                        Proses sterilisasi dengan
                                        <select name="tujuan_mesin_sterilisasi_2" class="template-input w-64">
                                            <option value="">-- Pilih Mesin Sterilisasi --</option>
                                            @foreach(($stageSterilisasi ?? $stages->first(fn($s) => str_contains(strtolower($s->name), 'steril')))?->machines ?? [] as $machine)
                                                <option value="{{ $machine->name }}"
                                                    {{ (old('tujuan_mesin_sterilisasi_2', $draft?->payload['form_values']['tujuan_mesin_sterilisasi_2'] ?? '') === $machine->name) ? 'selected' : '' }}>
                                                    {{ $machine->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        dilakukan dengan parameter
                                        <input type="text" name="parameter_sterilisasi" 
                                        class="template-input w-86" placeholder="sirkulasi selama 14 menit pada suhu  85°C">. 
                                        Dengan hasil akhir tahap sterilisasi sebesar
                                        <input type="text" name="berat_hasil_sterilisasi" class="template-input w-24"
                                        placeholder=" 223.7">
                                        kg

                                    </p>
                                    
                                </div>

                                {{-- 2.3.3.3 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.3.3</span>
                                        Pemeriksaan
                                        <input type="text" name="param_kemas_344" class="template-input w-36"
                                        value="cemaran mikroba" placeholder="cemaran mikroba">
                                        pada produk antara hasil sterilisasi
                                        bukan merupakan syarat release QC (spesifikasi pemeriksaan rutin),
                                        tetapi hanya digunakan sebagai pendataan.
                            
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

                                {{-- 2.3.3.4 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.3.4</span>
                                        Dilakukan pengambilan sampel yang mewakili
                                         <input type="text" name="pencampuran_sampling_waktu" class="template-input w-52" placeholder="atas, tengah, dan bawah">,
                                        dari vat/kontainer dengan hasil sebagai berikut:
                                        
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

                                {{-- 2.3.3.5 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.3.5</span>
                                    Hasil pemeriksaan
                                    <input type="text" name="param_kemas_344" class="template-input w-56"
                                        value="cemaran mikroba"
                                        placeholder="cemaran mikroba">
                                    seluruh sampel produk antara hasil sterilisasi dari batch
                                    <input type="text" name="batch_besaran" class="template-input w-35"
                                        placeholder="DEC25A07">
                                    <input type="text" name="hasil_sterilisasi" class="template-input w-36" 
                                    value="" placeholder="telah memenuhi">
                                    kriteria penerimaan yang berlaku.
                                    
                                    </p>
                                </div>

                            
                                {{-- 2.3.4 Tahap Granulasi --}}
                            <div class="ml-4 mb-6 p-4 bg-slate-50 dark:bg-slate-900/30 rounded-lg border border-slate-200 dark:border-slate-700">
                                <h4 class="font-semibold text-slate-700 dark:text-slate-300 mb-4">2.3.4 Tahap Granulasi</h4>

                                {{-- 2.3.4.1 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.4.1</span>
                                        Ekstrak hasil sterilisasi dari batch
                                        <input type="text" name="batch_besaran" class="template-input w-35"
                                        placeholder="DEC25A07">
                                        sebesar
                                        <input type="text" name="berat_ekstrak_granulasi" class="template-input w-24"
                                        placeholder="223.75">
                                        kg diproses mixing dengan pengisi 
                                        <input type="text" name="bahan_pengisi_granulasi" class="template-input w-36"
                                        placeholder="maltodextrine">
                                        sebesar
                                        <input type="text" name="berat_pengisi_granulasi" class="template-input w-24"
                                        placeholder="223.75"> 
                                        kg dengan
                                        @php
                                            $stageMixing = $stages->first(fn($s) => str_contains(strtolower($s->name), 'mix'));
                                        @endphp
                                        <select name="tujuan_mesin_mixing" class="template-input w-64">
                                            <option value="">-- Pilih Mesin Mixing --</option>
                                            @if($stageMixing)
                                                @foreach($stageMixing->machines as $machine)
                                                    <option value="{{ $machine->name }}"
                                                        {{ (old('tujuan_mesin_mixing', $draft?->payload['form_values']['tujuan_mesin_mixing'] ?? '') === $machine->name) ? 'selected' : '' }}>
                                                        {{ $machine->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        
                                        
                                    </p>
                                </div>

                                {{-- 2.3.4.2 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.4.2</span>
                                        Campuran antara pengisi dan ekstrak diproses granulasi dan pengeringan menggunakan
                                        <select name="tujuan_mesin_granulasi_2" class="template-input w-64">
                                            <option value="">-- Pilih Mesin Granulasi --</option>
                                            @foreach(($stageGranulasi ?? $stages->first(fn($s) => str_contains(strtolower($s->name), 'granul')))?->machines ?? [] as $machine)
                                                <option value="{{ $machine->name }}"
                                                    {{ (old('tujuan_mesin_granulasi_2', $draft?->payload['form_values']['tujuan_mesin_granulasi_2'] ?? '') === $machine->name) ? 'selected' : '' }}>
                                                    {{ $machine->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </p>
                                </div>

                                {{-- 2.3.4.3 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.4.3</span>
                                        Hasil granulasi kemudian diproses pengecilan ukuran granul menggunakan
                                        @php
                                            $stagePengecilan = $stages->first(fn($s) => str_contains(strtolower($s->name), 'pengecil') || str_contains(strtolower($s->name), 'grind') || str_contains(strtolower($s->name), 'mill'));
                                        @endphp
                                        <select name="tujuan_mesin_pengecilan" class="template-input w-64">
                                            <option value="">-- Pilih Mesin Pengecilan Ukuran --</option>
                                            @if($stagePengecilan)
                                                @foreach($stagePengecilan->machines as $machine)
                                                    <option value="{{ $machine->name }}"
                                                        {{ (old('tujuan_mesin_pengecilan', $draft?->payload['form_values']['tujuan_mesin_pengecilan'] ?? '') === $machine->name) ? 'selected' : '' }}>
                                                        {{ $machine->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        Screen 
                                        <input type="text" name="kapsulasi_sampling_titik" class="template-input w-12" placeholder="24">. 
                                        Dengan hasil akhir ekstrak kering sebesar
                                        <input type="text" name="berat_ekstrak_kering" class="template-input w-24"
                                        placeholder="232.78">kg
                                    </p>

                                </div>

                                {{-- 2.3.4.4 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.4.4</span>
                                        Spesifikasi Produk
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                        data-sync="nama_produk" placeholder="Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF"> 
                                        batch
                                        <input type="text" name="batch_besaran" class="template-input w-35"
                                        placeholder="DEC25A07">
                                        sesuai dengan yang tercantum pada Spesifikasi
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                        data-sync="nama_produk" placeholder="Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF"> 
                                        No. Dokumen
                                        <input type="text" name="pencampuran_no_dokumen" class="template-input sync-input w-53"
                                        data-sync="no_dokumen" placeholder="SX-F03-3-00018-02">,
                                        tanggal
                                        <input type="text" name="pencampuran_tanggal_dokumen" class="template-input sync-input w-53"
                                        data-sync="tanggal_dokumen" placeholder="09-08-2024 ">
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

                                {{-- 2.3.4.5 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.4.5</span>
                                        Pada tahap akhir pengecilan ukuran granul dilakukan sampling sebanyak
                                        <input type="text" name="kapsulasi_sampling_titik" class="template-input w-12" placeholder="3">
                                        lokasi yang mewakili lokasi
                                         <input type="text" name="pencampuran_sampling_waktu" class="template-input w-52" placeholder="atas, tengah, dan bawah">
                                        dari wadah pengemas ekstrak. Kemudian dilakukan pemeriksaan
                                        <input type="text" name="pencampuran_sampling_waktu_235" class="template-input w-180" placeholder="pemerian, kadar air, kadar logam berat, dan pemeriksaan batas mikroba">
                                        dengan hasil sebagai berikut:

                                    </p>

                                </div>
                                    
                                {{-- 2.3.4.5.1 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.4.5.1</span>
                                        Tabel hasil pemeriksaan 
                                        <input type="text" name="pem_granulasi_1" 
                                        class="template-input w-72 mt-1" value="pemerian dan kadar air">
                                        pada tahap akhir granulasi:
                                        
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

                                {{-- 2.3.4.5.2 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.4.5.2</span>
                                        Tabel hasil pemeriksaan 
                                        <input type="text" name="pem_granulasi_2" 
                                        class="template-input w-96 mt-1" value="ukuran partikel dan cemaran logam berat">
                                        
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


                                {{-- 2.3.4.5.3 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.4.5.3</span>
                                        Tabel hasil pemeriksaan 
                                        <input type="text" name="pem_granulasi_3" 
                                        class="template-input w-72 mt-1" value="cemaran mikrobiologi">
                                         pada tahap granulasi akhir
                                    
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



                                {{-- 2.3.4.6 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.4.6</span>
                                        Secara keseluruhan, atribut yang diuji pada tahap akhir granulasi sudah memberikan hasil yang
                                        <input type="text" name="mixing_hasil" class="template-input w-32" value=""
                                        placeholder="memenuhi">
                                        persyaratan menurut spesifikasi ekstrak yang berlaku.
                                        
                                    </p>
                                    
                                </div>

                            </div>
                         {{-- 2.3.5 Tahap Pengemasan --}}
                            <div class="ml-4 mb-6 p-4 bg-slate-50 dark:bg-slate-900/30 rounded-lg border border-slate-200 dark:border-slate-700">
                                <h4 class="font-semibold text-slate-700 dark:text-slate-300 mb-4">2.3.4 Tahap Granulasi</h4>

                                 {{-- 2.3.5.1 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.5.1</span>
                                        Hasil pengolahan
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                        data-sync="nama_produk" placeholder="Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF">
                                        batch
                                        <input type="text" name="batch_besaran" class="template-input w-35"
                                        placeholder="DEC25A07">
                                        dikemas dalam kemasan
                                        <input type="text" name="pencampuran_kemasan" class="template-input w-56"
                                        placeholder="Fiber Drum">. 
                                        
                                    </p>
                                </div>

                                {{-- 2.3.5.2 --}}
                                <div class="ml-4 mb-4">
                                    <p 
                                    
                                    class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.5.2</span>
                                        <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                        data-sync="nama_produk" placeholder="Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF">
                                        batch
                                        <input type="text" name="batch_besaran" class="template-input w-35"
                                        placeholder="DEC25A07">
                                        yang dikemas dalam kemasan primer
                                        <input type="text" name="pencampuran_kemasan" class="template-input w-35"
                                        placeholder="plastik">
                                        dengan kemasan sekunder 
                                        <input type="text" name="pencampuran_kemasan" class="template-input w-56"
                                        placeholder="Fiber Drum">
                                        adalah sebanyak
                                        <input type="text" name="kapsulasi_sampling_titik" class="template-input w-12" placeholder="9">
                                        wadah, dengan masing-masing memiliki bobot
                                        <input type="text" name="berat_kemasan_satuan" class="template-input w-24"
                                        placeholder="25">
                                        kg
                                    </p>
                                    
                                </div>
                                    {{-- 2.3.5.3 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.5.3</span>
                                        Dengan hasil pemeriksaan hasil kemas
                                        <input type="text" name="pencampuran_kemasan" class="template-input w-56"
                                        placeholder="Fiber Drum">
                                        sebagai berikut: 
                                        
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

                                {{-- 2.3.5.4 --}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.3.5.4</span>
                                        Secara keseluruhan, atribut yang diuji pada tahap pengemasan sudah memberikan hasil yang
                                        <input type="text" name="hasil_granulasi" class="template-input w-36" 
                                        value="" placeholder="memenuhi">
                                        persyaratan menurut spesifikasi ekstrak yang berlaku.
                                    </p>
                                </div>

                            </div>

                        </div>{{-- end bab2-section-content 2.3 --}}
                    </div>{{-- end bab2-section 2.3 --}}

                    {{-- 2.4 CATATAN --}}
                            <div class="ml-4 mb-6 p-4 bg-slate-50 dark:bg-slate-900/30 rounded-lg border border-slate-200 dark:border-slate-700">
                                <h4 class="font-semibold text-slate-700 dark:text-slate-300 mb-4">2.4 CATATAN</h4>
                                {{-- 2.4.1--}}
                                <div class="ml-4 mb-4">
                                    <p class="text-base text-slate-700 dark:text-slate-300 mb-2">
                                        <span class="font-semibold">2.4.1</span>
                                        <textarea 
                                        name="pencampuran_catatan" rows="3" class="template-input w-full resize-y text-base font-bold" 
                                        placeholder="Tahap evaporasi belum dapat memberikan hasil bobot tetap yang sesuai dengan MBR Proses Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32), no. dokumen CG-00087-04-PC, tanggal 29-09-2025, yaitu 15-20%">
                                        Tahap evaporasi belum dapat memberikan hasil bobot tetap yang sesuai dengan MBR Proses Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32), no. dokumen CG-00087-04-PC, tanggal 29-09-2025, yaitu 15-20%</textarea>
                                    </p>
                                </div>
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
                                Telah dilakukan validasi proses pengolahan produk
                                <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                    data-sync="nama_produk" placeholder="Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF">,
                                yaitu 
                                <input type="text" name="kesimpulan_tahapan" class="template-input sync-input w-128"
                                        data-sync="nama_produk" placeholder="ekstraksi, evaporasi, sterilisasi, granulasi, dan pengemasan">,
                                telah dilakukan sesuai dengan MBR Proses
                                <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                    data-sync="nama_produk" placeholder="Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF">
                                No. Dokumen
                                <input type="text" name="pencampuran_no_dokumen" class="template-input sync-input w-53"
                                    data-sync="no_dokumen" placeholder=" CG-00087-04-PC">, tanggal <input type="text" name="pencampuran_tanggal_dokumen" class="template-input sync-input w-53" data-sync="tanggal_dokumen" placeholder="29-09-2025">,
                                MBR Pengemasan
                                <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                    data-sync="nama_produk" placeholder="Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF">
                                <input type="text" name="kemasan_tempat" class="template-input w-56"
                                    placeholder="Fiber Drum">
                                No. Dokumen
                                <input type="text" name="pencampuran_no_dokumen" class="template-input sync-input w-53"
                                    data-sync="no_dokumen" placeholder=" CG-00090-01-NL">
                                tanggal
                                <input type="text" name="pencampuran_tanggal_dokumen" class="template-input sync-input w-53"
                                    data-sync="tanggal_dokumen" placeholder="05-07-2023">.
                            </p>

                            <div class="kesimpulan-sub-point ml-4" data-sub-point-id="3.1.1">
                                <div class="kesimpulan-content text-base leading-relaxed text-slate-700 dark:text-slate-300 template-text text-justify transition-opacity duration-200">
                                    <div class="flex items-start gap-2">
                                <span class="kesimpulan-sub-number font-bold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                onclick="toggleKesimpulanSubPoint(this)" title="Klik untuk disable/enable">3.1.1</span> 
                                <p 

                                style="text-align:left;">
                               Berdasarkan pemeriksaan batch validasi 
                                <input type="text" name="batch_besaran" class="template-input w-35"
                                    placeholder="(DEC25A07)"> 
                                terhadap parameter mutu produk pada tahap ekstraksi antara lain
                                 <input type="text" name="param_mutu_ekstraksi" 
                                        class="template-input w-96 mt-1" value="pemerian dan bobot tetap">
                                didapatkan hasil pengujian
                                <input type="text" name="kemasan_hasil" class="template-input w-56" 
                                value="" placeholder="telah memenuhi">
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
                                <input type="text" name="batch_besaran" class="template-input w-35"
                                placeholder="(DEC25A07)">
                                terhadap parameter mutu produk pada tahap evaporasi antara lain
                                <input type="text" name="param_mutu_evaporasi" 
                                        class="template-input w-56 mt-1" value="pemerian">
                                didapatkan hasil pengujian
                                <input type="text" name="hasil_311" class="template-input w-56" 
                                value="" placeholder="telah memenuhi">
                                <textarea name="param_penyalutan_313" rows="3" class="template-input w-full resize-y text-base font-bold" 
                                placeholder="Namun belum dapat menghasilkan bobot tetap yang sesuai dengan spesifikasi produk yang berlaku. Pemeriksaan bobot tetap pada hasil akhir evaporasi bukan merupakan syarat rilis produk, melainkan hanya sebagai kontrol dan pendataan. ">
                                Namun belum dapat menghasilkan bobot tetap yang sesuai dengan spesifikasi produk yang berlaku. Pemeriksaan bobot tetap pada hasil akhir evaporasi bukan merupakan syarat rilis produk, melainkan hanya sebagai kontrol dan pendataan. </textarea>

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
                                <input type="text" name="batch_besaran" class="template-input w-35"
                                placeholder="(DEC25A07)">
                                terhadap parameter mutu produk pada tahap sterilisasi antara lain
                                <input type="text" name="param_mutu_sterilisasi" 
                                        class="template-input w-56 mt-1" value="batas mikroba">
                                didapatkan hasil pengujian
                                <input type="text" name="hasil_312" class="template-input w-56" 
                                value="" placeholder="telah memenuhi">
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
                                <input type="text" name="batch_besaran" class="template-input w-35"
                                placeholder="(DEC25A07)">
                                terhadap parameter mutu produk pada tahap akhir granulasi sebagai produk jadi, antara lain
                                 <input type="text" name="param_kemas_314" class="template-input w-150"
                                value="pemerian, kadar air, kadar logam berat, dan cemaran mikroba" placeholder="pemerian, kadar air, kadar logam berat, dan cemaran mikroba">,
                                didapatkan hasil pegujian
                                <input type="text" name="hasil_313" class="template-input w-56" 
                                value="" placeholder="telah memenuhi">
                                spesifikasi produk yang berlaku. 

                                </p>
                                        </div>
                                </div>
                        </div>


                        <div class="kesimpulan-sub-point ml-4" data-sub-point-id="3.1.5">
                                <div class="kesimpulan-content text-base leading-relaxed text-slate-700 dark:text-slate-300 template-text text-justify transition-opacity duration-200">
                                    <div class="flex items-start gap-2">
                                <span class="kesimpulan-sub-number font-bold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                onclick="toggleKesimpulanSubPoint(this)" title="Klik untuk disable/enable">3.1.5</span> 
                                <p>
                                Berdasarkan pemeriksaan batch validasi
                                <input type="text" name="batch_besaran" class="template-input w-36"
                                placeholder="(DEC25A07)">
                               terhadap parameter mutu pengemasan pada tahap pengemasan antara lain
                                <textarea name="param_kemas_315" rows="3" class="template-input w-full resize-y text-base font-bold" 
                                placeholder="kebersihan kemasan, keberadaan etiket, kebersihan etiket, kelengkapan dan kesesuaian isi etiket, dan penyimpanan produk">
                                kebersihan kemasan, keberadaan etiket, kebersihan etiket, kelengkapan dan kesesuaian isi etiket, dan penyimpanan produk</textarea>
                                didapatkan hasil pegujian
                                <input type="text" name="hasil_314" class="template-input w-56" 
                                value="" placeholder="telah memenuhi">
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
                                Proses
                                <input type="text" name="hasil_315" class="template-input w-36" 
                                value="" placeholder="terbukti">
                                dapat menghasilkan produk jadi
                                 Telah dilakukan validasi proses pengolahan produk
                                <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                    data-sync="nama_produk" placeholder="Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF">
                                batch
                                <input type="text" name="batch_besaran" class="template-input w-36"
                                placeholder="DEC25A07"> 
                                yang 
                                <input type="text" name="hasil_32_proses" class="template-input w-36" 
                                value="" placeholder="memenuhi">
                                spesifikasi dalam Spesifikasi
                                <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-128"
                                    data-sync="nama_produk" placeholder="Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF">,
                                No. Dokumen
                                <input type="text" name="pencampuran_no_dokumen" class="template-input sync-input w-53"
                                    data-sync="no_dokumen" placeholder="SX-F03-3-00018-02">
                                tanggal
                                <input type="text" name="pencampuran_tanggal_dokumen" class="template-input sync-input w-53"
                                    data-sync="tanggal_dokumen" placeholder="09-08-2024">,
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
                    '#zingiberisTemplateForm input[name]:not([type="file"]), #zingiberisTemplateForm textarea[name], #zingiberisTemplateForm select[name]'
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
                    '#zingiberisTemplateForm input[name], #zingiberisTemplateForm textarea[name], #zingiberisTemplateForm select[name]')
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
                const form = document.getElementById('zingiberisTemplateForm');
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
                document.getElementById('zingiberisTemplateForm').appendChild(hiddenInput);
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
        const SAVE_DRAFT_URL = "{{ route('template-summary.zingiberis.draft', [], false) }}";
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
            const zingiberisForm = document.getElementById('zingiberisTemplateForm');
            if (zingiberisForm) {
                zingiberisForm.addEventListener('submit', function() {
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
        // SYNC NAMA PRODUK â€” berjalan langsung (global)
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
                document.getElementById('zingiberisTemplateForm').appendChild(tokenInput);
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
                    }, remainingTime);
                }
            }, 500);
        }
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
@endsection





