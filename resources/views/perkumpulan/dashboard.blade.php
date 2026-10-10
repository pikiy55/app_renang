@extends('layouts.app')

@section('title', 'Data Atlet & Rekap Pendaftaran - Perkumpulan')

@section('content')
{{-- Hero Banner Perkumpulan (Dark Blue #172B4D) --}}
<div class="bg-navy text-white shadow-md border-b border-[#1F365D]" style="background-color: #172B4D;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            {{-- Profile Info --}}
            <div class="flex items-start sm:items-center space-x-4">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl flex items-center justify-center font-black text-2xl sm:text-3xl shadow-lg shrink-0 border border-cyan/30"
                     style="background-color: #20B8D4; color: #172B4D;">
                    {{ strtoupper(substr(auth()->user()->nama_klub ?? auth()->user()->name, 0, 2)) }}
                </div>
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                        <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider border border-cyan/30"
                              style="background-color: rgba(32, 184, 212, 0.15); color: #20B8D4;">
                            <span class="w-2 h-2 rounded-full animate-pulseDot" style="background-color: #20B8D4;"></span>
                            Perkumpulan Renang
                        </span>
                        @if(auth()->user()->whatsapp)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium border border-white/20 text-slate-200"
                                  style="background-color: rgba(255, 255, 255, 0.08);">
                                <svg class="w-3 h-3 text-cyan" style="color: #20B8D4;" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.842-.981z"/></svg>
                                {{ auth()->user()->whatsapp }}
                            </span>
                        @endif
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                        {{ auth()->user()->nama_klub ?? auth()->user()->name }}
                    </h1>
                    <p class="text-slate-300 text-xs sm:text-sm mt-1 flex flex-wrap items-center gap-2">
                        <span>PIC: <strong class="text-white">{{ auth()->user()->name }}</strong></span>
                        <span class="text-slate-400">•</span>
                        <span>{{ auth()->user()->email }}</span>
                    </p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('perkumpulan.dashboard') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold shadow-md hover:scale-[1.02] transition-all duration-200"
                   style="background-color: #20B8D4; color: #172B4D;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span>Daftar Event Kejuaraan</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl flex items-start border border-[#BBE7F0] shadow-sm animate-fadeIn"
             style="background-color: #DFF6FA; color: #1796AD;">
            <div class="p-2 rounded-xl mr-3 shrink-0" style="background-color: rgba(32, 184, 212, 0.2);">
                <svg class="w-5 h-5" style="color: #1796AD;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-sm" style="color: #172B4D;">Berhasil!</h4>
                <p class="text-sm mt-0.5 text-slate-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 rounded-2xl flex items-start border border-[#FFA1A1] shadow-sm animate-fadeIn"
             style="background-color: #FFF2F2; color: #E25050;">
            <div class="p-2 rounded-xl mr-3 shrink-0" style="background-color: rgba(255, 107, 107, 0.2);">
                <svg class="w-5 h-5" style="color: #E25050;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-sm" style="color: #E25050;">Perhatian</h4>
                <p class="text-sm mt-0.5 text-slate-700">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    {{-- Stats Cards Grid (KPI Metrics) -- FIXED: NO OVERLAPPING CIRCLES --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-8">
        {{-- Card 1: Master Atlet --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Atlet Terdaftar</span>
                <div class="w-9 h-9 rounded-xl flex items-center justify-center border border-[#BBE7F0]"
                     style="background-color: #DFF6FA;">
                    <svg class="w-5 h-5" style="color: #1796AD;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-black my-1" style="color: #172B4D;">{{ $stats['total_master_atlet'] }}</p>
            <p class="text-xs text-slate-500 font-medium">Database atlet perkumpulan</p>
        </div>

        {{-- Card 2: Catatan Limit Waktu --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Catatan Waktu</span>
                <div class="w-9 h-9 rounded-xl flex items-center justify-center border border-[#BBE7F0]"
                     style="background-color: #DFF6FA;">
                    <svg class="w-5 h-5" style="color: #1796AD;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-black my-1" style="color: #172B4D;">{{ $stats['total_riwayat_waktu'] }}</p>
            <p class="text-xs text-slate-500 font-medium">Rekor limit waktu tersimpan</p>
        </div>

        {{-- Card 3: Pendaftaran Event --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pendaftaran Lomba</span>
                <div class="w-9 h-9 rounded-xl flex items-center justify-center border border-[#BBE7F0]"
                     style="background-color: #DFF6FA;">
                    <svg class="w-5 h-5" style="color: #1796AD;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-black my-1" style="color: #172B4D;">{{ $stats['total_pendaftaran'] }}</p>
            <p class="text-xs text-slate-500 font-medium">Entri lomba diikuti</p>
        </div>

        {{-- Card 4: Event Aktif --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Event Aktif</span>
                <div class="w-9 h-9 rounded-xl flex items-center justify-center border border-[#BBE7F0]"
                     style="background-color: #DFF6FA;">
                    <svg class="w-5 h-5" style="color: #1796AD;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <p class="text-3xl font-black my-1" style="color: #172B4D;">{{ $stats['total_event_aktif'] }}</p>
            <p class="text-xs text-slate-500 font-medium">Kejuaraan dibuka</p>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
        <div class="border-b border-slate-200 bg-slate-50 px-4 sm:px-6 py-3 flex flex-wrap items-center justify-between gap-4">
            {{-- Tab Buttons --}}
            <nav class="flex space-x-2 sm:space-x-3" aria-label="Tabs">
                <button type="button"
                        id="tab-btn-master"
                        onclick="switchTab('master')"
                        class="tab-btn px-4 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 transition-all"
                        style="background-color: #172B4D; color: #ffffff;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span>Data Atlet Perkumpulan</span>
                    <span class="tab-badge ml-1 px-2 py-0.5 rounded-full text-xs font-bold"
                          style="background-color: #20B8D4; color: #172B4D;">
                        {{ $stats['total_master_atlet'] }}
                    </span>
                </button>

                <button type="button"
                        id="tab-btn-pendaftaran"
                        onclick="switchTab('pendaftaran')"
                        class="tab-btn px-4 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <span>Pendaftaran di Event</span>
                    <span class="tab-badge ml-1 px-2 py-0.5 rounded-full text-xs bg-slate-200 text-slate-700 font-semibold">
                        {{ $stats['total_pendaftaran'] }}
                    </span>
                </button>

                <button type="button"
                        id="tab-btn-event"
                        onclick="switchTab('event')"
                        class="tab-btn px-4 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Event Aktif</span>
                    <span class="tab-badge ml-1 px-2 py-0.5 rounded-full text-xs bg-slate-200 text-slate-700 font-semibold">
                        {{ $stats['total_event_aktif'] }}
                    </span>
                </button>
            </nav>
        </div>

        {{-- TAB 1: MASTER DATA ATLET PERKUMPULAN --}}
        <div id="tab-content-master" class="tab-pane p-5 sm:p-6">
            {{-- Top Toolbar --}}
            <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-extrabold flex items-center gap-2" style="color: #172B4D;">
                        <span>Daftar Atlet Terdaftar pada Perkumpulan</span>
                        <span class="text-xs font-bold px-2.5 py-0.5 rounded-full border border-cyan/30"
                              style="background-color: #DFF6FA; color: #1796AD;">
                            {{ $masterAtletGrouped->count() }} Atlet
                        </span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Database seluruh atlet yang terdaftar dalam perkumpulan dan riwayat catatan waktu kejuaraan.
                    </p>
                </div>

                {{-- Toolbar Actions (Tambah Atlet & Search Bar) --}}
                <div class="flex flex-wrap sm:flex-nowrap items-center gap-2.5">
                    <button type="button"
                            onclick="openTambahAtletModal()"
                            class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold text-navy shadow-md hover:scale-[1.02] transition-all"
                            style="background-color: #20B8D4; color: #172B4D;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        <span>Tambah Atlet</span>
                    </button>

                    {{-- Search Bar --}}
                    <form action="{{ route('perkumpulan.rekap') }}" method="GET" class="flex items-center gap-2 flex-1 sm:flex-initial">
                        <input type="hidden" name="tab" value="master">
                        <div class="relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text"
                                   name="search_atlet"
                                   value="{{ request('search_atlet') }}"
                                   placeholder="Cari nama atlet..."
                                   class="w-full pl-9 pr-3.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-cyan focus:bg-white transition-all">
                        </div>
                        @if(request('search_atlet'))
                            <a href="{{ route('perkumpulan.rekap', ['tab' => 'master']) }}" class="shrink-0 px-3 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                                Reset
                            </a>
                        @endif
                        <button type="submit" class="shrink-0 px-4 py-2 rounded-xl text-sm font-bold text-white transition-colors shadow-sm"
                                style="background-color: #172B4D;">
                            Cari
                        </button>
                    </form>
                </div>
            </div>

            {{-- Master Atlet Table --}}
            @if($masterAtletGrouped->count() > 0)
                <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider w-12">No</th>
                                <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Atlet</th>
                                <th class="px-4 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Gender</th>
                                <th class="px-4 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tgl Lahir & Usia</th>
                                <th class="px-4 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Estimasi KU</th>
                                <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nomor & Limit Waktu</th>
                                <th class="px-4 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @foreach($masterAtletGrouped as $index => $atlet)
                                @php
                                    $tglLahir = $atlet->tanggal_lahir;
                                    $usia = $tglLahir ? \Carbon\Carbon::parse($tglLahir)->age : null;
                                    $kuLabel = '-';
                                    $kuBadge = 'bg-slate-100 text-slate-700 border-slate-200';
                                    if ($usia !== null) {
                                        if ($usia <= 8) {
                                            $kuLabel = 'KU 5 (≤ 8 th)';
                                            $kuBadge = 'bg-teal-50 text-teal-700 border-teal-200';
                                        } elseif ($usia <= 10) {
                                            $kuLabel = 'KU 4 (9-10 th)';
                                            $kuBadge = 'bg-cyan-50 text-cyan-700 border-cyan-200';
                                        } elseif ($usia <= 12) {
                                            $kuLabel = 'KU 3 (11-12 th)';
                                            $kuBadge = 'bg-blue-50 text-blue-700 border-blue-200';
                                        } elseif ($usia <= 14) {
                                            $kuLabel = 'KU 2 (13-14 th)';
                                            $kuBadge = 'bg-indigo-50 text-indigo-700 border-indigo-200';
                                        } elseif ($usia <= 18) {
                                            $kuLabel = 'KU 1 (15-18 th)';
                                            $kuBadge = 'bg-purple-50 text-purple-700 border-purple-200';
                                        } else {
                                            $kuLabel = 'Senior (19+ th)';
                                            $kuBadge = 'bg-amber-50 text-amber-700 border-amber-200';
                                        }
                                    }
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    {{-- No --}}
                                    <td class="px-4 py-4 text-center text-xs text-slate-400 font-semibold">
                                        {{ $index + 1 }}
                                    </td>

                                    {{-- Nama Atlet --}}
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shrink-0 shadow-sm border border-[#BBE7F0]"
                                                 style="background-color: #DFF6FA; color: #1796AD;">
                                                {{ strtoupper(substr($atlet->nama_atlet, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-extrabold leading-snug" style="color: #172B4D;">
                                                    {{ $atlet->nama_atlet }}
                                                </div>
                                                <div class="text-xs text-slate-500 mt-0.5 flex items-center gap-2">
                                                    <span>{{ $atlet->total_nomor }} catatan waktu</span>
                                                    <span>•</span>
                                                    <span class="{{ $atlet->total_daftar > 0 ? 'font-bold' : 'text-slate-400' }}"
                                                          style="{{ $atlet->total_daftar > 0 ? 'color: #1796AD;' : '' }}">
                                                        {{ $atlet->total_daftar }} lomba event
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Gender --}}
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        @if($atlet->jenis_kelamin === 'putra')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold border border-cyan/30"
                                                  style="background-color: #DFF6FA; color: #1796AD;">
                                                Putra
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold border border-coral/30"
                                                  style="background-color: rgba(255, 107, 107, 0.12); color: #E25050;">
                                                Putri
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Tanggal Lahir & Usia --}}
                                    <td class="px-4 py-4 whitespace-nowrap text-xs">
                                        @if($tglLahir)
                                            <span class="font-bold text-slate-800">{{ $tglLahir->format('d M Y') }}</span>
                                            <span class="text-slate-500 block mt-0.5">({{ $usia }} tahun)</span>
                                        @else
                                            <span class="text-slate-400 italic">Belum diisi</span>
                                        @endif
                                    </td>

                                    {{-- Estimasi KU --}}
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold border {{ $kuBadge }}">
                                            {{ $kuLabel }}
                                        </span>
                                    </td>

                                    {{-- Nomor & Limit Waktu Preview --}}
                                    <td class="px-5 py-4">
                                        <div class="flex flex-wrap gap-1.5 max-w-md">
                                            @forelse($atlet->riwayat->take(3) as $rw)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs bg-slate-100 text-slate-700 border border-slate-200">
                                                    <span class="font-semibold">{{ $rw->jarak }}m {{ ucfirst($rw->gaya) }}:</span>
                                                    <span class="font-mono font-bold" style="color: #1796AD;">{{ $rw->limit_waktu }}</span>
                                                </span>
                                            @empty
                                                <span class="text-xs text-slate-400 italic">Belum ada catatan limit waktu</span>
                                            @endforelse
                                            @if($atlet->riwayat->count() > 3)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[11px] font-bold border border-cyan/30"
                                                      style="background-color: #DFF6FA; color: #1796AD;">
                                                    +{{ $atlet->riwayat->count() - 3 }} lainnya
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-1.5">
                                            {{-- Detail Waktu & Event Modal --}}
                                            <button type="button"
                                                    onclick='openRiwayatModal(@json($atlet))'
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl text-xs font-bold transition-all border border-[#BBE7F0] shadow-sm hover:scale-105"
                                                    style="background-color: #DFF6FA; color: #1796AD;"
                                                    title="Lihat Detail Riwayat & Keikutsertaan Event">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                <span>Detail</span>
                                            </button>

                                            {{-- Tambah Catatan Waktu --}}
                                            <button type="button"
                                                    onclick='openTambahWaktuModal(@json($atlet->nama_atlet))'
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-xl text-xs font-bold text-navy transition-all shadow-sm hover:scale-105"
                                                    style="background-color: #20B8D4; color: #172B4D;"
                                                    title="Tambah Catatan Limit Waktu">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                                <span>+ Waktu</span>
                                            </button>

                                            {{-- Edit Profil Atlet --}}
                                            <button type="button"
                                                    onclick='openEditAtletModal(@json($atlet->nama_atlet), @json($atlet->tanggal_lahir ? $atlet->tanggal_lahir->format("Y-m-d") : ""), @json($atlet->jenis_kelamin))'
                                                    class="p-1.5 rounded-xl text-slate-600 hover:text-navy hover:bg-slate-100 border border-slate-200 transition-colors"
                                                    title="Edit Profil Atlet">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>

                                            {{-- Hapus Atlet --}}
                                            <form action="{{ route('perkumpulan.atlet.destroy') }}"
                                                  method="POST"
                                                  class="inline-block"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus atlet {{ $atlet->nama_atlet }} dari daftar perkumpulan? Data riwayat waktu atlet ini akan terhapus.');">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="nama_atlet" value="{{ $atlet->nama_atlet }}">
                                                <button type="submit"
                                                        class="p-1.5 rounded-xl text-coral hover:text-coral-dark hover:bg-coral/10 border border-slate-200 transition-colors"
                                                        title="Hapus Atlet">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-slate-50 rounded-2xl border border-dashed border-slate-300 p-12 text-center">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-[#BBE7F0]"
                         style="background-color: #DFF6FA;">
                        <svg class="w-8 h-8" style="color: #1796AD;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h4 class="text-base font-extrabold mb-1" style="color: #172B4D;">Belum Ada Data Atlet Terdaftar</h4>
                    <p class="text-sm text-slate-500 max-w-md mx-auto mb-5 leading-relaxed">
                        Data seluruh atlet yang terdaftar dalam perkumpulan Anda akan ditampilkan di sini. Anda dapat menambahkan atlet baru secara manual atau atlet otomatis tersimpan saat didaftarkan ke event kejuaraan.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-3">
                        <button type="button"
                                onclick="openTambahAtletModal()"
                                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-navy shadow-md hover:scale-[1.02] transition-all"
                                style="background-color: #20B8D4; color: #172B4D;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Atlet Baru
                        </button>
                        <a href="{{ route('perkumpulan.dashboard') }}"
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-slate-700 border border-slate-300 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors shadow-sm">
                            <svg class="w-4 h-4" style="color: #1796AD;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Daftarkan Atlet ke Event
                        </a>
                    </div>
                </div>
            @endif
        </div>

        {{-- TAB 2: PENDAFTARAN ATLET DI EVENT --}}
        <div id="tab-content-pendaftaran" class="tab-pane p-5 sm:p-6 hidden">
            {{-- Toolbar Filters --}}
            <div class="mb-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-extrabold flex items-center gap-2" style="color: #172B4D;">
                        <span>Pendaftaran Atlet di Kejuaraan</span>
                        <span class="text-xs font-bold px-2.5 py-0.5 rounded-full border border-cyan/30"
                              style="background-color: #DFF6FA; color: #1796AD;">
                            {{ $myPendaftaran->total() }} Entri
                        </span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Daftar atlet yang sedang diikutsertakan dalam berbagai event kejuaraan renang.
                    </p>
                </div>

                <form action="{{ route('perkumpulan.rekap') }}" method="GET" class="flex flex-wrap items-center gap-2">
                    <input type="hidden" name="tab" value="pendaftaran">

                    {{-- Filter Event --}}
                    <select name="event_id" onchange="this.form.submit()" class="px-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan">
                        <option value="">Semua Event Kejuaraan</option>
                        @foreach($events as $ev)
                            <option value="{{ $ev->id }}" {{ request('event_id') == $ev->id ? 'selected' : '' }}>
                                {{ $ev->nama_event }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Search Nama --}}
                    <div class="relative w-44 sm:w-56">
                        <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text"
                               name="search_pendaftaran"
                               value="{{ request('search_pendaftaran') }}"
                               placeholder="Cari atlet..."
                               class="w-full pl-8 pr-3 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-cyan">
                    </div>

                    @if(request('event_id') || request('search_pendaftaran'))
                        <a href="{{ route('perkumpulan.rekap', ['tab' => 'pendaftaran']) }}" class="shrink-0 px-2.5 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                            Reset
                        </a>
                    @endif
                    <button type="submit" class="shrink-0 px-3.5 py-2 rounded-xl text-xs font-bold text-white transition-colors shadow-sm"
                            style="background-color: #172B4D;">
                        Filter
                    </button>
                </form>
            </div>

            {{-- Pendaftaran Table --}}
            @if($myPendaftaran->count() > 0)
                <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Atlet</th>
                                <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Event Kejuaraan</th>
                                <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">KU & Nomor Lomba</th>
                                <th class="px-4 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Limit Waktu</th>
                                <th class="px-4 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @foreach($myPendaftaran as $daftar)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    {{-- Atlet --}}
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="text-sm font-extrabold" style="color: #172B4D;">{{ $daftar->nama_atlet }}</div>
                                        <div class="text-xs text-slate-500 flex items-center gap-1.5 mt-0.5">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold {{ $daftar->jenis_kelamin === 'putra' ? 'border border-cyan/30 text-cyan' : 'border border-coral/30 text-coral' }}"
                                                  style="{{ $daftar->jenis_kelamin === 'putra' ? 'background-color: #DFF6FA; color: #1796AD;' : 'background-color: rgba(255, 107, 107, 0.12); color: #E25050;' }}">
                                                {{ ucfirst($daftar->jenis_kelamin) }}
                                            </span>
                                            <span>Lahir: {{ $daftar->tanggal_lahir?->format('d/m/Y') }}</span>
                                        </div>
                                    </td>

                                    {{-- Event --}}
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-slate-800">{{ $daftar->event->nama_event ?? '-' }}</div>
                                        <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                            {{ $daftar->event->lokasi ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- KU & Nomor --}}
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="text-xs font-bold px-2 py-0.5 rounded border border-[#BBE7F0] inline-block mb-1"
                                             style="background-color: #DFF6FA; color: #1796AD;">
                                            {{ $daftar->kelompokUmur->nama_ku ?? '-' }}
                                        </div>
                                        <div class="text-sm font-semibold text-slate-700">
                                            {{ $daftar->nomorLomba->nama_nomor ?? '-' }}
                                        </div>
                                    </td>

                                    {{-- Waktu --}}
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        @if($daftar->status_waktu === 'NT')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                                NT
                                            </span>
                                        @else
                                            <span class="text-xs font-mono font-bold px-2.5 py-1 rounded border border-[#BBE7F0]"
                                                  style="background-color: #DFF6FA; color: #1796AD;">
                                                {{ $daftar->limit_waktu }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        @if($daftar->isLocked())
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200" title="Terkunci (Melewati Deadline)">
                                                <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                Terkunci
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold border border-cyan/30"
                                                  style="background-color: #DFF6FA; color: #1796AD;">
                                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 animate-pulseDot" style="background-color: #20B8D4;"></span>
                                                Aktif
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-4 py-4 whitespace-nowrap text-right text-xs font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            @if(!$daftar->isLocked())
                                                <a href="{{ route('perkumpulan.pendaftaran.edit', $daftar) }}"
                                                   class="p-1.5 text-slate-600 hover:text-navy hover:bg-slate-100 rounded-lg transition-colors"
                                                   title="Edit Data Pendaftaran">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>
                                                <form action="{{ route('perkumpulan.pendaftaran.destroy', $daftar) }}"
                                                      method="POST"
                                                      class="inline-block"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran {{ $daftar->nama_atlet }} pada nomor ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="p-1.5 text-coral hover:text-coral-dark hover:bg-coral/10 rounded-lg transition-colors"
                                                            title="Batalkan Pendaftaran">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-slate-400 text-xs italic">Terkunci</span>
                                            @endif
                                            @if($daftar->event_id)
                                                <a href="{{ route('perkumpulan.event.dashboard', $daftar->event_id) }}"
                                                   class="p-1.5 text-slate-600 hover:text-navy hover:bg-slate-100 rounded-lg transition-colors"
                                                   title="Ke Dashboard Event">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($myPendaftaran->hasPages())
                    <div class="mt-4">
                        {{ $myPendaftaran->links() }}
                    </div>
                @endif
            @else
                <div class="bg-slate-50 rounded-2xl border border-dashed border-slate-300 p-12 text-center">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-[#BBE7F0]"
                         style="background-color: #DFF6FA;">
                        <svg class="w-8 h-8" style="color: #1796AD;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h4 class="text-base font-extrabold mb-1" style="color: #172B4D;">Belum Ada Pendaftaran Event</h4>
                    <p class="text-sm text-slate-500 max-w-md mx-auto mb-4 leading-relaxed">
                        Perkumpulan Anda belum mendaftarkan atlet ke event kejuaraan renang yang aktif saat ini.
                    </p>
                    <a href="{{ route('perkumpulan.dashboard') }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-navy shadow-md hover:scale-[1.02] transition-all"
                       style="background-color: #20B8D4; color: #172B4D;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Pilih Event Kejuaraan
                    </a>
                </div>
            @endif
        </div>

        {{-- TAB 3: EVENT AKTIF --}}
        <div id="tab-content-event" class="tab-pane p-5 sm:p-6 hidden">
            <div class="mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-extrabold flex items-center gap-2" style="color: #172B4D;">
                        <span>Event Kejuaraan Renang Aktif</span>
                        <span class="text-xs font-bold px-2.5 py-0.5 rounded-full border border-cyan/30"
                              style="background-color: #DFF6FA; color: #1796AD;">
                            {{ $events->count() }} Event
                        </span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Pilih event untuk mengelola pendaftaran atlet dan nomor lomba yang diikuti.
                    </p>
                </div>
            </div>

            @forelse($events as $event)
                @php
                    $isDeadlinePassed = $event->isDeadlinePassed();
                    $atletCount = $event->pendaftaran->where('user_id', auth()->id())->count();
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-md hover:border-cyan/50 transition-all duration-200 mb-4">
                    <div class="flex flex-col sm:flex-row">
                        <div class="sm:w-2.5 {{ $isDeadlinePassed ? 'bg-slate-300' : 'bg-gradient-to-b from-cyan to-cyan-dark' }} shrink-0"
                             style="{{ $isDeadlinePassed ? 'background-color: #CBD5E1;' : 'background: linear-gradient(180deg, #20B8D4, #1796AD);' }}"></div>
                        <div class="flex-1 p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <h4 class="font-extrabold text-base hover:text-cyan transition-colors" style="color: #172B4D;">
                                        {{ $event->nama_event }}
                                    </h4>
                                    @if($isDeadlinePassed)
                                        <span class="shrink-0 inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[10px] font-bold border border-coral/30"
                                              style="background-color: rgba(255, 107, 107, 0.12); color: #E25050;">Ditutup</span>
                                    @else
                                        <span class="shrink-0 inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[10px] font-bold border border-cyan/30"
                                              style="background-color: #DFF6FA; color: #1796AD;">
                                            <span class="w-1.5 h-1.5 rounded-full animate-pulseDot" style="background-color: #20B8D4;"></span>
                                            Dibuka
                                        </span>
                                    @endif
                                </div>
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 text-xs text-slate-500">
                                    <span class="inline-flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                        {{ $event->lokasi }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $event->tanggal_mulai->format('d M Y') }} – {{ $event->tanggal_selesai->format('d M Y') }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Deadline:
                                        <span class="font-bold {{ $isDeadlinePassed ? 'text-coral' : 'text-navy' }}"
                                              style="{{ $isDeadlinePassed ? 'color: #E25050;' : 'color: #172B4D;' }}">
                                            {{ $event->deadline_pendaftaran->format('d M Y, H:i') }}
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 shrink-0">
                                <div class="text-center px-3 border-r border-slate-200 sm:border-r-0">
                                    <p class="text-xl font-black" style="color: #172B4D;">{{ $atletCount }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Atlet Terdaftar</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if(!$isDeadlinePassed)
                                        <a href="{{ route('perkumpulan.pendaftaran.create', $event) }}"
                                           class="px-3.5 py-2 rounded-xl text-xs font-bold text-navy transition-colors shadow-sm inline-flex items-center gap-1.5"
                                           style="background-color: #20B8D4; color: #172B4D;">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                            Daftar Atlet
                                        </a>
                                    @endif
                                    <a href="{{ route('perkumpulan.event.dashboard', $event) }}"
                                       class="px-3.5 py-2 rounded-xl text-xs font-bold transition-colors border border-[#BBE7F0] inline-flex items-center gap-1"
                                       style="background-color: #DFF6FA; color: #1796AD;">
                                        Kelola Event
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                    <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <p class="text-sm font-semibold text-slate-600">Belum ada event aktif saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Modal Tambah Atlet Perkumpulan --}}
<div id="modal-tambah-atlet" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden animate-fadeIn">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
        <form action="{{ route('perkumpulan.atlet.store') }}" method="POST">
            @csrf
            <div class="px-6 py-4 text-white flex items-center justify-between"
                 style="background-color: #172B4D;">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-navy shadow-inner"
                         style="background-color: #20B8D4;">
                        <svg class="w-5 h-5 text-navy" style="color: #172B4D;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white leading-tight">Tambah Atlet Perkumpulan</h3>
                        <p class="text-xs text-slate-300">Daftarkan atlet ke database klub</p>
                    </div>
                </div>
                <button type="button" onclick="closeTambahAtletModal()" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Lengkap Atlet <span class="text-coral" style="color: #FF6B6B;">*</span>
                    </label>
                    <input type="text" name="nama_atlet" required placeholder="Contoh: Muhammad Farhan"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-cyan focus:bg-white transition-all">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Jenis Kelamin <span class="text-coral" style="color: #FF6B6B;">*</span>
                        </label>
                        <select name="jenis_kelamin" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-cyan">
                            <option value="putra">Putra</option>
                            <option value="putri">Putri</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Tanggal Lahir <span class="text-coral" style="color: #FF6B6B;">*</span>
                        </label>
                        <input type="date" name="tanggal_lahir" required
                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-cyan">
                    </div>
                </div>

                {{-- Catatan Waktu Awal (Opsional) --}}
                <div class="pt-3 border-t border-slate-200">
                    <span class="text-xs font-bold text-slate-700 block mb-2">Catatan Waktu Awal (Opsional)</span>
                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="block text-[11px] text-slate-500 mb-1">Jarak (m)</label>
                            <input type="number" name="jarak" placeholder="50" min="25"
                                   class="w-full px-2.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-cyan">
                        </div>
                        <div>
                            <label class="block text-[11px] text-slate-500 mb-1">Gaya</label>
                            <select name="gaya" class="w-full px-2 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs focus:ring-2 focus:ring-cyan">
                                <option value="">Pilih Gaya</option>
                                <option value="bebas">Bebas</option>
                                <option value="dada">Dada</option>
                                <option value="punggung">Punggung</option>
                                <option value="kupu">Kupu-kupu</option>
                                <option value="ganti_perorangan">Ganti Perorangan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] text-slate-500 mb-1">Limit Waktu</label>
                            <input type="text" name="limit_waktu" placeholder="00:32.50"
                                   class="w-full px-2.5 py-2 bg-slate-50 border border-slate-300 rounded-xl text-xs font-mono focus:ring-2 focus:ring-cyan">
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="closeTambahAtletModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-navy transition-all shadow-sm"
                        style="background-color: #20B8D4; color: #172B4D;">
                    Simpan Atlet
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Profil Atlet --}}
<div id="modal-edit-atlet" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden animate-fadeIn">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
        <form action="{{ route('perkumpulan.atlet.update') }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="old_nama_atlet" id="edit-atlet-old-nama">

            <div class="px-6 py-4 text-white flex items-center justify-between"
                 style="background-color: #172B4D;">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-navy shadow-inner"
                         style="background-color: #20B8D4;">
                        <svg class="w-5 h-5" style="color: #172B4D;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white leading-tight">Edit Data Atlet</h3>
                        <p class="text-xs text-slate-300">Perbarui identitas profil atlet perkumpulan</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditAtletModal()" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Lengkap Atlet <span class="text-coral" style="color: #FF6B6B;">*</span>
                    </label>
                    <input type="text" name="nama_atlet" id="edit-atlet-nama" required
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-cyan focus:bg-white transition-all">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Jenis Kelamin <span class="text-coral" style="color: #FF6B6B;">*</span>
                        </label>
                        <select name="jenis_kelamin" id="edit-atlet-gender" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-cyan">
                            <option value="putra">Putra</option>
                            <option value="putri">Putri</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Tanggal Lahir <span class="text-coral" style="color: #FF6B6B;">*</span>
                        </label>
                        <input type="date" name="tanggal_lahir" id="edit-atlet-tgl-lahir" required
                               class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-cyan">
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="closeEditAtletModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-navy transition-colors shadow-sm"
                        style="background-color: #20B8D4; color: #172B4D;">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Tambah Catatan Waktu --}}
<div id="modal-tambah-waktu" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden animate-fadeIn">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
        <form action="{{ route('perkumpulan.atlet.riwayat.store') }}" method="POST">
            @csrf
            <input type="hidden" name="nama_atlet" id="tambah-waktu-nama-atlet">

            <div class="px-6 py-4 text-white flex items-center justify-between"
                 style="background-color: #172B4D;">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-navy shadow-inner"
                         style="background-color: #20B8D4;">
                        <svg class="w-5 h-5" style="color: #172B4D;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-white leading-tight">Tambah Catatan Waktu</h3>
                        <p class="text-xs text-slate-300" id="tambah-waktu-display-nama">Nama Atlet</p>
                    </div>
                </div>
                <button type="button" onclick="closeTambahWaktuModal()" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Jarak Lomba <span class="text-coral" style="color: #FF6B6B;">*</span>
                        </label>
                        <select name="jarak" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-cyan">
                            <option value="25">25 meter</option>
                            <option value="50" selected>50 meter</option>
                            <option value="100">100 meter</option>
                            <option value="200">200 meter</option>
                            <option value="400">400 meter</option>
                            <option value="800">800 meter</option>
                            <option value="1500">1500 meter</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Gaya Renang <span class="text-coral" style="color: #FF6B6B;">*</span>
                        </label>
                        <select name="gaya" required class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-cyan">
                            <option value="bebas">Bebas</option>
                            <option value="dada">Dada</option>
                            <option value="punggung">Punggung</option>
                            <option value="kupu">Kupu-kupu</option>
                            <option value="ganti_perorangan">Ganti Perorangan</option>
                            <option value="ganti_estafet">Ganti Estafet</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Limit Waktu / Rekor Terbaik <span class="text-coral" style="color: #FF6B6B;">*</span>
                    </label>
                    <input type="text" name="limit_waktu" required placeholder="00:32.50 atau 01:15.00"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-cyan focus:bg-white transition-all">
                    <p class="text-[11px] text-slate-400 mt-1">Format: Menit:Detik.milidetik (contoh: 00:32.45 atau 01:12.80)</p>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="closeTambahWaktuModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-navy transition-colors shadow-sm"
                        style="background-color: #20B8D4; color: #172B4D;">
                    Simpan Catatan Waktu
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Detail Profil, Riwayat Waktu & Event Atlet --}}
<div id="modal-riwayat" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden animate-fadeIn">
    <div class="bg-white rounded-2xl max-w-2xl w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
        <div class="px-6 py-4 text-white flex items-center justify-between"
             style="background-color: #172B4D;">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-navy shadow-inner text-base"
                     id="modal-atlet-avatar" style="background-color: #20B8D4;">
                    A
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-white leading-tight" id="modal-atlet-nama">Nama Atlet</h3>
                    <div class="flex items-center gap-2 mt-0.5 text-xs text-slate-300">
                        <span id="modal-atlet-gender">Putra</span>
                        <span>•</span>
                        <span id="modal-atlet-ttl">Tgl Lahir</span>
                    </div>
                </div>
            </div>
            <button type="button" onclick="closeRiwayatModal()" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="p-6 max-h-[75vh] overflow-y-auto space-y-6">
            {{-- Section 1: Catatan Limit Waktu --}}
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-extrabold flex items-center gap-1.5" style="color: #172B4D;">
                        <svg class="w-4 h-4 text-cyan" style="color: #20B8D4;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Catatan Limit Waktu Perkumpulan</span>
                    </h4>
                    <button type="button" id="modal-btn-tambah-waktu" onclick=""
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-bold transition-all border border-[#BBE7F0]"
                            style="background-color: #DFF6FA; color: #1796AD;">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span>+ Waktu</span>
                    </button>
                </div>

                <div class="overflow-hidden rounded-xl border border-slate-200">
                    <table class="min-w-full divide-y divide-slate-200 text-xs">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-2.5 text-left font-bold text-slate-500 uppercase">Jarak & Gaya</th>
                                <th class="px-4 py-2.5 text-center font-bold text-slate-500 uppercase">Limit Waktu</th>
                                <th class="px-4 py-2.5 text-center font-bold text-slate-500 uppercase">Diperbarui</th>
                                <th class="px-3 py-2.5 text-right font-bold text-slate-500 uppercase">Hapus</th>
                            </tr>
                        </thead>
                        <tbody id="modal-riwayat-body" class="bg-white divide-y divide-slate-100">
                            {{-- Injected via JS --}}
                        </tbody>
                    </table>
                </div>
                <p class="text-[11px] text-slate-400 mt-2">
                    Catatan waktu ini digunakan sebagai acuan auto-complete saat mendaftar event kejuaraan.
                </p>
            </div>

            {{-- Section 2: Keikutsertaan Event Kejuaraan --}}
            <div class="pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-extrabold flex items-center gap-1.5" style="color: #172B4D;">
                        <svg class="w-4 h-4 text-cyan" style="color: #20B8D4;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Riwayat Pendaftaran di Event Kejuaraan</span>
                    </h4>
                </div>

                <div class="overflow-hidden rounded-xl border border-slate-200">
                    <table class="min-w-full divide-y divide-slate-200 text-xs">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-2.5 text-left font-bold text-slate-500 uppercase">Event</th>
                                <th class="px-4 py-2.5 text-left font-bold text-slate-500 uppercase">Nomor Lomba</th>
                                <th class="px-4 py-2.5 text-center font-bold text-slate-500 uppercase">Waktu Daftar</th>
                            </tr>
                        </thead>
                        <tbody id="modal-pendaftaran-body" class="bg-white divide-y divide-slate-100">
                            {{-- Injected via JS --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 flex justify-end">
            <button type="button" onclick="closeRiwayatModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Tab switching logic (Aligned with Dark Blue #172B4D & Cyan #20B8D4 theme)
    function switchTab(tab) {
        document.querySelectorAll('.tab-pane').forEach(el => el.classList.add('hidden'));

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.style.backgroundColor = '';
            btn.style.color = '';
            btn.classList.remove('shadow-sm');
            btn.classList.add('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-100');
            const badge = btn.querySelector('.tab-badge');
            if (badge) {
                badge.style.backgroundColor = '';
                badge.style.color = '';
                badge.className = 'tab-badge ml-1 px-2 py-0.5 rounded-full text-xs bg-slate-200 text-slate-700 font-semibold';
            }
        });

        const activePane = document.getElementById('tab-content-' + tab);
        const activeBtn = document.getElementById('tab-btn-' + tab);

        if (activePane && activeBtn) {
            activePane.classList.remove('hidden');
            activeBtn.classList.remove('text-slate-600', 'hover:text-slate-900', 'hover:bg-slate-100');
            activeBtn.style.backgroundColor = '#172B4D';
            activeBtn.style.color = '#ffffff';
            activeBtn.classList.add('shadow-sm');
            const badge = activeBtn.querySelector('.tab-badge');
            if (badge) {
                badge.className = 'tab-badge ml-1 px-2 py-0.5 rounded-full text-xs font-bold';
                badge.style.backgroundColor = '#20B8D4';
                badge.style.color = '#172B4D';
            }
        }

        history.replaceState(null, null, '#tab=' + tab);
    }

    // Modal Tambah Atlet
    function openTambahAtletModal() {
        document.getElementById('modal-tambah-atlet').classList.remove('hidden');
    }
    function closeTambahAtletModal() {
        document.getElementById('modal-tambah-atlet').classList.add('hidden');
    }

    // Modal Edit Atlet
    function openEditAtletModal(nama, tglLahir, gender) {
        document.getElementById('edit-atlet-old-nama').value = nama;
        document.getElementById('edit-atlet-nama').value = nama;
        document.getElementById('edit-atlet-tgl-lahir').value = tglLahir;
        document.getElementById('edit-atlet-gender').value = gender;
        document.getElementById('modal-edit-atlet').classList.remove('hidden');
    }
    function closeEditAtletModal() {
        document.getElementById('modal-edit-atlet').classList.add('hidden');
    }

    // Modal Tambah Waktu
    function openTambahWaktuModal(nama) {
        document.getElementById('tambah-waktu-nama-atlet').value = nama;
        document.getElementById('tambah-waktu-display-nama').innerText = 'Atlet: ' + nama;
        document.getElementById('modal-tambah-waktu').classList.remove('hidden');
    }
    function closeTambahWaktuModal() {
        document.getElementById('modal-tambah-waktu').classList.add('hidden');
    }

    // Modal Riwayat Lengkap Atlet
    function openRiwayatModal(atlet) {
        const nama = typeof atlet === 'string' ? atlet : atlet.nama_atlet;
        const riwayatData = atlet.riwayat || [];
        const pendaftaranData = atlet.pendaftarans || [];

        document.getElementById('modal-atlet-nama').innerText = nama;
        document.getElementById('modal-atlet-avatar').innerText = nama.charAt(0).toUpperCase();

        const genderText = atlet.jenis_kelamin ? (atlet.jenis_kelamin.charAt(0).toUpperCase() + atlet.jenis_kelamin.slice(1)) : 'Putra';
        document.getElementById('modal-atlet-gender').innerText = genderText;

        let ttlInfo = 'Tgl Lahir: -';
        if (atlet.tanggal_lahir) {
            const d = new Date(atlet.tanggal_lahir);
            ttlInfo = 'Lahir: ' + d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        }
        document.getElementById('modal-atlet-ttl').innerText = ttlInfo;

        document.getElementById('modal-btn-tambah-waktu').setAttribute('onclick', `openTambahWaktuModal('${nama.replace(/'/g, "\\'")}')`);

        // Populate Table Riwayat Waktu
        const tbodyRiwayat = document.getElementById('modal-riwayat-body');
        tbodyRiwayat.innerHTML = '';

        if (!riwayatData || riwayatData.length === 0) {
            tbodyRiwayat.innerHTML = '<tr><td colspan="4" class="px-4 py-5 text-center text-slate-400 italic">Belum ada catatan limit waktu tersimpan.</td></tr>';
        } else {
            riwayatData.forEach(item => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-slate-50 transition-colors';

                const gayaCapitalized = item.gaya ? (item.gaya.charAt(0).toUpperCase() + item.gaya.slice(1)) : '-';
                const updatedDate = item.updated_at ? new Date(item.updated_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';

                tr.innerHTML = `
                    <td class="px-4 py-2.5 whitespace-nowrap font-medium text-slate-800">
                        <span class="inline-block px-2 py-0.5 rounded text-xs font-bold mr-1.5" style="background-color: #DFF6FA; color: #1796AD;">${item.jarak}m</span>
                        ${gayaCapitalized}
                    </td>
                    <td class="px-4 py-2.5 whitespace-nowrap text-center">
                        <span class="font-mono font-bold text-xs px-2 py-0.5 rounded border border-[#BBE7F0]" style="background-color: #DFF6FA; color: #1796AD;">
                            ${item.limit_waktu || 'NT'}
                        </span>
                    </td>
                    <td class="px-4 py-2.5 whitespace-nowrap text-center text-slate-400">
                        ${updatedDate}
                    </td>
                    <td class="px-3 py-2.5 whitespace-nowrap text-right">
                        ${item.id ? `
                            <form action="/perkumpulan/atlet/riwayat-waktu/${item.id}" method="POST" onsubmit="return confirm('Hapus catatan waktu ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-coral hover:text-coral-dark p-1 rounded hover:bg-coral/10 transition-colors" title="Hapus catatan waktu">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        ` : '-'}
                    </td>
                `;
                tbodyRiwayat.appendChild(tr);
            });
        }

        // Populate Table Pendaftaran Event
        const tbodyPendaftaran = document.getElementById('modal-pendaftaran-body');
        tbodyPendaftaran.innerHTML = '';

        if (!pendaftaranData || pendaftaranData.length === 0) {
            tbodyPendaftaran.innerHTML = '<tr><td colspan="3" class="px-4 py-5 text-center text-slate-400 italic">Belum ada riwayat pendaftaran event kejuaraan.</td></tr>';
        } else {
            pendaftaranData.forEach(p => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-slate-50 transition-colors';
                const eventNama = p.event ? p.event.nama_event : '-';
                const nomorNama = p.nomor_lomba ? `${p.nomor_lomba.nama_nomor} (${p.nomor_lomba.jarak}m ${p.nomor_lomba.gaya})` : '-';
                const limitWaktu = p.limit_waktu || (p.status_waktu === 'NT' ? 'NT' : '-');

                tr.innerHTML = `
                    <td class="px-4 py-2.5 whitespace-nowrap font-bold" style="color: #172B4D;">
                        ${eventNama}
                    </td>
                    <td class="px-4 py-2.5 whitespace-nowrap text-slate-600">
                        ${nomorNama}
                    </td>
                    <td class="px-4 py-2.5 whitespace-nowrap text-center font-mono font-bold text-xs ${limitWaktu === 'NT' ? 'text-amber-600' : 'text-slate-700'}">
                        ${limitWaktu}
                    </td>
                `;
                tbodyPendaftaran.appendChild(tr);
            });
        }

        document.getElementById('modal-riwayat').classList.remove('hidden');
    }

    function closeRiwayatModal() {
        document.getElementById('modal-riwayat').classList.add('hidden');
    }

    // Check URL query or hash on load
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const urlTab = urlParams.get('tab');
        const hash = window.location.hash;

        if (urlTab) {
            switchTab(urlTab);
        } else if (hash && hash.startsWith('#tab=')) {
            const tabName = hash.replace('#tab=', '');
            switchTab(tabName);
        }
    });
</script>
@endpush
@endsection
