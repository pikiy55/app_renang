@extends('layouts.admin')

@section('title', 'Tambah Event Baru')
@section('header_title', 'Tambah Event Kejuaraan')
@section('header_subtitle', 'Buat data event/kejuaraan renang baru')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.events.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Event
    </a>
</div>

<form action="{{ route('admin.events.store') }}" method="POST" id="eventForm">
    @csrf

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
                    <input type="text" name="nama_event" id="nama_event" value="{{ old('nama_event') }}" required
                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors"
                        placeholder="Contoh: Kejuaraan Renang Antar Perkumpulan Nasional 2026">
                    @error('nama_event')
                        <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div>
                    <label for="lokasi" class="block text-sm font-bold text-slate-700 mb-1">Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" required
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
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors">
                        @error('tanggal_mulai')
                            <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Selesai -->
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-bold text-slate-700 mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required
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
                    <input type="datetime-local" name="deadline_pendaftaran" id="deadline_pendaftaran" value="{{ old('deadline_pendaftaran') }}" required
                        class="block w-full md:w-1/2 rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors">
                    @error('deadline_pendaftaran')
                        <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Aktif -->
                <div class="pt-4 pb-2 border-t border-slate-100">
                    <div class="flex items-center">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                            class="h-5 w-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 bg-slate-50 cursor-pointer">
                        <label for="is_active" class="ml-3 block text-sm font-bold text-slate-700 cursor-pointer select-none">
                            Tampilkan ke Publik (Aktif)
                        </label>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 ml-8">Jika tidak dicentang, event akan disimpan sebagai Draft dan tidak terlihat oleh klub.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- SECTION 2: Kelompok Umur & Nomor Lomba --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden max-w-5xl mb-8">
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-cyan-50 to-slate-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-8 h-8 bg-cyan-600 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-sm">2</div>
                    <div class="ml-3">
                        <h3 class="text-base font-bold text-slate-800">Kelompok Umur & Nomor Lomba</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Atur kategori umur, gaya renang, dan jarak lomba <span class="text-amber-600 font-medium">(opsional — bisa ditambah nanti)</span></p>
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
            <div id="kuEmptyState" class="text-center py-10">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <p class="text-sm font-medium text-slate-600 mb-1">Belum ada Kelompok Umur</p>
                <p class="text-xs text-slate-400">Klik tombol "Tambah KU" untuk menambahkan kategori umur dan nomor lomba.</p>
            </div>

            <!-- KU items will be added here dynamically -->
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
            Simpan Event
        </button>
    </div>
</form>

@push('scripts')
<script>
    let kuIndex = 0;
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

    let nomorCounters = {};

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
                // Show empty state if no KU left
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
                // Show empty state if no nomor left
                const container = document.getElementById(`nomor-container-${kuIdx}`);
                const remaining = container.querySelectorAll('.nomor-item');
                if (remaining.length === 0) {
                    const emptyEl = document.getElementById(`nomor-empty-${kuIdx}`);
                    if (emptyEl) emptyEl.style.display = 'block';
                }
            }, 200);
        }
    }
</script>
@endpush
@endsection
