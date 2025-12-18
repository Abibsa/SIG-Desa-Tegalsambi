@extends('layouts.app')

@section('content')
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Hero Section with Pattern -->
            <div class="relative bg-white rounded-2xl p-8 mb-8 shadow-sm border border-gray-100 overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-red-50 to-orange-50 rounded-full blur-3xl opacity-60 -mr-20 -mt-20">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-gray-50 to-gray-100 rounded-full blur-3xl opacity-60 -ml-10 -mb-10">
                </div>

                <div class="relative z-10">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
                        <div>
                            <div
                                class="inline-flex items-center px-3 py-1 rounded-full bg-red-50 text-red-600 text-xs font-medium mb-3 border border-red-100">
                                <span class="flex h-2 w-2 relative mr-2">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                </span>
                                Live System Overview
                            </div>
                            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-2">
                                Dashboard <span class="text-red-600">Terpadu</span>
                            </h1>
                            <p class="text-gray-500 text-lg max-w-2xl">
                                Selamat datang kembali, <span
                                    class="font-semibold text-gray-900">{{ Auth::user()->name }}</span>.
                                Pantau data kependudukan dan statistik wilayah Desa Tegalsambi secara realtime.
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-bold text-gray-900 tracking-tight font-mono" id="clock-time">--:--</p>
                            <p class="text-sm font-medium text-gray-400 uppercase tracking-widest mt-1" id="clock-date">
                                Loading...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Wilayah -->
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="h-12 w-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <span
                            class="inline-flex items-center text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-lg">
                            +100% Active
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Cakupan Wilayah</p>
                        <h3 class="text-3xl font-bold text-gray-900">{{ $totalWilayah }} <span
                                class="text-lg text-gray-400 font-normal">RW</span></h3>
                    </div>
                </div>

                <!-- Total Penduduk -->
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="h-12 w-12 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                        <span
                            class="inline-flex items-center text-xs font-semibold text-gray-500 bg-gray-50 px-2.5 py-1 rounded-lg">
                            Terupdate
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Penduduk</p>
                        <h3 class="text-3xl font-bold text-gray-900">{{ number_format($totalPenduduk) }} <span
                                class="text-lg text-gray-400 font-normal">Jiwa</span></h3>
                    </div>
                </div>

                <!-- Kepadatan -->
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="h-12 w-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <span
                            class="inline-flex items-center text-xs font-semibold text-orange-600 bg-orange-50 px-2.5 py-1 rounded-lg">
                            Avg Density
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Kepadatan Penduduk</p>
                        <h3 class="text-3xl font-bold text-gray-900">{{ $kepadatan }} <span
                                class="text-lg text-gray-400 font-normal">/Ha</span></h3>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Main Content / Table (Span 2) -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Quick Actions -->
                    <div>
                        <div class="flex items-center justify-between mb-4 px-1">
                            <h3 class="text-lg font-bold text-gray-900">Akses Cepat</h3>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <a href="{{ route('home') }}"
                                class="flex flex-col items-center justify-center p-5 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-red-200 transition-all group">
                                <div
                                    class="h-12 w-12 bg-red-50 text-red-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-gray-700 group-hover:text-red-600">Peta
                                    Digital</span>
                            </a>
                            <a href="{{ route('admin.wilayah.index') }}"
                                class="flex flex-col items-center justify-center p-5 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-200 transition-all group">
                                <div
                                    class="h-12 w-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-gray-700 group-hover:text-blue-600">Data
                                    Wilayah</span>
                            </a>
                            <a href="{{ route('admin.poi.index') }}"
                                class="flex flex-col items-center justify-center p-5 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-orange-200 transition-all group">
                                <div
                                    class="h-12 w-12 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-gray-700 group-hover:text-orange-600">Kelola
                                    POI</span>
                            </a>
                            <a href="{{ route('export.csv') }}"
                                class="flex flex-col items-center justify-center p-5 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-emerald-200 transition-all group">
                                <div
                                    class="h-12 w-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <span
                                    class="text-sm font-semibold text-gray-700 group-hover:text-emerald-600">Laporan</span>
                            </a>
                        </div>
                    </div>

                    <!-- Recent Data Table -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <div>
                                <h3 class="font-bold text-gray-900">Database Wilayah</h3>
                                <p class="text-xs text-gray-500">5 data terbaru yang diupdate</p>
                            </div>
                            <a href="{{ route('admin.wilayah.index') }}"
                                class="text-sm text-red-600 hover:text-red-700 font-medium inline-flex items-center gap-1 transition-colors">
                                Lihat Semua
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr
                                        class="text-xs font-semibold tracking-wide text-gray-500 uppercase border-b border-gray-100 bg-gray-50/50">
                                        <th class="px-6 py-4">Wilayah</th>
                                        <th class="px-6 py-4">Kepala Keluarga</th>
                                        <th class="px-6 py-4">Penduduk (L/P)</th>
                                        <th class="px-6 py-4">Total</th>
                                        <th class="px-6 py-4 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($rws->take(5) as $wilayah)
                                        <tr class="hover:bg-gray-50/80 transition-colors group">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div
                                                        class="h-8 w-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center mr-3 font-bold text-xs ring-1 ring-red-100">
                                                        RW</div>
                                                    <span class="font-medium text-gray-900">{{ $wilayah->nama }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="text-sm text-gray-600">{{ number_format($wilayah->kk) }} KK</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3 text-xs">
                                                    <span
                                                        class="flex items-center gap-1.5 text-gray-700 bg-gray-100 px-2.5 py-1 rounded-md font-medium"><span
                                                            class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> L:
                                                        {{ number_format($wilayah->l) }}</span>
                                                    <span
                                                        class="flex items-center gap-1.5 text-gray-700 bg-gray-100 px-2.5 py-1 rounded-md font-medium"><span
                                                            class="w-1.5 h-1.5 rounded-full bg-pink-500"></span> P:
                                                        {{ number_format($wilayah->p) }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="font-bold text-gray-900">{{ number_format($wilayah->l + $wilayah->p) }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('admin.wilayah.edit', $wilayah->id) }}"
                                                    class="inline-flex p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar (Tips / Charts Preview) -->
                <div class="space-y-6">
                    <!-- Quick Stats Box -->
                    <div class="bg-gray-900 rounded-2xl shadow-xl p-6 text-white overflow-hidden relative">

                        <div class="relative z-10 flex items-center justify-between mb-6">
                            <div>
                                <h3 class="font-bold text-lg">System Info</h3>
                                <p class="text-gray-400 text-xs">Performa server realtime</p>
                            </div>
                            <div class="h-8 w-8 bg-gray-800 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="space-y-5 relative z-10">
                            <div>
                                <div class="flex justify-between text-xs mb-2">
                                    <span class="text-gray-400 font-medium">Database Load</span>
                                    <span class="text-green-400 font-bold">Optimal</span>
                                </div>
                                <div class="w-full bg-gray-800 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-green-500 h-1.5 rounded-full" style="width: 25%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs mb-2">
                                    <span class="text-gray-400 font-medium">API Response</span>
                                    <span class="text-blue-400 font-bold">~45ms</span>
                                </div>
                                <div class="w-full bg-gray-800 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-blue-500 h-1.5 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]"
                                        style="width: 60%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-800">
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center justify-center w-full py-2.5 bg-gray-800 hover:bg-gray-700 rounded-xl text-xs font-bold uppercase tracking-wider transition-all hover:shadow-lg">
                                Pengaturan Akun
                            </a>
                        </div>
                    </div>

                    <!-- Mini Calendar / Info -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="h-2 w-2 rounded-full bg-red-600"></span>
                            <h4 class="font-bold text-gray-900 text-sm uppercase tracking-wide">Pemberitahuan</h4>
                        </div>
                        <ul class="space-y-4">
                            <li class="flex gap-3">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-600 leading-relaxed">Pastikan NIK valid (16 digit) saat
                                    menginputkan data Kepala Keluarga baru.</p>
                            </li>
                            <li class="flex gap-3">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-600 leading-relaxed">Lakukan backup database mingguan untuk
                                    mencegah kehilangan data statistik.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];

            const dayName = days[now.getDay()];
            const day = String(now.getDate()).padStart(2, '0');
            const month = months[now.getMonth()];
            const year = now.getFullYear();

            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            document.getElementById('clock-time').textContent = `${hours}:${minutes}`;
            document.getElementById('clock-date').textContent = `${dayName}, ${day} ${month} ${year}`;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
@endsection