@extends('layouts.app')

@section('title', 'Katalog Event Kejuaraan')

@section('content')
{{-- Hero Section (Dark Blue #172B4D) --}}
<div class="bg-navy py-12 sm:py-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden border-b border-[#1F365D]"
     style="background-color: #172B4D;">
    {{-- Decorative Glows --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-24 right-1/4 w-96 h-96 rounded-full blur-3xl opacity-20" style="background-color: #20B8D4;"></div>
        <div class="absolute -bottom-20 left-10 w-80 h-80 rounded-full blur-3xl opacity-15" style="background-color: #20B8D4;"></div>
    </div>

    <div class="max-w-4xl mx-auto text-center relative z-10">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-4 border border-cyan/30"
             style="background-color: rgba(32, 184, 212, 0.15); color: #20B8D4;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            Platform Resmi Pendaftaran Kejuaraan
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight mb-4 leading-tight">
            Kejuaraan Renang <span class="text-cyan" style="color: #20B8D4;">Nasional</span>
        </h1>
        <p class="text-sm sm:text-base lg:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed font-normal">
            Temukan dan daftarkan atlet perkumpulan Anda di berbagai kejuaraan bergengsi. Berkompetisi dengan perenang terbaik di seluruh Indonesia.
        </p>
    </div>
</div>

{{-- Events Catalog Section --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 mb-16 relative z-10">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-navy" style="color: #172B4D;">
                Event Berlangsung & Mendatang
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Pilih kejuaraan untuk melihat informasi detail, nomor lomba, dan jadwal pelaksanaan.
            </p>
        </div>
        <div class="bg-white rounded-full px-4 py-1.5 text-xs font-bold text-navy shadow-sm border border-slate-200 flex items-center gap-2"
             style="color: #172B4D;">
            <span class="w-2 h-2 rounded-full animate-pulseDot" style="background-color: #20B8D4;"></span>
            {{ count($events) }} Event Tersedia
        </div>
    </div>

    @if(count($events) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 hover:shadow-xl hover:border-cyan/50 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        {{-- Card Top Accent Line --}}
                        <div class="h-2 {{ $event['is_deadline_passed'] ? 'bg-slate-300' : 'bg-gradient-to-r from-cyan to-[#48CDE4]' }}"
                             style="{{ $event['is_deadline_passed'] ? 'background-color: #CBD5E1;' : 'background: linear-gradient(90deg, #20B8D4, #48CDE4);' }}"></div>

                        {{-- Card Visual Banner --}}
                        <div class="relative h-40 overflow-hidden" style="background-color: #172B4D;">
                            <div class="w-full h-full flex items-center justify-center group-hover:scale-105 transition-transform duration-500">
                                <svg class="w-16 h-16 opacity-25" style="color: #20B8D4;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                                </svg>
                            </div>
                            <div class="absolute bottom-3 left-4 right-4 z-20 flex justify-between items-end">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-navy/80 text-white backdrop-blur-md border border-white/20">
                                    <svg class="w-3.5 h-3.5 mr-1 text-cyan" style="color: #20B8D4;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $event['tanggal_mulai'] }}
                                </span>
                                @if($event['is_deadline_passed'])
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold text-white shadow-sm"
                                          style="background-color: #E25050;">
                                        Ditutup
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold text-navy shadow-sm"
                                          style="background-color: #20B8D4; color: #172B4D;">
                                        <span class="w-1.5 h-1.5 bg-navy rounded-full mr-1.5 animate-pulseDot"></span>
                                        Dibuka
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="p-6">
                            <h3 class="text-lg font-extrabold text-navy mb-3 line-clamp-2 group-hover:text-cyan transition-colors"
                                style="color: #172B4D;">
                                {{ $event['nama_event'] }}
                            </h3>

                            <div class="space-y-2.5 text-sm text-slate-600 mb-4">
                                <div class="flex items-start">
                                    <div class="w-7 h-7 rounded-lg flex items-center justify-center mr-2.5 shrink-0 border border-[#BBE7F0]"
                                         style="background-color: #DFF6FA;">
                                        <svg class="w-3.5 h-3.5" style="color: #1796AD;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <span class="truncate mt-0.5 font-medium text-slate-700">{{ $event['lokasi'] }}</span>
                                </div>

                                <div class="flex items-start">
                                    <div class="w-7 h-7 rounded-lg flex items-center justify-center mr-2.5 shrink-0 border border-[#BBE7F0]"
                                         style="background-color: #DFF6FA;">
                                        <svg class="w-3.5 h-3.5" style="color: #1796AD;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <span class="mt-0.5 font-medium text-slate-700">Deadline: <strong class="text-navy" style="color: #172B4D;">{{ $event['deadline_pendaftaran'] }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card Footer --}}
                    <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between">
                        <div class="text-xs font-bold"
                             style="{{ $event['is_deadline_passed'] ? 'color: #E25050;' : 'color: #1796AD;' }}">
                            @if($event['is_deadline_passed'])
                                Pendaftaran Selesai
                            @else
                                Sisa: {{ $event['sisa_waktu'] }}
                            @endif
                        </div>

                        <a href="{{ route('events.show', $event['id']) }}"
                           class="inline-flex items-center text-xs font-extrabold group-hover:translate-x-0.5 transition-all"
                           style="color: #1796AD;">
                            Detail Event
                            <svg class="ml-1 w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center max-w-lg mx-auto">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-[#BBE7F0]"
                 style="background-color: #DFF6FA;">
                <svg class="w-8 h-8" style="color: #1796AD;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-lg font-extrabold text-navy mb-1" style="color: #172B4D;">Belum Ada Event</h3>
            <p class="text-sm text-slate-500 leading-relaxed">Saat ini belum ada kejuaraan renang yang aktif atau dibuka untuk pendaftaran. Silakan kembali lagi nanti.</p>
        </div>
    @endif
</div>
@endsection
