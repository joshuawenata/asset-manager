@extends('layouts.app')

@section('css')
    {{--    <link href="{{ asset('css/pizza.css') }}" rel="stylesheet"> --}}
@endsection

@section('js')
    <script defer src="{{ asset('js/newassetcategory.js') }}"></script>
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

                            {{-- <div class="row mb-3">
                                <label for="asset-category"
                                    class="col-md-4 col-form-label text-md-end">{{ __('') }}</label>

                                <div class="col-md-6">
                                    <div class="mt-2">
                                        <input class="form-check-input mt-1" type="checkbox" id="show2"
                                            name="pemilik-barang" value="" />
                                        <label for="pemilik-barang">Tambah Pemilik Barang Baru</label>
                                    </div>
                                    <div id="box2" style="display: none;">
                                        <input id="new-pemilik-barang" type="text"
                                            class="form-control mt-2 @error('new-pemilik-barang') is-invalid @enderror"
                                            name="new-pemilik-barang" value="{{ old('new-pemilik-barang') }}" />

                                        @error('new-pemilik-barang')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div> --}}

                            <div class="row mb-3">
                                <label for="brand"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Spesifikasi') }}</label>

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
                                    <input type="hidden" name="asset-status" value="tidak tersedia">
                                    <input class="form-check-input mt-1" name="asset-status" type="checkbox"
                                        value="tersedia">
                                    <label for="brand">Barang bisa dipinjam</label>
                                </div>
                            </div>

                            {{-- hidden division id --}}
                            <input type="hidden" name="division_id" id="division_id"
                                value="{{ \Illuminate\Support\Facades\Auth::user()->division->id }}">

                            <div class="row mb-3">
                                <label for="asset-category"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Kategori Barang') }}</label>

                                <div class="col-md-6">
                                    @if ($show)
                                        @foreach ($show as $index => $item)
                                            <div class="mt-2">
                                                <input class="form-check-input mt-1" type="radio" id="hide"
                                                    name="asset-category" value="{{ $item->id }}" checked />
                                                <label for="hide">{{ $item->name }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
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
