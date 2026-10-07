<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Katalog Event') - App Renang</title>
    <meta name="description" content="Sistem Informasi Pendaftaran Kejuaraan Renang - Platform pendaftaran lomba renang profesional">

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased font-sans min-h-screen flex flex-col">
    <!-- Navbar (Dark Blue #172B4D) -->
    <nav class="bg-navy shadow-md sticky top-0 z-50 border-b border-[#1F365D]" style="background-color: #172B4D;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                {{-- Brand Logo --}}
                <div class="flex items-center">
                    <a href="{{ route('events.index') }}" class="flex items-center group">
                        <div class="rounded-xl flex items-center justify-center mr-2.5 shadow-md shadow-cyan/30 group-hover:scale-105 transition-all duration-200 shrink-0"
                             style="width: 38px; height: 38px; min-width: 38px; min-height: 38px; max-width: 38px; max-height: 38px; aspect-ratio: 1/1; background-color: #20B8D4;">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-lg sm:text-xl font-extrabold text-white tracking-tight leading-tight">APP RENANG</span>
                            <span class="text-[10px] text-cyan font-semibold tracking-wider uppercase -mt-0.5" style="color: #20B8D4;">Platform Kejuaraan</span>
                        </div>
                    </a>
                </div>

                {{-- Desktop Navigation (Hidden on Mobile) --}}
                <div class="hidden md:flex md:items-center md:space-x-1.5">
                    <a href="{{ route('events.index') }}"
                       class="{{ request()->routeIs('events.index') ? 'text-white bg-white/10 font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5 font-semibold' }} px-3.5 py-2 rounded-xl text-sm transition-all duration-200 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-cyan" style="color: #20B8D4;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span>Katalog Event</span>
                    </a>

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.events.index') }}"
                               class="{{ request()->routeIs('admin.*') ? 'text-white bg-white/10 font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5 font-semibold' }} px-3.5 py-2 rounded-xl text-sm transition-all duration-200 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-cyan" style="color: #20B8D4;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                                <span>Admin Area</span>
                            </a>
                        @else
                            <a href="{{ route('perkumpulan.dashboard') }}"
                               class="{{ request()->routeIs('perkumpulan.dashboard') || request()->routeIs('perkumpulan.event.*') ? 'text-white bg-white/10 font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5 font-semibold' }} px-3.5 py-2 rounded-xl text-sm transition-all duration-200 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-cyan" style="color: #20B8D4;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>Daftar Event</span>
                            </a>
                            <a href="{{ route('perkumpulan.rekap') }}"
                               class="{{ request()->routeIs('perkumpulan.rekap') ? 'text-white bg-white/10 font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5 font-semibold' }} px-3.5 py-2 rounded-xl text-sm transition-all duration-200 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-cyan" style="color: #20B8D4;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <span>Data Atlet & Rekap</span>
                            </a>
                        @endif

                        <div class="w-px h-6 bg-white/20 mx-2"></div>

                        {{-- User Quick Profile Pill --}}
                        <div class="flex items-center gap-2 pl-1.5 pr-3 py-1 bg-white/5 border border-white/10 rounded-xl text-xs text-white">
                            <span class="rounded-lg font-black flex items-center justify-center text-[11px] shrink-0"
                                  style="width: 26px; height: 26px; min-width: 26px; min-height: 26px; aspect-ratio: 1/1; background-color: #20B8D4; color: #172B4D;">
                                {{ strtoupper(substr(auth()->user()->nama_klub ?? auth()->user()->name, 0, 2)) }}
                            </span>
                            <span class="font-bold max-w-[140px] truncate text-slate-100">
                                {{ auth()->user()->nama_klub ?? auth()->user()->name }}
                            </span>
                        </div>

                        {{-- Logout Button --}}
                        <form method="POST" action="{{ route('logout') }}" class="ml-1">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-3.5 py-1.5 rounded-xl text-xs font-bold text-coral bg-coral/10 hover:bg-coral hover:text-white border border-coral/30 hover:border-coral transition-all duration-200">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-300 hover:text-white hover:bg-white/5 px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200">
                            Masuk
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center ml-1 px-4 py-2 rounded-xl text-sm font-bold text-navy bg-cyan hover:bg-cyan-light shadow-md shadow-cyan/30 hover:shadow-cyan/50 transition-all duration-200"
                           style="background-color: #20B8D4; color: #172B4D;">
                            Login Klub
                        </a>
                    @endauth
                </div>

                {{-- Mobile Hamburger Button --}}
                <div class="flex items-center md:hidden">
                    <button type="button"
                            onclick="toggleMobileNav()"
                            class="inline-flex items-center justify-center rounded-xl text-slate-200 hover:text-white hover:bg-white/10 transition-all focus:outline-none"
                            style="width: 40px; height: 40px; min-width: 40px; min-height: 40px;"
                            aria-label="Buka Menu">
                        <svg id="nav-icon-menu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg id="nav-icon-close" class="hidden w-6 h-6 text-cyan" style="color: #20B8D4;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Dropdown Drawer (Ensured Dark Blue Background #172B4D, NO GEPENG ELEMENTS) --}}
        <div id="mobile-nav-drawer"
             class="hidden md:hidden border-t border-[#1F365D] animate-slideDown shadow-2xl"
             style="background-color: #172B4D;">
            <div class="px-4 pt-3 pb-5 space-y-2">
                @auth
                    {{-- User Profile Card on Mobile -- FIXED: STRICT SQUARE AVATAR, NEVER GEPENG --}}
                    <div class="p-3 mb-3 rounded-2xl border border-[#1F365D] flex items-center gap-3.5"
                         style="background-color: #0E1A2E;">
                        <div class="rounded-2xl flex items-center justify-center font-black text-sm shadow-md shrink-0"
                             style="width: 44px; height: 44px; min-width: 44px; min-height: 44px; max-width: 44px; max-height: 44px; aspect-ratio: 1 / 1; background-color: #20B8D4; color: #172B4D;">
                            {{ strtoupper(substr(auth()->user()->nama_klub ?? auth()->user()->name, 0, 2)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-1.5">
                                <span class="text-[10px] uppercase font-extrabold tracking-wider px-2 py-0.5 rounded-full border border-cyan/30"
                                      style="background-color: rgba(32, 184, 212, 0.15); color: #20B8D4;">
                                    {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Perkumpulan' }}
                                </span>
                            </div>
                            <p class="text-sm font-extrabold text-white truncate mt-1">
                                {{ auth()->user()->nama_klub ?? auth()->user()->name }}
                            </p>
                            <p class="text-xs text-slate-300 truncate font-normal">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                    </div>

                    {{-- Navigation Links with Explicit High-Contrast Colors --}}
                    <a href="{{ route('events.index') }}"
                       class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-bold transition-all"
                       style="{{ request()->routeIs('events.index') ? 'background-color: rgba(32, 184, 212, 0.2); color: #ffffff; border-left: 4px solid #20B8D4;' : 'color: #F1F5F9;' }}">
                        <svg class="w-4 h-4 shrink-0" style="color: #20B8D4;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span>Katalog Event Kejuaraan</span>
                    </a>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.events.index') }}"
                           class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-bold transition-all"
                           style="{{ request()->routeIs('admin.*') ? 'background-color: rgba(32, 184, 212, 0.2); color: #ffffff; border-left: 4px solid #20B8D4;' : 'color: #F1F5F9;' }}">
                            <svg class="w-4 h-4 shrink-0" style="color: #20B8D4;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                            <span>Admin Area</span>
                        </a>
                    @else
                        <a href="{{ route('perkumpulan.dashboard') }}"
                           class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-bold transition-all"
                           style="{{ request()->routeIs('perkumpulan.dashboard') || request()->routeIs('perkumpulan.event.*') ? 'background-color: rgba(32, 184, 212, 0.2); color: #ffffff; border-left: 4px solid #20B8D4;' : 'color: #F1F5F9;' }}">
                            <svg class="w-4 h-4 shrink-0" style="color: #20B8D4;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Daftar Event Kejuaraan</span>
                        </a>
                        <a href="{{ route('perkumpulan.rekap') }}"
                           class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-bold transition-all"
                           style="{{ request()->routeIs('perkumpulan.rekap') ? 'background-color: rgba(32, 184, 212, 0.2); color: #ffffff; border-left: 4px solid #20B8D4;' : 'color: #F1F5F9;' }}">
                            <svg class="w-4 h-4 shrink-0" style="color: #20B8D4;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span>Data Atlet & Rekap</span>
                        </a>
                    @endif

                    <div class="pt-3 mt-2 border-t border-[#1F365D]">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-sm font-bold border transition-all duration-200"
                                    style="background-color: rgba(255, 107, 107, 0.15); color: #FF6B6B; border-color: rgba(255, 107, 107, 0.3);">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                <span>Logout Keluar</span>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('events.index') }}"
                       class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-semibold transition-colors"
                       style="color: #F1F5F9;">
                        <svg class="w-4 h-4" style="color: #20B8D4;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span>Katalog Event</span>
                    </a>
                    <a href="{{ route('login') }}"
                       class="flex items-center justify-center px-4 py-3 rounded-xl text-sm font-bold transition-colors shadow-md"
                       style="background-color: #20B8D4; color: #172B4D;">
                        Masuk ke Akun Perkumpulan
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 w-full">
        @yield('content')
    </main>

    <!-- Footer (Dark Blue #172B4D) -->
    <footer class="bg-navy mt-auto border-t border-[#1F365D]" style="background-color: #172B4D;">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center">
                    <div class="rounded-xl flex items-center justify-center mr-2.5 shadow-sm shrink-0"
                         style="width: 34px; height: 34px; min-width: 34px; min-height: 34px; aspect-ratio: 1/1; background-color: #20B8D4;">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-base font-extrabold text-white tracking-tight">APP RENANG</span>
                        <p class="text-[11px] text-slate-300">Sistem Informasi Pendaftaran Kejuaraan Renang</p>
                    </div>
                </div>
                <p class="text-center text-xs text-slate-300">&copy; {{ date('Y') }} APP RENANG. Seluruh Hak Cipta Dilindungi.</p>
            </div>
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
