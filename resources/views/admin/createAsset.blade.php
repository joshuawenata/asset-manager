@extends('layouts.app')

@section('css')
    {{--    <link href="{{ asset('css/pizza.css') }}" rel="stylesheet">--}}

@endsection

@section('js')
    <script defer src="{{ asset('js/newassetcategory.js')}}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                            {{ __('Tambahkan Aset') }}
                    </div>

                    <div class="card-body">



                        <form method="POST" action="{{ route('storeAsset') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="serialnumber" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Seri') }}</label>

                                <div class="col-md-6">
                                    <input id="serialnumber" type="text" class="form-control @error('serialnumber') is-invalid @enderror" name="serialnumber" value="{{ old('serialnumber') }}" required autocomplete="serialnumber" autofocus>

                                    @error('serialnumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="location" class="col-md-4 col-form-label text-md-end">{{ __('Lokasi Penyimpanan') }}</label>

                                <div class="col-md-6">
                                    <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" required autocomplete="location" autofocus>

                                    @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="brand" class="col-md-4 col-form-label text-md-end">{{ __('Merek') }}</label>

                                <div class="col-md-6">
                                    <input id="brand" type="text" class="form-control @error('brand') is-invalid @enderror" name="brand" value="{{ old('brand') }}" required autocomplete="brand" autofocus>

                                    @error('brand')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

{{--                            hidden division id--}}
                            <input type="hidden" name="division_id" id="division_id" value="{{ \Illuminate\Support\Facades\Auth::user()->division->id }}">

                            <div class="row mb-3">
                                <label for="asset-category" class="col-md-4 col-form-label text-md-end">{{ __('Kategori Aset') }}</label>

                                <div class="col-md-6">
                                    @foreach($show as $index => $item)
                                            <div class="mt-2">
                                                <input class="form-check-input mt-1" type="radio" id="hide" name="asset-category" value="{{ $item->id }}" checked />
                                                <label for="hide">{{ $item->name }}</label>
                                            </div>
                                    @endforeach
                                        <div class="mt-2">
                                            <input class="form-check-input mt-1" type="radio" id="show" name="asset-category" value="" />
                                            <label for="show">Tambah Kategori Aset Baru</label>
                                        </div>
                                        <div id="box" style="display: none;">
                                            <input id="new-asset-category" type="text" class="form-control mt-2 @error('new-asset-category') is-invalid @enderror" name="new-asset-category" value="{{ old('new-asset-category') }}" />

                                            @error('new-asset-category')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
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
