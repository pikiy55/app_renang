<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\KelompokUmur;
use App\Models\NomorLomba;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::updateOrCreate(
            ['nama_event' => 'Kejuaraan Renang Daerah 2026'],
            [
                'lokasi'               => 'Kolam Renang Stadion Utama',
                'tanggal_mulai'        => '2026-10-15',
                'tanggal_selesai'      => '2026-10-17',
                'deadline_pendaftaran' => '2026-10-10 23:59:59',
                'is_active'            => true,
            ]
        );

        // Kelompok Umur
        $kuList = [
            ['nama_ku' => 'KU I',   'usia_min' => 8,  'usia_max' => 10],
            ['nama_ku' => 'KU II',  'usia_min' => 11, 'usia_max' => 12],
            ['nama_ku' => 'KU III', 'usia_min' => 13, 'usia_max' => 14],
            ['nama_ku' => 'Senior', 'usia_min' => 15, 'usia_max' => null],
        ];

        $gayaByKU = [
            'KU I'   => [
                ['nama_nomor' => '50m Gaya Bebas Putra',    'jarak' => 50,  'gaya' => 'bebas',    'jenis_kelamin' => 'putra'],
                ['nama_nomor' => '50m Gaya Bebas Putri',    'jarak' => 50,  'gaya' => 'bebas',    'jenis_kelamin' => 'putri'],
                ['nama_nomor' => '50m Gaya Dada Putra',     'jarak' => 50,  'gaya' => 'dada',     'jenis_kelamin' => 'putra'],
                ['nama_nomor' => '50m Gaya Dada Putri',     'jarak' => 50,  'gaya' => 'dada',     'jenis_kelamin' => 'putri'],
            ],
            'KU II'  => [
                ['nama_nomor' => '100m Gaya Bebas Putra',   'jarak' => 100, 'gaya' => 'bebas',    'jenis_kelamin' => 'putra'],
                ['nama_nomor' => '100m Gaya Bebas Putri',   'jarak' => 100, 'gaya' => 'bebas',    'jenis_kelamin' => 'putri'],
                ['nama_nomor' => '100m Gaya Punggung Putra','jarak' => 100, 'gaya' => 'punggung', 'jenis_kelamin' => 'putra'],
                ['nama_nomor' => '100m Gaya Punggung Putri','jarak' => 100, 'gaya' => 'punggung', 'jenis_kelamin' => 'putri'],
            ],
            'KU III' => [
                ['nama_nomor' => '200m Gaya Bebas Putra',   'jarak' => 200, 'gaya' => 'bebas',    'jenis_kelamin' => 'putra'],
                ['nama_nomor' => '200m Gaya Bebas Putri',   'jarak' => 200, 'gaya' => 'bebas',    'jenis_kelamin' => 'putri'],
                ['nama_nomor' => '100m Gaya Kupu Putra',    'jarak' => 100, 'gaya' => 'kupu',     'jenis_kelamin' => 'putra'],
                ['nama_nomor' => '100m Gaya Kupu Putri',    'jarak' => 100, 'gaya' => 'kupu',     'jenis_kelamin' => 'putri'],
            ],
            'Senior' => [
                ['nama_nomor' => '400m Gaya Bebas Putra',   'jarak' => 400, 'gaya' => 'bebas',    'jenis_kelamin' => 'putra'],
                ['nama_nomor' => '400m Gaya Bebas Putri',   'jarak' => 400, 'gaya' => 'bebas',    'jenis_kelamin' => 'putri'],
                ['nama_nomor' => '200m Gaya Ganti Putra',   'jarak' => 200, 'gaya' => 'ganti_perorangan', 'jenis_kelamin' => 'putra'],
                ['nama_nomor' => '200m Gaya Ganti Putri',   'jarak' => 200, 'gaya' => 'ganti_perorangan', 'jenis_kelamin' => 'putri'],
            ],
        ];

        foreach ($kuList as $kuData) {
            $ku = KelompokUmur::updateOrCreate(
                ['event_id' => $event->id, 'nama_ku' => $kuData['nama_ku']],
                ['usia_min' => $kuData['usia_min'], 'usia_max' => $kuData['usia_max']]
            );

            foreach ($gayaByKU[$kuData['nama_ku']] as $nomorData) {
                NomorLomba::updateOrCreate(
                    ['kelompok_umur_id' => $ku->id, 'nama_nomor' => $nomorData['nama_nomor']],
                    $nomorData
                );
            }
        }
    }
}
