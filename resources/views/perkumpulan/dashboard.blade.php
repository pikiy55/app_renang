@extends('layouts.app')

@section('title', 'Rekap Pendaftaran - Perkumpulan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Rekap Pendaftaran</h2>
            <p class="text-sm text-slate-500 mt-1">Selamat datang, {{ auth()->user()->nama_klub ?? auth()->user()->name }}</p>
        </div>
        <a href="{{ route('perkumpulan.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Event
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-start">
            <svg class="w-5 h-5 mr-3 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h4 class="font-medium text-emerald-800">Berhasil!</h4>
                <p class="text-sm mt-1">{{ session('success') }}</p>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-start">
            <svg class="w-5 h-5 mr-3 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h4 class="font-medium text-red-800">Terdapat Kesalahan</h4>
                <p class="text-sm mt-1">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    {{-- Section Title --}}
    <h3 class="text-lg font-bold text-slate-800 flex items-center mb-5">
        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        Event Aktif
        <span class="ml-2 text-xs font-medium text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md">{{ $events->count() }} event</span>
    </h3>

    {{-- Event Cards Grid --}}
    @forelse($events as $event)
        @php
            $isDeadlinePassed = $event->isDeadlinePassed();
            $atletCount = $event->pendaftaran->where('user_id', auth()->id())->count();
        @endphp
        <a href="{{ route('perkumpulan.event.dashboard', $event) }}"
           class="group block bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-md hover:border-indigo-200 transition-all duration-200 mb-4">
            <div class="flex flex-col sm:flex-row">
                {{-- Left: Color accent --}}
                <div class="sm:w-2 {{ $isDeadlinePassed ? 'bg-slate-300' : 'bg-indigo-500' }} shrink-0"></div>

                {{-- Content --}}
                <div class="flex-1 p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    {{-- Event Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-bold text-slate-800 text-base group-hover:text-indigo-600 transition-colors truncate">
                                {{ $event->nama_event }}
                            </h4>
                            @if($isDeadlinePassed)
                                <span class="shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-100 text-red-600 border border-red-200">Ditutup</span>
                            @else
                                <span class="shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                    Dibuka
                                </span>
                            @endif
                        </div>
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500 mt-1">
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $event->tanggal_mulai->format('d M Y') }} – {{ $event->tanggal_selesai->format('d M Y') }}
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Deadline:
                                <span class="font-semibold {{ $isDeadlinePassed ? 'text-red-500' : 'text-slate-700' }}">
                                    {{ $event->deadline_pendaftaran->format('d M Y, H:i') }}
                                </span>
                            </span>
                        </div>
                    </div>

                    {{-- Right Side: Stats + Arrow --}}
                    <div class="flex items-center gap-4 shrink-0">
                        <div class="text-center px-3">
                            <p class="text-lg font-bold {{ $atletCount > 0 ? 'text-indigo-600' : 'text-slate-400' }}">{{ $atletCount }}</p>
                            <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">Atlet</p>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-indigo-100 flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @empty
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
            <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <p class="text-sm font-medium text-slate-600">Belum ada event aktif saat ini.</p>
        </div>
    @endforelse
</div>
@endsection
