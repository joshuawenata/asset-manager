@extends('layouts.app')

@section('js')
    <script defer src="{{ asset('js/datatable.js') }}"></script>
@endsection

@section('css')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if ($mode == 'current')
                    <a href="{{ route('admin.createAsset') }}" type="button" class="no-underline text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                        Add New Item
                    </a>
                @endif

                <div class="card">
                    <div class="card-header">{{ __('Kelola Barang') }}</div>

                    <div class="card-body">

                        @if (session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <table class="display nowrap table" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kode Barang</th>
                                    <th scope="col">Jenis Barang</th>
                                    <th scope="col">Kategori Barang</th>
                                    <th scope="col">Brand</th>
                                    <th scope="col">Spesifikasi Barang</th>
                                    @if ($mode == 'current')
                                        <th scope="col">Lokasi</th>
                                    @endif
                                    <th scope="col">Pemilik Barang</th>
                                    @if ($mode == 'deleted')
                                    <th scope="col">Timestamp</th>
                                    @endif
                                    @if ($mode == 'current')
                                        <th scope="col">Status</th>
                                        <th scope="col">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        {{--                masukin kolom --}}
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $item->serial_number }}</td>
                                        <td>{{ $item->assetJenis->name }}</td>
                                        <td>{{ $item->kategori_barang }}</td>
                                        <td>{{ $item->brand }}</td>
                                        <td>{{ $item->spesifikasi_barang }}</td>
                                        @if ($mode == 'current')
                                            <td>{{ $item->current_location }}</td>
                                        @endif
                                        <td>{{ $item->pemilik_barang }}</td>
                                        @if ($mode == 'deleted')
                                            <td>{{ $item->created_at }}</td>
                                        @endif
                                        @if ($mode == 'current')
                                            @if ($item->status == 'dipinjam')
                                                <td>{{ $item->status . ' oleh ' . $item->getNamaPeminjam($item->id) }}</td>
                                            @else
                                                <td>{{ $item->status }}</td>
                                            @endif

                                            <td style="width: 2.5rem; height: 2.5rem;">
                                                <a title="Edit Barang" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-2 py-2 text-center m-0.5" href="{{ URL::to('/edit-asset/' . $item->id) }}">
                                                    <span class="material-icons">edit</span>
                                                </a>

                                                @if ($item->status != 'dipinjam')
                                                    <a title="Hapus Barang" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded text-sm px-2 py-2 text-center m-0.5" href="{{ URL::to('/delete-asset/' . $item->id) }}">
                                                        <span class="material-icons">delete</span>
                                                    </a>
                                                @endif

                                                <a title="Barang Rusak" class="text-white bg-gradient-to-r from-green-600 via-green-700 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-500 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-2 py-2 text-center m-0.5" href="{{ URL::to('/repair-asset-history/' . $item->id) }}">
                                                    <span class="material-icons">build</span>
                                                </a>

                                                <a title="Riwayat Pemindahan" class="place-content-center text-white bg-gradient-to-r from-green-600 via-green-700 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-500 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-2 py-2 text-center m-0.5" href="{{ URL::to('/move-asset-history/' . $item->id) }}">
                                                    <span class="material-icons">unarchive</span>
                                                </a>
                                            </td>

                                        @endif
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
