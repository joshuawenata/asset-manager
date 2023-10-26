@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script defer src="{{ asset('js/datatable.js') }}"></script>
    <script defer src="{{ asset('js/newpemilikbarang.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form action="{{ route('superadmin.historyPemilikBarang') }}">
                    <button type="submit" class="btn btn-small btn-success mb-3" data-bs-toggle="modal">
                        History Pemilik Barang
                    </button>
                </form>
                <div class="card">
                    <div class="card-header">{{ __('Kelola Pemilik Barang') }}</div>

                    <div class="card-body">

                        @if (session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <form method="POST" action="{{ route('createNewPemilikBarang') }}">
                            @csrf
                            <div class="mt-2">
                                <input class="form-check-input mt-1 mb-3" type="checkbox" id="show"
                                    name="pemilik-barang" value="" />
                                <label for="show">Tambah Pemilik Barang Baru</label>
                            </div>
                            <div id="box" style="display: none;">
                                <input id="new-pemilik-barang" type="text" placeholder="Input Nama Pemilik Barang"
                                    class="form-control mt-2 mb-3 @error('new-pemilik-barang') is-invalid @enderror"
                                    name="new-pemilik-barang" value="{{ old('new-pemilik-barang') }}" />

                                @error('new-pemilik-barang')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div id="box2" style="display: none;">
                                <select class="form-select mb-3" name="division-id" id="division-id">
                                    @foreach ($divisi as $index => $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row mb-3" id="box3" style="display: none;">
                                <div>
                                    <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                        {{ __('Tambahkan') }}
                                    </button>
                                </div>
                            </div>
                        </form>

                        <table id="myTable" class="display table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Prodi/Divisi</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        {{--                                masukin kolom --}}
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $item->nama }}</td>
                                        @foreach ($divisi as $i => $d)
                                            @if ($d->id == $item->division_id)
                                                <td>{{ $d->name }}</td>
                                            @endif
                                        @endforeach
                                        <td>
                                            <a class="btn btn-small btn-danger"
                                                href="{{ URL::to('edit-pemilik-barang/' . $item->id) }}"><span
                                                    class="material-symbols-outlined">delete</span></a>
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
