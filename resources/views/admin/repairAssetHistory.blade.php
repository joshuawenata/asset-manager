@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script defer src="{{ asset('js/datatable.js') }}"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card mb-3">
                    <div class="card-body">
                        <p><b>Kode Barang&emsp;&ensp;</b>: {{ $asset->serial_number }}</p>
                        <p><b>Jenis Barang&emsp;&ensp;</b>: {{ $asset->assetJenis->name }}</p>
                        <p><b>Kategori Barang&emsp;&emsp;&ensp;</b>: {{ $asset->kategori_barang }}</p>
                        <p><b>Brand&emsp;&emsp;&ensp;</b>: {{ $asset->brand }}</p>
                        <p><b>Spesifikasi Barang&emsp;&emsp;&ensp;</b>: {{ $asset->spesifikasi_barang }}</p>
                        <p><b>Lokasi&emsp;&emsp;&emsp;&emsp;&ensp;</b>: {{ $asset->current_location }}</p>
                        <p><b>Status Barang&emsp;</b>: {{ $asset->status }}</p>
                    </div>
                </div>


                @if ($status != 'dipinjam' && $status != 'dimusnahkan')
                    @if ($fixed == 1)
                        <a class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 no-underline"
                            href="{{ url('create-repair-asset/' . $asset->id) }}">Lapor Kerusakan</a>
                    @endif
                @endif

                <div class="card mt-3">
                    <div class="card-header">{{ __('Riwayat Reparasi Barang') }}</div>

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

                        <table id="myTable7" class="display table">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3" scope="col">No</th>
                                    <th class="px-6 py-3" scope="col">Tanggal Lapor</th>
                                    <th class="px-6 py-3" scope="col">Description</th>
                                    <th class="px-6 py-3" scope="col">Pelapor</th>
                                    <th class="px-6 py-3" scope="col">Action</th>
                                    <th class="px-6 py-3" scope="col">Tanggal Perbaikan</th>
                                    <th class="px-6 py-3" scope="col">Perbaikan Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        {{--                masukin kolom --}}
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ date('l, d M Y', $item->create_at) }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->reported_by }}</td>
                                        <td>
                                            @if (!$item->flag_fixed)
                                                <form id="repairForm" action="{{ route('repair') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="repair_id" value="{{ $item->id }}">
                                                    <button title="perbaiki barang" type="submit" class="perbaikiBtn no-underline text-white bg-gradient-to-r from-lime-500 via-lime-600 to-lime-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300 dark:focus:ring-lime-800 shadow-lg shadow-lime-500/50 dark:shadow-lg dark:shadow-lime-800/80 font-medium rounded-lg text-sm px-3 py-2 text-center m-0.5" value="{{ $item->id }}">
                                                        <span class="material-symbols-outlined">build</span>
                                                    </button>
                                                </form>
                                            @else
                                                Sudah diperbaiki
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->flag_fixed)
                                                {{ date('l, d M Y', $item->perbaharui_at) }}
                                            @else
                                                {{ '-' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->flag_fixed)
                                                {{ $item->pic_repair . ' (' . $item->repaired_by . ')' }}
                                            @else
                                                {{ '-' }}
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