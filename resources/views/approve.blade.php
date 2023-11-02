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
                    <div class="relative overflow-x-auto">
                        <table class="display table w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">No</th>
                                    <th class="px-6 py-3">Kode Barang</th>
                                    <th class="px-6 py-3">Jenis Barang</th>
                                    <th class="px-6 py-3">Kategori Barang</th>
                                    <th class="px-6 py-3">Brand</th>
                                    <th class="px-6 py-3">Spesifikasi Barang</th>
                                    <th class="px-6 py-3">Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($bookings)
                                    @foreach ($bookings as $index => $item)
                                        <tr>
                                            <td class="px-6 py-3" scope="row">{{ $index + 1 }}</td>
                                            <td>{{ $item->serial_number }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->kategori_barang }}</td>
                                            <td>{{ $item->brand }}</td>
                                            <td>{{ $item->spesifikasi_barang }}</td>
                                            <td>{{ $item->status == 'tidak' ? 'tersedia' : $item->status }}</td>
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
                </div>
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
                    <button type="submit" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Ya</button>
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