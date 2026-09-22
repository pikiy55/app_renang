<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterRiwayatAtlet;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportController extends Controller
{
    /**
     * Form import riwayat atlet dari Excel (FR-12).
     */
    public function showForm()
    {
        $clubs = User::where('role', 'perkumpulan')->where('is_active', true)->get();
        return view('admin.import.riwayat', compact('clubs'));
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
            'file'    => ['required', 'file', 'mimes:xlsx,xls'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $file        = $request->file('file');
        $userId      = $request->integer('user_id');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet       = $spreadsheet->getActiveSheet();
        $rows        = $sheet->toArray(null, true, true, true);

        // Lewati baris header (baris pertama)
        $dataRows = array_slice($rows, 1);

        $imported = 0;
        $errors   = [];

        foreach ($dataRows as $index => $row) {
            $rowNum = $index + 2; // +2 karena array dimulai 0 dan kita skip header

            try {
                $namaAtlet    = trim($row['A'] ?? '');
                $tanggalLahir = trim($row['B'] ?? '');
                $jenisKelamin = strtolower(trim($row['C'] ?? ''));
                $jarak        = (int) ($row['D'] ?? 0);
                $gaya         = strtolower(str_replace(' ', '_', trim($row['E'] ?? '')));
                $limitWaktu   = trim($row['F'] ?? '');

                if (empty($namaAtlet) || empty($limitWaktu)) {
                    continue; // Skip baris kosong
                }

                $validGaya = ['bebas', 'dada', 'punggung', 'kupu', 'ganti_perorangan', 'ganti_estafet'];
                if (! in_array($gaya, $validGaya)) {
                    $errors[] = "Baris {$rowNum}: Gaya '{$gaya}' tidak valid.";
                    continue;
                }

                if (! in_array($jenisKelamin, ['putra', 'putri'])) {
                    $errors[] = "Baris {$rowNum}: Jenis kelamin '{$jenisKelamin}' tidak valid.";
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
}
