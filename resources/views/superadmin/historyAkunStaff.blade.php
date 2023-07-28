@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
                    <div class="card-header">{{ __('Riwayat Akun Staff') }}</div>

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
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counting = 0;
                                @endphp
                                @foreach ($dataHistoryAddAsset as $index => $req)
                                    <tr>
                                        {{--                masukin kolom --}}
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $req->aksi }}</td>
                                        <td>{{ $req->created_at }}</td>
                                    </tr>
                                    @php
                                        $counting++;
                                    @endphp
                                @endforeach
                                @foreach ($data as $index => $req)
                                    <tr>
                                        {{--                masukin kolom --}}
                                        <th scope="row">{{ $index + $counting + 1 }}</th>
                                        <td>{{ $req->aksi }}</td>
                                        <td>{{ $req->created_at }}</td>
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
