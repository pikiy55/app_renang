<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\KelompokUmur;
use App\Models\Pendaftaran;
use App\Http\Requests\StorePendaftaranRequest;
use App\Http\Requests\UpdatePendaftaranRequest;
use App\Services\AutoMatchService;
use App\Services\DeadlineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function __construct(
        private AutoMatchService $autoMatch,
        private DeadlineService  $deadline,
    ) {}

    /**
     * Dashboard perkumpulan — daftar event & entri atlet milik klub.
     */
    public function dashboard()
    {
        $events = Event::aktif()->with('kelompokUmur')->get();

        $myPendaftaran = Pendaftaran::where('user_id', Auth::id())
            ->with(['event', 'nomorLomba', 'kelompokUmur'])
            ->latest()
            ->paginate(20);

        return view('perkumpulan.dashboard', compact('events', 'myPendaftaran'));
    }

    /**
     * Form pendaftaran atlet ke event (FR-4 s/d FR-8).
     */
    public function create(Event $event)
    {
        if ($this->deadline->isDeadlinePassed($event)) {
            return back()->with('error', 'Deadline pendaftaran untuk event ini sudah berakhir.');
        }

        $kelompokUmur = KelompokUmur::where('event_id', $event->id)
            ->with('nomorLomba')
            ->get();

        return view('perkumpulan.pendaftaran.create', compact('event', 'kelompokUmur'));
    }

    /**
     * Simpan pendaftaran atlet — auto-approved (FR-10a).
     */
    public function store(StorePendaftaranRequest $request, Event $event)
    {
        if ($this->deadline->isDeadlinePassed($event)) {
            return back()->with('error', 'Deadline pendaftaran sudah berakhir.');
        }

        $data = $request->validated();

        // Auto-match limit waktu dari riwayat
        $nomorLomba = \App\Models\NomorLomba::findOrFail($data['nomor_lomba_id']);
        $limitWaktu = $this->autoMatch->matchWaktu(
            $data['nama_atlet'],
            $nomorLomba->jarak,
            $nomorLomba->gaya,
            Auth::id()
        );

        $statusWaktu = $limitWaktu ? 'normal' : 'NT';

        Pendaftaran::create([
            'event_id'         => $event->id,
            'user_id'          => Auth::id(),
            'kelompok_umur_id' => $data['kelompok_umur_id'],
            'nomor_lomba_id'   => $data['nomor_lomba_id'],
            'nama_atlet'       => $data['nama_atlet'],
            'tanggal_lahir'    => $data['tanggal_lahir'],
            'jenis_kelamin'    => $data['jenis_kelamin'],
            'limit_waktu'      => $data['limit_waktu'] ?? $limitWaktu,
            'status_waktu'     => $data['limit_waktu'] ? 'normal' : $statusWaktu,
            'is_locked'        => false,
        ]);

        return redirect()->route('perkumpulan.dashboard')
            ->with('success', "Atlet {$data['nama_atlet']} berhasil didaftarkan." .
                ($statusWaktu === 'NT' ? ' Status NT (No Time) karena tidak ada riwayat waktu.' : ''));
    }

    /**
     * Form edit pendaftaran (FR-10).
     */
    public function edit(Pendaftaran $pendaftaran)
    {
        $this->authorize('update', $pendaftaran);

        if ($pendaftaran->isLocked()) {
            return back()->with('error', 'Data sudah terkunci karena deadline telah berakhir.');
        }

        $event        = $pendaftaran->event->load('kelompokUmur.nomorLomba');
        $kelompokUmur = $event->kelompokUmur;

        return view('perkumpulan.pendaftaran.edit', compact('pendaftaran', 'event', 'kelompokUmur'));
    }

    /**
     * Update pendaftaran (FR-10).
     */
    public function update(UpdatePendaftaranRequest $request, Pendaftaran $pendaftaran)
    {
        $this->authorize('update', $pendaftaran);

        if ($pendaftaran->isLocked()) {
            return back()->with('error', 'Data sudah terkunci. Tidak bisa diubah.');
        }

        $pendaftaran->update($request->validated());

        return redirect()->route('perkumpulan.dashboard')
            ->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

    /**
     * Hapus pendaftaran (FR-10).
     */
    public function destroy(Pendaftaran $pendaftaran)
    {
        $this->authorize('delete', $pendaftaran);

        if ($pendaftaran->isLocked()) {
            return back()->with('error', 'Data sudah terkunci. Tidak bisa dihapus.');
        }

        $namaAtlet = $pendaftaran->nama_atlet;
        $pendaftaran->delete();

        return redirect()->route('perkumpulan.dashboard')
            ->with('success', "Data pendaftaran {$namaAtlet} berhasil dihapus.");
    }
}
