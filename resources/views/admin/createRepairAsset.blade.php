@extends('layouts.app')

@section('css')
@endsection

@section('js')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Laporkan Kerusakan Barang') }}
                    </div>

                    <div class="card-body">



                        <form method="POST" action="{{ route('storeRepairAsset') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="pelapor"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Nama Pelapor') }}</label>

                                <div class="col-md-6">
                                    <input id="pelapor" type="text"
                                        class="form-control @error('pelapor') is-invalid @enderror" name="pelapor"
                                        value="{{ old('pelapor') }}" required autocomplete="pelapor" autofocus>

                                    @error('pelapor')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Deskripsi Kerusakan') }}</label>

                                <div class="col-md-6">
                                    <textarea class="form-control" id="description" name="description" required autofocus></textarea>
                                </div>
                            </div>

                            {{--                            hidden asset id --}}
                            <input type="hidden" name="asset_id" id="asset_id" value="{{ $asset }}">

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                        {{ __('Submit') }}
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
