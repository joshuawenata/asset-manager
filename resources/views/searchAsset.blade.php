@extends('layouts.app')

@section('js')
    <script defer src="{{ asset('js/datatable.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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

                        <table id="myTable" class="display table w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3" scope="col">No</th>
                                    <th class="px-6 py-3" scope="col">Kode Barang</th>
                                    <th class="px-6 py-3" scope="col">Jenis Barang</th>
                                    <th class="px-6 py-3" scope="col">Kategori Barang</th>
                                    <th class="px-6 py-3" scope="col">Brand</th>
                                    <th class="px-6 py-3" scope="col">Spesifikasi Barang</th>
                                    @if ($mode == 'current')
                                        <th class="px-6 py-3" scope="col">Lokasi</th>
                                    @endif
                                    <th class="px-6 py-3" scope="col">Pemilik Barang</th>
                                    @if ($mode == 'current')
                                        <th class="px-6 py-3" scope="col">Status</th>
                                    @endif
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
                                        @if ($mode == 'current')
                                            <td>{{ $item->current_location }}</td>
                                        @endif
                                        <td>{{ $item->pemilik_barang }}</td>
                                        @if ($mode == 'current')
                                            @if ($item->status == 'dipinjam')
                                                <td>{{ $item->status . ' oleh ' . $item->getNamaPeminjam($item->id) }}</td>
                                            @else
                                                <td>{{ $item->status }}</td>
                                            @endif
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
