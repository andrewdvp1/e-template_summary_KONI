<?php

namespace App\Services\Export;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\ComplexType\TblWidth;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

class QFomilExportService
{
    protected PhpWord $phpWord;
    protected Section $section;
    protected array $data;

    /**
     * Ambil nilai dari data form. Jika kosong/null, gunakan fallback.
     * Ini menangani kasus input yang tidak punya value attribute (hanya placeholder)
     * sehingga saat submit mengirim string kosong "".
     */
    protected function d(string $key, string $fallback = '-'): string
    {
        $val = trim((string) ($this->data[$key] ?? ''));
        return $val !== '' ? $val : $fallback;
    }

    /**
     * Export the Q-Fomil template to Word document
     */
    public function export(array $data)
    {
        $this->data = $data;
        $this->phpWord = new PhpWord();

        Settings::setOutputEscapingEnabled(true);

        $this->setupDocument();
        $this->addHeader();
        $this->addDocumentTitle();
        $this->addDocumentInfoTable();
        $this->exportBab1();
        $this->exportBab2();
        $this->exportBab3();
        $this->addFooter();

        return $this->saveAndDownload();
    }

    /**
     * Setup document configuration
     */
    protected function setupDocument(): void
    {
        $this->phpWord->setDefaultFontName('Helvetica');
        $this->phpWord->setDefaultFontSize(11);

        $this->section = $this->phpWord->addSection([
            'marginTop' => 850,
            'marginBottom' => 850,
            'marginLeft' => 850,
            'marginRight' => 850,
            'headerHeight' => 480,
            'borderTopSize' => 6,
            'borderBottomSize' => 6,
            'borderLeftSize' => 6,
            'borderRightSize' => 6,
        ]);
    }

    /**
     * Add document header with company info
     */
    protected function addHeader(): void
    {
        $header = $this->section->addHeader();
        $headerTable = $header->addTable([
            'width' => 10915,
            'unit' => 'dxa',
            'borderSize' => 6,
            'cellMargin' => 50,
            'indent' => new TblWidth(-310, 'dxa'),
        ]);

        $col1 = 4100;
        $col2 = 3150;
        $col3 = 3675;

        // Row 1
        $headerTable->addRow(350);
        $headerTable->addCell($col1, [
            'borderRightSize' => 0,
            'borderRightColor' => 'FFFFFF',
            'borderBottomSize' => 0,
            'borderBottomColor' => 'FFFFFF'
        ])->addText(' PT KONIMEX', ['bold' => true, 'italic' => true, 'size' => 14], ['spaceAfter' => 0]);

        $cellHalaman = $headerTable->addCell($col2, [
            'borderLeftSize' => 0,
            'borderLeftColor' => 'FFFFFF',
            'borderRightSize' => 0,
            'borderRightColor' => 'FFFFFF',
            'borderBottomSize' => 0,
            'borderBottomColor' => 'FFFFFF'
        ]);
        $cellHalaman->addPreserveText('Halaman {PAGE} dari {NUMPAGES}', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);

        // Fixed Nomor (not from form)
        $headerTable->addCell($col3, ['borderColor' => '000000', 'borderSize' => 6])
            ->addText('Nomor            : AF-00185-01', ['size' => 11], ['alignment' => 'left', 'spaceAfter' => 0]);

        // Row 2
        $headerTable->addRow(250);
        $headerTable->addCell($col1 + $col2, [
            'gridSpan' => 2,
            'valign' => 'center',
            'borderTopSize' => 0,
            'borderTopColor' => 'FFFFFF',
        ])->addText('SUMMARY LAPORAN VALIDASI/ KUALIFIKASI', ['bold' => true, 'size' => 14], ['alignment' => 'center', 'spaceAfter' => 0]);

        // Fixed Tanggal Terbit (not from form)
        $headerTable->addCell($col3, ['valign' => 'center', 'borderTopSize' => 6, 'borderColor' => '000000'])
            ->addText('Tanggal Terbit : 15-03-2024', ['size' => 11], ['spaceAfter' => 0]);
    }

    /**
     * Add document title (from Judul Summary section)
     */
    protected function addDocumentTitle(): void
    {
        $this->section->addTextBreak(1);

        $namaProduk = strtoupper($this->d('judul_nama_produk', 'Q-FOMIL'));
        $line       = strtoupper($this->d('judul_line', 'OBAT DALAM'));
        $bagian     = strtoupper($this->d('judul_bagian', $this->d('tujuan_bagian', 'PRODUCTION NATPRO & EXTRACTION BANGUNAN IOT NATPRO')));

        // Baris 1: SUMMARY ... PRODUK [NAMA] DI LINI [LINE]
        $line1 = "SUMMARY LAPORAN VALIDASI PROSES PEMBUATAN PRODUK {$namaProduk} DI LINI {$line}";
        $this->section->addText($line1, ['bold' => true, 'size' => 12], ['alignment' => 'center', 'spaceAfter' => 0]);

        // Baris 2: BAGIAN [BAGIAN]
        $line2 = "BAGIAN {$bagian}";
        $this->section->addText($line2, ['bold' => true, 'size' => 12], ['alignment' => 'center', 'spaceAfter' => 0]);
    }

    /**
     * Add document info table
     */
    protected function addDocumentInfoTable(): void
    {
        $this->section->addTextBreak(1);

        $infoTable = $this->section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80, 'alignment' => 'center']);
        $cellParagraph = ['spaceAfter' => 0];

        $infoTable->addRow();
        $infoTable->addCell(2000)->addText('Dokumen No. :', ['size' => 11], $cellParagraph);
        $infoTable->addCell(3000)->addText($this->d('dokumen_no', '-'), ['size' => 11], $cellParagraph);
        $infoTable->addCell(1500)->addText('Tanggal :', ['size' => 11], $cellParagraph);
        $infoTable->addCell(2500)->addText($this->d('dokumen_tanggal', '-'), ['size' => 11], $cellParagraph);

        $infoTable->addRow();
        $infoTable->addCell(2000)->addText('Pengganti No. :', ['size' => 11], $cellParagraph);
        $infoTable->addCell(3000)->addText($this->d('pengganti_no', '-'), ['size' => 11], $cellParagraph);
        $infoTable->addCell(1500)->addText('Tanggal :', ['size' => 11], $cellParagraph);
        $infoTable->addCell(2500)->addText($this->d('pengganti_tanggal', '-'), ['size' => 11], $cellParagraph);

        $this->section->addTextBreak(1);
    }

    /**
     * Export Bab 1: Pendahuluan
     */
    protected function exportBab1(): void
    {
        $this->section->addText('1. PENDAHULUAN', ['bold' => true, 'size' => 12], [
            'alignment' => 'both',
            'spaceBefore' => 240,
            'contextualSpacing' => true,
        ]);

        // 1.1 Tujuan
        $textRun11 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 300],
            'contextualSpacing' => true,
        ]);
        $textRun11->addText('1.1', ['size' => 11]);
        $textRun11->addText('  Tujuan', ['size' => 11]);

        $namaProduk  = $this->d('tujuan_nama_produk', $this->d('judul_nama_produk', 'Q-Fomil'));
        $line        = $this->d('tujuan_line', 'Obat Dalam');
        $bagian      = $this->d('tujuan_bagian', 'Production Natpro & Extraction');
        $varian      = $this->d('varian_produk', 'kemasan botol');
        $namaProduk2 = $this->d('tujuan_nama_produk_2', $namaProduk);

        $tujuanText = "Summary validasi ini bertujuan mendokumentasikan hasil studi validasi/pembuktian terhadap " .
            "kualitas dan reprodusibilitas proses pengolahan produk {$namaProduk} di Lini {$line} Bagian {$bagian} " .
            "dalam menghasilkan produk yang memenuhi persyaratan mutu yang tercantum dalam Spesifikasi Produk dan " .
            "Kemasan {$namaProduk2} {$varian} yang berlaku.";

        $textRun111 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 740, 'hanging' => 440],
            'contextualSpacing' => true,
        ]);
        $textRun111->addText('1.1.1', ['size' => 11]);
        $textRun111->addText(' ' . $tujuanText, ['size' => 11]);

        // 1.2 Batch Validasi
        $textRun12 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 300],
            'contextualSpacing' => true,
        ]);
        $textRun12->addText('1.2', ['size' => 11]);
        $textRun12->addText('  Batch Validasi', ['size' => 11]);

        $jumlahBatch = $this->d('batch_jumlah', 'satu');
        $batchKode   = $this->d('batch_name', $this->d('batch_besaran', 'DEC25A01'));
        $besaran     = $this->d('batch_besaran', '21 kg');

        $batchText = "Studi validasi dilakukan terhadap {$jumlahBatch} batch produksi yaitu batch {$batchKode} dengan besaran batch {$besaran}.";

        $this->section->addText($batchText, ['size' => 11], [
            'alignment' => 'both',
            'indentation' => ['left' => 740],
            'contextualSpacing' => true,
        ]);

        $this->addBahanAktifTable();
    }

    /**
     * Add Bahan Aktif table from pasted Excel data
     */
    protected function addBahanAktifTable(): void
    {
        $tableDataJson = $this->data['tabel_bahan_aktif'] ?? '';

        if (empty($tableDataJson)) {
            return;
        }

        $tableData = json_decode($tableDataJson, true);

        if (empty($tableData) || !is_array($tableData)) {
            return;
        }

        $this->section->addTextBreak(1);

        // Table styling
        $tableStyle = [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 80,
            'width' => 10200,
            'unit' => 'dxa',
        ];

        $headerCellStyle = ['valign' => 'center'];
        $cellStyle = ['valign' => 'center'];
        $headerFontStyle = ['bold' => true, 'size' => 11];
        $cellFontStyle = ['size' => 11];
        $headerCellParagraph = ['alignment' => 'center', 'spaceAfter' => 0];
        $cellParagraph = ['alignment' => 'left', 'spaceAfter' => 0];

        // Column widths
        $col1 = 3000; // Bahan Aktif
        $col2 = 2300; // Kode Bahan Baku
        $col3 = 3700; // Nama Supplier
        $col4 = 1200; // Negara

        $table = $this->section->addTable($tableStyle);

        // Header row
        $table->addRow(100);
        $table->addCell($col1, $headerCellStyle)->addText('Bahan Aktif', $headerFontStyle, $headerCellParagraph);
        $table->addCell($col2, $headerCellStyle)->addText('Kode Bahan Baku', $headerFontStyle, $headerCellParagraph);
        $table->addCell($col3, $headerCellStyle)->addText('Nama Supplier', $headerFontStyle, $headerCellParagraph);
        $table->addCell($col4, $headerCellStyle)->addText('Negara', $headerFontStyle, $headerCellParagraph);

        // Data rows from pasted Excel
        foreach ($tableData as $row) {
            $table->addRow(250);
            $table->addCell($col1, $cellStyle)->addText($row[0] ?? '-', $cellFontStyle, $cellParagraph);
            $table->addCell($col2, $cellStyle)->addText($row[1] ?? '-', $cellFontStyle, $cellParagraph);
            $table->addCell($col3, $cellStyle)->addText($row[2] ?? '-', $cellFontStyle, $cellParagraph);
            $table->addCell($col4, $cellStyle)->addText($row[3] ?? '-', $cellFontStyle, $headerCellParagraph);
        }
    }

    /**
     * Export BAB 2: HASIL DAN EVALUASI PROSES
     */
    protected function exportBab2(): void
    {
        $this->section->addTextBreak(1);

        $this->section->addText('2. HASIL DAN EVALUASI PROSES', ['bold' => true, 'size' => 12], [
            'alignment' => 'both', 'spaceAfter' => 0,
        ]);

        // 2.1
        $enabledBab2 = array_map('trim', explode(',', $this->data['bab2_enabled_sections'] ?? '1,2,3'));

        if (in_array('1', $enabledBab2)) {
            $namaProduk  = $this->d('tujuan_nama_produk', $this->d('judul_nama_produk', 'Q-Fomil'));
            $batchKode21 = $this->d('batch_name', $this->d('batch_besaran', 'DEC25A01'));
            $metode      = $this->d('rangkuman_metode', 'penimbangan bahan baku, pencampuran, pencetakan, penyalutan, dan pengemasan primer (stripping)');
            $noDokumen   = $this->d('pencampuran_no_dokumen', 'CE-00467-01-NL');
            $tglDokumen  = $this->d('pencampuran_tanggal_dokumen', '07-11-2025');

            $textRun21 = $this->section->addTextRun([
                'alignment' => 'both', 'indentation' => ['left' => 740, 'hanging' => 440], 'contextualSpacing' => true,
            ]);
            $textRun21->addText('2.1.', ['size' => 11]);
            $textRun21->addText(" Seluruh tahapan pengolahan dan pengemasan primer {$namaProduk} batch {$batchKode21} yaitu {$metode} telah dilakukan sesuai MBR Pengolahan {$namaProduk}, no. dokumen {$noDokumen}, tanggal {$tglDokumen} dan MBR Pengemasan {$namaProduk}, no. Dokumen {$noDokumen}, tanggal {$tglDokumen} telah dilakukan sesuai prosedur pengolahan dan pengemasan yang berlaku.", ['size' => 11]);
        }

        // Shared map dibutuhkan oleh 2.3
        $tableSubabMap    = is_array($this->data['bab22_table_subab_key'] ?? null) ? $this->data['bab22_table_subab_key'] : [];
        $imageMap         = is_array($this->data['mixing_image_file'] ?? null) ? $this->data['mixing_image_file'] : [];
        $existingImageMap = is_array($this->data['existing_mixing_image_file'] ?? null) ? $this->data['existing_mixing_image_file'] : [];

        // 2.2 Pelaksanaan Proses Produksi — hanya tabel tunggal (table_1), sesuai blade
        $textRun22 = $this->section->addTextRun([
            'alignment' => 'both', 'indentation' => ['left' => 300], 'contextualSpacing' => true,
        ]);
        $textRun22->addText('2.2', ['size' => 11]);
        $textRun22->addText('  Pelaksanaan Proses Produksi', ['size' => 11]);

        // Render tabel table_1 langsung (bukan subab dinamis)
        $this->renderTableUid('table_1', $imageMap, $existingImageMap);

        // 2.3 Hasil Pemeriksaan Sampel — selalu ditampilkan (tidak tergantung bab2_enabled_sections)
        $textRun23 = $this->section->addTextRun([
            'alignment' => 'both', 'indentation' => ['left' => 300], 'contextualSpacing' => true,
        ]);
        $textRun23->addText('2.3', ['size' => 11]);
        $textRun23->addText('  Hasil pemeriksaan sampel pada masing-masing tahapan adalah sebagai berikut :', ['size' => 11]);

        $this->exportBab23($tableSubabMap, $imageMap, $existingImageMap);
    }

    /**
     * Export BAB 2.3: Detail pemeriksaan sampel (2.3.1–2.3.4)
     */
    protected function exportBab23(array $tableSubabMap, array $imageMap, array $existingImageMap): void
    {
        $namaProduk = $this->d('tujuan_nama_produk', $this->d('judul_nama_produk', 'Q-Fomil'));
        $batchName  = $this->d('batch_name', $this->d('batch_besaran', 'DEC25A01'));
        $mesin      = $this->d('tujuan_mesin', 'Double Cone Mixer DC 40');

        // ── 2.3.1 Tahap Pencampuran Akhir ──────────────────────────────
        $this->section->addText('2.3.1  Tahap Pencampuran Akhir', [ 'size' => 11], [
            'alignment' => 'both', 'indentation' => ['left' => 440], 'spaceBefore' => 120, 'spaceAfter' => 60,
        ]);

        $noDoc  = $this->d('pencampuran_no_dokumen', 'EA-F03-3-00261-00');
        $tglDoc = $this->d('pencampuran_tanggal_dokumen', '19-01-2024');
        $this->addParagraphIndented('2.3.1.1', "Proses pencampuran {$namaProduk} batch {$batchName} dilakukan dengan mesin {$mesin}.");

        $this->addParagraphIndented('2.3.1.2', "Berdasarkan acuan Spesifikasi Produk {$namaProduk}, no. dokumen {$noDoc}, tanggal {$tglDoc}, produk antara hasil lubrikasi memiliki spesifikasi sebagai berikut:");
        $this->addBab22SubabTables('pencampuran_212', $tableSubabMap, $imageMap, $existingImageMap);

        $samplingTitik    = $this->d('pencampuran_sampling_titik', '7');
        $samplingWaktu    = $this->d('pencampuran_sampling_waktu_213', '(3 titik di lokasi bagian atas dan 3 titik dilokasi bagian bawah dengan sudut radial ±120°, serta 1 titik di lokasi tengah vat/ kontainer)');
        $pemeriksaanJenis = $this->d('pencampuran_pemeriksaan_jenis', 'Kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12');
        $this->addParagraphIndented('2.3.1.3', "Pada tahap lubrikasi dilakukan sampling sebanyak {$samplingTitik} titik lokasi {$samplingWaktu}, kemudian dilakukan pemeriksaan {$pemeriksaanJenis} dengan hasil sebagai berikut:");
        $this->addBab22SubabTables('pencampuran_213', $tableSubabMap, $imageMap, $existingImageMap);

        $this->addParagraphIndented('2.3.1.3.1', 'Tabel data hasil pemeriksaan kadar zat aktif');
        $this->addBab22SubabTables('pencampuran_1331', $tableSubabMap, $imageMap, $existingImageMap);

        $bahanBaku = $this->d('pemeriksaan_bahan_baku', '(6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6 HCl, dan Vitamin B12');
        $this->addParagraphIndented('2.3.1.3.1.1', "Parameter kadar {$bahanBaku}, pada tahap lubrikasi produk {$namaProduk}, bukan merupakan syarat release, tetapi hanya sebagai pendataan selama proses.");
        $this->addParagraphIndented('2.3.1.3.1.2', "Seluruh hasil pemeriksaan kadar {$bahanBaku}, pada tahap lubrikasi akhir produk {$namaProduk}, batch {$batchName} sudah memberikan hasil yang memenuhi persyaratan Spesifikasi Produk yang berlaku.");

        // ── 2.3.2 Tahap Pencetakan ──────────────────────────────────────
        $this->section->addTextBreak(1);
        $this->section->addText('2.3.2  Tahap Pencetakan', ['size' => 11], [
            'alignment' => 'both', 'indentation' => ['left' => 440], 'spaceBefore' => 120, 'spaceAfter' => 60,
        ]);

        // fields: tujuan_mesin_kapsulasi, kapsulasi_no_dokumen, kapsulasi_tanggal_dokumen
        $mesinKapsulasi = $this->d('tujuan_mesin_kapsulasi', 'cetak Hanseaten PII/S');
        $noKapsulasi    = $this->d('kapsulasi_no_dokumen', 'EA-F03-3-00261-00');
        $tglKapsulasi   = $this->d('kapsulasi_tanggal_dokumen', '19-01-2024');

        $this->addParagraphIndented('2.3.2.1', "Tahap pencetakan produk {$namaProduk} menggunakan mesin {$mesinKapsulasi}.");
        $this->addParagraphIndented('2.3.2.2', "Spesifikasi Produk {$namaProduk} pada tahap pencetakan sesuai dengan Spesifikasi Produk {$namaProduk}, no. dokumen {$noKapsulasi}, tanggal {$tglKapsulasi} produk antara hasil pencetakan memiliki spesifikasi sebagai berikut:");
        $this->addBab22SubabTables('kapsulasi_222', $tableSubabMap, $imageMap, $existingImageMap);

        $samplingCetakTitik = $this->d('kapsulasi_sampling_titik', '10');
        $this->addParagraphIndented('2.3.2.3', "Pada proses pencetakan dilakukan pengambilan sampel sebanyak {$samplingCetakTitik} kali sepanjang proses pencetakan.");

        $paramCetak234 = $this->d('pencampuran_sampling_waktu_234', 'pemerian kaplet inti (bentuk, warna), ukuran, kekerasan, tebal, kerapuhan, waktu hancur, kadar air, keseragaman bobot, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12.');
        $this->addParagraphIndented('2.3.2.4', "Sampel yang didapat kemudian dilakukan pemeriksaan {$paramCetak234}.");

        $paramCetak235 = $this->d('pencampuran_sampling_waktu_235', 'pemerian kaplet inti (bentuk, warna), ukuran, kekerasan, tebal, kerapuhan, waktu hancur, kadar air, keseragaman bobot');
        $this->addParagraphIndented('2.3.2.5', "Data pemeriksaan dan evaluasi pada proses pencetakan untuk parameter {$paramCetak235} adalah sebagai berikut:");
        $this->addBab22SubabTables('kapsulasi_2231', $tableSubabMap, $imageMap, $existingImageMap);

        $paramIdentif = $this->d('pencampuran_identifikasi', 'identifikasi dan kadar');
        $this->addParagraphIndented('2.3.2.6', "Data pemeriksaan tahap pencetakan untuk parameter {$paramIdentif} adalah sebagai berikut:");
        $this->addBab22SubabTables('kapsulasi_2232', $tableSubabMap, $imageMap, $existingImageMap);

        $param2361 = $this->d('pencampuran_sampling_waktu_2361', 'ukuran, tebal, identifikasi, dan kadar zat aktif ((6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12)');
        $this->addParagraphIndented('2.3.2.6.1', "Parameter {$param2361} pada tahap pencetakan produk {$namaProduk} bukan merupakan syarat release, tetapi hanya sebagai pendataan selama proses.");

        $param2362 = $this->d('pencampuran_sampling_waktu_2362', 'pemerian kaplet inti (bentuk, warna), ukuran, kekerasan, tebal, kerapuhan, waktu hancur, kadar air, keseragaman bobot, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12');
        $batch2362 = $this->d('batch_besaran_2362', $batchName);
        $this->addParagraphIndented('2.3.2.6.2', "Seluruh hasil pemeriksaan {$param2362} pada tahap pencetakan produk {$namaProduk} batch {$batch2362} sudah memberikan hasil yang memenuhi persyaratan Spesifikasi Produk yang berlaku.");

        // ── 2.3.3 Tahap Penyalutan ─────────────────────────────────────
        $this->section->addTextBreak(1);
        $this->section->addText('2.3.3  Tahap Penyalutan', ['size' => 11], [
            'alignment' => 'both', 'indentation' => ['left' => 440], 'spaceBefore' => 120, 'spaceAfter' => 60,
        ]);

        $mesinSalut = $this->d('tujuan_mesin_kemas', 'coating Rama Cota');
        $noSalut    = $this->d('kemasan_no_dokumen_produk', 'EA-F03-3-00261-00');
        $tglSalut   = $this->d('kemasan_tanggal_dokumen_produk', '19-01-2024');

        $this->addParagraphIndented('2.3.3.1', "Tahap penyalutan produk {$namaProduk} menggunakan mesin {$mesinSalut}.");
        $this->addParagraphIndented('2.3.3.2', "Spesifikasi Produk {$namaProduk} pada tahap penyalutan sesuai dengan Spesifikasi Produk {$namaProduk}, no. dokumen {$noSalut}, tanggal {$tglSalut} produk antara hasil pencetakan memiliki spesifikasi sebagai berikut:");
        $this->addBab22SubabTables('kemasan_332', $tableSubabMap, $imageMap, $existingImageMap);

        $samplingSalutTitik = $this->d('kemasan_sampling_titik', '5');
        $lokasiSalut        = $this->d('lokasi_sampling_penyalutan', 'depan kiri, depan kanan, tengah, belakang kiri, dan belakang kanan');
        $this->addParagraphIndented('2.3.3.3', "Pada proses penyalutan dilakukan pengambilan sampel sebanyak {$samplingSalutTitik} lokasi dalam panci penyalut yang mewakili bagian {$lokasiSalut}.");

        $paramSalut334 = $this->d('pencampuran_sampling_waktu_334', 'pemerian kaplet salut (bentuk, warna), ukuran, kekerasan, tebal, waktu hancur, kadar air, keseragaman bobot, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12, dan cemaran logam berat.');
        $this->addParagraphIndented('2.3.3.4', "Sampel yang didapat kemudian dilakukan pemeriksaan {$paramSalut334}");

        $paramSalut335 = $this->d('param_penyalutan_335', 'pemerian kaplet inti (bentuk, warna), ukuran, kekerasan, tebal, waktu hancur, kadar air, keseragaman bobot');
        $this->addParagraphIndented('2.3.3.5', "Data pemeriksaan dan evaluasi pada proses kapsulasi untuk parameter {$paramSalut335} adalah sebagai berikut:");
        $this->addBab22SubabTables('kemasan_3331', $tableSubabMap, $imageMap, $existingImageMap);

        $paramSalut336 = $this->d('pencampuran_spesifikasi_nama', 'cemaran logam berat');
        $this->addParagraphIndented('2.3.3.6', "Data pemeriksaan tahap penyalutan untuk parameter {$paramSalut336}");
        $this->addBab22SubabTables('kemasan_3332', $tableSubabMap, $imageMap, $existingImageMap);

        $paramSalut337 = $this->d('pencampuran_identifikasi', 'identifikasi dan kadar');
        $this->addParagraphIndented('2.3.3.7', "Data pemeriksaan tahap penyalutan untuk parameter {$paramSalut337} adalah sebagai berikut:");
        $this->addBab22SubabTables('kemasan_3335', $tableSubabMap, $imageMap, $existingImageMap);

        $paramUkuran = $this->d('pencampuran_ukuran', 'ukuran dan tebal');
        $this->addParagraphIndented('2.3.3.7.1', "Parameter {$paramUkuran} pada tahap penyalutan produk {$namaProduk} bukan merupakan syarat release, tetapi hanya sebagai pendataan selama proses.");

        $param3372 = $this->d('pencampuran_sampling_waktu_3372', 'pemerian kaplet salut (bentuk, warna), ukuran, kekerasan, tebal, waktu hancur, kadar air, keseragaman bobot, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12');
        $this->addParagraphIndented('2.3.3.7.2', "Seluruh hasil pemeriksaan {$param3372} pada tahap pencetakan produk {$namaProduk} batch {$batchName} sudah memberikan hasil yang memenuhi persyaratan Spesifikasi Produk yang berlaku.");

        // ── 2.3.4 Tahap Kemas Primer ────────────────────────────────────
        $this->section->addTextBreak(1);
        $this->section->addText('2.3.4  Tahap Kemas Primer', ['size' => 11], [
            'alignment' => 'both', 'indentation' => ['left' => 440], 'spaceBefore' => 120, 'spaceAfter' => 60,
        ]);

        // fields: tujuan_mesin_kemas_primer, kapsulasi_sampling_titik, kapsulasi_sampling_waktu
        // pencampuran_no_dokumen (Spek Kemasan), pencampuran_tanggal_dokumen (Spek Kemasan)
        // pencampuran_no_dokumen (Spek Produk), pencampuran_tanggal_dokumen (Spek Produk) — sama field, sync
        $mesinKemas    = $this->d('tujuan_mesin_kemas_primer', 'Uhlmann HS 40');
        $samplingKemas = $this->d('kapsulasi_sampling_titik', '10');
        $waktuKemas    = $this->d('kapsulasi_sampling_waktu', 'awal, tengah, dan akhir');
        $noDoc234      = $this->d('pencampuran_no_dokumen', 'EC-F04-3-00189-01');
        $tglDoc234     = $this->d('pencampuran_tanggal_dokumen', '03-05-2025');
        $paramKemas344 = $this->d('param_kemas_344', 'isi dalam 1 strip, elegance strip, dan cemaran mikroba');
        $paramMikroba  = $this->d('param_kemas_3461', 'pemeriksaan cemaran mikroba');

        $this->addParagraphIndented('2.3.4.1', "Tahap kemas primer (strip) produk {$namaProduk} menggunakan mesin {$mesinKemas}.");
        $this->addParagraphIndented('2.3.4.2', "Pada proses pengemasan primer (strip) dilakukan {$samplingKemas} kali sampling yang mewakili {$waktuKemas} selama proses pengemasan primer.");
        $this->addParagraphIndented('2.3.4.3', "Spesifikasi Produk {$namaProduk} pada proses pengemasan primer (strip) sesuai dengan Spesifikasi Kemasan {$namaProduk}, No. Dokumen {$noDoc234}, tanggal {$tglDoc234} ditambah dengan pemeriksaan cemaran mikroba sesuai Spesifikasi Produk {$namaProduk}, No.Dokumen {$noDoc234}, tanggal {$tglDoc234}, adalah sebagai berikut:");
        $this->addBab22SubabTables('kemasan_3333', $tableSubabMap, $imageMap, $existingImageMap);

        $this->addParagraphIndented('2.3.4.4', "Sampel yang didapat kemudian dilakukan pemeriksaan {$paramKemas344}.");
        $this->addParagraphIndented('2.3.4.5', 'Data hasil pemeriksaan isi dalam 1 (strip) adalah sebagai berikut:');
        $this->addBab22SubabTables('kemasan_3336', $tableSubabMap, $imageMap, $existingImageMap);

        $this->addParagraphIndented('2.3.4.6', 'Data hasil pengujian cemaran mikroba adalah sebagai berikut:');
        $this->addBab22SubabTables('kemasan_3334', $tableSubabMap, $imageMap, $existingImageMap);

        $this->addParagraphIndented('2.3.4.6.1', "Secara keseluruhan, atribut yang diuji pada tahap kemas primer {$paramMikroba} Produk {$namaProduk} pada batch {$batchName} sudah memberikan hasil yang memenuhi persyaratan menurut Spesifikasi Produk yang berlaku.");
    }

    /**
     * Helper: Add indented paragraph (number + text)
     */
    protected function addParagraphIndented(string $number, string $text): void
    {
        $textRun = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 740, 'hanging' => 440],
            'contextualSpacing' => true,
        ]);
        $textRun->addText($number, ['size' => 11]);
        $textRun->addText('  ' . $text, ['size' => 11]);
    }

    /**
     * Resolve enabled BAB 2.2 subabs in editor order (dynamic subabs only).
     * 'partikel_asing' is NOT included here — it is a hardcoded sub-point (2.2.x.1)
     * rendered under the last dynamic subab, not a sibling subab.
     */
    protected function getEnabledBab22SubabKeys(): array
    {
        $enabledStr = trim((string) ($this->data['bab22_enabled_subab_keys'] ?? ''));
        if ($enabledStr !== '') {
            // Strip partikel_asing if it somehow ended up in the list
            return array_values(array_filter(
                array_map('trim', explode(',', $enabledStr)),
                fn($k) => $k !== '' && $k !== 'partikel_asing'
            ));
        }

        $tableSubabMap = $this->data['bab22_table_subab_key'] ?? [];
        $fallbackOrder = ['mixing', 'filling_awal'];

        if (is_array($tableSubabMap) && !empty($tableSubabMap)) {
            $ordered = [];
            foreach ($tableSubabMap as $key) {
                $key = trim((string) $key);
                if ($key !== '' && $key !== 'partikel_asing' && !in_array($key, $ordered, true)) {
                    $ordered[] = $key;
                }
            }
            if (!empty($ordered)) {
                return $ordered;
            }
        }

        return $fallbackOrder;
    }

    /**
     * Resolve title by subab key (default/custom).
     */
    protected function getBab22SubabTitle(string $subabKey): string
    {
        $title = match ($subabKey) {
            'mixing' => 'Mixing',
            'filling_awal' => 'Awal filling-capping',
            'filling_capping' => 'Filling-capping',
            default => trim((string) ($this->data["{$subabKey}_title"] ?? 'Subab')),
        };

        return $title !== '' ? $title : 'Subab';
    }

    /**
     * Resolve closing paragraph by subab key.
     */
    protected function getBab22SubabClosingText(string $subabKey): string
    {
        return match ($subabKey) {
            'mixing' => 'Atribut yang diuji pada tahap mixing sudah memberikan hasil yang ' .
                $this->d('mixing_hasil', 'memenuhi') .
                ' persyaratan menurut Spesifikasi Produk yang berlaku' .
                $this->resolveBab22ClosingTail('mixing_hasil_catatan') . '.',
            'filling_awal' => 'Atribut yang diuji pada tahap awal filling-capping sudah memberikan hasil yang ' .
                $this->d('filling_awal_hasil', 'memenuhi') .
                ' persyaratan menurut Spesifikasi Produk yang berlaku' .
                $this->resolveBab22ClosingTail('filling_awal_hasil_catatan') . '.',
            'filling_capping' => 'Atribut yang diuji pada tahap filling-capping sudah memberikan hasil yang ' .
                $this->d('filling_capping_hasil', 'memenuhi') .
                ' persyaratan menurut Spesifikasi Produk dan Spesifikasi Kemasan yang berlaku' .
                $this->resolveBab22ClosingTail('filling_capping_hasil_catatan') . '.',
            'partikel_asing' => '',
            default => $this->d("{$subabKey}_notes", ''),
        };
    }

    private function resolveBab22ClosingTail(string $fieldName): string
    {
        $tail = $this->d($fieldName, '');
        return $tail !== '' ? " {$tail}" : '';
    }

    /**
     * Export BAB 3: KESIMPULAN
     */
    protected function exportBab3(): void
    {
        $this->section->addTextBreak(1);

        $this->section->addText('3. KESIMPULAN', ['bold' => true, 'size' => 11], [
            'alignment' => 'both', 'spaceAfter' => 0,
        ]);

        $enabledStr      = $this->data['kesimpulan_enabled_sections'] ?? '1,2';
        $enabledSections = array_filter(array_map('trim', explode(',', $enabledStr)), fn($s) => $s !== '');

        $namaProduk = $this->d('tujuan_nama_produk', $this->d('judul_nama_produk', 'Q-Fomil'));
        $batchName  = $this->d('batch_name', $this->d('batch_besaran', 'DEC25A01'));
        $sectionNum = 1;

        // Section 3.1
        if (in_array('1', $enabledSections)) {
            $metode = $this->d('rangkuman_metode', 'penimbangan bahan baku, pencampuran, pencetakan, penyalutan, dan pengemasan primer (stripping)');
            $noDoc  = $this->d('pencampuran_no_dokumen', 'CE-00466-00-PC');
            $tglDoc = $this->d('pencampuran_tanggal_dokumen', '12-07-2025');

            $this->addKesimpulanItem("3.{$sectionNum}", "Telah dilakukan validasi proses pengolahan dan pengemasan primer produk {$namaProduk}, batch {$batchName} {$metode} telah dilakukan sesuai MBR Pengolahan {$namaProduk}, No. Dokumen {$noDoc}, tanggal {$tglDoc} dan MBR Pengemasan {$namaProduk} No. Dokumen {$noDoc}, tanggal {$tglDoc}.");

            $param311 = $this->d('param_lubrikasi_311', 'kadar zat aktif (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12');
            $hasil311 = $this->d('kemasan_hasil', 'memenuhi');
            $this->addKesimpulanSubItem("3.{$sectionNum}.1", "Berdasarkan pemeriksaan batch validasi {$batchName} terhadap parameter mutu produk pada tahap lubrikasi antara lain {$param311} didapatkan seluruh hasil pengujian {$hasil311} spesifikasi produk yang berlaku.");

            $param312 = $this->d('param_pencetakan_312', 'pemerian kaplet inti (bentuk, warna), ukuran, kekerasan, tebal, kerapuhan, waktu hancur, kadar air, keseragaman bobot, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12');
            $hasil312 = $this->d('kemasan_hasil', 'memenuhi');
            $this->addKesimpulanSubItem("3.{$sectionNum}.2", "Berdasarkan pemeriksaan batch validasi {$batchName} terhadap parameter mutu produk pada tahap pencetakan, antara lain {$param312} didapatkan seluruh hasil pengujian telah {$hasil312} spesifikasi produk yang berlaku.");

            $param313 = $this->d('param_penyalutan_313', 'pemerian kaplet salut (bentuk, warna), ukuran, kekerasan, tebal, waktu hancur, kadar air, keseragaman bobot, cemaran logam berat, identifikasi, dan kadar (6S)-5-Methyltetrahydofolic Acid Glucosamine Salt, Vitamin B6, dan Vitamin B12');
            $hasil313 = $this->d('kemasan_hasil', 'memenuhi');
            $this->addKesimpulanSubItem("3.{$sectionNum}.3", "Berdasarkan pemeriksaan batch validasi {$batchName} terhadap parameter mutu produk pada tahap penyalutan, antara lain {$param313} didapatkan seluruh hasil pengujian {$hasil313} spesifikasi produk yang berlaku.");

            $param314 = $this->d('param_kemas_314', 'isi dalam 1 strip, kebocoran strip, elegance strip, dan cemaran mikroba');
            $hasil314 = $this->d('kemasan_hasil', 'memenuhi');
            $this->addKesimpulanSubItem("3.{$sectionNum}.4", "Berdasarkan pemeriksaan batch validasi {$batchName} terhadap parameter mutu produk pada tahap pengemasan primer, antara lain {$param314}, didapatkan seluruh hasil pengujian {$hasil314} spesifikasi produk yang berlaku.");

            $sectionNum++;
        }

        // Section 3.2
        if (in_array('2', $enabledSections)) {
            $noSpek  = $this->d('pencampuran_no_dokumen', 'EA-F03-3-00261-00');
            $tglSpek = $this->d('pencampuran_tanggal_dokumen', '19-01-2024');
            $status  = $this->d('kesimpulan_status', 'validated');
            $hasil32 = $this->d('kemasan_hasil', 'memenuhi');

            $textRun = $this->section->addTextRun([
                'alignment' => 'both', 'indentation' => ['left' => 740, 'hanging' => 440], 'contextualSpacing' => true,
            ]);
            $textRun->addText("3.{$sectionNum}", ['size' => 11]);
            $textRun->addText(
                "  Berdasarkan pemeriksaan pada batch validasi {$batchName}, proses terbukti dapat menghasilkan produk jadi {$namaProduk} yang {$hasil32} spesifikasi sesuai dengan Spesifikasi Produk {$namaProduk}, No. Dokumen {$noSpek} tanggal {$tglSpek} dan Spesifikasi Kemasan {$namaProduk} No. Dokumen {$noSpek}, tanggal {$tglSpek}. sehingga dinyatakan ",
                ['size' => 11]
            );
            $textRun->addText($status, ['italic' => true, 'size' => 11]);
            $textRun->addText('.', ['size' => 11]);
            $sectionNum++;
        }

        // Custom sections
        foreach ($enabledSections as $sectionId) {
            if (str_starts_with($sectionId, 'c')) {
                $customNum  = substr($sectionId, 1);
                $customText = $this->d("kesimpulan_custom_{$customNum}", '');
                if ($customText !== '') {
                    $this->addKesimpulanItem("3.{$sectionNum}", $customText);
                    $sectionNum++;
                }
            }
        }
    }

    /**
     * Helper: Add a kesimpulan sub-item (indented deeper)
     */
    protected function addKesimpulanSubItem(string $number, string $text): void
    {
        $textRun = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 1350, 'hanging' => 610],
            'contextualSpacing' => true,
        ]);
        $textRun->addText($number, ['size' => 11]);
        $textRun->addText('  ' . $text, ['size' => 11]);
    }

    /**
     * Helper: Add a kesimpulan item with number and text
     */
    protected function addKesimpulanItem(string $number, string $text): void
    {
        $textRun = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 740, 'hanging' => 440],
            'contextualSpacing' => true,
        ]);
        $textRun->addText($number, ['bold' => false, 'size' => 11]);
        $textRun->addText(' ' . $text, ['size' => 11]);
    }

    /**
     * Render satu tabel/gambar berdasarkan table uid langsung (tanpa subab mapping).
     * Digunakan untuk tabel tunggal seperti table_1 di section 2.2.
     */
    protected function renderTableUid(string $tableUid, array $imageMap, array $existingImageMap): void
    {
        $imageFile         = $imageMap[$tableUid] ?? null;
        $resolvedImagePath = $this->resolveStoredImagePath($existingImageMap[$tableUid] ?? null);
        $base64            = trim((string) ($this->data['mixing_image_base64'][$tableUid] ?? ''));

        if ($imageFile instanceof UploadedFile && $imageFile->isValid()) {
            try {
                $this->section->addImage($imageFile->getPathname(), [
                    'width' => 450, 'height' => null, 'marginTop' => 10, 'marginBottom' => 10, 'align' => 'center',
                ]);
            } catch (\Exception $e) {
                $this->section->addText("[Error memuat gambar: {$e->getMessage()}]", ['color' => 'FF0000']);
            }
        } elseif ($resolvedImagePath) {
            try {
                $this->section->addImage($resolvedImagePath, [
                    'width' => 450, 'height' => null, 'marginTop' => 10, 'marginBottom' => 10, 'align' => 'center',
                ]);
            } catch (\Exception $e) {
                $this->section->addText("[Error memuat gambar draft: {$e->getMessage()}]", ['color' => 'FF0000']);
            }
        } elseif ($base64 !== '' && str_starts_with($base64, 'data:image')) {
            try {
                $commaPos  = strpos($base64, ',');
                $imageData = base64_decode(substr($base64, $commaPos + 1));
                $tmpFile   = tempnam(sys_get_temp_dir(), 'bab2img');
                file_put_contents($tmpFile, $imageData);
                $this->section->addImage($tmpFile, [
                    'width' => 450, 'height' => null, 'marginTop' => 10, 'marginBottom' => 10, 'align' => 'center',
                ]);
                @unlink($tmpFile);
            } catch (\Exception $e) {
                $this->section->addText("[Error gambar base64]", ['color' => 'FF0000']);
            }
        } else {
            $pastedJson = trim((string) ($this->data['mixing_pasted_table_json'][$tableUid] ?? ''));
            if ($pastedJson !== '') {
                $rows = json_decode($pastedJson, true);
                if (is_array($rows) && !empty($rows)) {
                    $this->renderPastedTableToWord($rows);
                }
            }
        }
    }

    /**
     * Add tables/images for one BAB 2.2 subab based on table->subab mapping.
     *
     * @param array<string, string> $tableSubabMap
     * @param array<string, mixed> $imageMap
     * @param array<string, string> $existingImageMap
     */
    protected function addBab22SubabTables(string $subabKey, array $tableSubabMap, array $imageMap, array $existingImageMap): void
    {
        $tableUids = [];
        foreach ($tableSubabMap as $tableUid => $mappedSubabKey) {
            if ((string) $mappedSubabKey === $subabKey) {
                $tableUids[] = (string) $tableUid;
            }
        }

        if (empty($tableUids)) {
            return;
        }

        foreach ($tableUids as $tableUid) {
            $imageFile = $imageMap[$tableUid] ?? null;
            $resolvedImagePath = $this->resolveStoredImagePath($existingImageMap[$tableUid] ?? null);
            $base64 = trim((string) ($this->data['mixing_image_base64'][$tableUid] ?? ''));

            if ($imageFile instanceof UploadedFile && $imageFile->isValid()) {
                try {
                    $this->section->addImage($imageFile->getPathname(), [
                        'width' => 450, 'height' => null, 'marginTop' => 10, 'marginBottom' => 10, 'align' => 'center',
                    ]);
                } catch (\Exception $e) {
                    $this->section->addText("[Error memuat gambar: {$e->getMessage()}]", ['color' => 'FF0000']);
                }
            } elseif ($resolvedImagePath) {
                try {
                    $this->section->addImage($resolvedImagePath, [
                        'width' => 450, 'height' => null, 'marginTop' => 10, 'marginBottom' => 10, 'align' => 'center',
                    ]);
                } catch (\Exception $e) {
                    $this->section->addText("[Error memuat gambar draft: {$e->getMessage()}]", ['color' => 'FF0000']);
                }
            } elseif ($base64 !== '' && str_starts_with($base64, 'data:image')) {
                try {
                    $commaPos = strpos($base64, ',');
                    $imageData = base64_decode(substr($base64, $commaPos + 1));
                    $tmpFile = tempnam(sys_get_temp_dir(), 'bab2img');
                    file_put_contents($tmpFile, $imageData);
                    $this->section->addImage($tmpFile, [
                        'width' => 450, 'height' => null, 'marginTop' => 10, 'marginBottom' => 10, 'align' => 'center',
                    ]);
                    @unlink($tmpFile);
                } catch (\Exception $e) {
                    $this->section->addText("[Error gambar base64]", ['color' => 'FF0000']);
                }
            } else {
                // Try pasted table JSON
                $pastedJson = trim((string) ($this->data['mixing_pasted_table_json'][$tableUid] ?? ''));
                if ($pastedJson !== '') {
                    $rows = json_decode($pastedJson, true);
                    if (is_array($rows) && !empty($rows)) {
                        $this->renderPastedTableToWord($rows);
                    }
                }
            }
        }
    }

    /**
     * Render a pasted table (array of rows) into the Word document.
     */
    protected function renderPastedTableToWord(array $rows): void
    {
        if (empty($rows)) {
            return;
        }

        $colCount = max(array_map('count', $rows));
        $totalWidth = 9000;
        $colWidth = (int) ($totalWidth / max($colCount, 1));

        $tableStyle = [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 80,
            'width' => $totalWidth,
            'unit' => 'dxa',
        ];

        $table = $this->section->addTable($tableStyle);

        foreach ($rows as $rowIndex => $row) {
            $table->addRow(250);
            foreach ($row as $cellValue) {
                $isHeader = ($rowIndex === 0);
                $table->addCell($colWidth, ['valign' => 'center'])
                    ->addText(
                        htmlspecialchars_decode((string) $cellValue),
                        ['bold' => $isHeader, 'size' => 10],
                        ['alignment' => 'left', 'spaceAfter' => 0]
                    );
            }
        }
    }

    private function resolveStoredImagePath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->path($path);
        }

        return null;
    }

    /**
     * Add footer with signature table
     */
    protected function addFooter(): void
    {
        $footer = $this->section->addFooter();

        $col1 = 2729;
        $col2 = 2729;
        $col3 = 2728;
        $col4 = 2729;

        $footerTable = $footer->addTable([
            'width' => 10915,
            'unit' => 'dxa',
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 50,
            'indent' => new TblWidth(-310, 'dxa'),
        ]);

        // Row 1: Headers
        $footerTable->addRow(0, ['exactHeight' => true]);

        $footerTable->addCell($col1, [
            'borderSize' => 6,
            'valign' => 'center'
        ])->addText('Dibuat oleh', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0, 'spaceBefore' => 0]);

        $footerTable->addCell($col2 + $col3, [
            'gridSpan' => 2,
            'borderSize' => 6,
            'valign' => 'center'
        ])->addText('Diperiksa oleh', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0, 'spaceBefore' => 0]);

        $footerTable->addCell($col4, [
            'borderSize' => 6,
            'valign' => 'center'
        ])->addText('Disetujui oleh', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0, 'spaceBefore' => 0]);

        // Row 2: Signature blocks
        $footerTable->addRow(650);

        $cell1 = $footerTable->addCell($col1, ['borderSize' => 6, 'valign' => 'bottom']);
        $cell1->addTextBreak(2);
        $cell1->addText('__________', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $cell1->addText('Validation Officer (2)', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $cell1->addText('Tanggal:', ['size' => 11], ['alignment' => 'left', 'spaceAfter' => 0]);

        $cell2 = $footerTable->addCell($col2, [
            'borderSize' => 6,
            'borderRightSize' => 0,
            'valign' => 'bottom'
        ]);
        $cell2->addTextBreak(2);
        $cell2->addText('__________', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $cell2->addText('Validation Manager', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $cell2->addText('Tanggal:', ['size' => 11], ['alignment' => 'left', 'spaceAfter' => 0]);

        $cell3 = $footerTable->addCell($col3, [
            'borderSize' => 6,
            'borderLeftSize' => 0,
            'valign' => 'bottom'
        ]);
        $cell3->addTextBreak(2);
        $cell3->addText('__________', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $cell3->addText('QA Manager', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $cell3->addText('Tanggal:', ['size' => 11], ['alignment' => 'left', 'spaceAfter' => 0]);

        $cell4 = $footerTable->addCell($col4, ['borderSize' => 6, 'valign' => 'bottom']);
        $cell4->addTextBreak(2);
        $cell4->addText('__________', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $cell4->addText('Quality Div. Manager', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $cell4->addText('Tanggal:', ['size' => 11], ['alignment' => 'left', 'spaceAfter' => 0]);
    }

    /**
     * Save document and return download response
     */
    protected function saveAndDownload()
    {
        $namaProduk = $this->d('judul_nama_produk', 'Q-Fomil');
        $fileName = 'Summary_Validasi_' . str_replace(' ', '_', $namaProduk) . '_' . date('Y-m-d') . '.docx';

        $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord');
        $objWriter = IOFactory::createWriter($this->phpWord, 'Word2007');

        $token = request()->input('export_token', '');
        $objWriter->save($tempFile);

        if ($token) {
            setcookie('export_done', $token, ['expires' => time() + 60, 'path' => '/', 'httponly' => false, 'samesite' => 'Lax']);
        }

        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ])->deleteFileAfterSend(true);
    }
}