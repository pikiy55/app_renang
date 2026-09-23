<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - App Renang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
    </style>
</head>
<body class="bg-slate-50 antialiased font-sans min-h-screen flex items-center justify-center relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
    <div class="absolute top-40 -left-40 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-40 left-20 w-96 h-96 bg-emerald-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>

    <div class="w-full max-w-md relative z-10 px-4 sm:px-0">
        <!-- Back to Home -->
        <div class="mb-8 flex justify-center">
            <a href="{{ route('events.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors bg-white/60 px-5 py-2.5 rounded-full backdrop-blur-md border border-white shadow-sm">
                <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>

        <!-- Login Card -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-white overflow-hidden transform transition-all">
            <div class="p-8 sm:p-10">
                <!-- Logo & Heading -->
                <div class="text-center mb-10">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600 text-white mb-6 shadow-lg shadow-indigo-600/30 transform -rotate-6">
                        <svg class="w-8 h-8 transform rotate-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Selamat Datang</h2>
                    <p class="text-slate-500 mt-2 font-medium">Masuk ke akun Perkumpulan / Admin Anda</p>
                </div>

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-start">
                        <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="text-sm font-medium text-red-800">
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
                        <label for="email" class="block text-sm font-bold text-slate-700 mb-2 ml-1">Alamat Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all sm:text-sm font-medium" placeholder="nama@klubanda.com">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-2 ml-1">
                            <label for="password" class="block text-sm font-bold text-slate-700">Password</label>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" type="password" name="password" required
                                class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all sm:text-sm font-medium" placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center">
                            <input id="remember" type="checkbox" name="remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded bg-slate-50 cursor-pointer">
                            <label for="remember" class="ml-2 block text-sm font-medium text-slate-600 cursor-pointer select-none">
                                Ingat Saya
                            </label>
                        </div>
                        <a href="#" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors">Lupa password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full flex justify-center items-center py-4 px-4 border border-transparent rounded-2xl shadow-lg shadow-indigo-600/20 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 hover:shadow-indigo-600/40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:-translate-y-0.5 transition-all duration-200 mt-8">
                        Masuk Sekarang
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>
            <div class="px-8 py-6 bg-slate-50/80 border-t border-slate-100 text-center">
                <p class="text-sm font-medium text-slate-600">
                    Belum punya akun? <a href="#" class="font-bold text-indigo-600 hover:text-indigo-800 transition-colors ml-1">Daftarkan Klub Anda</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
