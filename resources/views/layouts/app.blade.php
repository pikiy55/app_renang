<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Katalog Event') - App Renang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased font-sans min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                {{-- Brand Logo --}}
                <div class="flex items-center">
                    <a href="{{ route('events.index') }}" class="flex items-center">
                        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center mr-2 shadow-sm shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <span class="text-lg sm:text-xl font-extrabold text-slate-800 tracking-tight">APP RENANG</span>
                    </a>
                </div>

                {{-- Desktop Navigation (Hidden on Mobile) --}}
                <div class="hidden md:flex md:items-center md:space-x-4">
                    <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.index') ? 'text-indigo-600 font-semibold' : 'text-slate-600 hover:text-indigo-600' }} px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                        Katalog Event
                    </a>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.*') ? 'text-indigo-600 font-semibold' : 'text-slate-600 hover:text-indigo-600' }} px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                Admin Area
                            </a>
                        @else
                            <a href="{{ route('perkumpulan.dashboard') }}" class="{{ request()->routeIs('perkumpulan.dashboard') || request()->routeIs('perkumpulan.event.*') ? 'text-indigo-600 font-semibold' : 'text-slate-600 hover:text-indigo-600' }} px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                Daftar Event
                            </a>
                            <a href="{{ route('perkumpulan.rekap') }}" class="{{ request()->routeIs('perkumpulan.rekap') ? 'text-indigo-600 font-semibold' : 'text-slate-600 hover:text-indigo-600' }} px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                Data Atlet & Rekap
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition-colors">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-600 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                            Masuk
                        </a>
                        <a href="#" class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition-colors">
                            Daftar Klub
                        </a>
                    @endauth
                </div>

                {{-- Mobile Hamburger Button --}}
                <div class="flex items-center md:hidden">
                    <button type="button"
                            onclick="toggleMobileNav()"
                            class="inline-flex items-center justify-center p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors focus:outline-none"
                            aria-label="Buka Menu">
                        <svg id="nav-icon-menu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg id="nav-icon-close" class="hidden w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Dropdown Drawer --}}
        <div id="mobile-nav-drawer" class="hidden md:hidden border-t border-slate-200 bg-white shadow-xl animate-fadeIn">
            <div class="px-4 pt-3 pb-4 space-y-1.5">
                @auth
                    {{-- User Profile Card on Mobile --}}
                    <div class="p-3 mb-2 rounded-xl bg-slate-50 border border-slate-200 flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white font-bold flex items-center justify-center text-sm shadow-sm shrink-0">
                            {{ strtoupper(substr(auth()->user()->nama_klub ?? auth()->user()->name, 0, 2)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-slate-800 truncate">
                                {{ auth()->user()->nama_klub ?? auth()->user()->name }}
                            </p>
                            <p class="text-xs text-slate-500 truncate">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('events.index') }}"
                       class="{{ request()->routeIs('events.index') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span>Katalog Event</span>
                    </a>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.events.index') }}"
                           class="{{ request()->routeIs('admin.*') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                            <span>Admin Area</span>
                        </a>
                    @else
                        <a href="{{ route('perkumpulan.dashboard') }}"
                           class="{{ request()->routeIs('perkumpulan.dashboard') || request()->routeIs('perkumpulan.event.*') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Daftar Event Kejuaraan</span>
                        </a>
                        <a href="{{ route('perkumpulan.rekap') }}"
                           class="{{ request()->routeIs('perkumpulan.rekap') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }} flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span>Data Atlet & Rekap</span>
                        </a>
                    @endif

                    <div class="pt-2 border-t border-slate-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-xl text-sm font-semibold transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                <span>Logout Keluar</span>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('events.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                        Katalog Event
                    </a>
                    <a href="{{ route('login') }}"
                       class="flex items-center justify-center px-4 py-2.5 border border-slate-300 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                        Masuk
                    </a>
                    <a href="#"
                       class="flex items-center justify-center px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors shadow-sm">
                        Daftar Klub
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-auto">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center mb-4 md:mb-0">
                <div class="w-6 h-6 bg-slate-300 rounded flex items-center justify-center mr-2">
                    <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="text-lg font-bold text-slate-800 tracking-tight">APP RENANG</span>
            </div>
            <p class="text-center text-sm text-slate-500">&copy; {{ date('Y') }} Sistem Informasi Pendaftaran Kejuaraan Renang. Hak Cipta Dilindungi.</p>
        </div>
    </footer>
    <script>
        function toggleMobileNav() {
            const drawer = document.getElementById('mobile-nav-drawer');
            const iconMenu = document.getElementById('nav-icon-menu');
            const iconClose = document.getElementById('nav-icon-close');
            if (!drawer) return;

            const isHidden = drawer.classList.contains('hidden');
            if (isHidden) {
                drawer.classList.remove('hidden');
                if (iconMenu) iconMenu.classList.add('hidden');
                if (iconClose) iconClose.classList.remove('hidden');
            } else {
                drawer.classList.add('hidden');
                if (iconMenu) iconMenu.classList.remove('hidden');
                if (iconClose) iconClose.classList.add('hidden');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
