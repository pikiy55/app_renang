@extends('layouts.app')

@section('title', 'Dashboard Perkumpulan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800">Dashboard Perkumpulan</h2>
        <p class="text-sm text-slate-500 mt-1">Selamat datang, {{ auth()->user()->nama_klub ?? auth()->user()->name }}</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl shadow-sm flex items-start">
            <svg class="w-5 h-5 mr-3 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h4 class="font-medium text-emerald-800">Berhasil!</h4>
                <p class="text-sm mt-1">{{ session('success') }}</p>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm flex items-start">
            <svg class="w-5 h-5 mr-3 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h4 class="font-medium text-red-800">Terdapat Kesalahan</h4>
                <p class="text-sm mt-1">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Event Aktif Section -->
        <div class="lg:col-span-1 space-y-6">
            <h3 class="text-xl font-bold text-slate-800 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Event Aktif
            </h3>
            
            @forelse($events as $event)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-5 border-b border-slate-100">
                        <h4 class="font-bold text-slate-800 text-lg mb-2">{{ $event->nama_event }}</h4>
                        <div class="space-y-2 text-sm text-slate-600">
                            <div class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>{{ $event->tanggal_mulai->format('d M Y') }} - {{ $event->tanggal_selesai->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>
                                    Batas Pendaftaran: <br>
                                    <span class="font-semibold {{ $event->isDeadlinePassed() ? 'text-red-500' : 'text-emerald-600' }}">
                                        {{ $event->deadline_pendaftaran->format('d M Y, H:i') }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-5 py-4">
                        @if(!$event->isDeadlinePassed())
                            <a href="{{ route('perkumpulan.pendaftaran.create', $event) }}" class="block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors shadow-sm">
                                Daftar Atlet
                            </a>
                        @else
                            <button disabled class="block w-full text-center px-4 py-2 bg-slate-200 text-slate-500 rounded-xl text-sm font-semibold cursor-not-allowed">
                                Pendaftaran Ditutup
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 text-center">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    <p class="text-sm font-medium text-slate-600">Belum ada event aktif saat ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Data Pendaftaran Section -->
        <div class="lg:col-span-2 space-y-6">
            <h3 class="text-xl font-bold text-slate-800 flex items-center">
                <svg class="w-6 h-6 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Data Pendaftaran Anda
            </h3>
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Atlet</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Event & Nomor</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($myPendaftaran as $daftar)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-slate-800">{{ $daftar->nama_atlet }}</div>
                                        <div class="text-xs text-slate-500">{{ ucfirst($daftar->jenis_kelamin) }}, Lhr: {{ $daftar->tanggal_lahir?->format('Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-slate-800 truncate max-w-[200px]" title="{{ $daftar->event->nama_event }}">
                                            {{ $daftar->event->nama_event }}
                                        </div>
                                        <div class="text-xs text-slate-600 mt-1">
                                            {{ $daftar->kelompokUmur->nama_ku }} - {{ $daftar->nomorLomba->nama_nomor }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($daftar->status_waktu === 'NT')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">NT</span>
                                        @else
                                            <span class="text-sm font-mono font-medium text-slate-700">{{ $daftar->limit_waktu }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($daftar->isLocked())
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200" title="Terkunci (Melewati Deadline)">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                Terkunci
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-100 text-emerald-700 border border-emerald-200">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                                                Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if(!$daftar->isLocked())
                                            <div class="flex items-center justify-end space-x-3">
                                                <a href="{{ route('perkumpulan.pendaftaran.edit', $daftar) }}" class="text-amber-500 hover:text-amber-700 transition-colors" title="Edit">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>
                                                <form action="{{ route('perkumpulan.pendaftaran.destroy', $daftar) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran atlet ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-slate-400 text-xs italic">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="bg-slate-100 p-4 rounded-full mb-4 text-slate-400">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </div>
                                            <h3 class="text-base font-bold text-slate-800">Belum Ada Pendaftaran</h3>
                                            <p class="text-sm text-slate-500 mt-1">Anda belum mendaftarkan atlet ke event manapun.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($myPendaftaran->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                    {{ $myPendaftaran->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
