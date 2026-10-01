@extends('layouts.app')

@section('title', $event->nama_event . ' - Dashboard Perkumpulan')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<div class="min-h-screen bg-slate-50">
    {{-- Event Header --}}
    <div class="relative bg-gradient-to-br from-indigo-900 via-slate-900 to-purple-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-indigo-500 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-purple-500 rounded-full blur-3xl"></div>
        </div>
        <div class="absolute inset-0">
            <svg class="absolute bottom-0 left-0 right-0 text-slate-50" viewBox="0 0 1440 60" fill="currentColor" preserveAspectRatio="none">
                <path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z"></path>
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-20">
            {{-- Breadcrumb --}}
            <div class="mb-6">
                <a href="{{ route('perkumpulan.dashboard') }}" class="inline-flex items-center text-sm font-medium text-indigo-200/70 hover:text-white transition-colors group">
                    <svg class="mr-2 w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke halama utama 
                </a>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between">
                <div class="flex-1">
                    <div class="flex flex-wrap gap-2 mb-3">
                        @if($isDeadlinePassed)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-500/80 text-white backdrop-blur-md border border-red-500/50">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Pendaftaran Ditutup
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/80 text-white backdrop-blur-md border border-emerald-500/50">
                                <span class="w-1.5 h-1.5 bg-white rounded-full mr-1.5 animate-pulse"></span>
                                Pendaftaran Dibuka
                            </span>
                        @endif
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/10 text-indigo-200 backdrop-blur-md border border-white/20">
                            {{ $event->tanggal_mulai->format('d M Y') }} – {{ $event->tanggal_selesai->format('d M Y') }}
                        </span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight mb-1">
                        {{ $event->nama_event }}
                    </h1>
                    <p class="text-indigo-200/70 text-sm flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $event->lokasi }}
                    </p>
                </div>

                <div class="mt-6 lg:mt-0 flex items-center space-x-3">
                    {{-- Stats Cards --}}
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl px-4 py-2.5 text-center">
                        <p class="text-xl font-extrabold text-white">{{ $myPendaftaran->total() }}</p>
                        <p class="text-[11px] text-indigo-200/70 font-medium">Atlet Terdaftar</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl px-4 py-2.5 text-center">
                        <p class="text-xl font-extrabold text-white">{{ $sisaWaktu }}</p>
                        <p class="text-[11px] text-indigo-200/70 font-medium">Sisa Waktu</p>
                    </div>

                    @if($event->file_juknis)
                        <a href="{{ route('perkumpulan.event.juknis.download', $event) }}"
                           class="inline-flex items-center justify-center px-4 py-3 rounded-xl bg-white/10 backdrop-blur-md border border-white/30 text-white font-semibold text-sm hover:bg-white/20 hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Unduh Juknis
                        </a>
                    @endif

                    @if(!$isDeadlinePassed)
                        <a href="{{ route('perkumpulan.pendaftaran.create', $event) }}"
                           class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-white text-indigo-900 font-bold text-sm shadow-lg hover:bg-indigo-50 hover:-translate-y-0.5 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Daftar Atlet
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 pb-16 relative z-10">

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl shadow-sm flex items-start animate-fadeIn">
                <svg class="w-5 h-5 mr-3 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <h4 class="font-medium text-emerald-800">Berhasil!</h4>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm flex items-start animate-fadeIn">
                <svg class="w-5 h-5 mr-3 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <h4 class="font-medium text-red-800">Terdapat Kesalahan</h4>
                    <p class="text-sm mt-1">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Deadline Info Bar --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
            <div class="flex items-center space-x-6">
                <div class="flex items-center">
                    <div class="w-9 h-9 rounded-lg bg-indigo-100 flex items-center justify-center mr-3">
                        <svg class="w-4.5 h-4.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Batas Pendaftaran</p>
                        <p class="text-sm font-bold {{ $isDeadlinePassed ? 'text-red-600' : 'text-slate-800' }}">
                            {{ $event->deadline_pendaftaran->format('d F Y, H:i') }} WIB
                        </p>
                    </div>
                </div>
                <div class="hidden sm:block w-px h-8 bg-slate-200"></div>
                <div class="hidden sm:flex items-center">
                    <div class="w-9 h-9 rounded-lg {{ $isDeadlinePassed ? 'bg-red-100' : 'bg-emerald-100' }} flex items-center justify-center mr-3">
                        <svg class="w-4.5 h-4.5 {{ $isDeadlinePassed ? 'text-red-600' : 'text-emerald-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Status</p>
                        <p class="text-sm font-bold {{ $isDeadlinePassed ? 'text-red-600' : 'text-emerald-600' }}">
                            {{ $isDeadlinePassed ? 'Deadline Berakhir' : $sisaWaktu }}
                        </p>
                    </div>
                </div>
            </div>
            @if(!$isDeadlinePassed)
                <a href="{{ route('perkumpulan.pendaftaran.create', $event) }}"
                   class="inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Daftarkan Atlet Baru
                </a>
            @endif
        </div>

        {{-- Pendaftaran Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Data Pendaftaran Atlet
                </h3>
                <span class="text-sm text-slate-500 font-medium bg-slate-100 px-3 py-1 rounded-lg">{{ $myPendaftaran->total() }} data</span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">No</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Atlet</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori & Nomor Lomba</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($myPendaftaran as $index => $daftar)
                            <tr class="hover:bg-indigo-50/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-slate-400">{{ $myPendaftaran->firstItem() + $index }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center mr-3 shadow-sm">
                                            <span class="text-white text-xs font-bold">{{ strtoupper(substr($daftar->nama_atlet, 0, 2)) }}</span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-800">{{ $daftar->nama_atlet }}</div>
                                            <div class="text-xs text-slate-500">{{ ucfirst($daftar->jenis_kelamin) }} · {{ $daftar->tanggal_lahir?->format('Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-800">
                                        {{ $daftar->kelompokUmur->nama_ku }}
                                    </div>
                                    <div class="text-xs text-indigo-600 font-medium mt-0.5">
                                        {{ $daftar->nomorLomba->nama_nomor }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($daftar->status_waktu === 'NT')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            NT
                                        </span>
                                    @else
                                        <span class="text-sm font-mono font-semibold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg">{{ $daftar->limit_waktu }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($daftar->isLocked())
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200" title="Terkunci (Melewati Deadline)">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            Terkunci
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                                            Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if(!$daftar->isLocked())
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('perkumpulan.pendaftaran.edit', $daftar) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 transition-colors" title="Edit">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('perkumpulan.pendaftaran.destroy', $daftar) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran atlet ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 transition-colors" title="Hapus">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-slate-400 text-xs italic">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                        </div>
                                        <h3 class="text-base font-bold text-slate-800 mb-1">Belum Ada Atlet Terdaftar</h3>
                                        <p class="text-sm text-slate-500 mb-4">Anda belum mendaftarkan atlet untuk event ini.</p>
                                        @if(!$isDeadlinePassed)
                                            <a href="{{ route('perkumpulan.pendaftaran.create', $event) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors shadow-sm">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                                Daftarkan Atlet Pertama
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($myPendaftaran->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50">
                {{ $myPendaftaran->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.4s ease-out;
    }
</style>
@endsection
