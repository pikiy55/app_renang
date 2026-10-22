@php
    $user = auth()->user();
    $initials = collect(explode(' ', $user->name ?? 'Admin'))
        ->filter()->take(2)->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');

    $navGroups = [
        'Ringkasan' => [
            ['route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'label' => 'Dashboard',
             'icon' => 'M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z'],
        ],
        'Menu Utama' => [
            ['route' => 'admin.events.index', 'match' => 'admin.events.*', 'label' => 'Manajemen Event',
             'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5'],
            ['route' => 'admin.users.index', 'match' => 'admin.users.*', 'label' => 'Perkumpulan',
             'icon' => 'M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z'],
        ],
        'Data & Laporan' => [
            ['route' => 'admin.import.form', 'match' => 'admin.import.*', 'label' => 'Import Riwayat',
             'icon' => 'M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5'],
            ['route' => 'admin.audit-log', 'match' => 'admin.audit-log', 'label' => 'Audit Log',
             'icon' => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z'],
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Panel administrasi App Renang — kelola event, perkumpulan, dan pendaftaran atlet.')">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#0f172a">
    <title>@yield('title', 'Admin Dashboard') · App Renang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-canvas text-ink antialiased font-sans">
    {{-- Skip link (keyboard / screen reader) --}}
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[60] focus:px-4 focus:py-2 focus:rounded-lg focus:bg-white focus:text-brand-800 focus:shadow-lg focus:outline-2 focus:outline-brand-600">
        Lewati ke konten utama
    </a>

    {{-- Mobile backdrop --}}
    <div id="sidebar-backdrop"
         class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-200 lg:hidden"
         aria-hidden="true"></div>

    {{-- ============ Sidebar ============ --}}
    <aside id="admin-sidebar"
           class="fixed inset-y-0 left-0 z-50 flex w-72 lg:w-64 flex-col bg-slate-900 text-white
                  -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-out"
           aria-label="Navigasi admin">
        {{-- Brand --}}
        <div class="flex h-16 shrink-0 items-center justify-between gap-3 px-5 border-b border-white/10">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-lg focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-brand-400">
                <span class="grid size-9 place-items-center rounded-lg bg-gradient-to-br from-brand-500 to-brand-700 shadow-lg shadow-brand-900/40" aria-hidden="true">
                    {{-- Wave mark --}}
                    <svg class="size-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2 15c1.67 0 1.67-1.5 3.33-1.5S7 15 8.67 15s1.66-1.5 3.33-1.5S13.67 15 15.33 15 17 13.5 18.67 13.5 20.33 15 22 15M2 19.5c1.67 0 1.67-1.5 3.33-1.5S7 19.5 8.67 19.5s1.66-1.5 3.33-1.5 1.67 1.5 3.33 1.5S17 18 18.67 18s1.66 1.5 3.33 1.5M14 4.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0ZM6 11l4-3.5 3 2 4-2.5"/>
                    </svg>
                </span>
                <span class="leading-tight">
                    <span class="block text-sm font-bold tracking-wide">App Renang</span>
                    <span class="block text-[11px] font-medium text-slate-400">Admin Console</span>
                </span>
            </a>
            <button type="button" id="sidebar-close" class="btn-icon text-slate-400 hover:bg-white/10 hover:text-white lg:hidden" aria-label="Tutup menu navigasi">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-3 py-5" aria-label="Menu utama">
            @foreach($navGroups as $group => $items)
                <div class="{{ $loop->first ? '' : 'mt-6' }}">
                    <p class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">{{ $group }}</p>
                    <ul class="space-y-1" role="list">
                        @foreach($items as $item)
                            @php $active = request()->routeIs($item['match']); @endphp
                            <li>
                                <a href="{{ route($item['route']) }}" class="nav-link" @if($active) aria-current="page" @endif>
                                    <svg class="size-5 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                                    </svg>
                                    <span class="truncate">{{ $item['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            <div class="mt-6 pt-6 border-t border-white/10">
                <a href="{{ route('events.index') }}" class="nav-link" target="_blank" rel="noopener">
                    <svg class="size-5 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    <span class="truncate">Lihat Situs Publik</span>
                    <span class="sr-only">(membuka tab baru)</span>
                </a>
            </div>
        </nav>

        {{-- User card --}}
        <div class="shrink-0 p-3 border-t border-white/10">
            <div class="flex items-center gap-3 rounded-lg bg-white/5 px-3 py-2.5">
                <span class="grid size-9 shrink-0 place-items-center rounded-full bg-brand-600 text-sm font-semibold" aria-hidden="true">{{ $initials ?: 'A' }}</span>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium">{{ $user->name ?? 'Administrator' }}</p>
                    <p class="truncate text-xs text-slate-400">{{ $user->email ?? 'Admin' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-icon size-9 text-slate-400 hover:bg-white/10 hover:text-white" aria-label="Keluar dari akun">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ============ Main column ============ --}}
    <div class="lg:pl-64 flex min-h-full flex-col">
        <header class="sticky top-0 z-30 flex h-16 shrink-0 items-center gap-3 border-b border-line bg-white/85 px-4 backdrop-blur-md sm:px-6 lg:px-8">
            <button type="button" id="sidebar-open" class="btn-icon -ml-2 lg:hidden"
                    aria-label="Buka menu navigasi" aria-controls="admin-sidebar" aria-expanded="false">
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
            </button>

            <div class="min-w-0 flex-1">
                <h1 class="truncate text-base font-semibold text-ink sm:text-lg">@yield('header_title', 'Dashboard')</h1>
                <p class="hidden truncate text-xs text-ink-muted sm:block">@yield('header_subtitle', 'Panel administrasi')</p>
            </div>

            <div class="flex items-center gap-2">
                @yield('header_actions')
                <time class="hidden md:inline-flex items-center gap-2 rounded-lg border border-line bg-white px-3 py-1.5 text-xs font-medium text-ink-muted"
                      datetime="{{ now()->toDateString() }}">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                    {{ now()->locale('id')->translatedFormat('l, d F Y') }}
                </time>
            </div>
        </header>

        <main id="main-content" tabindex="-1" class="flex-1 px-4 py-6 sm:px-6 lg:px-8 lg:py-8 focus:outline-none">
            <div class="mx-auto w-full max-w-[1400px]">
                @if(session('success'))
                    <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800" role="status" data-dismissible>
                        <svg class="mt-0.5 size-5 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                        <div class="flex-1">
                            <p class="text-sm font-semibold">Berhasil</p>
                            <p class="mt-0.5 text-sm">{{ session('success') }}</p>
                        </div>
                        <button type="button" class="btn-icon size-8 text-emerald-700 hover:bg-emerald-100" data-dismiss aria-label="Tutup notifikasi">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800" role="alert" data-dismissible>
                        <svg class="mt-0.5 size-5 shrink-0 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>
                        <div class="flex-1">
                            <p class="text-sm font-semibold">Terdapat Kesalahan</p>
                            <p class="mt-0.5 text-sm">{{ session('error') }}</p>
                        </div>
                        <button type="button" class="btn-icon size-8 text-red-700 hover:bg-red-100" data-dismiss aria-label="Tutup notifikasi">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <footer class="border-t border-line px-4 py-4 text-xs text-ink-muted sm:px-6 lg:px-8">
            <div class="mx-auto flex max-w-[1400px] flex-wrap items-center justify-between gap-2">
                <span>&copy; {{ date('Y') }} App Renang. Semua hak dilindungi.</span>
                <span class="num">v{{ app()->version() }}</span>
            </div>
        </footer>
    </div>

    <script>
        (() => {
            const sidebar  = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const openBtn  = document.getElementById('sidebar-open');
            const closeBtn = document.getElementById('sidebar-close');
            const desktop  = window.matchMedia('(min-width: 1024px)');

            const setOpen = (open) => {
                sidebar.classList.toggle('-translate-x-full', !open);
                backdrop.classList.toggle('opacity-0', !open);
                backdrop.classList.toggle('pointer-events-none', !open);
                openBtn.setAttribute('aria-expanded', String(open));
                document.body.classList.toggle('overflow-hidden', open);
                // Hidden off-canvas drawer must not be reachable by keyboard
                if (!desktop.matches) sidebar.inert = !open;
                if (open) closeBtn.focus();
            };

            const sync = () => {
                if (desktop.matches) {
                    sidebar.inert = false;
                    document.body.classList.remove('overflow-hidden');
                    backdrop.classList.add('opacity-0', 'pointer-events-none');
                } else {
                    setOpen(false);
                }
            };

            openBtn.addEventListener('click', () => setOpen(true));
            closeBtn.addEventListener('click', () => { setOpen(false); openBtn.focus(); });
            backdrop.addEventListener('click', () => { setOpen(false); openBtn.focus(); });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && openBtn.getAttribute('aria-expanded') === 'true') {
                    setOpen(false); openBtn.focus();
                }
            });
            desktop.addEventListener('change', sync);
            sync();

            document.querySelectorAll('[data-dismiss]').forEach((btn) =>
                btn.addEventListener('click', () => btn.closest('[data-dismissible]')?.remove())
            );
        })();
    </script>
    @stack('scripts')
</body>
</html>
