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
            $('.perbaikiBtn').click(function() {
                var repair_id = $(this).val();
                $('#repair_id').val(repair_id);
                console.log(repair_id);
                // Trigger the form submission
                $('#repairForm').submit();
            });
        });
    </script>
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


                @if ($status != 'dipinjam')
                    @if ($fixed == 1)
                        <a class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 no-underline"
                            href="{{ url('create-repair-asset/' . $asset->id) }}">Lapor Kerusakan</a>
                    @endif
                @endif

                <div class="card mt-3">
                    <div class="card-header">{{ __('Riwayat Reparasi Barang') }}</div>

                    <div class="card-body">

                        @if (session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <table id="myTable" class="display table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Tanggal Lapor</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Pelapor</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Tanggal Perbaikan</th>
                                    <th scope="col">Perbaikan Oleh</th>
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
                                                    <input type="hidden" name="repair_id" id="repair_id">
                                                    <button title="perbaiki barang" type="button" class="perbaikiBtn no-underline text-white bg-gradient-to-r from-lime-500 via-lime-600 to-lime-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300 dark:focus:ring-lime-800 shadow-lg shadow-lime-500/50 dark:shadow-lg dark:shadow-lime-800/80 font-medium rounded-lg text-sm px-3 py-2 text-center m-0.5" value="{{ $item->id }}">
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