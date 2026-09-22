<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Carbon;

class DeadlineService
{
    /**
     * Cek apakah deadline pendaftaran event sudah terlampaui.
     */
    public function isDeadlinePassed(Event $event): bool
    {
        return Carbon::now()->isAfter($event->deadline_pendaftaran);
    }

    /**
     * Kembalikan sisa waktu deadline dalam format yang readable.
     */
    public function sisaWaktu(Event $event): string
    {
        if ($this->isDeadlinePassed($event)) {
            return 'Deadline sudah berakhir';
        }

        $deadline = Carbon::parse($event->deadline_pendaftaran);
        $diff = $deadline->diff(Carbon::now());

        if ($diff->days > 0) {
            return "{$diff->days} hari {$diff->h} jam lagi";
        }

        if ($diff->h > 0) {
            return "{$diff->h} jam {$diff->i} menit lagi";
        }

        return "{$diff->i} menit lagi";
    }
}
