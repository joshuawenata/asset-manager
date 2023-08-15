@extends('layouts.app')

@section('js')
    <script defer src="{{ asset('js/datatable.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('Riwayat Akun Admin') }}</div>

                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        <table id="myTable" class="display nowrap table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Aksi</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counting = 0;
                                @endphp
                                @foreach ($dataHistoryAddAsset as $index => $req)
                                    <tr>
                                        {{--                masukin kolom --}}
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $req->aksi }}</td>
                                        <td>{{ $req->created_at }}</td>
                                    </tr>
                                    @php
                                        $counting++;
                                    @endphp
                                @endforeach
                                @php
                                    $counting1 = 0;
                                @endphp
                                @foreach ($dataHistoryPemusnahanBarang as $index => $req)
                                    <tr>
                                        {{--                masukin kolom --}}
                                        <th scope="row">{{ $index + 1 + $counting }}</th>
                                        <td>{{ $user[0]['name'] . ' memusnahkan barang dengan nomor seri ' . $req->serial_number . ', brand ' . $req->brand . ', lokasi ' . $req->location . ', pemilik barang ' . $req->pemilik_barang . ', divisi ' . $division . ', kategori barang ' }}
                                            @php
                                                $assetJenis = \App\Models\AssetJenis::find($req->asset_jenis_id);
                                            @endphp
                                            {{ $assetJenis ? $assetJenis->name : 'Unknown' }}
                                        </td>
                                        <td>{{ $req->created_at }}</td>
                                    </tr>
                                    @php
                                        $counting1++;
                                    @endphp
                                @endforeach
                                @php
                                    $counting2 = 0;
                                @endphp
                                @foreach ($dataHistoryPembaharuanBarang as $index => $req)
                                    <tr>
                                        {{--                masukin kolom --}}
                                        <th scope="row">{{ $index + 1 + $counting + $counting1 }}</th>
                                        <td>{{ $user[0]['name'] . ' memperbaharui barang dengan nomor seri ' . $req->kode_barang . ', kategori barang ' }}
                                            @php
                                                $assetJenis = \App\Models\AssetJenis::find($req->kategori_barang);
                                            @endphp
                                            {{ $assetJenis ? $assetJenis->name : 'Unknown' }}
                                            {{ ', status barang ' . $req->status_barang . ', spesifikasi barang ' . $req->spesifikasi_barang . ', pemilik barang ' . $req->pemilik_barang . ', divisi ' . $division . ', kategori barang menjadi nomor seri ' . $req->new_kode_barang . ', kategori barang ' }}
                                            @php
                                                $newAssetJenis = \App\Models\AssetJenis::find($req->new_kategori_barang);
                                            @endphp
                                            {{ $newAssetJenis ? $newAssetJenis->name : 'Unknown' }}
                                            {{ ', status barang ' . $req->new_status_barang . ', spesifikasi barang ' . $req->new_spesifikasi_barang . ', pemilik barang ' . $req->new_pemilik_barang }}
                                        </td>
                                        <td>{{ $req->created_at }}</td>
                                    </tr>
                                    @php
                                        $counting2++;
                                    @endphp
                                @endforeach
                                @php
                                    $counting3 = 0;
                                @endphp
                                @foreach ($dataHistoryPemindahanBarang as $index => $req)
                                    <tr>
                                        {{--                masukin kolom --}}
                                        <th scope="row">{{ $index + 1 + $counting + $counting1 + $counting2 }}</th>
                                        <td>{{ $user[0]['name'] . ' memindahkan barang dengan nomor seri ' }}
                                            @php
                                                $asset_serial_number = \App\Models\Asset::find($req->asset_serial_number_id);
                                            @endphp
                                            {{ $asset_serial_number ? $asset_serial_number->name : 'Unknown' }}
                                            {{ ' ke ' . $req->to_location . ' dengan notes ' . $req->notes }}
                                        </td>
                                        <td>{{ $req->created_at }}</td>
                                    </tr>
                                    @php
                                        $counting3++;
                                    @endphp
                                @endforeach
                                @php
                                    $counting4 = 0;
                                @endphp
                                @foreach ($dataHistoryBarangRusak as $index => $req)
                                    <tr>
                                        @if ($req->flag_fixed == 0)
                                            <th scope="row">
                                                {{ $index + 1 + $counting + $counting1 + $counting2 + $counting3 }}</th>
                                            <td>{{ $user[0]['name'] . ' melaporkan kerusakan barang dengan nomor seri ' }}
                                                @php
                                                    $asset_serial_number = \App\Models\Asset::find($req->asset_serial_number_id);
                                                @endphp
                                                {{ $asset_serial_number ? $asset_serial_number->name : 'Unknown' }}
                                                {{ ' dengan deskripsi ' . $req->description }}
                                            </td>
                                            <td>{{ $req->created_at }}</td>
                                        @else
                                            <th scope="row">
                                                {{ $index + 1 + $counting + $counting1 + $counting2 + $counting3 }}</th>
                                            <td>{{ $user[0]['name'] . ' melaporkan kerusakan barang dengan nomor seri ' }}
                                                @php
                                                    $asset_serial_number = \App\Models\Asset::find($req->asset_serial_number_id);
                                                @endphp
                                                {{ $asset_serial_number ? $asset_serial_number->name : 'Unknown' }}
                                                {{ ' dengan deskripsi ' . $req->description . ' dan sudah diperbaiki oleh ' . $req->pic_repair . ' dengan nomor kontak ' . $req->repaired_by }}
                                            </td>
                                            <td>{{ $req->created_at }}</td>
                                        @endif
                                    </tr>
                                    @php
                                        $counting4++;
                                    @endphp
                                @endforeach
                                @php
                                    $counting5 = 0;
                                @endphp
                                @foreach ($data as $index => $req)
                                    <tr>
                                        <th scope="row">
                                            {{ $index + 1 + $counting + $counting1 + $counting2 + $counting3 + $counting4 }}
                                        </th>
                                        <td>{{ $req->aksi }}</td>
                                        <td>{{ $req->created_at }}</td>
                                    </tr>
                                    @php
                                        $counting5++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
