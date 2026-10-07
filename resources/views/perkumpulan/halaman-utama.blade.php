@extends('layouts.app')

@section('title', $event->nama_event . ' - Dashboard Perkumpulan')

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<div class="min-h-screen bg-slate-50">
    {{-- Event Header (Dark Blue #172B4D) --}}
    <div class="relative bg-navy overflow-hidden border-b border-[#1F365D]" style="background-color: #172B4D;">
        {{-- Decorative glow --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-20 right-1/3 w-80 h-80 rounded-full blur-3xl opacity-20" style="background-color: #20B8D4;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-14 z-10">
            {{-- Breadcrumb Navigation --}}
            <div class="mb-5">
                <a href="{{ route('perkumpulan.dashboard') }}"
                   class="inline-flex items-center text-xs sm:text-sm font-semibold text-slate-300 hover:text-white transition-colors group">
                    <svg class="mr-2 w-4 h-4 text-cyan transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar Event
                </a>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        @if($isDeadlinePassed)
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold border border-coral/30"
                                  style="background-color: rgba(255, 107, 107, 0.15); color: #FF6B6B;">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Pendaftaran Ditutup
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold border border-cyan/30"
                                  style="background-color: #DFF6FA; color: #1796AD;">
                                <span class="w-2 h-2 rounded-full mr-1.5 animate-pulseDot" style="background-color: #20B8D4;"></span>
                                Pendaftaran Dibuka
                            </span>
                        @endif
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-white/10 text-slate-200 border border-white/20">
                            {{ $event->tanggal_mulai->format('d M Y') }} – {{ $event->tanggal_selesai->format('d M Y') }}
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight mb-2">
                        {{ $event->nama_event }}
                    </h1>
                    <p class="text-slate-300 text-xs sm:text-sm flex items-center">
                        <svg class="w-4 h-4 mr-1.5 shrink-0 text-cyan" style="color: #20B8D4;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $event->lokasi }}
                    </p>
                </div>

                {{-- Action & Stats Area --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 shrink-0">
                    {{-- Stats Cards --}}
                    <div class="grid grid-cols-2 gap-2.5 sm:flex sm:items-center sm:space-x-3">
                        <div class="rounded-xl px-4 py-2.5 text-center flex flex-col justify-center border border-[#1F365D]"
                             style="background-color: #0E1A2E;">
                            <p class="text-xl sm:text-2xl font-black text-white leading-none">{{ $myPendaftaran->total() }}</p>
                            <p class="text-[11px] text-slate-300 font-semibold mt-1">Atlet Terdaftar</p>
                        </div>
                        <div class="rounded-xl px-4 py-2.5 text-center flex flex-col justify-center min-w-[120px] border border-[#1F365D]"
                             style="background-color: #0E1A2E;">
                            <p class="text-sm sm:text-base font-extrabold text-cyan leading-tight" style="color: #20B8D4;">{{ $sisaWaktu }}</p>
                            <p class="text-[11px] text-slate-300 font-semibold mt-1">Sisa Waktu</p>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center gap-2.5">
                        @if($event->file_juknis)
                            <a href="{{ route('perkumpulan.event.juknis.download', $event) }}"
                               class="flex-1 sm:flex-initial inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-white/10 border border-white/30 text-white font-bold text-xs sm:text-sm hover:bg-white/20 transition-all">
                                <svg class="w-4 h-4 mr-1.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                <span>Unduh Juknis</span>
                            </a>
                        @endif

                        @if(!$isDeadlinePassed)
                            <a href="{{ route('perkumpulan.pendaftaran.create', $event) }}"
                               class="flex-1 sm:flex-initial inline-flex items-center justify-center px-4 py-2.5 rounded-xl font-bold text-xs sm:text-sm text-navy shadow-lg transition-all hover:scale-[1.02]"
                               style="background-color: #20B8D4; color: #172B4D;">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                <span>Daftar Atlet</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 pb-16 relative z-20">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl flex items-start border border-[#BBE7F0] shadow-sm animate-fadeIn"
                 style="background-color: #DFF6FA; color: #1796AD;">
                <svg class="w-5 h-5 mr-3 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <h4 class="font-bold text-sm" style="color: #172B4D;">Berhasil!</h4>
                    <p class="text-sm mt-0.5 text-slate-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl flex items-start border border-[#FFA1A1] shadow-sm animate-fadeIn"
                 style="background-color: #FFF2F2; color: #E25050;">
                <svg class="w-5 h-5 mr-3 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <h4 class="font-bold text-sm" style="color: #E25050;">Terdapat Kesalahan</h4>
                    <p class="text-sm mt-0.5 text-slate-700">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Deadline Info Bar --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-5 mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3 shrink-0 border border-[#BBE7F0]"
                         style="background-color: #DFF6FA;">
                        <svg class="w-5 h-5" style="color: #1796AD;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Batas Pendaftaran</p>
                        <p class="text-sm font-bold" style="color: #172B4D;">
                            {{ $event->deadline_pendaftaran->format('d F Y, H:i') }} WIB
                        </p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3 shrink-0 border"
                         style="{{ $isDeadlinePassed ? 'background-color: rgba(255, 107, 107, 0.12); border-color: rgba(255, 107, 107, 0.3);' : 'background-color: #DFF6FA; border-color: #BBE7F0;' }}">
                        <svg class="w-5 h-5" style="{{ $isDeadlinePassed ? 'color: #E25050;' : 'color: #1796AD;' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Status Event</p>
                        <p class="text-sm font-bold" style="{{ $isDeadlinePassed ? 'color: #E25050;' : 'color: #1796AD;' }}">
                            {{ $isDeadlinePassed ? 'Deadline Berakhir' : $sisaWaktu }}
                        </p>
                    </div>
                </div>
            </div>
            @if(!$isDeadlinePassed)
                <a href="{{ route('perkumpulan.pendaftaran.create', $event) }}"
                   class="w-full md:w-auto inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-bold text-navy shadow-md hover:scale-[1.02] transition-all"
                   style="background-color: #20B8D4; color: #172B4D;">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Daftarkan Atlet Baru
                </a>
            @endif
        </div>

        {{-- Registered Athletes Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                <h3 class="text-base font-extrabold flex items-center" style="color: #172B4D;">
                    <svg class="w-5 h-5 mr-2" style="color: #1796AD;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Data Pendaftaran Atlet
                </h3>
                <span class="text-xs font-bold px-2.5 py-1 rounded-lg border border-cyan/30"
                      style="background-color: #DFF6FA; color: #1796AD;">{{ $myPendaftaran->total() }} Data Terdaftar</span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-5 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider w-12">No</th>
                            <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Atlet</th>
                            <th scope="col" class="px-5 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori & Nomor Lomba</th>
                            <th scope="col" class="px-4 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu</th>
                            <th scope="col" class="px-4 py-3.5 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-5 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($myPendaftaran as $index => $daftar)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-5 py-4 whitespace-nowrap text-center">
                                    <span class="text-xs font-bold text-slate-400">{{ $myPendaftaran->firstItem() + $index }}</span>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm shrink-0 border border-[#BBE7F0]"
                                             style="background-color: #DFF6FA; color: #1796AD;">
                                            {{ strtoupper(substr($daftar->nama_atlet, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-extrabold" style="color: #172B4D;">{{ $daftar->nama_atlet }}</div>
                                            <div class="text-xs text-slate-500 mt-0.5">
                                                <span class="font-semibold {{ $daftar->jenis_kelamin === 'putra' ? 'text-cyan' : 'text-coral' }}"
                                                      style="{{ $daftar->jenis_kelamin === 'putra' ? 'color: #1796AD;' : 'color: #E25050;' }}">
                                                    {{ ucfirst($daftar->jenis_kelamin) }}
                                                </span>
                                                · Lahir {{ $daftar->tanggal_lahir?->format('Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="text-xs font-bold px-2 py-0.5 rounded border border-[#BBE7F0] inline-block mb-1"
                                         style="background-color: #DFF6FA; color: #1796AD;">
                                        {{ $daftar->kelompokUmur->nama_ku }}
                                    </div>
                                    <div class="text-sm font-semibold text-slate-800">
                                        {{ $daftar->nomorLomba->nama_nomor }}
                                    </div>
                                </td>
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
                                <td class="px-5 py-4 whitespace-nowrap text-right text-xs font-medium">
                                    @if(!$daftar->isLocked())
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('perkumpulan.pendaftaran.edit', $daftar) }}"
                                               class="p-1.5 text-slate-600 hover:text-navy hover:bg-slate-100 rounded-lg transition-colors"
                                               title="Edit Pendaftaran">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('perkumpulan.pendaftaran.destroy', $daftar) }}"
                                                  method="POST"
                                                  class="inline-block"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran atlet ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="p-1.5 text-coral hover:text-coral-dark hover:bg-coral/10 rounded-lg transition-colors"
                                                        title="Batalkan">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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
                                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4 border border-[#BBE7F0]"
                                             style="background-color: #DFF6FA;">
                                            <svg class="w-8 h-8" style="color: #1796AD;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                        </div>
                                        <h3 class="text-base font-extrabold mb-1" style="color: #172B4D;">Belum Ada Atlet Terdaftar</h3>
                                        <p class="text-sm text-slate-500 mb-5 leading-relaxed">Perkumpulan Anda belum mendaftarkan atlet untuk event kejuaraan ini.</p>
                                        @if(!$isDeadlinePassed)
                                            <a href="{{ route('perkumpulan.pendaftaran.create', $event) }}"
                                               class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-bold text-navy shadow-md hover:scale-[1.02] transition-all"
                                               style="background-color: #20B8D4; color: #172B4D;">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                                Daftarkan Atlet Sekarang
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
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                    {{ $myPendaftaran->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
