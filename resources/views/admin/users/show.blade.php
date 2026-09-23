@extends('layouts.admin')

@section('title', 'Detail Perkumpulan - ' . ($user->nama_klub ?? $user->name))
@section('header_title', 'Detail Perkumpulan')
@section('header_subtitle', $user->nama_klub ?? $user->name)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors">
        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Perkumpulan
    </a>
    <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-lg text-sm font-semibold hover:bg-indigo-100 transition-colors shadow-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
        Edit Akun
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Info Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50">
                <h3 class="text-base font-bold text-slate-800">Informasi Akun</h3>
            </div>
            <div class="p-6 flex flex-col items-center text-center">
                <div class="h-20 w-20 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-2xl mb-4">
                    {{ strtoupper(substr($user->nama_klub ?? $user->name, 0, 2)) }}
                </div>
                <h3 class="text-lg font-bold text-slate-800">{{ $user->nama_klub ?? '-' }}</h3>
                <p class="text-sm text-slate-500 mt-0.5">PIC: {{ $user->name }}</p>
                
                @if($user->is_active)
                    <span class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Aktif
                    </span>
                @else
                    <span class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span> Nonaktif
                    </span>
                @endif
            </div>
            <div class="border-t border-slate-100 p-6">
                <dl class="divide-y divide-slate-100 text-sm">
                    <div class="py-3 flex justify-between">
                        <dt class="text-slate-500 font-medium">Email</dt>
                        <dd class="text-slate-800 font-semibold">{{ $user->email }}</dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="text-slate-500 font-medium">WhatsApp</dt>
                        <dd class="text-slate-800 font-semibold">{{ $user->whatsapp ?? '-' }}</dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="text-slate-500 font-medium">Bergabung</dt>
                        <dd class="text-slate-800 font-semibold">{{ $user->created_at?->format('d M Y') }}</dd>
                    </div>
                    <div class="py-3 flex justify-between">
                        <dt class="text-slate-500 font-medium">Total Pendaftaran</dt>
                        <dd class="text-indigo-600 font-bold">{{ $user->pendaftaran->count() }} atlet</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Riwayat Pendaftaran -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50">
                <h3 class="text-base font-bold text-slate-800">Riwayat Pendaftaran Atlet</h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar atlet yang telah didaftarkan oleh perkumpulan ini</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Atlet</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Event</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Limit Waktu</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($user->pendaftaran as $p)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-6 py-3 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-800">{{ $p->nama_atlet }}</div>
                                <div class="text-xs text-slate-500">{{ ucfirst($p->jenis_kelamin) }} · {{ $p->tanggal_lahir?->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-600">{{ $p->event->nama_event ?? '-' }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-center text-sm font-mono text-slate-700">{{ $p->limit_waktu ?? '-' }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-center">
                                @if($p->status_waktu === 'NT')
                                    <span class="inline-flex px-2 py-0.5 rounded text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">NT</span>
                                @else
                                    <span class="inline-flex px-2 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">Normal</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm text-slate-500 italic">Belum ada riwayat pendaftaran atlet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
