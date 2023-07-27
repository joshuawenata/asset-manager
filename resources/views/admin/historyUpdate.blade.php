@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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

                        <table id="myTable" class="display table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang </th>
                                    <th>Kategori Barang</th>
                                    <th>Status Barang</th>
                                    <th>Spesifikasi Barang</th>
                                    <th>Pemilik Barang</th>
                                    <th>New Kode Barang </th>
                                    <th>New Kategori Barang</th>
                                    <th>New Status Barang</th>
                                    <th>New Spesifikasi Barang</th>
                                    <th>New Pemilik Barang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $req)
                                    <tr>
                                        {{--                masukin kolom --}}
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $req->kode_barang }}</td>
                                        <td>{{ $req->kategori_barang }}</td>
                                        <td>{{ $req->status_barang }}</td>
                                        <td>{{ $req->spesifikasi_barang }}</td>
                                        <td>{{ $req->pemilik_barang }}</td>
                                        <td>{{ $req->new_kode_barang }}</td>
                                        <td>{{ $req->new_kategori_barang }}</td>
                                        <td>{{ $req->new_status_barang }}</td>
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
