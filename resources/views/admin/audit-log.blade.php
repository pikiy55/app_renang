@extends('layouts.admin')

@section('title', 'Audit Log')
@section('header_title', 'Sistem Audit Log')
@section('header_subtitle', 'Pantau semua aktivitas perubahan data oleh pengguna dan admin')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-full max-h-full">
    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center bg-slate-50/50">
        <div class="flex items-center">
            <div class="bg-indigo-100 p-2 rounded-lg text-indigo-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800">Riwayat Aktivitas</h3>
                <p class="text-sm text-slate-500 mt-0.5">Menampilkan log historis operasi Create, Update, Delete, Import, dan Export</p>
            </div>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-2">
            <!-- Bisa ditambah filter atau search ke depannya -->
            <button type="button" class="inline-flex items-center px-4 py-2 border border-slate-300 rounded-lg shadow-sm text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                <svg class="-ml-1 mr-2 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Refresh
            </button>
        </div>
    </div>
    
    <div class="overflow-x-auto flex-1">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-40">Waktu</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-48">Pengguna</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-24">Aksi</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider w-48">Entitas Terkait</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Detail Perubahan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-100">
                @forelse($logs as $log)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="px-6 py-5 whitespace-nowrap text-sm text-slate-600 align-top">
                        <div class="font-medium">{{ $log->created_at->format('d M Y') }}</div>
                        <div class="text-xs text-slate-400 mt-1">{{ $log->created_at->format('H:i:s') }} WIB</div>
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap align-top">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold text-xs mr-3">
                                {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-slate-800">{{ $log->user->name ?? 'System' }}</div>
                                <div class="text-xs text-slate-500 mt-0.5 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                    {{ $log->ip_address }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 whitespace-nowrap align-top">
                        @php
                            $actionConfig = [
                                'create' => ['bg-emerald-100', 'text-emerald-800', 'border-emerald-200'],
                                'edit' => ['bg-amber-100', 'text-amber-800', 'border-amber-200'],
                                'delete' => ['bg-red-100', 'text-red-800', 'border-red-200'],
                                'export' => ['bg-fuchsia-100', 'text-fuchsia-800', 'border-fuchsia-200'],
                                'import' => ['bg-blue-100', 'text-blue-800', 'border-blue-200'],
                            ];
                            $config = $actionConfig[$log->action] ?? ['bg-slate-100', 'text-slate-800', 'border-slate-200'];
                        @endphp
                        <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-md border {{ $config[0] }} {{ $config[1] }} {{ $config[2] }}">
                            {{ strtoupper($log->action) }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-sm align-top">
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800 border border-slate-200">
                                {{ class_basename($log->auditable_type) }}
                            </span>
                        </div>
                        <div class="text-xs text-slate-500 mt-2 font-mono bg-slate-50 px-2 py-1 rounded inline-block">
                            ID: #{{ $log->auditable_id }}
                        </div>
                    </td>
                    <td class="px-6 py-5 text-sm align-top">
                        <div class="max-w-2xl">
                            @if(!empty($log->old_values) || !empty($log->new_values))
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @if(!empty($log->old_values))
                                    <div class="bg-red-50/50 rounded-lg p-3 border border-red-100 shadow-sm">
                                        <div class="font-bold text-xs text-red-600 mb-2 flex items-center uppercase tracking-wider">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Data Sebelumnya
                                        </div>
                                        <div class="text-xs text-slate-700 max-h-32 overflow-y-auto custom-scrollbar">
                                            @foreach($log->old_values as $key => $value)
                                                <div class="flex border-b border-red-100/50 last:border-0 py-1">
                                                    <span class="font-medium text-slate-600 w-1/3 truncate pr-2" title="{{ $key }}">{{ $key }}:</span>
                                                    <span class="w-2/3 truncate text-slate-800" title="{{ is_array($value) ? json_encode($value) : $value }}">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    @if(!empty($log->new_values))
                                    <div class="bg-emerald-50/50 rounded-lg p-3 border border-emerald-100 shadow-sm">
                                        <div class="font-bold text-xs text-emerald-600 mb-2 flex items-center uppercase tracking-wider">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Data Baru
                                        </div>
                                        <div class="text-xs text-slate-700 max-h-32 overflow-y-auto custom-scrollbar">
                                            @foreach($log->new_values as $key => $value)
                                                <div class="flex border-b border-emerald-100/50 last:border-0 py-1">
                                                    <span class="font-medium text-slate-600 w-1/3 truncate pr-2" title="{{ $key }}">{{ $key }}:</span>
                                                    <span class="w-2/3 truncate text-slate-800" title="{{ is_array($value) ? json_encode($value) : $value }}">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            @else
                                <div class="inline-flex items-center px-3 py-1.5 rounded-md bg-slate-50 border border-slate-200 text-xs text-slate-500 italic">
                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Tidak ada detail perubahan yang dicatat
                                </div>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="bg-slate-100 p-3 rounded-full mb-3 text-slate-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-sm font-semibold text-slate-700">Belum ada Log Aktivitas</h3>
                            <p class="text-xs text-slate-500 mt-1 max-w-sm">Data log akan muncul di sini setelah ada operasi pembuatan, perubahan, penghapusan, atau import/export data.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t border-slate-200 bg-white shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
        {{ $logs->links() }}
    </div>
</div>

<style>
/* Custom Scrollbar for small details container */
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent; 
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1; 
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8; 
}
</style>
@endsection
