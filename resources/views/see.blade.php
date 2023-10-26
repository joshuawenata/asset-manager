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

                <div class="relative overflow-x-auto">
                    <table class="display table w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    
                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Kode Barang</th>
                                <th class="px-6 py-3">Jenis Barang</th>
                                <th class="px-6 py-3">Kategori Barang</th>
                                <th class="px-6 py-3">Brand</th>
                                <th class="px-6 py-3">Spesifikasi Barang</th>
                                <th class="px-6 py-3">Kondisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (session('bookings'))
                                @foreach (session('bookings') as $index => $item)
                                    <tr>
                                    <td class="px-6 py-3" scope="row">{{ $index + 1 }}</td>
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
                </div>

                <div class="mb-3">
                    <label for="pesan" class="col-form-label">Catatan Peminjaman:</label>
                    <textarea class="form-control" id="pesan" name="pesan" readonly autofocus>{{ session('request') }}</textarea>
                </div>

            </div>

        </div>
    </div>
@endsection