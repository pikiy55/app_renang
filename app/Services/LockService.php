<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Pendaftaran;

class LockService
{
    /**
     * Kunci semua pendaftaran pada event yang sudah melewati deadline.
     * Biasanya dipanggil via scheduled command.
     */
    public function lockAllPendaftaran(Event $event): int
    {
        if (! $event->isDeadlinePassed()) {
            return 0;
        }

        return Pendaftaran::where('event_id', $event->id)
            ->where('is_locked', false)
            ->update(['is_locked' => true]);
    }

    /**
     * Lock semua event yang sudah lewat deadline (untuk bulk processing).
     */
    public function lockAllExpiredEvents(): int
    {
        $total = 0;

        Event::where('is_active', true)
            ->where('deadline_pendaftaran', '<', now())
            ->each(function (Event $event) use (&$total) {
                $total += $this->lockAllPendaftaran($event);
            });

        return $total;
    }
}
