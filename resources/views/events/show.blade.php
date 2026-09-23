@extends('layouts.app')

@section('title', $event->nama_event . ' - Detail')

@section('content')
<div class="mb-8 mt-4">
    <a href="{{ route('events.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Katalog
    </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden mb-12">
    <!-- Header/Banner -->
    <div class="relative h-64 sm:h-80 bg-slate-900 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-900/90 to-slate-900/80 z-10"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20 z-0"></div>
        
        <div class="absolute bottom-0 left-0 right-0 p-8 sm:p-12 z-20">
            <div class="flex flex-col md:flex-row md:items-end justify-between">
                <div>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-md border border-white/20">
                            {{ $event->tanggal_mulai->format('d M Y') }} - {{ $event->tanggal_selesai->format('d M Y') }}
                        </span>
                        @if($isDeadlinePassed)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-500/80 text-white backdrop-blur-md border border-red-500/50">
                                Pendaftaran Ditutup
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/80 text-white backdrop-blur-md border border-emerald-500/50">
                                Pendaftaran Dibuka
                            </span>
                        @endif
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-2">
                        {{ $event->nama_event }}
                    </h1>
                    <p class="text-indigo-200 text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $event->lokasi }}
                    </p>
                </div>
                
                @if(!$isDeadlinePassed)
                <div class="mt-6 md:mt-0">
                    <a href="{{ route('perkumpulan.pendaftaran.create', $event->id) }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent rounded-xl shadow-lg text-base font-bold text-indigo-900 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-900 focus:ring-white transition-all duration-300 transform hover:-translate-y-1">
                        Daftar Sekarang
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="p-8 sm:p-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Left Column: Info & Schedule -->
            <div class="lg:col-span-2 space-y-12">
                
                <section>
                    <h3 class="text-2xl font-bold text-slate-800 mb-6 flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        Informasi Kejuaraan
                    </h3>
                    <div class="prose prose-indigo max-w-none text-slate-600">
                        {!! nl2br(e($event->deskripsi ?? 'Tidak ada deskripsi tersedia untuk event ini.')) !!}
                    </div>
                </section>

                <hr class="border-slate-100">

                <section>
                    <h3 class="text-2xl font-bold text-slate-800 mb-6 flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        Kategori & Nomor Lomba
                    </h3>
                    
                    @forelse($event->kelompokUmur as $ku)
                        <div class="mb-6 bg-slate-50 rounded-xl border border-slate-200 overflow-hidden">
                            <div class="px-6 py-4 bg-slate-100/50 border-b border-slate-200 flex justify-between items-center">
                                <h4 class="font-bold text-slate-800">{{ $ku->nama_ku }}</h4>
                                <span class="text-sm font-medium text-slate-500">
                                    Min: {{ $ku->min_umur ?? 0 }} | Max: {{ $ku->max_umur ?? 'Unlimited' }} thn
                                </span>
                            </div>
                            <div class="p-6">
                                <ul class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @forelse($ku->nomorLomba as $nomor)
                                        <li class="flex items-center text-slate-600 bg-white p-3 rounded-lg border border-slate-100 shadow-sm">
                                            <svg class="w-4 h-4 mr-3 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $nomor->nama_nomor }}
                                        </li>
                                    @empty
                                        <li class="text-slate-400 italic text-sm">Belum ada nomor lomba</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500 italic bg-slate-50 p-6 rounded-xl border border-slate-200 text-center">Data kelompok umur belum tersedia.</p>
                    @endforelse
                </section>
            </div>

            <!-- Right Column: Sidebar Info -->
            <div class="space-y-8">
                <!-- Registration Card -->
                <div class="bg-indigo-50 rounded-2xl p-6 border border-indigo-100 relative overflow-hidden shadow-sm">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-24 h-24 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>
                    </div>
                    
                    <h4 class="text-lg font-bold text-indigo-900 mb-4 relative z-10">Status Pendaftaran</h4>
                    
                    <div class="space-y-4 relative z-10">
                        <div>
                            <p class="text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-1">Batas Akhir</p>
                            <p class="text-lg font-medium text-indigo-900">{{ $event->deadline_pendaftaran->format('d F Y, H:i') }}</p>
                        </div>
                        
                        <div>
                            <p class="text-xs font-semibold text-indigo-400 uppercase tracking-wider mb-1">Sisa Waktu</p>
                            <p class="text-xl font-bold {{ $isDeadlinePassed ? 'text-red-600' : 'text-emerald-600' }}">
                                @if($isDeadlinePassed)
                                    Waktu Habis
                                @else
                                    {{ $sisaWaktu }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contact/Help -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm">
                    <h4 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Butuh Bantuan?
                    </h4>
                    <p class="text-sm text-slate-600 mb-4">Jika Anda mengalami kendala pendaftaran atau memiliki pertanyaan seputar kejuaraan.</p>
                    <a href="#" class="inline-flex w-full justify-center items-center px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 transition-colors">
                        Hubungi Panitia
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
