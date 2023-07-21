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

                    <table class="display table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Kategori Barang</th>
                                <th>Spesifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (session('bookings'))
                                @foreach (session('bookings') as $index => $item)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $item->serial_number }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->brand }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <div class="mb-3">
                        <label for="pesan" class="col-form-label">Catatan Peminjaman:</label>
                        <textarea class="form-control" id="pesan" name="pesan" readonly autofocus>{{ session('request') }}</textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        <table id="myTable" class="display table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Peminjam</th>
                                    <th scope="col">Binusian ID</th>
                                    <th scope="col">Tujuan Peminjaman</th>
                                    <th scope="col">Tanggal Pinjam</th>
                                    <th scope="col">Tanggal Kembali</th>
                                    <th scope="col">Lokasi</th>
                                    <th scope="col">Lihat inventory</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $req)
                                    <tr>
                                        {{--                masukin kolom --}}
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $req->name }}</td>
                                        <td>{{ $req->binusianid }}</td>
                                        <td>{{ $req->purpose }}</td>
                                        <td>{{ date('d M Y H:i', strtotime($req->book_date)) }}</td>
                                        <td>{{ date('d M Y H:i', strtotime($req->return_date)) }}</td>
                                        <td>{{ $req->lokasi }}</td>
                                        <td>
                                            {{--                                        DONE: ini masi error --}}
                                            <form action="{{ route('rejectedbookings.show', ['id' => $req->id]) }}"
                                                method="GET">
                                                @csrf
                                                <button type="submit" class="btn btn-small btn-primary mb-3">
                                                    <span class="material-symbols-outlined">visibility</span>
                                                </button>
                                            </form>
                                        </td>
                                        {{--                                    @if ($req->return_notice == 'isu_rusak') --}}
                                        {{--                                        <td style="color: red">{{$req->status}}</td> --}}
                                        {{--                                    @else --}}
                                        <td>{{ $req->status }}</td>
                                        {{--                                    @endif --}}
                                        <td>
                                            @if ($req->status == 'done')
                                                {{--                                        DONE: ini tampilin receiptnya --}}
                                                <form action="{{ route('download') }}" target="_blank" method="post">
                                                    @csrf
                                                    <button type="submit"
                                                        @if ($req->return_notice == 'isu_rusak') class="btn btn-danger"
                                                        @else
                                                            class="btn btn-primary" @endif
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
