<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\KelompokUmur;
use Illuminate\Http\Request;

class KelompokUmurController extends Controller
{
    public function index(Event $event)
    {
        $kelompokUmur = $event->kelompokUmur()->with('nomorLomba')->get();
        return view('admin.kelompok-umur.index', compact('event', 'kelompokUmur'));
    }

    public function create(Event $event)
    {
        return view('admin.kelompok-umur.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $data = $request->validate([
            'nama_ku'  => ['required', 'string', 'max:100'],
            'usia_min' => ['nullable', 'integer', 'min:0'],
            'usia_max' => ['nullable', 'integer', 'min:0'],
        ]);

        $event->kelompokUmur()->create($data);
        return redirect()->route('admin.events.ku.index', $event)
            ->with('success', "Kelompok Umur '{$data['nama_ku']}' berhasil ditambahkan.");
    }

    public function edit(Event $event, KelompokUmur $ku)
    {
        return view('admin.kelompok-umur.edit', compact('event', 'ku'));
    }

    public function update(Request $request, Event $event, KelompokUmur $ku)
    {
        $data = $request->validate([
            'nama_ku'  => ['required', 'string', 'max:100'],
            'usia_min' => ['nullable', 'integer', 'min:0'],
            'usia_max' => ['nullable', 'integer', 'min:0'],
        ]);

        $ku->update($data);
        return redirect()->route('admin.events.ku.index', $event)
            ->with('success', 'Kelompok Umur berhasil diperbarui.');
    }

    public function destroy(Event $event, KelompokUmur $ku)
    {
        $ku->delete();
        return redirect()->route('admin.events.ku.index', $event)
            ->with('success', 'Kelompok Umur berhasil dihapus.');
    }
}
