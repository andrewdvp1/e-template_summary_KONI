<?php

namespace App\Services\Export;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\ComplexType\TblWidth;
use PhpOffice\PhpWord\IOFactory;

class KonidinOBHExportService
{
    protected PhpWord $phpWord;
    protected Section $section;
    protected array $data;

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

    protected function setupDocument(): void
    {
        $this->phpWord->setDefaultFontName('Helvetica');
        $this->phpWord->setDefaultFontSize(11);

        $this->section = $this->phpWord->addSection([
            'marginTop'      => 850,
            'marginBottom'   => 850,
            'marginLeft'     => 850,
            'marginRight'    => 850,
            'headerHeight'   => 480,
            'borderTopSize'  => 6,
            'borderBottomSize' => 6,
            'borderLeftSize' => 6,
            'borderRightSize' => 6,
        ]);
    }

    protected function addHeader(): void
    {
        $header = $this->section->addHeader();
        $headerTable = $header->addTable([
            'width'      => 10915,
            'unit'       => 'dxa',
            'borderSize' => 6,
            'cellMargin' => 50,
            'indent'     => new TblWidth(-310, 'dxa'),
        ]);

        $col1 = 4100;
        $col2 = 3150;
        $col3 = 3675;

        $headerTable->addRow(350);
        $headerTable->addCell($col1, [
            'borderRightSize' => 0, 'borderRightColor' => 'FFFFFF',
            'borderBottomSize' => 0, 'borderBottomColor' => 'FFFFFF',
        ])->addText(' PT KONIMEX', ['bold' => true, 'italic' => true, 'size' => 14], ['spaceAfter' => 0]);

        $cellHalaman = $headerTable->addCell($col2, [
            'borderLeftSize' => 0, 'borderLeftColor' => 'FFFFFF',
            'borderRightSize' => 0, 'borderRightColor' => 'FFFFFF',
            'borderBottomSize' => 0, 'borderBottomColor' => 'FFFFFF',
        ]);
        $cellHalaman->addPreserveText('Halaman {PAGE} dari {NUMPAGES}', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);

        $headerTable->addCell($col3, ['borderColor' => '000000', 'borderSize' => 6])
            ->addText('Nomor            : AF-00185-01', ['size' => 11], ['alignment' => 'left', 'spaceAfter' => 0]);

        $headerTable->addRow(250);
        $headerTable->addCell($col1 + $col2, [
            'gridSpan' => 2, 'valign' => 'center',
            'borderTopSize' => 0, 'borderTopColor' => 'FFFFFF',
        ])->addText('SUMMARY LAPORAN VALIDASI/ KUALIFIKASI', ['bold' => true, 'size' => 14], ['alignment' => 'center', 'spaceAfter' => 0]);

        $headerTable->addCell($col3, ['valign' => 'center', 'borderTopSize' => 6, 'borderColor' => '000000'])
            ->addText('Tanggal Terbit : 15-03-2024', ['size' => 11], ['spaceAfter' => 0]);
    }

    protected function addDocumentTitle(): void
    {
        $this->section->addTextBreak(1);

        $namaProduk = strtoupper($this->data['judul_nama_produk'] ?? 'KONIDIN OBH');
        $line       = strtoupper($this->data['judul_line'] ?? '5');
        $bagian     = strtoupper($this->data['judul_bagian'] ?? 'Production Pharma II');
        $formula    = $this->data['judul_formula'] ?? '';
        $formulaStr = $formula ? ' (' . strtoupper($formula) . ')' : '';

        $title = "SUMMARY LAPORAN VALIDASI PROSES PEMBUATAN PRODUK {$namaProduk}{$formulaStr} DI LINE {$line} (SACHET) BAGIAN {$bagian}";

        $this->section->addText($title, ['bold' => true, 'size' => 12], ['alignment' => 'center', 'spaceAfter' => 0]);
    }

    protected function addDocumentInfoTable(): void
    {
        $this->section->addTextBreak(1);

        $infoTable = $this->section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80, 'alignment' => 'center']);
        $cp = ['spaceAfter' => 0];

        $infoTable->addRow();
        $infoTable->addCell(2000)->addText('Dokumen No. :', ['size' => 11], $cp);
        $infoTable->addCell(3000)->addText($this->data['dokumen_no'] ?? '-', ['size' => 11], $cp);
        $infoTable->addCell(1500)->addText('Tanggal :', ['size' => 11], $cp);
        $infoTable->addCell(2500)->addText($this->data['dokumen_tanggal'] ?? '-', ['size' => 11], $cp);

        $infoTable->addRow();
        $infoTable->addCell(2000)->addText('Pengganti No. :', ['size' => 11], $cp);
        $infoTable->addCell(3000)->addText($this->data['pengganti_no'] ?? '-', ['size' => 11], $cp);
        $infoTable->addCell(1500)->addText('Tanggal :', ['size' => 11], $cp);
        $infoTable->addCell(2500)->addText($this->data['pengganti_tanggal'] ?? '-', ['size' => 11], $cp);

        $this->section->addTextBreak(1);
    }

    protected function exportBab1(): void
    {
        $this->section->addText('1. PENDAHULUAN', ['bold' => true, 'size' => 12], [
            'alignment' => 'both', 'spaceBefore' => 240, 'contextualSpacing' => true,
        ]);

        $textRun11 = $this->section->addTextRun([
            'alignment' => 'both', 'indentation' => ['left' => 300], 'contextualSpacing' => true,
        ]);
        $textRun11->addText('1.1', ['size' => 11]);
        $textRun11->addText('  Tujuan', ['size' => 11]);

        $namaProduk = $this->data['tujuan_nama_produk'] ?? 'Konidin OBH';
        $line       = $this->data['judul_line'] ?? '5';
        $bagian     = $this->data['tujuan_bagian'] ?? 'Production Pharma II';
        $mesin      = $this->data['tujuan_mesin'] ?? 'Mesin mixer Indolaval Lexamix tanpa Impeller dan Mesin sachetting Klockner';

        $tujuanText = "Summary validasi ini bertujuan mendokumentasikan hasil studi validasi/pembuktian terhadap kualitas " .
            "dan reprodusibilitas proses pengolahan produk {$namaProduk} di Line {$line} (Sachet) Bagian {$bagian} yang " .
            "diproduksi dengan {$mesin} " .
            "dalam menghasilkan produk {$namaProduk} dalam kemasan sachet yang memenuhi persyaratan mutu yang tercantum " .
            "dalam Spesifikasi Produk dan Spesifikasi Kemasan yang berlaku.";

        $textRun111 = $this->section->addTextRun([
            'alignment' => 'both', 'indentation' => ['left' => 1350, 'hanging' => 610], 'contextualSpacing' => true,
        ]);
        $textRun111->addText('1.1.1', ['size' => 11]);
        $textRun111->addText(' ' . $tujuanText, ['size' => 11]);

        $textRun12 = $this->section->addTextRun([
            'alignment' => 'both', 'indentation' => ['left' => 300], 'contextualSpacing' => true,
        ]);
        $textRun12->addText('1.2', ['size' => 11]);
        $textRun12->addText('  Batch Validasi', ['size' => 11]);

        $jumlahBatch = $this->data['batch_jumlah'] ?? 'satu';
        $besaran     = $this->data['batch_besaran'] ?? '200L';
        $kodeList    = $this->data['batch_kode_list'] ?? 'A25A01, A25A02, A25A03';

        $batchText = "Studi validasi dilakukan terhadap {$jumlahBatch} batch produksi dengan besaran batch {$besaran}, yaitu {$kodeList} :";

        $this->section->addText($batchText, [], [
            'alignment' => 'both', 'indentation' => ['left' => 740], 'contextualSpacing' => true,
        ]);

        $this->addBahanAktifTable();
    }

    protected function addBahanAktifTable(): void
    {
        $tableDataJson = $this->data['tabel_bahan_aktif'] ?? '';
        if (empty($tableDataJson)) return;

        $tableData = json_decode($tableDataJson, true);
        if (empty($tableData) || !is_array($tableData)) return;

        $this->section->addTextBreak(1);

        $tableStyle = [
            'borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80,
            'width' => 10200, 'unit' => 'dxa',
        ];
        $hFont = ['bold' => true, 'size' => 11];
        $cFont = ['size' => 11];
        $hPara = ['alignment' => 'center', 'spaceAfter' => 0];
        $cPara = ['alignment' => 'left', 'spaceAfter' => 0];

        $col1 = 3000; $col2 = 2300; $col3 = 3700; $col4 = 1200;

        $table = $this->section->addTable($tableStyle);
        $table->addRow(100);
        $table->addCell($col1)->addText('Bahan Aktif', $hFont, $hPara);
        $table->addCell($col2)->addText('Kode Bahan Baku', $hFont, $hPara);
        $table->addCell($col3)->addText('Nama Supplier', $hFont, $hPara);
        $table->addCell($col4)->addText('Negara', $hFont, $hPara);

        foreach ($tableData as $row) {
            $table->addRow(250);
            $table->addCell($col1)->addText($row[0] ?? '-', $cFont, $cPara);
            $table->addCell($col2)->addText($row[1] ?? '-', $cFont, $cPara);
            $table->addCell($col3)->addText($row[2] ?? '-', $cFont, $cPara);
            $table->addCell($col4)->addText($row[3] ?? '-', $cFont, $hPara);
        }
    }

    protected function exportBab2(): void
    {
        $this->section->addTextBreak(1);

        $this->section->addText('2. RANGKUMAN HASIL', ['bold' => true, 'size' => 11], [
            'alignment' => 'both', 'spaceAfter' => 0,
        ]);

        $textRun21 = $this->section->addTextRun([
            'alignment' => 'both', 'indentation' => ['left' => 740, 'hanging' => 440], 'contextualSpacing' => true,
        ]);
        $textRun21->addText('2.1', ['size' => 11]);
        $textRun21->addText(' Semua tahap dalam penimbangan bahan baku, mixing, dan sachetting telah dilakukan sesuai prosedur pengolahan dan pengemasan yang berlaku.', ['size' => 11]);

        $textRun22 = $this->section->addTextRun([
            'alignment' => 'both', 'indentation' => ['left' => 670, 'hanging' => 370], 'spaceAfter' => 60,
        ]);
        $textRun22->addText('2.2', ['size' => 11]);
        $textRun22->addText('  Hasil pemeriksaan sampel', ['size' => 11]);

        $enabledStr = trim((string) ($this->data['bab22_enabled_subab_keys'] ?? ''));
        $enabledKeys = $enabledStr !== ''
            ? array_values(array_filter(array_map('trim', explode(',', $enabledStr))))
            : ['mixing', 'sachetting_awal', 'sachetting'];

        $tableSubabMap   = is_array($this->data['bab22_table_subab_key'] ?? []) ? ($this->data['bab22_table_subab_key'] ?? []) : [];
        $imageMap        = is_array($this->data['mixing_image_file'] ?? []) ? ($this->data['mixing_image_file'] ?? []) : [];
        $existingImageMap = is_array($this->data['existing_mixing_image_file'] ?? []) ? ($this->data['existing_mixing_image_file'] ?? []) : [];

        $subabNumber = 1;
        foreach ($enabledKeys as $subabKey) {
            $title = $this->getSubabTitle($subabKey);

            $textRun22x = $this->section->addTextRun([
                'alignment' => 'both', 'indentation' => ['left' => 740], 'spaceAfter' => 120,
            ]);
            $textRun22x->addText("2.2.{$subabNumber}", ['size' => 11]);
            $textRun22x->addText(" {$title}", ['size' => 11]);

            $this->addSubabImages($subabKey, $tableSubabMap, $imageMap, $existingImageMap);

            $closing = $this->getSubabClosingText($subabKey);
            if (!empty($closing)) {
                $this->section->addText($closing, [], [
                    'alignment' => 'both', 'indentation' => ['left' => 740], 'contextualSpacing' => true,
                ]);
            }

            $subabNumber++;
            $this->section->addTextBreak(1);
        }
    }

    protected function getSubabTitle(string $key): string
    {
        return match ($key) {
            'mixing'          => 'Mixing',
            'sachetting_awal' => 'Awal Sachetting',
            'sachetting'      => 'Sachetting',
            default           => trim((string) ($this->data["{$key}_title"] ?? 'Subab')),
        };
    }

    protected function getSubabClosingText(string $key): string
    {
        $tail = fn(string $f) => ($t = trim((string) ($this->data[$f] ?? ''))) !== '' ? " {$t}" : '';

        return match ($key) {
            'mixing' => 'Atribut yang diuji pada tahap mixing sudah memberikan hasil yang ' .
                ($this->data['mixing_hasil'] ?? 'memenuhi') .
                ' persyaratan menurut Spesifikasi Produk yang berlaku' .
                $tail('mixing_hasil_catatan') . '.',
            'sachetting_awal' => 'Atribut yang diuji pada tahap awal sachetting sudah memberikan hasil yang ' .
                ($this->data['sachetting_awal_hasil'] ?? 'memenuhi') .
                ' persyaratan menurut Spesifikasi Produk yang berlaku' .
                $tail('sachetting_awal_hasil_catatan') . '.',
            'sachetting' => 'Atribut yang diuji pada tahap sachetting sudah memberikan hasil yang ' .
                ($this->data['sachetting_hasil'] ?? 'memenuhi') .
                ' persyaratan menurut Spesifikasi Produk dan Spesifikasi Kemasan yang berlaku' .
                $tail('sachetting_hasil_catatan') . '.',
            default => trim((string) ($this->data["{$key}_notes"] ?? '')),
        };
    }

    protected function addSubabImages(string $subabKey, array $tableSubabMap, array $imageMap, array $existingImageMap): void
    {
        $tableUids = [];
        foreach ($tableSubabMap as $uid => $mappedKey) {
            if ((string) $mappedKey === $subabKey) {
                $tableUids[] = (string) $uid;
            }
        }

        if (empty($tableUids)) return;

        foreach ($tableUids as $uid) {
            $imageFile = $imageMap[$uid] ?? null;
            $resolvedPath = null;

            if (!empty($existingImageMap[$uid])) {
                $p = $existingImageMap[$uid];
                if (Storage::disk('public')->exists($p)) {
                    $resolvedPath = Storage::disk('public')->path($p);
                }
            }

            if ($imageFile instanceof UploadedFile && $imageFile->isValid()) {
                try {
                    $this->section->addImage($imageFile->getPathname(), [
                        'width' => 450, 'height' => null,
                        'marginTop' => 10, 'marginBottom' => 10, 'align' => 'center',
                    ]);
                } catch (\Exception $e) {
                    $this->section->addText("[Error memuat gambar: {$e->getMessage()}]", ['color' => 'FF0000']);
                }
            } elseif ($resolvedPath) {
                try {
                    $this->section->addImage($resolvedPath, [
                        'width' => 450, 'height' => null,
                        'marginTop' => 10, 'marginBottom' => 10, 'align' => 'center',
                    ]);
                } catch (\Exception $e) {
                    $this->section->addText("[Error memuat gambar draft: {$e->getMessage()}]", ['color' => 'FF0000']);
                }
            } else {
                $this->section->addText('[Gambar tabel tidak tersedia]', ['italic' => true, 'color' => '808080']);
            }
        }
    }

    protected function exportBab3(): void
    {
        $this->section->addTextBreak(1);

        $this->section->addText('3. KESIMPULAN', ['bold' => true, 'size' => 11], [
            'alignment' => 'both', 'spaceAfter' => 0,
        ]);

        $enabledStr = $this->data['kesimpulan_enabled_sections'] ?? '1,2,3,4,5';
        $enabled    = array_map('trim', explode(',', $enabledStr));
        $n          = 1;

        if (in_array('1', $enabled)) {
            $namaProduk = $this->data['kesimpulan_nama_produk'] ?? $this->data['tujuan_nama_produk'] ?? 'Konidin OBH';
            $batchCodes = $this->data['kesimpulan_batch_codes'] ?? 'A25A01, A25A02, A25A03';
            $this->addKesimpulanItem("3.{$n}", "Telah dilakukan proses produksi terhadap produk {$namaProduk}, yakni pada batch {$batchCodes} yang digunakan sebagai batch validasi proses.");
            $n++;
        }

        if (in_array('2', $enabled)) {
            $atribut = $this->data['kesimpulan_mixing_atribut'] ?? 'bentuk, warna, aroma, pH, kadar zat aktif dan kadar pengawet';
            $hasil   = $this->data['kesimpulan_mixing_hasil'] ?? 'memenuhi';
            $this->addKesimpulanItem("3.{$n}", "Atribut yang diuji pada tahap mixing ({$atribut}) memberikan hasil yang {$hasil} persyaratan menurut Spesifikasi Produk yang berlaku.");
            $n++;
        }

        if (in_array('3', $enabled)) {
            $atribut = $this->data['kesimpulan_sachettingawal_atribut'] ?? 'kadar zat aktif dan kadar pengawet';
            $hasil   = $this->data['kesimpulan_sachettingawal_hasil'] ?? 'memenuhi';
            $this->addKesimpulanItem("3.{$n}", "Atribut yang diuji pada tahap awal sachetting produk suspensi ke dalam kemasan sachet ({$atribut}) memberikan hasil yang {$hasil} persyaratan menurut Spesifikasi Produk yang berlaku.");
            $n++;
        }

        if (in_array('4', $enabled)) {
            $atribut = $this->data['kesimpulan_sachetting_atribut'] ?? 'bentuk, warna, aroma, pH, kadar zat aktif, kadar pengawet, batas mikroba, volume terpindahkan, kebocoran sachet';
            $hasil   = $this->data['kesimpulan_sachetting_hasil'] ?? 'memenuhi';
            $this->addKesimpulanItem("3.{$n}", "Atribut yang diuji pada tahap sachetting produk suspensi ke dalam kemasan sachet ({$atribut}) memberikan hasil yang {$hasil} persyaratan menurut Spesifikasi Produk dan Spesifikasi Kemasan yang berlaku.");
            $n++;
        }

        if (in_array('5', $enabled)) {
            $finalProduk = $this->data['kesimpulan_final_produk'] ?? $this->data['tujuan_nama_produk'] ?? 'Konidin OBH';
            $status      = $this->data['kesimpulan_status'] ?? 'validated';
            $mesin       = $this->data['kesimpulan_mesin'] ?? $this->data['tujuan_mesin'] ?? 'mesin mixer Indolaval Lexamix tanpa impeller dan mesin sachetting Klockner';
            $tahap       = $this->data['kesimpulan_tahap_proses'] ?? 'mixing, awal sachetting dan sachetting';

            $text = "Sesuai dengan hasil evaluasi terhadap kesesuaian pelaksanaan di setiap tahap proses produksi, parameter " .
                "proses dan hasil pemeriksaan atribut kualitas produk pada tahap {$tahap} yang memenuhi " .
                "persyaratan, maka proses pengolahan dan pengemasan produk {$finalProduk} menggunakan {$mesin} dinyatakan ";

            $textRun = $this->section->addTextRun([
                'alignment' => 'both', 'indentation' => ['left' => 740, 'hanging' => 440], 'contextualSpacing' => true,
            ]);
            $textRun->addText("3.{$n}", ['size' => 11]);
            $textRun->addText(' ' . $text, ['size' => 11]);
            $textRun->addText($status, ['italic' => true, 'size' => 11]);
            $textRun->addText('.', ['size' => 11]);
            $n++;
        }

        // Custom sections
        foreach ($enabled as $sectionId) {
            if (str_starts_with($sectionId, 'c')) {
                $num = substr($sectionId, 1);
                $customText = trim((string) ($this->data["kesimpulan_custom_{$num}"] ?? ''));
                if (!empty($customText)) {
                    $this->addKesimpulanItem("3.{$n}", $customText);
                    $n++;
                }
            }
        }
    }

    protected function addKesimpulanItem(string $number, string $text): void
    {
        $textRun = $this->section->addTextRun([
            'alignment' => 'both', 'indentation' => ['left' => 740, 'hanging' => 440], 'contextualSpacing' => true,
        ]);
        $textRun->addText($number, ['size' => 11]);
        $textRun->addText(' ' . $text, ['size' => 11]);
    }

    protected function addFooter(): void
    {
        $footer = $this->section->addFooter();

        $col = 2729;
        $footerTable = $footer->addTable([
            'width' => 10915, 'unit' => 'dxa',
            'borderSize' => 6, 'borderColor' => '000000',
            'cellMargin' => 50, 'indent' => new TblWidth(-310, 'dxa'),
        ]);

        $footerTable->addRow(0, ['exactHeight' => true]);
        $footerTable->addCell($col, ['borderSize' => 6, 'valign' => 'center'])
            ->addText('Dibuat oleh', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $footerTable->addCell($col * 2, ['gridSpan' => 2, 'borderSize' => 6, 'valign' => 'center'])
            ->addText('Diperiksa oleh', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $footerTable->addCell($col, ['borderSize' => 6, 'valign' => 'center'])
            ->addText('Disetujui oleh', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);

        $footerTable->addRow(650);

        $roles = [
            ['Validation Officer (2)', false, false],
            ['Validation Manager', true, false],
            ['QA Manager', false, true],
            ['Quality Div. Manager', false, false],
        ];

        foreach ($roles as [$role, $noBorderRight, $noBorderLeft]) {
            $cellStyle = ['borderSize' => 6, 'valign' => 'bottom'];
            if ($noBorderRight) $cellStyle['borderRightSize'] = 0;
            if ($noBorderLeft)  $cellStyle['borderLeftSize']  = 0;

            $cell = $footerTable->addCell($col, $cellStyle);
            $cell->addTextBreak(2);
            $cell->addText('__________', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
            $cell->addText($role, ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
            $cell->addText('Tanggal:', ['size' => 11], ['alignment' => 'left', 'spaceAfter' => 0]);
        }
    }

    protected function saveAndDownload()
    {
        $namaProduk = $this->data['judul_nama_produk'] ?? 'Konidin_OBH';
        $fileName   = 'Summary_Validasi_' . str_replace(' ', '_', $namaProduk) . '_' . date('Y-m-d') . '.docx';

        $tempFile  = tempnam(sys_get_temp_dir(), 'PHPWord');
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
