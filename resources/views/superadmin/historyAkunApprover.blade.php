@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script defer src="{{ asset('js/datatable.js') }}"></script>
@endsection

@section('content')
    {{-- content --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('Riwayat Akun Approver') }}</div>

                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        <table id="myTable" class="display table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Aksi</th>
                                    <th>Timestamp</th>
                                    <th>Lihat Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $req)
                                    <tr>
                                        {{--                masukin kolom --}}
                                        <th scope="row">{{ $index + 1 }}</th>
                                        @php
                                            $division = \App\Models\Division::find($req->approver_division_id);
                                        @endphp
                                        <td>{{ $req->approver . ' mengajukan peminjaman untuk ' . $req->nama_peminjam . ' dengan barang yang dipinjam merupakan barang divisi ' . $division->name }}
                                        </td>
                                        <td>{{ $req->created_at }}</td>
                                        <td>
                                            <form action="{{ route('unduh') }}" target="_blank" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-primary" name="request_id"
                                                    value="{{ $req->id }}"><span
                                                        class="material-symbols-outlined">file_download</span></button>
                                            </form>
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
