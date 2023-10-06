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
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <form action="{{ route('perbaharuiRequest', ['request_perbaharui_id' => $request_perbaharui_id]) }}" method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Approve Request</h1>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="request_perbaharui_id" value="{{ $request_perbaharui_id }}">
                    <input type="hidden" name="request_perbaharui" value="approved">
                    <input type="hidden" name="approver_num"
                        value="{{ \Illuminate\Support\Facades\Auth::user()->division->approver }}">
                    <h5>Apakah anda yakin ingin meng-approve request peminjaman?</h5>
                    <table class="display table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Jenis Barang</th>
                                <th>Kategori Barang</th>
                                <th>Brand</th>
                                <th>Spesifikasi Barang</th>
                                <th>Kondisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($bookings)
                                @foreach ($bookings as $index => $item)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $item->serial_number }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->kategori_barang }}</td>
                                        <td>{{ $item->brand }}</td>
                                        <td>{{ $item->spesifikasi_barang }}</td>
                                        <td>{{ $item->status == 'tidak tersedia' ? 'tersedia' : $item->status }}</td>
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
                            <textarea class="form-control" id="pesan" name="pesan" autofocus required></textarea>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Ya</button>
                </div>
            </form>

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