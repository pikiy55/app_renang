<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'before',
        'after',
    ];

    protected function casts(): array
    {
        return [
            'before' => 'array',
            'after'  => 'array',
        ];
    }

    // --- Relasi ---

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
