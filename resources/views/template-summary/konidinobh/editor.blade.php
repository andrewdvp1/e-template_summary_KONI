@extends('layouts.app')

@section('content')
    <form action="{{ route('template-summary.konidinobh.export') }}" method="POST" id="konidinobhTemplateForm"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="draft_id" id="draft_id" value="{{ $draft->id ?? '' }}">
        <input type="hidden" name="draft_line" id="draft_line" value="{{ $draftLine ?? '' }}">

        <div class="max-w-5xl mx-auto flex flex-col gap-6 pb-24">

            {{-- Title Section --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="font-bold text-slate-900 dark:text-white">Judul Summary</h2>
                </div>
                <div class="p-6">
                    <div class="text-base leading-relaxed text-slate-700 dark:text-slate-300 template-text">
                        <p class="font-bold text-center text-base mb-2">
                            SUMMARY LAPORAN VALIDASI PROSES PEMBUATAN PRODUK
                            <input type="text" name="judul_nama_produk" class="template-input sync-input w-64 uppercase"
                                data-sync="nama_produk" placeholder="KONIDIN OBH">
                        </p>
                        <p class="font-bold text-center text-base mb-4">
                            (<input type="text" name="judul_formula" class="template-input sync-input w-96"
                                data-sync="formula" placeholder="MIXING INDOLAVAL LEXAMIX TANPA IMPELLER">) DI LINE
                            <input type="text" name="judul_line" class="template-input sync-input w-8" data-sync="line"
                                placeholder="5">
                            (SACHET) BAGIAN
                            <input type="text" name="judul_bagian" class="template-input sync-input w-96 uppercase"
                                data-sync="bagian" value="Production Pharma III Gedung B"
                                placeholder="Production Pharma III Gedung B">
                        </p>
                    </div>
                    <div class="mt-6 border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden">
                        <table class="w-full text-base">
                            <tbody>
                                <tr class="border-b border-slate-300 dark:border-slate-600">
                                    <td class="px-4 py-2 font-medium text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-900/50 w-40">Dokumen No.</td>
                                    <td class="px-4 py-2 border-l border-slate-300 dark:border-slate-600">
                                        <input type="text" name="dokumen_no" class="template-input w-48" placeholder="-">
                                    </td>
                                    <td class="px-4 py-2 font-medium text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-900/50 w-24 border-l border-slate-300 dark:border-slate-600">Tanggal</td>
                                    <td class="px-4 py-2 border-l border-slate-300 dark:border-slate-600">
                                        <input type="text" name="dokumen_tanggal" class="template-input w-40" placeholder="-">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-medium text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-900/50">Pengganti No.</td>
                                    <td class="px-4 py-2 border-l border-slate-300 dark:border-slate-600">
                                        <input type="text" name="pengganti_no" class="template-input w-48" placeholder="-">
                                    </td>
                                    <td class="px-4 py-2 font-medium text-slate-700 dark:text-slate-300 bg-slate-50 dark:bg-slate-900/50 border-l border-slate-300 dark:border-slate-600">Tanggal</td>
                                    <td class="px-4 py-2 border-l border-slate-300 dark:border-slate-600">
                                        <input type="text" name="pengganti_tanggal" class="template-input w-40" placeholder="-">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- BAB 1: PENDAHULUAN --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="font-bold text-slate-900 dark:text-white">1. PENDAHULUAN</h2>
                </div>
                <div class="p-6 flex flex-col gap-6">
                    {{-- 1.1 Tujuan --}}
                    <div>
                        <h3 class="font-semibold text-slate-800 dark:text-slate-200 mb-3">1.1 Tujuan</h3>
                        <div class="ml-4 text-base leading-relaxed text-slate-700 dark:text-slate-300 template-text text-justify">
                            <p class="pl-8 -indent-8">
                                <span class="font-medium">1.1.1</span> Summary validasi ini bertujuan mendokumentasikan
                                hasil studi validasi/pembuktian terhadap kualitas dan reprodusibilitas proses pengolahan
                                produk
                                <input type="text" name="tujuan_nama_produk" class="template-input sync-input w-40"
                                    data-sync="nama_produk" placeholder="Konidin OBH">
                                di Line
                                <input type="text" name="tujuan_line" class="template-input sync-input w-8"
                                    data-sync="line" placeholder="5">
                                (Sachet) Bagian
                                <input type="text" name="tujuan_bagian" class="template-input sync-input w-96"
                                    data-sync="bagian" value="Production Pharma III Gedung B"
                                    placeholder="Production Pharma III Gedung B">
                                yang diproduksi dengan
                                <input type="text" name="tujuan_mesin" class="template-input sync-input w-full"
                                    data-sync="mesin"
                                    value="Mesin mixer Indolaval Lexamix tanpa Impeller dan Mesin sachetting Klockner"
                                    placeholder="Mesin mixer Indolaval Lexamix tanpa Impeller dan Mesin sachetting Klockner">
                                dalam menghasilkan produk
                                <input type="text" name="tujuan_nama_produk_2" class="template-input sync-input w-40"
                                    data-sync="nama_produk" placeholder="Konidin OBH">
                                dalam kemasan sachet yang memenuhi persyaratan mutu yang tercantum dalam Spesifikasi Produk
                                dan Spesifikasi Kemasan yang berlaku.
                            </p>
                        </div>
                    </div>

                    {{-- 1.2 Batch Validasi --}}
                    <div>
                        <h3 class="font-semibold text-slate-800 dark:text-slate-200 mb-3">1.2 Batch Validasi</h3>
                        <div class="text-base leading-relaxed text-slate-700 dark:text-slate-300 template-text text-justify mb-4">
                            <p>
                                Studi validasi dilakukan terhadap
                                <input type="text" name="batch_jumlah" class="template-input w-16" placeholder="satu">
                                batch produksi dengan besaran batch
                                <input type="text" name="batch_besaran" class="template-input w-20" placeholder="200L">,
                                yaitu
                                <input type="text" name="batch_kode_list" class="template-input sync-input w-64"
                                    data-sync="batch" placeholder="A25A01, A25A02, A25A03">:
                            </p>
                        </div>

                        {{-- Tabel Bahan Aktif --}}
                        <div class="border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden">
                            <div class="px-4 py-3 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-300 dark:border-slate-600 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-slate-500 text-[20px]">table_chart</span>
                                    <span class="text-base font-medium text-slate-700 dark:text-slate-300">Tabel Identitas Bahan Baku Zat Aktif</span>
                                </div>
                                <button type="button" onclick="clearExcelTable('bahan_aktif')"
                                    class="text-xs text-slate-500 hover:text-red-600 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">delete</span> Clear
                                </button>
                            </div>
                            <div id="paste_instructions_bahan_aktif" class="p-4">
                                <div class="border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-8 text-center">
                                    <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-2">content_paste</span>
                                    <p class="text-base font-medium text-slate-600 dark:text-slate-400 mb-1">Paste dari Excel</p>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Copy data dari Excel (4 kolom: Bahan aktif, Kode Bahan Baku, Nama Supplier, Negara) lalu paste di bawah</p>
                                    <textarea id="excel_paste_bahan_aktif" rows="4"
                                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-base focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none font-mono"
                                        placeholder="Paste data Excel disini (Ctrl+V)..." onpaste="handleExcelPaste(event, 'bahan_aktif')"></textarea>
                                </div>
                            </div>
                            <div id="table_preview_bahan_aktif" class="hidden">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-base" id="preview_table_bahan_aktif">
                                        <thead>
                                            <tr class="bg-slate-100 dark:bg-slate-700">
                                                <th class="px-4 py-2 text-left font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-300 dark:border-slate-600">Bahan aktif</th>
                                                <th class="px-4 py-2 text-left font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-300 dark:border-slate-600">Kode Bahan Baku</th>
                                                <th class="px-4 py-2 text-left font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-300 dark:border-slate-600">Nama Supplier</th>
                                                <th class="px-4 py-2 text-left font-semibold text-slate-700 dark:text-slate-300 border-b border-slate-300 dark:border-slate-600">Negara</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_body_bahan_aktif"></tbody>
                                    </table>
                                </div>
                            </div>
                            <input type="hidden" name="tabel_bahan_aktif" id="hidden_data_bahan_aktif">
                        </div>
                    </div>
                </div>
            </div>

            {{-- BAB 2: RANGKUMAN HASIL --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <h2 class="font-bold text-slate-900 dark:text-white">2. RANGKUMAN HASIL</h2>
                    <span class="text-xs text-slate-400 dark:text-slate-500">Klik nomor untuk enable/disable</span>
                </div>
                <div class="p-6 flex flex-col gap-6">
                    <div>
                        <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                            <p class="pl-8 -indent-8">
                                <span class="font-semibold">2.1.</span> Semua tahap dalam penimbangan bahan baku, mixing,
                                dan sachetting telah dilakukan sesuai prosedur pengolahan dan pengemasan yang berlaku.
                            </p>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-semibold text-slate-800 dark:text-slate-200 mb-3">2.2 Hasil pemeriksaan sampel</h3>
                        <input type="hidden" name="bab22_enabled_subab_keys" id="bab22_enabled_subab_keys" value="">

                        {{-- 2.2.1 Mixing --}}
                        <div class="bab22-subab mb-6" id="bab22_subab_mixing" draggable="true" data-subab-type="default"
                            data-subab-id="1" data-subab-key="mixing" data-subab-title="Mixing"
                            data-closing-kind="template" data-template-stage="mixing">
                            <h4 class="font-medium text-slate-700 dark:text-slate-300 mb-4 flex items-center justify-between">
                                <span>
                                    <span class="bab22-number bab22-toggle-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                        onclick="toggleBab22Subab(this)" title="Klik untuk disable/enable">2.2.1</span>
                                    <span class="bab22-title">Mixing</span>
                                </span>
                                <span class="material-symbols-outlined text-[18px] text-slate-400 cursor-grab select-none">drag_indicator</span>
                            </h4>
                            <div class="mixing-tables-container flex flex-col gap-4">
                                <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative"
                                    data-table-index="0" data-table-uid="table_1" onpaste="handleMixingPaste(event, this)">
                                    <div class="absolute top-1 right-1 z-20 remove-table-btn">
                                        <button type="button" onclick="toggleTableMenu(this)"
                                            class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors">
                                            <span class="material-symbols-outlined text-[20px] block">more_vert</span>
                                        </button>
                                        <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30">
                                            <button type="button" onclick="removeMixingTable(this)"
                                                class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">delete</span> Hapus Tabel
                                            </button>
                                        </div>
                                    </div>
                                    <div class="p-6">
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
                                                placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)"
                                                onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                                        </div>
                                        <input type="file" name="mixing_image_file[table_1]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                                        <input type="file" name="mixing_excel_file[table_1]" accept=".xlsx,.xls,.ods" class="hidden" onchange="updateFileName(this)">
                                        <div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1">
                                            <img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm">
                                            <button type="button" onclick="removeImage(this)"
                                                class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10">
                                                <span class="material-symbols-outlined text-[14px] block">close</span>
                                            </button>
                                        </div>
                                        <div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3">
                                            <div class="overflow-auto max-h-[420px]">
                                                <table class="w-full text-sm border-collapse pasted-table-preview-table"></table>
                                            </div>
                                            <button type="button" onclick="removePastedTable(this)"
                                                class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10">
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
                            <button type="button" onclick="addMixingTableToSubab(this)"
                                class="mt-4 w-full py-3 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg text-slate-500 dark:text-slate-400 hover:border-red-400 hover:text-red-600 transition-colors flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">add</span>
                                <span class="text-sm font-medium">Tambah Tabel</span>
                            </button>
                            <div class="mt-6 text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                                <p>
                                    Atribut yang diuji pada tahap mixing sudah memberikan hasil yang
                                    <input type="text" name="mixing_hasil" class="template-input w-32" value="" placeholder="memenuhi">
                                    persyaratan menurut Spesifikasi Produk yang berlaku
                                    <input type="text" name="mixing_hasil_catatan" class="template-input w-64" value="" placeholder="">.
                                </p>
                            </div>
                        </div>

                        {{-- 2.2.2 Awal Sachetting --}}
                        <div class="bab22-subab mb-6" id="bab22_subab_sachetting_awal" draggable="true" data-subab-type="default"
                            data-subab-id="2" data-subab-key="sachetting_awal" data-subab-title="Awal sachetting"
                            data-closing-kind="template" data-template-stage="sachetting_awal">
                            <h4 class="font-medium text-slate-700 dark:text-slate-300 mb-4 flex items-center justify-between">
                                <span>
                                    <span class="bab22-number bab22-toggle-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                        onclick="toggleBab22Subab(this)" title="Klik untuk disable/enable">2.2.2</span>
                                    <span class="bab22-title">Awal sachetting</span>
                                </span>
                                <span class="material-symbols-outlined text-[18px] text-slate-400 cursor-grab select-none">drag_indicator</span>
                            </h4>
                            <div class="mixing-tables-container flex flex-col gap-4">
                                <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative"
                                    data-table-index="0" data-table-uid="table_2" onpaste="handleMixingPaste(event, this)">
                                    <div class="absolute top-1 right-1 z-20 remove-table-btn">
                                        <button type="button" onclick="toggleTableMenu(this)"
                                            class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors">
                                            <span class="material-symbols-outlined text-[20px] block">more_vert</span>
                                        </button>
                                        <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30">
                                            <button type="button" onclick="removeMixingTable(this)"
                                                class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">delete</span> Hapus Tabel
                                            </button>
                                        </div>
                                    </div>
                                    <div class="p-6">
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
                                                placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)"
                                                onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                                        </div>
                                        <input type="file" name="mixing_image_file[table_2]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                                        <input type="file" name="mixing_excel_file[table_2]" accept=".xlsx,.xls,.ods" class="hidden" onchange="updateFileName(this)">
                                        <div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1">
                                            <img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm">
                                            <button type="button" onclick="removeImage(this)"
                                                class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10">
                                                <span class="material-symbols-outlined text-[14px] block">close</span>
                                            </button>
                                        </div>
                                        <div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3">
                                            <div class="overflow-auto max-h-[420px]">
                                                <table class="w-full text-sm border-collapse pasted-table-preview-table"></table>
                                            </div>
                                            <button type="button" onclick="removePastedTable(this)"
                                                class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10">
                                                <span class="material-symbols-outlined text-[14px] block">close</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="bab22_table_subab_key[table_2]" value="sachetting_awal">
                            <input type="hidden" name="existing_mixing_image_file[table_2]" value="">
                            <input type="hidden" name="mixing_pasted_table_json[table_2]" value="">
                            <input type="hidden" name="mixing_image_base64[table_2]" value="">
                            <button type="button" onclick="addMixingTableToSubab(this)"
                                class="mt-4 w-full py-3 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg text-slate-500 dark:text-slate-400 hover:border-red-400 hover:text-red-600 transition-colors flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">add</span>
                                <span class="text-sm font-medium">Tambah Tabel</span>
                            </button>
                            <div class="mt-6 text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                                <p>
                                    Atribut yang diuji pada tahap awal sachetting sudah memberikan hasil yang
                                    <input type="text" name="sachetting_awal_hasil" class="template-input w-32" value="" placeholder="memenuhi">
                                    persyaratan menurut Spesifikasi Produk yang berlaku
                                    <input type="text" name="sachetting_awal_hasil_catatan" class="template-input w-64" value="" placeholder="">.
                                </p>
                            </div>
                        </div>

                        {{-- 2.2.3 Sachetting --}}
                        <div class="bab22-subab mb-6" id="bab22_subab_sachetting" draggable="true" data-subab-type="default"
                            data-subab-id="3" data-subab-key="sachetting" data-subab-title="Sachetting"
                            data-closing-kind="template" data-template-stage="sachetting">
                            <h4 class="font-medium text-slate-700 dark:text-slate-300 mb-4 flex items-center justify-between">
                                <span>
                                    <span class="bab22-number bab22-toggle-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                        onclick="toggleBab22Subab(this)" title="Klik untuk disable/enable">2.2.3</span>
                                    <span class="bab22-title">Sachetting</span>
                                </span>
                                <span class="material-symbols-outlined text-[18px] text-slate-400 cursor-grab select-none">drag_indicator</span>
                            </h4>
                            <div class="mixing-tables-container flex flex-col gap-4">
                                <div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative"
                                    data-table-index="0" data-table-uid="table_3" onpaste="handleMixingPaste(event, this)">
                                    <div class="absolute top-1 right-1 z-20 remove-table-btn">
                                        <button type="button" onclick="toggleTableMenu(this)"
                                            class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors">
                                            <span class="material-symbols-outlined text-[20px] block">more_vert</span>
                                        </button>
                                        <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30">
                                            <button type="button" onclick="removeMixingTable(this)"
                                                class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">delete</span> Hapus Tabel
                                            </button>
                                        </div>
                                    </div>
                                    <div class="p-6">
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
                                                placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)"
                                                onpaste="handleClipboardFieldPaste(event, this)"></textarea>
                                        </div>
                                        <input type="file" name="mixing_image_file[table_3]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
                                        <input type="file" name="mixing_excel_file[table_3]" accept=".xlsx,.xls,.ods" class="hidden" onchange="updateFileName(this)">
                                        <div class="hidden image-preview-box relative border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-1">
                                            <img src="" alt="Preview" class="w-full h-auto rounded-md shadow-sm">
                                            <button type="button" onclick="removeImage(this)"
                                                class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-70 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10">
                                                <span class="material-symbols-outlined text-[14px] block">close</span>
                                            </button>
                                        </div>
                                        <div class="hidden pasted-table-preview-box relative border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-900/50 p-3">
                                            <div class="overflow-auto max-h-[420px]">
                                                <table class="w-full text-sm border-collapse pasted-table-preview-table"></table>
                                            </div>
                                            <button type="button" onclick="removePastedTable(this)"
                                                class="flex items-center absolute top-4 right-4 p-2 bg-red-500 opacity-80 text-white rounded-lg hover:bg-red-600 shadow-md transition-colors z-10">
                                                <span class="material-symbols-outlined text-[14px] block">close</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="bab22_table_subab_key[table_3]" value="sachetting">
                            <input type="hidden" name="existing_mixing_image_file[table_3]" value="">
                            <input type="hidden" name="mixing_pasted_table_json[table_3]" value="">
                            <input type="hidden" name="mixing_image_base64[table_3]" value="">
                            <button type="button" onclick="addMixingTableToSubab(this)"
                                class="mt-4 w-full py-3 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg text-slate-500 dark:text-slate-400 hover:border-red-400 hover:text-red-600 transition-colors flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">add</span>
                                <span class="text-sm font-medium">Tambah Tabel</span>
                            </button>
                            <div class="mt-6 text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                                <p>
                                    Atribut yang diuji pada tahap sachetting sudah memberikan hasil yang
                                    <input type="text" name="sachetting_hasil" class="template-input w-32" value="" placeholder="memenuhi">
                                    persyaratan menurut Spesifikasi Produk dan Spesifikasi Kemasan yang berlaku
                                    <input type="text" name="sachetting_hasil_catatan" class="template-input w-64" value="" placeholder="">.
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
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <h2 class="font-bold text-slate-900 dark:text-white">3. KESIMPULAN</h2>
                    <span class="text-xs text-slate-400 dark:text-slate-500">Klik nomor untuk enable/disable</span>
                </div>
                <div class="p-6 flex flex-col gap-6" id="bab3_container">
                    <input type="hidden" name="kesimpulan_enabled_sections" id="kesimpulan_enabled_sections" value="1,2,3,4,5">

                    {{-- 3.1 --}}
                    <div class="kesimpulan-section" data-section-id="1">
                        <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                            <p class="pl-8 -indent-8">
                                <span class="kesimpulan-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                    onclick="toggleKesimpulanSection(this)" title="Klik untuk disable/enable">3.1</span>
                                Telah dilakukan proses produksi terhadap produk
                                <input type="text" name="kesimpulan_nama_produk" class="template-input sync-input w-48"
                                    data-sync="nama_produk" placeholder="Konidin OBH">,
                                yakni pada batch
                                <input type="text" name="kesimpulan_batch_codes" class="template-input sync-input w-48"
                                    data-sync="batch" placeholder="A25A01, A25A02, A25A03">
                                yang digunakan sebagai batch validasi proses.
                            </p>
                        </div>
                    </div>

                    {{-- 3.2 Mixing --}}
                    <div class="kesimpulan-section" data-section-id="2">
                        <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                            <p class="pl-8 -indent-8">
                                <span class="kesimpulan-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                    onclick="toggleKesimpulanSection(this)" title="Klik untuk disable/enable">3.2</span>
                                Atribut yang diuji pada tahap mixing (
                                <input type="text" name="kesimpulan_mixing_atribut" class="template-input w-96"
                                    value="bentuk, warna, aroma, pH, kadar zat aktif dan kadar pengawet"
                                    placeholder="bentuk, warna, aroma, pH, kadar zat aktif dan kadar pengawet">
                                ) memberikan hasil yang
                                <input type="text" name="kesimpulan_mixing_hasil" class="template-input w-32"
                                    value="" placeholder="memenuhi">
                                persyaratan menurut Spesifikasi Produk yang berlaku.
                            </p>
                        </div>
                    </div>

                    {{-- 3.3 Awal Sachetting --}}
                    <div class="kesimpulan-section" data-section-id="3">
                        <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                            <p class="pl-8 -indent-8">
                                <span class="kesimpulan-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                    onclick="toggleKesimpulanSection(this)" title="Klik untuk disable/enable">3.3</span>
                                Atribut yang diuji pada tahap awal sachetting produk suspensi ke dalam kemasan sachet (
                                <input type="text" name="kesimpulan_sachettingawal_atribut" class="template-input w-64"
                                    value="kadar zat aktif dan kadar pengawet"
                                    placeholder="kadar zat aktif dan kadar pengawet">
                                ) memberikan hasil yang
                                <input type="text" name="kesimpulan_sachettingawal_hasil" class="template-input w-32"
                                    value="" placeholder="memenuhi">
                                persyaratan menurut Spesifikasi Produk yang berlaku.
                            </p>
                        </div>
                    </div>

                    {{-- 3.4 Sachetting --}}
                    <div class="kesimpulan-section" data-section-id="4">
                        <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                            <p class="pl-8 -indent-8">
                                <span class="kesimpulan-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                    onclick="toggleKesimpulanSection(this)" title="Klik untuk disable/enable">3.4</span>
                                Atribut yang diuji pada tahap sachetting produk suspensi ke dalam kemasan sachet (
                                <input type="text" name="kesimpulan_sachetting_atribut" class="template-input w-96"
                                    value="bentuk, warna, aroma, pH, kadar zat aktif, kadar pengawet, batas mikroba, volume terpindahkan, kebocoran sachet"
                                    placeholder="bentuk, warna, aroma, pH, kadar zat aktif, kadar pengawet, batas mikroba, volume terpindahkan, kebocoran sachet">
                                ) memberikan hasil yang
                                <input type="text" name="kesimpulan_sachetting_hasil" class="template-input w-32"
                                    value="" placeholder="memenuhi">
                                persyaratan menurut Spesifikasi Produk dan Spesifikasi Kemasan yang berlaku.
                            </p>
                        </div>
                    </div>

                    {{-- 3.5 Kesimpulan Final --}}
                    <div class="kesimpulan-section" data-section-id="5">
                        <div class="text-base leading-relaxed text-slate-800 dark:text-slate-300 template-text text-justify">
                            <p class="pl-8 -indent-8">
                                <span class="kesimpulan-number font-semibold cursor-pointer select-none px-1 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 transition-colors"
                                    onclick="toggleKesimpulanSection(this)" title="Klik untuk disable/enable">3.5</span>
                                Sesuai dengan hasil evaluasi terhadap kesesuaian pelaksanaan di setiap tahap proses produksi,
                                parameter proses dan hasil pemeriksaan atribut kualitas produk pada tahap
                                <input type="text" name="kesimpulan_tahap_proses" class="template-input w-64"
                                    value="mixing, awal sachetting dan sachetting"
                                    placeholder="mixing, awal sachetting dan sachetting">
                                yang memenuhi persyaratan, maka proses pengolahan dan pengemasan produk
                                <input type="text" name="kesimpulan_final_produk" class="template-input sync-input w-40"
                                    data-sync="nama_produk" placeholder="Konidin OBH">
                                menggunakan
                                <input type="text" name="kesimpulan_mesin" class="template-input sync-input w-full"
                                    data-sync="mesin"
                                    value="mesin mixer Indolaval Lexamix tanpa impeller dan mesin sachetting Klockner"
                                    placeholder="mesin mixer Indolaval Lexamix tanpa impeller dan mesin sachetting Klockner">
                                dinyatakan <em><input type="text" name="kesimpulan_status" class="template-input w-28 italic"
                                    value="validated" placeholder="validated"></em>.
                            </p>
                        </div>
                    </div>

                    {{-- Custom sections container --}}
                    <div id="kesimpulan_custom_container" class="flex flex-col gap-6"></div>

                    <button type="button" onclick="addKesimpulanCustomSection()"
                        class="w-full py-3 border-2 border-dashed border-red-200 dark:border-red-800 rounded-lg text-red-600 dark:text-red-400 hover:border-red-400 hover:bg-red-50/40 dark:hover:bg-red-900/20 transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                        <span class="text-sm font-medium">Tambah Poin Kesimpulan</span>
                    </button>
                </div>
            </div>

        </div>{{-- end max-w-5xl --}}

        {{-- Floating Action Bar --}}
        <div class="fixed bottom-0 left-0 right-0 z-40 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-700 shadow-lg">
            <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span id="autosave_indicator" class="text-xs text-slate-400 dark:text-slate-500 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px]">cloud_done</span>
                        <span id="autosave_text">Draft tersimpan</span>
                    </span>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" id="btn_save_draft" onclick="saveDraft()"
                        class="px-5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-semibold text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan Draft
                    </button>
                    <button type="button" id="btn_export" onclick="exportDocument()"
                        class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">download</span>
                        Export Word
                    </button>
                </div>
            </div>
        </div>

    </form>
@endsection

@push('scripts')
<script>
// ── Sync inputs ──────────────────────────────────────────────────────────────
document.querySelectorAll('.sync-input').forEach(input => {
    input.addEventListener('input', function () {
        const key = this.dataset.sync;
        document.querySelectorAll(`.sync-input[data-sync="${key}"]`).forEach(el => {
            if (el !== this) el.value = this.value;
        });
    });
});

// ── Draft restore ─────────────────────────────────────────────────────────────
const initialDraftState = @json($initialDraftState ?? null);
if (initialDraftState && initialDraftState.form_values) {
    const fv = initialDraftState.form_values;
    Object.entries(fv).forEach(([name, value]) => {
        const el = document.querySelector(`[name="${name}"]`);
        if (el) el.value = value;
    });
}

// ── Save Draft ────────────────────────────────────────────────────────────────
function saveDraft() {
    const form = document.getElementById('konidinobhTemplateForm');
    const formData = new FormData(form);
    const formValues = {};
    for (const [key, value] of formData.entries()) {
        if (!(value instanceof File)) formValues[key] = value;
    }
    const draftState = JSON.stringify({ form_values: formValues });

    const payload = new FormData();
    payload.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '');
    payload.append('draft_id', document.getElementById('draft_id').value || '');
    payload.append('draft_line', document.getElementById('draft_line').value || '');
    payload.append('draft_title', formValues['judul_nama_produk'] || 'Konidin OBH');
    payload.append('draft_state', draftState);

    document.getElementById('autosave_text').textContent = 'Menyimpan...';

    fetch('{{ route("template-summary.konidinobh.draft") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
        body: payload,
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('draft_id').value = data.draft_id;
            document.getElementById('autosave_text').textContent = 'Draft tersimpan';
            if (data.redirect_url && !window.location.search.includes('draft=')) {
                window.history.replaceState({}, '', data.redirect_url);
            }
        }
    })
    .catch(() => { document.getElementById('autosave_text').textContent = 'Gagal menyimpan'; });
}

// ── Export ────────────────────────────────────────────────────────────────────
function exportDocument() {
    document.getElementById('konidinobhTemplateForm').submit();
}

// ── Toggle kesimpulan section ─────────────────────────────────────────────────
function toggleKesimpulanSection(el) {
    const section = el.closest('.kesimpulan-section');
    const isDisabled = section.classList.toggle('opacity-40');
    section.querySelectorAll('input').forEach(i => i.disabled = isDisabled);
    updateKesimpulanEnabledSections();
}

function updateKesimpulanEnabledSections() {
    const enabled = [];
    document.querySelectorAll('.kesimpulan-section:not(.opacity-40)').forEach(s => {
        enabled.push(s.dataset.sectionId);
    });
    document.getElementById('kesimpulan_enabled_sections').value = enabled.join(',');
}

// ── Toggle bab22 subab ────────────────────────────────────────────────────────
function toggleBab22Subab(el) {
    const subab = el.closest('.bab22-subab');
    subab.classList.toggle('opacity-40');
    subab.querySelectorAll('input, textarea').forEach(i => i.disabled = subab.classList.contains('opacity-40'));
    updateBab22EnabledKeys();
}

function updateBab22EnabledKeys() {
    const keys = [];
    document.querySelectorAll('.bab22-subab:not(.opacity-40)').forEach(s => {
        if (s.dataset.subabKey) keys.push(s.dataset.subabKey);
    });
    document.getElementById('bab22_enabled_subab_keys').value = keys.join(',');
}

// ── Autosave every 60s ────────────────────────────────────────────────────────
setInterval(saveDraft, 60000);
</script>
@endpush
