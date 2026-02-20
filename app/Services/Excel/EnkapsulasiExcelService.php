<?php

namespace App\Services\Excel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Ods;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class EnkapsulasiExcelService
{
    protected string $namaProduk;
    protected string $batchSize;
    protected array $kodeBatch;
    protected string $parameterName;
    protected string $satuan;
    protected int $rowCount;
    protected int $columnsPerBatch;
    protected array $sheetParameters = []; // For multi-sheet generation with child parameters

    public function __construct(
        string $namaProduk = 'Produk',
        string $batchSize = '',
        array $kodeBatch = [],
        string $parameterName = 'Nilai Uji',
        string $satuan = 'mg',
        int $rowCount = 50,
        int $columnsPerBatch = 20
    ) {
        $this->namaProduk = $namaProduk;
        $this->batchSize = $batchSize;
        $this->kodeBatch = $kodeBatch;
        $this->parameterName = $parameterName;
        $this->satuan = $satuan;
        $this->rowCount = $rowCount;
        $this->columnsPerBatch = $columnsPerBatch;
    }

    /**
     * Generate the Excel template and return the temp file path
     */
    public function generate(): string
    {
        $spreadsheet = new Spreadsheet();

        // Determine which parameters to create sheets for
        $parametersToGenerate = !empty($this->sheetParameters)
            ? $this->sheetParameters
            : [['name' => $this->parameterName, 'satuan' => $this->satuan]];

        $isFirstSheet = true;

        foreach ($parametersToGenerate as $paramData) {
            $paramName = is_array($paramData) ? ($paramData['name'] ?? 'Parameter') : $paramData;
            $paramSatuan = is_array($paramData) ? ($paramData['satuan'] ?? $this->satuan) : $this->satuan;

            // Create sheet (reuse first sheet, create new for subsequent)
            if ($isFirstSheet) {
                $sheet = $spreadsheet->getActiveSheet();
                $isFirstSheet = false;
            } else {
                $sheet = $spreadsheet->createSheet();
            }

            // Set sanitized sheet title
            $sheetTitle = $this->sanitizeSheetName($paramName);
            $sheet->setTitle($sheetTitle);

            // Build the template for this sheet
            $this->buildTemplate($sheet);
        }

        // Save to temp file
        $tempFile = tempnam(sys_get_temp_dir(), 'enkap_');
        $writer = new Ods($spreadsheet);
        $writer->save($tempFile);

        return $tempFile;
    }

    /**
     * Build the template structure based on image reference
     */
    protected function buildTemplate($sheet): void
    {
        // If no batches provided, create default 3 batches
        $batches = !empty($this->kodeBatch) ? $this->kodeBatch : ['Batch 1', 'Batch 2', 'Batch 3'];
        $batchCount = count($batches);

        // Add margin: shift right 1 column (start from C = 3) and down 1 row (start from row 2)
        $startCol = 5; // C column (instead of B)
        $headerRow = 2; // Row 2 for batch headers (instead of 1)
        $subHeaderRow = 3; // Row 3 for column numbers (instead of 2)
        $dataStartRow = 4; // Row 4 for data (instead of 3)
        $labelCol = 'D'; // B column for "Sampel Ke-" (instead of A)

        foreach (['A', 'B'] as $col) {
            $sheet->getColumnDimension($col)->setWidth(16);
        }
        $sheet->getColumnDimension('C')->setWidth(6);

        // Info Lokasi Sampel
        $this->drawInfoBlock(
            $sheet,
            'Lokasi Sampel',
            "Isi lokasi sampel sesuai yang digunakan. Tidak perlu mengisi semua kolom.",
            'A',
            'B',
            3,
            'E8F1FA' // biru pastel
        );

        // Info Lokasi Sampel
        $this->drawInfoBlock(
            $sheet,
            'Data Pengujian',
            "Masukkan nilai hasil pengujian di area berwarna.",
            'A',
            'B',
            9,
            'FFF6D6' // kuning pastel
        );

        // Info Lokasi Sampel
        $this->drawInfoBlock(
            $sheet,
            'Catatan',
            "Jangan menghapus kolom yang kosong. Jika tidak digunakan, lanjutkan ke batch berikutnya.",
            'A',
            'B',
            15,
            'FFD7D7' // merah pastel
        );

        // Set "Sampel Ke-" header in B3
        $sheet->setCellValue($labelCol . $subHeaderRow, 'Sampel Ke-');
        $sheet->getStyle($labelCol . $subHeaderRow)->getFont()->setBold(true);
        $sheet->getStyle($labelCol . $subHeaderRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getColumnDimension($labelCol)->setWidth(12);

        // Create batch headers and column numbers
        $currentCol = $startCol;

        foreach ($batches as $batchIndex => $batchName) {
            // Calculate column range for this batch
            $startColLetter = $this->getColumnLetter($currentCol);
            $endColLetter = $this->getColumnLetter($currentCol + $this->columnsPerBatch - 1);

            // Batch name header (merged cells)
            $sheet->setCellValue($startColLetter . $headerRow, $batchName);
            $sheet->mergeCells($startColLetter . $headerRow . ':' . $endColLetter . $headerRow);

            // Style batch header
            $sheet->getStyle($startColLetter . $headerRow)->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
            ]);

            // Column numbers 1–10 (header saja)
            for ($i = 1; $i <= $this->columnsPerBatch; $i++) {
                $colLetter = $this->getColumnLetter($currentCol + $i - 1);
                $cell = $colLetter . $subHeaderRow;

                $sheet->getStyle($cell)->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                ]);

                $sheet->getColumnDimension($colLetter)->setWidth(9);
            }

            $currentCol += $this->columnsPerBatch;
        }

        // Calculate total columns
        $totalDataCols = $batchCount * $this->columnsPerBatch;
        $lastColLetter = $this->getColumnLetter($startCol + $totalDataCols - 1);

        // Sample numbers 1–50
        for ($row = 1; $row <= $this->rowCount; $row++) {
            $excelRow = $row + $dataStartRow - 1; // Excel row
            $cell = $labelCol . $excelRow;

            $sheet->setCellValue($cell, $row);

            $sheet->getStyle($cell)->applyFromArray([
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ]);
        }

        // Apply borders to entire data range (from B2 to last column and row)
        $dataEndRow = $this->rowCount + $dataStartRow - 1;
        $borderRange = "{$labelCol}{$headerRow}:{$lastColLetter}{$dataEndRow}";

        $sheet->getStyle($borderRange)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Header row styling (column numbers row)
        $sheet->getStyle("E{$subHeaderRow}:{$lastColLetter}{$subHeaderRow}")->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E8F1FA']
            ]
        ]);

        // Data row styling
        $dataFillRange =
            $this->getColumnLetter($startCol) . $dataStartRow
            . ':' .
            $lastColLetter . $dataEndRow;

        $sheet->getStyle($dataFillRange)->applyFromArray([
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFF6D6'], // kuning pastel
            ],
        ]);
    }

    protected function drawInfoBlock(
        $sheet,
        string $title,
        string $description,
        string $startCol,
        string $endCol,
        int $startRow,
        string $bgColor
    ): void {
        // Title (2 rows)
        $titleRange = "{$startCol}{$startRow}:{$endCol}" . ($startRow + 1);
        $sheet->mergeCells($titleRange);
        $sheet->setCellValue($startCol . $startRow, $title);

        $sheet->getStyle($titleRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => $bgColor],
            ],
        ]);

        // Description (3 rows)
        $descStart = $startRow + 2;
        $descEnd   = $startRow + 4;
        $descRange = "{$startCol}{$descStart}:{$endCol}{$descEnd}";

        $sheet->mergeCells($descRange);
        $sheet->setCellValue($startCol . $descStart, $description);

        $sheet->getStyle($descRange)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrapText'   => true,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => $bgColor],
            ],
        ]);
    }

    /**
     * Convert column number to Excel letter (1 = A, 2 = B, etc.)
     */
    protected function getColumnLetter(int $columnNumber): string
    {
        $letter = '';
        while ($columnNumber > 0) {
            $mod = ($columnNumber - 1) % 26;
            $letter = chr(65 + $mod) . $letter;
            $columnNumber = (int)(($columnNumber - $mod) / 26);
        }
        return $letter;
    }

    /**
     * Sanitize sheet name to comply with Excel rules
     * - Max 31 characters
     * - Cannot contain: \ / * ? : [ ]
     */
    protected function sanitizeSheetName(string $name): string
    {
        // Remove invalid characters using str_replace (avoids regex escaping issues)
        $invalidChars = ['\\', '/', '*', '?', ':', '[', ']'];
        $sanitized = str_replace($invalidChars, '', $name);

        // Truncate to max 31 characters
        if (mb_strlen($sanitized) > 31) {
            $sanitized = mb_substr($sanitized, 0, 31);
        }

        // If empty after sanitization, use default
        if (empty(trim($sanitized))) {
            $sanitized = 'Data';
        }

        return $sanitized;
    }

    /**
     * Get suggested filename
     */
    public function getFileName(): string
    {
        return 'Template_Data.ods';
    }


    // =================================================================
    // SETTERS for customization
    // =================================================================

    public function setNamaProduk(string $namaProduk): self
    {
        $this->namaProduk = $namaProduk;
        return $this;
    }

    public function setBatchSize(string $batchSize): self
    {
        $this->batchSize = $batchSize;
        return $this;
    }

    public function setKodeBatch(array $kodeBatch): self
    {
        $this->kodeBatch = $kodeBatch;
        return $this;
    }

    public function setParameterName(string $parameterName): self
    {
        $this->parameterName = $parameterName;
        return $this;
    }

    public function setSatuan(string $satuan): self
    {
        $this->satuan = $satuan;
        return $this;
    }

    public function setRowCount(int $rowCount): self
    {
        $this->rowCount = $rowCount;
        return $this;
    }

    public function setColumnsPerBatch(int $columnsPerBatch): self
    {
        $this->columnsPerBatch = $columnsPerBatch;
        return $this;
    }

    /**
     * Set sheet parameters for multi-sheet generation
     * Each entry should be array with 'name' and optionally 'satuan'
     */
    public function setSheetParameters(array $sheetParameters): self
    {
        $this->sheetParameters = $sheetParameters;
        return $this;
    }
}
