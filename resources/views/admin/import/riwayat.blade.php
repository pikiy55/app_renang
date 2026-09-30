@extends('layouts.admin')

@section('title', 'Import Riwayat Waktu')
@section('header_title', 'Import Riwayat Waktu Atlet')
@section('header_subtitle', 'Import data riwayat waktu atlet ke master database dari file Excel')

@section('content')
<div class="space-y-6 max-w-4xl">

    {{-- ===== PETUNJUK & TEMPLATE ===== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-indigo-50 p-3 rounded-xl text-indigo-600 shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800">Petunjuk Import</h3>
                    <p class="text-sm text-slate-500 mt-0.5">Pastikan file Excel sesuai format sebelum diupload</p>
                </div>
            </div>
            {{-- Tombol Download Template --}}
            <a href="{{ route('admin.import.template') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download Template Excel
            </a>
        </div>

        <div class="p-6">
            <p class="text-sm text-slate-600 mb-4">
                Upload file Excel <strong>(.xlsx / .xls)</strong> berisi riwayat waktu atlet. Baris pertama (header) akan diabaikan secara otomatis.
                Jika data atlet + jarak + gaya sudah ada untuk klub tersebut, data akan <strong>diperbarui</strong> (bukan duplikat).
            </p>

            {{-- Tabel format kolom --}}
            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-indigo-600 text-white">
                            <th class="px-4 py-2.5 text-left font-semibold">Kolom</th>
                            <th class="px-4 py-2.5 text-left font-semibold">Nama Field</th>
                            <th class="px-4 py-2.5 text-left font-semibold">Format / Nilai Valid</th>
                            <th class="px-4 py-2.5 text-left font-semibold">Wajib</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr class="bg-white hover:bg-slate-50">
                            <td class="px-4 py-2.5 font-bold text-indigo-600">A</td>
                            <td class="px-4 py-2.5 font-medium text-slate-700">Nama Atlet</td>
                            <td class="px-4 py-2.5 text-slate-500">Teks bebas — contoh: <em>Budi Santoso</em></td>
                            <td class="px-4 py-2.5"><span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs font-semibold">Wajib</span></td>
                        </tr>
                        <tr class="bg-slate-50 hover:bg-slate-100">
                            <td class="px-4 py-2.5 font-bold text-indigo-600">B</td>
                            <td class="px-4 py-2.5 font-medium text-slate-700">Tanggal Lahir</td>
                            <td class="px-4 py-2.5 text-slate-500">Format tanggal Excel atau <code class="bg-white px-1 rounded border border-slate-200 text-xs">YYYY-MM-DD</code></td>
                            <td class="px-4 py-2.5"><span class="bg-slate-100 text-slate-500 px-2 py-0.5 rounded text-xs font-semibold">Opsional</span></td>
                        </tr>
                        <tr class="bg-white hover:bg-slate-50">
                            <td class="px-4 py-2.5 font-bold text-indigo-600">C</td>
                            <td class="px-4 py-2.5 font-medium text-slate-700">Jenis Kelamin</td>
                            <td class="px-4 py-2.5 text-slate-500"><code class="bg-white px-1 rounded border border-slate-200 text-xs">putra</code> atau <code class="bg-white px-1 rounded border border-slate-200 text-xs">putri</code></td>
                            <td class="px-4 py-2.5"><span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs font-semibold">Wajib</span></td>
                        </tr>
                        <tr class="bg-slate-50 hover:bg-slate-100">
                            <td class="px-4 py-2.5 font-bold text-indigo-600">D</td>
                            <td class="px-4 py-2.5 font-medium text-slate-700">Jarak</td>
                            <td class="px-4 py-2.5 text-slate-500">Angka dalam meter — contoh: <code class="bg-white px-1 rounded border border-slate-200 text-xs">50</code>, <code class="bg-white px-1 rounded border border-slate-200 text-xs">100</code>, <code class="bg-white px-1 rounded border border-slate-200 text-xs">200</code></td>
                            <td class="px-4 py-2.5"><span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs font-semibold">Wajib</span></td>
                        </tr>
                        <tr class="bg-white hover:bg-slate-50">
                            <td class="px-4 py-2.5 font-bold text-indigo-600">E</td>
                            <td class="px-4 py-2.5 font-medium text-slate-700">Gaya</td>
                            <td class="px-4 py-2.5 text-slate-500">
                                <div class="flex flex-wrap gap-1">
                                    @foreach(['bebas','dada','punggung','kupu','ganti_perorangan','ganti_estafet'] as $g)
                                        <code class="bg-indigo-50 text-indigo-700 px-1.5 rounded border border-indigo-100 text-xs">{{ $g }}</code>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-2.5"><span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs font-semibold">Wajib</span></td>
                        </tr>
                        <tr class="bg-slate-50 hover:bg-slate-100">
                            <td class="px-4 py-2.5 font-bold text-indigo-600">F</td>
                            <td class="px-4 py-2.5 font-medium text-slate-700">Limit Waktu</td>
                            <td class="px-4 py-2.5 text-slate-500">Format <code class="bg-white px-1 rounded border border-slate-200 text-xs">MM:SS.ss</code> — contoh: <code class="bg-white px-1 rounded border border-slate-200 text-xs">01:05.30</code></td>
                            <td class="px-4 py-2.5"><span class="bg-red-100 text-red-700 px-2 py-0.5 rounded text-xs font-semibold">Wajib</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ===== FORM IMPORT ===== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-base font-bold text-slate-800">Upload File Excel</h3>
            <p class="text-sm text-slate-500 mt-0.5">Pilih klub dan file Excel yang akan diimport</p>
        </div>

        <form id="importForm" action="{{ route('admin.import.riwayat') }}" method="POST"
              enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            {{-- Pilih Perkumpulan --}}
            <div>
                <label for="user_id" class="block text-sm font-semibold text-slate-700 mb-1">
                    Perkumpulan / Klub <span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-slate-500 mb-2">Data yang diimport akan terhubung ke klub ini.</p>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <select id="user_id" name="user_id" required
                            class="block w-full pl-10 pr-10 py-3 text-sm border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl bg-white hover:border-slate-400 transition-colors {{ $errors->has('user_id') ? 'border-red-400 bg-red-50' : '' }}">
                        <option value="">-- Pilih Klub --</option>
                        @foreach($clubs as $club)
                            <option value="{{ $club->id }}" {{ old('user_id') == $club->id ? 'selected' : '' }}>
                                {{ $club->nama_klub ?? $club->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('user_id')
                    <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Upload File --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">
                    File Excel (.xlsx / .xls) <span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-slate-500 mb-2">Maksimal 10 MB. Baris pertama (header) akan diabaikan.</p>

                {{-- Drop zone --}}
                <div id="dropZone"
                     class="mt-1 flex flex-col justify-center items-center px-6 pt-8 pb-8 border-2 border-dashed rounded-xl transition-all duration-200 cursor-pointer border-slate-300 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-400 {{ $errors->has('file') ? 'border-red-400 bg-red-50' : '' }}"
                     onclick="document.getElementById('file').click()"
                     ondragover="event.preventDefault(); this.classList.add('border-indigo-500','bg-indigo-50')"
                     ondragleave="this.classList.remove('border-indigo-500','bg-indigo-50')"
                     ondrop="handleDrop(event)">

                    <div id="dropIcon" class="mb-3">
                        <div class="bg-white w-14 h-14 rounded-full flex items-center justify-center shadow-sm border border-slate-100">
                            <svg class="h-7 w-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </div>
                    </div>

                    <div id="dropText" class="text-center">
                        <p class="text-sm font-medium text-indigo-600">Klik untuk memilih file</p>
                        <p class="text-xs text-slate-500 mt-1">atau drag &amp; drop file Excel di sini</p>
                        <p class="text-xs text-slate-400 mt-1">.xlsx atau .xls — maks. 10 MB</p>
                    </div>

                    <div id="filePreview" class="hidden text-center">
                        <div class="flex items-center justify-center gap-2 bg-white border border-emerald-200 text-emerald-700 px-4 py-2 rounded-lg shadow-sm">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <div class="text-left">
                                <p id="fileName" class="text-sm font-semibold"></p>
                                <p id="fileSize" class="text-xs text-emerald-500"></p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 mt-2">Klik untuk mengganti file</p>
                    </div>

                    <input id="file" name="file" type="file" accept=".xlsx,.xls"
                           class="hidden" required onchange="previewFile(this)">
                </div>

                @error('file')
                    <p class="text-red-500 text-sm mt-1.5 flex items-center gap-1">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="pt-2 flex items-center justify-between border-t border-slate-100">
                <p class="text-xs text-slate-400">
                    Data yang sudah ada (nama + jarak + gaya sama) akan <strong>diperbarui</strong>, bukan digandakan.
                </p>
                <button type="submit" id="submitBtn"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                    <span id="btnNormal" class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Mulai Import Data
                    </span>
                    <span id="btnLoading" class="hidden flex items-center gap-2">
                        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        Memproses...
                    </span>
                </button>
            </div>
        </form>
    </div>

    {{-- ===== HASIL IMPORT — ERROR ROWS ===== --}}
    @if(session('import_errors') && count(session('import_errors')) > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-red-200 overflow-hidden">
            <div class="px-6 py-4 bg-red-50 border-b border-red-100 flex items-center gap-3">
                <div class="bg-red-100 p-2 rounded-full">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-red-800">
                        {{ count(session('import_errors')) }} Baris Gagal Diimport
                    </h3>
                    <p class="text-xs text-red-600 mt-0.5">Periksa isi file dan perbaiki baris-baris berikut</p>
                </div>
            </div>
            <div class="max-h-64 overflow-y-auto p-4">
                <ul class="space-y-1.5">
                    @foreach(session('import_errors') as $error)
                        <li class="flex items-start gap-2 text-sm text-slate-700 bg-red-50 px-3 py-2 rounded-lg border border-red-100">
                            <svg class="w-4 h-4 text-red-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    function previewFile(input) {
        const file = input.files[0];
        if (!file) return;

        document.getElementById('dropText').classList.add('hidden');
        document.getElementById('dropIcon').classList.add('hidden');
        document.getElementById('filePreview').classList.remove('hidden');
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileSize').textContent = formatBytes(file.size);

        const zone = document.getElementById('dropZone');
        zone.classList.remove('border-slate-300', 'bg-slate-50', 'hover:bg-indigo-50', 'hover:border-indigo-400');
        zone.classList.add('border-emerald-400', 'bg-emerald-50');
    }

    function handleDrop(event) {
        event.preventDefault();
        const file = event.dataTransfer.files[0];
        if (!file) return;

        const input = document.getElementById('file');
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
        previewFile(input);

        const zone = document.getElementById('dropZone');
        zone.classList.remove('border-indigo-500', 'bg-indigo-50');
    }

    function formatBytes(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
    }

    document.getElementById('importForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
        document.getElementById('btnNormal').classList.add('hidden');
        document.getElementById('btnLoading').classList.remove('hidden');
    });
</script>
@endpush

