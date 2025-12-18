@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Data POI') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.poi.update', $poi) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama -->
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Tempat</label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama', $poi->nama) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                                <select name="kategori" id="kategori"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="Masjid" {{ $poi->kategori == 'Masjid' ? 'selected' : '' }}>🕌 Masjid
                                    </option>
                                    <option value="Musholla" {{ $poi->kategori == 'Musholla' ? 'selected' : '' }}>🕌 Musholla
                                    </option>
                                    <option value="Pemerintahan" {{ $poi->kategori == 'Pemerintahan' ? 'selected' : '' }}>🏛️
                                        Pemerintahan</option>
                                    <option value="Sekolah" {{ $poi->kategori == 'Sekolah' ? 'selected' : '' }}>🏫 Sekolah
                                    </option>
                                    <option value="Kesehatan" {{ $poi->kategori == 'Kesehatan' ? 'selected' : '' }}>🏥
                                        Kesehatan</option>
                                    <option value="Perdagangan" {{ $poi->kategori == 'Perdagangan' ? 'selected' : '' }}>🏪
                                        Perdagangan</option>
                                    <option value="Pendidikan" {{ $poi->kategori == 'Pendidikan' ? 'selected' : '' }}>🎓
                                        Pendidikan</option>
                                    <option value="Agama" {{ $poi->kategori == 'Agama' ? 'selected' : '' }}>🤲 Agama</option>
                                    <option value="Rumah" {{ $poi->kategori == 'Rumah' ? 'selected' : '' }}>🏠 Rumah</option>
                                    <option value="Lainnya" {{ $poi->kategori == 'Lainnya' ? 'selected' : '' }}>📍 Lainnya
                                    </option>
                                </select>
                            </div>

                            <!-- Latitude -->
                            <div>
                                <label for="latitude" class="block text-sm font-medium text-gray-700">Latitude</label>
                                <input type="number" step="any" name="latitude" id="latitude"
                                    value="{{ old('latitude', $poi->latitude) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                            </div>

                            <!-- Longitude -->
                            <div>
                                <label for="longitude" class="block text-sm font-medium text-gray-700">Longitude</label>
                                <input type="number" step="any" name="longitude" id="longitude"
                                    value="{{ old('longitude', $poi->longitude) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required>
                            </div>

                            <!-- Alamat -->
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                <textarea name="alamat" id="alamat" rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('alamat', $poi->alamat) }}</textarea>
                            </div>

                            <!-- Detail Lainnya (Opsional) -->
                            <div>
                                <label for="fasilitas" class="block text-sm font-medium text-gray-700">Fasilitas</label>
                                <input type="text" name="fasilitas" id="fasilitas"
                                    value="{{ old('fasilitas', $poi->fasilitas) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="kontak" class="block text-sm font-medium text-gray-700">Kontak</label>
                                <input type="text" name="kontak" id="kontak" value="{{ old('kontak', $poi->kontak) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="web" class="block text-sm font-medium text-gray-700">Website</label>
                                <input type="text" name="web" id="web" value="{{ old('web', $poi->web) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('admin.poi.index') }}"
                                class="mr-3 px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">Update
                                Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection