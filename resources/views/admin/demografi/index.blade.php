@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __($title) }}
        </h2>
        <div class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
            Data Desa Tegalsambi
        </div>
    </div>
@endsection

@section('content')
@php 
    $labelCol = 'kategori';
    switch ((string)$type) {
        case 'pendidikan': $labelCol = 'tingkat_pendidikan'; break;
        case 'pekerjaan': $labelCol = 'jenis_pekerjaan'; break;
        case 'agama': $labelCol = 'agama'; break;
        case 'umur': $labelCol = 'rentang_umur'; break;
    }
    
    $total = $data->sum('jumlah');
    $maxVal = $data->max('jumlah') > 0 ? $data->max('jumlah') : 1;
@endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Summary Card -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-red-600 to-red-800 text-white overflow-hidden shadow-sm rounded-2xl p-6 relative">
                    <div class="relative z-10">
                        <div class="text-red-100 text-sm font-medium uppercase tracking-wider mb-1">Total {{ str_replace('Data ', '', $title) }}</div>
                        <div class="text-4xl font-bold">{{ number_format($total) }}</div>
                        <div class="text-red-200 text-xs mt-2">Jiwa</div>
                    </div>
                    <!-- Decorative Icon -->
                    <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-4 translate-y-4">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"></path></svg>
                    </div>
                </div>
                
                <div class="bg-white text-gray-800 shadow-sm rounded-2xl p-6 border border-gray-100 flex flex-col justify-center">
                     <div class="text-gray-500 text-sm font-medium uppercase mb-2">Terbanyak</div>
                     @php 
                        $top = $data->sortByDesc('jumlah')->first();
                     @endphp
                     @if($top)
                        <div class="font-bold text-xl truncate" title="{{ $top->$labelCol }}">{{ $top->$labelCol }}</div>
                        <div class="text-red-600 font-bold text-lg">{{ number_format($top->jumlah) }}</div>
                     @else
                        <div class="text-gray-400">-</div>
                     @endif
                </div>

                 <div class="bg-white text-gray-800 shadow-sm rounded-2xl p-6 border border-gray-100 flex flex-col justify-center">
                     <div class="text-gray-500 text-sm font-medium uppercase mb-2">Item Data</div>
                     <div class="font-bold text-3xl">{{ $data->count() }}</div>
                     <div class="text-gray-400 text-xs">Kategori terdaftar</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    @if (session('success'))
                        <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm" role="alert">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif
                    
                    <form action="{{ $routeUpdate }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead>
                                    <tr class="bg-gray-50/50">
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-l-lg">
                                            Kategori / Kelompok
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-1/4">
                                            Visualisasi
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-32">
                                            Jumlah
                                        </th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider rounded-r-lg">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-50 space-y-2">
                                    @foreach ($data as $index => $item)
                                        <tr class="group hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-gray-700 group-hover:text-gray-900">{{ $item->$labelCol }}</div>
                                            </td>
                                            <td class="px-6 py-4 align-middle">
                                                <div class="w-full bg-gray-100 rounded-full h-2">
                                                    @php $percent = ($item->jumlah / $total) * 100; @endphp
                                                    <div class="bg-red-500 h-2 rounded-full" style="width: {{ $percent > 0 ? $percent : 0 }}%"></div>
                                                </div>
                                                <div class="text-[10px] text-gray-400 mt-1">{{ number_format($percent, 1) }}%</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="relative rounded-md shadow-sm">
                                                    <input type="number" name="jumlah[{{ $item->id }}]" value="{{ $item->jumlah }}" 
                                                        class="focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-300 rounded-md py-2 text-right font-medium text-gray-700 bg-gray-50 focus:bg-white transition-colors">
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button type="button" 
                                                    onclick="if(confirm('Apakah Anda yakin ingin menghapus data \'{{ $item->$labelCol }}\' ini?')) document.getElementById('del-{{$item->id}}').submit()" 
                                                    class="text-gray-400 hover:text-red-600 transition-colors p-2 rounded-full hover:bg-red-50" title="Hapus Data">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                    <!-- Baris Tambah Data -->
                                    <tr class="bg-blue-50/30 border border-blue-100 rounded-lg">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center mr-3">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                                </div>
                                                <input type="text" name="new_label" placeholder="Tambah Kategori Baru..." 
                                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md bg-transparent placeholder-gray-400">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <!-- Empty for visualization col -->
                                            <span class="text-xs text-gray-400 italic">Data baru akan muncul setelah disimpan</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <input type="number" name="new_jumlah" placeholder="0" 
                                                class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md text-right bg-white">
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm text-gray-500">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                New
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Footer Actions -->
                        <div class="mt-8 flex items-center justify-between border-t border-gray-100 pt-6">
                            <div class="text-sm text-gray-500">
                                Total Data: <span class="font-bold text-gray-800">{{ $data->count() }}</span> baris
                            </div>
                            <div class="flex gap-4">
                                <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-white border border-gray-300 rounded-xl shadow-sm text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                                    Batal
                                </a>
                                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl shadow-lg hover:shadow-red-500/30 hover:shadow-xl font-bold tracking-wide transform hover:-translate-y-0.5 transition-all duration-200">
                                    SIMPAN PERUBAHAN
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Hidden Delete Forms -->
                    @foreach ($data as $item)
                        <form id="del-{{$item->id}}" action="{{ route('admin.demografi.destroy', ['type' => $type, 'id' => $item->id]) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
