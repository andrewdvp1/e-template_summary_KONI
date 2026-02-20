================================================================================
                    E-Template (ReportGenerator v2.0)
               Panduan Developer / Dokumentasi Teknis
================================================================================

DESKRIPSI SINGKAT
-----------------
E-Template adalah aplikasi web berbasis Laravel yang berfungsi sebagai
generator summary/laporan validasi proses produksi secara otomatis. User
memilih jenis sediaan (saat ini: Sirup), mengisi template form di browser,
lalu aplikasi meng-export data tersebut menjadi dokumen Word (.docx).

Aplikasi ini dirancang sebagai PORTABLE DESKTOP APP — artinya:
  - PHP runtime sudah di-bundle di dalam folder `php/`
  - Database menggunakan SQLite (tanpa MySQL/PostgreSQL)
  - Tidak perlu install web server (Apache/Nginx)
  - Dijalankan cukup dengan double-click `start.bat`

Database (SQLite) hanya digunakan untuk:
  - Menyimpan draft laporan (JSON payload)
  - Menyimpan referensi path gambar yang di-upload


================================================================================
                           TECH STACK & VERSI
================================================================================

Backend:
  - PHP              : 8.2.x (Thread Safe, VS16 x64)
  - Laravel          : 12.x (framework PHP)
  - PHPWord          : ^1.3 (generate dokumen .docx)
  - PHPSpreadsheet   : ^5.4 (generate template Excel)

Frontend:
  - Tailwind CSS     : 4.x (versi 4, BUKAN versi 3 — konfigurasi berbeda!)
  - Vite             : 7.x (build tool, menggantikan webpack/mix)
  - Google Fonts     : Manrope (font utama)
  - Material Symbols : Outlined (icon set)

Database:
  - SQLite           : File-based database (`database/database.sqlite`)

Build Tools:
  - Node.js/npm      : Untuk install dan build frontend dependencies
  - Composer         : Untuk install PHP dependencies


================================================================================
                      STRUKTUR FOLDER UTAMA
================================================================================

ReportGenerator_v2.0/
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
│       ├── 0001_01_01_000000_create_users_table.php
│       ├── 0001_01_01_000001_create_cache_table.php
│       ├── 0001_01_01_000002_create_jobs_table.php
│       └── 2026_02_11_000001_create_template_summary_drafts_table.php  # ★
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
├── build_portable.ps1             # ★ Script build distribusi portable
├── setup_php.ps1                  # ★ Script download & setup PHP runtime
│
└── README.txt                     # File ini


================================================================================
               PENJELASAN FILE-FILE UTAMA
================================================================================

--- ROUTES ---

routes/web.php
  Mendefinisikan semua URL / endpoint yang tersedia:

  GET  /                              → Home, redirect ke template-summary
  GET  /template-summary              → Halaman pilih template (index)
  GET  /template-summary/drafts       → Halaman daftar semua draft
  GET  /template-summary/sirup        → Editor template sirup
  GET  /template-summary/sirup?draft=ID → Load draft tertentu ke editor
  POST /template-summary/sirup/draft  → Simpan draft (AJAX, JSON response)
  POST /template-summary/sirup/export → Export ke Word (.docx), download file
  POST /template-summary/parse-excel  → Parse file Excel yang di-upload
  DELETE /template-summary/drafts/{id}→ Hapus draft
  GET  /settings                      → Halaman settings
  GET  /settings/database-status      → AJAX cek koneksi database


--- CONTROLLERS ---

app/Http/Controllers/TemplateSummaryController.php (★ Paling Penting)
  Controller utama. Berisi ~500 baris kode. Method-method utama:

  - index()           : Menampilkan halaman pilih template + daftar draft
  - drafts()          : Menampilkan halaman daftar semua draft (full page)
  - sirupEditor()     : Menampilkan editor sirup (baru atau dari draft)
  - exportSirup()     : Menerima form data, panggil SirupExportService, 
                         return file download .docx
  - saveSirupDraft()  : Menerima AJAX POST, simpan/update draft ke database.
                         Menangani upload file gambar (image) dan Excel.
                         Menyimpan semua form state sebagai JSON di kolom `payload`.
  - parseExcel()      : Menerima upload file Excel, parse isinya, return JSON
  - deleteDraft()     : Hapus draft + file terkait dari storage
  
  Helper methods (private):
  - storeDraftFileGroup()     : Upload & simpan file ke storage/app/public
  - resolveDraftTitle()       : Generate judul draft dari data form
  - deleteDraftStorageDirectory() : Hapus folder storage draft
  - publicStorageUrl()        : Convert storage path ke public URL
  - cleanupRemovedDraftFiles(): Hapus file lama saat draft di-update
  - extractStoredFilePaths()  : Ambil semua path file dari state draft
  - normalizeStoredFilesUrl() : Normalisasi URL file untuk kompatibilitas
  - normalizeStoredFileGroup(): Normalisasi path per group file
  - normalizeStoredFilePath() : Normalisasi single path (handle legacy format)

app/Http/Controllers/SettingsController.php
  - index()          : Tampilkan halaman settings (versi app, info system)
  - checkDatabase()  : AJAX endpoint cek koneksi database, return JSON


--- MODELS ---

app/Models/TemplateSummaryDraft.php
  Tabel: template_summary_drafts
  Kolom:
    - id             : Primary key
    - draft_type     : Tipe template (misal: 'sirup')
    - title          : Judul draft (auto-generated dari data form)
    - payload        : JSON longText — menyimpan SELURUH state form editor.
                       Termasuk: semua input values, posisi sub-bab, section
                       yang enabled/disabled, path file gambar, dll.
    - last_saved_at  : Timestamp terakhir disimpan
    - created_at     : Timestamp dibuat
    - updated_at     : Timestamp diupdate


--- SERVICES ---

app/Services/Export/SirupExportService.php (★ Paling Penting #2)
  Service yang meng-generate dokumen Word (.docx) menggunakan PHPWord.
  ~700 baris kode. Method-method utama:

  - export($data)           : Entry point. Terima array data dari controller,
                              panggil semua method build, return download.
  - setupDocument()         : Konfigurasi halaman (A4, margin, font default)
  - addHeader()             : Tambah header dokumen (logo, info perusahaan)
  - addDocumentTitle()      : Tambah judul summary
  - addDocumentInfoTable()  : Tambah tabel info (Dokumen No, Tanggal, dll)
  - exportBab1()            : Export BAB 1: Pendahuluan
    - addBahanAktifTable()  : Tambah tabel bahan aktif dari data Excel paste
  - exportBab2()            : Export BAB 2: Rangkuman Hasil
    - getDnabledBab22SubabKeys() : Ambil sub-bab yang aktif
    - getBab22SubabTitle()       : Resolve judul sub-bab
    - getBab22SubabClosingText() : Resolve paragraf penutup sub-bab
    - addBab22SubabTables()      : Tambah tabel/gambar per sub-bab
  - exportBab3()            : Export BAB 3: Kesimpulan
    - addKesimpulanItem()   : Tambah item kesimpulan bernomor
  - addFooter()             : Tambah footer dengan tabel tanda tangan
  - saveAndDownload()       : Simpan ke temp file, return download response
  - resolveStoredImagePath(): Resolve path gambar dari storage

app/Services/Excel/EnkapsulasiExcelService.php
  Service untuk generate template Excel (.xlsx) menggunakan PHPSpreadsheet.
  Digunakan untuk membuat template input data enkapsulasi.
  ~384 baris. Fitur:
  - Generate spreadsheet multi-sheet
  - Style otomatis (border, warna, alignment)
  - Dynamic header berdasarkan kode batch
  - Sanitasi nama sheet


--- VIEWS ---

resources/views/layouts/app.blade.php
  Layout utama seluruh halaman. Berisi:
  - Import Google Fonts (Manrope) dan Material Symbols
  - @vite directive untuk CSS/JS
  - Script inisialisasi tema (dark/light mode dari localStorage)
  - Sidebar + Header + Content area
  - Script handler settings (sidebar collapse, tema)

resources/views/components/sidebar.blade.php
  Sidebar navigasi kiri. Menu items:
  - Template Summary (link ke index)
  - Draft Summary (link ke drafts)
  - Settings
  - Tombol collapse sidebar

resources/views/template-summary/index.blade.php
  Halaman pemilihan template. Menampilkan:
  - Card "Template Kosong" dengan pilihan jenis sediaan:
    - Sirup (aktif, bisa diklik)
    - Tablet (coming soon, disabled)
    - Kapsul (coming soon, disabled)
  - Card "Lanjutkan Draft" dengan daftar draft sirup yang tersimpan

resources/views/template-summary/drafts.blade.php
  Halaman daftar semua draft tersimpan (full page view).
  Fitur: lihat, edit, hapus draft.

resources/views/template-summary/sirup/editor.blade.php (★ Terpenting)
  File terbesar (~1700 baris, ~96KB). Ini adalah HALAMAN UTAMA aplikasi.
  Berisi form editor template sirup lengkap:

  Struktur dokumen yang di-generate:
  - Judul Summary (nama produk, formula, line, bagian, dokumen no, tanggal)
  - BAB 1: Pendahuluan
    - 1.1 Tujuan (template text dengan input fill-in-the-blank)
    - 1.2 Batch Validasi (info batch + tabel bahan aktif dari Excel paste)
  - BAB 2: Rangkuman Hasil
    - 2.1 (teks statis)
    - 2.2 Hasil pemeriksaan sampel — SUB-BAB DINAMIS:
      - Mixing (default, bisa di-toggle enable/disable)
      - Custom sub-bab bisa ditambah (Filling, dll.)
      - Setiap sub-bab punya: upload gambar tabel + upload Excel arsip
      - Sub-bab bisa di-drag-and-drop untuk re-order
      - Closing text per sub-bab (memenuhi/tidak memenuhi syarat)
  - BAB 3: Kesimpulan
    - 3.1 s/d 3.5 (poin-poin kesimpulan, bisa di-toggle enable/disable)
    - Custom poin kesimpulan bisa ditambah
  - Footer: Tombol "Simpan Draft" dan "Export ke Word"

  Fitur JavaScript di file ini:
  - Sync input: Satu field bisa sinkron otomatis ke field lain
    (contoh: nama_produk di Judul otomatis mengisi nama_produk di Tujuan)
  - Excel paste handler: Copy dari Excel, paste langsung ke tabel preview
  - Image preview: Upload gambar, lihat preview langsung
  - Dynamic sub-bab: Tambah/hapus/reorder sub-bab BAB 2.2
  - Enable/disable section: Klik nomor untuk toggle section
  - Save draft via AJAX: Kumpulkan semua state form, kirim ke server
  - Restore draft: Load draft dari server, restore semua state form
  - Drag-and-drop: Reorder sub-bab dengan drag

resources/views/settings.blade.php
  Halaman pengaturan. Menampilkan info versi app, status database,
  dan preferensi user (tema, default jenis sediaan).


--- MIGRATIONS ---

database/migrations/2026_02_11_000001_create_template_summary_drafts_table.php
  Membuat tabel `template_summary_drafts`:
  - id: bigint auto-increment
  - draft_type: varchar(50), indexed — tipe template ('sirup')
  - title: varchar, nullable — judul draft
  - payload: longText, nullable — JSON blob semua data form
  - last_saved_at: timestamp, nullable, indexed
  - created_at, updated_at: timestamps Laravel


--- KONFIGURASI ---

.env / .env.production
  - DB_CONNECTION=sqlite
  - DB_DATABASE=database/database.sqlite  (relative path)
  - SESSION_DRIVER=file
  - QUEUE_CONNECTION=sync  (tidak pakai queue)
  - CACHE_STORE=file
  - APP_URL=http://127.0.0.1:8000

.env.example
  - Sama seperti .env tapi untuk development
  - SESSION_DRIVER=database, QUEUE_CONNECTION=database
  - Butuh `php artisan migrate` lebih lengkap

tailwind.config.js
  - darkMode: "class" (toggle dark mode via class di <html>)
  - Warna custom: primary=#ef4444 (merah), bg-light=#f6f6f8, bg-dark=#101622
  - Font: Manrope
  - CATATAN: Ini Tailwind v4 — import via `@import "tailwindcss"` di app.css,
    BUKAN via postcss.config.js seperti Tailwind v3

vite.config.js
  - Plugin: laravel-vite-plugin + @tailwindcss/vite
  - Input: resources/css/app.css + resources/js/app.js
  - Auto-refresh saat file blade berubah

php.ini.portable
  Template php.ini yang dicopy ke folder php/ saat setup.
  Extension yang diaktifkan:
  - pdo_sqlite, sqlite3 (database)
  - mbstring (string multibyte)
  - fileinfo (deteksi tipe file)
  - openssl (enkripsi/HTTPS)
  - zip (handle file zip)
  - gd (manipulasi gambar)
  - curl (HTTP requests)


--- SCRIPTS BUILD & DEPLOY ---

start.bat
  Launcher produksi. Alur:
  1. Cek php/php.exe ada
  2. Set PHPRC ke folder php/
  3. Cek port 8000 tersedia
  4. Cek database.sqlite ada
  5. Start PHP built-in server (php -S 127.0.0.1:8000 -t public)
  6. Buka browser otomatis
  7. Tunggu tombol ditekan untuk stop
  8. Kill server by PID

setup_php.ps1
  Download dan setup PHP 8.2 portable otomatis:
  1. Download php-8.2.27-Win32-vs16-x64.zip dari windows.php.net
  2. Extract ke folder php/
  3. Copy php.ini dari php.ini.portable
  4. Verifikasi instalasi dan extension

build_portable.ps1 (★ WAJIB DIJALANKAN UNTUK BUILD PRODUKSI)
  Script build distribusi portable. Alur lengkap:
  1. Backup .env ke .env.backup
  2. Build frontend: `npm run build` (Vite production build)
  3. Copy .env.production ke .env
  4. Clear bootstrap cache Laravel
  5. `composer install --no-dev --classmap-authoritative --no-scripts`
  6. `php artisan package:discover`
  7. `php artisan optimize:clear`
  8. Buat database.sqlite + run migrations
  9. Copy semua file ke folder dist/ (TANPA artisan, TANPA node_modules)
  10. Cleanup (hapus logs, cache, sessions dari dist)
  11. Buat junction public/storage → storage/app/public
  12. Verifikasi integritas distribusi
  
  Output: folder `dist/E-Template-Portable/` siap distribusi.

  Untuk restore ke mode development setelah build:
    Copy-Item .env.backup .env -Force
    composer install


================================================================================
              CARA SETUP DEVELOPMENT ENVIRONMENT
================================================================================

PRASYARAT:
  1. PHP 8.2+ terinstall di system (atau gunakan XAMPP/Laragon)
     Download: https://windows.php.net/download
     Pilih: VS16 x64 Thread Safe
     Extension yang harus aktif di php.ini:
       pdo_sqlite, sqlite3, mbstring, fileinfo, openssl, zip, gd, curl

  2. Composer (PHP package manager)
     Download: https://getcomposer.org/download/

  3. Node.js 18+ dan npm
     Download: https://nodejs.org/

LANGKAH SETUP:

  1. Clone/copy folder project

  2. Install PHP dependencies:
     > composer install

  3. Setup environment:
     > copy .env.example .env       (jika .env belum ada)
     > php artisan key:generate     (generate APP_KEY)

  4. Setup database:
     > php artisan migrate          (buat tabel di database.sqlite)

  5. Install frontend dependencies:
     > npm install

  6. Jalankan development server:
     > npm run dev                 (terminal 1 — Vite dev server)
     > php artisan serve           (terminal 2 — Laravel server)
     
     ATAU gunakan shortcut (jalankan keduanya bersamaan):
     > composer dev
     (Ini menjalankan: php artisan serve + npm run dev + queue + pail secara
      bersamaan menggunakan concurrently)

  7. Buka browser ke http://127.0.0.1:8000


CATATAN DEVELOPMENT:

  - Saat development, Vite berjalan di mode HMR (Hot Module Replacement).
    Perubahan pada file blade/css/js otomatis refresh di browser.

  - Jangan edit file di folder public/build/ (auto-generated oleh Vite).

  - Jika mengubah migration, jalankan:
    > php artisan migrate:fresh
    (HATI-HATI: ini akan menghapus semua data di database!)

  - Untuk membuat migration baru:
    > php artisan make:migration nama_migration

  - Untuk membuat controller baru:
    > php artisan make:controller NamaController

  - Untuk membuat model baru:
    > php artisan make:model NamaModel -m
    (flag -m otomatis buat migration file juga)


================================================================================
                     CARA BUILD UNTUK PRODUKSI
================================================================================

  1. Pastikan setup_php.ps1 sudah dijalankan (PHP portable ada di folder php/):
     > powershell -ExecutionPolicy Bypass -File setup_php.ps1

  2. Jalankan build script:
     > powershell -ExecutionPolicy Bypass -File build_portable.ps1

  3. Hasil build ada di: dist\E-Template-Portable\
     
  4. Untuk test hasil build:
     > cd dist\E-Template-Portable
     > .\start.bat

  5. Untuk restore development environment setelah build:
     > Copy-Item .env.backup .env -Force
     > composer install


================================================================================
                    ALUR KERJA APLIKASI (USER FLOW)
================================================================================

  1. User buka aplikasi → Halaman "Template Summary"
  2. User pilih "Template Kosong" → pilih "Sirup"
  3. Editor sirup terbuka dengan template form pre-filled
  4. User mengisi data di template:
     - Info judul (nama produk, formula, line, bagian)
     - Info dokumen (nomor dokumen, tanggal)
     - BAB 1: Tujuan + Batch Validasi + Tabel Bahan Aktif (paste dari Excel)
     - BAB 2: Enable/disable sub-bab, upload gambar tabel, isi conclusion
     - BAB 3: Enable/disable poin kesimpulan, isi detail
  5. User bisa "Simpan Draft" kapan saja (disimpan ke database)
  6. User klik "Export ke Word" → download file .docx
  7. User bisa kembali ke halaman utama, pilih draft, lanjutkan editing


================================================================================
                  CARA MENAMBAH TEMPLATE BARU
================================================================================

Saat ini hanya template "Sirup" yang aktif. Untuk menambah template baru
(misal: Tablet, Kapsul), langkah-langkah umum:

  1. Buat view baru di:
     resources/views/template-summary/[nama_sediaan]/editor.blade.php
     (Referensi: copy dari sirup/editor.blade.php, modifikasi sesuai
     kebutuhan template sediaan baru)

  2. Buat export service baru di:
     app/Services/Export/[NamaSediaan]ExportService.php
     (Referensi: copy dari SirupExportService.php, ubah struktur bab,
     tabel, dan format sesuai kebutuhan)

  3. Tambah method di TemplateSummaryController.php:
     - [nama]Editor()  → tampilkan editor
     - export[Nama]()  → handle export
     - save[Nama]Draft() → handle save draft

  4. Tambah route di routes/web.php:
     Route::get('template-summary/[nama]', [..., '[nama]Editor'])
     Route::post('template-summary/[nama]/export', [..., 'export[Nama]'])
     Route::post('template-summary/[nama]/draft', [..., 'save[Nama]Draft'])

  5. Update index.blade.php:
     Ubah card yang disabled menjadi link aktif ke route baru.

  6. (Opsional) Buat Excel service baru jika template butuh generate
     template Excel khusus.


================================================================================
           TROUBLESHOOTING DEVELOPMENT
================================================================================

Problem: Vite build error / Tailwind tidak bekerja
Solution: Pastikan menggunakan Tailwind CSS v4 syntax:
  - Import di app.css: @import "tailwindcss";
  - Config di app.css: @config "../../tailwind.config.js";
  - Plugin Vite: @tailwindcss/vite (bukan postcss plugin)

Problem: "Class not found" setelah buat file baru
Solution: > composer dump-autoload

Problem: Migration error
Solution: > php artisan migrate:fresh
  (Hapus database.sqlite, buat ulang)

Problem: Storage link error (gambar tidak muncul)
Solution: > php artisan storage:link
  (Buat symlink public/storage → storage/app/public)

Problem: CSRF token mismatch (419 error)
Solution: Pastikan semua form memiliki @csrf directive atau
  request AJAX menyertakan X-CSRF-TOKEN header.

Problem: File upload terlalu besar
Solution: Edit php.ini (atau php.ini.portable untuk production):
  post_max_size = 50M
  upload_max_filesize = 50M


================================================================================
                         CATATAN PENTING
================================================================================

1. TENTANG TAILWIND CSS V4:
   Versi 4 SANGAT BERBEDA dari versi 3. Jangan ikuti tutorial Tailwind v3.
   - Tidak ada lagi postcss.config.js untuk Tailwind
   - Config diimport langsung di CSS: @config "path/to/config"
   - Plugin via Vite, bukan PostCSS

2. TENTANG PORTABLE BUILD:
   - Artisan TIDAK di-ikutkan dalam distribusi (start.bat langsung
     menjalankan PHP built-in server)
   - Jangan jalankan `php artisan` command apapun di production
   - Migration hanya dijalankan saat BUILD, bukan saat runtime

3. TENTANG DATABASE:
   - SQLite = single file (database/database.sqlite)
   - SELURUH data form disimpan sebagai JSON di kolom `payload`
   - Jangan normalize payload ke tabel relasional — ini by design
     untuk fleksibilitas template yang berbeda-beda

4. TENTANG GAMBAR:
   - Gambar upload disimpan di: storage/app/public/drafts/{draft_id}/
   - Diakses via public URL: /storage/drafts/{draft_id}/filename
   - Symlink/junction: public/storage → storage/app/public

5. TENTANG JAVASCRIPT:
   - Semua JS logic ada INLINE di editor.blade.php (bukan file terpisah)
   - Ini by design karena JS-nya sangat terikat dengan DOM template
   - Jika ingin refactor ke file terpisah, pastikan semua DOM reference
     tetap valid

6. SYNC INPUT MECHANISM:
   - Input dengan class "sync-input" dan data-sync="field_name" akan
     otomatis sinkronisasi nilainya ke semua input dengan data-sync
     yang sama
   - Contoh: Semua input data-sync="nama_produk" akan punya value sama


================================================================================
                        Version 2.0 | Built with Laravel 12
================================================================================
