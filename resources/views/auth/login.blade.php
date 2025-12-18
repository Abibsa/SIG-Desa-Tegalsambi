<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - SIG Desa Tegalsambi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
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
                    <h2 class="text-4xl font-bold leading-tight mb-4">Informasi Geografis & <br><span class="text-red-400">Statistik Terpadu</span></h2>
                    <p class="text-gray-300 text-lg max-w-md">Platform manajemen data wilayah desa yang modern, akurat, dan mudah diakses untuk pembangunan yang lebih baik.</p>
                </div>

                <div class="text-xs text-gray-500 font-mono">
                    &copy; 2025 WebGIS Team.
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center bg-white p-8 sm:p-12 xl:p-24 relative overflow-y-auto">
             <!-- Mobile Header Logo (Visible only on small screens) -->
             <div class="lg:hidden flex justify-center mb-8">
                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center text-red-600">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-2 text-center lg:text-left">Selamat Datang</h2>
            <p class="text-gray-500 text-sm mb-10 text-center lg:text-left">Masuk untuk mengakses dashboard admin.</p>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
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
                </div>

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
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                        <span class="text-sm text-gray-600">Ingat Saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-red-500/30 transition-all transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                    Masuk Dashboard
                </button>
            </form>
            
            <p class="mt-8 text-center text-sm text-gray-500">
                Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-red-600 hover:text-red-700">Daftar disini</a>
            </p>
        </div>
    </div>
</body>
</html>