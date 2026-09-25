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

        $data              = $request->validated();
        $nomorLombaIds     = $data['nomor_lomba_ids'];
        $namaAtlet         = $data['nama_atlet'];
        $limitWaktuPerNomor = $data['limit_waktu_per_nomor'] ?? [];
        $daftarNomor       = [];

        foreach ($nomorLombaIds as $nomorLombaId) {
            $nomorLomba = \App\Models\NomorLomba::findOrFail($nomorLombaId);

            // Cek apakah pelatih mengisi waktu untuk nomor ini
            $inputWaktu = isset($limitWaktuPerNomor[$nomorLombaId]) && $limitWaktuPerNomor[$nomorLombaId] !== ''
                ? $limitWaktuPerNomor[$nomorLombaId]
                : null;

            // Jika tidak diisi pelatih, coba auto-match dari riwayat
            $autoWaktu = null;
            if (!$inputWaktu) {
                $autoWaktu = $this->autoMatch->matchWaktu(
                    $namaAtlet,
                    $nomorLomba->jarak,
                    $nomorLomba->gaya,
                    Auth::id()
                );
            }

            $limitWaktu  = $inputWaktu ?? $autoWaktu;
            $statusWaktu = $limitWaktu ? 'normal' : 'NT';

            Pendaftaran::create([
                'event_id'         => $event->id,
                'user_id'          => Auth::id(),
                'kelompok_umur_id' => $data['kelompok_umur_id'],
                'nomor_lomba_id'   => $nomorLombaId,
                'nama_atlet'       => $namaAtlet,
                'tanggal_lahir'    => $data['tanggal_lahir'],
                'jenis_kelamin'    => $data['jenis_kelamin'],
                'limit_waktu'      => $limitWaktu,
                'status_waktu'     => $statusWaktu,
                'is_locked'        => false,
            ]);

            $daftarNomor[] = "{$nomorLomba->nama_nomor} ({$nomorLomba->jarak}m {$nomorLomba->gaya})";
        }

        $jumlah     = count($nomorLombaIds);
        $listNomor  = implode(', ', $daftarNomor);
        $successMsg = "Atlet {$namaAtlet} berhasil didaftarkan ke {$jumlah} nomor lomba: {$listNomor}.";

        return redirect()->route('perkumpulan.dashboard')->with('success', $successMsg);
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
