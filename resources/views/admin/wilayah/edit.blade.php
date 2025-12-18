@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Edit Wilayah: {{ $wilayah->nama }}</h2>
                        <a href="{{ route('admin.wilayah.index') }}" class="text-gray-600 hover:text-gray-900">← Kembali</a>
                    </div>

                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.wilayah.update', $wilayah) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="nama">
                                Nama Wilayah *
                            </label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $wilayah->nama) }}" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="tingkat">
                                Tingkat Wilayah *
                            </label>
                            <select name="tingkat" id="tingkat"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="desa" {{ old('tingkat', $wilayah->tingkat) == 'desa' ? 'selected' : '' }}>Desa
                                </option>
                                <option value="dusun" {{ old('tingkat', $wilayah->tingkat) == 'dusun' ? 'selected' : '' }}>
                                    Dusun</option>
                                <option value="rw" {{ old('tingkat', $wilayah->tingkat) == 'rw' ? 'selected' : '' }}>RW
                                </option>
                                <option value="rt" {{ old('tingkat', $wilayah->tingkat) == 'rt' ? 'selected' : '' }}>RT
                                </option>
                            </select>
                        </div>

                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="kk">
                                    Jumlah KK *
                                </label>
                                <input type="number" name="kk" id="kk" value="{{ old('kk', $wilayah->kk) }}" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="l">
                                    Laki-laki (L) *
                                </label>
                                <input type="number" name="l" id="l" value="{{ old('l', $wilayah->l) }}" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="p">
                                    Perempuan (P) *
                                </label>
                                <input type="number" name="p" id="p" value="{{ old('p', $wilayah->p) }}" required
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update
                            </button>
                            <a href="{{ route('admin.wilayah.index') }}" class="text-gray-600 hover:text-gray-900">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection