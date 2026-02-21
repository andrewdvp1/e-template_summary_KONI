================================================================================

&nbsp;                   E-Template (ReportGenerator v2.0)

&nbsp;              Panduan Developer / Dokumentasi Teknis

================================================================================



DESKRIPSI SINGKAT

-----------------

E-Template adalah aplikasi web berbasis Laravel yang berfungsi sebagai

generator summary/laporan validasi proses produksi secara otomatis. User

memilih jenis sediaan (saat ini: Sirup), mengisi template form di browser,

lalu aplikasi meng-export data tersebut menjadi dokumen Word (.docx).



Aplikasi ini dirancang sebagai PORTABLE DESKTOP APP — artinya:

&nbsp; - PHP runtime sudah di-bundle di dalam folder `php/`

&nbsp; - Database menggunakan SQLite (tanpa MySQL/PostgreSQL)

&nbsp; - Tidak perlu install web server (Apache/Nginx)

&nbsp; - Dijalankan cukup dengan double-click `start.bat`



Database (SQLite) hanya digunakan untuk:

&nbsp; - Menyimpan draft laporan (JSON payload)

&nbsp; - Menyimpan referensi path gambar yang di-upload





================================================================================

&nbsp;                          TECH STACK \& VERSI

================================================================================



Backend:

&nbsp; - PHP              : 8.2.x (Thread Safe, VS16 x64)

&nbsp; - Laravel          : 12.x (framework PHP)

&nbsp; - PHPWord          : ^1.3 (generate dokumen .docx)

&nbsp; - PHPSpreadsheet   : ^5.4 (generate template Excel)



Frontend:

&nbsp; - Tailwind CSS     : 4.x (versi 4, BUKAN versi 3 — konfigurasi berbeda!)

&nbsp; - Vite             : 7.x (build tool, menggantikan webpack/mix)

&nbsp; - Google Fonts     : Manrope (font utama)

&nbsp; - Material Symbols : Outlined (icon set)



Database:

&nbsp; - SQLite           : File-based database (`database/database.sqlite`)



Build Tools:

&nbsp; - Node.js/npm      : Untuk install dan build frontend dependencies

&nbsp; - Composer         : Untuk install PHP dependencies





================================================================================

&nbsp;                     STRUKTUR FOLDER UTAMA

================================================================================



ReportGenerator\_v2.0/

│

├── app/                          # Kode PHP utama (MVC)

│   ├── Http/

│   │   └── Controllers/

│   │       ├── Controller.php              # Base controller (kosong)

│   │       ├── TemplateSummaryController.php  # ★ CONTROLLER UTAMA

│   │       └── SettingsController.php      # Halaman settings/cek DB

│   │

│   ├── Models/

│   │   ├── User.php                    # Model user bawaan Laravel

│   │   └── TemplateSummaryDraft.php    # ★ Model draft summary

│   │

│   ├── Services/

│   │   ├── Export/

│   │   │   └── SirupExportService.php  # ★ Service export ke Word (.docx)

│   │   └── Excel/

│   │       └── EnkapsulasiExcelService.php  # Service generate template Excel

│   │

│   └── Providers/

│       └── AppServiceProvider.php      # Service provider bawaan

│

├── resources/                     # Asset dan View

│   ├── views/

│   │   ├── layouts/

│   │   │   └── app.blade.php           # ★ Layout utama (sidebar + header)

│   │   ├── components/

│   │   │   ├── sidebar.blade.php       # Sidebar navigasi

│   │   │   ├── header.blade.php        # Header dengan breadcrumb

│   │   │   └── breadcrumb.blade.php    # Komponen breadcrumb

│   │   ├── template-summary/

│   │   │   ├── index.blade.php         # ★ Halaman pilih template

│   │   │   ├── drafts.blade.php        # ★ Halaman daftar draft

│   │   │   └── sirup/

│   │   │       └── editor.blade.php    # ★ HALAMAN UTAMA editor sirup

│   │   ├── settings.blade.php          # Halaman settings

│   │   └── welcome.blade.php           # Landing page (tidak dipakai)

│   ├── css/

│   │   └── app.css                 # Import Tailwind + custom base styles

│   └── js/

│       ├── app.js                  # Entry point JS (import bootstrap)

│       └── bootstrap.js            # Setup Axios/CSRF

│

├── routes/

│   └── web.php                    # ★ Semua definisi route

│

├── database/

│   ├── database.sqlite            # File database SQLite

│   └── migrations/

│       ├── 0001\_01\_01\_000000\_create\_users\_table.php

│       ├── 0001\_01\_01\_000001\_create\_cache\_table.php

│       ├── 0001\_01\_01\_000002\_create\_jobs\_table.php

│       └── 2026\_02\_11\_000001\_create\_template\_summary\_drafts\_table.php  # ★

│

├── config/                        # Konfigurasi Laravel standar

│   ├── app.php, database.php, filesystems.php, session.php, dll.

│

├── public/                        # Document root web server

│   └── (build assets dari Vite)

│

├── storage/                       # Storage Laravel (logs, cache, uploads)

│   └── app/public/                # File uploads (gambar draft)

│

├── php/                           # ★ PHP runtime portable (bundled)

│   ├── php.exe

│   └── php.ini (di-copy dari php.ini.portable saat setup)

│

├── .env                           # Environment config (aktif)

├── .env.example                   # Contoh env untuk development

├── .env.production                # Env untuk build production/portable

├── .env.backup                    # Backup env development

│

├── composer.json                  # PHP dependencies + scripts

├── package.json                   # Frontend dependencies

├── tailwind.config.js             # Konfigurasi Tailwind CSS v4

├── vite.config.js                 # Konfigurasi Vite (build tool)

├── php.ini.portable               # Template php.ini untuk portable build

│

├── start.bat                      # ★ Launcher aplikasi (produksi)

├── build\_portable.ps1             # ★ Script build distribusi portable

├── setup\_php.ps1                  # ★ Script download \& setup PHP runtime

│

└── README.txt                     # File ini





================================================================================

&nbsp;              PENJELASAN FILE-FILE UTAMA

================================================================================



--- ROUTES ---



routes/web.php

&nbsp; Mendefinisikan semua URL / endpoint yang tersedia:



&nbsp; GET  /                              → Home, redirect ke template-summary

&nbsp; GET  /template-summary              → Halaman pilih template (index)

&nbsp; GET  /template-summary/drafts       → Halaman daftar semua draft

&nbsp; GET  /template-summary/sirup        → Editor template sirup

&nbsp; GET  /template-summary/sirup?draft=ID → Load draft tertentu ke editor

&nbsp; POST /template-summary/sirup/draft  → Simpan draft (AJAX, JSON response)

&nbsp; POST /template-summary/sirup/export → Export ke Word (.docx), download file

&nbsp; POST /template-summary/parse-excel  → Parse file Excel yang di-upload

&nbsp; DELETE /template-summary/drafts/{id}→ Hapus draft

&nbsp; GET  /settings                      → Halaman settings

&nbsp; GET  /settings/database-status      → AJAX cek koneksi database





--- CONTROLLERS ---



app/Http/Controllers/TemplateSummaryController.php (**Paling Penting**)

&nbsp; Controller utama. Berisi ~500 baris kode. Method-method utama:



&nbsp; - index()           : Menampilkan halaman pilih template + daftar draft

&nbsp; - drafts()          : Menampilkan halaman daftar semua draft (full page)

&nbsp; - sirupEditor()     : Menampilkan editor sirup (baru atau dari draft)

&nbsp; - exportSirup()     : Menerima form data, panggil SirupExportService, 

&nbsp;                        return file download .docx

&nbsp; - saveSirupDraft()  : Menerima AJAX POST, simpan/update draft ke database.

&nbsp;                        Menangani upload file gambar (image) dan Excel.

&nbsp;                        Menyimpan semua form state sebagai JSON di kolom `payload`.

&nbsp; - parseExcel()      : Menerima upload file Excel, parse isinya, return JSON

&nbsp; - deleteDraft()     : Hapus draft + file terkait dari storage

&nbsp; 

&nbsp; Helper methods (private):

&nbsp; - storeDraftFileGroup()     : Upload \& simpan file ke storage/app/public

&nbsp; - resolveDraftTitle()       : Generate judul draft dari data form

&nbsp; - deleteDraftStorageDirectory() : Hapus folder storage draft

&nbsp; - publicStorageUrl()        : Convert storage path ke public URL

&nbsp; - cleanupRemovedDraftFiles(): Hapus file lama saat draft di-update

&nbsp; - extractStoredFilePaths()  : Ambil semua path file dari state draft

&nbsp; - normalizeStoredFilesUrl() : Normalisasi URL file untuk kompatibilitas

&nbsp; - normalizeStoredFileGroup(): Normalisasi path per group file

&nbsp; - normalizeStoredFilePath() : Normalisasi single path (handle legacy format)



app/Http/Controllers/SettingsController.php

&nbsp; - index()          : Tampilkan halaman settings (versi app, info system)

&nbsp; - checkDatabase()  : AJAX endpoint cek koneksi database, return JSON





--- MODELS ---



app/Models/TemplateSummaryDraft.php

&nbsp; Tabel: template\_summary\_drafts

&nbsp; Kolom:

&nbsp;   - id             : Primary key

&nbsp;   - draft\_type     : Tipe template (misal: 'sirup')

&nbsp;   - title          : Judul draft (auto-generated dari data form)

&nbsp;   - payload        : JSON longText — menyimpan SELURUH state form editor.

&nbsp;                      Termasuk: semua input values, posisi sub-bab, section

&nbsp;                      yang enabled/disabled, path file gambar, dll.

&nbsp;   - last\_saved\_at  : Timestamp terakhir disimpan

&nbsp;   - created\_at     : Timestamp dibuat

&nbsp;   - updated\_at     : Timestamp diupdate





--- SERVICES ---



app/Services/Export/SirupExportService.php (**Paling Penting #2**)

&nbsp; Service yang meng-generate dokumen Word (.docx) menggunakan PHPWord.

&nbsp; Method-method utama:



&nbsp; - export($data)           : Entry point. Terima array data dari controller,

&nbsp;                             panggil semua method build, return download.

&nbsp; - setupDocument()         : Konfigurasi halaman (A4, margin, font default)

&nbsp; - addHeader()             : Tambah header dokumen (logo, info perusahaan)

&nbsp; - addDocumentTitle()      : Tambah judul summary

&nbsp; - addDocumentInfoTable()  : Tambah tabel info (Dokumen No, Tanggal, dll)

&nbsp; - exportBab1()            : Export BAB 1: Pendahuluan

&nbsp;   - addBahanAktifTable()  : Tambah tabel bahan aktif dari data Excel paste

&nbsp; - exportBab2()            : Export BAB 2: Rangkuman Hasil

&nbsp;   - getDnabledBab22SubabKeys() : Ambil sub-bab yang aktif

&nbsp;   - getBab22SubabTitle()       : Resolve judul sub-bab

&nbsp;   - getBab22SubabClosingText() : Resolve paragraf penutup sub-bab

&nbsp;   - addBab22SubabTables()      : Tambah tabel/gambar per sub-bab

&nbsp; - exportBab3()            : Export BAB 3: Kesimpulan

&nbsp;   - addKesimpulanItem()   : Tambah item kesimpulan bernomor

&nbsp; - addFooter()             : Tambah footer dengan tabel tanda tangan

&nbsp; - saveAndDownload()       : Simpan ke temp file, return download response

&nbsp; - resolveStoredImagePath(): Resolve path gambar dari storage



app/Services/Excel/EnkapsulasiExcelService.php

&nbsp; Service untuk generate template Excel (.xlsx) menggunakan PHPSpreadsheet.

&nbsp; Digunakan untuk membuat template input data enkapsulasi.

&nbsp; Fitur:

&nbsp; - Generate spreadsheet multi-sheet

&nbsp; - Style otomatis (border, warna, alignment)

&nbsp; - Dynamic header berdasarkan kode batch

&nbsp; - Sanitasi nama sheet





--- VIEWS ---



resources/views/layouts/app.blade.php

&nbsp; Layout utama seluruh halaman. Berisi:

&nbsp; - Import Google Fonts (Manrope) dan Material Symbols

&nbsp; - @vite directive untuk CSS/JS

&nbsp; - Script inisialisasi tema (dark/light mode dari localStorage)

&nbsp; - Sidebar + Header + Content area

&nbsp; - Script handler settings (sidebar collapse, tema)



resources/views/components/sidebar.blade.php

&nbsp; Sidebar navigasi kiri. Menu items:

&nbsp; - Template Summary (link ke index)

&nbsp; - Draft Summary (link ke drafts)

&nbsp; - Settings

&nbsp; - Tombol collapse sidebar



resources/views/template-summary/index.blade.php

&nbsp; Halaman pemilihan template. Menampilkan:

&nbsp; - Card "Template Kosong" dengan pilihan jenis sediaan:

&nbsp;   - Sirup (aktif, bisa diklik)

&nbsp;   - Tablet (coming soon, disabled)

&nbsp;   - Kapsul (coming soon, disabled)

&nbsp; - Card "Lanjutkan Draft" dengan daftar draft sirup yang tersimpan



resources/views/template-summary/drafts.blade.php

&nbsp; Halaman daftar semua draft tersimpan (full page view).

&nbsp; Fitur: lihat, edit, hapus draft.



resources/views/template-summary/sirup/editor.blade.php (**Terpenting**)

&nbsp; Ini adalah HALAMAN UTAMA aplikasi.

&nbsp; Berisi form editor template sirup lengkap:



&nbsp; Struktur dokumen yang di-generate:

&nbsp; - Judul Summary (nama produk, formula, line, bagian, dokumen no, tanggal)

&nbsp; - BAB 1: Pendahuluan

&nbsp;   - 1.1 Tujuan (template text dengan input fill-in-the-blank)

&nbsp;   - 1.2 Batch Validasi (info batch + tabel bahan aktif dari Excel paste)

&nbsp; - BAB 2: Rangkuman Hasil

&nbsp;   - 2.1 (teks statis)

&nbsp;   - 2.2 Hasil pemeriksaan sampel — SUB-BAB DINAMIS:

&nbsp;     - Mixing (default, bisa di-toggle enable/disable)

&nbsp;     - Custom sub-bab bisa ditambah (Filling, dll.)

&nbsp;     - Setiap sub-bab punya: upload gambar tabel + upload Excel arsip

&nbsp;     - Sub-bab bisa di-drag-and-drop untuk re-order

&nbsp;     - Closing text per sub-bab (memenuhi/tidak memenuhi syarat)

&nbsp; - BAB 3: Kesimpulan

&nbsp;   - 3.1 s/d 3.5 (poin-poin kesimpulan, bisa di-toggle enable/disable)

&nbsp;   - Custom poin kesimpulan bisa ditambah

&nbsp; - Footer: Tombol "Simpan Draft" dan "Export ke Word"



&nbsp; Fitur JavaScript di file ini:

&nbsp; - Sync input: Satu field bisa sinkron otomatis ke field lain

&nbsp;   (contoh: nama\_produk di Judul otomatis mengisi nama\_produk di Tujuan)

&nbsp; - Excel paste handler: Copy dari Excel, paste langsung ke tabel preview

&nbsp; - Image preview: Upload gambar, lihat preview langsung

&nbsp; - Dynamic sub-bab: Tambah/hapus/reorder sub-bab BAB 2.2

&nbsp; - Enable/disable section: Klik nomor untuk toggle section

&nbsp; - Save draft via AJAX: Kumpulkan semua state form, kirim ke server

&nbsp; - Restore draft: Load draft dari server, restore semua state form

&nbsp; - Drag-and-drop: Reorder sub-bab dengan drag



resources/views/settings.blade.php

&nbsp; Halaman pengaturan. Menampilkan info versi app, status database,

&nbsp; dan preferensi user (tema, default jenis sediaan).





--- MIGRATIONS ---



database/migrations/2026\_02\_11\_000001\_create\_template\_summary\_drafts\_table.php

&nbsp; Membuat tabel `template\_summary\_drafts`:

&nbsp; - id: bigint auto-increment

&nbsp; - draft\_type: varchar(50), indexed — tipe template ('sirup')

&nbsp; - title: varchar, nullable — judul draft

&nbsp; - payload: longText, nullable — JSON blob semua data form

&nbsp; - last\_saved\_at: timestamp, nullable, indexed

&nbsp; - created\_at, updated\_at: timestamps Laravel





--- KONFIGURASI ---



.env / .env.production

&nbsp; - DB\_CONNECTION=sqlite

&nbsp; - DB\_DATABASE=database/database.sqlite  (relative path)

&nbsp; - SESSION\_DRIVER=file

&nbsp; - QUEUE\_CONNECTION=sync  (tidak pakai queue)

&nbsp; - CACHE\_STORE=file

&nbsp; - APP\_URL=http://127.0.0.1:8000



.env.example

&nbsp; - Sama seperti .env tapi untuk development

&nbsp; - SESSION\_DRIVER=database, QUEUE\_CONNECTION=database

&nbsp; - Butuh `php artisan migrate` lebih lengkap



tailwind.config.js

&nbsp; - darkMode: "class" (toggle dark mode via class di <html>)

&nbsp; - Warna custom: primary=#ef4444 (merah), bg-light=#f6f6f8, bg-dark=#101622

&nbsp; - Font: Manrope

&nbsp; - CATATAN: Ini Tailwind v4 — import via `@import "tailwindcss"` di app.css,

&nbsp;   BUKAN via postcss.config.js seperti Tailwind v3



vite.config.js

&nbsp; - Plugin: laravel-vite-plugin + @tailwindcss/vite

&nbsp; - Input: resources/css/app.css + resources/js/app.js

&nbsp; - Auto-refresh saat file blade berubah



php.ini.portable

&nbsp; Template php.ini yang dicopy ke folder php/ saat setup.

&nbsp; Extension yang diaktifkan:

&nbsp; - pdo\_sqlite, sqlite3 (database)

&nbsp; - mbstring (string multibyte)

&nbsp; - fileinfo (deteksi tipe file)

&nbsp; - openssl (enkripsi/HTTPS)

&nbsp; - zip (handle file zip)

&nbsp; - gd (manipulasi gambar)

&nbsp; - curl (HTTP requests)





--- SCRIPTS BUILD \& DEPLOY ---



start.bat

&nbsp; Launcher produksi. Alur:

&nbsp; 1. Cek php/php.exe ada

&nbsp; 2. Set PHPRC ke folder php/

&nbsp; 3. Cek port 8000 tersedia

&nbsp; 4. Cek database.sqlite ada

&nbsp; 5. Start PHP built-in server (php -S 127.0.0.1:8000 -t public)

&nbsp; 6. Buka browser otomatis

&nbsp; 7. Tunggu tombol ditekan untuk stop

&nbsp; 8. Kill server by PID



setup\_php.ps1

&nbsp; Download dan setup PHP 8.2 portable otomatis:

&nbsp; 1. Download php-8.2.27-Win32-vs16-x64.zip dari windows.php.net

&nbsp; 2. Extract ke folder php/

&nbsp; 3. Copy php.ini dari php.ini.portable

&nbsp; 4. Verifikasi instalasi dan extension



build\_portable.ps1 (**WAJIB DIJALANKAN UNTUK BUILD PRODUKSI**)

&nbsp; Script build distribusi portable. Alur lengkap:

&nbsp; 1. Backup .env ke .env.backup

&nbsp; 2. Build frontend: `npm run build` (Vite production build)

&nbsp; 3. Copy .env.production ke .env

&nbsp; 4. Clear bootstrap cache Laravel

&nbsp; 5. `composer install --no-dev --classmap-authoritative --no-scripts`

&nbsp; 6. `php artisan package:discover`

&nbsp; 7. `php artisan optimize:clear`

&nbsp; 8. Buat database.sqlite + run migrations

&nbsp; 9. Copy semua file ke folder dist/ (TANPA artisan, TANPA node\_modules)

&nbsp; 10. Cleanup (hapus logs, cache, sessions dari dist)

&nbsp; 11. Buat junction public/storage → storage/app/public

&nbsp; 12. Verifikasi integritas distribusi

&nbsp; 

&nbsp; Output: folder `dist/E-Template-Portable/` siap distribusi.



&nbsp; Untuk restore ke mode development setelah build:

&nbsp;   Copy-Item .env.backup .env -Force

&nbsp;   composer install





================================================================================

&nbsp;      CARA SETUP DEVELOPMENT ENVIRONMENT (**JIKA INGIN MELANJUTKAN PROGRAM**)

================================================================================



PRASYARAT:

&nbsp; 1. PHP 8.2+ terinstall di system (atau gunakan XAMPP/Laragon)

&nbsp;    Download: https://windows.php.net/download

&nbsp;    Pilih: VS16 x64 Thread Safe

&nbsp;    Extension yang harus aktif di php.ini:

&nbsp;      pdo\_sqlite, sqlite3, mbstring, fileinfo, openssl, zip, gd, curl



&nbsp; 2. Composer (PHP package manager)

&nbsp;    Download: https://getcomposer.org/download/



&nbsp; 3. Node.js 18+ dan npm

&nbsp;    Download: https://nodejs.org/



LANGKAH SETUP:



&nbsp; 1. Clone/copy folder project



&nbsp; 2. Install PHP dependencies:

&nbsp;    > composer install



&nbsp; 3. Setup environment:

&nbsp;    > copy .env.example .env       (jika .env belum ada)

&nbsp;    > php artisan key:generate     (generate APP\_KEY)



&nbsp; 4. Setup database:

&nbsp;    > php artisan migrate          (buat tabel di database.sqlite)



&nbsp; 5. Install frontend dependencies:

&nbsp;    > npm install



&nbsp; 6. Jalankan development server:

&nbsp;    > npm run dev                 (terminal 1 — Vite dev server)

&nbsp;    > php artisan serve           (terminal 2 — Laravel server)

&nbsp;    

&nbsp;    ATAU gunakan shortcut (jalankan keduanya bersamaan):

&nbsp;    > composer dev

&nbsp;    (Ini menjalankan: php artisan serve + npm run dev + queue + pail secara

&nbsp;     bersamaan menggunakan concurrently)



&nbsp; 7. Buka browser ke http://127.0.0.1:8000





CATATAN DEVELOPMENT:



&nbsp; - Saat development, Vite berjalan di mode HMR (Hot Module Replacement).

&nbsp;   Perubahan pada file blade/css/js otomatis refresh di browser.



&nbsp; - Jangan edit file di folder public/build/ (auto-generated oleh Vite).



&nbsp; - Jika mengubah migration, jalankan:

&nbsp;   > php artisan migrate:fresh

&nbsp;   (HATI-HATI: ini akan menghapus semua data di database!)



&nbsp; - Untuk membuat migration baru:

&nbsp;   > php artisan make:migration nama\_migration



&nbsp; - Untuk membuat controller baru:

&nbsp;   > php artisan make:controller NamaController



&nbsp; - Untuk membuat model baru:

&nbsp;   > php artisan make:model NamaModel -m

&nbsp;   (flag -m otomatis buat migration file juga)





================================================================================

&nbsp;                    CARA BUILD UNTUK PRODUKSI

================================================================================



&nbsp; 1. Pastikan setup\_php.ps1 sudah dijalankan (PHP portable ada di folder php/):

&nbsp;    > powershell -ExecutionPolicy Bypass -File setup\_php.ps1



&nbsp; 2. Jalankan build script:

&nbsp;    > powershell -ExecutionPolicy Bypass -File build\_portable.ps1



&nbsp; 3. Hasil build ada di: dist\\E-Template-Portable\\

&nbsp;    

&nbsp; 4. Untuk test hasil build:

&nbsp;    > cd dist\\E-Template-Portable

&nbsp;    > .\\start.bat



&nbsp; 5. Untuk restore development environment setelah build:

&nbsp;    > Copy-Item .env.backup .env -Force

&nbsp;    > composer install





================================================================================

&nbsp;                   ALUR KERJA APLIKASI (USER FLOW)

================================================================================



&nbsp; 1. User buka aplikasi → Halaman "Template Summary"

&nbsp; 2. User pilih "Template Kosong" → pilih "Sirup"

&nbsp; 3. Editor sirup terbuka dengan template form pre-filled

&nbsp; 4. User mengisi data di template:

&nbsp;    - Info judul (nama produk, formula, line, bagian)

&nbsp;    - Info dokumen (nomor dokumen, tanggal)

&nbsp;    - BAB 1: Tujuan + Batch Validasi + Tabel Bahan Aktif (paste dari Excel)

&nbsp;    - BAB 2: Enable/disable sub-bab, upload gambar tabel, isi conclusion

&nbsp;    - BAB 3: Enable/disable poin kesimpulan, isi detail

&nbsp; 5. User bisa "Simpan Draft" kapan saja (disimpan ke database)

&nbsp; 6. User klik "Export ke Word" → download file .docx

&nbsp; 7. User bisa kembali ke halaman utama, pilih draft, lanjutkan editing





================================================================================

&nbsp;                 CARA MENAMBAH TEMPLATE BARU

================================================================================



Saat ini hanya template "Sirup" yang aktif. Untuk menambah template baru

(misal: Tablet, Kapsul), langkah-langkah umum:



&nbsp; 1. Buat view baru di:

&nbsp;    resources/views/template-summary/\[nama\_sediaan]/editor.blade.php

&nbsp;    (Referensi: copy dari sirup/editor.blade.php, modifikasi sesuai

&nbsp;    kebutuhan template sediaan baru)



&nbsp; 2. Buat export service baru di:

&nbsp;    app/Services/Export/\[NamaSediaan]ExportService.php

&nbsp;    (Referensi: copy dari SirupExportService.php, ubah struktur bab,

&nbsp;    tabel, dan format sesuai kebutuhan)



&nbsp; 3. Tambah method di TemplateSummaryController.php:

&nbsp;    - \[nama]Editor()  → tampilkan editor

&nbsp;    - export\[Nama]()  → handle export

&nbsp;    - save\[Nama]Draft() → handle save draft



&nbsp; 4. Tambah route di routes/web.php:

&nbsp;    Route::get('template-summary/\[nama]', \[..., '\[nama]Editor'])

&nbsp;    Route::post('template-summary/\[nama]/export', \[..., 'export\[Nama]'])

&nbsp;    Route::post('template-summary/\[nama]/draft', \[..., 'save\[Nama]Draft'])



&nbsp; 5. Update index.blade.php:

&nbsp;    Ubah card yang disabled menjadi link aktif ke route baru.



&nbsp; 6. (Opsional) Buat Excel service baru jika template butuh generate

&nbsp;    template Excel khusus.





================================================================================

&nbsp;          TROUBLESHOOTING DEVELOPMENT

================================================================================



Problem: Vite build error / Tailwind tidak bekerja

Solution: Pastikan menggunakan Tailwind CSS v4 syntax:

&nbsp; - Import di app.css: @import "tailwindcss";

&nbsp; - Config di app.css: @config "../../tailwind.config.js";

&nbsp; - Plugin Vite: @tailwindcss/vite (bukan postcss plugin)



Problem: "Class not found" setelah buat file baru

Solution: > composer dump-autoload



Problem: Migration error

Solution: > php artisan migrate:fresh

&nbsp; (Hapus database.sqlite, buat ulang)



Problem: Storage link error (gambar tidak muncul)

Solution: > php artisan storage:link

&nbsp; (Buat symlink public/storage → storage/app/public)



Problem: CSRF token mismatch (419 error)

Solution: Pastikan semua form memiliki @csrf directive atau

&nbsp; request AJAX menyertakan X-CSRF-TOKEN header.



Problem: File upload terlalu besar

Solution: Edit php.ini (atau php.ini.portable untuk production):

&nbsp; post\_max\_size = 50M

&nbsp; upload\_max\_filesize = 50M





================================================================================

&nbsp;                        CATATAN PENTING

================================================================================



1\. TENTANG TAILWIND CSS V4:

&nbsp;  Versi 4 SANGAT BERBEDA dari versi 3. Jangan ikuti tutorial Tailwind v3.

&nbsp;  - Tidak ada lagi postcss.config.js untuk Tailwind

&nbsp;  - Config diimport langsung di CSS: @config "path/to/config"

&nbsp;  - Plugin via Vite, bukan PostCSS



2\. TENTANG PORTABLE BUILD:

&nbsp;  - Artisan TIDAK di-ikutkan dalam distribusi (start.bat langsung

&nbsp;    menjalankan PHP built-in server)

&nbsp;  - Jangan jalankan `php artisan` command apapun di production

&nbsp;  - Migration hanya dijalankan saat BUILD, bukan saat runtime



3\. TENTANG DATABASE:

&nbsp;  - SQLite = single file (database/database.sqlite)

&nbsp;  - SELURUH data form disimpan sebagai JSON di kolom `payload`

&nbsp;  - Jangan normalize payload ke tabel relasional — ini by design

&nbsp;    untuk fleksibilitas template yang berbeda-beda



4\. TENTANG GAMBAR:

&nbsp;  - Gambar upload disimpan di: storage/app/public/drafts/{draft\_id}/

&nbsp;  - Diakses via public URL: /storage/drafts/{draft\_id}/filename

&nbsp;  - Symlink/junction: public/storage → storage/app/public



5\. TENTANG JAVASCRIPT:

&nbsp;  - Semua JS logic ada INLINE di editor.blade.php (bukan file terpisah)

&nbsp;  - Ini by design karena JS-nya sangat terikat dengan DOM template

&nbsp;  - Jika ingin refactor ke file terpisah, pastikan semua DOM reference

&nbsp;    tetap valid



6\. SYNC INPUT MECHANISM:

&nbsp;  - Input dengan class "sync-input" dan data-sync="field\_name" akan

&nbsp;    otomatis sinkronisasi nilainya ke semua input dengan data-sync

&nbsp;    yang sama

&nbsp;  - Contoh: Semua input data-sync="nama\_produk" akan punya value sama





================================================================================

&nbsp;                       Version 2.0 | Built with Laravel 12

================================================================================



