<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\MasterRiwayatAtlet;
use App\Models\NomorLomba;
use App\Models\Pendaftaran;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Membuat 20 perkumpulan x 10 atlet = 200 peserta
 * pada "Kejuaraan Renang Daerah 2026".
 * Jalankan: php artisan db:seed --class=PesertaDemoSeeder
 */
class PesertaDemoSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::where('nama_event', 'Kejuaraan Renang Daerah 2026')->first();
        if (! $event) {
            $this->call(EventSeeder::class);
            $event = Event::where('nama_event', 'Kejuaraan Renang Daerah 2026')->firstOrFail();
        }

        $event->load('kelompokUmur.nomorLomba');
        $refDate = Carbon::parse($event->tanggal_mulai);

        mt_srand(2026);

        // Bersihkan data demo sebelumnya agar seeder bisa dijalankan ulang (selalu 200 peserta)
        $demoIds = User::where('email', 'like', 'klub%@renang.test')->pluck('id');
        Pendaftaran::where('event_id', $event->id)->whereIn('user_id', $demoIds)->delete();
        MasterRiwayatAtlet::whereIn('user_id', $demoIds)->delete();

        $clubNames = [
            'Tirta Kencana', 'Dolphin', 'Aquatic Jaya', 'Hiu Perkasa', 'Samudra',
            'Barracuda', 'Neptunus', 'Mutiara Biru', 'Bintang Laut', 'Ikan Terbang',
            'Ombak Muda', 'Marlin', 'Piranha', 'Lumba-Lumba', 'Arwana',
            'Tirta Prima', 'Orca', 'Pesut Mahakam', 'Torpedo', 'Naga Air',
        ];

        $putra = ['Ahmad', 'Budi', 'Cahyo', 'Dimas', 'Eko', 'Fajar', 'Galih', 'Hendra', 'Irfan', 'Joko',
                  'Kevin', 'Lucky', 'Rizky', 'Naufal', 'Oscar', 'Putra', 'Raka', 'Satria', 'Taufik', 'Yoga'];
        $putri = ['Aulia', 'Bunga', 'Citra', 'Dewi', 'Eka', 'Fitri', 'Gita', 'Hana', 'Intan', 'Jasmine',
                  'Kirana', 'Layla', 'Maya', 'Nadia', 'Olivia', 'Putri', 'Rani', 'Salsa', 'Tiara', 'Zahra'];
        $belakang = ['Pratama', 'Saputra', 'Wijaya', 'Santoso', 'Kusuma', 'Hidayat', 'Nugroho', 'Permana',
                     'Setiawan', 'Lestari', 'Utami', 'Maharani', 'Ramadhan', 'Firmansyah', 'Anggraini',
                     'Wibowo', 'Hartono', 'Susanto', 'Purnama', 'Gunawan'];

        $used = [];

        foreach ($clubNames as $i => $nama) {
            $n = $i + 1;
            $club = User::updateOrCreate(
                ['email' => "klub{$n}@renang.test"],
                [
                    'name'      => "Klub {$nama}",
                    'password'  => Hash::make('password'),
                    'role'      => 'perkumpulan',
                    'nama_klub' => "Perkumpulan Renang {$nama}",
                    'whatsapp'  => '0812' . str_pad((string) (3000000 + $n * 1111), 8, '0', STR_PAD_LEFT),
                    'is_active' => true,
                ]
            );

            for ($j = 0; $j < 10; $j++) {
                $gender = $j % 2 === 0 ? 'putra' : 'putri';
                $pool   = $gender === 'putra' ? $putra : $putri;

                // nama unik
                do {
                    $namaAtlet = $pool[mt_rand(0, 19)] . ' ' . $belakang[mt_rand(0, 19)];
                } while (isset($used[$namaAtlet]));
                $used[$namaAtlet] = true;

                // umur 8-17 tahun pada hari pertandingan
                $umur = mt_rand(8, 17);
                $lahir = $refDate->copy()->subYears($umur)->subDays(mt_rand(1, 360));

                $ku = $event->kelompokUmur->first(function ($k) use ($umur) {
                    return $umur >= $k->usia_min && ($k->usia_max === null || $umur <= $k->usia_max);
                });
                if (! $ku) {
                    continue;
                }

                $pilihan = $ku->nomorLomba->where('jenis_kelamin', $gender)->values();
                $nomor = $pilihan[mt_rand(0, $pilihan->count() - 1)];

                $nt = mt_rand(1, 100) <= 20;
                $limit = $nt ? null : $this->randomTime($nomor);

                Pendaftaran::firstOrCreate(
                    [
                        'event_id'       => $event->id,
                        'nomor_lomba_id' => $nomor->id,
                        'nama_atlet'     => $namaAtlet,
                    ],
                    [
                        'user_id'          => $club->id,
                        'kelompok_umur_id' => $ku->id,
                        'tanggal_lahir'    => $lahir->toDateString(),
                        'jenis_kelamin'    => $gender,
                        'limit_waktu'      => $limit,
                        'status_waktu'     => $limit ? 'normal' : 'NT',
                        'is_locked'        => false,
                    ]
                );

                if ($limit) {
                    MasterRiwayatAtlet::updateOrCreate(
                        [
                            'user_id'    => $club->id,
                            'nama_atlet' => $namaAtlet,
                            'jarak'      => $nomor->jarak,
                            'gaya'       => $nomor->gaya,
                        ],
                        [
                            'tanggal_lahir' => $lahir->toDateString(),
                            'jenis_kelamin' => $gender,
                            'limit_waktu'   => $limit,
                        ]
                    );
                }
            }
        }
    }

    /** Waktu realistis format MM:SS.ss berdasarkan jarak. */
    private function randomTime(NomorLomba $nomor): string
    {
        $base = ['50' => 38, '100' => 85, '200' => 175, '400' => 380][(string) $nomor->jarak] ?? 60;
        $total = $base + mt_rand(0, (int) ($base * 0.35) * 100) / 100;

        $min = intdiv((int) $total, 60);
        $sec = $total - $min * 60;

        return sprintf('%02d:%05.2f', $min, $sec);
    }
}
