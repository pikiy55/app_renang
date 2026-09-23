@extends('layouts.admin')

@section('title', 'Kelompok Umur - ' . $event->nama_event)
@section('header_title', 'Kelompok Umur (KU)')
@section('header_subtitle', 'Event: ' . $event->nama_event)

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <a href="{{ route('admin.events.show', $event) }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Detail Event
    </a>
    <a href="{{ route('admin.events.ku.create', $event) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring ring-indigo-300 transition shadow-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah KU Baru
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama KU</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Usia Min</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Usia Max</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Jml Nomor Lomba</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-100">
                @forelse($kelompokUmur as $ku)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-slate-800">{{ $ku->nama_ku }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-600">{{ $ku->usia_min ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-600">{{ $ku->usia_max ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <a href="{{ route('admin.ku.nomor.index', $ku) }}" class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200 hover:bg-indigo-100 transition-colors">
                            {{ $ku->nomorLomba->count() }} Nomor
                            <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.events.ku.edit', [$event, $ku]) }}" class="text-amber-500 hover:text-amber-700 transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.events.ku.destroy', [$event, $ku]) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus KU ini? Semua Nomor Lomba di dalamnya juga akan terhapus.');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="bg-slate-100 p-4 rounded-full mb-4 text-slate-400"><svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg></div>
                            <h3 class="text-base font-bold text-slate-800">Belum ada Kelompok Umur</h3>
                            <p class="text-sm text-slate-500 mt-1">Tambahkan KU baru untuk event ini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
