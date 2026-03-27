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
        $namaProduk = strtoupper($this->data['judul_nama_produk'] ?? 'Paramex 500mg');
        $line = strtoupper($this->data['judul_line'] ?? '2');
        $bagian = strtoupper($this->data['judul_bagian'] ?? $this->data['tujuan_bagian'] ?? 'Natpro');

        $formula = $this->data['judul_formula'] ?? '';
        $formulaStr = $formula ? ' (' . strtoupper($formula) . ')' : '';

        $title = "SUMMARY LAPORAN VALIDASI PROSES PEMBUATAN PRODUK {$namaProduk}{$formulaStr} DI LINE {$line} BAGIAN {$bagian}";

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
        $namaProduk = $this->data['tujuan_nama_produk'] ?? 'Paramex 500mg';
        $line = $this->data['judul_line'] ?? '1';
        $bagian = $this->data['tujuan_bagian'] ?? $this->data['judul_bagian'] ?? 'Natpro';
        $mesin = $this->data['tujuan_mesin'] ?? $this->data['kesimpulan_mesin'] ?? 'Mesin Mixer dan Holding Tank Indo Laval 600 L, Mesin Blow and Suck Fillomatic Tornado 8 SA, Mesin Filling-capping Bausch and Stroebel FVF 5060';

        $tujuanText = "Summary validasi ini bertujuan mendokumentasikan hasil studi validasi/pembuktian terhadap kualitas " .
            "dan reprodusibilitas proses pengolahan produk {$namaProduk} di Line {$line} Bagian {$bagian} yang " .
            "diproduksi dengan {$mesin} " .
            "dalam menghasilkan produk {$namaProduk} dalam kemasan botol yang memenuhi persyaratan mutu yang tercantum dalam Spesifikasi Produk " .
            "dan Spesifikasi Kemasan yang berlaku.";

        $textRun111 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 1350, 'hanging' => 610],
            'contextualSpacing' => true,
        ]);
        $textRun111->addText('1.1.1', ['bold' => false, 'size' => 11]);
        $textRun111->addText(' ' . $tujuanText, ['size' => 11]);

        // 1.2 Batch Validasi - only 1.2 is bold
        $textRun12 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 300],
            'contextualSpacing' => true,
        ]);
        $textRun12->addText('1.2', ['bold' => false, 'size' => 11]);
        $textRun12->addText('  Batch Validasi', ['size' => 11]);

        // Build batch text from form data
        $jumlahBatch = $this->data['batch_jumlah'] ?? 'tiga';
        $besaran = $this->data['batch_besaran'] ?? '600 L';
        $jumlahBotol = $this->data['batch_jumlah_botol'] ?? '20.000';
        $volumePerBotol = $this->data['batch_volume_per_botol'] ?? '30 ml';
        $kodeList = $this->data['batch_kode_list'] ?? 'A26A01, A26A02, A26A03';

        $batchText = "Studi validasi dilakukan terhadap {$jumlahBatch} batch produksi dengan besaran batch {$besaran} = {$jumlahBotol} botol @ {$volumePerBotol}, yaitu {$kodeList} :";

        $this->section->addText($batchText, [], [
            'alignment' => 'both',
            'indentation' => ['left' => 740],
            'contextualSpacing' => true,
        ]);

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

        // 2.1 Tujuan
        $textRun21 = $this->section->addTextRun([
            'alignment' => 'both',
            'indentation' => ['left' => 740, 'hanging' => 440],
            'contextualSpacing' => true,
        ]);
        $textRun21->addText('2.1', ['bold' => false, 'size' => 11]);
        $textRun21->addText(' Semua tahap dalam penimbangan bahan baku, mixing, dan filling telah dilakukan sesuai prosedur pengolahan dan pengemasan yang berlaku.', ['size' => 11]);

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
                ($this->data['mixing_hasil'] ?? 'memenuhi') .
                ' persyaratan menurut Spesifikasi Produk yang berlaku' .
                $this->resolveBab22ClosingTail('mixing_hasil_catatan') . '.',
            'filling_awal' => 'Atribut yang diuji pada tahap awal filling-capping sudah memberikan hasil yang ' .
                ($this->data['filling_awal_hasil'] ?? 'memenuhi') .
                ' persyaratan menurut Spesifikasi Produk yang berlaku' .
                $this->resolveBab22ClosingTail('filling_awal_hasil_catatan') . '.',
            'filling_capping' => 'Atribut yang diuji pada tahap filling-capping sudah memberikan hasil yang ' .
                ($this->data['filling_capping_hasil'] ?? 'memenuhi') .
                ' persyaratan menurut Spesifikasi Produk dan Spesifikasi Kemasan yang berlaku' .
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

        // BAB 3 Title
        $this->section->addText('3. KESIMPULAN', ['bold' => true, 'size' => 11], [
            'alignment' => 'both',
            'spaceAfter' => 0,
        ]);

        // Determine which sections are enabled (default: all)
        $enabledStr = $this->data['kesimpulan_enabled_sections'] ?? '1,2,3,4,5';
        $enabledSections = array_map('trim', explode(',', $enabledStr));

        $sectionNumber = 1;

        // Section 1: Produksi
        if (in_array('1', $enabledSections)) {
            $namaProduk = $this->data['kesimpulan_nama_produk'] ?? $this->data['tujuan_nama_produk'] ?? 'Anakonidin OBH 30 ml';
            $batchCodes = $this->data['kesimpulan_batch_codes'] ?? 'A26A01, A26A02, A26A03';
            $text = "Telah dilakukan proses produksi terhadap produk {$namaProduk}, yakni pada batch {$batchCodes} yang digunakan sebagai batch validasi proses.";
            $this->addKesimpulanItem("3.{$sectionNumber}", $text);
            $sectionNumber++;
        }

        // Section 2: Mixing
        if (in_array('2', $enabledSections)) {
            $mixingAtribut = $this->data['kesimpulan_mixing_atribut'] ?? 'bentuk, warna, aroma, pH, identifikasi, kadar zat aktif, kadar pengawet, batas mikroba';
            $mixingHasil = $this->data['kesimpulan_mixing_hasil'] ?? 'memenuhi';
            $text = "Atribut yang diuji pada tahap mixing ({$mixingAtribut}) sudah memberikan hasil yang {$mixingHasil} persyaratan menurut Spesifikasi Produk yang berlaku.";
            $this->addKesimpulanItem("3.{$sectionNumber}", $text);
            $sectionNumber++;
        }

        // Section 3: Awal Filling-Capping
        if (in_array('3', $enabledSections)) {
            $fillingAwalAtribut = $this->data['kesimpulan_fillingawal_atribut'] ?? 'bentuk, warna, aroma, pH, identifikasi, kadar zat aktif, kadar pengawet, batas mikroba';
            $fillingAwalHasil = $this->data['kesimpulan_fillingawal_hasil'] ?? 'memenuhi';
            $text = "Atribut yang diuji pada tahap awal filling-capping ({$fillingAwalAtribut}) sudah memberikan hasil yang {$fillingAwalHasil} persyaratan menurut Spesifikasi Produk yang berlaku.";
            $this->addKesimpulanItem("3.{$sectionNumber}", $text);
            $sectionNumber++;
        }

        // Section 4: Filling-Capping
        if (in_array('4', $enabledSections)) {
            $fillingAtribut = $this->data['kesimpulan_filling_atribut'] ?? 'bentuk, warna, aroma, pH, identifikasi, kadar zat aktif, kadar pengawet, batas mikroba, Batas cemaran Etilen glikol, Batas cemaran Dietilen glikol, Senyawa sejenis 4-aminofenol, kebocoran botol, volume terpindahkan';
            $fillingHasil = $this->data['kesimpulan_filling_hasil'] ?? 'memenuhi';
            $text = "Atribut yang diuji pada tahap filling-capping produk kapsul ke dalam kemasan botol ({$fillingAtribut}) sudah memberikan hasil yang {$fillingHasil} persyaratan menurut Spesifikasi Produk dan Spesifikasi Kemasan yang berlaku.";
            $this->addKesimpulanItem("3.{$sectionNumber}", $text);
            $sectionNumber++;
        }

        // Section 5: Final Conclusion (with italic status)
        if (in_array('5', $enabledSections)) {
            $finalProduk = $this->data['kesimpulan_final_produk'] ?? $this->data['tujuan_nama_produk'] ?? 'Anakonidin OBH 30 ml';
            $status = $this->data['kesimpulan_status'] ?? 'validated';
            $formula = $this->data['kesimpulan_formula'] ?? $this->data['judul_formula'] ?? '';
            $mesin = $this->data['kesimpulan_mesin'] ?? $this->data['tujuan_mesin'] ?? 'Mesin Mixer dan Holding Tank Indo Laval 600 L, Mesin Blow and Suck Fillomatic Tornado 8 SA, Mesin Filling-capping Bausch and Stroebel FVF 5060';
            $tahapProses = $this->data['kesimpulan_tahap_proses'] ?? 'mixing, awal filling-capping, selama filling-capping';
            $formulaText = $formula ? " dengan formula zat aktif {$formula}" : "";

            $text = "Sesuai dengan hasil evaluasi terhadap kesesuaian pelaksanaan di setiap tahap proses produksi, parameter " .
                "proses dan hasil pemeriksaan atribut kualitas produk pada tahap {$tahapProses} yang memenuhi " .
                "persyaratan, maka proses pengolahan dan pengemasan produk {$finalProduk} menggunakan {$mesin}" .
                "{$formulaText} dinyatakan ";

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
                $customNum = substr($sectionId, 1); // e.g. "1" from "c1"
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