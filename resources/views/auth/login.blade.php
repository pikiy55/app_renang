<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - App Renang</title>
    <meta name="description" content="Masuk ke akun Perkumpulan atau Admin - Sistem Pendaftaran Kejuaraan Renang">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans min-h-screen flex items-center justify-center relative overflow-hidden bg-navy">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-32 -right-32 w-80 h-80 bg-cyan/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -left-32 w-96 h-96 bg-cyan/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 right-1/4 w-72 h-72 bg-coral/10 rounded-full blur-3xl"></div>
        <!-- Subtle wave pattern -->
        <svg class="absolute bottom-0 left-0 right-0 text-navy-light/30" viewBox="0 0 1440 120" fill="currentColor" preserveAspectRatio="none">
            <path d="M0,60 C240,120 480,0 720,60 C960,120 1200,0 1440,60 L1440,120 L0,120 Z"></path>
        </svg>
    </div>

    <div class="w-full max-w-md relative z-10 px-4 sm:px-0">
        <!-- Back to Home -->
        <div class="mb-8 flex justify-center">
            <a href="{{ route('events.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-400 hover:text-cyan transition-colors bg-white/5 px-5 py-2.5 rounded-full backdrop-blur-md border border-white/10 hover:border-cyan/30">
                <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl shadow-black/20 overflow-hidden animate-fadeInUp">
            <div class="p-8 sm:p-10">
                <!-- Logo & Heading -->
                <div class="text-center mb-10">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-navy text-white mb-6 shadow-lg shadow-navy/40">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-navy tracking-tight">Selamat Datang</h2>
                    <p class="text-slate-500 mt-2 font-medium">Masuk ke akun Perkumpulan / Admin Anda</p>
                </div>

                @if($errors->any())
                    <div class="mb-6 p-4 bg-coral/5 border border-coral/20 rounded-xl flex items-start animate-fadeIn">
                        <svg class="w-5 h-5 text-coral mr-3 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="text-sm font-medium text-coral-dark">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('auth.login') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-navy mb-2 ml-1">Alamat Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-cyan transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="block w-full pl-11 pr-4 py-3.5 bg-ice-light border border-slate-200 rounded-xl text-navy placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan/30 focus:border-cyan focus:bg-white transition-all sm:text-sm font-medium" placeholder="nama@klubanda.com">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-2 ml-1">
                            <label for="password" class="block text-sm font-bold text-navy">Password</label>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-cyan transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" type="password" name="password" required
                                class="block w-full pl-11 pr-4 py-3.5 bg-ice-light border border-slate-200 rounded-xl text-navy placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan/30 focus:border-cyan focus:bg-white transition-all sm:text-sm font-medium" placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center">
                            <input id="remember" type="checkbox" name="remember" class="h-4 w-4 text-cyan focus:ring-cyan border-slate-300 rounded bg-slate-50 cursor-pointer accent-cyan">
                            <label for="remember" class="ml-2 block text-sm font-medium text-slate-600 cursor-pointer select-none">
                                Ingat Saya
                            </label>
                        </div>
                        <a href="#" class="text-sm font-bold text-cyan hover:text-cyan-dark transition-colors">Lupa password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full flex justify-center items-center py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-cyan/25 text-sm font-bold text-white bg-cyan hover:bg-cyan-dark hover:shadow-cyan/40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan transform hover:-translate-y-0.5 transition-all duration-200 mt-8">
                        Masuk Sekarang
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>
            <div class="px-8 py-5 bg-ice-light border-t border-ice-dark/30 text-center">
                <p class="text-sm font-medium text-slate-600">
                    Belum punya akun? <a href="#" class="font-bold text-cyan hover:text-cyan-dark transition-colors ml-1">Daftarkan Klub Anda</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
