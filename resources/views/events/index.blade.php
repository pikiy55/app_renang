@extends('layouts.app')

@section('title', 'Katalog Event Kejuaraan')

@section('content')
<div class="bg-gradient-to-b from-indigo-900 to-slate-900 -mt-10 pt-20 pb-24 px-4 sm:px-6 lg:px-8 shadow-inner mb-12">
    <div class="max-w-7xl mx-auto text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4">
            Kejuaraan Renang Nasional
        </h1>
        <p class="text-lg md:text-xl text-indigo-200 max-w-3xl mx-auto font-light">
            Temukan dan daftarkan atlet perkumpulan Anda di berbagai kejuaraan bergengsi. Berkompetisi dengan perenang terbaik di seluruh Indonesia.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20 -mt-16">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Event Berlangsung & Mendatang</h2>
        <div class="bg-white rounded-full px-4 py-2 text-sm font-medium text-slate-600 shadow-sm border border-slate-200">
            {{ count($events) }} Event Aktif
        </div>
    </div>

    @if(count($events) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($events as $event)
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg border border-slate-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col h-full group">
                    <div class="relative h-48 bg-slate-200 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent z-10"></div>
                        <!-- Placeholder Image -->
                        <div class="w-full h-full bg-indigo-100 flex items-center justify-center group-hover:scale-105 transition-transform duration-500">
                            <svg class="w-20 h-20 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4 z-20 flex justify-between items-end">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-white/20 text-white backdrop-blur-sm border border-white/30">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $event['tanggal_mulai'] }}
                            </span>
                            @if($event['is_deadline_passed'])
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-red-500 text-white shadow-sm">
                                    Ditutup
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-500 text-white shadow-sm">
                                    Dibuka
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-xl font-bold text-slate-800 mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                            {{ $event['nama_event'] }}
                        </h3>
                        
                        <div class="mt-2 space-y-2 mb-6">
                            <div class="flex items-start text-sm text-slate-600">
                                <svg class="w-5 h-5 mr-2 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="line-clamp-1">{{ $event['lokasi'] }}</span>
                            </div>
                            
                            <div class="flex items-start text-sm text-slate-600">
                                <svg class="w-5 h-5 mr-2 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Deadline: <span class="font-medium text-slate-800">{{ $event['deadline_pendaftaran'] }}</span></span>
                            </div>
                        </div>
                        
                        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                            <div class="text-xs font-medium {{ $event['is_deadline_passed'] ? 'text-red-500' : 'text-orange-500' }}">
                                @if($event['is_deadline_passed'])
                                    Waktu habis
                                @else
                                    Sisa: {{ $event['sisa_waktu'] }}
                                @endif
                            </div>
                            
                            <a href="{{ route('events.show', $event['id']) }}" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                                Detail Event
                                <svg class="ml-1 w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Event</h3>
            <p class="text-slate-500 max-w-md mx-auto">Saat ini belum ada kejuaraan renang yang aktif atau dibuka untuk pendaftaran. Silakan kembali lagi nanti.</p>
        </div>
    @endif
</div>
@endsection
