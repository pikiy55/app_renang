@extends('layouts.app')

@section('title', 'Daftar Event - Perkumpulan')

@section('content')
{{-- Hero Banner --}}
<div class="bg-gradient-to-r from-indigo-700 via-indigo-800 to-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Top Row: Badge --}}
        <div class="mb-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 text-indigo-100 text-xs font-semibold uppercase tracking-wider">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Panel Perkumpulan
            </span>
        </div>

        {{-- Content Row --}}
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
            {{-- Left: Title & Description --}}
            <div class="max-w-2xl">
                <h1 class="text-3xl font-extrabold text-white tracking-tight mb-2">
                    Daftar Event Kejuaraan
                </h1>
                <p class="text-indigo-200 text-sm leading-relaxed">
                    Pilih event yang ingin diikuti oleh perkumpulan
                    <span class="font-semibold text-white">{{ auth()->user()->nama_klub ?? auth()->user()->name }}</span>.
                    Klik event untuk mengelola pendaftaran atlet.
                </p>
            </div>

            {{-- Right: Stats + Button --}}
            <div class="flex items-center gap-3">
                <div class="bg-white/10 rounded-xl px-5 py-3 text-center min-w-[90px]">
                    <p class="text-2xl font-extrabold text-white leading-none">{{ $events->count() }}</p>
                    <p class="text-[11px] text-indigo-200 font-medium mt-1">Event Aktif</p>
                </div>
                <div class="bg-white/10 rounded-xl px-5 py-3 text-center min-w-[90px]">
                    <p class="text-2xl font-extrabold text-white leading-none">{{ $totalPendaftaran }}</p>
                    <p class="text-[11px] text-indigo-200 font-medium mt-1">Total Atlet</p>
                </div>
                <a href="{{ route('perkumpulan.rekap') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-indigo-700 rounded-xl text-sm font-bold shadow-sm hover:bg-indigo-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Rekap Pendaftaran
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Flash Messages --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-start">
            <svg class="w-5 h-5 mr-3 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h4 class="font-semibold text-emerald-800 text-sm">Berhasil!</h4>
                <p class="text-sm mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-start">
            <svg class="w-5 h-5 mr-3 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h4 class="font-semibold text-red-800 text-sm">Terdapat Kesalahan</h4>
                <p class="text-sm mt-0.5">{{ session('error') }}</p>
            </div>
        </div>
    @endif
</div>

{{-- Events Grid --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 mt-2">
    @if($events->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach($events as $event)
                @php
                    $isDeadlinePassed = $event->isDeadlinePassed();
                    $pendaftaranCount = $event->pendaftaran->where('user_id', auth()->id())->count();
                @endphp

                <a href="{{ route('perkumpulan.event.dashboard', $event) }}"
                   class="group block bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg hover:border-indigo-300 transition-all duration-200">

                    {{-- Card Top Accent --}}
                    <div class="h-2 {{ $isDeadlinePassed ? 'bg-gradient-to-r from-slate-300 to-slate-400' : 'bg-gradient-to-r from-indigo-500 to-purple-500' }}"></div>

                    {{-- Card Body --}}
                    <div class="p-5">
                        {{-- Header: Title + Badge --}}
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <h3 class="text-base font-bold text-slate-800 leading-snug group-hover:text-indigo-600 transition-colors line-clamp-2">
                                {{ $event->nama_event }}
                            </h3>
                            @if($isDeadlinePassed)
                                <span class="shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold bg-red-100 text-red-600 border border-red-200">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    Ditutup
                                </span>
                            @else
                                <span class="shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                    Dibuka
                                </span>
                            @endif
                        </div>

                        {{-- Info Rows --}}
                        <div class="space-y-2.5 text-sm text-slate-600">
                            {{-- Lokasi --}}
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <span class="truncate">{{ $event->lokasi }}</span>
                            </div>

                            {{-- Tanggal --}}
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <span>{{ $event->tanggal_mulai->format('d M Y') }} – {{ $event->tanggal_selesai->format('d M Y') }}</span>
                            </div>

                            {{-- Deadline --}}
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg {{ $isDeadlinePassed ? 'bg-red-50' : 'bg-amber-50' }} flex items-center justify-center shrink-0">
                                    <svg class="w-3.5 h-3.5 {{ $isDeadlinePassed ? 'text-red-400' : 'text-amber-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <span class="text-[11px] text-slate-400 uppercase tracking-wide font-medium">Deadline</span>
                                    <p class="text-sm font-semibold {{ $isDeadlinePassed ? 'text-red-500' : 'text-slate-700' }} leading-tight">
                                        {{ $event->deadline_pendaftaran->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="mt-4 pt-3.5 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 {{ $pendaftaranCount > 0 ? 'text-indigo-500' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="text-xs font-semibold {{ $pendaftaranCount > 0 ? 'text-indigo-600' : 'text-slate-500' }}">{{ $pendaftaranCount }} Atlet terdaftar</span>
                            </div>
                            <span class="inline-flex items-center text-xs font-semibold text-indigo-600 group-hover:text-indigo-700 transition-colors">
                                Kelola
                                <svg class="ml-1 w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200 p-16 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Event Aktif</h3>
            <p class="text-sm text-slate-500 max-w-sm mx-auto">Saat ini belum ada kejuaraan renang yang aktif. Silakan kembali lagi nanti.</p>
        </div>
    @endif
</div>
@endsection
