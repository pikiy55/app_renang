<?php

namespace App\Services;

use App\Models\MasterRiwayatAtlet;

class AutoMatchService
{
    /**
     * Cari limit waktu terbaru atlet berdasarkan jarak dan gaya.
     * Mengembalikan string limit waktu jika ditemukan, null jika tidak ada (→ status NT).
     *
     * @param string $namaAtlet Nama atlet
     * @param int    $jarak     Jarak lomba dalam meter
     * @param string $gaya      Gaya renang
     * @param int    $userId    ID perkumpulan pemilik data
     */
    public function matchWaktu(string $namaAtlet, int $jarak, string $gaya, int $userId): ?string
    {
        $riwayat = MasterRiwayatAtlet::autoMatch($namaAtlet, $jarak, $gaya, $userId)->first();

        return $riwayat?->limit_waktu;
    }

    /**
     * Cari saran nama atlet untuk auto-complete.
     *
     * @param string $keyword Kata kunci pencarian
     * @param int    $userId  ID perkumpulan
     * @return array<int, array{nama_atlet: string, tanggal_lahir: string|null, jenis_kelamin: string}>
     */
    public function suggestNama(string $keyword, int $userId): array
    {
        return MasterRiwayatAtlet::byNama($keyword, $userId)
            ->limit(10)
            ->get()
            ->map(fn ($item) => [
                'nama_atlet'    => $item->nama_atlet,
                'tanggal_lahir' => $item->tanggal_lahir?->format('Y-m-d'),
                'jenis_kelamin' => $item->jenis_kelamin,
            ])
            ->toArray();
    }
}
