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

        $formula = $this->data['judul_formula'] ?? '';
        $formulaStr = $formula ? ' (' . strtoupper($formula) . ')' : '';

        $title = "SUMMARY LAPORAN VALIDASI PROSES PEMBUATAN" .
        "PRODUK {$namaProduk}" .
        "{$formulaStr} ";

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

        // Build tujuan text from form data
        $namaProduk = $this->data['tujuan_nama_produk'] ?? 'Konilife Omega 3 Soft Capsule';
        $besarBets  = $this->data['tujuan_besar_bets'] ?? '34 kg';
        $banyakBets = $this->data['tujuan_banyak_bets'] ?? '68.000';
        $bagian     = $this->data['tujuan_bagian'] ?? $this->data['judul_bagian'] ?? 'Produksi Farmasi I Line Soft Capsule Gedung A';

        $tujuanText = "Summary laporan validasi ini bertujuan mendokumentasikan hasil studi validasi/pembuktian terhadap " .
            "kualitas proses pengolahan produk {$namaProduk} dengan besar bets produksi {$besarBets} = {$banyakBets} Kapsul Lunak, " .
            "di bagian {$bagian}, dalam menghasilkan produk yang memenuhi persyaratan mutu internal Konimex, " .
            "pemerintah dan persyaratan kapabilitas proses yang sudah ditentukan secara konsisten.";

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

        // Build batch text from form data
        $jumlahBatch    = $this->data['batch_jumlah'] ?? 'tiga';
        $besaran        = $this->data['batch_besaran'] ?? '34 kg';
        $jumlahKapsul   = $this->data['batch_jumlah_botol'] ?? '68.000';
        $bobotIsi       = $this->data['batch_volume_per_botol'] ?? '500 mg (bobot isi)';
        $kodeList       = $this->data['batch_kode_list'] ?? 'AUG25A01, AUG25A02, AUG25A03';
        $bagianProduksi = $this->data['batch_bagian_produksi'] ?? $this->data['tujuan_bagian'] ?? 'Produksi Farmasi I Line Soft Capsule Gedung A';
        $mesin          = $this->data['tujuan_mesin'] ?? 'mixer softgel melting tank, mesin enkapsulasi, tumbler dryer, dan mesin counting filling';

        $batchText = "Studi validasi dilakukan terhadap {$jumlahBatch} bets produksi dengan besaran batch {$besaran} = {$jumlahKapsul} Kapsul Lunak @ {$bobotIsi}, yaitu batch {$kodeList} yang diproduksi di Bagian {$bagianProduksi} dilakukan dengan menggunakan {$mesin}.";

        $textRun121 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 1350, 'hanging' => 610],
            'contextualSpacing' => true,
        ]);
        $textRun121->addText('1.2.1', ['bold' => false, 'size' => 11]);
        $textRun121->addText(' ' . $batchText, ['size' => 11]);

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
     * Export BAB 2: RANGKUMAN HASIL
     */
    protected function exportBab2(): void
    {
        $this->section->addTextBreak(1);

        // BAB 2 Title
        $this->section->addText('2. RANGKUMAN HASIL', ['bold' => true, 'size' => 11], [
            'alignment' => 'both',
            'spaceAfter' => 0,
        ]);

        // 2.1
        $textRun21 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 740, 'hanging' => 440],
            'contextualSpacing' => true,
        ]);
        $textRun21->addText('2.1', ['bold' => false, 'size' => 11]);
        $textRun21->addText(' Seluruh tahapan pengolahan dan pengemasan primer telah dilakukan sesuai dengan prosedur pengolahan dan pengemasan yang berlaku.', ['size' => 11]);

        // 2.2 Subheading 
        $textRun22 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 670, 'hanging' => 370],
            'spaceAfter' => 60,
        ]);
        $textRun22->addText('2.2', ['bold' => false, 'size' => 11]);
        $textRun22->addText('  Hasil pemeriksaan sampel', ['size' => 11]);

        $enabledSubabKeys = $this->getEnabledBab22SubabKeys();
        $tableSubabMap = $this->data['bab22_table_subab_key'] ?? [];
        $imageMap = $this->data['mixing_image_file'] ?? [];
        $existingImageMap = $this->data['existing_mixing_image_file'] ?? [];

        if (!is_array($tableSubabMap)) {
            $tableSubabMap = [];
        }
        if (!is_array($imageMap)) {
            $imageMap = [];
        }
        if (!is_array($existingImageMap)) {
            $existingImageMap = [];
        }

        $subabNumber = 1;
        foreach ($enabledSubabKeys as $subabKey) {
            $subabTitle = $this->getBab22SubabTitle($subabKey);

            $textRun22x = $this->section->addTextRun([
                'alignment' => 'both',
                'indentation' => ['left' => 740],
                'spaceAfter' => 120,
            ]);
            $textRun22x->addText("2.2.{$subabNumber}", ['bold' => false, 'size' => 11]);
            $textRun22x->addText(" {$subabTitle}", ['size' => 11]);

            $this->addBab22SubabTables($subabKey, $tableSubabMap, $imageMap, $existingImageMap);

            $closingText = $this->getBab22SubabClosingText($subabKey);
            if (!empty($closingText)) {
                $this->section->addText($closingText, [], [
                    'alignment' => 'both',
                    'indentation' => ['left' => 740],
                    'contextualSpacing' => true,
                ]);
            }

            $subabNumber++;
            $this->section->addTextBreak(1);
        }

        // 2.3 Hasil pemeriksaan sampel per tahapan
        $this->exportBab23($tableSubabMap, $imageMap, $existingImageMap);
    }

    /**
     * Export BAB 2.3: Hasil pemeriksaan sampel per tahapan
     */
    protected function exportBab23(array $tableSubabMap, array $imageMap, array $existingImageMap): void
    {
        // Collect all bab23 table UIDs in submission order
        $bab23TableUids = [];
        foreach ($tableSubabMap as $tableUid => $subabKey) {
            if ((string) $subabKey === 'bab23') {
                $bab23TableUids[] = (string) $tableUid;
            }
        }

        // Check if there's any bab23 content at all
        $hasBab23Content = !empty($bab23TableUids)
            || !empty(trim((string) ($this->data['enkapsulasi_bobot_syarat'] ?? '')))
            || !empty(trim((string) ($this->data['enkapsulasi_batch_list'] ?? '')))
            || !empty(trim((string) ($this->data['bab23_subab_1_title'] ?? '')));

        if (!$hasBab23Content) {
            return;
        }

        // 2.3 heading
        $textRun23 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 670, 'hanging' => 370],
            'spaceAfter' => 60,
        ]);
        $textRun23->addText('2.3', ['bold' => false, 'size' => 11]);
        $textRun23->addText('  Hasil pemeriksaan sampel pada masing-masing tahapan adalah sebagai berikut:', ['size' => 11]);

        // --- 2.3.1 static subab ---
        $this->addBab23SubabHeading('2.3.1', 'Enkapsulasi (Sebelum pengeringan)');

        // 2.3.1.1
        $bobotSyarat = trim((string) ($this->data['enkapsulasi_bobot_syarat'] ?? '500 ± 50 mg'));
        $this->addBab23SubSubabText('2.3.1.1',
            "Hasil enkapsulasi memiliki keseragaman bobot (isi) dengan syarat kualitas {$bobotSyarat}.");

        // 2.3.1.2 — text + tables
        $samplingLokasi = trim((string) ($this->data['enkapsulasi_sampling_lokasi'] ?? '3'));
        $samplingJumlah = trim((string) ($this->data['enkapsulasi_sampling_jumlah'] ?? '20'));
        $this->addBab23SubSubabText('2.3.1.2',
            "Dilakukan sampling pemeriksaan bobot pada {$samplingLokasi} lokasi (awal, tengah, akhir) dengan jumlah {$samplingJumlah} butir soft capsule pada setiap pengambilan sampel, dengan hasil sebagai berikut:");

        // Render table for 2.3.1.2
        foreach ($bab23TableUids as $uid) {
            if (str_starts_with($uid, 'bab23_enkapsulasi')) {
                $this->renderBab23Image($uid, $imageMap, $existingImageMap);
            }
        }

        // 2.3.1.3
        $namaProduk = trim((string) ($this->data['enkapsulasi_nama_produk'] ?? $this->data['tujuan_nama_produk'] ?? 'Konilife Omega 3 Soft Capsule'));
        $batchList  = trim((string) ($this->data['enkapsulasi_batch_list'] ?? $this->data['batch_kode_list'] ?? 'AUG25A01, AUG25A02, dan AUG25A03'));
        $this->addBab23SubSubabText('2.3.1.3',
            "Seluruh hasil pemeriksaan sampel tahap enkapsulasi (sebelum pengeringan) produk {$namaProduk} bets {$batchList} memenuhi spesifikasi produk yang ditetapkan.");

        // Dynamic sub-subabs added to static subab 1 (key: enkapsulasi_sub_*)
        $this->renderDynamicSubSubabs('enkapsulasi', '2.3.1', $bab23TableUids, $imageMap, $existingImageMap, 4);

        // --- Dynamic 2.3.x subabs ---
        $dynSubabIdx = 2;
        $dynCounter = 1;
        while (true) {
            $key = "bab23_subab_dyn_{$dynCounter}";
            $title = trim((string) ($this->data["{$key}_title"] ?? ''));
            if ($title === '' && $dynCounter > 20) {
                break;
            }
            if ($title !== '') {
                $this->addBab23SubabHeading("2.3.{$dynSubabIdx}", $title);

                // Dynamic sub-subabs for this subab
                $this->renderDynamicSubSubabs($key, "2.3.{$dynSubabIdx}", $bab23TableUids, $imageMap, $existingImageMap, 1);

                $dynSubabIdx++;
            }
            $dynCounter++;
            if ($dynCounter > 50) break;
        }

        // Render all dynamic tables (bab23_tbl_*) once at the end
        foreach ($bab23TableUids as $uid) {
            if (str_starts_with($uid, 'bab23_tbl_')) {
                $this->renderBab23Image($uid, $imageMap, $existingImageMap);
            }
        }

        $this->section->addTextBreak(1);
    }

    private function addBab23SubabHeading(string $number, string $title): void
    {
        $textRun = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 740, 'hanging' => 440],
            'spaceAfter' => 60,
        ]);
        $textRun->addText($number, ['bold' => false, 'size' => 11]);
        $textRun->addText("  {$title}", ['size' => 11]);
    }

    private function addBab23SubSubabText(string $number, string $text): void
    {
        $textRun = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 1080, 'hanging' => 580],
            'contextualSpacing' => true,
        ]);
        $textRun->addText($number, ['bold' => false, 'size' => 11]);
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
        }
    }

    private function renderDynamicSubSubabs(string $subabKey, string $parentNum, array $bab23TableUids, array $imageMap, array $existingImageMap, int $startIdx): void
    {
        $ssIdx = $startIdx;
        $ssCounter = 1;
        while (true) {
            $ssKey = "{$subabKey}_sub_{$ssCounter}";
            $ssTitle = trim((string) ($this->data["{$ssKey}_title"] ?? ''));
            $ssText  = trim((string) ($this->data["{$ssKey}_text"] ?? ''));
            if ($ssTitle === '' && $ssText === '' && $ssCounter > 20) {
                break;
            }
            if ($ssTitle !== '' || $ssText !== '') {
                $content = $ssTitle !== '' ? $ssTitle . ($ssText !== '' ? ": {$ssText}" : '') : $ssText;
                $this->addBab23SubSubabText("{$parentNum}.{$ssIdx}", $content);
                $ssIdx++;
            }
            $ssCounter++;
            if ($ssCounter > 100) break;
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

        $fallbackOrder = ['mixing', 'filling_awal', 'filling_capping'];
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
            'filling_awal' => 'Tahap Pengeringan',
            'filling_capping' => 'Tahap Kemas Primer',
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

        return match ($subabKey) {
            'mixing' => 'Seluruh hasil pemeriksaan bobot sampel tahap enkapsulasi (sebelum pengeringan) produk ' .
                $namaProduk . ' bets ' . $batchList . ' sudah memberikan hasil yang ' .
                ($this->data['mixing_hasil'] ?? 'memenuhi') .
                ' spesifikasi produk yang ditetapkan' .
                $this->resolveBab22ClosingTail('mixing_hasil_catatan') . '.',
            'filling_awal' => 'Seluruh hasil pemeriksaan sampel pengeringan produk ' .
                $namaProduk . ' bets ' . $batchList . ' sudah memberikan hasil yang ' .
                ($this->data['filling_awal_hasil'] ?? 'memenuhi') .
                ' spesifikasi produk yang ditetapkan' .
                $this->resolveBab22ClosingTail('filling_awal_hasil_catatan') . '.',
            'filling_capping' => 'Seluruh hasil pemeriksaan sampel tahap kemas primer produk ' .
                $namaProduk . ' bets ' . $batchList . ' sudah memberikan hasil yang ' .
                ($this->data['filling_capping_hasil'] ?? 'memenuhi') .
                ' spesifikasi kemasan yang ditetapkan' .
                $this->resolveBab22ClosingTail('filling_capping_hasil_catatan') . '.',
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
            $textRun->addText("3.{$sectionNumber}", ['bold' => false, 'size' => 11]);
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

        foreach ($tableUids as $index => $tableUid) {
            $imageFile = $imageMap[$tableUid] ?? null;
            $resolvedImagePath = $this->resolveStoredImagePath($existingImageMap[$tableUid] ?? null);

            if ($imageFile instanceof UploadedFile && $imageFile->isValid()) {
                try {
                    $this->section->addImage($imageFile->getPathname(), [
                        'width' => 450,
                        'height' => null,
                        'marginTop' => 10,
                        'marginBottom' => 10,
                        'align' => 'center',
                    ]);
                } catch (\Exception $e) {
                    $this->section->addText("[Error memuat gambar: {$e->getMessage()}]", ['color' => 'FF0000']);
                }
            } elseif ($resolvedImagePath) {
                try {
                    $this->section->addImage($resolvedImagePath, [
                        'width' => 450,
                        'height' => null,
                        'marginTop' => 10,
                        'marginBottom' => 10,
                        'align' => 'center',
                    ]);
                } catch (\Exception $e) {
                    $this->section->addText("[Error memuat gambar draft: {$e->getMessage()}]", ['color' => 'FF0000']);
                }
            } else {
                $this->section->addText("[Gambar tabel tidak tersedia]", ['italic' => true, 'color' => '808080']);
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
            $textRun->addText("4.{$sectionNumber}", ['bold' => false, 'size' => 11]);
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
                    $textRun->addText("4.{$sectionNumber}", ['bold' => false, 'size' => 11]);
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
        $cell1->addText('Validation Officer (1)', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $cell1->addText('Tanggal:', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);

        $cell2 = $footerTable->addCell($col2, [
            'borderSize' => 6,
            'borderRightSize' => 0,
            'valign' => 'bottom'
        ]);
        $cell2->addTextBreak(2);
        $cell2->addText('Validation Manager', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $cell2->addText('Tanggal:', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);

        $cell3 = $footerTable->addCell($col3, [
            'borderSize' => 6,
            'borderLeftSize' => 0,
            'valign' => 'bottom'
        ]);
        $cell3->addTextBreak(2);
        $cell3->addText('QA Manager', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
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