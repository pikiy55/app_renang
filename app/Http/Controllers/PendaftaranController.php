<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\KelompokUmur;
use App\Models\Pendaftaran;
use App\Models\MasterRiwayatAtlet;
use App\Http\Requests\StorePendaftaranRequest;
use App\Http\Requests\UpdatePendaftaranRequest;
use App\Services\AutoMatchService;
use App\Services\DeadlineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller
{
    public function __construct(
        private AutoMatchService $autoMatch,
        private DeadlineService  $deadline,
    ) {}

    /**
     * Daftar event aktif yang bisa diikuti perkumpulan.
     */
    public function dashboard()
    {
        $this->syncPendaftaranToMaster(Auth::id());

        $events = Event::aktif()->with(['kelompokUmur', 'pendaftaran'])->get();

        $totalPendaftaran = Pendaftaran::where('user_id', Auth::id())->count();
        $totalMasterAtlet = MasterRiwayatAtlet::where('user_id', Auth::id())->distinct('nama_atlet')->count('nama_atlet');

        return view('perkumpulan.events', compact('events', 'totalPendaftaran', 'totalMasterAtlet'));
    }

    /**
     * Rekap semua pendaftaran & data atlet perkumpulan — menampilkan seluruh atlet terdaftar pada perkumpulan.
     */
    public function rekap(Request $request)
    {
        $userId = Auth::id();

        // 1. Sinkronisasi data atlet dari riwayat pendaftaran event
        $this->syncPendaftaranToMaster($userId);

        // 2. Data Event Aktif
        $events = Event::aktif()->with(['kelompokUmur', 'pendaftaran'])->get();

        // 3. Data Master Riwayat Atlet milik perkumpulan (Database Atlet Perkumpulan)
        $masterQuery = MasterRiwayatAtlet::where('user_id', $userId);

        if ($request->filled('search_atlet')) {
            $search = $request->string('search_atlet')->trim()->value();
            $masterQuery->where('nama_atlet', 'like', "%{$search}%");
        }

        $allMaster = $masterQuery->orderBy('nama_atlet')->orderBy('jarak')->orderBy('gaya')->get();

        // Ambil data keikutsertaan event pendaftaran milik user untuk tiap atlet
        $pendaftaranPerAtlet = Pendaftaran::where('user_id', $userId)
            ->with(['event', 'nomorLomba', 'kelompokUmur'])
            ->get()
            ->groupBy('nama_atlet');

        // Kelompokkan per nama atlet
        $masterAtletGrouped = $allMaster->groupBy('nama_atlet')->map(function ($items, $nama) use ($pendaftaranPerAtlet) {
            $first = $items->first();
            $validRiwayat = $items->filter(fn($r) => !is_null($r->jarak) && !is_null($r->gaya) && !is_null($r->limit_waktu));
            $pendaftarans = $pendaftaranPerAtlet->get($nama, collect());

            return (object) [
                'id'            => $first->id,
                'nama_atlet'    => $nama,
                'tanggal_lahir' => $first->tanggal_lahir,
                'jenis_kelamin' => $first->jenis_kelamin,
                'total_nomor'   => $validRiwayat->count(),
                'riwayat'       => $validRiwayat->values(),
                'total_event'   => $pendaftarans->unique('event_id')->count(),
                'total_daftar'  => $pendaftarans->count(),
                'pendaftarans'  => $pendaftarans->values(),
            ];
        })->values();

        // 4. Data Pendaftaran Atlet di Event Kejuaraan
        $pendaftaranQuery = Pendaftaran::where('user_id', $userId)
            ->with(['event', 'nomorLomba', 'kelompokUmur'])
            ->latest();

        if ($request->filled('event_id')) {
            $pendaftaranQuery->where('event_id', $request->integer('event_id'));
        }

        if ($request->filled('search_pendaftaran')) {
            $searchPendaftaran = $request->string('search_pendaftaran')->trim()->value();
            $pendaftaranQuery->where('nama_atlet', 'like', "%{$searchPendaftaran}%");
        }

        $myPendaftaran = $pendaftaranQuery->paginate(15, ['*'], 'pendaftaran_page')->withQueryString();

        // 5. Statistik Ringkasan
        $stats = [
            'total_master_atlet'   => $masterAtletGrouped->count(),
            'total_riwayat_waktu'  => $allMaster->whereNotNull('jarak')->whereNotNull('limit_waktu')->count(),
            'total_pendaftaran'    => Pendaftaran::where('user_id', $userId)->count(),
            'total_event_diikuti'  => Pendaftaran::where('user_id', $userId)->distinct('event_id')->count('event_id'),
            'total_event_aktif'    => $events->count(),
        ];

        return view('perkumpulan.dashboard', compact(
            'events',
            'myPendaftaran',
            'masterAtletGrouped',
            'stats'
        ));
    }

    /**
     * Dashboard per-event — menampilkan data pendaftaran atlet milik klub untuk event tertentu.
     */
    public function eventPendaftaran(Event $event)
    {
        $event->load('kelompokUmur');

        $myPendaftaran = Pendaftaran::where('user_id', Auth::id())
            ->where('event_id', $event->id)
            ->with(['nomorLomba', 'kelompokUmur'])
            ->latest()
            ->paginate(20);

        $isDeadlinePassed = $this->deadline->isDeadlinePassed($event);
        $sisaWaktu        = $this->deadline->sisaWaktu($event);

        return view('perkumpulan.halaman-utama', compact('event', 'myPendaftaran', 'isDeadlinePassed', 'sisaWaktu'));
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

        // Ambil daftar pendaftaran milik klub ini untuk event ini
        // (untuk ditampilkan di frontend agar nomor yang sudah terdaftar di-disabled)
        $pendaftaranSudahAda = Pendaftaran::where('event_id', $event->id)
            ->where('user_id', Auth::id())
            ->get(['nama_atlet', 'kelompok_umur_id', 'nomor_lomba_id'])
            ->toArray();

        return view('perkumpulan.pendaftaran.create', compact('event', 'kelompokUmur', 'pendaftaranSudahAda'));
    }

    /**
     * Simpan pendaftaran atlet — auto-approved (FR-10a).
     */
    public function store(StorePendaftaranRequest $request, Event $event)
    {
        if ($this->deadline->isDeadlinePassed($event)) {
            return back()->with('error', 'Deadline pendaftaran sudah berakhir.');
        }

        $data               = $request->validated();
        $nomorLombaIds      = $data['nomor_lomba_ids'];
        $namaAtlet          = $data['nama_atlet'];
        $kelompokUmurId     = $data['kelompok_umur_id'];
        $limitWaktuPerNomor = $data['limit_waktu_per_nomor'] ?? [];
        $daftarNomor        = [];
        $daftarDuplikat     = [];

        foreach ($nomorLombaIds as $nomorLombaId) {
            $nomorLomba = \App\Models\NomorLomba::findOrFail($nomorLombaId);

            // ── Cek duplikat: atlet + event + KU + nomor yang sama ──
            $sudahTerdaftar = Pendaftaran::where('event_id', $event->id)
                ->where('nama_atlet', $namaAtlet)
                ->where('kelompok_umur_id', $kelompokUmurId)
                ->where('nomor_lomba_id', $nomorLombaId)
                ->exists();

            if ($sudahTerdaftar) {
                $daftarDuplikat[] = "{$nomorLomba->nama_nomor} ({$nomorLomba->jarak}m {$nomorLomba->gaya})";
                continue; // Lewati, jangan insert ulang
            }

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
                'kelompok_umur_id' => $kelompokUmurId,
                'nomor_lomba_id'   => $nomorLombaId,
                'nama_atlet'       => $namaAtlet,
                'tanggal_lahir'    => $data['tanggal_lahir'],
                'jenis_kelamin'    => $data['jenis_kelamin'],
                'limit_waktu'      => $limitWaktu,
                'status_waktu'     => $statusWaktu,
                'is_locked'        => false,
            ]);

            // Sync atlet ke master riwayat perkumpulan
            if ($nomorLomba->jarak && $nomorLomba->gaya) {
                MasterRiwayatAtlet::updateOrCreate(
                    [
                        'user_id'    => Auth::id(),
                        'nama_atlet' => trim($namaAtlet),
                        'jarak'      => $nomorLomba->jarak,
                        'gaya'       => $nomorLomba->gaya,
                    ],
                    [
                        'tanggal_lahir' => $data['tanggal_lahir'],
                        'jenis_kelamin' => $data['jenis_kelamin'],
                        'limit_waktu'   => $limitWaktu ?: 'NT',
                    ]
                );
                // Bersihkan placeholder kosong jika ada
                MasterRiwayatAtlet::where('user_id', Auth::id())
                    ->where('nama_atlet', trim($namaAtlet))
                    ->whereNull('jarak')
                    ->delete();
            }

            $daftarNomor[] = "{$nomorLomba->nama_nomor} ({$nomorLomba->jarak}m {$nomorLomba->gaya})";
        }

        // Tidak ada satupun yang berhasil didaftarkan (semua duplikat)
        if (empty($daftarNomor) && !empty($daftarDuplikat)) {
            $listDuplikat = implode(', ', $daftarDuplikat);
            return back()
                ->withInput()
                ->with('error', "Atlet {$namaAtlet} sudah terdaftar di nomor berikut dalam event & KU yang sama: {$listDuplikat}. Tidak ada data baru yang disimpan.");
        }

        // Sebagian berhasil, sebagian duplikat
        $successMsg = '';
        if (!empty($daftarNomor)) {
            $jumlah    = count($daftarNomor);
            $listNomor = implode(', ', $daftarNomor);
            $successMsg .= "Atlet {$namaAtlet} berhasil didaftarkan ke {$jumlah} nomor lomba: {$listNomor}.";
        }
        if (!empty($daftarDuplikat)) {
            $listDuplikat = implode(', ', $daftarDuplikat);
            $successMsg .= " (Dilewati karena sudah terdaftar: {$listDuplikat})";
        }

        return redirect()->route('perkumpulan.event.dashboard', $event)->with('success', $successMsg);
    }

    /**
     * Form edit pendaftaran (FR-10).
     */
    public function edit(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki hak akses untuk data pendaftaran ini.');
        }

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
        if ($pendaftaran->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki hak akses untuk data pendaftaran ini.');
        }

        if ($pendaftaran->isLocked()) {
            return back()->with('error', 'Data sudah terkunci. Tidak bisa diubah.');
        }

        $pendaftaran->update($request->validated());

        if ($pendaftaran->nomorLomba && $pendaftaran->nomorLomba->jarak && $pendaftaran->nomorLomba->gaya) {
            MasterRiwayatAtlet::updateOrCreate(
                [
                    'user_id'    => $pendaftaran->user_id,
                    'nama_atlet' => trim($pendaftaran->nama_atlet),
                    'jarak'      => $pendaftaran->nomorLomba->jarak,
                    'gaya'       => $pendaftaran->nomorLomba->gaya,
                ],
                [
                    'tanggal_lahir' => $pendaftaran->tanggal_lahir,
                    'jenis_kelamin' => $pendaftaran->jenis_kelamin,
                    'limit_waktu'   => $pendaftaran->limit_waktu ?: 'NT',
                ]
            );
        }

        return redirect()->route('perkumpulan.event.dashboard', $pendaftaran->event_id)
            ->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

    /**
     * Hapus pendaftaran (FR-10).
     */
    public function destroy(Pendaftaran $pendaftaran)
    {
        if ($pendaftaran->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki hak akses untuk data pendaftaran ini.');
        }

        if ($pendaftaran->isLocked()) {
            return back()->with('error', 'Data sudah terkunci. Tidak bisa dihapus.');
        }

        $namaAtlet = $pendaftaran->nama_atlet;
        $eventId   = $pendaftaran->event_id;
        $pendaftaran->delete();

        return back()->with('success', "Data pendaftaran {$namaAtlet} berhasil dibatalkan.");
    }

    /**
     * Download file juknis event.
     */
    public function downloadJuknis(Event $event)
    {
        if (!$event->file_juknis || !Storage::disk('public')->exists($event->file_juknis)) {
            abort(404, 'File juknis tidak ditemukan.');
        }

        $ext      = pathinfo($event->file_juknis, PATHINFO_EXTENSION);
        $filename = 'Juknis_' . str_replace(' ', '_', $event->nama_event) . '.' . $ext;

        return Storage::disk('public')->download($event->file_juknis, $filename);
    }

    /**
     * Tambah atlet baru langsung ke perkumpulan (tanpa harus daftar event terlebih dahulu).
     */
    public function storeAtlet(Request $request)
    {
        $validated = $request->validate([
            'nama_atlet'    => ['required', 'string', 'max:255'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'jenis_kelamin' => ['required', 'in:putra,putri'],
            'jarak'         => ['nullable', 'integer', 'min:25'],
            'gaya'          => ['nullable', 'string', 'in:bebas,dada,punggung,kupu,ganti_perorangan,ganti_estafet'],
            'limit_waktu'   => ['nullable', 'string', 'max:20'],
        ], [
            'nama_atlet.required'    => 'Nama atlet wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        ]);

        $userId = Auth::id();
        $nama   = trim($validated['nama_atlet']);

        if (!empty($validated['jarak']) && !empty($validated['gaya'])) {
            MasterRiwayatAtlet::updateOrCreate(
                [
                    'user_id'    => $userId,
                    'nama_atlet' => $nama,
                    'jarak'      => $validated['jarak'],
                    'gaya'       => $validated['gaya'],
                ],
                [
                    'tanggal_lahir' => $validated['tanggal_lahir'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                    'limit_waktu'   => $validated['limit_waktu'] ?: 'NT',
                ]
            );
            // Hapus placeholder kosong jika ada
            MasterRiwayatAtlet::where('user_id', $userId)->where('nama_atlet', $nama)->whereNull('jarak')->delete();
        } else {
            $existing = MasterRiwayatAtlet::where('user_id', $userId)->where('nama_atlet', $nama)->first();
            if ($existing) {
                $existing->update([
                    'tanggal_lahir' => $validated['tanggal_lahir'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                ]);
            } else {
                MasterRiwayatAtlet::create([
                    'user_id'       => $userId,
                    'nama_atlet'    => $nama,
                    'tanggal_lahir' => $validated['tanggal_lahir'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                    'jarak'         => null,
                    'gaya'          => null,
                    'limit_waktu'   => null,
                ]);
            }
        }

        return redirect()->route('perkumpulan.rekap', ['tab' => 'master'])
            ->with('success', "Atlet {$nama} berhasil ditambahkan ke daftar atlet perkumpulan.");
    }

    /**
     * Perbarui data profil atlet (nama, tanggal lahir, jenis kelamin).
     */
    public function updateAtlet(Request $request)
    {
        $validated = $request->validate([
            'old_nama_atlet' => ['required', 'string'],
            'nama_atlet'     => ['required', 'string', 'max:255'],
            'tanggal_lahir'  => ['required', 'date', 'before:today'],
            'jenis_kelamin'  => ['required', 'in:putra,putri'],
        ], [
            'nama_atlet.required'    => 'Nama atlet wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        ]);

        $userId  = Auth::id();
        $oldNama = trim($validated['old_nama_atlet']);
        $newNama = trim($validated['nama_atlet']);

        MasterRiwayatAtlet::where('user_id', $userId)
            ->where('nama_atlet', $oldNama)
            ->update([
                'nama_atlet'    => $newNama,
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
            ]);

        Pendaftaran::where('user_id', $userId)
            ->where('nama_atlet', $oldNama)
            ->update([
                'nama_atlet'    => $newNama,
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
            ]);

        return redirect()->route('perkumpulan.rekap', ['tab' => 'master'])
            ->with('success', "Data atlet {$newNama} berhasil diperbarui.");
    }

    /**
     * Tambah catatan limit waktu baru untuk atlet perkumpulan.
     */
    public function storeRiwayatWaktu(Request $request)
    {
        $validated = $request->validate([
            'nama_atlet'  => ['required', 'string'],
            'jarak'       => ['required', 'integer', 'min:25'],
            'gaya'        => ['required', 'string', 'in:bebas,dada,punggung,kupu,ganti_perorangan,ganti_estafet'],
            'limit_waktu' => ['required', 'string', 'max:20'],
        ], [
            'nama_atlet.required'  => 'Nama atlet wajib dipilih.',
            'jarak.required'       => 'Jarak lomba wajib diisi.',
            'gaya.required'        => 'Gaya renang wajib dipilih.',
            'limit_waktu.required' => 'Limit waktu wajib diisi.',
        ]);

        $userId = Auth::id();
        $nama   = trim($validated['nama_atlet']);

        $atlet = MasterRiwayatAtlet::where('user_id', $userId)->where('nama_atlet', $nama)->first();
        if (!$atlet) {
            return back()->with('error', "Data atlet {$nama} tidak ditemukan.");
        }

        MasterRiwayatAtlet::updateOrCreate(
            [
                'user_id'    => $userId,
                'nama_atlet' => $nama,
                'jarak'      => $validated['jarak'],
                'gaya'       => $validated['gaya'],
            ],
            [
                'tanggal_lahir' => $atlet->tanggal_lahir,
                'jenis_kelamin' => $atlet->jenis_kelamin,
                'limit_waktu'   => $validated['limit_waktu'],
            ]
        );

        // Hapus baris placeholder tanpa jarak jika sudah ada data catatan waktu
        MasterRiwayatAtlet::where('user_id', $userId)->where('nama_atlet', $nama)->whereNull('jarak')->delete();

        return redirect()->route('perkumpulan.rekap', ['tab' => 'master'])
            ->with('success', "Catatan waktu {$validated['jarak']}m {$validated['gaya']} untuk {$nama} berhasil disimpan.");
    }

    /**
     * Hapus satu catatan waktu atlet.
     */
    public function destroyRiwayatWaktu(MasterRiwayatAtlet $riwayat)
    {
        if ($riwayat->user_id !== Auth::id()) {
            abort(403);
        }

        $nama = $riwayat->nama_atlet;
        $totalRows = MasterRiwayatAtlet::where('user_id', Auth::id())->where('nama_atlet', $nama)->count();

        if ($totalRows <= 1) {
            $riwayat->update([
                'jarak'       => null,
                'gaya'        => null,
                'limit_waktu' => null,
            ]);
        } else {
            $riwayat->delete();
        }

        return back()->with('success', "Catatan waktu berhasil dihapus.");
    }

    /**
     * Hapus data atlet dari daftar perkumpulan.
     */
    public function destroyAtlet(Request $request)
    {
        $request->validate(['nama_atlet' => 'required|string']);
        $nama   = trim($request->string('nama_atlet')->value());
        $userId = Auth::id();

        MasterRiwayatAtlet::where('user_id', $userId)->where('nama_atlet', $nama)->delete();

        return redirect()->route('perkumpulan.rekap', ['tab' => 'master'])
            ->with('success', "Atlet {$nama} berhasil dihapus dari daftar perkumpulan.");
    }

    /**
     * Sinkronisasi data atlet dari riwayat pendaftaran event ke MasterRiwayatAtlet.
     */
    private function syncPendaftaranToMaster(int $userId): void
    {
        $pendaftarans = Pendaftaran::where('user_id', $userId)
            ->with('nomorLomba')
            ->get();

        foreach ($pendaftarans as $p) {
            $nama = trim($p->nama_atlet);
            if (!$nama) continue;

            if ($p->nomorLomba && $p->nomorLomba->jarak && $p->nomorLomba->gaya) {
                MasterRiwayatAtlet::updateOrCreate(
                    [
                        'user_id'    => $userId,
                        'nama_atlet' => $nama,
                        'jarak'      => $p->nomorLomba->jarak,
                        'gaya'       => $p->nomorLomba->gaya,
                    ],
                    [
                        'tanggal_lahir' => $p->tanggal_lahir,
                        'jenis_kelamin' => $p->jenis_kelamin,
                        'limit_waktu'   => $p->limit_waktu ?: 'NT',
                    ]
                );
            } else {
                $exists = MasterRiwayatAtlet::where('user_id', $userId)->where('nama_atlet', $nama)->exists();
                if (!$exists) {
                    MasterRiwayatAtlet::create([
                        'user_id'       => $userId,
                        'nama_atlet'    => $nama,
                        'tanggal_lahir' => $p->tanggal_lahir,
                        'jenis_kelamin' => $p->jenis_kelamin,
                        'jarak'         => null,
                        'gaya'          => null,
                        'limit_waktu'   => null,
                    ]);
                }
            }
        }

        // Hapus placeholder kosong untuk atlet yang sudah punya minimal 1 catatan waktu berjarak
        $athletesWithRecords = MasterRiwayatAtlet::where('user_id', $userId)
            ->whereNotNull('jarak')
            ->pluck('nama_atlet')
            ->unique();

        if ($athletesWithRecords->isNotEmpty()) {
            MasterRiwayatAtlet::where('user_id', $userId)
                ->whereIn('nama_atlet', $athletesWithRecords)
                ->whereNull('jarak')
                ->delete();
        }
    }
}
