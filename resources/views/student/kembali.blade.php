{{--{{ dd($current_date, $returned, $aset, $request) }}--}}
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')

@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Kembali Pinjaman') }}
                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('simpanKembali') }}">
                            @csrf

                            @if($returned)
                                <div class="row mb-3">
                                    <label for="peminjam" class="col-md-4 col-form-label text-md-end">{{ __('Peminjam') }}</label>

                                    <div class="col-md-6">
                                        <input id="peminjam" type="text" class="form-control mt-2" name="peminjam" value="{{ $request->User->name }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="binusianid" class="col-md-4 col-form-label text-md-end">{{ __('Binusian ID') }}</label>

                                    <div class="col-md-6">
                                        <input id="binusianid" type="text" class="form-control mt-2" name="binusianid" value="{{ $request->User->binusianid }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-4 col-form-label text-md-end">{{ __('Periode Peminjaman') }}</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control mt-2" value="{{ date("l, d M Y H:i", strtotime($request->book_date)) . ' - ' . date("l, d M Y H:i", strtotime($request->return_date)) }}" readonly>
                                    </div>
                                </div>
                            @endif

                            <div class="row mb-3">
                                <label for="realize_return_date" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Pengembalian') }}</label>

                                <div class="col-md-6">
                                    <input id="realize_return_date" type="text" class="form-control mt-2" name="realize_return_date" value="{{ $current_date }}" readonly>
                                </div>
                            </div>

                            @if($returned)
                                <div class="mb-3">
                                    <label for="purpose" class="col-form-label text-md-end"><b>{{ __('Tujuan Peminjaman') }}</b></label>

                                    <div>
                                        <textarea class="form-control" id="purpose" name="purpose" required readonly>{{$request->purpose}}</textarea>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="col-form-label text-md-end">{{ __('Barang yang dikembalikan') }}</label>

                                <div class="md-6">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nomor Seri</th>
                                            <th>Jenis</th>
                                            <th>Merek</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($aset as $index => $item)
                                            <tr>
                                                <th scope="row">{{$index+1}}</th>
                                                <td>{{$item->serial_number}}</td>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->brand}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if($returned)
                                <div class="row mb-3">
                                    <label for="return_status" class="col-md-4 col-form-label text-md-end">{{ __('Kondisi Barang') }}</label>

                                    <div class="col-md-6">
                                        <input id="return_status" type="text" class="form-control mt-2" name="return_status" value="{{ $request->return_status }}" readonly>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label text-md-end"><b>{{ __('Deskripsi Pengembalian') }}</b></label>

                                    <div>
                                        <textarea class="form-control" readonly>{{$request->return_notes}}</textarea>
                                    </div>
                                </div>
                            @endif

                            @if(!$returned)
                                <div class="mb-3">
                                    <label class="col-form-label text-md-end">{{ __('Apakah barang dalam kondisi yang baik?') }}</label>

                                    <div class="md-6">
                                        <input class="form-check-input mt-1" type="radio" id="kondisi_aset" name="kondisi_aset" value="aman" checked onclick="document.getElementById('return_condition').removeAttribute('required')" />
                                        <label for="kondisi_aset">Ya</label>
                                    </div>
                                    <div class="md-6">
                                        <input class="form-check-input mt-1" type="radio" id="kondisi_aset" name="kondisi_aset" value="rusak" onclick="document.getElementById('return_condition').setAttribute('required', 'required')" />
                                        <label for="kondisi_aset">Tidak</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="return_condition" class="col-form-label text-md-end">{{ __('Deskripsi Kondisi Barang') }}</label>

                                    <div>
                                        <textarea class="form-control" id="return_condition" name="return_condition" autofocus>{{$request->return_notes}}</textarea>
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <div class="md-6">
                                        <input type="hidden" name="request_id" value="{{$request->id}}">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Submit') }}
                                        </button>
                                    </div>
                                </div>
                            @endif

                        </form>




                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
