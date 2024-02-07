@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script defer src="{{ asset('js/datatable10.js') }}"></script>
@endsection

@section('content')
    {{-- content --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('Riwayat Pemindahan Barang') }}</div>

                    <div class="card-body">

                        <table id="myTable10" class="display table">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3" scope="col">No</th>
                                    <th class="px-6 py-3" scope="col">Kode Barang</th>
                                    <th class="px-6 py-3" scope="col">Jenis Barang</th>
                                    <th class="px-6 py-3" scope="col">Kategori Barang</th>
                                    <th class="px-6 py-3" scope="col">Brand</th>
                                    <th class="px-6 py-3" scope="col">Spesifikasi Barang</th>
                                    <th class="px-6 py-3" scope="col">Lokasi pemindahan</th>
                                    <th class="px-6 py-3" scope="col">Oleh</th>
                                    <th class="px-6 py-3" scope="col">Tanggal</th>
                                    <th class="px-6 py-3" scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $rec)
                                    <tr>
                                        {{--                masukin kolom --}}
                                        <td class="px-6 py-3" scope="row">{{ $index + 1 }}</td>
                                        <td>{{ $rec->asset->serial_number }}</td>
                                        <td>{{ $rec->asset->assetJenis->name }}</td>
                                        <td>{{ $rec->asset->kategori_barang }}</td>
                                        <td>{{ $rec->asset->brand }}</td>
                                        <td>{{ $rec->asset->spesifikasi_barang }}</td>
                                        <td>{{ $rec->to_location }}</td>
                                        <td>{{ $rec->responsible }}</td>
                                        <td>{{ date('d M Y ' . '\Pk' . ' H:i', strtotime($rec->created_at)) }}</td>
                                        <td>{{ $rec->notes }}</td>
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
