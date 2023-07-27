@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if (session('message'))
                    @if (session('message') == 'Data Uploaded failed!' ||
                            session('message') == 'Please choose your file!' ||
                            session('message') == 'Error: The file is unreadable or corrupted. Please upload a valid Excel file.' ||
                            session('message') ==
                                'Error: No file type detected. Please upload a valid Excel file with the .xlsx extension.' ||
                            session('message') == 'An error occurred while processing the file. Please try again.')
                        <div class="alert alert-danger" role="alert">{{ session('message') }}</div>
                    @else
                        <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                    @endif
                @endif

                <div class="card">

                    <div class="card-header">
                        {{ __('Tambahkan Barang') }}
                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('staff.storeAssetExcel') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="excel"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Upload File Excel: ') }}</label>

                                <div class="col-md-6">
                                    <input id="excel" type="file"
                                        class="form-control @error('excel') is-invalid @enderror" name="excel"
                                        value="{{ old('excel') }}" required autocomplete="excel" autofocus>

                                    @error('excel')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>file harus diisi dan menggunakan ekstension .xlsx</strong>
                                        </span>
                                    @enderror
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

                        <form action="{{ route('downloadExcel') }}">
                            @csrf
                            <div class="row mb-0 mt-2">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Download Template Excel') }}
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
