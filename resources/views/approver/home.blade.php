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

    {{-- content --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('dashboard Approver') }}</div>

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
                                    <th scope="col">Binusian ID Peminjam</th>
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
                                        <td>{{ $req->binusian_id_peminjam }}</td>
                                        <td>{{ $req->purpose }}</td>
                                        <td>{{ date('d M Y H:i', strtotime($req->book_date)) }}</td>
                                        <td>{{ date('d M Y H:i', strtotime($req->return_date)) }}</td>
                                        <td>{{ $req->lokasi }}</td>
                                        <td>
                                            {{--                                        DONE: ini kalo staff usernya gmn? --}}
                                            <form
                                                action="{{ route('bookings.show', ['user' => \Illuminate\Support\Facades\Auth::user()->role->name, 'id' => $req->id]) }}"
                                                method="GET">
                                                @csrf
                                                <button type="submit" class="btn btn-small btn-primary mb-3">
                                                    <span class="material-symbols-outlined">visibility</span>
                                                </button>
                                            </form>
                                        </td>
                                        @if ($req->status == 'waiting approval')
                                            <td>{{ $req->status . ' dari divisi ' . \App\Models\Division::find($req->division_id)->name }}
                                            </td>
                                        @elseif ($req->status == 'waiting next approval')
                                            <td>
                                                waiting next approval
                                            </td>
                                        @else
                                            <td>{{ $req->status }}</td>
                                        @endif
                                        <td>
                                            @if ($req->status == 'waiting approval')
                                                <form action="{{ route('cancel', ['request_delete_id' => $req->id]) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Cancel</button>
                                                </form>
                                            @elseif($req->status == 'waiting next approval')
                                                <form action="{{ route('reject', ['request_delete_id' => $req->id]) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Tidak Jadi Pinjam</button>
                                                </form>
                                                <form action="{{ route('approve', ['request_delete_id' => $req->id]) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Jadi Pinjam</button>
                                                </form>
                                            @elseif($req->status == 'approved')
                                                {{ 'Silahkan ambil barang sesuai jadwal pinjam.' }}
                                            @elseif($req->status == 'on use' || $req->status == 'done')
                                                <form action="{{ route('unduh') }}" target="_blank" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary" name="request_id"
                                                        value="{{ $req->id }}"><span
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
