@extends('layouts.app')

@section('js')
    <script defer src="{{ asset('js/datatable.js')}}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('Silahkan cek peminjaman Anda!') }}</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('storeRequest') }}">
                            @csrf

                            <table id="myTable" class="table">
                                <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nomor Seri</th>
                                    <th scope="col">Jenis</th>
                                    <th scope="col">Merek</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($assets as $index => $item)
                                    <tr>
                                        {{--                masukin kolom--}}
                                        <th scope="row">{{$index+1}}</th>
                                        <td>{{$item->serial_number}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->brand}}</td>
                                        <input type="hidden" name="assets[]" value="{{$item->id}}">
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="mb-3">
                                <label for="purpose" class="col-form-label text-md-end"><b>{{ __('Tujuan Peminjaman') }}</b></label>

                                <div>
                                    <textarea class="form-control" id="purpose" name="purpose" required readonly>{{$purpose}}</textarea>
                                </div>
                            </div>

{{--                            lokasi--}}
                            <div class="mb-3">
                                <label for="lokasi" class="col-form-label text-md-end"><b>{{ __('Lokasi Peminjaman') }}</b></label>

                                <div>
                                    <div class="col-sm-5 col-md-6"><input type="text" class="form-control mt-2" readonly name="lokasi" value="{{$lokasi}}" /></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-sm-5 col-md-6"><label class="col-form-label text-md-end"><b>{{ __('Tanggal Pinjam') }}</b></label></div>
                                    <div class="col-sm-5 col-md-6"><label class="col-form-label text-md-end"><b>{{ __('Tanggal Kembali') }}</b></label></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5 col-md-6"><input type="text" class="form-control mt-2" readonly name="book_date" value="{{date("l, d M Y H:i", $book_date)}}" /></div>
                                    <div class="col-sm-5 col-md-6"><input type="text" class="form-control mt-2" readonly name="return_date" value="{{date("l, d M Y H:i", $return_date)}}" /></div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-0">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Konfirmasi') }}
                                    </button>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
