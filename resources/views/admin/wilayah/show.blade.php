@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Detail Wilayah: {{ $wilayah->nama }}</h2>
                        <a href="{{ route('admin.wilayah.index') }}" class="text-gray-600 hover:text-gray-900">← Kembali</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-bold text-lg mb-2 text-gray-700">Informasi Umum</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between border-b pb-1">
                                    <span class="text-gray-600">ID System</span>
                                    <span class="font-medium">{{ $wilayah->id }}</span>
                                </div>
                                <div class="flex justify-between border-b pb-1">
                                    <span class="text-gray-600">Nama Wilayah</span>
                                    <span class="font-bold text-gray-800">{{ $wilayah->nama }}</span>
                                </div>
                                <div class="flex justify-between border-b pb-1">
                                    <span class="text-gray-600">Tingkat Admin</span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 uppercase">
                                        {{ $wilayah->tingkat }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-red-50 p-4 rounded-lg">
                            <h3 class="font-bold text-lg mb-2 text-red-700">Statistik Kependudukan</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between border-b border-red-200 pb-1">
                                    <span class="text-gray-600">Kepala Keluarga (KK)</span>
                                    <span class="font-medium">{{ number_format($wilayah->kk) }}</span>
                                </div>
                                <div class="flex justify-between border-b border-red-200 pb-1">
                                    <span class="text-gray-600">Laki-laki</span>
                                    <span class="font-medium text-blue-600">{{ number_format($wilayah->l) }}</span>
                                </div>
                                <div class="flex justify-between border-b border-red-200 pb-1">
                                    <span class="text-gray-600">Perempuan</span>
                                    <span class="font-medium text-pink-600">{{ number_format($wilayah->p) }}</span>
                                </div>
                                <div class="flex justify-between pt-2">
                                    <span class="font-bold text-gray-700">Total Penduduk</span>
                                    <span
                                        class="font-black text-xl text-gray-800">{{ number_format($wilayah->l + $wilayah->p) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <a href="{{ route('admin.wilayah.edit', $wilayah) }}"
                            class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                            Edit Data
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection