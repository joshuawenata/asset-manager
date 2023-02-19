@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script defer src="{{ asset('js/datatable.js')}}"></script>
@endsection

@section('content')

    {{--content--}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('Riwayat Pemindahan Barang') }}</div>

                    <div class="card-body">

                        <table id="myTable" class="display table">
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nomor Seri</th>
                                <th scope="col">Spesifikasi</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Lokasi pemindahan</th>
                                <th scope="col">Oleh</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $index => $rec)
                                <tr>
                                    {{--                masukin kolom--}}
                                    <th scope="row">{{$index+1}}</th>
                                    <td>{{$rec->asset->serial_number}}</td>
                                    <td>{{$rec->asset->brand}}</td>
                                    <td>{{$rec->asset->assetcategory->name}}</td>
                                    <td>{{$rec->to_location}}</td>
                                    <td>{{$rec->responsible}}</td>
                                    <td>{{date("d M Y " . "\Pk" . " H:i", strtotime($rec->created_at))}}</td>
                                    <td>{{$rec->notes}}</td>
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
