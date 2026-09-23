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
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <div class="w-8 h-8 bg-indigo-600 rounded flex items-center justify-center mr-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h1 class="text-xl font-bold text-slate-800 tracking-tight">APP RENANG</h1>
                    </div>
                    <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                        <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.index') ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors">
                            Katalog Event
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.events.index') }}" class="text-slate-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Admin Area</a>
                        @else
                            <a href="{{ route('perkumpulan.dashboard') }}" class="text-slate-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="ml-4">
                            @csrf
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-indigo-600 px-4 py-2 rounded-md text-sm font-medium transition-colors mr-2">Masuk</a>
                        <a href="#" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            Daftar Klub
                        </a>
                    @endauth
                </div>
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
    @stack('scripts')
</body>
</html>
