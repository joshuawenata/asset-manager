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

                        <table id="myTable" class="display table w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">No</th>
                                    <th class="px-6 py-3">Aksi</th>
                                    <th class="px-6 py-3">Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counting = 0;
                                @endphp
                                @foreach ($dataHistoryAddAsset as $index => $req)
                                    <tr>
                                        {{--                masukin kolom --}}
                                        <td class="px-6 py-3" scope="row">{{ $index + 1 }}</td>
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
                                        <th class="px-6 py-3" scope="row">{{ $index + $counting + 1 }}</th>
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
