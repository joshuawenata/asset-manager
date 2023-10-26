@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if (session('message'))
                    @if (session('message') == 'Data Uploaded Successfully!')
                        <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                    @else
                        <div class="alert alert-danger" role="alert">{{ session('message') }}</div>
                    @endif
                @endif

                <div class="card">

                    <div class="card-header">
                        {{ __('Tambahkan Barang') }}
                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('admin.storeAssetExcel') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-10">
                                <label for="excel"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Upload File Excel: ') }}</label>

                                <div class="col-md-6">
                                    <input id="excel" 
                                        type="file"
                                        class="form-input @error('excel') is-invalid @enderror block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                        name="excel"
                                        value="{{ old('excel') }}"
                                        required
                                        autocomplete="excel"
                                        autofocus>

                                    @error('excel')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>file harus diisi dan menggunakan ekstension .xlsx</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                        {{ __('Tambahkan') }}
                                    </button>
                                </div>
                            </div>

                        </form>

                        <form action="{{ route('unduhExcel') }}">
                            @csrf
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                        {{ __('Unduh Template Excel') }}
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
