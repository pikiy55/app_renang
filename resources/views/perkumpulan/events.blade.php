@extends('layouts.app')

@section('title', 'Daftar Event - Perkumpulan')

@section('content')
{{-- Hero Banner (Dark Blue #172B4D) --}}
<div class="bg-navy relative overflow-hidden border-b border-[#1F365D]" style="background-color: #172B4D;">
    {{-- Subtle Decorative Aquatic Glows --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-24 right-1/4 w-96 h-96 rounded-full blur-3xl opacity-20" style="background-color: #20B8D4;"></div>
        <div class="absolute -bottom-20 left-10 w-80 h-80 rounded-full blur-3xl opacity-15" style="background-color: #20B8D4;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 relative z-10">
        {{-- Top Row: Badge --}}
        <div class="mb-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-cyan border border-cyan/30"
                  style="background-color: rgba(32, 184, 212, 0.12); color: #20B8D4;">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Panel Perkumpulan
            </span>
        </div>

        {{-- Content Row --}}
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
            {{-- Left: Title & Description --}}
            <div class="max-w-2xl">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight mb-2">
                    Daftar Event Kejuaraan
                </h1>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Pilih event yang ingin diikuti oleh perkumpulan
                    <span class="font-bold text-cyan">{{ auth()->user()->nama_klub ?? auth()->user()->name }}</span>.
                    Klik event untuk mengelola pendaftaran atlet dan nomor lomba.
                </p>
            </div>

            {{-- Right: Stats + Quick CTA Button --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 shrink-0">
                <div class="grid grid-cols-3 gap-2 sm:gap-3">
                    <div class="rounded-xl p-3 sm:px-4 sm:py-3 text-center border border-[#1F365D]"
                         style="background-color: #0E1A2E;">
                        <p class="text-xl sm:text-2xl font-extrabold text-white leading-none">{{ $events->count() }}</p>
                        <p class="text-[11px] text-slate-300 font-medium mt-1">Event Aktif</p>
                    </div>
                    <div class="rounded-xl p-3 sm:px-4 sm:py-3 text-center border border-[#1F365D]"
                         style="background-color: #0E1A2E;">
                        <p class="text-xl sm:text-2xl font-extrabold text-white leading-none">{{ $totalMasterAtlet ?? 0 }}</p>
                        <p class="text-[11px] text-slate-300 font-medium mt-1">Atlet Klub</p>
                    </div>
                    <div class="rounded-xl p-3 sm:px-4 sm:py-3 text-center border border-[#1F365D]"
                         style="background-color: #0E1A2E;">
                        <p class="text-xl sm:text-2xl font-extrabold text-cyan leading-none" style="color: #20B8D4;">{{ $totalPendaftaran }}</p>
                        <p class="text-[11px] text-slate-300 font-medium mt-1">Pendaftaran</p>
                    </div>
                </div>
                <a href="{{ route('perkumpulan.rekap') }}"
                   class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-sm font-bold text-navy shadow-lg transition-all duration-200 hover:scale-[1.02]"
                   style="background-color: #20B8D4; color: #172B4D;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span>Data Atlet & Rekap</span>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Flash Messages --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    @if(session('success'))
        <div class="mb-4 p-4 rounded-xl flex items-start border border-[#BBE7F0] animate-fadeIn"
             style="background-color: #DFF6FA; color: #1796AD;">
            <svg class="w-5 h-5 mr-3 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h4 class="font-bold text-sm" style="color: #172B4D;">Berhasil!</h4>
                <p class="text-sm mt-0.5 text-slate-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 rounded-xl flex items-start border border-[#FFA1A1] animate-fadeIn"
             style="background-color: #FFF2F2; color: #E25050;">
            <svg class="w-5 h-5 mr-3 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h4 class="font-bold text-sm" style="color: #E25050;">Perhatian</h4>
                <p class="text-sm mt-0.5 text-slate-700">{{ session('error') }}</p>
            </div>
        </div>
    @endif
</div>

{{-- Events Grid Section --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 mt-2">
    @if($events->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                @php
                    $isDeadlinePassed = $event->isDeadlinePassed();
                    $pendaftaranCount = $event->pendaftaran->where('user_id', auth()->id())->count();
                @endphp

                <a href="{{ route('perkumpulan.event.dashboard', $event) }}"
                   class="group block bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl hover:border-cyan/50 transition-all duration-300 flex flex-col justify-between">

                    <div>
                        {{-- Card Top Accent Line --}}
                        <div class="h-2 {{ $isDeadlinePassed ? 'bg-slate-300' : 'bg-gradient-to-r from-cyan to-[#48CDE4]' }}"
                             style="{{ $isDeadlinePassed ? 'background-color: #CBD5E1;' : 'background: linear-gradient(90deg, #20B8D4, #48CDE4);' }}"></div>

                        {{-- Card Header & Body --}}
                        <div class="p-6">
                            {{-- Header: Event Title + Status Badge --}}
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <h3 class="text-lg font-extrabold text-navy leading-snug group-hover:text-cyan transition-colors line-clamp-2"
                                    style="color: #172B4D;">
                                    {{ $event->nama_event }}
                                </h3>
                                @if($isDeadlinePassed)
                                    <span class="shrink-0 inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold border border-coral/30"
                                          style="background-color: rgba(255, 107, 107, 0.12); color: #E25050;">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        Ditutup
                                    </span>
                                @else
                                    <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold border border-cyan/30"
                                          style="background-color: #DFF6FA; color: #1796AD;">
                                        <span class="w-2 h-2 rounded-full animate-pulseDot" style="background-color: #20B8D4;"></span>
                                        Dibuka
                                    </span>
                                @endif
                            </div>

                            {{-- Info Rows --}}
                            <div class="space-y-3 text-sm text-slate-600">
                                {{-- Lokasi --}}
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 border border-[#BBE7F0]"
                                         style="background-color: #DFF6FA;">
                                        <svg class="w-4 h-4" style="color: #1796AD;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <span class="truncate font-medium text-slate-700">{{ $event->lokasi }}</span>
                                </div>

                                {{-- Tanggal Pelaksanaan --}}
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 border border-[#BBE7F0]"
                                         style="background-color: #DFF6FA;">
                                        <svg class="w-4 h-4" style="color: #1796AD;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <span class="font-medium text-slate-700">{{ $event->tanggal_mulai->format('d M Y') }} – {{ $event->tanggal_selesai->format('d M Y') }}</span>
                                </div>

                                {{-- Deadline Pendaftaran --}}
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 border"
                                         style="{{ $isDeadlinePassed ? 'background-color: rgba(255, 107, 107, 0.12); border-color: rgba(255, 107, 107, 0.3);' : 'background-color: #DFF6FA; border-color: #BBE7F0;' }}">
                                        <svg class="w-4 h-4" style="{{ $isDeadlinePassed ? 'color: #E25050;' : 'color: #1796AD;' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[11px] text-slate-400 uppercase tracking-wider font-semibold block leading-none mb-0.5">Batas Pendaftaran</span>
                                        <p class="text-xs sm:text-sm font-bold {{ $isDeadlinePassed ? 'text-coral' : 'text-navy' }}"
                                           style="{{ $isDeadlinePassed ? 'color: #E25050;' : 'color: #172B4D;' }}">
                                            {{ $event->deadline_pendaftaran->format('d M Y, H:i') }} WIB
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card Footer --}}
                    <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full {{ $pendaftaranCount > 0 ? 'bg-cyan' : 'bg-slate-300' }}"
                                  style="{{ $pendaftaranCount > 0 ? 'background-color: #20B8D4;' : 'background-color: #CBD5E1;' }}"></span>
                            <span class="text-xs font-bold {{ $pendaftaranCount > 0 ? 'text-navy' : 'text-slate-500' }}"
                                  style="{{ $pendaftaranCount > 0 ? 'color: #172B4D;' : '' }}">
                                {{ $pendaftaranCount }} Atlet Klub Terdaftar
                            </span>
                        </div>
                        <span class="inline-flex items-center text-xs font-extrabold text-cyan group-hover:translate-x-0.5 transition-all"
                              style="color: #1796AD;">
                            Kelola Event
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200 p-16 text-center max-w-lg mx-auto shadow-sm">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-[#BBE7F0]"
                 style="background-color: #DFF6FA;">
                <svg class="w-8 h-8 text-cyan" style="color: #20B8D4;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-lg font-extrabold text-navy mb-1" style="color: #172B4D;">Belum Ada Event Aktif</h3>
            <p class="text-sm text-slate-500 leading-relaxed">Saat ini belum ada kejuaraan renang yang dibuka untuk pendaftaran. Silakan cek kembali dalam beberapa waktu.</p>
        </div>
    @endif
</div>
@endsection
