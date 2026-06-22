<?php

namespace App\Services\Export;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Element\Section;
use PhpOffice\PhpWord\ComplexType\TblWidth;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

class ZingiberisExportService
{
    protected PhpWord $phpWord;
    protected Section $section;
    protected array $data;

    /**
     * Default mesin per tahap jika dropdown tidak dipilih (sesuai teks sebelum -> di blade)
     */
    private const MESIN_DEFAULTS = [
        'tujuan_mesin'              => 'SCH500',
        'tujuan_mesin_ekstraksi_2'  => 'SCH500',
        'tujuan_mesin_evaporasi'    => 'SCH2000',
        'tujuan_mesin_evaporasi_2'  => 'SCH2000',
        'tujuan_mesin_granulasi'    => 'Vacuum Belt Dryer',
        'tujuan_mesin_sterilisasi'  => 'SCH500',
        'tujuan_mesin_sterilisasi_2'=> 'SCH500',
        'tujuan_mesin_mixing'       => 'Mixer Tateng',
        'tujuan_mesin_granulasi_2'  => 'Vacuum Belt Dryer',
        'tujuan_mesin_pengecilan'   => 'Grinding Fitzmill',
    ];

    /** Resolve nilai mesin: pakai form value jika diisi, fallback ke default */
    private function mesin(string $key): string
    {
        $val = trim((string)($this->data[$key] ?? ''));
        return $val !== '' ? $val : (self::MESIN_DEFAULTS[$key] ?? '');
    }

    public function export(array $data)
    {
        $this->data    = $data;
        $this->phpWord = new PhpWord();
        Settings::setOutputEscapingEnabled(true);

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
            'marginTop'      => 850, 'marginBottom' => 850,
            'marginLeft'     => 850, 'marginRight'  => 850,
            'headerHeight'   => 480,
            'borderTopSize'  => 6,   'borderBottomSize' => 6,
            'borderLeftSize' => 6,   'borderRightSize'  => 6,
        ]);
    }

    protected function addHeader(): void
    {
        $header      = $this->section->addHeader();
        $headerTable = $header->addTable([
            'width'      => 10915, 'unit'       => 'dxa',
            'borderSize' => 6,     'cellMargin' => 50,
            'indent'     => new TblWidth(-310, 'dxa'),
        ]);
        [$col1, $col2, $col3] = [4100, 3150, 3675];

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
        $namaProduk = strtoupper($this->data['judul_nama_produk'] ?? 'ZINGIBERIS OFFICINALIS POWDER EXTRACT 2:1 (ZOS-32) HOF');
        $line       = strtoupper($this->data['judul_line']   ?? 'EKSTRAKSI');
        $bagian     = strtoupper($this->data['judul_bagian'] ?? 'PRODUCTION NATPRO & EXTRACTION BANGUNAN IOT NATPRO');
        $this->section->addText(
            "SUMMARY LAPORAN VALIDASI PROSES PEMBUATAN PRODUK {$namaProduk} DI LINI {$line} BAGIAN {$bagian}",
            ['bold' => true, 'size' => 12], ['alignment' => 'center', 'spaceAfter' => 0]
        );
    }

    protected function addDocumentInfoTable(): void
    {
        $this->section->addTextBreak(1);
        $t  = $this->section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80, 'alignment' => 'center']);
        $cp = ['spaceAfter' => 0];
        $t->addRow();
        $t->addCell(2000)->addText('Dokumen No. :', ['size' => 11], $cp);
        $t->addCell(3000)->addText($this->data['dokumen_no']       ?? '-', ['size' => 11], $cp);
        $t->addCell(1500)->addText('Tanggal :',      ['size' => 11], $cp);
        $t->addCell(2500)->addText($this->data['dokumen_tanggal']  ?? '-', ['size' => 11], $cp);
        $t->addRow();
        $t->addCell(2000)->addText('Pengganti No. :', ['size' => 11], $cp);
        $t->addCell(3000)->addText($this->data['pengganti_no']     ?? '-', ['size' => 11], $cp);
        $t->addCell(1500)->addText('Tanggal :',       ['size' => 11], $cp);
        $t->addCell(2500)->addText($this->data['pengganti_tanggal'] ?? '-', ['size' => 11], $cp);
        $this->section->addTextBreak(1);
    }

    protected function exportBab1(): void
    {
        $this->section->addText('1. PENDAHULUAN', ['bold' => true, 'size' => 12], ['alignment' => 'both', 'spaceBefore' => 240, 'contextualSpacing' => true]);

        $r11 = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 300], 'contextualSpacing' => true]);
        $r11->addText('1.1', ['size' => 11]);
        $r11->addText('  Tujuan', ['size' => 11]);

        $namaProduk = $this->data['tujuan_nama_produk'] ?? 'Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF';
        $line       = $this->data['tujuan_line']   ?? $this->data['judul_line']   ?? 'Ekstraksi';
        $bagian     = $this->data['tujuan_bagian'] ?? $this->data['judul_bagian'] ?? 'Production Natpro & Extraction';

        $r = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 740], 'contextualSpacing' => true]);
        $r->addText("Summary validasi ini bertujuan mendokumentasikan hasil studi validasi/pembuktian terhadap kualitas dan reprodusibilitas proses pengolahan produk {$namaProduk} di Lini {$line} Bagian {$bagian} dalam menghasilkan produk yang memenuhi persyaratan mutu yang tercantum dalam Spesifikasi Produk Ekstrak yang berlaku.", ['size' => 11]);

        $r12 = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 300], 'contextualSpacing' => true]);
        $r12->addText('1.2', ['size' => 11]);
        $r12->addText('  Batch Validasi', ['size' => 11]);

        $jumlah    = $this->data['batch_jumlah']       ?? '1';
        $batchCode = $this->data['batch_besaran']      ?? 'DEC25A07';
        $bahan     = $this->data['batch_bahan']        ?? 'Rimpang Jahe Segar';
        $berat     = $this->data['berat_biomassa_bab1'] ?? ($this->data['pencampuran_berat_produk'] ?? '501.19');

        $this->section->addText(
            "Studi validasi dilakukan terhadap {$jumlah} batch produksi yaitu batch {$batchCode} dengan besaran {$bahan} sebesar {$berat} kg ({$bahan} yang diproses pada batch {$batchCode}).",
            ['size' => 11],
            ['alignment' => 'both', 'indentation' => ['left' => 740], 'contextualSpacing' => true]
        );
    }

    protected function exportBab2(): void
    {
        $this->section->addTextBreak(1);
        $this->section->addText('2. HASIL DAN EVALUASI PROSES', ['bold' => true, 'size' => 11], ['alignment' => 'both', 'spaceAfter' => 0]);

        $tableSubabMap    = is_array($this->data['bab22_table_subab_key']         ?? null) ? $this->data['bab22_table_subab_key']         : [];
        $imageMap         = is_array($this->data['mixing_image_file']              ?? null) ? $this->data['mixing_image_file']              : [];
        $existingImageMap = is_array($this->data['existing_mixing_image_file']     ?? null) ? $this->data['existing_mixing_image_file']     : [];

        $namaProduk = $this->data['tujuan_nama_produk'] ?? $this->data['judul_nama_produk'] ?? 'Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF';
        $tahapan    = $this->data['pencampuran_tahapan']         ?? 'ekstraksi, evaporasi, sterilisasi, granulasi, dan pengemasan';
        $noDok      = $this->data['pencampuran_no_dokumen']      ?? 'CG-00087-04-PC';
        $tglDok     = $this->data['pencampuran_tanggal_dokumen'] ?? '29-09-2025';
        $tempat     = $this->data['pencampuran_tempat']          ?? 'Fiber Drum';

        $r21 = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 740, 'hanging' => 440], 'contextualSpacing' => true]);
        $r21->addText('2.1.', ['size' => 11]);
        $r21->addText(" Seluruh tahapan pengolahan {$namaProduk} yaitu {$tahapan} telah dilakukan sesuai dengan MBR Proses {$namaProduk}, No. Dokumen {$noDok}, tanggal {$tglDok}, dan MBR Pengemasan {$namaProduk} {$tempat}, No. Dokumen {$noDok}, tanggal {$tglDok}.", ['size' => 11]);

        $r22 = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 670, 'hanging' => 370], 'spaceAfter' => 60]);
        $r22->addText('2.2', ['size' => 11]);
        $r22->addText('  Pelaksanaan Proses Produksi', ['size' => 11]);
        $this->addBab22SubabTables('mixing', $tableSubabMap, $imageMap, $existingImageMap);

        $r23 = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 670, 'hanging' => 370], 'spaceAfter' => 60]);
        $r23->addText('2.3', ['size' => 11]);
        $r23->addText('  Hasil pemeriksaan sampel pada masing-masing tahapan adalah sebagai berikut:', ['size' => 11]);
        $this->exportBab23($tableSubabMap, $imageMap, $existingImageMap);

        // 2.4 Catatan
        $catatanDefault = 'Tahap evaporasi belum dapat memberikan hasil bobot tetap yang sesuai dengan MBR Proses Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32), no. dokumen CG-00087-04-PC, tanggal 29-09-2025, yaitu 15-20%';
        $catatan = trim((string)($this->data['pencampuran_catatan'] ?? ''));
        if ($catatan === '') {
            $catatan = $catatanDefault;
        }
        $r24 = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 670, 'hanging' => 370], 'spaceAfter' => 60]);
        $r24->addText('2.4', ['size' => 11]);
        $r24->addText('  CATATAN', ['bold' => true, 'size' => 11]);
        $r241 = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 1350, 'hanging' => 610], 'contextualSpacing' => true]);
        $r241->addText('2.4.1', ['size' => 11]);
        $r241->addText(' ' . $catatan, ['size' => 11]);
    }

    protected function exportBab23(array $tableSubabMap, array $imageMap, array $existingImageMap): void
    {
        $namaProduk = $this->data['tujuan_nama_produk'] ?? $this->data['judul_nama_produk'] ?? 'Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF';
        $noDok      = $this->data['pencampuran_no_dokumen']      ?? 'CG-00087-04-PC';
        $tglDok     = $this->data['pencampuran_tanggal_dokumen'] ?? '29-09-2025';

        // batch codes: blade pakai batch_name di 2.3.1.1, batch_besaran_2362 di 2.3.2, batch_besaran di 2.3.3/4
        $batchEkstraksi = trim((string)($this->data['batch_name']       ?? ($this->data['batch_besaran'] ?? 'DEC25A07')));
        $batchEvapo     = trim((string)($this->data['batch_besaran_2362'] ?? $batchEkstraksi));
        $batchSteril    = trim((string)($this->data['batch_besaran']    ?? $batchEkstraksi));

        // ── 2.3.1 Tahap Ekstraksi ──
        $this->addSubabHeading('2.3.1.', 'Tahap Ekstraksi');

        // 2.3.1.1 — mesin default SCH500
        $mesinEkstr1   = $this->mesin('tujuan_mesin');
        $beratBiomassa = trim((string)($this->data['berat_biomassa'] ?? '109.65'));
        $this->addSubSubabText('2.3.1.1.',
            "Tahap ekstraksi produk {$namaProduk} batch {$batchEkstraksi} menggunakan {$mesinEkstr1}"
            . ($beratBiomassa !== '' ? " dengan bobot Biomassa hasil preproses parut yang diekstraksi sebesar {$beratBiomassa} kg" : '') . '.'
        );

        // 2.3.1.2 — mesin default SCH500
        $mesinEkstr2 = $this->mesin('tujuan_mesin_ekstraksi_2');
        $waktu       = trim((string)($this->data['pencampuran_waktu'] ?? '90'));
        $suhu        = trim((string)($this->data['pencampuran_suhu']  ?? '70'));
        $this->addSubSubabText('2.3.1.2.',
            "Proses ekstraksi dengan {$mesinEkstr2} dilakukan selama {$waktu} menit setelah suhu tercapai {$suhu}°C."
        );

        // 2.3.1.3
        $beratAkhirEkstr = trim((string)($this->data['berat_hasil_ekstraksi'] ?? '599.81'));
        $this->addSubSubabText('2.3.1.3.',
            "Pengambilan sampel dilakukan setelah proses pencampuran antara miscella hasil preproses parut dan hasil ekstraksi biomassa. Dengan hasil akhir sebesar {$beratAkhirEkstr} kg."
        );

        // 2.3.1.4
        $ipcEkstr = trim((string)($this->data['ipc_jenis_ekstraksi'] ?? 'Pemerian dan bobot tetap pada'));
        $this->addSubSubabText('2.3.1.4.',
            "{$ipcEkstr} produk antara hasil ekstraksi bukan merupakan syarat release QC (spesifikasi pemeriksaan rutin), tetapi merupakan monitoring in process control (IPC) pada akhir proses ekstraksi sehingga tetap dilakukan pemeriksaan tetapi hanya digunakan sebagai pendataan seperti yang tercantum pada MBR Proses {$namaProduk} No. Dokumen {$noDok}, tanggal {$tglDok}."
        );
        $this->addBab22SubabTables('tbl_kapsulasi_2232', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.1.5
        $this->addSubSubabText('2.3.1.5.', 'Dilakukan pengambilan sampel ketika proses ekstraksi telah selesai dengan hasil sebagai berikut:');
        $this->addBab22SubabTables('ekstr_hasil', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.1.6
        $hasilEkstr = trim((string)($this->data['hasil_jenis_ekstraksi'] ?? 'pemeriksaan pemerian dan bobot tetap'));
        $this->addSubSubabText('2.3.1.6.',
            "Hasil {$hasilEkstr} seluruh sampel produk antara hasil ekstraksi dari batch {$batchEvapo} telah memenuhi syarat spesifikasi IPC."
        );

        // ── 2.3.2 Tahap Evaporasi ──
        $this->addSubabHeading('2.3.2.', 'Tahap Evaporasi');

        // 2.3.2.1 — mesin default SCH2000
        $mesinEvapo1 = $this->mesin('tujuan_mesin_evaporasi');
        $this->addSubSubabText('2.3.2.1.',
            "Tahap evaporasi untuk {$namaProduk} batch {$batchEvapo} dilakukan menggunakan {$mesinEvapo1}."
        );

        // 2.3.2.2 — mesin default SCH2000
        $mesinEvapo2 = $this->mesin('tujuan_mesin_evaporasi_2');
        $paramEvapo  = trim((string)($this->data['pencampuran_parameter'] ?? 'flowrate 4 m3/h, suhu preheating 70°C, suhu heating 80°C, dan tekanan vakum -0.750 bar'));
        $beratEvapo  = trim((string)($this->data['berat_hasil_evaporasi'] ?? '223.9'));
        $this->addSubSubabText('2.3.2.2.',
            "Proses evaporasi dengan {$mesinEvapo2} dilakukan dengan parameter {$paramEvapo}. Dengan hasil akhir tahap evaporasi sebesar {$beratEvapo} kg."
        );

        // 2.3.2.3
        $ipcEvapo = trim((string)($this->data['ipc_jenis_evaporasi'] ?? 'Pemerian dan bobot tetap'));
        $this->addSubSubabText('2.3.2.3.',
            "{$ipcEvapo} pada produk antara hasil evaporasi bukan merupakan syarat release QC (spesifikasi pemeriksaan rutin), tetapi merupakan monitoring in process control (IPC) pada akhir proses evaporasi sehingga tetap dilakukan pemeriksaan tetapi hanya digunakan sebagai pendataan seperti yang tercantum pada MBR Proses {$namaProduk} No. Dokumen {$noDok}, tanggal {$tglDok}."
        );
        $this->addBab22SubabTables('tbl_kapsulasi_222', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.2.4
        $this->addSubSubabText('2.3.2.4.', 'Dilakukan pengambilan sampel ketika proses evaporasi selesai dengan hasil sebagai berikut:');
        $this->addBab22SubabTables('evapo_hasil', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.2.5 — mesin granulasi default Vacuum Belt Dryer
        $mesinGran1  = $this->mesin('tujuan_mesin_granulasi');
        $syaratEvapo = trim((string)($this->data['pencampuran_syarat_evaporasi'] ?? '15-20%'));
        $this->addSubSubabText('2.3.2.5.',
            "Hasil akhir evaporasi dari batch {$batchEvapo} akan digranulasi dengan {$mesinGran1} sehingga digunakan syarat {$syaratEvapo}."
        );

        // 2.3.2.6
        $hasilEvapo1 = trim((string)($this->data['hasil_ipc_evaporasi_1'] ?? 'telah memenuhi'));
        $pemErianEvapo = trim((string)($this->data['hasil_pemerian_evaporasi'] ?? 'pemerian'));
        $this->addSubSubabText('2.3.2.6.',
            "Hasil pemeriksaan {$pemErianEvapo} seluruh sampel produk antara hasil evaporasi dari batch {$batchEvapo} {$hasilEvapo1} syarat spesifikasi IPC."
        );

        // 2.3.2.7
        $hasilEvapo2   = trim((string)($this->data['hasil_ipc_evaporasi_2'] ?? 'tidak memenuhi'));
        $bobotTetapEvapo = trim((string)($this->data['hasil_bobot_tetap_evaporasi'] ?? 'bobot tetap'));
        $this->addSubSubabText('2.3.2.7.',
            "Hasil pemeriksaan {$bobotTetapEvapo} seluruh sampel produk antara hasil evaporasi dari batch {$batchEvapo} {$hasilEvapo2} syarat spesifikasi IPC yaitu {$syaratEvapo}."
        );

        // ── 2.3.3 Tahap Sterilisasi ──
        $this->addSubabHeading('2.3.3.', 'Tahap Sterilisasi');

        // 2.3.3.1 — mesin default SCH500
        $mesinSteril1 = $this->mesin('tujuan_mesin_sterilisasi');
        $this->addSubSubabText('2.3.3.1.',
            "Tahap sterilisasi untuk {$namaProduk} batch {$batchSteril} dengan menggunakan mesin {$mesinSteril1}."
        );

        // 2.3.3.2 — mesin default SCH500
        $mesinSteril2 = $this->mesin('tujuan_mesin_sterilisasi_2');
        $paramSteril  = trim((string)($this->data['parameter_sterilisasi'] ?? ($this->data['pencampuran_parameter'] ?? 'sirkulasi selama 14 menit pada suhu 85°C')));
        $beratSteril  = trim((string)($this->data['berat_hasil_sterilisasi'] ?? '223.75'));
        $this->addSubSubabText('2.3.3.2.',
            "Proses sterilisasi dengan {$mesinSteril2} dilakukan dengan parameter {$paramSteril}. Dengan hasil akhir tahap sterilisasi sebesar {$beratSteril} kg."
        );

        // 2.3.3.3
        $pemSteril = trim((string)($this->data['param_kemas_344'] ?? 'cemaran mikroba'));
        $this->addSubSubabText('2.3.3.3.',
            "Pemeriksaan {$pemSteril} pada produk antara hasil sterilisasi bukan merupakan syarat release QC (spesifikasi pemeriksaan rutin), tetapi hanya digunakan sebagai pendataan."
        );
        $this->addBab22SubabTables('tbl_kemasan_332', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.3.4
        $samplingLokasi = trim((string)($this->data['pencampuran_sampling_waktu'] ?? 'atas, tengah, dan bawah'));
        $this->addSubSubabText('2.3.3.4.',
            "Dilakukan pengambilan sampel yang mewakili {$samplingLokasi} dari vat/kontainer dengan hasil sebagai berikut:"
        );
        $this->addBab22SubabTables('tbl_kemasan_3331', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.3.5
        $hasilSteril = trim((string)($this->data['hasil_sterilisasi'] ?? 'telah memenuhi'));
        $this->addSubSubabText('2.3.3.5.',
            "Hasil pemeriksaan {$pemSteril} seluruh sampel produk antara hasil sterilisasi dari batch {$batchSteril} {$hasilSteril} kriteria penerimaan yang berlaku."
        );

        // ── 2.3.4 Tahap Granulasi ──
        $this->addSubabHeading('2.3.4.', 'Tahap Granulasi');

        // 2.3.4.1 — mesin mixing default Mixer Tateng
        $mesinMixing  = $this->mesin('tujuan_mesin_mixing');
        $pengisi      = trim((string)($this->data['bahan_pengisi_granulasi'] ?? ($this->data['pencampuran_tahapan'] ?? 'maltodextrine')));
        $beratEkstrGran = trim((string)($this->data['berat_ekstrak_granulasi'] ?? '223.75'));
        $beratPengisi   = trim((string)($this->data['berat_pengisi_granulasi'] ?? '232.58'));
        $this->addSubSubabText('2.3.4.1.',
            "Ekstrak hasil sterilisasi dari batch {$batchSteril} sebesar {$beratEkstrGran} kg diproses mixing dengan pengisi {$pengisi} sebesar {$beratPengisi} kg dengan {$mesinMixing}."
        );

        // 2.3.4.2 — mesin granulasi default Vacuum Belt Dryer
        $mesinGran2 = $this->mesin('tujuan_mesin_granulasi_2');
        $this->addSubSubabText('2.3.4.2.',
            "Campuran antara pengisi dan ekstrak diproses granulasi dan pengeringan menggunakan {$mesinGran2}."
        );

        // 2.3.4.3 — mesin pengecilan default Grinding Fitzmill
        $mesinPengecilan = $this->mesin('tujuan_mesin_pengecilan');
        $screenSize      = trim((string)($this->data['kapsulasi_sampling_titik'] ?? '24'));
        $beratKering     = trim((string)($this->data['berat_ekstrak_kering'] ?? '232.78'));
        $this->addSubSubabText('2.3.4.3.',
            "Hasil granulasi kemudian diproses pengecilan ukuran granul menggunakan {$mesinPengecilan} Screen {$screenSize}. Dengan hasil akhir ekstrak kering sebesar {$beratKering} kg."
        );

        // 2.3.4.4
        $noDok2344             = $this->data['pencampuran_no_dokumen']       ?? 'SX-F03-3-00018-02';
        $tglDok2344            = $this->data['pencampuran_tanggal_dokumen']  ?? '09-08-2024';
        $this->addSubSubabText('2.3.4.4.',
            "Spesifikasi Produk {$namaProduk} batch {$batchSteril} sesuai dengan yang tercantum pada Spesifikasi {$namaProduk} No. Dokumen {$noDok2344}, tanggal {$tglDok2344} adalah sebagai berikut:"
        );
        $this->addBab22SubabTables('gran_spesifikasi', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.4.5
        $jmlLokasi    = trim((string)($this->data['kapsulasi_sampling_titik'] ?? '3'));
        $pemGranulasi = trim((string)($this->data['pencampuran_sampling_waktu_235'] ?? 'pemerian, kadar air, kadar logam berat, dan pemeriksaan batas mikroba'));
        $this->addSubSubabText('2.3.4.5.',
            "Pada tahap akhir pengecilan ukuran granul dilakukan sampling sebanyak {$jmlLokasi} lokasi yang mewakili lokasi {$samplingLokasi} dari wadah pengemas ekstrak. Kemudian dilakukan pemeriksaan {$pemGranulasi} dengan hasil sebagai berikut:"
        );

        // 2.3.4.5.1
        $pem1 = trim((string)($this->data['pem_granulasi_1'] ?? 'pemerian dan kadar air'));
        $this->addSubSubSubabText('2.3.4.5.1.', "Tabel hasil pemeriksaan {$pem1} pada tahap akhir granulasi:");
        $this->addBab22SubabTables('gran_pem1', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.4.5.2
        $pem2 = trim((string)($this->data['pem_granulasi_2'] ?? 'ukuran partikel dan cemaran logam berat'));
        $this->addSubSubSubabText('2.3.4.5.2.', "Tabel hasil pemeriksaan {$pem2}.");
        $this->addBab22SubabTables('gran_pem2', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.4.5.3
        $pem3 = trim((string)($this->data['pem_granulasi_3'] ?? 'cemaran mikrobiologi'));
        $this->addSubSubSubabText('2.3.4.5.3.', "Tabel hasil pemeriksaan {$pem3} pada tahap granulasi akhir.");
        $this->addBab22SubabTables('gran_pem3', $tableSubabMap, $imageMap, $existingImageMap);

        // 2.3.4.6
        $hasilGran     = trim((string)($this->data['hasil_granulasi'] ?? 'memenuhi'));
        $paramGranAkhr = trim((string)($this->data['param_kemas_314'] ?? 'pemerian, kadar air, kadar logam berat, dan cemaran mikroba'));
        $this->addSubSubabText('2.3.4.6.',
            "Secara keseluruhan,  atribut yang diuji pada tahap akhir granulasi sudah memberikan hasil yang {$hasilGran}  persyaratan menurut spesifikasi ekstrak yang berlaku."
        );

        // ── 2.3.5 Tahap Pengemasan ──
        $this->addSubabHeading('2.3.5.', 'Tahap Pengemasan');

        $hasil2351 = trim((string)($this->data['hasil_2351'] ?? ''));
        $tempat     = $this->data['pencampuran_tempat']          ?? 'Fiber Drum';
        $this->addSubSubabText('2.3.5.1.',
            "Hasil pengolahan {$namaProduk} batch {$batchSteril} dikemas dalam kemasan {$tempat}" . ($hasil2351 !== '' ? " {$hasil2351}" : '') . '.'
        );
        $this->addBab22SubabTables('kemas_hasil', $tableSubabMap, $imageMap, $existingImageMap);

        $hasil2352 = trim((string)($this->data['hasil_2352'] ?? ''));
        $kemasan   = $this->data['pencampuran_kemasan']   ?? 'Plastik';
        $tempat     = $this->data['pencampuran_tempat']          ?? 'Fiber Drum';
        $samplingWadah = $this->data['kapsulasi_sampling_titik'] ?? '9';
        $beratSatuan  = $this->data['berat_kemasan_satuan'] ?? '25';
        $this->addSubSubabText('2.3.5.2.',
            "{$namaProduk} batch {$batchSteril} yang dikemas dalam kemasan primer {$kemasan} dengan kemasan sekunder {$tempat} adalah sebanyak {$samplingWadah} wadah, dengan masing-masing memiliki bobot {$beratSatuan} kg." . ($hasil2352 !== '' ? " {$hasil2352}" : '') . '.'
        );
        $this->addBab22SubabTables('kemas_pem', $tableSubabMap, $imageMap, $existingImageMap);

        $hasil2353 = trim((string)($this->data['hasil_2353'] ?? ''));
        $tempat     = $this->data['pencampuran_tempat']          ?? 'Fiber Drum';
        $this->addSubSubabText('2.3.5.3.',
            "Dengan hasil pemeriksaan hasil kemas {$tempat} sebagai berikut : " . ($hasil2353 !== '' ? " {$hasil2353}" : '') . '.'
        );
        $this->addBab22SubabTables('kemas_hasil', $tableSubabMap, $imageMap, $existingImageMap);
        $this->addBab22SubabTables('gran_pem2', $tableSubabMap, $imageMap, $existingImageMap); 

        $hasil2354 = trim((string)($this->data['hasil_2354'] ?? ''));
        $hasilGran     = trim((string)($this->data['hasil_granulasi'] ?? 'memenuhi'));
        $this->addSubSubabText('2.3.5.4.',
            "Secara keseluruhan, atribut yang diuji pada tahap pengemasan sudah memberikan hasil yang {$hasilGran} persyaratan menurut spesifikasi ekstrak yang berlaku." . ($hasil2354 !== '' ? " {$hasil2354}" : '') . '.'
        );
        $this->addBab22SubabTables('kemas_hasil', $tableSubabMap, $imageMap, $existingImageMap);
    }

    protected function exportBab3(): void
    {
        $this->section->addTextBreak(1);
        $this->section->addText('3. KESIMPULAN', ['bold' => true, 'size' => 11], ['alignment' => 'both', 'spaceAfter' => 0]);

        $namaProduk        = $this->data['tujuan_nama_produk']          ?? $this->data['judul_nama_produk'] ?? 'Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF';
        $kesimpulanTahapan = $this->data['kesimpulan_tahapan']          ?? 'ekstraksi, evaporasi, sterilisasi, granulasi, dan pengemasan';
        $noDok             = $this->data['pencampuran_no_dokumen']       ?? 'CG-00087-04-PC';
        $tglDok            = $this->data['pencampuran_tanggal_dokumen']  ?? '29-09-2025';
        $tempat            = $this->data['pencampuran_tempat']           ?? 'Fiber Drum';
        $batchCode         = $this->data['batch_besaran']                ?? 'DEC25A07';
        $kemHasil          = trim((string)($this->data['kemasan_hasil'] ?? 'memenuhi'));
        $status            = trim((string)($this->data['kesimpulan_status'] ?? 'validated'));

        // 3.1
        $r31 = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 740, 'hanging' => 440], 'contextualSpacing' => true]);
        $r31->addText('3.1', ['size' => 11]);
        $r31->addText(" Telah dilakukan validasi proses pengolahan produk {$namaProduk}, yaitu {$kesimpulanTahapan}, telah dilakukan sesuai dengan MBR Proses {$namaProduk}, No. Dokumen {$noDok}, tanggal {$tglDok}, MBR Pengemasan {$namaProduk} {$tempat}, No. Dokumen {$noDok}, tanggal {$tglDok}.", ['size' => 11]);

        // sub-poin 3.1.x — field dari blade
        $pemJenis    = trim((string)($this->data['param_mutu_ekstraksi']  ?? 'pemerian dan bobot tetap'));
        $kemHasil11  = trim((string)($this->data['hasil_311']             ?? 'telah memenuhi'));
        $paramEvapo2 = trim((string)($this->data['param_penyalutan_313']  ?? ''));

        $texts = [
            '3.1.1' => "Berdasarkan pemeriksaan batch validasi {$batchCode} terhadap parameter mutu produk pada tahap ekstraksi antara lain {$pemJenis} didapatkan hasil pengujian {$kemHasil11} spesifikasi produk yang berlaku.",
            '3.1.2' => "Berdasarkan pemeriksaan batch validasi {$batchCode} terhadap parameter mutu produk pada tahap evaporasi antara lain "
                . trim((string)($this->data['param_mutu_evaporasi'] ?? 'pemerian'))
                . " didapatkan hasil pengujian " . trim((string)($this->data['hasil_312'] ?? 'telah memenuhi'))
                . ($paramEvapo2 !== '' ? " {$paramEvapo2}" : '.'),
            '3.1.3' => "Berdasarkan pemeriksaan batch validasi {$batchCode} terhadap parameter mutu produk pada tahap sterilisasi antara lain "
                . trim((string)($this->data['param_mutu_sterilisasi'] ?? 'batas mikroba'))
                . " didapatkan hasil pengujian " . trim((string)($this->data['hasil_313'] ?? 'telah memenuhi')) . " spesifikasi produk yang berlaku.",
            '3.1.4' => "Berdasarkan pemeriksaan batch validasi {$batchCode} terhadap parameter mutu produk pada tahap akhir granulasi sebagai produk jadi, antara lain "
                . trim((string)($this->data['param_kemas_314'] ?? 'pemerian, kadar air, kadar logam berat, dan cemaran mikroba'))
                . " didapatkan hasil pegujian " . trim((string)($this->data['hasil_314'] ?? 'telah memenuhi')) . " spesifikasi produk yang berlaku.",
            '3.1.5' => "Berdasarkan pemeriksaan batch validasi {$batchCode} terhadap parameter mutu pengemasan pada tahap pengemasan antara lain "
                . trim((string)($this->data['param_kemas_315'] ?? ($this->data['param_kemas_314'] ?? 'kebersihan kemasan, keberadaan etiket, dan penyimpanan produk')))
                . " didapatkan hasil pegujian " . trim((string)($this->data['hasil_315'] ?? 'telah memenuhi')) . " spesifikasi produk yang berlaku.",
        ];

        $enabledStr      = (string)($this->data['kesimpulan_enabled_sections'] ?? '1,2,3,4');
        $enabledSections = array_values(array_filter(array_map('trim', explode(',', $enabledStr))));

        $subMap = ['1' => '3.1.1', '2' => '3.1.2', '3' => '3.1.3', '4' => '3.1.4'];
        foreach ($subMap as $sid => $num) {
            if (in_array($sid, $enabledSections, true)) {
                $this->addSubKesimpulanItem($num, $texts[$num]);
                if ($sid === '4') {
                    $this->addSubKesimpulanItem('3.1.5', $texts['3.1.5']);
                }
            }
        }

        // 3.2
        $kemHasil  = trim((string)($this->data['kemasan_hasil']    ?? 'memenuhi'));
        $hasilProses = trim((string)($this->data['hasil_32_proses'] ?? ($this->data['kemasan_hasil'] ?? 'memenuhi')));
        $r32 = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 740, 'hanging' => 440], 'contextualSpacing' => true]);
        $r32->addText('3.2', ['size' => 11]);
        $r32->addText(" Proses {$hasilProses} terbukti dapat menghasilkan produk jadi {$namaProduk} batch {$batchCode} yang memenuhi spesifikasi dalam Spesifikasi {$namaProduk}, No. Dokumen {$noDok}, tanggal {$tglDok}, sehingga dinyatakan ", ['size' => 11]);
        $r32->addText($status, ['italic' => true, 'size' => 11]);
        $r32->addText('.', ['size' => 11]);

        // Custom poin tambahan
        $customNumber = 3;
        foreach ($enabledSections as $sectionId) {
            if (str_starts_with($sectionId, 'c')) {
                $customNum  = substr($sectionId, 1);
                $customText = trim((string)($this->data["kesimpulan_custom_{$customNum}"] ?? ''));
                if ($customText !== '') {
                    $this->addKesimpulanItem("3.{$customNumber}", $customText);
                    $customNumber++;
                }
            }
        }
    }

    protected function exportBab4(): void
    {
        $this->section->addTextBreak(1);
        $this->section->addText('4. SARAN', ['bold' => true, 'size' => 11], ['alignment' => 'both', 'spaceAfter' => 0]);

        $namaProduk = $this->data['tujuan_nama_produk'] ?? $this->data['judul_nama_produk'] ?? 'Zingiberis Officinalis Powder Extract 2 : 1 (ZOS-32) HOF';
        $this->addKesimpulanItem('4.1',
            "Apabila dikemudian hari dilakukan perubahan pada proses produksi produk {$namaProduk}, maka perubahan tersebut harus diberitahukan ke pihak-pihak terkait dengan mekanisme sesuai pedoman pengendalian perubahan yang berlaku."
        );
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    protected function addKesimpulanItem(string $number, string $text): void
    {
        $r = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 740, 'hanging' => 440], 'contextualSpacing' => true]);
        $r->addText($number, ['size' => 11]);
        $r->addText(' ' . $text, ['size' => 11]);
    }

    protected function addSubKesimpulanItem(string $number, string $text): void
    {
        $r = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 1350, 'hanging' => 610], 'contextualSpacing' => true]);
        $r->addText($number, ['size' => 11]);
        $r->addText(' ' . $text, ['size' => 11]);
    }

    protected function addSubabHeading(string $number, string $title): void
    {
        $r = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 740, 'hanging' => 440], 'contextualSpacing' => true]);
        $r->addText($number, ['size' => 11]);
        $r->addText(' ' . $title, ['bold' => true, 'size' => 11]);
    }

    protected function addSubSubabText(string $number, string $text): void
    {
        $r = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 1350, 'hanging' => 610], 'contextualSpacing' => true]);
        $r->addText($number, ['size' => 11]);
        $r->addText(' ' . $text, ['size' => 11]);
    }

    protected function addSubSubSubabText(string $number, string $text): void
    {
        $r = $this->section->addTextRun(['alignment' => 'both', 'indentation' => ['left' => 1760, 'hanging' => 660], 'contextualSpacing' => true]);
        $r->addText($number, ['size' => 11]);
        $r->addText(' ' . $text, ['size' => 11]);
    }

    protected function addBab22SubabTables(string $subabKey, array $tableSubabMap, array $imageMap, array $existingImageMap): void
    {
        $tableUids = [];
        foreach ($tableSubabMap as $uid => $key) {
            if ((string)$key === $subabKey) {
                $tableUids[] = (string)$uid;
            }
        }
        // Fallback: jika subabKey adalah UID langsung (tbl_kapsulasi_2232 dll.)
        if (empty($tableUids) && (isset($imageMap[$subabKey]) || isset($existingImageMap[$subabKey]) || isset($this->data['mixing_pasted_table_json'][$subabKey]))) {
            $tableUids[] = $subabKey;
        }
        foreach ($tableUids as $uid) {
            $this->renderOneTable($uid, $imageMap, $existingImageMap);
        }
    }

    private function renderOneTable(string $uid, array $imageMap, array $existingImageMap): void
    {
        $imageFile = $imageMap[$uid] ?? null;
        $existing  = is_string($existingImageMap[$uid] ?? null) ? $existingImageMap[$uid] : null;
        $base64    = trim((string)($this->data['mixing_image_base64'][$uid] ?? ''));
        $pasted    = trim((string)($this->data['mixing_pasted_table_json'][$uid] ?? ''));

        $resolved = $this->resolveStoredImagePath($existing);

        if ($imageFile instanceof UploadedFile && $imageFile->isValid()) {
            try { $this->section->addImage($imageFile->getPathname(), ['width' => 450, 'height' => null, 'marginTop' => 10, 'marginBottom' => 10, 'align' => 'center']); return; }
            catch (\Exception $e) { $this->section->addText('[Error gambar: '.$e->getMessage().']', ['color' => 'FF0000']); }
        }
        if ($resolved) {
            try { $this->section->addImage($resolved, ['width' => 450, 'height' => null, 'marginTop' => 10, 'marginBottom' => 10, 'align' => 'center']); return; }
            catch (\Exception $e) { $this->section->addText('[Error gambar draft: '.$e->getMessage().']', ['color' => 'FF0000']); }
        }
        if ($base64 !== '' && str_starts_with($base64, 'data:image')) {
            try {
                $imgData = base64_decode(substr($base64, strpos($base64, ',') + 1));
                $tmp     = tempnam(sys_get_temp_dir(), 'zib');
                file_put_contents($tmp, $imgData);
                $this->section->addImage($tmp, ['width' => 450, 'height' => null, 'marginTop' => 10, 'marginBottom' => 10, 'align' => 'center']);
                @unlink($tmp);
                return;
            } catch (\Exception $e) { $this->section->addText('[Error base64]', ['color' => 'FF0000']); }
        }
        if ($pasted !== '') {
            $rows = json_decode($pasted, true);
            if (is_array($rows) && !empty($rows)) { $this->renderPastedTableToWord($rows); }
        }
    }

    protected function renderPastedTableToWord(array $rows): void
    {
        $colCount  = max(array_map('count', $rows));
        $colWidth  = (int)(9000 / max($colCount, 1));
        $table     = $this->section->addTable(['borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80, 'width' => 9000, 'unit' => 'dxa']);
        foreach ($rows as $ri => $row) {
            $table->addRow(250);
            for ($c = 0; $c < $colCount; $c++) {
                $table->addCell($colWidth, ['valign' => 'center'])
                    ->addText((string)($row[$c] ?? ''), ['bold' => $ri === 0, 'size' => 10], ['alignment' => 'left', 'spaceAfter' => 0]);
            }
        }
    }

    private function resolveStoredImagePath(?string $path): ?string
    {
        if (!$path) return null;
        return Storage::disk('public')->exists($path) ? Storage::disk('public')->path($path) : null;
    }

    protected function addFooter(): void
    {
        $footer = $this->section->addFooter();
        [$c1, $c2, $c3, $c4] = [2729, 2729, 2728, 2729];
        $ft = $footer->addTable(['width' => 10915, 'unit' => 'dxa', 'borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 50, 'indent' => new TblWidth(-310, 'dxa')]);
        $ft->addRow(0, ['exactHeight' => true]);
        $ft->addCell($c1, ['borderSize' => 6, 'valign' => 'center'])->addText('Dibuat oleh',    ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $ft->addCell($c2 + $c3, ['gridSpan' => 2, 'borderSize' => 6, 'valign' => 'center'])->addText('Diperiksa oleh', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $ft->addCell($c4, ['borderSize' => 6, 'valign' => 'center'])->addText('Disetujui oleh', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
        $ft->addRow(650);
        foreach ([['Validation Officer (2)', $c1], ['Validation Manager', $c2, true], ['APJ IEBA', $c3, false, true], ['Quality Div. Manager', $c4]] as $col) {
            [$label, $width] = $col;
            $opts = ['borderSize' => 6, 'valign' => 'bottom'];
            if (!empty($col[2])) $opts['borderRightSize'] = 0;
            if (!empty($col[3])) $opts['borderLeftSize']  = 0;
            $cell = $ft->addCell($width, $opts);
            $cell->addTextBreak(2);
            $cell->addText('__________', ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
            $cell->addText($label,       ['size' => 11], ['alignment' => 'center', 'spaceAfter' => 0]);
            $cell->addText('Tanggal:',   ['size' => 11], ['alignment' => 'left',   'spaceAfter' => 0]);
        }
    }

    protected function saveAndDownload()
    {
        $namaProduk = $this->data['judul_nama_produk'] ?? 'Zingiberis_Officinalis_Powder_Extract';
        $fileName   = 'Summary_Validasi_' . str_replace(' ', '_', $namaProduk) . '_' . date('Y-m-d') . '.docx';
        $tmpFile    = tempnam(sys_get_temp_dir(), 'ZibWord');
        $writer     = IOFactory::createWriter($this->phpWord, 'Word2007');

        $token = request()->input('export_token', '');
        $writer->save($tmpFile);
        if ($token) {
            setcookie('export_done', $token, ['expires' => time() + 60, 'path' => '/', 'httponly' => false, 'samesite' => 'Lax']);
        }
        return response()->download($tmpFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ])->deleteFileAfterSend(true);
    }
}
