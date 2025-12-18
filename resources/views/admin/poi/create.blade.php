@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Tambah POI Baru') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.poi.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama -->
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Tempat</label>
                                <input type="text" name="nama" id="nama"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                                <select name="kategori" id="kategori"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="Masjid">🕌 Masjid</option>
                                    <option value="Musholla">🕌 Musholla</option>
                                    <option value="Pemerintahan">🏛️ Pemerintahan</option>
                                    <option value="Sekolah">🏫 Sekolah</option>
                                    <option value="Kesehatan">🏥 Kesehatan</option>
                                    <option value="Perdagangan">🏪 Perdagangan</option>
                                    <option value="Pendidikan">🎓 Pendidikan</option>
                                    <option value="Agama">🤲 Agama</option>
                                    <option value="Rumah">🏠 Rumah</option>
                                    <option value="Lainnya">📍 Lainnya</option>
                                </select>
                            </div>

                            <!-- Latitude -->
                            <div>
                                <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                                <input type="number" step="any" name="latitude" id="latitude"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                            </div>

                            <!-- Longitude -->
                            <div>
                                <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                                <input type="number" step="any" name="longitude" id="longitude"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                            </div>

                            <!-- Alamat -->
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                <textarea name="alamat" id="alamat" rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            </div>

                            <!-- Detail Lainnya (Opsional) -->
                            <div>
                                <label for="fasilitas" class="block text-sm font-medium text-gray-700">Fasilitas</label>
                                <input type="text" name="fasilitas" id="fasilitas"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="kontak" class="block text-sm font-medium text-gray-700">Kontak</label>
                                <input type="text" name="kontak" id="kontak"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('admin.poi.index') }}"
                                class="mr-3 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">Simpan
                                Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection