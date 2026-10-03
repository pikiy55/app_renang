<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Event;
use App\Models\Pendaftaran;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function __construct(private AuditService $audit) {}

    /**
     * Export semua pendaftaran event menjadi .xlsx multi-sheet per klub (FR-13).
     */
    public function pendaftaran(Event $event): StreamedResponse
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->removeSheetByIndex(0); // Hapus sheet default

        // Ambil semua pendaftaran per klub (user)
        $pendaftaranPerKlub = Pendaftaran::where('event_id', $event->id)
            ->with(['user', 'kelompokUmur', 'nomorLomba'])
            ->get()
            ->groupBy('user_id');

        if ($pendaftaranPerKlub->isEmpty()) {
            return back()->with('error', 'Belum ada data pendaftaran untuk event ini.');
        }

        $headers = ['No', 'Klub', 'Nama Atlet', 'Tgl Lahir', 'Jenis Kelamin', 'KU', 'Nomor Lomba', 'Limit Waktu', 'Status'];

        // Helper: tulis satu sheet berisi daftar pendaftaran
        $tulisSheet = function ($sheet, $rows) use ($headers) {
            foreach ($headers as $col => $header) {
                $sheet->setCellValue([$col + 1, 1], $header);
            }

            $headerRange = 'A1:I1';
            $sheet->getStyle($headerRange)->getFont()->setBold(true);
            $sheet->getStyle($headerRange)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('4472C4');
            $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');
            $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            foreach ($rows->values() as $idx => $p) {
                $row = $idx + 2;
                $sheet->setCellValue([1, $row], $idx + 1);
                $sheet->setCellValue([2, $row], $p->user->nama_klub ?? ('Klub ' . $p->user_id));
                $sheet->setCellValue([3, $row], $p->nama_atlet);
                $sheet->setCellValue([4, $row], $p->tanggal_lahir?->format('d/m/Y'));
                $sheet->setCellValue([5, $row], ucfirst((string) $p->jenis_kelamin));
                $sheet->setCellValue([6, $row], $p->kelompokUmur->nama_ku ?? '-');
                $sheet->setCellValue([7, $row], $p->nomorLomba->nama_nomor ?? '-');
                $sheet->setCellValue([8, $row], $p->limit_waktu ?? '-');
                $sheet->setCellValue([9, $row], $p->status_waktu);
            }

            foreach (range('A', 'I') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
        };

        // Sheet pertama: rekap SEMUA pendaftaran event
        $semua = $pendaftaranPerKlub->flatten(1);
        $sheetSemua = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Semua Pendaftaran');
        $spreadsheet->addSheet($sheetSemua);
        $tulisSheet($sheetSemua, $semua);

        // Sheet berikutnya: satu sheet per klub
        $judulTerpakai = ['Semua Pendaftaran'];
        foreach ($pendaftaranPerKlub as $userId => $pendaftaran) {
            $namaKlub = $pendaftaran->first()->user->nama_klub ?? 'Klub ' . $userId;

            // Maks 31 karakter & tanpa karakter terlarang; pastikan unik
            $base  = substr(preg_replace('/[\\\\\/\?\*\[\]:]/', '-', $namaKlub), 0, 28);
            $judul = $base;
            $n     = 2;
            while (in_array($judul, $judulTerpakai, true)) {
                $judul = $base . ' ' . $n++;
            }
            $judulTerpakai[] = $judul;

            $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $judul);
            $spreadsheet->addSheet($sheet);
            $tulisSheet($sheet, $pendaftaran);
        }

        $spreadsheet->setActiveSheetIndex(0);


        // Log audit
        $this->audit->log(Auth::user(), 'export', $event, [], [
            'event_id'   => $event->id,
            'klub_count' => $pendaftaranPerKlub->count(),
        ]);

        // Stream file ke browser
        $filename = 'pendaftaran_' . \Str::slug($event->nama_event) . '_' . now()->format('Ymd_His') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Override admin untuk edit data pendaftaran yang terkunci (FR-14).
     */
    public function overrideUpdate(Request $request, Pendaftaran $pendaftaran)
    {
        $before = $pendaftaran->toArray();

        $data = $request->validate([
            'limit_waktu'  => ['nullable', 'string'],
            'status_waktu' => ['required', 'in:normal,NT'],
        ]);

        $pendaftaran->update($data);

        // Catat di audit log
        $this->audit->log(Auth::user(), 'edit', $pendaftaran, $before, $pendaftaran->fresh()->toArray());

        return redirect()->back()->with('success', 'Data berhasil dioverride. Perubahan tercatat di audit log.');
    }

    /**
     * Override admin untuk hapus data pendaftaran yang terkunci (FR-14).
     */
    public function overrideDelete(Pendaftaran $pendaftaran)
    {
        $before = $pendaftaran->toArray();

        // Catat di audit log sebelum hapus
        $this->audit->log(Auth::user(), 'delete', $pendaftaran, $before, []);
        $pendaftaran->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus (override admin). Tercatat di audit log.');
    }

    /**
     * Tampilkan audit log.
     */
    public function auditLog(Request $request)
    {
        $logs = AuditLog::with('user')
            ->latest()
            ->paginate(30);

        return view('admin.audit-log', compact('logs'));
    }
}
