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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">{{ __('dashboard Admin') }}</div>

                    <div class="card-body">


                        @if (session('message'))
                            @if (session('message') == 'Request peminjaman tidak bisa dicancel karena sudah diapprove admin.')
                                {{--                            DONE: kalo gaberhasil cancel warna merah, klo ga ya warna success ijo --}}
                                <div class="alert alert-danger" role="alert">{{ session('message') }}</div>
                            @else
                                <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                            @endif
                        @endif

                        <table id="myTable" class="display table" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Peminjam</th>
                                    <th scope="col">Binusian ID</th>
                                    <th scope="col">Tujuan Peminjaman</th>
                                    <th scope="col">Tanggal Pinjam</th>
                                    <th scope="col">Tanggal Kembali</th>
                                    <th scope="col">Lokasi</th>
                                    <th scope="col">Lihat Inventory</th>
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
                                            <form
                                                action="{{ route('bookings.show', ['user' => 'admin', 'id' => $req->id]) }}"
                                                method="GET">
                                                @csrf
                                                <button type="submit" class="btn btn-small btn-primary mb-3">
                                                    <span class="material-symbols-outlined">visibility</span>
                                                </button>
                                            </form>
                                        </td>
                                        <td>{{ $req->status }}</td>
                                        <td>
                                            @if ($req->status == 'waiting approval')
                                                <form action="{{ route('reject', ['request_perbaharui_id' => $req->id]) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                                </form>
                                                <form action="{{ route('approve', ['request_perbaharui_id' => $req->id]) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Setuju</button>
                                                </form>
                                            @elseif($req->status == 'on use')
                                                @if ($req->flag_return == null || $req->flag_return == 0)
                                                    <form action="{{ route('kembali') }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary mt-2"
                                                            name="request_return_id" value="{{ $req->id }}">
                                                                Kembalikan
                                                        </button>
                                                    </form>
                                                @elseif($req->flag_return == 1)
                                                    <form
                                                        action="{{ route('bookings.show', ['user' => \Illuminate\Support\Facades\Auth::user()->role->name, 'id' => $req->id]) }}"
                                                        method="GET">
                                                        @csrf
                                                        <button type="submit" class="btn btn-small btn-primary mb-3">
                                                            <span class="material-symbols-outlined">visibility</span>
                                                        </button>
                                                    </form>
                                                @endif
                                            @elseif($req->status == 'approved' || $req->status == 'approved sebagian')
                                                <form action="{{ route('takenBooking') }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary"
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
