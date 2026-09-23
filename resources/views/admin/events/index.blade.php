@extends('layouts.admin')

@section('title', 'Manajemen Event')
@section('header_title', 'Daftar Kejuaraan (Event)')
@section('header_subtitle', 'Kelola semua data event/kejuaraan renang')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div class="flex-1">
        <h3 class="text-lg font-bold text-slate-800">Semua Event</h3>
        <p class="text-sm text-slate-500">Total: {{ $events->total() }} event terdaftar</p>
    </div>
    <div>
        <a href="{{ route('admin.events.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Event Baru
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Event</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal & Lokasi</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Deadline</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-100">
                @forelse($events as $event)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-slate-800">{{ $event->nama_event }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-slate-600">
                            <span class="font-medium text-slate-700">Mulai:</span> {{ $event->tanggal_mulai?->format('d M Y') }}
                        </div>
                        <div class="text-sm text-slate-600 mt-1">
                            <span class="font-medium text-slate-700">Selesai:</span> {{ $event->tanggal_selesai?->format('d M Y') }}
                        </div>
                        <div class="text-xs text-slate-400 mt-1 flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $event->lokasi ?? '-' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($event->isDeadlinePassed())
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                {{ $event->deadline_pendaftaran?->format('d M Y H:i') }} (Ditutup)
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                {{ $event->deadline_pendaftaran?->format('d M Y H:i') }} (Dibuka)
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if($event->is_active)
                            <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500 mr-2 shadow-sm shadow-emerald-500/50"></span>
                            <span class="text-sm font-medium text-emerald-600">Aktif</span>
                        @else
                            <span class="inline-flex h-2.5 w-2.5 rounded-full bg-slate-300 mr-2"></span>
                            <span class="text-sm font-medium text-slate-500">Draft</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.events.show', $event) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors" title="Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <a href="{{ route('admin.events.edit', $event) }}" class="text-amber-500 hover:text-amber-700 transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini? Semua data terkait (KU, Nomor Lomba, Pendaftaran) mungkin juga akan terhapus jika diatur cascade.');">
                                @csrf
                                @method('DELETE')
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
                        <div class="flex flex-col items-center justify-center">
                            <div class="bg-slate-100 p-4 rounded-full mb-4 text-slate-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="text-base font-bold text-slate-800">Belum Ada Data Event</h3>
                            <p class="text-sm text-slate-500 mt-1 max-w-sm">Mulai dengan menambahkan event kejuaraan renang pertama Anda.</p>
                            <a href="{{ route('admin.events.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-semibold hover:bg-indigo-100 transition-colors border border-indigo-200">
                                Tambah Event Baru
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($events->hasPages())
    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
        {{ $events->links() }}
    </div>
    @endif
</div>
@endsection
