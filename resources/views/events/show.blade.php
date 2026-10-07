@extends('layouts.app')

@section('title', $event->nama_event . ' - Detail')

@section('content')
{{-- Back Navigation --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6 mt-6">
    <a href="{{ route('events.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-cyan transition-colors group">
        <svg class="mr-2 w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Katalog
    </a>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        {{-- Hero / Competition Header --}}
        <div class="relative h-64 sm:h-80 bg-navy overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-navy/95 to-navy-light/80 z-10"></div>
            {{-- Decorative elements --}}
            <div class="absolute inset-0 z-0">
                <div class="absolute top-10 right-10 w-40 h-40 bg-cyan/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-10 left-10 w-32 h-32 bg-cyan/5 rounded-full blur-3xl"></div>
            </div>
            
            <div class="absolute bottom-0 left-0 right-0 p-8 sm:p-12 z-20">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-white/10 text-white backdrop-blur-md border border-white/15">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $event->tanggal_mulai->format('d M Y') }} - {{ $event->tanggal_selesai->format('d M Y') }}
                            </span>
                            @if($isDeadlinePassed)
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-coral/80 text-white backdrop-blur-md border border-coral/50">
                                    Pendaftaran Ditutup
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-cyan/80 text-white backdrop-blur-md border border-cyan/50">
                                    <span class="w-1.5 h-1.5 bg-white rounded-full mr-1.5 animate-pulse"></span>
                                    Pendaftaran Dibuka
                                </span>
                            @endif
                        </div>
                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-2">
                            {{ $event->nama_event }}
                        </h1>
                        <p class="text-slate-300 text-lg flex items-center">
                            <svg class="w-5 h-5 mr-2 text-cyan/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $event->lokasi }}
                        </p>
                    </div>
                    
                    @if(!$isDeadlinePassed)
                    <div class="mt-2 md:mt-0">
                        <a href="{{ route('perkumpulan.pendaftaran.create', $event->id) }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent rounded-xl shadow-lg shadow-cyan/30 text-base font-bold text-white bg-cyan hover:bg-cyan-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-navy focus:ring-cyan transition-all duration-300 transform hover:-translate-y-1">
                            Daftar Sekarang
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="p-6 sm:p-10">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                {{-- Left Column: Info & Schedule --}}
                <div class="lg:col-span-2 space-y-10">
                    
                    <section>
                        <h3 class="text-xl font-bold text-navy mb-5 flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-ice text-cyan flex items-center justify-center mr-3">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            Informasi Kejuaraan
                        </h3>
                        <div class="prose max-w-none text-slate-600 leading-relaxed">
                            {!! nl2br(e($event->deskripsi ?? 'Tidak ada deskripsi tersedia untuk event ini.')) !!}
                        </div>
                    </section>

                    <hr class="border-slate-100">

                    <section>
                        <h3 class="text-xl font-bold text-navy mb-5 flex items-center">
                            <div class="w-8 h-8 rounded-lg bg-ice text-cyan flex items-center justify-center mr-3">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            Kategori & Nomor Lomba
                        </h3>
                        
                        @forelse($event->kelompokUmur as $ku)
                            <div class="mb-5 bg-slate-50 rounded-xl border border-slate-200 overflow-hidden">
                                <div class="px-5 py-3.5 bg-navy/[0.03] border-b border-slate-200 flex justify-between items-center">
                                    <h4 class="font-bold text-navy text-sm">{{ $ku->nama_ku }}</h4>
                                    <span class="text-xs font-medium text-slate-500 bg-white px-2.5 py-1 rounded-md border border-slate-200">
                                        Min: {{ $ku->min_umur ?? 0 }} | Max: {{ $ku->max_umur ?? 'Unlimited' }} thn
                                    </span>
                                </div>
                                <div class="p-5">
                                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-2.5">
                                        @forelse($ku->nomorLomba as $nomor)
                                            <li class="flex items-center text-sm text-slate-600 bg-white p-3 rounded-lg border border-slate-100 hover:border-cyan/30 hover:bg-ice-light transition-colors">
                                                <svg class="w-4 h-4 mr-2.5 text-cyan shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $nomor->nama_nomor }}
                                            </li>
                                        @empty
                                            <li class="text-slate-400 italic text-sm">Belum ada nomor lomba</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500 italic bg-ice-light p-6 rounded-xl border border-ice-dark/30 text-center">Data kelompok umur belum tersedia.</p>
                        @endforelse
                    </section>
                </div>

                {{-- Right Column: Sidebar Info --}}
                <div class="space-y-6">
                    {{-- Registration Status Card --}}
                    <div class="bg-ice rounded-xl p-6 border border-ice-dark/30 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-cyan/5 rounded-full -translate-y-8 translate-x-8"></div>
                        
                        <h4 class="text-base font-bold text-navy mb-4 relative z-10 flex items-center">
                            <svg class="w-4.5 h-4.5 mr-2 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Status Pendaftaran
                        </h4>
                        
                        <div class="space-y-4 relative z-10">
                            <div>
                                <p class="text-xs font-semibold text-cyan-dark uppercase tracking-wider mb-1">Batas Akhir</p>
                                <p class="text-base font-semibold text-navy">{{ $event->deadline_pendaftaran->format('d F Y, H:i') }}</p>
                            </div>
                            
                            <div>
                                <p class="text-xs font-semibold text-cyan-dark uppercase tracking-wider mb-1">Sisa Waktu</p>
                                <p class="text-xl font-bold {{ $isDeadlinePassed ? 'text-coral' : 'text-cyan' }}">
                                    @if($isDeadlinePassed)
                                        Waktu Habis
                                    @else
                                        {{ $sisaWaktu }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Contact/Help --}}
                    <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
                        <h4 class="text-base font-bold text-navy mb-3 flex items-center">
                            <svg class="w-4.5 h-4.5 mr-2 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Butuh Bantuan?
                        </h4>
                        <p class="text-sm text-slate-600 mb-4">Jika Anda mengalami kendala pendaftaran atau memiliki pertanyaan seputar kejuaraan.</p>
                        <a href="#" class="inline-flex w-full justify-center items-center px-4 py-2.5 border border-slate-200 rounded-lg text-sm font-semibold text-navy bg-white hover:bg-ice-light hover:border-cyan/30 transition-all duration-200">
                            Hubungi Panitia
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
