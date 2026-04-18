<?php

namespace App\Services\Export;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\ComplexType\TblWidth;
use PhpOffice\PhpWord\IOFactory;

class KapsulExportService
{
    protected PhpWord $phpWord;
    protected Section $section;
    protected array $data;

    /**
     * Export the Kapsul template to Word document
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

        // Build title from form data - convert to uppercase
        $namaProduk = strtoupper($this->data['judul_nama_produk'] ?? 'Konilife Omega 3 Soft Capsule');
        //$line = strtoupper($this->data['judul_line'] ?? '2');
        //$bagian = strtoupper($this->data['judul_bagian'] ?? $this->data['tujuan_bagian'] ?? 'Natpro');

        $formula = trim((string) ($this->data['judul_formula'] ?? ''));

        $titleStyle = ['bold' => true, 'size' => 12];
        $titlePara = ['alignment' => 'center', 'spaceAfter' => 0];

        $this->section->addText('SUMMARY LAPORAN VALIDASI PROSES PEMBUATAN', $titleStyle, $titlePara);
        $this->section->addText("PRODUK {$namaProduk}", $titleStyle, $titlePara);
        if ($formula !== '') {
            $this->section->addText('(' . strtoupper($formula) . ')', $titleStyle, $titlePara);
        }
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

        $enabledBab1Points = array_values(array_filter(array_map(
            'trim',
            explode(',', (string) ($this->data['bab1_enabled_points'] ?? '1.1.1,1.2.1,1.2.2,1.2.3,1.2.4'))
        )));

        // 1.1 Tujuan
        $textRun11 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 300],
            'contextualSpacing' => true,
        ]);
        $textRun11->addText('1.1', ['bold' => true, 'size' => 11]);
        $textRun11->addText('  Tujuan', ['bold' => true, 'size' => 11]);

        // Build tujuan text from form data
        $namaProduk = $this->data['tujuan_nama_produk'] ?? 'Konilife Omega 3 Soft Capsule';
        $besarBets  = $this->data['tujuan_besar_bets'] ?? '34 kg';
        $banyakBets = $this->data['tujuan_banyak_bets'] ?? '68.000';
        $bagian     = $this->data['tujuan_bagian'] ?? $this->data['judul_bagian'] ?? 'Produksi Farmasi I Line Soft Capsule Gedung A';

        $tujuanText = "Summary laporan validasi ini bertujuan mendokumentasikan hasil studi validasi/pembuktian terhadap " .
            "kualitas proses pengolahan produk {$namaProduk} dengan besar bets produksi {$besarBets} = {$banyakBets} Kapsul Lunak, " .
            "di bagian {$bagian}, dalam menghasilkan produk yang memenuhi persyaratan mutu internal Konimex, " .
            "pemerintah dan persyaratan kapabilitas proses yang sudah ditentukan secara konsisten.";

        if (in_array('1.1.1', $enabledBab1Points, true)) {
            $textRun111 = $this->section->addTextRun([
                'alignment' => 'both',
                'indentation' => ['left' => 1350, 'hanging' => 610],
                'contextualSpacing' => true,
            ]);
            $textRun111->addText('1.1.1', ['bold' => false, 'size' => 11]);
            $textRun111->addText(' ' . $tujuanText, ['size' => 11]);
        }

        // 1.2 Batch Validasi
        $textRun12 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 300],
            'contextualSpacing' => true,
        ]);
        $textRun12->addText('1.2', ['bold' => true, 'size' => 11]);
        $textRun12->addText('  Batch Validasi', ['bold' => true, 'size' => 11]);

        // Build batch text from form data
        $jumlahBatch    = $this->data['batch_jumlah'] ?? '3';
        $besaran        = $this->data['batch_besaran'] ?? '34 kg';
        $jumlahKapsul   = $this->data['batch_jumlah_botol'] ?? '68.000';
        $bobotIsi       = $this->data['batch_volume_per_botol'] ?? '500 mg (bobot isi)';
        $kodeList       = $this->data['batch_kode_list'] ?? 'AUG25A01, AUG25A02, dan AUG25A03';
        $bagianProduksi = $this->data['batch_bagian_produksi'] ?? $this->data['tujuan_bagian'] ?? 'Produksi Farmasi I lini Soft Capsule';
        $mesin          = $this->data['tujuan_mesin'] ?? 'mixer softgel melting tank, mesin enkapsulasi, tumbler dryer, dan mesin counting filling';

        $mbrProduk = $this->data['batch_mbr_pengolahan_produk'] ?? $this->data['tujuan_nama_produk'] ?? 'Konilife Omega 3 Soft Capsule';
        $mbrDesc   = $this->data['batch_mbr_multisource_desc'] ?? 'Multisource Omega 3 Fatty Acid Kode Bahan O921-02-CR-HPI';
        $mbrNo     = $this->data['batch_mbr_no'] ?? 'CC-00077-08-PC';
        $mbrMsCode = $this->data['batch_mbr_ms_code'] ?? 'MS O921-02-CR-HPI';
        $mbrTgl    = $this->data['batch_mbr_tanggal'] ?? '04-08-2025';

        $batchText = "Studi validasi dilakukan terhadap {$jumlahBatch} bets produksi yaitu batch {$kodeList} dengan besaran batch {$besaran} = {$jumlahKapsul} Kapsul Lunak @ {$bobotIsi}, yang diproduksi di Bagian {$bagianProduksi} dilakukan dengan menggunakan {$mesin}, mengacu MBR Pengolahan {$mbrProduk} ({$mbrDesc}) no {$mbrNo} ({$mbrMsCode}) tanggal {$mbrTgl}.";

        if (in_array('1.2.1', $enabledBab1Points, true)) {
            $textRun121 = $this->section->addTextRun([
                'alignment' => 'both',
                'indentation' => ['left' => 1350, 'hanging' => 610],
                'contextualSpacing' => true,
            ]);
            $textRun121->addText('1.2.1', ['bold' => false, 'size' => 11]);
            $textRun121->addText(' ' . $batchText, ['size' => 11]);
        }

        $ppNo = $this->data['batch_pp_no'] ?? 'PP-EA-092-00';
        $ppTanggal = $this->data['batch_pp_tanggal'] ?? '23-08-2024';
        $ppRincian = $this->data['batch_perubahan_rincian'] ?? 'merevisi FBB dan MBR pengolahan Konilife Omega 3 (menghapus kode V204-01-KR-PBE, T021-02-CR-FBO, T021-03-CR-BAS dan menambahkan kode O921-02-R-HPI), serta menyesuaikan SP Konilife Omega 3, SBB Omega 3, dan Fish Oil Ethyl dengan Surat Persetujuan Variasi Kepala BPOM RI no. PN.04.01.42.421.07.25.1443.';
        $batchText122 = trim((string) ($this->data['batch_122_text'] ?? ''));
        if ($batchText122 === '') {
            $batchText122 = "Dokumen ini juga menjadi tindak lanjut dari Permintaan Perubahan no {$ppNo} tanggal {$ppTanggal}, dengan perubahan: {$ppRincian}";
        }
        if (in_array('1.2.2', $enabledBab1Points, true)) {
            $textRun122 = $this->section->addTextRun([
                'alignment' => 'both',
                'indentation' => ['left' => 1350, 'hanging' => 610],
                'contextualSpacing' => true,
            ]);
            $textRun122->addText('1.2.2', ['bold' => false, 'size' => 11]);
            $textRun122->addText(' ' . $batchText122, ['size' => 11]);
        }

        $protokolProduk = $this->data['batch_protokol_produk'] ?? $this->data['tujuan_nama_produk'] ?? 'Konilife Omega 3 Soft Capsule';
        $protokolNo = $this->data['batch_protokol_no'] ?? 'AF-D-3-00702-01';
        $protokolTanggal = $this->data['batch_protokol_tanggal'] ?? '24-01-2023';
        $protokolBagian = $this->data['batch_protokol_bagian'] ?? $this->data['batch_bagian_produksi'] ?? 'Produksi Farmasi I Line Soft Capsule Gedung A';
        $fbbNo = $this->data['batch_fbb_no'] ?? 'BB-0914-0-ID-00-ALL-04';
        $fbbTanggal = $this->data['batch_fbb_tanggal'] ?? '05-08-2025';
        $spProduk = $this->data['batch_sp_produk'] ?? $this->data['tujuan_nama_produk'] ?? 'Konilife Omega 3 Soft Capsule';
        $spNo = $this->data['batch_sp_no'] ?? 'EA-F03-3-00158-01';
        $spTanggal = $this->data['batch_sp_tanggal'] ?? '06-08-2025';
        $batchText123 = "Tinjauan status validasi proses pembuatan karena perubahan ini, dilakukan berdasar pada Protokol Validasi Proses Pembuatan Produk {$protokolProduk}, no. {$protokolNo}, tanggal {$protokolTanggal} pada Bagian {$protokolBagian}, dengan pembaruan dokumen Formula Bahan Baku (FBB) no {$fbbNo} tanggal {$fbbTanggal} dan dokumen Spesifikasi Produk {$spProduk} no {$spNo} tanggal {$spTanggal}.";

        if (in_array('1.2.3', $enabledBab1Points, true)) {
            $textRun123 = $this->section->addTextRun([
                'alignment' => 'both',
                'indentation' => ['left' => 1350, 'hanging' => 610],
                'contextualSpacing' => true,
            ]);
            $textRun123->addText('1.2.3', ['bold' => false, 'size' => 11]);
            $textRun123->addText(' ' . $batchText123, ['size' => 11]);
        }

        $batchText124 = 'Validasi proses dilakukan untuk variasi multisource bahan baku aktif sebagai berikut:';
        if (in_array('1.2.4', $enabledBab1Points, true)) {
            $textRun124 = $this->section->addTextRun([
                'alignment' => 'both',
                'indentation' => ['left' => 1350, 'hanging' => 610],
                'contextualSpacing' => true,
            ]);
            $textRun124->addText('1.2.4', ['bold' => false, 'size' => 11]);
            $textRun124->addText(' ' . $batchText124, ['size' => 11]);
        }

        // Add Bahan Aktif table if present
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
        $col1 = 2400; // BB Zat Aktif
        $col2 = 1500; // Kode BB
        $col3 = 3000; // Supplier
        $col4 = 1500; // Asal Negara
        $col5 = 1800; // Kode Supplier

        $table = $this->section->addTable($tableStyle);

        // Header row
        $table->addRow(100);
        $table->addCell($col1, $headerCellStyle)->addText('BB Zat Aktif', $headerFontStyle, $headerCellParagraph);
        $table->addCell($col2, $headerCellStyle)->addText('Kode BB', $headerFontStyle, $headerCellParagraph);
        $table->addCell($col3, $headerCellStyle)->addText('Supplier', $headerFontStyle, $headerCellParagraph);
        $table->addCell($col4, $headerCellStyle)->addText('Asal Negara', $headerFontStyle, $headerCellParagraph);
        $table->addCell($col5, $headerCellStyle)->addText('Kode Supplier', $headerFontStyle, $headerCellParagraph);

        // Data rows from pasted Excel
        foreach ($tableData as $row) {
            $table->addRow(250);
            $table->addCell($col1, $cellStyle)->addText($row[0] ?? '-', $cellFontStyle, $cellParagraph);
            $table->addCell($col2, $cellStyle)->addText($row[1] ?? '-', $cellFontStyle, $cellParagraph);
            $table->addCell($col3, $cellStyle)->addText($row[2] ?? '-', $cellFontStyle, $cellParagraph);
            $table->addCell($col4, $cellStyle)->addText($row[3] ?? '-', $cellFontStyle, $headerCellParagraph);
            $table->addCell($col5, $cellStyle)->addText($row[4] ?? '-', $cellFontStyle, $headerCellParagraph);
        }
    }

    /**
     * Export BAB 2: HASIL DAN EVALUASI VALIDASI PROSES
     */
    protected function exportBab2(): void
    {
        $this->section->addTextBreak(1);

        // BAB 2 Title
        $this->section->addText('2. HASIL DAN EVALUASI VALIDASI PROSES', ['bold' => true, 'size' => 11], [
            'alignment' => 'both',
            'spaceAfter' => 0,
        ]);

        $tableSubabMap = $this->data['bab22_table_subab_key'] ?? [];
        $imageMap = $this->data['mixing_image_file'] ?? [];
        $existingImageMap = $this->data['existing_mixing_image_file'] ?? [];

        if (!is_array($tableSubabMap)) $tableSubabMap = [];
        if (!is_array($imageMap)) $imageMap = [];
        if (!is_array($existingImageMap)) $existingImageMap = [];

        $bab2StaticEnabled = array_map('trim', explode(',', (string) ($this->data['bab2_static_enabled'] ?? '2.1,2.2,2.3,2.3.1,2.3.1.1,2.3.1.2,2.3.1.3,2.3.2,2.3.2.1,2.3.2.2,2.3.2.3,2.3.2.3.1,2.3.2.3.2,2.3.2.3.3,2.3.2.3.4,2.3.2.3.5,2.3.2.4,2.3.3')));
        $isEnabled = fn(string $num): bool => in_array($num, $bab2StaticEnabled, true);

        // 2.1 Pelaksanaan Proses Produksi
        if ($isEnabled('2.1')) {
            $textRun21 = $this->section->addTextRun([
                'alignment' => 'both',
                'indentation' => ['left' => 740, 'hanging' => 440],
                'contextualSpacing' => true,
            ]);
            $textRun21->addText('2.1.', ['bold' => true, 'size' => 11]);
            $textRun21->addText(' Pelaksanaan Proses Produksi:', ['bold' => true, 'size' => 11]);

            // Render tabel pelaksanaan (paste/screenshot)
            $this->addBab22SubabTables('pelaksanaan', $tableSubabMap, $imageMap, $existingImageMap);
        }

        // 2.2 Teks statis
        if ($isEnabled('2.2')) {
            $textRun22 = $this->section->addTextRun([
                'alignment' => 'both',
                'indentation' => ['left' => 740, 'hanging' => 440],
                'contextualSpacing' => true,
            ]);
            $textRun22->addText('2.2.', ['bold' => true, 'size' => 11]);
            $textRun22->addText(' Seluruh tahapan pengolahan dan pengemasan primer telah dilakukan sesuai dengan prosedur pengolahan dan pengemasan yang berlaku.', ['size' => 11]);
        }

        // 2.3 Hasil pemeriksaan sampel
        if ($isEnabled('2.3')) {
            $textRun23 = $this->section->addTextRun([
                'alignment' => 'both',
                'indentation' => ['left' => 740, 'hanging' => 440],
                'contextualSpacing' => true,
            ]);
            $textRun23->addText('2.3.', ['bold' => true, 'size' => 11]);
            $textRun23->addText(' Hasil pemeriksaan sampel pada masing-masing tahapan adalah sebagai berikut :', ['size' => 11]);

            // 2.3.x dynamic subabs
            $this->exportBab23SubabsDynamic($tableSubabMap, $imageMap, $existingImageMap);
        }
    }

    /**
     * Export BAB 2.3.x: Static subabs (Enkapsulasi, Pengeringan, Kemas Primer)
     */
    protected function exportBab23SubabsDynamic(array $tableSubabMap, array $imageMap, array $existingImageMap): void
    {
        $namaProduk = trim((string) ($this->data['tujuan_nama_produk'] ?? 'Konilife Omega 3 Soft Capsule'));
        $batchList  = trim((string) ($this->data['batch_kode_list'] ?? 'AUG25A01, AUG25A02, dan AUG25A03'));

        $bab2StaticEnabled = array_map('trim', explode(',', (string) ($this->data['bab2_static_enabled'] ?? '2.1,2.2,2.3,2.3.1,2.3.1.1,2.3.1.2,2.3.1.3,2.3.2,2.3.2.1,2.3.2.2,2.3.2.3,2.3.2.3.1,2.3.2.3.2,2.3.2.3.3,2.3.2.3.4,2.3.2.3.5,2.3.2.4,2.3.3')));
        $isEnabled = fn(string $num): bool => in_array($num, $bab2StaticEnabled, true);

        // --- 2.3.1 Enkapsulasi (Sebelum pengeringan) ---
        if ($isEnabled('2.3.1')) {
            $this->addBab23SubabHeading('2.3.1', 'Enkapsulasi (Sebelum pengeringan)');

            if ($isEnabled('2.3.1.1')) {
                $bobotSyarat = trim((string) ($this->data['enkapsulasi_bobot_syarat'] ?? '500 ± 50 mg'));
                $this->addBab23SubSubabText('2.3.1.1',
                    "Hasil enkapsulasi memiliki keseragaman bobot (isi) dengan syarat kualitas {$bobotSyarat}.");
            }

            if ($isEnabled('2.3.1.2')) {
                $samplingLokasi = trim((string) ($this->data['enkapsulasi_sampling_lokasi'] ?? '3'));
                $samplingJumlah = trim((string) ($this->data['enkapsulasi_sampling_jumlah'] ?? '20'));
                $this->addBab23SubSubabText('2.3.1.2',
                    "Dilakukan sampling pemeriksaan bobot pada {$samplingLokasi} lokasi (awal, tengah, akhir) dengan jumlah {$samplingJumlah} butir soft capsule pada setiap pengambilan sampel, dengan hasil sebagai berikut:");
                $this->renderBab23Image('bab23_enkapsulasi_tabel', $imageMap, $existingImageMap);
            }

            if ($isEnabled('2.3.1.3')) {
                $enkNamaProduk = trim((string) ($this->data['enkapsulasi_nama_produk'] ?? $namaProduk));
                $enkBatchList  = trim((string) ($this->data['enkapsulasi_batch_list'] ?? $batchList));
                $this->addBab23SubSubabText('2.3.1.3',
                    "Seluruh hasil pemeriksaan sampel tahap enkapsulasi (sebelum pengeringan) produk {$enkNamaProduk} bets {$enkBatchList} memenuhi spesifikasi produk yang ditetapkan.");
            }
        }

        // --- 2.3.2 Tahap Pengeringan ---
        if ($isEnabled('2.3.2')) {
            $this->addBab23SubabHeading('2.3.2', 'Tahap Pengeringan');

            // 2.3.2.1
            if ($isEnabled('2.3.2.1')) {
                $spProduk  = trim((string) ($this->data['pengeringan_sp_produk'] ?? $namaProduk));
                $spNo      = trim((string) ($this->data['pengeringan_sp_no'] ?? 'EA-F03-3-00158-01'));
                $spTanggal = trim((string) ($this->data['pengeringan_sp_tanggal'] ?? '06-08-2025'));
                $this->addBab23SubSubabText('2.3.2.1',
                    "Syarat kualitas produk setelah tahap pengeringan memiliki syarat mutu sesuai Spesifikasi Produk {$spProduk} no {$spNo} tanggal {$spTanggal}, sebagai berikut:");
                $this->renderBab23Image('bab232_spesifikasi_tabel', $imageMap, $existingImageMap);
            }

            // 2.3.2.2
            if ($isEnabled('2.3.2.2')) {
                $mesin          = trim((string) ($this->data['pengeringan_mesin'] ?? 'tumbler dryer'));
                $jumlahTray     = trim((string) ($this->data['pengeringan_jumlah_tray'] ?? '10'));
                $jumlahSampling = trim((string) ($this->data['pengeringan_jumlah_sampling'] ?? '30'));
                $this->addBab23SubSubabText('2.3.2.2',
                    "Hasil enkapsulasi setelah tahap pengeringan, berupa soft capsule yang telah dikeringkan pada {$mesin}, secara urut ditampung dalam tray-tray dan dikeringkan di ruang pengering, sehingga menjadi soft capsule kering. Tray dibagi menjadi {$jumlahTray} kelompok dan dilakukan sampling sebanyak {$jumlahSampling} soft capsule per kelompok untuk semua pemeriksaan atribut di atas, dengan kondisi aktual pengeringan sebagai berikut:");
                $this->renderBab23Image('bab232_kondisi_tabel', $imageMap, $existingImageMap);
            }

            // 2.3.2.3
            if ($isEnabled('2.3.2.3')) {
                $this->addBab23SubSubabText('2.3.2.3',
                    'Hasil pemeriksaan sampel untuk pemeriksaan atribut sebagai berikut:');

                // 2.3.2.3.1
                if ($isEnabled('2.3.2.3.1')) {
                    $this->addBab23SubSubSubabText('2.3.2.3.1', 'Pemeriksaan keseragaman bobot');
                    $this->renderBab23Image('bab232_bobot_tabel', $imageMap, $existingImageMap);
                }

                // 2.3.2.3.2
                if ($isEnabled('2.3.2.3.2')) {
                    $this->addBab23SubSubSubabText('2.3.2.3.2', 'Pemeriksaan Fisik');
                    $this->renderBab23Image('bab232_fisik_tabel', $imageMap, $existingImageMap);
                }

                // 2.3.2.3.3
                if ($isEnabled('2.3.2.3.3')) {
                    $labName = trim((string) ($this->data['kadar_lab_name'] ?? 'PT SIG Laboratory'));
                    $this->addBab23SubSubSubabText('2.3.2.3.3',
                        "Pemeriksaan kadar zat aktif dilakukan oleh pihak ke-3 ({$labName}) dengan hasil pemeriksaan diterbitkan dalam bentuk sertifikat pengujian:");
                    $this->renderBab23Image('bab232_sertifikat_tabel', $imageMap, $existingImageMap);
                    $this->section->addText(
                        'Dengan resume hasil pemeriksaan kadar zat aktif sebagai berikut:',
                        ['size' => 11],
                        ['alignment' => 'both', 'indentation' => ['left' => 1440], 'contextualSpacing' => true]
                    );
                    $this->renderBab23Image('bab232_kadar_tabel', $imageMap, $existingImageMap);
                }

                // 2.3.2.3.4
                if ($isEnabled('2.3.2.3.4')) {
                    $this->addBab23SubSubSubabText('2.3.2.3.4', 'Pemeriksaan Cemaran Logam Berat');
                    $this->renderBab23Image('bab232_logam_tabel', $imageMap, $existingImageMap);
                }

                // 2.3.2.3.5
                if ($isEnabled('2.3.2.3.5')) {
                    $this->addBab23SubSubSubabText('2.3.2.3.5', 'Pemeriksaan Mikrobiologi');
                    $this->renderBab23Image('bab232_mikro_tabel', $imageMap, $existingImageMap);
                }
            }

            // 2.3.2.4
            if ($isEnabled('2.3.2.4')) {
                $pengeringanNama  = trim((string) ($this->data['pengeringan_nama_produk'] ?? $namaProduk));
                $pengeringanBatch = trim((string) ($this->data['pengeringan_batch_list'] ?? $batchList));
                $this->addBab23SubSubabText('2.3.2.4',
                    "Seluruh hasil pemeriksaan sampel pengeringan produk {$pengeringanNama} bets {$pengeringanBatch} memenuhi spesifikasi produk yang ditetapkan.");
            }
        }

        // --- 2.3.3 Tahap Kemas Primer ---
        if ($isEnabled('2.3.3')) {
            $this->addBab23SubabHeading('2.3.3', 'Tahap Kemas Primer');
            $this->renderBab23Image('bab23_kemas_tabel', $imageMap, $existingImageMap);

            $kemasNama  = trim((string) ($this->data['kemas_nama_produk'] ?? $namaProduk));
            $kemasBatch = trim((string) ($this->data['kemas_batch_list'] ?? $batchList));
            $this->section->addText(
                "Seluruh hasil pemeriksaan sampel tahap kemas primer {$kemasNama} bets {$kemasBatch} telah memenuhi spesifikasi kemasan yang ditetapkan.",
                ['size' => 11],
                ['alignment' => 'both', 'indentation' => ['left' => 740], 'contextualSpacing' => true]
            );
        }
    }

    private function addBab23SubabHeading(string $number, string $title): void
    {
        $textRun = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 740, 'hanging' => 440],
            'spaceAfter' => 60,
        ]);
        $textRun->addText($number, ['bold' => true, 'size' => 11]);
        $textRun->addText("  {$title}", ['bold' => true, 'size' => 11]);
    }

    private function addBab23SubSubabText(string $number, string $text): void
    {
        $textRun = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 1080, 'hanging' => 580],
            'contextualSpacing' => true,
        ]);
        $textRun->addText($number, ['bold' => true, 'size' => 11]);
        $textRun->addText("  {$text}", ['size' => 11]);
    }

    private function addBab23SubSubSubabText(string $number, string $text): void
    {
        $textRun = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 1440, 'hanging' => 720],
            'contextualSpacing' => true,
        ]);
        $textRun->addText($number, ['bold' => true, 'size' => 11]);
        $textRun->addText("  {$text}", ['size' => 11]);
    }

    private function renderBab23Image(string $uid, array $imageMap, array $existingImageMap): void
    {
        $imageFile = $imageMap[$uid] ?? null;
        $base64 = trim((string) ($this->data["mixing_image_base64[{$uid}]"] ?? $this->data['mixing_image_base64'][$uid] ?? ''));
        $resolvedPath = $this->resolveStoredImagePath($existingImageMap[$uid] ?? null);

        if ($imageFile instanceof UploadedFile && $imageFile->isValid()) {
            try {
                $this->section->addImage($imageFile->getPathname(), ['width' => 450, 'align' => 'center', 'marginTop' => 6, 'marginBottom' => 6]);
            } catch (\Exception $e) {
                $this->section->addText("[Error gambar: {$e->getMessage()}]", ['color' => 'FF0000']);
            }
        } elseif ($resolvedPath) {
            try {
                $this->section->addImage($resolvedPath, ['width' => 450, 'align' => 'center', 'marginTop' => 6, 'marginBottom' => 6]);
            } catch (\Exception $e) {
                $this->section->addText("[Error gambar draft: {$e->getMessage()}]", ['color' => 'FF0000']);
            }
        } elseif ($base64 !== '' && str_starts_with($base64, 'data:image')) {
            try {
                $commaPos = strpos($base64, ',');
                $imageData = base64_decode(substr($base64, $commaPos + 1));
                $tmpFile = tempnam(sys_get_temp_dir(), 'bab23img');
                file_put_contents($tmpFile, $imageData);
                $this->section->addImage($tmpFile, ['width' => 450, 'align' => 'center', 'marginTop' => 6, 'marginBottom' => 6]);
                @unlink($tmpFile);
            } catch (\Exception $e) {
                $this->section->addText("[Error gambar base64]", ['color' => 'FF0000']);
            }
        } else {
            // Try pasted table JSON
            $pastedJson = trim((string) ($this->data['mixing_pasted_table_json'][$uid] ?? ''));
            if ($pastedJson !== '') {
                $rows = json_decode($pastedJson, true);
                if (is_array($rows) && !empty($rows)) {
                    $this->renderPastedTableToWord($rows);
                }
            }
        }
    }

    /**
     * Resolve enabled BAB 2.2 subabs in editor order.
     */
    protected function getEnabledBab22SubabKeys(): array
    {
        $enabledStr = trim((string) ($this->data['bab22_enabled_subab_keys'] ?? ''));
        if ($enabledStr !== '') {
            return array_values(array_filter(array_map('trim', explode(',', $enabledStr))));
        }

        $fallbackOrder = ['mixing', 'tahap_pengeringan', 'tahap_kemas_primer'];
        $tableSubabMap = $this->data['bab22_table_subab_key'] ?? [];

        if (is_array($tableSubabMap) && !empty($tableSubabMap)) {
            $ordered = [];
            foreach ($tableSubabMap as $key) {
                $key = trim((string) $key);
                if ($key !== '' && !in_array($key, $ordered, true)) {
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
            'mixing' => 'Enkapsulasi (Sebelum pengeringan)',
            'tahap_pengeringan' => 'Tahap Pengeringan',
            'tahap_kemas_primer' => 'Tahap Kemas Primer',
            default => trim((string) ($this->data["{$subabKey}_title"] ?? 'Subab')),
        };

        return $title !== '' ? $title : 'Subab';
    }

    /**
     * Resolve closing paragraph by subab key.
     */
    protected function getBab22SubabClosingText(string $subabKey): string
    {
        $namaProduk = $this->data['mixing_nama_produk'] ?? $this->data['tujuan_nama_produk'] ?? 'Konilife Omega 3 Soft Capsule';
        $batchList  = $this->data['mixing_batch_list'] ?? $this->data['batch_kode_list'] ?? 'AUG25A01, AUG25A02, dan AUG25A03';
        $formula = trim((string) ($this->data['judul_formula'] ?? ''));
        $produkLabel = $formula !== '' ? ($namaProduk . ' (' . $formula . ')') : $namaProduk;

        return match ($subabKey) {
            'mixing' => 'Seluruh hasil pemeriksaan bobot sampel tahap enkapsulasi (sebelum pengeringan) produk ' .
                $produkLabel . ' bets ' . $batchList . ' sudah memberikan hasil yang ' .
                ($this->data['mixing_hasil'] ?? 'memenuhi') .
                ' spesifikasi produk yang ditetapkan' .
                $this->resolveBab22ClosingTail('mixing_hasil_catatan') . '.',
            'tahap_pengeringan' => 'Seluruh hasil pemeriksaan sampel pengeringan produk ' .
                $produkLabel . ' bets ' . $batchList . ' memenuhi spesifikasi produk yang ditetapkan' .
                $this->resolveBab22ClosingTail('tahap_pengeringan_hasil_catatan') . '.',
            'tahap_kemas_primer' => 'Seluruh hasil pemeriksaan sampel tahap kemas primer ' .
                $produkLabel . ' bets ' . $batchList . ' telah memenuhi spesifikasi kemasan yang ditetapkan' .
                $this->resolveBab22ClosingTail('tahap_kemas_primer_hasil_catatan') . '.',
            default => trim((string) ($this->data["{$subabKey}_notes"] ?? '')),
        };
    }

    private function resolveBab22ClosingTail(string $fieldName): string
    {
        $tail = trim((string) ($this->data[$fieldName] ?? ''));
        return $tail !== '' ? " {$tail}" : '';
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

        $enabledStr = $this->data['kesimpulan_enabled_sections'] ?? '1,2';
        $enabledSections = array_map('trim', explode(',', $enabledStr));

        $sectionNumber = 1;

        // Section 1: Produksi + tinjauan perubahan
        if (in_array('1', $enabledSections)) {
            $namaProduk  = $this->data['kesimpulan_nama_produk'] ?? $this->data['tujuan_nama_produk'] ?? 'Konilife Omega 3 Soft Capsule';
            $batchCodes  = $this->data['kesimpulan_batch_codes'] ?? $this->data['batch_kode_list'] ?? 'AUG25A01, AUG25A02, dan AUG25A03';
            $namaProduk2 = $this->data['kesimpulan_nama_produk_2'] ?? $namaProduk;
            $ppNo        = $this->data['kesimpulan_pp_no'] ?? 'PP-EA-092-00';
            $ppTanggal   = $this->data['kesimpulan_pp_tanggal'] ?? '23-08-2024';

            $text = "Telah dilakukan proses produksi terhadap produk {$namaProduk} bets {$batchCodes} yang digunakan sebagai batch validasi proses, sekaligus menjadi tinjauan status validasi proses produk {$namaProduk2} terhadap Permintaan Perubahan no {$ppNo} tanggal {$ppTanggal}.";
            $this->addKesimpulanItem("3.{$sectionNumber}", $text);
            $sectionNumber++;
        }

        // Section 2: Final conclusion (validated)
        if (in_array('2', $enabledSections)) {
            $finalProduk  = $this->data['kesimpulan_final_produk'] ?? $this->data['tujuan_nama_produk'] ?? 'Konilife Omega 3 Soft Capsule';
            $namaProduk3  = $this->data['kesimpulan_nama_produk_3'] ?? $finalProduk;
            $status       = $this->data['kesimpulan_status'] ?? 'validated';

            $text = "Proses terbukti dapat menghasilkan produk jadi {$finalProduk} yang memenuhi spesifikasi dalam Spesifikasi Produk dan Spesifikasi Kemasan {$namaProduk3} sehingga dinyatakan ";

            $textRun = $this->section->addTextRun([
                'alignment' => 'both',
                'indentation' => ['left' => 740, 'hanging' => 440],
                'contextualSpacing' => true,
            ]);
            $textRun->addText("3.{$sectionNumber}", ['bold' => true, 'size' => 11]);
            $textRun->addText(' ' . $text, ['size' => 11]);
            $textRun->addText($status, ['italic' => true, 'size' => 11]);
            $textRun->addText('.', ['size' => 11]);
            $sectionNumber++;
        }

        // Custom sections (c1, c2, c3, ...)
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
     * Helper: Add a kesimpulan item with number and text
     */
    protected function addKesimpulanItem(string $number, string $text): void
    {
        $textRun = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 740, 'hanging' => 440],
            'contextualSpacing' => true,
        ]);
        $textRun->addText($number, ['bold' => true, 'size' => 11]);
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
     * Render a pasted table (array of rows) into the Word document
     */
    private function renderPastedTableToWord(array $rows): void
    {
        if (empty($rows)) return;

        $colCount = max(array_map('count', $rows));
        $totalWidth = 9200;
        $colWidth = (int) ($totalWidth / max($colCount, 1));

        $tableStyle = [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 80,
            'width' => $totalWidth,
            'unit' => 'dxa',
        ];

        $table = $this->section->addTable($tableStyle);

        foreach ($rows as $rowIdx => $row) {
            $table->addRow();
            foreach ($row as $cell) {
                $cellStyle = $rowIdx === 0 ? ['bgColor' => 'D9D9D9'] : [];
                $fontStyle = $rowIdx === 0 ? ['bold' => true, 'size' => 11] : ['size' => 11];
                $table->addCell($colWidth, $cellStyle)->addText((string) $cell, $fontStyle, ['spaceAfter' => 0, 'alignment' => 'center']);
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

        $namaProduk = $this->data['saran_nama_produk_4'] ?? $this->data['tujuan_nama_produk'] ?? 'Konilife Omega 3 Soft Capsule';
        $defaultSaran = "Apabila dikemudian hari dilakukan perubahan pada proses produksi produk {$namaProduk}, maka perubahan tersebut harus diberitahukan ke pihak-pihak terkait dengan mekanisme sesuai pedoman pengendalian perubahan yang berlaku.";

        $enabledStr = $this->data['saran_enabled_sections'] ?? '1';
        $enabledSections = array_map('trim', explode(',', $enabledStr));

        $sectionNumber = 1;

        // Section 1: main saran
        if (in_array('1', $enabledSections)) {
            $saranText = trim((string) ($this->data['saran_text'] ?? ''));
            if ($saranText === '') {
                $saranText = $defaultSaran;
            }
            $textRun = $this->section->addTextRun([
                'alignment' => 'both',
                'indentation' => ['left' => 740, 'hanging' => 440],
                'contextualSpacing' => true,
            ]);
            $textRun->addText("4.{$sectionNumber}", ['bold' => true, 'size' => 11]);
            $textRun->addText('  ' . $saranText, ['size' => 11]);
            $sectionNumber++;
        }

        // Custom saran sections (c1, c2, ...)
        foreach ($enabledSections as $sectionId) {
            if (str_starts_with($sectionId, 'c')) {
                $customNum  = substr($sectionId, 1);
                $customText = trim((string) ($this->data["saran_custom_{$customNum}"] ?? ''));
                if ($customText !== '') {
                    $textRun = $this->section->addTextRun([
                        'alignment' => 'both',
                        'indentation' => ['left' => 740, 'hanging' => 440],
                        'contextualSpacing' => true,
                    ]);
                    $textRun->addText("4.{$sectionNumber}", ['bold' => true, 'size' => 11]);
                    $textRun->addText('  ' . $customText, ['size' => 11]);
                    $sectionNumber++;
                }
            }
        }
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

        $footerTable->addCell($col1, ['borderSize' => 6, 'valign' => 'center'])
            ->addText('Dibuat oleh', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0, 'spaceBefore' => 0]);

        $footerTable->addCell($col2, ['borderSize' => 6, 'valign' => 'center'])
            ->addText('Diperiksa oleh', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0, 'spaceBefore' => 0]);

        $footerTable->addCell($col3 + $col4, ['gridSpan' => 2, 'borderSize' => 6, 'valign' => 'center'])
            ->addText('Disetujui oleh', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0, 'spaceBefore' => 0]);

        // Row 2: Signature blocks
        $footerTable->addRow(650);

        $cell1 = $footerTable->addCell($col1, ['borderSize' => 6, 'valign' => 'bottom']);
        $cell1->addTextBreak(2);
        $cell1->addText('Validation Officer (1)', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $cell1->addText('Tanggal:', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);

        $cell2 = $footerTable->addCell($col2, ['borderSize' => 6, 'valign' => 'bottom']);
        $cell2->addTextBreak(2);
        $cell2->addText('Validation Manager', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $cell2->addText('Tanggal:', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);

        $cell3 = $footerTable->addCell($col3, ['borderSize' => 6, 'valign' => 'bottom']);
        $cell3->addTextBreak(2);
        $cell3->addText('APJ IOBA', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $cell3->addText('Tanggal:', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);

        $cell4 = $footerTable->addCell($col4, ['borderSize' => 6, 'valign' => 'bottom']);
        $cell4->addTextBreak(2);
        $cell4->addText('Quality Div. Manager', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $cell4->addText('Tanggal:', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
    }

    /**
     * Save document and return download response
     */
    protected function saveAndDownload()
    {
        $namaProduk = $this->data['judul_nama_produk'] ?? 'Kapsul';
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