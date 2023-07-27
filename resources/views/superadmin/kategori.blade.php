@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script defer src="{{ asset('js/datatable.js') }}"></script>
    <script defer src="{{ asset('js/newassetcategory.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form action="{{ route('superadmin.historyAssetCategory') }}">
                    <button type="submit" class="btn btn-small btn-success mb-3" data-bs-toggle="modal">
                        History Kategori Barang
                    </button>
                </form>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">{{ __('Kelola Kategori Barang') }}</div>

                    <div class="card-body">

                        @if (session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <form method="POST" action="{{ route('createNewAssetCategory') }}">
                            @csrf
                            <div class="mt-2">
                                <input class="form-check-input mt-1 mb-3" type="checkbox" id="show"
                                    name="asset-category" value="" />
                                <label for="show">Tambah Kategori Barang Baru</label>
                            </div>
                            <div id="box" style="display: none;">
                                <input id="new-asset-category" type="text"
                                    class="form-control mt-2 mb-3 @error('new-asset-category') is-invalid @enderror"
                                    name="new-asset-category" value="{{ old('new-asset-category') }}" />

                                @error('new-asset-category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row mb-3" id="box2" style="display: none;">
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Tambahkan') }}
                                    </button>
                                </div>
                            </div>
                        </form>

                        <table id="myTable" class="display table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kategori Barang</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        {{--                                masukin kolom --}}
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <form action="{{ route('perbaharuiKategoriBarang', $item->id) }}"
                                                method="POST">
                                                @csrf
                                                <input class="form-control mb-2" type="text" name="name"
                                                    id="name">
                                                <button class="btn btn-small btn-info" type="submit"><span
                                                        class="material-symbols-outlined">edit_square</span></button>
                                                <a class="btn btn-small btn-danger"
                                                    href="{{ URL::to('delete-kategori-barang/' . $item->id) }}"><span
                                                        class="material-symbols-outlined">delete</span></a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
