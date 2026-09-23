@extends('layouts.admin')

@section('title', 'Edit KU - ' . $ku->nama_ku)
@section('header_title', 'Edit Kelompok Umur')
@section('header_subtitle', 'Event: ' . $event->nama_event)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.events.ku.index', $event) }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar KU
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden max-w-3xl">
    <div class="p-8">
        <form action="{{ route('admin.events.ku.update', [$event, $ku]) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="nama_ku" class="block text-sm font-bold text-slate-700 mb-1">Nama Kelompok Umur <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_ku" id="nama_ku" value="{{ old('nama_ku', $ku->nama_ku) }}" required
                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors">
                    @error('nama_ku') <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="usia_min" class="block text-sm font-bold text-slate-700 mb-1">Usia Minimum</label>
                        <input type="number" name="usia_min" id="usia_min" value="{{ old('usia_min', $ku->usia_min) }}" min="0"
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors">
                        @error('usia_min') <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="usia_max" class="block text-sm font-bold text-slate-700 mb-1">Usia Maksimum</label>
                        <input type="number" name="usia_max" id="usia_max" value="{{ old('usia_max', $ku->usia_max) }}" min="0"
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors">
                        @error('usia_max') <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.events.ku.index', $event) }}" class="px-6 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white hover:bg-indigo-700 transition-all transform hover:-translate-y-0.5">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
