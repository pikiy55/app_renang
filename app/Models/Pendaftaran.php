<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    protected $fillable = [
        'event_id',
        'user_id',
        'kelompok_umur_id',
        'nomor_lomba_id',
        'nama_atlet',
        'tanggal_lahir',
        'jenis_kelamin',
        'limit_waktu',
        'status_waktu',
        'is_locked',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'is_locked'     => 'boolean',
        ];
    }

    // --- Business Logic ---

    /**
     * Cek apakah entri ini terkunci (deadline event sudah lewat atau is_locked = true).
     */
    public function isLocked(): bool
    {
        return $this->is_locked || $this->event->isDeadlinePassed();
    }

    // --- Relasi ---

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kelompokUmur(): BelongsTo
    {
        return $this->belongsTo(KelompokUmur::class);
    }

    public function nomorLomba(): BelongsTo
    {
        return $this->belongsTo(NomorLomba::class);
    }
}
