@extends('layouts.admin')

@section('title', 'Buat Akun Perkumpulan')
@section('header_title', 'Buat Akun Perkumpulan Baru')
@section('header_subtitle', 'Daftarkan klub/perkumpulan renang baru ke sistem')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Perkumpulan
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden max-w-4xl">
    <div class="p-8">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-bold text-slate-700 mb-1">Nama PIC / Penanggung Jawab <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors"
                            placeholder="Nama lengkap PIC">
                        @error('name') <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="nama_klub" class="block text-sm font-bold text-slate-700 mb-1">Nama Klub / Perkumpulan <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_klub" id="nama_klub" value="{{ old('nama_klub') }}" required
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors"
                            placeholder="Contoh: Perkumpulan Renang Harapan">
                        @error('nama_klub') <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-sm font-bold text-slate-700 mb-1">Email Login <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors"
                            placeholder="email@klubanda.com">
                        @error('email') <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="whatsapp" class="block text-sm font-bold text-slate-700 mb-1">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}"
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors"
                            placeholder="08123456789">
                        @error('whatsapp') <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <hr class="border-slate-100">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-bold text-slate-700 mb-1">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" id="password" required
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors"
                            placeholder="Minimal 8 karakter">
                        @error('password') <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-3 px-4 bg-slate-50 hover:bg-white transition-colors"
                            placeholder="Ulangi password">
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end space-x-4">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white hover:bg-indigo-700 transition-all transform hover:-translate-y-0.5">Buat Akun</button>
            </div>
        </form>
    </div>
</div>
@endsection
