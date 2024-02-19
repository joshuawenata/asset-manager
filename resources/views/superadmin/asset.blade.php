@extends('layouts.app')

@section('js')
    <script defer src="{{ asset('js/datatable8.js') }}"></script>
    <script defer src="{{ asset('js/datatable9.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('Kelola Barang') }}</div>

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

                        <table id="myTable9" class="display table w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3" scope="col">No</th>
                                    <th class="px-6 py-3" scope="col">Kode Barang</th>
                                    <th class="px-6 py-3" scope="col">Jenis Barang</th>
                                    <th class="px-6 py-3" scope="col">Kategori Barang</th>
                                    <th class="px-6 py-3" scope="col">Brand</th>
                                    <th class="px-6 py-3" scope="col">Spesifikasi Barang</th>
                                    <th class="px-6 py-3" scope="col">Lokasi</th>
                                    <th class="px-6 py-3" scope="col">Pemilik Barang</th>
                                    <th class="px-6 py-3" scope="col">Timestamp</th>
                                    <th class="px-6 py-3" scope="col">Status</th>
                                    <th class="px-6 py-3" scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        {{--                masukin kolom --}}
                                        <td class="px-6 py-3" scope="row">{{ $index + 1 }}</td>
                                        <td>{{ $item->serial_number }}</td>
                                        <td>{{ $item->assetJenis->name }}</td>
                                        <td>{{ $item->kategori_barang }}</td>
                                        <td>{{ $item->brand }}</td>
                                        <td>{{ $item->spesifikasi_barang }}</td>
                                        <td>{{ $item->current_location }}</td>
                                        <td>{{ $item->pemilik_barang }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        @if ($item->status == 'dipinjam')
                                            <td>{{ $item->status . ' oleh ' . $item->getNamaPeminjam($item->id) }}</td>
                                        @else
                                            <td>{{ $item->status }}</td>
                                        @endif

                                        <td class="flex items-center space-x-2">
                                            <a title="Hapus Barang" class="no-underline text-white bg-gradient-to-r from-red-500 via-red-600 to-red-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-2 py-2 text-center m-0.5" href="{{ URL::to('/delete-asset-permanent/' . $item->id) }}">
                                                <span class="material-symbols-outlined">delete</span>
                                            </a>
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
