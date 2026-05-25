<?php

namespace App\Services\Export;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\ComplexType\TblWidth;
use PhpOffice\PhpWord\IOFactory;

class NutracareGrapeExportService
{
    protected PhpWord $phpWord;
    protected Section $section;
    protected array $data;

    /**
     * Export the Nutracare Grape Seed template to Word document
     */
    public function export(array $data)
    {
        $this->data = $data;
        $this->phpWord = new PhpWord();

        $this->setupDocument();
        $this->addHeader();
        $this->addDocumentTitle();
        $this->addDocumentInfoTable();
        $this->exportBab1();
        $this->exportBab2();
        $this->exportBab3();
        $this->exportBab4();
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

        $namaProduk = strtoupper($this->data['judul_nama_produk'] ?? 'NUTRACARE GRAPE SEED');
        $line       = strtoupper($this->data['judul_line'] ?? 'OBAT DALAM');
        $bagian     = strtoupper($this->data['judul_bagian'] ?? 'PRODUCTION NATPRO & EXTRACTION BANGUNAN IOT NATPRO');

        $title = "SUMMARY LAPORAN VALIDASI PROSES PEMBUATAN PRODUK {$namaProduk} DI LINI {$line} BAGIAN {$bagian}";

        $this->section->addText($title, ['bold' => true, 'size' => 12], ['alignment' => 'center', 'spaceAfter' => 0]);
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
        $infoTable->addCell(3000)->addText($this->data['dokumen_no'] ?? '-', ['size' => 11], $cellParagraph);
        $infoTable->addCell(1500)->addText('Tanggal :', ['size' => 11], $cellParagraph);
        $infoTable->addCell(2500)->addText($this->data['dokumen_tanggal'] ?? '-', ['size' => 11], $cellParagraph);

        $infoTable->addRow();
        $infoTable->addCell(2000)->addText('Pengganti No. :', ['size' => 11], $cellParagraph);
        $infoTable->addCell(3000)->addText($this->data['pengganti_no'] ?? '-', ['size' => 11], $cellParagraph);
        $infoTable->addCell(1500)->addText('Tanggal :', ['size' => 11], $cellParagraph);
        $infoTable->addCell(2500)->addText($this->data['pengganti_tanggal'] ?? '-', ['size' => 11], $cellParagraph);

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
        $textRun11->addText('1.1', ['bold' => false, 'size' => 11]);
        $textRun11->addText('  Tujuan', ['size' => 11]);

        // 1.1.1
        $namaProduk  = $this->data['tujuan_nama_produk'] ?? 'Nutracare Grape Seed';
        $namaProduk2 = $this->data['tujuan_nama_produk_2'] ?? $namaProduk;
        $line        = $this->data['tujuan_line'] ?? $this->data['judul_line'] ?? 'Obat Dalam';
        $bagian      = $this->data['tujuan_bagian'] ?? $this->data['judul_bagian'] ?? 'Production Natpro & Extraction';

        $tujuanText = "Summary validasi ini bertujuan mendokumentasikan hasil studi validasi proses/ pembuktian terhadap kualitas dan reprodusibilitas proses pengolahan produk {$namaProduk} yang merupakan di Lini {$line} Bagian {$bagian} dalam menghasilkan produk yang memenuhi persyaratan mutu yang tercantum dalam Spesifikasi Produk dan Kemasan {$namaProduk2} yang berlaku.";

        $textRun111 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 1350, 'hanging' => 610],
            'contextualSpacing' => true,
        ]);
        $textRun111->addText('1.1.1', ['bold' => false, 'size' => 11]);
        $textRun111->addText(' ' . $tujuanText, ['size' => 11]);

        // 1.2 Batch Validasi
        $textRun12 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 300],
            'contextualSpacing' => true,
        ]);
        $textRun12->addText('1.2', ['bold' => false, 'size' => 11]);
        $textRun12->addText('  Batch Validasi', ['size' => 11]);

        $jumlahBatch = $this->data['batch_jumlah'] ?? '2';
        $batchName   = $this->data['batch_name'] ?? 'NOV25A01 dan NOV25A02';
        $besaran     = $this->data['batch_besaran'] ?? '19.99';
        $jumlahKap   = $this->data['batch_jumlah_kapsul'] ?? '57.137';
        $satuan      = $this->data['batch_satuan'] ?? '350';

        $batchText = "Studi validasi telah dilakukan terhadap {$jumlahBatch} batch produksi yaitu batch {$batchName} dengan besaran batch {$besaran} kg ({$jumlahKap} kapsul @ {$satuan} mg).";

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

        $this->section->addText('2. HASIL DAN EVALUASI PROSES', ['bold' => true, 'size' => 11], [
            'alignment' => 'both',
            'spaceAfter' => 0,
        ]);

        $tableSubabMap    = is_array($this->data['bab22_table_subab_key'] ?? null)    ? $this->data['bab22_table_subab_key']    : [];
        $imageMap         = is_array($this->data['mixing_image_file'] ?? null)         ? $this->data['mixing_image_file']         : [];
        $existingImageMap = is_array($this->data['existing_mixing_image_file'] ?? null) ? $this->data['existing_mixing_image_file'] : [];

        // 2.1 Seluruh tahapan
        $namaProduk    = $this->data['tujuan_nama_produk'] ?? $this->data['judul_nama_produk'] ?? 'Nutracare Grape Seed';
        $metode        = $this->data['rangkuman_metode'] ?? 'penimbangan bahan baku, pencampuran, kapsulasi, dan pengemasan primer (botol)';
        $noDokumen     = $this->data['pencampuran_no_dokumen'] ?? 'AI-A0005-00-PC';
        $tglDokumen    = $this->data['pencampuran_tanggal_dokumen'] ?? '06-11-2025';
        $jumlahBotol   = $this->data['batch_jumlah_botol'] ?? 'Botol 30';

        $textRun21 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 740, 'hanging' => 440],
            'contextualSpacing' => true,
        ]);
        $textRun21->addText('2.1.', ['bold' => false, 'size' => 11]);
        $textRun21->addText(" Seluruh tahapan pengolahan dan pengemasan primer {$namaProduk} yaitu {$metode} telah dilakukan sesuai MBR Skala Produksi Pengolahan {$namaProduk}, no. dokumen {$noDokumen}, tanggal {$tglDokumen} dan MBR Pengemasan {$namaProduk} {$jumlahBotol}, no. dokumen {$noDokumen}, tanggal {$tglDokumen}.", ['size' => 11]);

        // 2.2 Pelaksanaan Proses Produksi
        $textRun22 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 670, 'hanging' => 370],
            'spaceAfter' => 60,
        ]);
        $textRun22->addText('2.2', ['bold' => false, 'size' => 11]);
        $textRun22->addText('  Pelaksanaan proses produksi', ['size' => 11]);

        // Tabel pelaksanaan (dari mixing table uid table_1)
        $this->addBab22SubabTables('mixing', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3 Hasil pemeriksaan sampel
        $textRun23 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 670, 'hanging' => 370],
            'spaceAfter' => 60,
        ]);
        $textRun23->addText('2.3', ['bold' => false, 'size' => 11]);
        $textRun23->addText('  Hasil pemeriksaan sampel pada masing-masing tahapan adalah sebagai berikut :', ['size' => 11]);

        $this->exportBab23($tableSubabMap, $imageMap, $existingImageMap);
    }

    /**
     * Export BAB 2.3: Detail pemeriksaan sampel
     */
    protected function exportBab23(array $tableSubabMap, array $imageMap, array $existingImageMap): void
    {
        $namaProduk = $this->data['tujuan_nama_produk'] ?? $this->data['judul_nama_produk'] ?? 'Nutracare Grape Seed';
        $batchName  = $this->data['batch_name'] ?? 'NOV25A01 dan NOV25A02';
        $mesin      = $this->data['tujuan_mesin'] ?? 'Double Cone Mixer DC 40';

        // ── 2.3.1 Tahap Pencampuran ──
        $this->addSubabHeading('2.3.1.', 'Tahap Pencampuran');

        // 2.3.1.1
        $this->addSubSubabText('2.3.1.1.',
            "Proses pencampuran produk antara {$namaProduk} batch {$batchName} dilakukan dengan mesin {$mesin}.");

        // 2.3.1.2
        $noDok231  = $this->data['pencampuran_no_dokumen'] ?? 'AI-F03-3-A0018-00';
        $tglDok231 = $this->data['pencampuran_tanggal_dokumen'] ?? '24-06-2024';
        $identif   = $this->data['pencampuran_identifikasi'] ?? 'identifikasi';
        $this->addSubSubabText('2.3.1.2.',
            "Berdasarkan acuan Spesifikasi Produk {$namaProduk}, no. dokumen {$noDok231}, tanggal {$tglDok231}, maka produk antara tahap pencampuran dilakukan pemeriksaan {$identif} sebagai pendataan, dengan penerimaan sebagai berikut:");
        $this->addBab22SubabTables('pencampuran_212', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.1.3
        $sampTitik = $this->data['pencampuran_sampling_titik'] ?? '7';
        $sampWaktu = $this->data['pencampuran_sampling_waktu'] ?? 'atas, tengah, dan bawah';
        $pemJenis  = $this->data['pencampuran_pemeriksaan_jenis'] ?? 'identifikasi Grape Seed Extract';
        $this->addSubSubabText('2.3.1.3.',
            "Pada tahap pencampuran dilakukan sampling sebanyak {$sampTitik} titik yang mewakili {$sampWaktu}, kemudian dilakukan pemeriksaan {$pemJenis} dengan hasil sebagai berikut:");

        // 2.3.1.3.1
        $this->addSubSubSubabText('2.3.1.3.1.',
            "Tabel data hasil pemeriksaan {$pemJenis} pada tahap pencampuran");
        $this->addBab22SubabTables('pencampuran_1331', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.1.3.2
        $this->addSubSubSubabText('2.3.1.3.2.',
            "Hasil pemeriksaan {$identif} pada tahap pencampuran produk {$namaProduk} batch {$batchName} menunjukkan bahwa pada seluruh sampel telah {$pemJenis}.");

        // ── 2.3.2 Tahap Kapsulasi ──
        $mesinKap = $this->data['tujuan_mesin_kapsulasi'] ?? $this->data['tujuan_mesin'] ?? 'Kapsulasi Bosch Type GKF 400';
        $this->addSubabHeading('2.3.2.', 'Tahap Kapsulasi');

        // 2.3.2.1
        $this->addSubSubabText('2.3.2.1.',
            "Tahap kapsulasi produk {$namaProduk} batch {$batchName} dilakukan menggunakan mesin {$mesinKap}.");

        // 2.3.2.2
        $noDok232  = $this->data['kapsulasi_no_dokumen'] ?? $this->data['pencampuran_no_dokumen'] ?? 'AI-F03-3-A0018-00';
        $tglDok232 = $this->data['kapsulasi_tanggal_dokumen'] ?? $this->data['pencampuran_tanggal_dokumen'] ?? '24-06-2024';
        $this->addSubSubabText('2.3.2.2.',
            "Spesifikasi Produk {$namaProduk} batch {$batchName} pada tahap kapsulasi sesuai dengan Spesifikasi Produk {$namaProduk}, no. dokumen {$noDok232}, tanggal {$tglDok232} adalah sebagai berikut:");
        $this->addBab22SubabTables('kapsulasi_222', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.2.3
        $sampTitikKap = $this->data['kapsulasi_sampling_titik'] ?? '10';
        $sampWaktuKap = $this->data['kapsulasi_sampling_waktu'] ?? 'awal, tengah, dan akhir proses';
        $pemJenisKap  = $this->data['kapsulasi_pemeriksaan_jenis'] ?? 'pemerian (bentuk, warna cangkang, dan pemerian isi kapsul), kadar air, waktu hancur, keseragaman bobot, identifikasi, dan cemaran logam berat';
        $this->addSubSubabText('2.3.2.3.',
            "Pada tahap kapsulasi dilakukan sampling sebanyak {$sampTitikKap} titik yang mewakili {$sampWaktuKap}, kemudian dilakukan pemeriksaan {$pemJenisKap} dengan hasil sebagai berikut:");

        // 2.3.2.3.1
        $this->addSubSubSubabText('2.3.2.3.1.',
            'Tabel data hasil pemeriksaan pemerian (bentuk, warna cangkang, dan pemerian isi kapsul), kadar air, waktu hancur, dan keseragaman bobot pada tahap kapsulasi.');
        $this->addBab22SubabTables('kapsulasi_2231', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.2.3.2
        $this->addSubSubSubabText('2.3.2.3.2.',
            'Tabel data hasil pemeriksaan cemaran logam berat pada tahap kapsulasi.');
        $this->addBab22SubabTables('kapsulasi_2232', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.2.3.3
        $besaran    = $this->data['batch_besaran'] ?? '19.99';
        $hasilKap   = $this->data['kapsulasi_hasil'] ?? 'memenuhi syarat';
        $this->addSubSubSubabText('2.3.2.3.3.',
            "Hasil pemeriksaan batch validasi {$batchName} pada tahap kapsulasi memberikan hasil yang {$hasilKap} Spesifikasi Produk yang berlaku untuk parameter pemerian (bentuk, warna cangkang, dan pemerian isi kapsul), kadar air, waktu hancur, keseragaman bobot, identifikasi grape seed extract, dan cemaran logam berat.");

        // ── 2.3.3 Tahap Kemas Primer ──
        $this->addSubabHeading('2.3.3.', 'Tahap Kemas Primer');

        // 2.3.3.1
        $mesinKemas = $this->data['tujuan_mesin_kemas'] ?? 'Counting Unimach';
        $this->addSubSubabText('2.3.3.1.',
            "Tahap kemas primer produk {$namaProduk} batch {$batchName} dilakukan menggunakan mesin {$mesinKemas}. Aluseal pada tutup botol diseal menggunakan mesin induction seal conveyor.");

        // 2.3.3.2
        $noDok233a  = $this->data['kemasan_no_dokumen_produk'] ?? $this->data['pencampuran_no_dokumen'] ?? 'AI-F03-3-A0018-00';
        $tglDok233a = $this->data['kemasan_tanggal_dokumen_produk'] ?? $this->data['pencampuran_tanggal_dokumen'] ?? '24-06-2024';
        $noDok233b  = $this->data['kemasan_no_dokumen'] ?? 'AI-F04-3-A0015-01';
        $tglDok233b = $this->data['kemasan_tanggal_dokumen'] ?? '06-11-2025';
        $this->addSubSubabText('2.3.3.2.',
            "Spesifikasi Produk dan kemasan {$namaProduk} batch {$batchName} pada tahap kemas primer sesuai dengan Spesifikasi Produk {$namaProduk}, no. dokumen {$noDok233a}, tanggal {$tglDok233a} dan Spesifikasi Kemasan {$namaProduk}, no. dokumen {$noDok233b}, tanggal {$tglDok233b} adalah sebagai berikut:");
        $this->addBab22SubabTables('kemasan_332', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.3.3
        $sampTitikKem = $this->data['kemasan_sampling_titik'] ?? '10';
        $sampWaktuKem = $this->data['kemasan_sampling_waktu'] ?? 'awal, tengah, dan akhir proses';
        $this->addSubSubabText('2.3.3.3.',
            "Pada tahap kemas primer dilakukan sampling sebanyak {$sampTitikKem} titik yang mewakili {$sampWaktuKem}, kemudian dilakukan pemeriksaan isi dalam satu botol, kondisi aluseal, aflatoksin total, dan cemaran mikroba dengan hasil sebagai berikut:");

        // 2.3.3.3.1
        $this->addSubSubSubabText('2.3.3.3.1.',
            'Tabel data hasil pemeriksaan isi dalam satu botol, kondisi aluseal, dan aflatoksin total');
        $this->addBab22SubabTables('kemasan_3331', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.3.3.2
        $this->addSubSubSubabText('2.3.3.3.2.',
            'Tabel data hasil pemeriksaan cemaran mikroba pada tahap kapsulasi');
        $this->addBab22SubabTables('kemasan_3332', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.3.3.3
        $this->addSubSubSubabText('2.3.3.3.3.',
            'Tabel data hasil pemeriksaan aflatoksin total');
        $this->addBab22SubabTables('kemasan_3333', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.3.3.4
        $hasilKemas = $this->data['kemasan_hasil'] ?? 'memenuhi syarat';
        $this->addSubSubSubabText('2.3.3.3.4.',
            "Hasil pemeriksaan batch validasi {$batchName} pada tahap kemas primer memberikan hasil yang {$hasilKemas} Spesifikasi Produk dan Kemasan yang berlaku untuk parameter isi dalam satu botol, kondisi aluseal, aflatoksin total, dan cemaran mikroba.");
    }

    /**
     * Export BAB 3: KESIMPULAN
     */
    protected function exportBab3(): void
    {
        $this->section->addTextBreak(1);

        $this->section->addText('3. KESIMPULAN', ['bold' => true, 'size' => 11], [
            'alignment' => 'both',
            'spaceAfter' => 0,
        ]);

        $namaProduk = $this->data['kesimpulan_nama_produk'] ?? $this->data['tujuan_nama_produk'] ?? $this->data['judul_nama_produk'] ?? 'Nutracare Grape Seed';
        $batchCodes = $this->data['kesimpulan_batch_codes'] ?? $this->data['batch_name'] ?? 'NOV25A01 dan NOV25A02';
        $metode     = $this->data['rangkuman_metode'] ?? 'penimbangan bahan baku, pencampuran, kapsulasi, dan pengemasan primer (botol)';
        $noDokProd  = $this->data['pencampuran_no_dokumen'] ?? 'AI-A0005-00-PC';
        $tglDokProd = $this->data['pencampuran_tanggal_dokumen'] ?? '06-11-2025';
        $noDokKemas = $this->data['kesimpulan_no_dokumen_kemas'] ?? 'AI-A0008-00-NL';
        $tglDokKemas = $this->data['kesimpulan_tgl_dokumen_kemas'] ?? '29-10-2025';

        // 3.1
        $this->addKesimpulanItem('3.1',
            "Telah dilakukan validasi proses pengolahan {$namaProduk} batch {$batchCodes} yaitu {$metode} telah dilakukan sesuai MBR Skala Produksi Pengolahan {$namaProduk}, no. dokumen {$noDokProd}, tanggal {$tglDokProd} dan MBR Pengemasan {$namaProduk}, tanggal {$noDokKemas}, tanggal {$tglDokKemas}.");

        // 3.1.1
        $text311 = $this->data['kesimpulan_311_text'] ?? "Berdasarkan pemeriksaan batch validasi {$batchCodes} terhadap parameter mutu produk pada tahap pencampuran antara lain identifikasi grape seed extract didapatkan seluruh hasil pengujian memenuhi spesifikasi produk yang berlaku.";
        if (!empty(trim($text311))) {
            $this->addSubKesimpulanItem('3.1.1', $text311);
        }

        // 3.1.2
        $text312 = $this->data['kesimpulan_312_text'] ?? "Berdasarkan pemeriksaan batch validasi {$batchCodes} terhadap parameter mutu produk pada tahap kapsulasi antara lain parameter pemerian (bentuk, warna cangkang, dan pemerian isi kapsul), kadar air, waktu hancur, keseragaman bobot, identifikasi grape seed extract, dan cemaran logam berat didapatkan seluruh hasil pengujian memenuhi spesifikasi produk yang berlaku.";
        if (!empty(trim($text312))) {
            $this->addSubKesimpulanItem('3.1.2', $text312);
        }

        // 3.1.3
        $text313 = $this->data['kesimpulan_313_text'] ?? "Berdasarkan pemeriksaan batch validasi {$batchCodes} terhadap parameter mutu produk dan kemasan pada tahap kemas primer, antara lain isi dalam satu botol, kondisi aluseal, aflatoksin total, dan cemaran mikroba didapatkan seluruh hasil pengujian memenuhi spesifikasi produk dan kemasan yang berlaku.";
        if (!empty(trim($text313))) {
            $this->addSubKesimpulanItem('3.1.3', $text313);
        }

        // 3.2
        $noDokSpesP  = $this->data['kesimpulan_no_dokumen_spesifikasi_produk'] ?? $this->data['pencampuran_no_dokumen'] ?? 'AI-F03-3-A0018-00';
        $tglDokSpesP = $this->data['kesimpulan_tgl_dokumen_spesifikasi_produk'] ?? $this->data['pencampuran_tanggal_dokumen'] ?? '24-06-2024';
        $noDokSpesK  = $this->data['kesimpulan_no_dokumen_spesifikasi_kemasan'] ?? 'AI-F04-3-A0015-01';
        $tglDokSpesK = $this->data['kesimpulan_tgl_dokumen_spesifikasi_kemasan'] ?? '06-11-2025';
        $status      = $this->data['kesimpulan_status'] ?? 'validated';

        $textRun32 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 740, 'hanging' => 440],
            'contextualSpacing' => true,
        ]);
        $textRun32->addText('3.2', ['bold' => false, 'size' => 11]);
        $textRun32->addText(
            " Berdasarkan pemeriksaan pada batch validasi {$batchCodes}, proses pengolahan dapat menghasilkan produk jadi {$namaProduk} yang memenuhi spesifikasi sesuai dengan Spesifikasi Produk {$namaProduk}, no. dokumen {$noDokSpesP}, tanggal {$tglDokSpesP} dan Spesifikasi Kemasan {$namaProduk}, no. dokumen {$noDokSpesK}, tanggal {$tglDokSpesK} sehingga dinyatakan ",
            ['size' => 11]
        );
        $textRun32->addText($status, ['italic' => true, 'size' => 11]);
        $textRun32->addText('.', ['size' => 11]);

        // Custom sections
        $enabledStr = $this->data['kesimpulan_enabled_sections'] ?? '';
        $enabledSections = array_map('trim', explode(',', $enabledStr));
        $sectionNumber = 3;
        foreach ($enabledSections as $sectionId) {
            if (str_starts_with($sectionId, 'c')) {
                $customNum  = substr($sectionId, 1);
                $customText = $this->data["kesimpulan_custom_{$customNum}"] ?? '';
                if (!empty(trim($customText))) {
                    $this->addKesimpulanItem("3.{$sectionNumber}", trim($customText));
                    $sectionNumber++;
                }
            }
        }
    }

    /**
     * Export BAB 4: SARAN
     */
    protected function exportBab4(): void
    {
        $this->section->addTextBreak(1);

        $this->section->addText('4. SARAN', ['bold' => true, 'size' => 11], [
            'alignment' => 'both',
            'spaceAfter' => 0,
        ]);

        $namaProduk = $this->data['saran_nama_produk'] ?? $this->data['judul_nama_produk'] ?? $this->data['tujuan_nama_produk'] ?? 'Nutracare Grape Seed';
        $saranText  = "Apabila dikemudian hari dilakukan perubahan pada proses produksi produk {$namaProduk}, maka perubahan tersebut harus diberitahukan ke pihak-pihak terkait dengan mekanisme sesuai pedoman pengendalian perubahan yang berlaku.";

        $this->addKesimpulanItem('4.1', $saranText);
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
     * Helper: Add a sub-kesimpulan item (3.1.1, 3.1.2, etc.)
     */
    protected function addSubKesimpulanItem(string $number, string $text): void
    {
        $textRun = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 1350, 'hanging' => 610],
            'contextualSpacing' => true,
        ]);
        $textRun->addText($number, ['bold' => false, 'size' => 11]);
        $textRun->addText(' ' . $text, ['size' => 11]);
    }

    /**
     * Helper: Add subab heading (2.3.1, 2.3.2, etc.)
     */
    protected function addSubabHeading(string $number, string $title): void
    {
        $textRun = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 740, 'hanging' => 440],
            'contextualSpacing' => true,
        ]);
        $textRun->addText($number, ['bold' => false, 'size' => 11]);
        $textRun->addText(' ' . $title, ['bold' => true, 'size' => 11]);
    }

    /**
     * Helper: Add sub-subab text (2.3.1.1, 2.3.1.2, etc.)
     */
    protected function addSubSubabText(string $number, string $text): void
    {
        $textRun = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 1350, 'hanging' => 610],
            'contextualSpacing' => true,
        ]);
        $textRun->addText($number, ['bold' => false, 'size' => 11]);
        $textRun->addText(' ' . $text, ['size' => 11]);
    }

    /**
     * Helper: Add sub-sub-subab text (2.3.1.3.1, etc.)
     */
    protected function addSubSubSubabText(string $number, string $text): void
    {
        $textRun = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 1760, 'hanging' => 660],
            'contextualSpacing' => true,
        ]);
        $textRun->addText($number, ['bold' => false, 'size' => 11]);
        $textRun->addText(' ' . $text, ['size' => 11]);
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
        $cell3->addText('APJ IOBA', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
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
        $namaProduk = $this->data['judul_nama_produk'] ?? 'Nutracare_Grape_Seed';
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