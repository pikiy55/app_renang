<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use App\Models\KelompokUmur;
use App\Models\NomorLomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(StoreEventRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->safe()->only([
                'nama_event', 'lokasi', 'tanggal_mulai',
                'tanggal_selesai', 'deadline_pendaftaran', 'is_active',
            ]);

            // Upload file juknis jika ada
            if ($request->hasFile('file_juknis')) {
                $data['file_juknis'] = $request->file('file_juknis')
                    ->store('juknis', 'public');
            }

            $event = Event::create($data);
            $this->syncKelompokUmur($event, $request->input('ku', []));
        });

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dibuat.');
    }

    public function show(Event $event)
    {
        $event->load('kelompokUmur.nomorLomba');
        $totalPendaftaran = $event->pendaftaran()->count();
        $totalKlub        = $event->pendaftaran()->distinct('user_id')->count('user_id');

        $pendaftaran = $event->pendaftaran()
            ->with(['user', 'kelompokUmur', 'nomorLomba'])
            ->latest()
            ->paginate(20);

        return view('admin.events.show', compact('event', 'totalPendaftaran', 'totalKlub', 'pendaftaran'));
    }

    public function edit(Event $event)
    {
        $event->load('kelompokUmur.nomorLomba');
        return view('admin.events.edit', compact('event'));
    }

    public function update(StoreEventRequest $request, Event $event)
    {
        DB::transaction(function () use ($request, $event) {
            $data = $request->safe()->only([
                'nama_event', 'lokasi', 'tanggal_mulai',
                'tanggal_selesai', 'deadline_pendaftaran', 'is_active',
            ]);

            // Upload file juknis baru jika ada, hapus yang lama
            if ($request->hasFile('file_juknis')) {
                if ($event->file_juknis) {
                    Storage::disk('public')->delete($event->file_juknis);
                }
                $data['file_juknis'] = $request->file('file_juknis')
                    ->store('juknis', 'public');
            }

            // Hapus file juknis jika admin mencentang hapus
            if ($request->boolean('hapus_juknis') && $event->file_juknis) {
                Storage::disk('public')->delete($event->file_juknis);
                $data['file_juknis'] = null;
            }

            $event->update($data);
            $this->syncKelompokUmur($event, $request->input('ku', []));
        });

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        // Hapus file juknis dari storage jika ada
        if ($event->file_juknis) {
            Storage::disk('public')->delete($event->file_juknis);
        }
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus.');
    }

    public function downloadJuknis(Event $event)
    {
        if (!$event->file_juknis || !Storage::disk('public')->exists($event->file_juknis)) {
            abort(404, 'File juknis tidak ditemukan.');
        }

        $ext      = pathinfo($event->file_juknis, PATHINFO_EXTENSION);
        $filename = 'Juknis_' . str_replace(' ', '_', $event->nama_event) . '.' . $ext;

        return Storage::disk('public')->download($event->file_juknis, $filename);
    }

    // ─── Private Helpers ─────────────────────────────────────────────

    /**
     * Sync Kelompok Umur beserta Nomor Lomba dari form data.
     * - KU dengan 'id' → update
     * - KU tanpa 'id'  → create
     * - KU lama yang tidak ada di form → delete
     */
    private function syncKelompokUmur(Event $event, array $kuData): void
    {
        $submittedKuIds = collect($kuData)
            ->pluck('id')
            ->filter()
            ->toArray();

        // Hapus KU yang sudah tidak ada di form (beserta nomor lombanya via cascade)
        $event->kelompokUmur()
            ->whereNotIn('id', $submittedKuIds)
            ->delete();

        foreach ($kuData as $kuItem) {
            $kuAttributes = [
                'nama_ku'  => $kuItem['nama_ku'],
                'usia_min' => $kuItem['usia_min'] ?? null,
                'usia_max' => $kuItem['usia_max'] ?? null,
            ];

            if (!empty($kuItem['id'])) {
                // Update existing KU
                $ku = KelompokUmur::find($kuItem['id']);
                if ($ku && $ku->event_id === $event->id) {
                    $ku->update($kuAttributes);
                }
            } else {
                // Create new KU
                $ku = $event->kelompokUmur()->create($kuAttributes);
            }

            // Sync Nomor Lomba for this KU
            if ($ku) {
                $this->syncNomorLomba($ku, $kuItem['nomor'] ?? []);
            }
        }
    }

    /**
     * Sync Nomor Lomba di bawah satu Kelompok Umur.
     */
    private function syncNomorLomba(KelompokUmur $ku, array $nomorData): void
    {
        $submittedNomorIds = collect($nomorData)
            ->pluck('id')
            ->filter()
            ->toArray();

        // Hapus nomor lomba yang sudah tidak ada di form
        $ku->nomorLomba()
            ->whereNotIn('id', $submittedNomorIds)
            ->delete();

        foreach ($nomorData as $nomorItem) {
            $nomorAttributes = [
                'nama_nomor'    => $nomorItem['nama_nomor'],
                'jarak'         => $nomorItem['jarak'],
                'gaya'          => $nomorItem['gaya'],
                'jenis_kelamin' => $nomorItem['jenis_kelamin'],
            ];

            if (!empty($nomorItem['id'])) {
                $nomor = NomorLomba::find($nomorItem['id']);
                if ($nomor && $nomor->kelompok_umur_id === $ku->id) {
                    $nomor->update($nomorAttributes);
                }
            } else {
                $ku->nomorLomba()->create($nomorAttributes);
            }
        }
    }
}
