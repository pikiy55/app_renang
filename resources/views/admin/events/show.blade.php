@extends('layouts.admin')

@section('title', 'Detail Event')
@section('header_title', 'Detail Kejuaraan')
@section('header_subtitle', $event->nama_event)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.events.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Event
    </a>
    
    <div class="flex space-x-3">
        <a href="{{ route('admin.export.pendaftaran', $event) }}" class="inline-flex items-center px-4 py-2 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-sm font-semibold hover:bg-emerald-100 transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export Pendaftaran
        </a>
        <a href="{{ route('admin.events.edit', $event) }}" class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-lg text-sm font-semibold hover:bg-indigo-100 transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Edit Event
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Info Section (Left Column) -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Event Details Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-800">Informasi Event</h3>
                @if($event->is_active)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">Aktif</span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-800 border border-slate-200">Draft</span>
                @endif
            </div>
            <div class="p-6">
                <dl class="divide-y divide-slate-100 text-sm">
                    <div class="py-3 flex justify-between">
                        <dt class="text-slate-500 font-medium">Tanggal Pelaksanaan</dt>
                        <dd class="text-slate-800 font-semibold text-right">
                            {{ $event->tanggal_mulai?->format('d M Y') }} - {{ $event->tanggal_selesai?->format('d M Y') }}
                        </dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="text-slate-500 font-medium">Lokasi</dt>
                        <dd class="text-slate-800 font-semibold text-right">{{ $event->lokasi ?? '-' }}</dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="text-slate-500 font-medium">Batas Pendaftaran</dt>
                        <dd class="text-right">
                            <div class="font-semibold {{ $event->isDeadlinePassed() ? 'text-red-600' : 'text-emerald-600' }}">
                                {{ $event->deadline_pendaftaran?->format('d M Y, H:i') }}
                            </div>
                            <div class="text-xs text-slate-400 mt-0.5">
                                {{ $event->isDeadlinePassed() ? '(Sudah Ditutup)' : '(Masih Dibuka)' }}
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50">
                <h3 class="text-base font-bold text-slate-800">Statistik Pendaftaran</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100 text-center">
                        <div class="text-3xl font-extrabold text-indigo-600 mb-1">{{ $totalPendaftaran }}</div>
                        <div class="text-xs font-semibold text-indigo-800 uppercase tracking-wide">Total Atlet</div>
                    </div>
                    <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100 text-center">
                        <div class="text-3xl font-extrabold text-emerald-600 mb-1">{{ $totalKlub }}</div>
                        <div class="text-xs font-semibold text-emerald-800 uppercase tracking-wide">Klub Peserta</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Section (Right Column) -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Kelompok Umur Management -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <div>
                    <h3 class="text-base font-bold text-slate-800">Kategori & Kelompok Umur</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Atur KU dan Nomor Lomba untuk event ini</p>
                </div>
                <a href="{{ route('admin.events.ku.index', $event) }}" class="inline-flex items-center px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                    Kelola KU
                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
            <div class="p-6">
                @if($event->kelompokUmur->isEmpty())
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Belum ada Kelompok Umur (KU)</p>
                        <p class="text-xs text-slate-400 mb-4">Tambahkan KU dan nomor lomba agar klub bisa mendaftarkan atletnya.</p>
                        <a href="{{ route('admin.events.ku.create', $event) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors">
                            Tambah Kategori Pertama
                        </a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($event->kelompokUmur as $ku)
                            <div class="border border-slate-200 rounded-xl overflow-hidden">
                                <div class="bg-slate-50 px-4 py-3 flex justify-between items-center border-b border-slate-200">
                                    <div class="font-bold text-slate-800">{{ $ku->nama_ku }} <span class="text-xs font-normal text-slate-500 ml-2">({{ $ku->min_umur ?? 0 }} - {{ $ku->max_umur ?? 'Unlimited' }} thn)</span></div>
                                    <a href="{{ route('admin.ku.nomor.index', $ku) }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">Lihat {{ $ku->nomorLomba->count() }} Nomor Lomba</a>
                                </div>
                                <div class="px-4 py-3 bg-white flex flex-wrap gap-2">
                                    @forelse($ku->nomorLomba->take(5) as $nomor)
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                            {{ $nomor->nama_nomor }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400 italic">Belum ada nomor lomba di KU ini</span>
                                    @endforelse
                                    @if($ku->nomorLomba->count() > 5)
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-indigo-50 text-indigo-600 border border-indigo-100 cursor-pointer" title="Lihat selengkapnya">
                                            +{{ $ku->nomorLomba->count() - 5 }} lainnya
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Peserta Section (Full Width) -->
<div class="mt-8 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
        <div>
            <h3 class="text-base font-bold text-slate-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Daftar Peserta (Atlet)
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">Semua atlet yang telah didaftarkan oleh klub untuk event ini</p>
        </div>
        <a href="{{ route('admin.export.pendaftaran', $event) }}" class="inline-flex items-center px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-1.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export Excel
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Atlet</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Klub (Perkumpulan)</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">KU & Nomor Lomba</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Limit Waktu</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu Daftar</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-100">
                @forelse($pendaftaran as $daftar)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-slate-800">{{ $daftar->nama_atlet }}</div>
                            <div class="text-xs text-slate-500">{{ ucfirst($daftar->jenis_kelamin) }}, Lhr: {{ $daftar->tanggal_lahir?->format('Y-m-d') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-slate-800">{{ $daftar->user->nama_klub ?? $daftar->user->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-slate-800">{{ $daftar->kelompokUmur->nama_ku }}</div>
                            <div class="text-xs text-slate-500">{{ $daftar->nomorLomba->nama_nomor }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($daftar->status_waktu === 'NT')
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">NT</span>
                            @else
                                <span class="text-sm font-mono font-medium text-slate-700">{{ $daftar->limit_waktu }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-slate-500">
                            {{ $daftar->created_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center">
                            <p class="text-slate-500 text-sm">Belum ada atlet yang didaftarkan pada event ini.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($pendaftaran->hasPages())
    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
        {{ $pendaftaran->links() }}
    </div>
    @endif
</div>
@endsection
