@extends('layouts.app')

@section('css')
    {{--    <link href="{{ asset('css/pizza.css') }}" rel="stylesheet"> --}}
@endsection

@section('js')
    <script defer src="{{ asset('js/newassetJenis.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Tambahkan Barang') }}
                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('staff.storeAsset') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="serial_number"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Kode Barang') }}</label>

                                <div class="col-md-6">
                                    <input id="serial_number" type="text"
                                        class="form-control @error('serial_number') is-invalid @enderror"
                                        name="serial_number" value="{{ old('serial_number') }}" required
                                        autocomplete="serial_number" autofocus>

                                    @error('serial_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="location"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Lokasi Penyimpanan') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select" name="location" id="location">
                                        @foreach ($data as $index => $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- fitur baru pemilik barang --}}
                            <div class="row mb-3">
                                <label for="pemilik-barang"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Pemilik Barang') }}</label>
                                <div class="col-md-6">
                                    <select class="form-select" name="pemilik-barang" id="pemilik-barang">
                                        @foreach ($pemilik as $index => $item)
                                            <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="asset-jenis"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Jenis Barang') }}</label>

                                <div class="col-md-6">
                                    @if ($show)
                                        @foreach ($show as $index => $item)
                                            <div class="mt-2">
                                                <input class="form-check-input mt-1" type="radio" id="hide"
                                                    name="asset-jenis" value="{{ $item->id }}" checked />
                                                <label for="hide">{{ $item->name }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="kategori_barang"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Kategori Barang') }}</label>

                                <div class="col-md-6">
                                    <input id="kategori_barang" type="text"
                                        class="form-control @error('kategori_barang') is-invalid @enderror" name="kategori_barang"
                                        value="{{ old('kategori_barang') }}" required autocomplete="kategori_barang" autofocus>

                                    @error('kategori_barang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="spesifikasi_barang"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Spesifikasi Barang') }}</label>

                                <div class="col-md-6">
                                    <input id="spesifikasi_barang" type="text"
                                        class="form-control @error('spesifikasi_barang') is-invalid @enderror" name="spesifikasi_barang"
                                        value="{{ old('spesifikasi_barang') }}" required autocomplete="spesifikasi_barang" autofocus>

                                    @error('spesifikasi_barang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="brand"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Brand') }}</label>

                                <div class="col-md-6">
                                    <input id="brand" type="text"
                                        class="form-control @error('brand') is-invalid @enderror" name="brand"
                                        value="{{ old('brand') }}" required autocomplete="brand" autofocus>

                                    @error('brand')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end"></label>

                                <div class="col-md-6">
                                    <input type="hidden" name="asset-status" value="tidak">
                                    <input class="form-check-input mt-1" name="asset-status" type="checkbox"
                                        value="tersedia">
                                    <label for="brand">Barang bisa dipinjam</label>
                                </div>
                            </div>

                            {{-- hidden division id --}}
                            <input type="hidden" name="division_id" id="division_id"
                                value="{{ \Illuminate\Support\Facades\Auth::user()->division->id }}">


                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                        {{ __('Tambahkan') }}
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
