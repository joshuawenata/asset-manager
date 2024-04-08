@extends('layouts.app')

@section('css')
    {{-- Tailwind CSS --}}
@endsection

@section('js')
    <script defer src="{{ asset('js/newassetJenis.js') }}"></script>
@endsection

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-center">
            <div class="w-full md:w-3/4 lg:w-1/2">
                <div class="bg-white shadow-md rounded-lg">
                    <div class="bg-gray-200 px-4 py-2 rounded-t-lg">
                        <h2 class="text-sm font-bold">{{ __('Tambahkan Barang') }}</h2>
                    </div>

                    <div class="p-4">
                        <form method="POST" action="{{ route('staff.storeAsset') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="serial_number" class="block text-sm font-medium text-gray-700">{{ __('Kode Barang') }}</label>
                                <input id="serial_number" type="text" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400  @error('serial_number') @enderror" name="serial_number" value="{{ old('serial_number') }}" required autocomplete="serial_number" autofocus>
                                @error('serial_number')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="location" class="block text-sm font-medium text-gray-700">{{ __('Lokasi Penyimpanan') }}</label>
                                <select class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 " name="location" id="location">
                                    @foreach ($data as $index => $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- fitur baru pemilik barang --}}
                            <div class="mb-4">
                                <label for="pemilik-barang" class="block text-sm font-medium text-gray-700">{{ __('Pemilik Barang') }}</label>
                                <select class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 " name="pemilik-barang" id="pemilik-barang">
                                    @foreach ($pemilik as $index => $item)
                                        <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="asset-jenis" class="block text-sm font-medium text-gray-700">{{ __('Jenis Barang') }}</label>

                                @if ($show)
                                    @foreach ($show as $index => $item)
                                        <div class="mt-2">
                                            <input class="form-checkbox mt-1" type="radio" id="hide" name="asset-jenis" value="{{ $item->id }}" checked />
                                            <label for="hide">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="kategori_barang" class="block text-sm font-medium text-gray-700">{{ __('Kategori Barang') }}</label>
                                <input id="kategori_barang" type="text" class="form-input @error('kategori_barang') @enderror" name="kategori_barang" value="{{ old('kategori_barang') }}" required autocomplete="kategori_barang" autofocus>
                                @error('kategori_barang')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="spesifikasi_barang" class="block text-sm font-medium text-gray-700">{{ __('Spesifikasi Barang') }}</label>
                                <input id="spesifikasi_barang" type="text" class="form-input @error('spesifikasi_barang') @enderror" name="spesifikasi_barang" value="{{ old('spesifikasi_barang') }}" required autocomplete="spesifikasi_barang" autofocus>
                                @error('spesifikasi_barang')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="brand" class="block text-sm font-medium text-gray-700">{{ __('Brand') }}</label>
                                <input id="brand" type="text" class="form-input @error('brand') @enderror" name="brand" value="{{ old('brand') }}" required autocomplete="brand" autofocus>
                                @error('brand')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <input type="hidden" name="asset-status" value="tidak">
                                <input class="form-checkbox mt-1" name="asset-status" type="checkbox" value="tersedia">
                                <label for="brand">{{ __('Barang bisa dipinjam') }}</label>
                            </div>

                            {{-- hidden division id --}}
                            <input type="hidden" name="division_id" id="division_id" value="{{ \Illuminate\Support\Facades\Auth::user()->division->id }}">

                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
                                    {{ __('Tambahkan') }}
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
