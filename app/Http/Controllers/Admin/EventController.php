<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(StoreEventRequest $request)
    {
        Event::create($request->validated());
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dibuat.');
    }

    public function show(Event $event)
    {
        $event->load('kelompokUmur.nomorLomba');
        $totalPendaftaran = $event->pendaftaran()->count();
        $totalKlub        = $event->pendaftaran()->distinct('user_id')->count('user_id');

        return view('admin.events.show', compact('event', 'totalPendaftaran', 'totalKlub'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(StoreEventRequest $request, Event $event)
    {
        $event->update($request->validated());
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus.');
    }
}
