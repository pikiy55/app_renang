<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NomorLomba extends Model
{
    protected $table = 'nomor_lomba';

    protected $fillable = [
        'kelompok_umur_id',
        'nama_nomor',
        'jarak',
        'gaya',
        'jenis_kelamin',
    ];

    // --- Relasi ---

    public function kelompokUmur(): BelongsTo
    {
        return $this->belongsTo(KelompokUmur::class);
    }

    public function pendaftaran(): HasMany
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
