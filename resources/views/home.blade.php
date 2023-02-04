@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script defer src="{{ asset('js/datatable.js')}}"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script defer>
        $(document).ready(function (){
            $('.deleteRequestBtn').click(function (e){
                e.preventDefault();
                var request_id = $(this).val();
                $('#request_id').val(request_id);
                $('#deleteModal').modal('show');
            });
        });
    </script>

    <script defer>
        $(document).ready(function() {

            if(window.location.href.indexOf('#see') != -1) {
                $('#see').modal('show');
            }

        });
    </script>
@endsection

@section('content')

{{--    modal see--}}
    <div class="modal fade" id="see" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Seri</th>
                            <th>Jenis</th>
                            <th>Spesifikasi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(session('bookings'))
                            @foreach(session('bookings') as $index => $item)
                                <tr>
                                    <th scope="row">{{$index+1}}</th>
                                    <td>{{$item->serial_number}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->brand}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                    @if(session('stat')  != 'waiting approval')
                        @if(session('stat')  != 'rejected')
                            <div class="mb-3">
                                <label for="pesan" class="col-form-label">Catatan Peminjaman:</label>
                                <textarea class="form-control" id="pesan" name="pesan" readonly autofocus>{{ session('request') }}</textarea>
                            </div>
                        @endif
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

{{--    modal delete--}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('deleteRequest') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Cancel Request</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="request_delete_id" id="request_id">
                        <h5>Apakah anda yakin ingin membatalkan request peminjaman?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger">Ya</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

{{--   content--}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('Dashboard Mahasiswa') }}</div>

                    <div class="card-body">

                        @if(session('message'))
                            @if(session('message') == 'Request peminjaman tidak bisa dicancel karena sudah diapprove admin.')
                        {{--                            DONE: kalo gaberhasil cancel warna merah, klo ga ya warna success ijo--}}
                                <div class="alert alert-danger" role="alert">{{ session('message') }}</div>
                            @else
                                <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                            @endif
                        @endif

                        <table id="myTable" class="table">
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Tujuan Peminjaman</th>
                                <th scope="col">Tanggal Pinjam</th>
                                <th scope="col">Tanggal Kembali</th>
{{--                                TODO: tambahin keterangan lokasi pinjemnya dimana --}}
                                <th scope="col">Lihat aset</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $index => $req)
                                <tr>
                                    {{--                masukin kolom--}}
                                    <th scope="row">{{$index+1}}</th>
                                    <td>{{$req->purpose}}</td>
                                    <td>{{date("d M Y H:i", strtotime($req->book_date))}}</td>
                                    <td>{{date("d M Y H:i", strtotime($req->return_date))}}</td>
                                    <td>
{{--                                        DONE: ini kalo staff usernya gmn?--}}
                                        <form action="{{ route('bookings.show', ['user' => \Illuminate\Support\Facades\Auth::user()->role->name, 'id' => $req->id]) }}" method="GET">
                                            @csrf
                                            <button type="submit" class="btn btn-small btn-primary mb-3">
                                                <span class="material-symbols-outlined">visibility</span>
                                            </button>
                                        </form>
                                    </td>
                                    <td>{{$req->status}}</td>
                                    <td>
                                        @if($req->status == 'waiting approval')
                                            <button type="button" class="btn btn-danger deleteRequestBtn" value="{{ $req->id }}">Cancel</button>
                                        @elseif($req->status == 'approved')
                                            {{"Silahkan ambil barang sesuai jadwal pinjam."}}
                                        @elseif($req->status == 'taken')
                                            <form action="{{ route('updateStatus') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="status" value="on use">
                                                <input type="hidden" name="user" value="student">
                                                <button type="submit" class="btn btn-primary" name="request_id" value="{{ $req->id }}">Barang sudah diterima</button>
                                            </form>
                                        @elseif($req->status == 'on use' || $req->status == 'done')
{{--                                        DONE: upgrade laravel biar bisa generate receipt DOMPDF--}}
                                            <form action="{{ route('download') }}" target="_blank" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-primary" name="request_id" value="{{$req->id}}"><span class="material-symbols-outlined">file_download</span></button>
                                            </form>

                                            @if($req->status == 'on use')
                                                <form action="{{ route('kembali') }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary" name="request_return_id" value="{{$req->id}}">
                                                        @if($req->flag_return == null || $req->flag_return == 0)
                                                            Kembalikan
                                                        @elseif($req->flag_return == 1)
                                                            <span class="material-symbols-outlined">visibility</span>
                                                        @endif
                                                    </button>
                                                </form>
                                            @endif
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
