<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\DeadlineService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(private DeadlineService $deadlineService) {}

    /**
     * Katalog event aktif — bisa diakses publik (FR-1).
     */
    public function index()
    {
        $events = Event::aktif()->get()->map(function (Event $event) {
            return [
                'id'                   => $event->id,
                'nama_event'           => $event->nama_event,
                'lokasi'               => $event->lokasi,
                'tanggal_mulai'        => $event->tanggal_mulai->format('d M Y'),
                'tanggal_selesai'      => $event->tanggal_selesai->format('d M Y'),
                'deadline_pendaftaran' => $event->deadline_pendaftaran->format('d M Y H:i'),
                'is_deadline_passed'   => $this->deadlineService->isDeadlinePassed($event),
                'sisa_waktu'           => $this->deadlineService->sisaWaktu($event),
            ];
        });

        return view('events.index', compact('events'));
    }

    /**
     * Detail event & jadwal — bisa diakses publik.
     */
    public function show(Event $event)
    {
        $event->load('kelompokUmur.nomorLomba');

        $isDeadlinePassed = $this->deadlineService->isDeadlinePassed($event);
        $sisaWaktu        = $this->deadlineService->sisaWaktu($event);

        return view('events.show', compact('event', 'isDeadlinePassed', 'sisaWaktu'));
    }
}
