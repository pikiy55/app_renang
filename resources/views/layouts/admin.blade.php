<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - App Renang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased font-sans flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white min-h-screen flex flex-col shadow-xl">
        <div class="h-16 flex items-center justify-center border-b border-slate-700 bg-slate-950/50">
            <h1 class="text-xl font-bold tracking-wider text-indigo-400">APP RENANG</h1>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-1">
            <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Menu Utama</p>

            <a href="{{ route('admin.events.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.events.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Manajemen Event
            </a>

            <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Perkumpulan
            </a>

            <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 mt-6">Data & Laporan</p>

            <a href="{{ route('admin.import.form') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.import.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                Import Riwayat
            </a>

            <a href="{{ route('admin.audit-log') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.audit-log') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                Audit Log
            </a>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <div class="flex items-center px-4 py-3 bg-slate-800 rounded-xl">
                <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-sm mr-3">
                    A
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-xs text-slate-400 truncate">Admin</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-20 bg-white/80 backdrop-blur-md shadow-sm border-b border-slate-200 flex items-center px-8 justify-between z-10 sticky top-0">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">@yield('header_title')</h2>
                <p class="text-sm text-slate-500 mt-1">@yield('header_subtitle', 'Dashboard Administration')</p>
            </div>
            <div class="flex items-center space-x-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <div class="p-8 flex-1 overflow-y-auto">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl shadow-sm flex items-start">
                    <svg class="w-5 h-5 mr-3 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h4 class="font-medium text-emerald-800">Berhasil!</h4>
                        <p class="text-sm mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm flex items-start">
                    <svg class="w-5 h-5 mr-3 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h4 class="font-medium text-red-800">Terdapat Kesalahan</h4>
                        <p class="text-sm mt-1">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
    @stack('scripts')
</body>
</html>
