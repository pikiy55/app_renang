<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Event extends Model
{
    protected $fillable = [
        'nama_event',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'deadline_pendaftaran',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai'          => 'date',
            'tanggal_selesai'        => 'date',
            'deadline_pendaftaran'   => 'datetime',
            'is_active'              => 'boolean',
        ];
    }

    // --- Business Logic ---

    /**
     * Cek apakah deadline pendaftaran sudah terlampaui.
     */
    public function isDeadlinePassed(): bool
    {
        return Carbon::now()->isAfter($this->deadline_pendaftaran);
    }

    // --- Relasi ---

    public function kelompokUmur(): HasMany
    {
        return $this->hasMany(KelompokUmur::class);
    }

    public function pendaftaran(): HasMany
    {
        return $this->hasMany(Pendaftaran::class);
    }

    // --- Scopes ---

    public function scopeAktif($query)
    {
        return $query->where('is_active', true)->orderBy('tanggal_mulai');
    }
}
