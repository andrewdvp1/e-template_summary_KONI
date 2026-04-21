<?php

namespace App\Services\Export;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\ComplexType\TblWidth;
use PhpOffice\PhpWord\IOFactory;

class NutracareExportService
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
        $this->exportBab4();
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

        $col1 = 4100; $col2 = 3150; $col3 = 3675;

        $headerTable->addRow(350);
        $headerTable->addCell($col1, ['borderRightSize' => 0, 'borderRightColor' => 'FFFFFF', 'borderBottomSize' => 0, 'borderBottomColor' => 'FFFFFF'])
            ->addText(' PT KONIMEX', ['bold' => true, 'italic' => true, 'size' => 14], ['spaceAfter' => 0]);
        $headerTable->addCell($col2, ['borderLeftSize' => 0, 'borderLeftColor' => 'FFFFFF', 'borderRightSize' => 0, 'borderRightColor' => 'FFFFFF', 'borderBottomSize' => 0, 'borderBottomColor' => 'FFFFFF'])
            ->addPreserveText('Halaman {PAGE} dari {NUMPAGES}', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $headerTable->addCell($col3, ['borderColor' => '000000', 'borderSize' => 6])
            ->addText('Nomor            : AF-00185-01', ['size' => 11], ['alignment' => 'left', 'spaceAfter' => 0]);

        $headerTable->addRow(250);
        $headerTable->addCell($col1 + $col2, ['gridSpan' => 2, 'valign' => 'center', 'borderTopSize' => 0, 'borderTopColor' => 'FFFFFF'])
            ->addText('SUMMARY LAPORAN VALIDASI/ KUALIFIKASI', ['bold' => true, 'size' => 14], ['alignment' => 'center', 'spaceAfter' => 0]);
        $headerTable->addCell($col3, ['valign' => 'center', 'borderTopSize' => 6, 'borderColor' => '000000'])
            ->addText('Tanggal Terbit : 15-03-2024', ['size' => 11], ['spaceAfter' => 0]);
    }

    protected function addDocumentTitle(): void
    {
        $this->section->addTextBreak(1);

        $namaProduk = strtoupper($this->data['judul_nama_produk'] ?? 'NUTRACARE EPO 500 SOFT CAPSULE');
        $this->section->addText(
            "SUMMARY LAPORAN VALIDASI PROSES PEMBUATAN PRODUK {$namaProduk}",
            ['bold' => true, 'size' => 12],
            ['alignment' => 'center', 'spaceAfter' => 0]
        );
    }

    protected function addDocumentInfoTable(): void
    {
        $this->section->addTextBreak(1);
        $p = ['spaceAfter' => 0];
        $t = $this->section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80, 'alignment' => 'center']);

        $t->addRow();
        $t->addCell(2000)->addText('Dokumen No. :', ['size' => 11], $p);
        $t->addCell(3000)->addText($this->data['dokumen_no'] ?? '-', ['size' => 11], $p);
        $t->addCell(1500)->addText('Tanggal :', ['size' => 11], $p);
        $t->addCell(2500)->addText($this->data['dokumen_tanggal'] ?? '-', ['size' => 11], $p);

        $t->addRow();
        $t->addCell(2000)->addText('Pengganti No. :', ['size' => 11], $p);
        $t->addCell(3000)->addText($this->data['pengganti_no'] ?? '-', ['size' => 11], $p);
        $t->addCell(1500)->addText('Tanggal :', ['size' => 11], $p);
        $t->addCell(2500)->addText($this->data['pengganti_tanggal'] ?? '-', ['size' => 11], $p);

        $this->section->addTextBreak(1);
    }

    // ─── BAB 1 ───────────────────────────────────────────────────────────────

    protected function exportBab1(): void
    {
        $this->section->addText('1. PENDAHULUAN', ['bold' => true, 'size' => 11], ['alignment' => 'both', 'spaceBefore' => 0, 'spaceAfter' => 0]);

        // 1.1 Tujuan
        $tr11 = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 440, 'hanging' => 440], 'spaceAfter' => 0]);
        $tr11->addText('1.1.', ['size' => 11]);
        $tr11->addText('  Tujuan', ['bold' => true, 'size' => 11]);

        $namaProduk = $this->data['tujuan_nama_produk'] ?? $this->data['judul_nama_produk'] ?? 'Nutracare EPO 500 Soft Capsule';
        $besarBets  = $this->data['tujuan_besar_bets'] ?? '30,015 Kg';
        $bagian     = $this->data['tujuan_bagian'] ?? 'Production Farmasi I Line Soft Capsule Gedung A';

        $tujuanText = "Summary laporan validasi ini bertujuan mendokumentasikan hasil studi validasi/pembuktian terhadap kualitas proses pengolahan produk {$namaProduk} dengan besar bets {$besarBets}, di bagian {$bagian}, dalam menghasilkan produk yang memenuhi persyaratan mutu internal Konimex, pemerintah dan persyaratan kapabilitas proses yang sudah ditentukan secara konsisten.";

        $this->section->addText($tujuanText, ['size' => 11], ['alignment' => 'both', 'indentation' => ['left' => 440], 'spaceAfter' => 0]);

        // 1.2 Batch Validasi
        $tr12 = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 440, 'hanging' => 440], 'spaceAfter' => 0]);
        $tr12->addText('1.2.', ['size' => 11]);
        $tr12->addText('  Batch Validasi', ['bold' => true, 'size' => 11]);

        $jumlah     = $this->data['batch_jumlah'] ?? '2';
        $kodeList   = $this->data['batch_kode_list'] ?? 'JAN26A01 dan JAN26A02';
        $besaran    = $this->data['batch_besaran'] ?? '30,015 Kg';
        $jumlahKap  = $this->data['batch_jumlah_kapsul'] ?? '60.000';
        $bobotIsi   = $this->data['batch_bobot_isi'] ?? '500,25 mg';

        $batchText = "Studi validasi dilakukan terhadap {$jumlah} bets produksi yaitu batch {$kodeList}, dengan besaran batch {$besaran} = {$jumlahKap} Soft Capsule @ {$bobotIsi} (bobot isi).";
        $this->section->addText($batchText, ['size' => 11], ['alignment' => 'both', 'indentation' => ['left' => 440], 'spaceAfter' => 0]);

        $this->addBahanAktifTable();
    }

    protected function addBahanAktifTable(): void
    {
        $json = $this->data['tabel_bahan_aktif'] ?? '';
        if (empty($json)) return;
        $rows = json_decode($json, true);
        if (empty($rows) || !is_array($rows)) return;

        $this->section->addTextBreak(1);
        $p = ['spaceAfter' => 0];
        $hf = ['bold' => true, 'size' => 11];
        $cf = ['size' => 11];
        $hp = ['alignment' => 'center', 'spaceAfter' => 0];
        $cp = ['alignment' => 'left', 'spaceAfter' => 0];

        $t = $this->section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80, 'width' => 10200, 'unit' => 'dxa']);
        $t->addRow(100);
        $t->addCell(3000, ['valign' => 'center'])->addText('Bahan aktif', $hf, $hp);
        $t->addCell(2300, ['valign' => 'center'])->addText('Kode Bahan Baku', $hf, $hp);
        $t->addCell(3700, ['valign' => 'center'])->addText('Nama Supplier', $hf, $hp);
        $t->addCell(1200, ['valign' => 'center'])->addText('Negara', $hf, $hp);

        foreach ($rows as $row) {
            $t->addRow(250);
            $t->addCell(3000)->addText($row[0] ?? '-', $cf, $cp);
            $t->addCell(2300)->addText($row[1] ?? '-', $cf, $cp);
            $t->addCell(3700)->addText($row[2] ?? '-', $cf, $cp);
            $t->addCell(1200)->addText($row[3] ?? '-', $cf, $hp);
        }
    }

    // ─── BAB 2 ───────────────────────────────────────────────────────────────

    protected function exportBab2(): void
    {
        $this->section->addTextBreak(1);
        $this->section->addText('2. HASIL DAN EVALUASI VALIDASI PROSES', ['bold' => true, 'size' => 11], ['alignment' => 'both', 'spaceAfter' => 0]);

        $tableSubabMap    = is_array($this->data['bab22_table_subab_key'] ?? null)    ? $this->data['bab22_table_subab_key']    : [];
        $imageMap         = is_array($this->data['mixing_image_file'] ?? null)         ? $this->data['mixing_image_file']         : [];
        $existingImageMap = is_array($this->data['existing_mixing_image_file'] ?? null) ? $this->data['existing_mixing_image_file'] : [];

        // 2.1 Pelaksanaan Proses Produksi
        $tr21 = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 440, 'hanging' => 440], 'spaceAfter' => 0]);
        $tr21->addText('2.1.', ['size' => 11]);
        $tr21->addText('  Pelaksanaan Proses Produksi:', ['size' => 11]);
        $this->renderTablesBySubabKey('tbl_pelaksanaan', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.2 Seluruh tahapan
        $tr22 = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 440, 'hanging' => 440], 'spaceAfter' => 0]);
        $tr22->addText('2.2.', ['size' => 11]);
        $tr22->addText('  Seluruh tahapan pengolahan dan pengemasan primer telah dilakukan sesuai dengan prosedur pengolahan dan pengemasan yang berlaku.', ['size' => 11]);

        // 2.3 Hasil pemeriksaan sampel
        $tr23 = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 440, 'hanging' => 440], 'spaceAfter' => 0]);
        $tr23->addText('2.3.', ['size' => 11]);
        $tr23->addText('  Hasil pemeriksaan sampel pada masing-masing tahapan adalah sebagai berikut:', ['size' => 11]);

        $this->exportBab23($tableSubabMap, $imageMap, $existingImageMap);
    }

    protected function exportBab23(array $tableSubabMap, array $imageMap, array $existingImageMap): void
    {
        // ── 2.3.1 Enkapsulasi ──
        $this->addSubabHeading('2.3.1.', 'Enkapsulasi (Sebelum pengeringan)');

        $bobotSyarat = trim((string)($this->data['enkapsulasi_bobot_syarat'] ?? ''));
        $this->addSubSubabText('2.3.1.1.', "Hasil enkapsulasi memiliki keseragaman bobot (isi) dengan syarat kualitas {$bobotSyarat}.");

        $lokasi  = $this->data['enkapsulasi_sampling_lokasi'] ?? '3';
        $jumlah  = $this->data['enkapsulasi_sampling_jumlah'] ?? '20';
        $this->addSubSubabText('2.3.1.2.', "Dilakukan sampling pada {$lokasi} lokasi (awal, tengah, akhir) dengan jumlah {$jumlah} butir soft capsule pada setiap pengambilan sampel, dengan hasil sebagai berikut:");
        $this->renderTablesBySubabKey('tbl_enkapsulasi_212', $tableSubabMap, $imageMap, $existingImageMap);

        $enkNama  = $this->data['enkapsulasi_nama_produk'] ?? $this->data['judul_nama_produk'] ?? '';
        $enkBets  = $this->data['enkapsulasi_besar_bets'] ?? $this->data['batch_besaran'] ?? '';
        $enkBatch = $this->data['enkapsulasi_batch_list'] ?? $this->data['batch_kode_list'] ?? '';
        $this->addSubSubabText('2.3.1.3.', "Seluruh hasil pemeriksaan sampel tahap enkapsulasi (sebelum pengeringan) produk {$enkNama} dengan besar bets {$enkBets}, bets {$enkBatch} memenuhi spesifikasi produk yang ditetapkan.");

        // ── 2.3.2 Pengeringan ──
        $this->addSubabHeading('2.3.2.', 'Tahap Pengeringan');

        $spesNama   = $this->data['pengeringan_spesifikasi_no'] ?? '';
        $spesNo     = $this->data['pengeringan_spesifikasi_tanggal'] ?? '';
        $spesTgl    = $this->data['pengeringan_spesifikasi_tanggal'] ?? '';
        $this->addSubSubabText('2.3.2.1.', "Syarat kualitas produk setelah tahap pengeringan memiliki syarat mutu sesuai Spesifikasi Produk {$spesNama} no {$spesNo} tanggal {$spesTgl}, sebagai berikut:");
        $this->renderTablesBySubabKey('tbl_spesifikasi_pengeringan', $tableSubabMap, $imageMap, $existingImageMap);

        $jumlahTray   = $this->data['pengeringan_jumlah_tray'] ?? '10';
        $samplingTray = $this->data['pengeringan_sampling_per_tray'] ?? '30';
        $this->addSubSubabText('2.3.2.2.', "Hasil enkapsulasi setelah tahap pengeringan, berupa soft capsule yang telah dikeringkan pada tumbler dryer, secara urut ditampung dalam tray-tray dan dikeringkan di ruang pengering, sehingga menjadi soft capsule kering. Tray dibagi menjadi {$jumlahTray} kelompok dan dilakukan sampling sebanyak {$samplingTray} soft capsule per kelompok untuk semua pemeriksaan atribut di atas, dengan kondisi aktual pengeringan sebagai berikut:");
        $this->renderTablesBySubabKey('tbl_kondisi_pengeringan', $tableSubabMap, $imageMap, $existingImageMap);

        $this->addSubSubabText('2.3.2.3.', 'Hasil pemeriksaan sampel untuk pemeriksaan atribut sebagai berikut:');

        $this->addSubSubabText('2.3.2.3.1', 'Pemeriksaan keseragaman bobot');
        $this->renderTablesBySubabKey('tbl_keseragaman_bobot', $tableSubabMap, $imageMap, $existingImageMap);

        $this->addSubSubabText('2.3.2.3.2', 'Pemeriksaan Fisik');
        $this->renderTablesBySubabKey('tbl_pemeriksaan_fisik', $tableSubabMap, $imageMap, $existingImageMap);

        $this->addSubSubabText('2.3.2.3.3', 'Pemeriksaan Identifikasi Fatty Acid Profile, positif teridentifikasi asam lemak dengan komposisi:');
        $this->renderTablesBySubabKey('tbl_fatty_acid', $tableSubabMap, $imageMap, $existingImageMap);

        $this->addSubSubabText('2.3.2.3.4', 'Pemeriksaan Aflatoksin Total');
        $this->renderTablesBySubabKey('tbl_aflatoksin', $tableSubabMap, $imageMap, $existingImageMap);

        $this->addSubSubabText('2.3.2.3.5', 'Pemeriksaan Cemaran Logam Berat');
        $this->renderTablesBySubabKey('tbl_logam_berat', $tableSubabMap, $imageMap, $existingImageMap);

        $this->addSubSubabText('2.3.2.3.6', 'Pemeriksaan Mikrobiologi');
        $this->renderTablesBySubabKey('tbl_mikrobiologi', $tableSubabMap, $imageMap, $existingImageMap);

        $pngNama  = $this->data['pengeringan_nama_produk'] ?? $this->data['judul_nama_produk'] ?? '';
        $pngBets  = $this->data['pengeringan_besar_bets'] ?? $this->data['batch_besaran'] ?? '';
        $pngBatch = $this->data['pengeringan_batch_list'] ?? $this->data['batch_kode_list'] ?? '';
        $this->addSubSubabText('2.3.2.4.', "Seluruh hasil pemeriksaan sampel pengeringan produk {$pngNama} dengan besar bets {$pngBets}, bets {$pngBatch} memenuhi spesifikasi produk yang ditetapkan.");

        // ── 2.3.3 Kemas Primer ──
        $this->addSubabHeading('2.3.3.', 'Tahap Kemas Primer');

        $kemNama   = $this->data['kemasan_nama_produk'] ?? $this->data['judul_nama_produk'] ?? '';
        $kemSpesNo = $this->data['kemasan_spesifikasi_no'] ?? '';
        $kemSpesNomor = $this->data['kemasan_spesifikasi_tanggal'] ?? '';
        $kemSpesTgl   = $this->data['kemasan_spesifikasi_tanggal'] ?? '';
        $this->addSubSubabText('2.3.3.1.', "Spesifikasi kemasan {$kemNama} untuk kemasan botol mengacu Spesifikasi Kemasan {$kemSpesNo} no {$kemSpesNomor} tanggal {$kemSpesTgl}, sebagai berikut:");
        $this->renderTablesBySubabKey('tbl_spesifikasi_kemasan', $tableSubabMap, $imageMap, $existingImageMap);

        $kemLokasi = $this->data['kemasan_sampling_lokasi'] ?? '10';
        $kemJumlah = $this->data['kemasan_sampling_jumlah'] ?? '1';
        $this->addSubSubabText('2.3.3.2.', "Sampling dilakukan pada {$kemLokasi} lokasi untuk 1 bets. Sampel diambil sebanyak {$kemJumlah} botol tiap kali sampling. Kemudian dilakukan pengujian dengan pengecekan jumlah soft capsule dan desipack per botol dan pemeriksaan elegansi dan kondisi aluseal.");

        $this->addSubSubabText('2.3.3.3.', 'Hasil pemeriksaan sampel sebagai berikut:');
        $this->renderTablesBySubabKey('tbl_hasil_kemasan', $tableSubabMap, $imageMap, $existingImageMap);

        $kemNama2  = $this->data['kemasan_nama_produk_2'] ?? $this->data['judul_nama_produk'] ?? '';
        $kemBets   = $this->data['kemasan_besar_bets'] ?? $this->data['batch_besaran'] ?? '';
        $kemBatch  = $this->data['kemasan_batch_list'] ?? $this->data['batch_kode_list'] ?? '';
        $this->addSubSubabText('2.3.3.4.', "Seluruh hasil pemeriksaan sampel tahap kemas primer {$kemNama2} dengan besar bets {$kemBets}, bets {$kemBatch} telah memenuhi spesifikasi yang ditetapkan.");

        // ── Dynamic 2.3.x subabs ──
        $dynIdx = 4;
        for ($i = 1; $i <= 50; $i++) {
            $key   = "bab23_subab_dyn_{$i}";
            $title = trim((string)($this->data["{$key}_title"] ?? ''));
            if ($title === '' && $i > 20) break;
            if ($title === '') continue;

            $this->addSubabHeading("2.3.{$dynIdx}.", $title);

            // sub-subabs
            for ($j = 1; $j <= 100; $j++) {
                $ssKey   = "{$key}_sub_{$j}";
                $ssTitle = trim((string)($this->data["{$ssKey}_title"] ?? ''));
                $ssText  = trim((string)($this->data["{$ssKey}_text"] ?? ''));
                if ($ssTitle === '' && $ssText === '' && $j > 20) break;
                if ($ssTitle !== '' || $ssText !== '') {
                    $content = $ssTitle !== '' ? $ssTitle . ($ssText !== '' ? ": {$ssText}" : '') : $ssText;
                    $this->addSubSubabText("2.3.{$dynIdx}.{$j}", $content);
                }
            }
            $dynIdx++;
        }
    }

    // ─── BAB 3 ───────────────────────────────────────────────────────────────

    protected function exportBab3(): void
    {
        $this->section->addTextBreak(1);
        $this->section->addText('3. KESIMPULAN', ['bold' => true, 'size' => 11], ['alignment' => 'both', 'spaceAfter' => 0]);

        $enabledStr = $this->data['kesimpulan_enabled_sections'] ?? '1,2';
        $enabled    = array_map('trim', explode(',', $enabledStr));
        $num = 1;

        if (in_array('1', $enabled)) {
            $nama  = $this->data['kesimpulan_nama_produk'] ?? $this->data['judul_nama_produk'] ?? '';
            $batch = $this->data['kesimpulan_batch_codes'] ?? $this->data['batch_kode_list'] ?? '';
            $this->addKesimpulanItem("3.{$num}", "Telah dilakukan proses produksi terhadap produk {$nama}, bets {$batch} yang digunakan sebagai batch validasi proses.");
            $num++;
        }

        if (in_array('2', $enabled)) {
            $jumlahBets = $this->data['kesimpulan_jumlah_bets'] ?? '2';
            $nama2      = $this->data['kesimpulan_nama_produk_2'] ?? $this->data['judul_nama_produk'] ?? '';
            $nama3      = $this->data['kesimpulan_nama_produk_3'] ?? $this->data['judul_nama_produk'] ?? '';
            $status     = $this->data['kesimpulan_status'] ?? 'validated';

            $textRun = $this->section->addTextRun([
                'alignment'   => 'both',
                'indentation' => ['left' => 440, 'hanging' => 440],
                'spaceAfter'  => 0,
            ]);
            $textRun->addText("3.{$num}", ['size' => 11]);
            $textRun->addText("  Proses terbukti pada {$jumlahBets} bets pemeriksaan, dapat menghasilkan produk jadi {$nama2} yang memenuhi spesifikasi dalam Spesifikasi Produk dan Spesifikasi Kemasan {$nama3} sehingga dinyatakan ", ['size' => 11]);
            $textRun->addText($status, ['italic' => true, 'size' => 11]);
            $textRun->addText('.', ['size' => 11]);
            $num++;
        }

        // Custom sections
        foreach ($enabled as $sectionId) {
            if (!str_starts_with($sectionId, 'c')) continue;
            $customNum  = substr($sectionId, 1);
            $customText = trim((string)($this->data["kesimpulan_custom_{$customNum}"] ?? ''));
            if ($customText !== '') {
                $this->addKesimpulanItem("3.{$num}", $customText);
                $num++;
            }
        }
    }

    protected function addKesimpulanItem(string $number, string $text): void
    {
        $textRun = $this->section->addTextRun([
            'alignment'   => 'both',
            'indentation' => ['left' => 440, 'hanging' => 440],
            'spaceAfter'  => 0,
        ]);
        $textRun->addText($number, ['size' => 11]);
        $textRun->addText('  ' . $text, ['size' => 11]);
    }

    // ─── BAB 4 ───────────────────────────────────────────────────────────────

    protected function exportBab4(): void
    {
        $this->section->addTextBreak(1);
        $this->section->addText('4. SARAN', ['bold' => true, 'size' => 11], ['alignment' => 'both', 'spaceAfter' => 0]);

        $namaProduk = $this->data['saran_nama_produk'] ?? $this->data['judul_nama_produk'] ?? $this->data['tujuan_nama_produk'] ?? 'produk';
        $saranText  = "Apabila dikemudian hari dilakukan perubahan pada proses produksi produk {$namaProduk}, maka perubahan tersebut harus diberitahukan ke pihak-pihak terkait dengan mekanisme sesuai pedoman pengendalian perubahan yang berlaku.";

        $textRun = $this->section->addTextRun([
            'alignment'   => 'both',
            'indentation' => ['left' => 440, 'hanging' => 440],
            'spaceAfter'  => 0,
        ]);
        $textRun->addText('4.1', ['size' => 11]);
        $textRun->addText('  ' . $saranText, ['size' => 11]);
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    private function addSubabHeading(string $number, string $title): void
    {
        $tr = $this->section->addTextRun([
            'alignment'   => 'both',
            'indentation' => ['left' => 880, 'hanging' => 440],
            'spaceAfter'  => 0,
        ]);
        $tr->addText($number, ['size' => 11]);
        $tr->addText('  ' . $title, ['bold' => true, 'size' => 11]);
    }

    private function addSubSubabText(string $number, string $text): void
    {
        $tr = $this->section->addTextRun([
            'alignment'   => 'both',
            'indentation' => ['left' => 1320, 'hanging' => 660],
            'spaceAfter'  => 0,
        ]);
        $tr->addText($number, ['size' => 11]);
        $tr->addText('  ' . $text, ['size' => 11]);
    }

    /**
     * Render image/table for a given table UID (by uid key in tableSubabMap or direct uid match).
     */
    private function renderTablesBySubabKey(string $uid, array $tableSubabMap, array $imageMap, array $existingImageMap): void
    {
        // Direct UID match (static tables like tbl_pelaksanaan)
        $this->renderImage($uid, $imageMap, $existingImageMap);
    }

    private function renderImage(string $uid, array $imageMap, array $existingImageMap): void
    {
        $imageFile    = $imageMap[$uid] ?? null;
        $base64       = trim((string)($this->data['mixing_image_base64'][$uid] ?? $this->data["mixing_image_base64[{$uid}]"] ?? ''));
        $resolvedPath = $this->resolveStoredImagePath($existingImageMap[$uid] ?? null);

        // Also check pasted table JSON
        $pastedJson = trim((string)($this->data['mixing_pasted_table_json'][$uid] ?? $this->data["mixing_pasted_table_json[{$uid}]"] ?? ''));

        if ($imageFile instanceof UploadedFile && $imageFile->isValid()) {
            try {
                $this->section->addImage($imageFile->getPathname(), ['width' => 450, 'align' => 'center']);
            } catch (\Exception $e) {
                $this->section->addText("[Error gambar]", ['color' => 'FF0000']);
            }
        } elseif ($resolvedPath) {
            try {
                $this->section->addImage($resolvedPath, ['width' => 450, 'align' => 'center']);
            } catch (\Exception $e) {
                $this->section->addText("[Error gambar draft]", ['color' => 'FF0000']);
            }
        } elseif ($base64 !== '' && str_starts_with($base64, 'data:image')) {
            try {
                $imageData = base64_decode(substr($base64, strpos($base64, ',') + 1));
                $tmp = tempnam(sys_get_temp_dir(), 'nutraimg');
                file_put_contents($tmp, $imageData);
                $this->section->addImage($tmp, ['width' => 450, 'align' => 'center']);
                @unlink($tmp);
            } catch (\Exception $e) {
                $this->section->addText("[Error gambar base64]", ['color' => 'FF0000']);
            }
        } elseif ($pastedJson !== '') {
            $rows = json_decode($pastedJson, true);
            if (is_array($rows) && !empty($rows)) {
                $this->renderPastedTable($rows);
            }
        } else {
            $this->section->addText('[Gambar tabel tidak tersedia]', ['italic' => true, 'color' => '808080'], ['spaceAfter' => 0]);
        }
    }

    private function renderPastedTable(array $rows): void
    {
        if (empty($rows)) return;
        $colCount = max(array_map('count', $rows));
        $totalWidth = 10200;
        $colWidth = (int)($totalWidth / max($colCount, 1));

        $t = $this->section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80, 'width' => $totalWidth, 'unit' => 'dxa']);
        foreach ($rows as $rowIdx => $row) {
            $t->addRow(250);
            for ($c = 0; $c < $colCount; $c++) {
                $val  = $row[$c] ?? '';
                $font = $rowIdx === 0 ? ['bold' => true, 'size' => 11] : ['size' => 11];
                $t->addCell($colWidth)->addText((string)$val, $font, ['spaceAfter' => 0]);
            }
        }
    }

    private function resolveStoredImagePath(?string $path): ?string
    {
        if (!$path) return null;
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->path($path);
        }
        return null;
    }

    // ─── Footer ──────────────────────────────────────────────────────────────

    protected function addFooter(): void
    {
        $footer = $this->section->addFooter();

        // 4 equal columns
        $col = 2729;

        $ft = $footer->addTable([
            'width'       => 10915,
            'unit'        => 'dxa',
            'borderSize'  => 6,
            'borderColor' => '000000',
            'cellMargin'  => 80,
            'indent'      => new TblWidth(-310, 'dxa'),
        ]);

        // Row 1: headers — Dibuat oleh | Diperiksa oleh (span 2) | Disetujui oleh
        $ft->addRow(300);
        $ft->addCell($col, ['borderSize' => 6, 'valign' => 'center'])
            ->addText('Dibuat oleh', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $ft->addCell($col * 2, ['gridSpan' => 2, 'borderSize' => 6, 'valign' => 'center'])
            ->addText('Diperiksa oleh', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $ft->addCell($col, ['borderSize' => 6, 'valign' => 'center'])
            ->addText('Disetujui oleh', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);

        // Row 2: signature blocks (tall)
        $ft->addRow(1200);

        // Col 1: Validation Officer (1)
        $c1 = $ft->addCell($col, ['borderSize' => 6, 'valign' => 'bottom']);
        $c1->addTextBreak(3);
        $c1->addText('______________', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $c1->addText('Validation Officer (1)', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $c1->addText('Tanggal:', ['size' => 11], ['alignment' => 'left', 'spaceAfter' => 0]);

        // Col 2: Validation Manager (left half of "Diperiksa oleh")
        $c2 = $ft->addCell($col, ['borderSize' => 6, 'borderRightSize' => 0, 'valign' => 'bottom']);
        $c2->addTextBreak(3);
        $c2->addText('______________', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $c2->addText('Validation Manager', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $c2->addText('Tanggal:', ['size' => 11], ['alignment' => 'left', 'spaceAfter' => 0]);

        // Col 3: APJ IOBA (right half of "Diperiksa oleh")
        $c3 = $ft->addCell($col, ['borderSize' => 6, 'borderLeftSize' => 0, 'valign' => 'bottom']);
        $c3->addTextBreak(3);
        $c3->addText('______________', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $c3->addText('APJ IOBA', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $c3->addText('Tanggal:', ['size' => 11], ['alignment' => 'left', 'spaceAfter' => 0]);

        // Col 4: Quality Div. Manager
        $c4 = $ft->addCell($col, ['borderSize' => 6, 'valign' => 'bottom']);
        $c4->addTextBreak(3);
        $c4->addText('______________', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $c4->addText('Quality Div. Manager', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $c4->addText('Tanggal:', ['size' => 11], ['alignment' => 'left', 'spaceAfter' => 0]);
    }

    protected function saveAndDownload()
    {
        $namaProduk = $this->data['judul_nama_produk'] ?? 'Nutracare_EPO_500';
        $fileName   = 'Summary_Validasi_' . str_replace(' ', '_', $namaProduk) . '_' . date('Y-m-d') . '.docx';
        $tempFile   = tempnam(sys_get_temp_dir(), 'PHPWord');

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
