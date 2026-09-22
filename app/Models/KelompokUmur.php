<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KelompokUmur extends Model
{
    protected $table = 'kelompok_umur';

    protected $fillable = [
        'event_id',
        'nama_ku',
        'usia_min',
        'usia_max',
    ];

    // --- Relasi ---

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function nomorLomba(): HasMany
    {
        return $this->hasMany(NomorLomba::class);
    }

    public function pendaftaran(): HasMany
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
