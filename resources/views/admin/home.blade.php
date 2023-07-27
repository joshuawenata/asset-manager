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
            $('.rejectBtn').click(function(e) {
                e.preventDefault();
                var request_id = $(this).val();
                $('#request_id').val(request_id);
                $('#rejectModal').modal('show');
            });

            if (window.location.href.indexOf('#approve') != -1) {
                $('#approveModal').modal('show');
            }

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
                    <h5 class="modal-title">Aset</h5>
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
                                <th>Kondisi</th>
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
                                        <td>{{ $item->status }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    @if (session('request') != '')
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

    {{--    modal reject --}}
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('perbaharuiRequest') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Reject Request</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="request_perbaharui_id" id="request_id">
                        <input type="hidden" name="request_perbaharui" value="rejected">
                        <input type="hidden" name="user" value="staff">
                        <h5>Apakah anda yakin ingin me-reject request peminjaman?</h5>
                        <div class="mb-3">
                            <label for="pesan" class="col-form-label">Pesan:</label>
                            <textarea class="form-control" id="pesan" name="pesan" autofocus required>{{ '' }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger">Ya</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{--    modal approve --}}
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('perbaharuiRequest') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Approve Request</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="request_perbaharui_id" value="{{ session('request_id') }}">
                        <input type="hidden" name="request_perbaharui" value="approved">
                        <input type="hidden" name="user" value="staff">
                        <input type="hidden" name="approver_num"
                            value="{{ \Illuminate\Support\Facades\Auth::user()->division->approver }}">
                        <h5>Apakah anda yakin ingin meng-approve request peminjaman?</h5>
                        <table class="display table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Kategori Barang</th>
                                    <th>Spesifikasi</th>
                                    <th>Kondisi</th>
                                    <th>Aksi</th>
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
                                            <td>{{ $item->status }}</td>
                                            <!-- Add name attribute to the checkbox inputs -->
                                            <td class="text-center"><input type="checkbox"
                                                    name="booking_approval[{{ $index }}]" value="1" /></td>
                                            <input type="hidden"
                                                name="booking_id[{{ $index }}]"value="{{ $item->id }}">
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-0">
                                <input class="form-check-input mt-1" type="checkbox" name="select-all" id="select-all">
                                <label for="select-all">pilih semua</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="pesan" class="col-form-label">Pesan:</label>
                            <textarea class="form-control" id="pesan" name="pesan" autofocus>{{ ' ' }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-success">Ya</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{--   content --}}
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
                    <div class="card-header">{{ __('Halaman Admin') }}</div>

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
                                                action="{{ route('bookings.show', ['user' => 'staff', 'id' => $req->id]) }}"
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
                                                <form
                                                    action="{{ route('bookings.showApprove', ['user' => 'staff', 'id' => $req->id]) }}"
                                                    method="GET">
                                                    @csrf
                                                    <button type="button" class="btn btn-danger rejectBtn mb-2"
                                                        value="{{ $req->id }}">Tolak</button>
                                                    <button type="submit" class="btn btn-success approveBtn"
                                                        value="{{ $req->id }}">Setuju</button>
                                                </form>
                                            @elseif($req->status == 'on use')
                                                {{--                                        DONE: ini tampilin receiptnya --}}
                                                <form action="{{ route('unduh') }}" target="_blank" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary" name="request_id"
                                                        value="{{ $req->id }}"><span
                                                            class="material-symbols-outlined">file_unduh</span></button>
                                                </form>
                                            @elseif($req->status == 'approved' || $req->status == 'approved sebagian')
                                                <form action="{{ route('takenBooking') }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary"
                                                        name="request_taken_id" value="{{ $req->id }}">Barang
                                                        sudah
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
