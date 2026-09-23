@extends('layouts.admin')

@section('title', 'Tambah Nomor Lomba')
@section('header_title', 'Tambah Nomor Lomba')
@section('header_subtitle', 'KU: ' . $ku->nama_ku . ' — Event: ' . $ku->event->nama_event)

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.ku.nomor.index', $ku) }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Nomor Lomba
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden max-w-3xl">
    <div class="p-8">
        <form action="{{ route('admin.ku.nomor.store', $ku) }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="nama_nomor" class="block text-sm font-bold text-slate-700 mb-1">Nama Nomor Lomba <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_nomor" id="nama_nomor" value="{{ old('nama_nomor') }}" required
                        class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors"
                        placeholder="Contoh: 50m Gaya Bebas Putra">
                    @error('nama_nomor') <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="jarak" class="block text-sm font-bold text-slate-700 mb-1">Jarak (meter) <span class="text-red-500">*</span></label>
                        <input type="number" name="jarak" id="jarak" value="{{ old('jarak') }}" required min="25"
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors"
                            placeholder="50">
                        @error('jarak') <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="gaya" class="block text-sm font-bold text-slate-700 mb-1">Gaya <span class="text-red-500">*</span></label>
                        <select name="gaya" id="gaya" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors">
                            <option value="">-- Pilih --</option>
                            @foreach($gayaOptions as $gaya)
                                <option value="{{ $gaya }}" {{ old('gaya') == $gaya ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $gaya)) }}</option>
                            @endforeach
                        </select>
                        @error('gaya') <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-bold text-slate-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors">
                            <option value="">-- Pilih --</option>
                            <option value="putra" {{ old('jenis_kelamin') == 'putra' ? 'selected' : '' }}>Putra</option>
                            <option value="putri" {{ old('jenis_kelamin') == 'putri' ? 'selected' : '' }}>Putri</option>
                            <option value="campuran" {{ old('jenis_kelamin') == 'campuran' ? 'selected' : '' }}>Campuran</option>
                        </select>
                        @error('jenis_kelamin') <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.ku.nomor.index', $ku) }}" class="px-6 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white hover:bg-indigo-700 transition-all transform hover:-translate-y-0.5">Simpan Nomor Lomba</button>
            </div>
        </form>
    </div>
</div>
@endsection
