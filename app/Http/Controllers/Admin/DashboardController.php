<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Event;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Ringkasan admin: KPI, tren pendaftaran 14 hari, event mendatang,
     * klub teraktif, dan aktivitas audit terbaru.
     */
    public function index(): View
    {
        $now = now();

        // --- KPI ---
        $totalPendaftaran = Pendaftaran::count();
        $pendaftaranMingguIni = Pendaftaran::where('created_at', '>=', $now->copy()->subDays(7))->count();
        $pendaftaranMingguLalu = Pendaftaran::whereBetween('created_at', [
            $now->copy()->subDays(14), $now->copy()->subDays(7),
        ])->count();

        $stats = [
            'events_total'      => Event::count(),
            'events_active'     => Event::where('is_active', true)->count(),
            'events_open'       => Event::where('is_active', true)
                                        ->where('deadline_pendaftaran', '>', $now)->count(),
            'clubs_total'       => User::where('role', 'perkumpulan')->count(),
            'clubs_active'      => User::where('role', 'perkumpulan')->where('is_active', true)->count(),
            'pendaftaran_total' => $totalPendaftaran,
            'pendaftaran_week'  => $pendaftaranMingguIni,
            'pendaftaran_trend' => $pendaftaranMingguLalu > 0
                ? round((($pendaftaranMingguIni - $pendaftaranMingguLalu) / $pendaftaranMingguLalu) * 100)
                : null,
            'atlet_unik'        => DB::query()->fromSub(
                Pendaftaran::select('user_id', 'nama_atlet')->distinct(), 'atlet'
            )->count(),
            'nt_count'          => Pendaftaran::where('status_waktu', 'NT')->count(),
        ];

        // --- Tren pendaftaran 14 hari terakhir ---
        $start = $now->copy()->subDays(13)->startOfDay();
        $daily = Pendaftaran::where('created_at', '>=', $start)
            ->selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal');

        $trend = collect(range(0, 13))->map(function (int $i) use ($start, $daily) {
            $date = $start->copy()->addDays($i)->locale('id');
            return [
                'label' => $date->translatedFormat('d M'),
                'day'   => $date->translatedFormat('D'),
                'total' => (int) ($daily[$date->toDateString()] ?? 0),
            ];
        });

        // --- Komposisi gender (data memakai 'putra'/'putri'; 'L'/'P' juga didukung) ---
        $genderRaw = Pendaftaran::selectRaw('LOWER(jenis_kelamin) as jk, COUNT(*) as total')
            ->groupBy('jk')
            ->pluck('total', 'jk');
        $gender = [
            'L' => (int) (($genderRaw['putra'] ?? 0) + ($genderRaw['l'] ?? 0)),
            'P' => (int) (($genderRaw['putri'] ?? 0) + ($genderRaw['p'] ?? 0)),
        ];

        // --- Event mendatang / berjalan ---
        $upcomingEvents = Event::withCount('pendaftaran')
            ->where('tanggal_selesai', '>=', $now->copy()->startOfDay())
            ->orderBy('tanggal_mulai')
            ->limit(5)
            ->get();

        // --- Klub teraktif ---
        $topClubs = User::where('role', 'perkumpulan')
            ->withCount('pendaftaran')
            ->orderByDesc('pendaftaran_count')
            ->limit(5)
            ->get();

        // --- Aktivitas terbaru ---
        $recentActivities = AuditLog::with('user:id,name,nama_klub')
            ->latest()
            ->limit(6)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'trend', 'gender', 'upcomingEvents', 'topClubs', 'recentActivities'
        ));
    }
}
