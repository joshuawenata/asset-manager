@extends('layouts.app')

@section('js')
    <script defer src="{{ asset('js/datatable.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('content')
    {{-- content --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('Riwayat perbaharui Data Barang') }}</div>

                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        <table id="myTable" class="display table w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">No</th>
                                    <th class="px-6 py-3">Kode Barang </th>
                                    <th class="px-6 py-3">Jenis Barang</th>
                                    <th class="px-6 py-3">Kategori Barang</th>
                                    <th class="px-6 py-3">Status Barang</th>
                                    <th class="px-6 py-3">Brand</th>
                                    <th class="px-6 py-3">Spesifikasi Barang</th>
                                    <th class="px-6 py-3">Pemilik Barang</th>
                                    <th class="px-6 py-3">New Kode Barang </th>
                                    <th class="px-6 py-3">New Jenis Barang</th>
                                    <th class="px-6 py-3">New Kategori Barang</th>
                                    <th class="px-6 py-3">New Status Barang</th>
                                    <th class="px-6 py-3">New Brand</th>
                                    <th class="px-6 py-3">New Spesifikasi Barang</th>
                                    <th class="px-6 py-3">New Pemilik Barang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $req)
                                    <tr>
                                        {{--                masukin kolom --}}
                                        <td class="px-6 py-3" scope="row">{{ $index + 1 }}</td>
                                        <td>{{ $req->kode_barang }}</td>
                                        <td>{{ $req->jenis_barang }}</td>
                                        <td>{{ $req->kategori_barang }}</td>
                                        <td>{{ $req->status_barang }}</td>
                                        <td>{{ $req->brand }}</td>
                                        <td>{{ $req->spesifikasi_barang }}</td>
                                        <td>{{ $req->pemilik_barang }}</td>
                                        <td>{{ $req->new_kode_barang }}</td>
                                        <td>{{ $req->new_jenis_barang }}</td>
                                        <td>{{ $req->new_kategori_barang }}</td>
                                        <td>{{ $req->new_status_barang }}</td>
                                        <td>{{ $req->new_brand }}</td>
                                        <td>{{ $req->new_spesifikasi_barang }}</td>
                                        <td>{{ $req->new_pemilik_barang }}</td>
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
