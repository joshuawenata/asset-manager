@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script defer src="{{ asset('js/datatable.js') }}"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script defer>
        $(document).ready(function() {

            if (window.location.href.indexOf('#see') != -1) {
                $('#see').modal('show');
            }

        });
    </script>
@endsection

@section('content')
    {{--    modal see --}}
    <div class="modal fade" id="see" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Inventory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <div class="modal-footer">
                    <button type="button" class="text-white text-gray-900 bg-gray-500 border border-gray-500 focus:outline-none hover:bg-gray-300 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    {{-- content --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('Riwayat Peminjaman') }}</div>

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

                        <table id="myTable10" class="display table w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3" scope="col">No</th>
                                    <th class="px-6 py-3" scope="col">Nama Peminjam</th>
                                    <th class="px-6 py-3" scope="col">Binusian ID</th>
                                    <th class="px-6 py-3" scope="col">Tujuan Peminjaman</th>
                                    <th class="px-6 py-3" scope="col">Tanggal Pinjam</th>
                                    <th class="px-6 py-3" scope="col">Tanggal Kembali</th>
                                    <th class="px-6 py-3" scope="col">Lokasi</th>
                                    <th class="px-6 py-3" scope="col">Lihat inventory</th>
                                    <th class="px-6 py-3" scope="col">Status</th>
                                    <th class="px-6 py-3" scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $req)
                                    <tr>
                                        <td class="px-6 py-3" scope="row">{{ $index + 1 }}</td>
                                        <td>{{ $req->nama_peminjam }}</td>
                                        <td>{{ $req->binusian_id_peminjam }}</td>
                                        <td>{{ $req->purpose }}</td>
                                        <td>{{ date('d M Y H:i', strtotime($req->book_date)) }}</td>
                                        <td>{{ date('d M Y H:i', strtotime($req->return_date)) }}</td>
                                        <td>{{ $req->lokasi }}</td>
                                        <td>
                                            <form
                                                action="{{ route('bookings.show', ['user' => \Illuminate\Support\Facades\Auth::user()->role->name, 'id' => $req->id]) }}"
                                                method="GET">
                                                @csrf
                                                <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
                                                    <span class="material-symbols-outlined">visibility</span>
                                                </button>
                                            </form>
                                        </td>
                                        <td>{{ $req->status }}</td>
                                        <td>
                                            @if ($req->status == 'done')
                                                <form action="{{ route('unduh') }}" target="_blank" method="post">
                                                    @csrf
                                                    <button type="submit"
                                                        @if ($req->return_notice == 'isu_rusak') class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                                                        @else
                                                            class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2" @endif
                                                        name="request_id" value="{{ $req->id }}"><span
                                                            class="material-symbols-outlined">file_download</span></button>
                                                </form>
                                            @endif
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
