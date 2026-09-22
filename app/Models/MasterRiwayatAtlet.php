<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class MasterRiwayatAtlet extends Model
{
    protected $table = 'master_riwayat_atlet';

    protected $fillable = [
        'user_id',
        'nama_atlet',
        'tanggal_lahir',
        'jenis_kelamin',
        'jarak',
        'gaya',
        'limit_waktu',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    // --- Relasi ---

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // --- Scopes ---

    /**
     * Scope untuk auto-complete nama atlet berdasarkan keyword dan perkumpulan.
     */
    public function scopeByNama(Builder $query, string $keyword, int $userId): Builder
    {
        return $query
            ->where('user_id', $userId)
            ->where('nama_atlet', 'like', "%{$keyword}%")
            ->select('nama_atlet', 'tanggal_lahir', 'jenis_kelamin')
            ->distinct();
    }

    /**
     * Scope untuk auto-match limit waktu berdasarkan nama atlet, jarak, dan gaya.
     */
    public function scopeAutoMatch(Builder $query, string $namaAtlet, int $jarak, string $gaya, int $userId): Builder
    {
        return $query
            ->where('user_id', $userId)
            ->where('nama_atlet', $namaAtlet)
            ->where('jarak', $jarak)
            ->where('gaya', $gaya)
            ->latest('updated_at');
    }
}
