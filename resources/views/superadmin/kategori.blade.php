@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script defer src="{{ asset('js/datatable.js') }}"></script>
    <script defer src="{{ asset('js/newassetjenis.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form action="{{ route('superadmin.historyAssetJenis') }}">
                    <button type="submit" class="btn btn-small btn-success mb-3" data-bs-toggle="modal">
                        History Jenis Barang
                    </button>
                </form>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">{{ __('Kelola Jenis Barang') }}</div>

                    <div class="card-body">

                        @if (session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <form method="POST" action="{{ route('createNewAssetJenis') }}">
                            @csrf
                            <div class="mt-2">
                                <input class="form-check-input mt-1 mb-3" type="checkbox" id="show"
                                    name="asset-Jenis" value="" />
                                <label for="show">Tambah Jenis Barang Baru</label>
                            </div>
                            <div id="box" style="display: none;">
                                <input id="new-asset-Jenis" type="text"
                                    class="form-control mt-2 mb-3 @error('new-asset-jenis') is-invalid @enderror"
                                    name="new-asset-Jenis" value="{{ old('new-asset-jenis') }}" />

                                @error('new-asset-jenis')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row mb-3" id="box2" style="display: none;">
                                <div>
                                    <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                        {{ __('Tambahkan') }}
                                    </button>
                                </div>
                            </div>
                        </form>

                        <table id="myTable" class="display table w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3" scope="col">No</th>
                                    <th class="px-6 py-3" scope="col">Kategori Barang</th>
                                    <th class="px-6 py-3" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        {{--                                masukin kolom --}}
                                        <td class="px-6 py-3" scope="row">{{ $index + 1 }}</td>
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
