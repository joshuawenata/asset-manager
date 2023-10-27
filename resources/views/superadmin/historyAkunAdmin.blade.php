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
                            <div id="alert-border-1" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
                                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                </svg>
                                <div class="ml-3 text-sm font-medium">
                                    {{ session('message') }}
                                </div>
                                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-border-1" aria-label="Close">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                </button>
                            </div>
                        @endif

                        <table id="myTable" class="display table w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">No</th>
                                    <th class="px-6 py-3">Aksi</th>
                                    <th class="px-6 py-3">Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counting = 0;
                                @endphp
                                @foreach ($dataHistoryAddAsset as $index => $req)
                                    <tr>
                                        {{--                masukin kolom --}}
                                        <td class="px-6 py-3" scope="row">{{ $index + 1 }}</td>
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
                                        <th class="px-6 py-3" scope="row">{{ $index + 1 + $counting }}</th>
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
                                        <th class="px-6 py-3" scope="row">{{ $index + 1 + $counting + $counting1 }}</th>
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
                                        <th class="px-6 py-3" scope="row">{{ $index + 1 + $counting + $counting1 + $counting2 }}</th>
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
                                            <th class="px-6 py-3" scope="row">
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
                                            <th class="px-6 py-3" scope="row">
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
                                        <th class="px-6 py-3" scope="row">
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
