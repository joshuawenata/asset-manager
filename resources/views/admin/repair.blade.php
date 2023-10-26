@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script defer src="{{ asset('js/datatable.js') }}"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@endsection

@section('content')
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('perbaharuiFixedAsset') }}">
                @csrf
                <input type="hidden" name="repair_id" value="{{ $repair_id }}">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Barang Diperbaiki</h1>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pic" class="col-form-label">{{ __('Diperbaiki oleh') }}</label>
                        <input type="text" class="form-control" id="pic" name="pic" autocomplete="pic"
                            autofocus required>
                    </div>
                    <div class="mb-3">
                        <label for="repaired-by" class="col-form-label">{{ __('Kontak') }}</label>
                        <input type="text" class="form-control" id="repaired-by" name="repaired-by"
                            autocomplete="repaired-by" autofocus required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection