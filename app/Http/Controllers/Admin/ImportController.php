<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterRiwayatAtlet;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ImportController extends Controller
{
    /**
     * Pemetaan alias gaya renang yang umum diketik user ke nilai enum DB.
     */
    private array $gayaAliases = [
        'bebas'             => 'bebas',
        'gaya_bebas'        => 'bebas',
        'freestyle'         => 'bebas',
        'dada'              => 'dada',
        'gaya_dada'         => 'dada',
        'breaststroke'      => 'dada',
        'punggung'          => 'punggung',
        'gaya_punggung'     => 'punggung',
        'backstroke'        => 'punggung',
        'kupu'              => 'kupu',
        'kupu-kupu'         => 'kupu',
        'kupu_kupu'         => 'kupu',
        'butterfly'         => 'kupu',
        'gaya_kupu'         => 'kupu',
        'ganti_perorangan'  => 'ganti_perorangan',
        'individual_medley' => 'ganti_perorangan',
        'im'                => 'ganti_perorangan',
        'ganti_estafet'     => 'ganti_estafet',
        'medley_relay'      => 'ganti_estafet',
    ];

    /**
     * Form import riwayat atlet dari Excel (FR-12).
     */
    public function showForm()
    {
        $clubs = User::where('role', 'perkumpulan')->where('is_active', true)->get();
        return view('admin.import.riwayat', compact('clubs'));
    }

    /**
     * Download template Excel kosong sesuai format import.
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Riwayat Atlet');

        // --- Header ---
        $headers = [
            'A1' => 'Nama Atlet',
            'B1' => 'Tanggal Lahir',
            'C1' => 'Jenis Kelamin',
            'D1' => 'Jarak (meter)',
            'E1' => 'Gaya',
            'F1' => 'Limit Waktu (MM:SS.ss)',
        ];
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style header
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F46E5']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'C7D2FE']]],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(28);

        // --- Contoh data ---
        $examples = [
            ['Budi Santoso', '2005-08-15', 'putra',  100, 'bebas',             '01:05.30'],
            ['Siti Rahayu',  '2007-03-22', 'putri',   50, 'dada',              '00:38.45'],
            ['Andi Wijaya',  '2006-11-10', 'putra',  200, 'kupu',              '02:20.00'],
            ['Dewi Lestari', '2008-07-01', 'putri',  100, 'punggung',          '01:15.80'],
            ['Raka Pratama', '2005-01-30', 'putra',  200, 'ganti_perorangan',  '02:30.50'],
        ];
        foreach ($examples as $i => $row) {
            $rowNum = $i + 2;
            $sheet->fromArray($row, null, "A{$rowNum}");
        }

        // Style contoh data
        $sheet->getStyle('A2:F6')->applyFromArray([
            'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EEF2FF']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'C7D2FE']]],
        ]);

        // --- Auto-width kolom ---
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // --- Catatan keterangan gaya ---
        $sheet->setCellValue('H1', 'Nilai gaya yang valid:');
        $sheet->getStyle('H1')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => '4F46E5']]]);
        $validGaya = ['bebas', 'dada', 'punggung', 'kupu', 'ganti_perorangan', 'ganti_estafet'];
        foreach ($validGaya as $i => $g) {
            $sheet->setCellValue('H' . ($i + 2), $g);
        }
        $sheet->setCellValue('H9', 'Jenis kelamin: putra / putri');
        $sheet->getStyle('H9')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => '4F46E5']]]);

        $writer = new Xlsx($spreadsheet);
        $filename = 'template_import_riwayat_atlet.xlsx';

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    /**
     * Proses import file Excel ke master_riwayat_atlet.
     *
     * Format kolom Excel yang diharapkan:
     * | nama_atlet | tanggal_lahir | jenis_kelamin | jarak | gaya | limit_waktu |
     */
    public function riwayat(Request $request)
    {
        $request->validate([
            'file'    => ['required', 'file', 'mimes:xlsx,xls', 'max:10240'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $file        = $request->file('file');
        $userId      = $request->integer('user_id');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet       = $spreadsheet->getActiveSheet();

        // Ambil rows dengan keep formula value = true
        $rows = $sheet->toArray(null, true, true, true);

        // Lewati baris header (baris pertama)
        $dataRows = array_slice($rows, 1);

        $imported = 0;
        $errors   = [];

        foreach ($dataRows as $index => $row) {
            $rowNum = $index + 2;

            try {
                $namaAtlet    = trim($row['A'] ?? '');
                $tanggalLahir = $this->parseExcelDate($row['B'] ?? null, $sheet, 'B' . $rowNum);
                $jenisKelamin = strtolower(trim($row['C'] ?? ''));
                $jarak        = (int) ($row['D'] ?? 0);
                $gayaRaw      = strtolower(trim(str_replace([' ', '-'], ['_', '-'], $row['E'] ?? '')));
                $gaya         = $this->normalizeGaya($gayaRaw);
                $limitWaktu   = trim($row['F'] ?? '');

                // Skip baris benar-benar kosong
                if (empty($namaAtlet) && empty($limitWaktu)) {
                    continue;
                }

                // Validasi field wajib
                if (empty($namaAtlet)) {
                    $errors[] = "Baris {$rowNum}: Nama atlet tidak boleh kosong.";
                    continue;
                }
                if (empty($limitWaktu)) {
                    $errors[] = "Baris {$rowNum}: Limit waktu tidak boleh kosong.";
                    continue;
                }

                if ($gaya === null) {
                    $errors[] = "Baris {$rowNum}: Gaya '{$gayaRaw}' tidak valid. Gunakan: bebas, dada, punggung, kupu, ganti_perorangan, atau ganti_estafet.";
                    continue;
                }

                if (! in_array($jenisKelamin, ['putra', 'putri'])) {
                    $errors[] = "Baris {$rowNum}: Jenis kelamin '{$jenisKelamin}' tidak valid. Gunakan: putra atau putri.";
                    continue;
                }

                if ($jarak <= 0) {
                    $errors[] = "Baris {$rowNum}: Jarak harus berupa angka positif (dalam meter).";
                    continue;
                }

                MasterRiwayatAtlet::updateOrCreate(
                    [
                        'user_id'    => $userId,
                        'nama_atlet' => $namaAtlet,
                        'jarak'      => $jarak,
                        'gaya'       => $gaya,
                    ],
                    [
                        'tanggal_lahir' => $tanggalLahir ?: null,
                        'jenis_kelamin' => $jenisKelamin,
                        'limit_waktu'   => $limitWaktu,
                    ]
                );

                $imported++;
            } catch (\Throwable $e) {
                $errors[] = "Baris {$rowNum}: " . $e->getMessage();
            }
        }

        $message = "Import selesai: {$imported} data berhasil diimport.";
        if (count($errors) > 0) {
            $message .= ' ' . count($errors) . ' baris gagal.';
        }

        return redirect()->route('admin.import.form')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }

    /**
     * Parse nilai tanggal dari sel Excel.
     * Excel menyimpan tanggal sebagai angka serial (float), bukan string.
     */
    private function parseExcelDate(mixed $value, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet, string $cellRef): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Jika berupa angka → kemungkinan serial date Excel
        if (is_numeric($value)) {
            try {
                $cell = $sheet->getCell($cellRef);
                if (ExcelDate::isDateTime($cell)) {
                    $dateTime = ExcelDate::excelToDateTimeObject((float) $value);
                    return $dateTime->format('Y-m-d');
                }
                // Angka biasa yang bukan tanggal, kembalikan apa adanya
                return (string) $value;
            } catch (\Throwable) {
                // Fallback: coba konversi langsung
                try {
                    $dateTime = ExcelDate::excelToDateTimeObject((float) $value);
                    return $dateTime->format('Y-m-d');
                } catch (\Throwable) {
                    return (string) $value;
                }
            }
        }

        // Jika string, coba parse berbagai format umum
        $value = trim((string) $value);
        $formats = [
            'd/m/Y', 'd-m-Y', 'Y-m-d', 'd/m/y', 'd-m-y',
            'Y/m/d', 'm/d/Y', 'm-d-Y',
        ];
        foreach ($formats as $format) {
            $dt = \DateTime::createFromFormat($format, $value);
            if ($dt !== false) {
                return $dt->format('Y-m-d');
            }
        }

        // Fallback strtotime
        $ts = strtotime($value);
        if ($ts !== false) {
            return date('Y-m-d', $ts);
        }

        return $value; // Kembalikan apa adanya, biarkan DB validasi
    }

    /**
     * Normalisasi nama gaya ke nilai enum yang valid.
     */
    private function normalizeGaya(string $gaya): ?string
    {
        $gaya = strtolower(trim($gaya));
        return $this->gayaAliases[$gaya] ?? null;
    }
}
