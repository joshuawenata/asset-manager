@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script defer src="{{ asset('js/datatable10.js') }}"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if ($errors->any())
                    <div id="alert-border-1" class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <div class="ml-3 text-sm font-medium">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-border-1" aria-label="Close">
                        
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        </button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">{{ __('dashboard Karyawan') }}</div>

                    <div class="card-body">


                        @if (session('message'))
                            @if (session('message') == 'Request peminjaman tidak bisa dicancel karena sudah diapprove admin.')
                                {{--                            DONE: kalo gaberhasil cancel warna merah, klo ga ya warna success ijo --}}
                                <div id="alert-border-1" class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
                                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <div class="ml-3 text-sm font-medium">
                                        {{ session('message') }}
                                    </div>
                                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-border-1" aria-label="Close">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    </button>
                                </div>
                            @else
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
                        @endif

                        <div class="relative overflow-x-auto">
                            <table class="display table w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%" id="myTable10">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th class="px-6 py-3" scope="col" class="px-6 py-3">No</th>
                                        <th class="px-6 py-3" scope="col" class="px-6 py-3">Nama Peminjam</th>
                                        <th class="px-6 py-3" scope="col" class="px-6 py-3">Binusian ID</th>
                                        <th class="px-6 py-3" scope="col" class="px-6 py-3">Tujuan Peminjaman</th>
                                        <th class="px-6 py-3" scope="col" class="px-6 py-3">Tanggal Pinjam</th>
                                        <th class="px-6 py-3" scope="col" class="px-6 py-3">Tanggal Kembali</th>
                                        <th class="px-6 py-3" scope="col" class="px-6 py-3">Lokasi</th>
                                        <th class="px-6 py-3" scope="col" class="px-6 py-3">Lihat Inventory</th>
                                        <th class="px-6 py-3" scope="col" class="px-6 py-3">Status</th>
                                        <th class="px-6 py-3" scope="col" class="px-6 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $req)
                                        <tr>
                                            <td class="px-6 py-3" scope="row">{{ $index + 1 }}</td>
                                            <td>{{ $req->name }}</td>
                                            <td>{{ $req->binusianid }}</td>
                                            <td>{{ $req->purpose }}</td>
                                            <td>{{ date('d M Y H:i', strtotime($req->book_date)) }}</td>
                                            <td>{{ date('d M Y H:i', strtotime($req->return_date)) }}</td>
                                            <td>{{ $req->lokasi }}</td>
                                            <td>
                                                {{--                                        DONE: ini masi error --}}
                                                <form
                                                    action="{{ route('bookings.show', ['user' => 'staff', 'id' => $req->id]) }}"
                                                    method="GET">
                                                    @csrf
                                                    <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
                                                        <span class="material-symbols-outlined">visibility</span>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{ $req->status }}</td>
                                            <td>
                                                @if ($req->status == 'waiting approval')
                                                    <form action="{{ route('reject', ['request_perbaharui_id' => $req->id]) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Tolak</button>
                                                    </form>
                                                    <form action="{{ route('approve', ['request_perbaharui_id' => $req->id]) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Setuju</button>
                                                    </form>
                                                @elseif($req->status == 'on use')
                                                    {{--                                        DONE: ini tampilin receiptnya --}}
                                                    <form action="{{ route('kembali') }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 mt-2"
                                                            name="request_return_id" value="{{ $req->id }}">
                                                            @if ($req->flag_return == null || $req->flag_return == 0)
                                                                Kembalikan
                                                            @elseif($req->flag_return == 1)
                                                                <form
                                                                    action="{{ route('bookings.show', ['user' => \Illuminate\Support\Facades\Auth::user()->role->name, 'id' => $req->id]) }}"
                                                                    method="GET">
                                                                    @csrf
                                                                    <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
                                                                        <span class="material-symbols-outlined">visibility</span>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </button>
                                                    </form>
                                                @elseif($req->status == 'approved' || $req->status == 'approved sebagian')
                                                    <form action="{{ route('takenBooking') }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                                                            name="request_taken_id" value="{{ $req->id }}">Barang
                                                            sudah
                                                            diambil</button>
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
    </div>
    <script>
        $('#select-all').click(function(event) {
            if (this.checked) {
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    </script>
@endsection
