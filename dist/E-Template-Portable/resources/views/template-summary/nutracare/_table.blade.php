<div class="mixing-table-item border border-slate-300 dark:border-slate-600 rounded-lg overflow-hidden relative" data-table-uid="{{ $uid }}" onpaste="handleMixingPaste(event, this)">
    <div class="absolute top-1 right-1 z-20 remove-table-btn">
        <button type="button" onclick="toggleTableMenu(this)" class="flex items-center p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-md transition-colors" title="Opsi">
            <span class="material-symbols-outlined text-[20px] block">more_vert</span>
        </button>
        <div class="table-dropdown-menu hidden absolute right-0 mt-1 w-40 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg shadow-lg py-1 z-30">
            <button type="button" onclick="removeMixingTable(this)" class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors">
                <span class="material-symbols-outlined text-[18px]">delete</span>Hapus Tabel
            </button>
        </div>
    </div>
    <div class="p-6">
        <div class="paste-instructions border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-8 text-center bg-slate-50 dark:bg-slate-900/40 hover:border-blue-400 transition-colors cursor-pointer" onclick="focusClipboardField(this)">
            <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-2">content_paste</span>
            <p class="text-base font-medium text-slate-600 dark:text-slate-400 mb-1">Paste Tabel atau Screenshot</p>
            <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Copy dari Excel atau Screenshot lalu paste (Ctrl+V)</p>
            <div class="flex justify-center mb-4">
                <button type="button" onclick="triggerClipboardPaste(this)" class="px-3 py-1.5 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">content_paste_go</span>Tempel dari Clipboard
                </button>
            </div>
            <textarea rows="4" class="clipboard-input-area w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-base focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none font-mono" placeholder="Paste screenshot / tabel Excel di sini... (Ctrl+V)" onpaste="handleClipboardFieldPaste(event, this)"></textarea>
        </div>
        <input type="file" name="mixing_image_file[{{ $uid }}]" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
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
    <input type="hidden" name="bab22_table_subab_key[{{ $uid }}]" value="bab23">
    <input type="hidden" name="existing_mixing_image_file[{{ $uid }}]" value="">
    <input type="hidden" name="mixing_pasted_table_json[{{ $uid }}]" value="">
    <input type="hidden" name="mixing_image_base64[{{ $uid }}]" value="">
</div>