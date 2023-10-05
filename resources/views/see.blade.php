@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('content')
    <div class="modal-dialog modal-dialog-centered modal-lg"> 
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Inventory</h5>
            </div>
            <div class="modal-body">

            <table class="display table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Jenis Barang</th>
                            <th>Kategori Barang</th>
                            <th>Brand</th>
                            <th>Spesifikasi Barang</th>
                            <th>Kondisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (session('bookings'))
                            @foreach (session('bookings') as $index => $item)
                                <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $item->serial_number }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->kategori_barang }}</td>
                                    <td>{{ $item->brand }}</td>
                                    <td>{{ $item->spesifikasi_barang }}</td>
                                    <td>{{ $item->status == 'tidak tersedia' ? 'tersedia' : $item->status }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                <div class="mb-3">
                    <label for="pesan" class="col-form-label">Catatan Peminjaman:</label>
                    <textarea class="form-control" id="pesan" name="pesan" readonly autofocus>{{ session('request') }}</textarea>
                </div>

            </div>

        </div>
    </div>
@endsection