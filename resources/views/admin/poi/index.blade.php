@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manajemen POI (Point of Interest)') }}
    </h2>
@endsection

@section('content')
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 border-l-4 border-red-600 pl-4">Manajemen POI</h2>
                    <p class="text-gray-600 mt-1 pl-4">Kelola data lokasi penting di Desa Tegalsambi</p>
                </div>
                <a href="{{ route('admin.poi.create') }}"
                    class="group relative inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white transition-all duration-200 bg-black border border-transparent rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 shadow-lg hover:shadow-red-500/30">
                    <span class="mr-2 text-xl">+</span> Tambah POI Baru
                </a>
            </div>

            <!-- Main Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-6 md:p-8">

                    <!-- Search & Filter Bar -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('admin.poi.index') }}" class="relative max-w-md w-full group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-red-500 transition-colors duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 sm:text-sm transition-all duration-200 ease-in-out shadow-sm"
                                placeholder="Cari nama lokasi atau alamat...">
                        </form>
                    </div>

                    @if (session('success'))
                        <div class="mb-6 flex p-4 bg-green-50 rounded-xl border border-green-200 shadow-sm" role="alert">
                            <svg class="h-5 w-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-green-800 font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Nama Lokasi</th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Kategori</th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Alamat</th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Koordinat</th>
                                    <th scope="col"
                                        class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($pois as $poi)
                                    <tr class="hover:bg-red-50/30 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center text-xl">
                                                    @php
                                                        $kategori = Str::lower($poi->kategori);
                                                        $iconColor = 'text-gray-400';
                                                        $iconPath = '<path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />'; // Default Pin

                                                        if(Str::contains($kategori, ['masjid', 'mush', 'langgar', 'surau', 'ibadah', 'agama'])) {
                                                            $iconColor = 'text-emerald-600';
                                                            // Masjid Realistis
                                                            $iconPath = '<path d="M12 2a2 2 0 0 1 2 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 0 1 7 7h1a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-6a1 1 0 0 1 1-1h1a7 7 0 0 1 7-7V5.73c-.6-.34-1-.99-1-1.73a2 2 0 0 1 2-2Zm0 7a5 5 0 0 0-5 5h10a5 5 0 0 0-5-5Zm-5.8 7H6v4h.2v-4Zm11.6 0H18v4h-.2v-4Z"/>';
                                                        } elseif(Str::contains($kategori, ['pemerinta', 'kantor', 'balai'])) {
                                                            $iconColor = 'text-slate-600';
                                                            $iconPath = '<path fill-rule="evenodd" d="M4 4a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 3a1 1 0 011-1h2a1 1 0 011 1v1H6V7zm1 3a1 1 0 100 2h2a1 1 0 100-2H7zm5-3a1 1 0 011-1h2a1 1 0 011 1v1h-4V7zm1 3a1 1 0 100 2h2a1 1 0 100-2h-2z" clip-rule="evenodd" />';
                                                        } elseif(Str::contains($kategori, ['sekolah', 'pendidikan', 'tk', 'sd', 'smp', 'sma', 'mi', 'mts'])) {
                                                            $iconColor = 'text-blue-600';
                                                            $iconPath = '<path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 000-2"/>';
                                                        } elseif(Str::contains($kategori, ['sehat', 'sakit', 'medis', 'klinik', 'puskesmas'])) {
                                                            $iconColor = 'text-red-600';
                                                            $iconPath = '<path fill-rule="evenodd" d="M10 2a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V3a1 1 0 011-1z" clip-rule="evenodd" />';
                                                        } elseif(Str::contains($kategori, ['dagang', 'toko', 'warung', 'pasar'])) {
                                                            $iconColor = 'text-purple-600';
                                                            $iconPath = '<path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />';
                                                        } elseif(Str::contains($kategori, ['lapangan', 'olahraga', 'sport'])) {
                                                            $iconColor = 'text-orange-500';
                                                            $iconPath = '<path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd" />';
                                                        }
                                                    @endphp
                                                    <svg class="w-6 h-6 {{ $iconColor }}" fill="currentColor" viewBox="0 0 24 24">
                                                        {!! $iconPath !!}
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900">{{ $poi->nama }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $colors = [
                                                    'Pendidikan' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                    'Kesehatan' => 'bg-red-100 text-red-800 border-red-200',
                                                    'Agama' => 'bg-green-100 text-green-800 border-green-200',
                                                    'Masjid' => 'bg-green-100 text-green-800 border-green-200',
                                                    'Musholla' => 'bg-green-100 text-green-800 border-green-200',
                                                    'Pemerintahan' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                ];
                                                $class = $colors[$poi->kategori] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                            @endphp
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $class }}">
                                                {{ $poi->kategori }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
                                            {{ Str::limit($poi->alamat, 40) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-400 font-mono">
                                            {{ number_format($poi->latitude, 6) }},<br>{{ number_format($poi->longitude, 6) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('admin.poi.edit', $poi) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition-colors"
                                                    title="Edit">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.poi.destroy', $poi) }}" method="POST"
                                                    class="inline-block"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors"
                                                        title="Hapus">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span class="text-base font-medium">Belum ada data lokasi yang ditemukan.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $pois->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection