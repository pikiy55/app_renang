@extends('layouts.admin')

@section('title', 'Edit Event')
@section('header_title', 'Edit Event Kejuaraan')
@section('header_subtitle', 'Perbarui data event: ' . $event->nama_event)

@section('content')
@php use Illuminate\Support\Facades\Storage; @endphp
<div class="mb-6">
    <a href="{{ route('admin.events.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Event
    </a>
</div>

<form action="{{ route('admin.events.update', $event) }}" method="POST" id="eventForm" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- ═══════════════════════════════════════════ --}}
    {{-- SECTION 1: Informasi Event --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden max-w-5xl mb-8">
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-slate-50">
            <div class="flex items-center">
                <div class="flex-shrink-0 w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-sm">1</div>
                <div class="ml-3">
                    <h3 class="text-base font-bold text-slate-800">Informasi Event</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Data dasar kejuaraan renang</p>
                </div>
            </div>
        </div>
        <div class="p-8">
            <div class="space-y-6">
                <!-- Nama Event -->
                <div>
                    <label for="nama_event" class="block text-sm font-bold text-slate-700 mb-1">Nama Kejuaraan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_event" id="nama_event" value="{{ old('nama_event', $event->nama_event) }}" required
                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors"
                        placeholder="Contoh: Kejuaraan Renang Antar Perkumpulan Nasional 2026">
                    @error('nama_event')
                        <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div>
                    <label for="lokasi" class="block text-sm font-bold text-slate-700 mb-1">Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $event->lokasi) }}" required
                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors"
                        placeholder="Contoh: Kolam Renang Senayan, Jakarta">
                    @error('lokasi')
                        <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tanggal Mulai -->
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-bold text-slate-700 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai', $event->tanggal_mulai?->format('Y-m-d')) }}" required
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors">
                        @error('tanggal_mulai')
                            <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Selesai -->
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-bold text-slate-700 mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai', $event->tanggal_selesai?->format('Y-m-d')) }}" required
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors">
                        @error('tanggal_selesai')
                            <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Deadline Pendaftaran -->
                <div>
                    <label for="deadline_pendaftaran" class="block text-sm font-bold text-slate-700 mb-1">Batas Akhir (Deadline) Pendaftaran <span class="text-red-500">*</span></label>
                    <p class="text-xs text-slate-500 mb-2">Pendaftaran akan otomatis ditutup melewati tanggal dan waktu ini.</p>
                    <input type="datetime-local" name="deadline_pendaftaran" id="deadline_pendaftaran" value="{{ old('deadline_pendaftaran', $event->deadline_pendaftaran?->format('Y-m-d\TH:i')) }}" required
                        class="block w-full md:w-1/2 rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors">
                    @error('deadline_pendaftaran')
                        <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Aktif -->
                <div class="pt-4 pb-2 border-t border-slate-100">
                    <div class="flex items-center">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $event->is_active) ? 'checked' : '' }}
                            class="h-5 w-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 bg-slate-50 cursor-pointer">
                        <label for="is_active" class="ml-3 block text-sm font-bold text-slate-700 cursor-pointer select-none">
                            Tampilkan ke Publik (Aktif)
                        </label>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 ml-8">Jika tidak dicentang, event akan disembunyikan dari klub dan tidak bisa menerima pendaftaran baru.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- SECTION 2: Upload Juknis --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden max-w-5xl mb-8">
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-slate-50">
            <div class="flex items-center">
                <div class="flex-shrink-0 w-8 h-8 bg-amber-500 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-sm">2</div>
                <div class="ml-3">
                    <h3 class="text-base font-bold text-slate-800">File Juknis</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Upload file Petunjuk Teknis (PDF/DOC) yang dapat didownload oleh klub <span class="text-amber-600 font-medium">(opsional)</span></p>
                </div>
            </div>
        </div>
        <div class="p-8">
            <div class="space-y-4">

                {{-- Tampilkan file juknis yang sudah ada --}}
                @if($event->file_juknis)
                <div class="flex items-center gap-4 p-4 bg-amber-50 border border-amber-200 rounded-xl">
                    <div class="flex-shrink-0 w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate">File juknis sudah diupload</p>
                        <p class="text-xs text-slate-500 truncate">{{ basename($event->file_juknis) }}</p>
                    </div>
                    <a href="{{ route('admin.events.juknis.download', $event) }}"
                        class="flex-shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 bg-white text-amber-700 border border-amber-300 rounded-lg text-xs font-semibold hover:bg-amber-100 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Lihat File
                    </a>
                    {{-- Checkbox hapus juknis --}}
                    <label class="flex items-center gap-2 text-xs font-semibold text-red-600 cursor-pointer">
                        <input type="checkbox" name="hapus_juknis" value="1" class="w-4 h-4 rounded border-red-300 text-red-600 focus:ring-red-500">
                        Hapus file
                    </label>
                </div>
                <p class="text-xs text-slate-400">Upload file baru di bawah untuk menggantikan file yang sudah ada.</p>
                @endif

                {{-- Dropzone upload --}}
                <div>
                    <label for="file_juknis" class="block text-sm font-bold text-slate-700 mb-1">
                        {{ $event->file_juknis ? 'Ganti File Juknis' : 'Upload File Juknis' }}
                    </label>
                    <div id="juknis-dropzone"
                        class="mt-1 flex flex-col items-center justify-center px-6 pt-8 pb-8 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer hover:border-amber-400 hover:bg-amber-50/50 transition-all group"
                        onclick="document.getElementById('file_juknis').click()">
                        <div id="juknis-preview-icon">
                            <svg class="w-12 h-12 text-slate-300 group-hover:text-amber-400 transition-colors mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-slate-600 group-hover:text-amber-600 transition-colors" id="juknis-filename">Klik untuk pilih file atau drag &amp; drop</p>
                        <p class="text-xs text-slate-400 mt-1">PDF, DOC, DOCX &mdash; Maks. 10 MB</p>
                        <input type="file" name="file_juknis" id="file_juknis" class="hidden" accept=".pdf,.doc,.docx">
                    </div>
                    @error('file_juknis')
                        <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- SECTION 3: Kelompok Umur & Nomor Lomba --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden max-w-5xl mb-8">
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-cyan-50 to-slate-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-8 h-8 bg-cyan-600 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-sm">3</div>
                    <div class="ml-3">
                        <h3 class="text-base font-bold text-slate-800">Kelompok Umur & Nomor Lomba</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Atur kategori umur, gaya renang, dan jarak lomba</p>
                    </div>
                </div>
                <button type="button" onclick="addKU()"
                    class="inline-flex items-center px-4 py-2 bg-cyan-600 text-white rounded-xl text-sm font-semibold hover:bg-cyan-700 transition-all transform hover:-translate-y-0.5 shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah KU
                </button>
            </div>
        </div>

        <div class="p-6" id="kuContainer">
            <!-- Empty state -->
            <div id="kuEmptyState" class="text-center py-10" style="{{ $event->kelompokUmur->count() > 0 ? 'display:none' : '' }}">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <p class="text-sm font-medium text-slate-600 mb-1">Belum ada Kelompok Umur</p>
                <p class="text-xs text-slate-400">Klik tombol "Tambah KU" untuk menambahkan kategori umur dan nomor lomba.</p>
            </div>

            {{-- Existing KU items rendered from server --}}
            @foreach($event->kelompokUmur as $kuIdx => $ku)
            <div class="ku-item border border-slate-200 rounded-xl overflow-hidden mb-4 shadow-sm hover:shadow-md transition-shadow" id="ku-{{ $kuIdx }}" data-ku-index="{{ $kuIdx }}">
                <div class="bg-gradient-to-r from-cyan-50 to-indigo-50 px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-7 h-7 bg-cyan-600 rounded-lg flex items-center justify-center text-white text-xs font-bold shadow-sm">KU</div>
                        <h4 class="ml-2.5 font-bold text-slate-800 text-sm">Kelompok Umur <span class="ku-number">#{{ $kuIdx + 1 }}</span></h4>
                    </div>
                    <button type="button" onclick="removeKU({{ $kuIdx }})" class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 border border-red-200 rounded-lg text-xs font-semibold hover:bg-red-100 transition-colors" title="Hapus KU">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Hapus
                    </button>
                </div>
                <div class="p-5 bg-white">
                    <input type="hidden" name="ku[{{ $kuIdx }}][id]" value="{{ $ku->id }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Nama KU <span class="text-red-500">*</span></label>
                            <input type="text" name="ku[{{ $kuIdx }}][nama_ku]" required value="{{ $ku->nama_ku }}"
                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm py-2.5 px-3.5 bg-slate-50 hover:bg-white transition-colors"
                                placeholder="Contoh: KU I">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Usia Minimum</label>
                            <input type="number" name="ku[{{ $kuIdx }}][usia_min]" min="0" value="{{ $ku->usia_min }}"
                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm py-2.5 px-3.5 bg-slate-50 hover:bg-white transition-colors"
                                placeholder="Contoh: 6">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Usia Maksimum</label>
                            <input type="number" name="ku[{{ $kuIdx }}][usia_max]" min="0" value="{{ $ku->usia_max }}"
                                class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm py-2.5 px-3.5 bg-slate-50 hover:bg-white transition-colors"
                                placeholder="Contoh: 7">
                        </div>
                    </div>

                    <!-- Nomor Lomba Section -->
                    <div class="border-t border-slate-100 pt-4">
                        <div class="flex items-center justify-between mb-3">
                            <h5 class="text-xs font-bold text-slate-600 uppercase tracking-wider flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Nomor Lomba
                            </h5>
                            <button type="button" onclick="addNomor({{ $kuIdx }})"
                                class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-lg text-xs font-semibold hover:bg-indigo-100 transition-colors">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Nomor
                            </button>
                        </div>
                        <div class="nomor-container space-y-3" id="nomor-container-{{ $kuIdx }}">
                            @if($ku->nomorLomba->isEmpty())
                            <div class="text-center py-4 text-xs text-slate-400 italic nomor-empty" id="nomor-empty-{{ $kuIdx }}">
                                Klik "Tambah Nomor" untuk menambahkan nomor lomba
                            </div>
                            @endif

                            @foreach($ku->nomorLomba as $nIdx => $nomor)
                            <div class="nomor-item bg-slate-50 rounded-xl p-4 border border-slate-200 hover:border-indigo-200 transition-colors" id="nomor-{{ $kuIdx }}-{{ $nIdx }}">
                                <div class="flex items-start gap-3">
                                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                                        <input type="hidden" name="ku[{{ $kuIdx }}][nomor][{{ $nIdx }}][id]" value="{{ $nomor->id }}">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 mb-1">Nama Nomor <span class="text-red-500">*</span></label>
                                            <input type="text" name="ku[{{ $kuIdx }}][nomor][{{ $nIdx }}][nama_nomor]" required value="{{ $nomor->nama_nomor }}"
                                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs py-2 px-3 bg-white"
                                                placeholder="50m Gaya Bebas Putra">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 mb-1">Jarak (meter) <span class="text-red-500">*</span></label>
                                            <input type="number" name="ku[{{ $kuIdx }}][nomor][{{ $nIdx }}][jarak]" required min="25" value="{{ $nomor->jarak }}"
                                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs py-2 px-3 bg-white"
                                                placeholder="50">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 mb-1">Gaya Renang <span class="text-red-500">*</span></label>
                                            <select name="ku[{{ $kuIdx }}][nomor][{{ $nIdx }}][gaya]" required
                                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs py-2 px-3 bg-white">
                                                <option value="">-- Pilih Gaya --</option>
                                                <option value="bebas" {{ $nomor->gaya == 'bebas' ? 'selected' : '' }}>Bebas</option>
                                                <option value="dada" {{ $nomor->gaya == 'dada' ? 'selected' : '' }}>Dada</option>
                                                <option value="punggung" {{ $nomor->gaya == 'punggung' ? 'selected' : '' }}>Punggung</option>
                                                <option value="kupu" {{ $nomor->gaya == 'kupu' ? 'selected' : '' }}>Kupu</option>
                                                <option value="ganti_perorangan" {{ $nomor->gaya == 'ganti_perorangan' ? 'selected' : '' }}>Ganti Perorangan</option>
                                                <option value="ganti_estafet" {{ $nomor->gaya == 'ganti_estafet' ? 'selected' : '' }}>Ganti Estafet</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-600 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                                            <select name="ku[{{ $kuIdx }}][nomor][{{ $nIdx }}][jenis_kelamin]" required
                                                class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs py-2 px-3 bg-white">
                                                <option value="">-- Pilih --</option>
                                                <option value="putra" {{ $nomor->jenis_kelamin == 'putra' ? 'selected' : '' }}>Putra</option>
                                                <option value="putri" {{ $nomor->jenis_kelamin == 'putri' ? 'selected' : '' }}>Putri</option>
                                                <option value="campuran" {{ $nomor->jenis_kelamin == 'campuran' ? 'selected' : '' }}>Campuran</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="button" onclick="removeNomor({{ $kuIdx }}, {{ $nIdx }})"
                                        class="flex-shrink-0 mt-5 p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus nomor lomba">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- SUBMIT --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="max-w-5xl flex items-center justify-end space-x-4 mb-8">
        <a href="{{ route('admin.events.index') }}" class="px-6 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
            Batal
        </a>
        <button type="submit" class="px-8 py-2.5 bg-indigo-600 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
            Simpan Perubahan
        </button>
    </div>
</form>

@push('scripts')
<script>
    let kuIndex = {{ $event->kelompokUmur->count() }};
    let nomorCounters = {};

    // Initialize nomor counters for existing KUs
    @foreach($event->kelompokUmur as $kuIdx => $ku)
        nomorCounters[{{ $kuIdx }}] = {{ $ku->nomorLomba->count() }};
    @endforeach

    const gayaOptions = [
        { value: 'bebas', label: 'Bebas' },
        { value: 'dada', label: 'Dada' },
        { value: 'punggung', label: 'Punggung' },
        { value: 'kupu', label: 'Kupu' },
        { value: 'ganti_perorangan', label: 'Ganti Perorangan' },
        { value: 'ganti_estafet', label: 'Ganti Estafet' },
    ];

    function addKU() {
        const container = document.getElementById('kuContainer');
        const emptyState = document.getElementById('kuEmptyState');
        if (emptyState) emptyState.style.display = 'none';

        const idx = kuIndex++;
        const kuHtml = `
        <div class="ku-item border border-slate-200 rounded-xl overflow-hidden mb-4 shadow-sm hover:shadow-md transition-shadow" id="ku-${idx}" data-ku-index="${idx}">
            <div class="bg-gradient-to-r from-cyan-50 to-indigo-50 px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-7 h-7 bg-cyan-600 rounded-lg flex items-center justify-center text-white text-xs font-bold shadow-sm">KU</div>
                    <h4 class="ml-2.5 font-bold text-slate-800 text-sm">Kelompok Umur <span class="ku-number">#${idx + 1}</span></h4>
                </div>
                <button type="button" onclick="removeKU(${idx})" class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 border border-red-200 rounded-lg text-xs font-semibold hover:bg-red-100 transition-colors" title="Hapus KU">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus
                </button>
            </div>
            <div class="p-5 bg-white">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Nama KU <span class="text-red-500">*</span></label>
                        <input type="text" name="ku[${idx}][nama_ku]" required
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm py-2.5 px-3.5 bg-slate-50 hover:bg-white transition-colors"
                            placeholder="Contoh: KU I">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Usia Minimum</label>
                        <input type="number" name="ku[${idx}][usia_min]" min="0"
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm py-2.5 px-3.5 bg-slate-50 hover:bg-white transition-colors"
                            placeholder="Contoh: 6">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1">Usia Maksimum</label>
                        <input type="number" name="ku[${idx}][usia_max]" min="0"
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 sm:text-sm py-2.5 px-3.5 bg-slate-50 hover:bg-white transition-colors"
                            placeholder="Contoh: 7">
                    </div>
                </div>

                <!-- Nomor Lomba Section -->
                <div class="border-t border-slate-100 pt-4">
                    <div class="flex items-center justify-between mb-3">
                        <h5 class="text-xs font-bold text-slate-600 uppercase tracking-wider flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Nomor Lomba
                        </h5>
                        <button type="button" onclick="addNomor(${idx})"
                            class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-lg text-xs font-semibold hover:bg-indigo-100 transition-colors">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Nomor
                        </button>
                    </div>
                    <div class="nomor-container space-y-3" id="nomor-container-${idx}">
                        <div class="text-center py-4 text-xs text-slate-400 italic nomor-empty" id="nomor-empty-${idx}">
                            Klik "Tambah Nomor" untuk menambahkan nomor lomba
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

        container.insertAdjacentHTML('beforeend', kuHtml);
    }

    function addNomor(kuIdx) {
        if (!nomorCounters[kuIdx]) nomorCounters[kuIdx] = 0;
        const nIdx = nomorCounters[kuIdx]++;

        const container = document.getElementById(`nomor-container-${kuIdx}`);
        const emptyEl = document.getElementById(`nomor-empty-${kuIdx}`);
        if (emptyEl) emptyEl.style.display = 'none';

        let gayaOptionsHtml = '<option value="">-- Pilih Gaya --</option>';
        gayaOptions.forEach(g => {
            gayaOptionsHtml += `<option value="${g.value}">${g.label}</option>`;
        });

        const nomorHtml = `
        <div class="nomor-item bg-slate-50 rounded-xl p-4 border border-slate-200 hover:border-indigo-200 transition-colors" id="nomor-${kuIdx}-${nIdx}">
            <div class="flex items-start gap-3">
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Nama Nomor <span class="text-red-500">*</span></label>
                        <input type="text" name="ku[${kuIdx}][nomor][${nIdx}][nama_nomor]" required
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs py-2 px-3 bg-white"
                            placeholder="50m Gaya Bebas Putra">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Jarak (meter) <span class="text-red-500">*</span></label>
                        <input type="number" name="ku[${kuIdx}][nomor][${nIdx}][jarak]" required min="25"
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs py-2 px-3 bg-white"
                            placeholder="50">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Gaya Renang <span class="text-red-500">*</span></label>
                        <select name="ku[${kuIdx}][nomor][${nIdx}][gaya]" required
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs py-2 px-3 bg-white">
                            ${gayaOptionsHtml}
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="ku[${kuIdx}][nomor][${nIdx}][jenis_kelamin]" required
                            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-xs py-2 px-3 bg-white">
                            <option value="">-- Pilih --</option>
                            <option value="putra">Putra</option>
                            <option value="putri">Putri</option>
                            <option value="campuran">Campuran</option>
                        </select>
                    </div>
                </div>
                <button type="button" onclick="removeNomor(${kuIdx}, ${nIdx})"
                    class="flex-shrink-0 mt-5 p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus nomor lomba">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>`;

        container.insertAdjacentHTML('beforeend', nomorHtml);
    }

    function removeKU(idx) {
        const el = document.getElementById(`ku-${idx}`);
        if (el) {
            el.style.transition = 'all 0.3s ease';
            el.style.opacity = '0';
            el.style.transform = 'translateX(-20px)';
            setTimeout(() => {
                el.remove();
                const remaining = document.querySelectorAll('.ku-item');
                if (remaining.length === 0) {
                    const emptyState = document.getElementById('kuEmptyState');
                    if (emptyState) emptyState.style.display = 'block';
                }
            }, 300);
        }
    }

    function removeNomor(kuIdx, nIdx) {
        const el = document.getElementById(`nomor-${kuIdx}-${nIdx}`);
        if (el) {
            el.style.transition = 'all 0.2s ease';
            el.style.opacity = '0';
            el.style.transform = 'scale(0.95)';
            setTimeout(() => {
                el.remove();
                const container = document.getElementById(`nomor-container-${kuIdx}`);
                const remaining = container.querySelectorAll('.nomor-item');
                if (remaining.length === 0) {
                    const emptyEl = document.getElementById(`nomor-empty-${kuIdx}`);
                    if (emptyEl) emptyEl.style.display = 'block';
                }
            }, 200);
        }
    }
    // Preview nama file juknis saat dipilih
    document.getElementById('file_juknis').addEventListener('change', function() {
        const filename = this.files[0]?.name ?? 'Klik untuk pilih file atau drag & drop';
        const el = document.getElementById('juknis-filename');
        el.textContent = filename;
        el.classList.toggle('text-amber-600', !!this.files[0]);
        const iconEl = document.getElementById('juknis-preview-icon');
        if (this.files[0]) {
            iconEl.innerHTML = `<div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>`;
        }
    });

    // Drag & drop support
    const dropzone = document.getElementById('juknis-dropzone');
    dropzone.addEventListener('dragover', e => { e.preventDefault(); dropzone.classList.add('border-amber-400', 'bg-amber-50'); });
    dropzone.addEventListener('dragleave', () => { dropzone.classList.remove('border-amber-400', 'bg-amber-50'); });
    dropzone.addEventListener('drop', e => {
        e.preventDefault();
        dropzone.classList.remove('border-amber-400', 'bg-amber-50');
        const input = document.getElementById('file_juknis');
        if (e.dataTransfer.files.length) {
            input.files = e.dataTransfer.files;
            input.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush
@endsection
