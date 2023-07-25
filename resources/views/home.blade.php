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
            $('.deleteRequestBtn').click(function(e) {
                e.preventDefault();
                var request_id = $(this).val();
                $('#request_id').val(request_id);
                $('#deleteModal').modal('show');
            });
        });
    </script>

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
                                @if (\Illuminate\Support\Facades\Auth::user()->role->name == 'staff')
                                    <th>Milik</th>
                                @endif
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
                                        @if (\Illuminate\Support\Facades\Auth::user()->role->name == 'staff')
                                            <td>{{ \App\Models\Division::getName($item->division_id) }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    @if (session('stat') != 'waiting approval')
                        <div class="mb-3">
                            <label for="pesan" class="col-form-label">Catatan Peminjaman:</label>
                            <textarea class="form-control" id="pesan" name="pesan" readonly autofocus>{{ session('request') }}</textarea>
                        </div>
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    {{--    modal delete --}}
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

    {{--   content --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    @if (\Illuminate\Support\Facades\Auth::user()->role->name == 'student')
                        <div class="card-header">{{ __('Dashboard Mahasiswa') }}</div>
                    @elseif(\Illuminate\Support\Facades\Auth::user()->role->name == 'staff')
                        <div class="card-header">{{ __('Dashboard Karyawan') }}</div>
                    @endif

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
                                                <button type="button" class="btn btn-danger rejectBtn mb-2"
                                                    value="{{ $req->id }}">Tolak</button>
                                                <button type="button" class="btn btn-success approveBtn"
                                                    value="{{ $req->id }}">Setuju</button>
                                            @elseif($req->status == 'on use')
                                                {{--                                        DONE: ini tampilin receiptnya --}}
                                                <form action="{{ route('download') }}" target="_blank" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary" name="request_id"
                                                        value="{{ $req->id }}"><span
                                                            class="material-symbols-outlined">file_download</span></button>
                                                </form>
                                            @elseif($req->status == 'approved')
                                                <form action="{{ route('takenBooking') }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary"
                                                        name="request_taken_id" value="{{ $req->id }}">Barang sudah
                                                        diambil</button>
                                                </form>
                                            @endif
                                            @if ($req->flag_return == 1)
                                                <form action="{{ route('admin.formKembali') }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary mt-2" name="request_id"
                                                        value="{{ $req->id }}">Lihat form
                                                        kembali</button>
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
