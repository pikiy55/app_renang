@extends('layouts.admin')

@section('title', 'Manajemen Perkumpulan')
@section('header_title', 'Akun Perkumpulan / Klub')
@section('header_subtitle', 'Kelola semua akun perkumpulan renang yang terdaftar')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div class="flex-1">
        <h3 class="text-lg font-bold text-slate-800">Semua Perkumpulan</h3>
        <p class="text-sm text-slate-500">Total: {{ $users->total() }} akun terdaftar</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring ring-indigo-300 transition shadow-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Buat Akun Baru
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Perkumpulan</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">WhatsApp</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-100">
                @forelse($users as $user)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm mr-3 shrink-0">
                                {{ strtoupper(substr($user->nama_klub ?? $user->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-800">{{ $user->nama_klub ?? '-' }}</div>
                                <div class="text-xs text-slate-400">PIC: {{ $user->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $user->whatsapp ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if($user->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span> Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.users.show', $user) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors" title="Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-amber-500 hover:text-amber-700 transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus akun perkumpulan ini? Semua data pendaftaran terkait juga mungkin terhapus.');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="bg-slate-100 p-4 rounded-full mb-4 text-slate-400"><svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                            <h3 class="text-base font-bold text-slate-800">Belum Ada Akun Perkumpulan</h3>
                            <p class="text-sm text-slate-500 mt-1">Buat akun baru untuk perkumpulan/klub.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">{{ $users->links() }}</div>
    @endif
</div>
@endsection
