@extends('layouts.admin')

@section('title', 'Import Riwayat Waktu')
@section('header_title', 'Import Riwayat Waktu Atlet')
@section('header_subtitle', 'Import data riwayat waktu atlet ke master database dari file excel')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-8">
        <div class="mb-8 border-b border-slate-100 pb-6 flex items-start space-x-4">
            <div class="bg-indigo-50 p-3 rounded-lg text-indigo-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-slate-800">Petunjuk Import</h3>
                <p class="text-slate-600 mt-1 text-sm leading-relaxed max-w-3xl">Upload file Excel (.xlsx, .xls) berisi riwayat waktu atlet. Pastikan format kolom sesuai dengan template yang ditentukan. Baris pertama (header) akan diabaikan.</p>
                <div class="mt-3 inline-flex items-center text-xs text-slate-500 bg-slate-50 px-3 py-1.5 rounded border border-slate-200">
                    <span class="font-semibold text-slate-700 mr-2">Format:</span> 
                    Nama Atlet | Tanggal Lahir | Jenis Kelamin | Jarak | Gaya | Limit Waktu
                </div>
            </div>
        </div>

        <form action="{{ route('admin.import.riwayat') }}" method="POST" enctype="multipart/form-data" class="space-y-8 max-w-3xl">
            @csrf

            <!-- Pilih Perkumpulan -->
            <div class="grid grid-cols-1 gap-1">
                <label for="user_id" class="block text-sm font-semibold text-slate-700">Pilih Perkumpulan (Klub)</label>
                <p class="text-xs text-slate-500 mb-2">Pilih klub yang akan dikaitkan dengan riwayat waktu ini.</p>
                <div class="relative">
                    <select id="user_id" name="user_id" required class="block w-full pl-4 pr-10 py-3 text-base border-slate-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-xl border shadow-sm bg-white hover:border-slate-400 transition-colors">
                        <option value="">-- Pilih Klub --</option>
                        @foreach($clubs as $club)
                            <option value="{{ $club->id }}">{{ $club->nama_klub ?? $club->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('user_id')
                    <p class="text-red-500 text-sm mt-1.5 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Upload File -->
            <div class="grid grid-cols-1 gap-1">
                <label for="file" class="block text-sm font-semibold text-slate-700">File Excel (.xlsx, .xls)</label>
                <div class="mt-2 flex justify-center px-6 pt-10 pb-12 border-2 border-slate-300 border-dashed rounded-xl bg-slate-50 hover:bg-slate-100 hover:border-indigo-400 transition-all duration-200 group cursor-pointer relative" onclick="document.getElementById('file').click()">
                    <div class="space-y-2 text-center">
                        <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto shadow-sm border border-slate-100 group-hover:scale-110 transition-transform duration-200">
                            <svg class="h-8 w-8 text-indigo-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="flex text-sm text-slate-600 justify-center items-center pt-2">
                            <span class="relative rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                Pilih file dari komputer
                            </span>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-slate-500">Hanya file Excel up to 10MB</p>
                    </div>
                    <input id="file" name="file" type="file" accept=".xlsx,.xls" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
                </div>
                @error('file')
                    <p class="text-red-500 text-sm mt-1.5 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Mulai Import Data
                </button>
            </div>
        </form>

        @if(session('import_errors'))
            <div class="mt-8 p-6 bg-red-50/50 rounded-xl border border-red-200">
                <div class="flex items-center mb-4">
                    <div class="bg-red-100 p-2 rounded-full mr-3">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-base font-bold text-red-800">Terdapat Kesalahan pada Beberapa Baris Data</h3>
                </div>
                <div class="max-h-60 overflow-y-auto bg-white rounded-lg border border-red-100 p-4">
                    <ul class="list-disc list-inside text-sm text-slate-700 space-y-2">
                        @foreach(session('import_errors') as $error)
                            <li class="pl-2">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
