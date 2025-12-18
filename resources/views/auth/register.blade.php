<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - SIG Desa Tegalsambi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full bg-white font-sans antialiased">
    <div class="min-h-screen flex">
        
        <!-- Left Side - Visual (Hidden on mobile, Visible on desktop) -->
         <div class="hidden lg:block lg:w-1/2 relative bg-gray-900 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1516937963542-a3a1f984a4da?q=80&w=2070&auto=format&fit=crop" 
                 class="absolute inset-0 w-full h-full object-cover opacity-60" 
                 alt="Aerial View">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 to-transparent"></div>
            
            <div class="relative z-10 w-full h-full flex flex-col justify-between p-12 text-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center shadow-lg shadow-red-600/20">
                         <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-wide">SIG DESA</h1>
                        <p class="text-[10px] text-gray-300 uppercase tracking-widest">Tegalsambi</p>
                    </div>
                </div>

                <div>
                    <h2 class="text-4xl font-bold leading-tight mb-4">Bergabunglah <br><span class="text-red-400">Bersama Kami</span></h2>
                    <p class="text-gray-300 text-lg max-w-md">Daftarkan akun administrator baru untuk mulai mengelola data geospasial desa secara menyeluruh.</p>
                </div>

                <div class="text-xs text-gray-500 font-mono">
                    &copy; 2025 WebGIS Team.
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center bg-white p-8 sm:p-12 xl:p-24 relative overflow-y-auto">
             <!-- Mobile Header Logo -->
             <div class="lg:hidden flex justify-center mb-8">
                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center text-red-600">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-2 text-center lg:text-left">Buat Akun Baru</h2>
            <p class="text-gray-500 text-sm mb-8 text-center lg:text-left">Isi formulir pendaftaran dengan data yang valid.</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                
                <div class="space-y-1">
                    <label for="name" class="text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input id="name" name="name" type="text" required autofocus
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all bg-gray-50 focus:bg-white"
                            placeholder="Nama Lengkap" value="{{ old('name') }}">
                    </div>
                     <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-600" />
                </div>

                <div class="space-y-1">
                    <label for="email" class="text-sm font-medium text-gray-700">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" required 
                            class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all bg-gray-50 focus:bg-white"
                            placeholder="user@example.com" value="{{ old('email') }}">
                    </div>
                     <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-600" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                         <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" required 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all bg-gray-50 focus:bg-white"
                                placeholder="••••••••">
                        </div>
                         <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-600" />
                    </div>

                    <div class="space-y-1">
                         <label for="password_confirmation" class="text-sm font-medium text-gray-700">Konfirmasi</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-green-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input id="password_confirmation" name="password_confirmation" type="password" required 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all bg-gray-50 focus:bg-white"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-red-500/30 transition-all transform hover:-translate-y-0.5 mt-2 flex justify-center items-center gap-2">
                    Daftar Sekarang
                </button>
            </form>
            
            <p class="mt-8 text-center text-sm text-gray-500">
                Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-red-600 hover:text-red-700">Masuk disini</a>
            </p>
        </div>
    </div>
</body>
</html>