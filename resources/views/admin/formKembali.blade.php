{{-- {{ dd($assets, $request) }} --}}
@extends('layouts.app')

@section('css')
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script defer>
        $(document).ready(function() {

            $('.approveBtn').click(function(e) {
                e.preventDefault();
                var request_id = $(this).val();
                $('#request_id2').val(request_id);

                if ($('#isu_kerusakan').is(":checked")) {
                    var isu_rusak = $('input[name=isu_kerusakan]').val();
                    $('#isu_rusak').val(isu_rusak);
                }

                $('#approveModal').modal('show');
            });
        });
    </script>
@endsection

@section('content')
    {{--    modal approve: kalo di approve perbaharui realize_return_date di bookings, aset status jadi tersedia --}}
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('approve-return') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Approve Pengembalian</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="request_return_id" id="request_id2">
                        <input type="hidden" name="isu_rusak" id="isu_rusak">
                        <h5>Apakah anda yakin ingin meng-approve request pengembalian?</h5>

                        <div class="mb-3">
                            <label for="pesan" class="col-form-label">Pesan:</label>
                            <textarea class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 " id="pesan" name="pesan" autofocus required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="text-gray-900 bg-gray-500 border border-gray-500 focus:outline-none hover:bg-gray-300 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Ya</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Konfirmasi Pengembalian') }}
                    </div>

                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="req_id"
                                class="col-md-4 col-form-label text-md-end">{{ __('Pinjaman nomor') }}</label>

                            <div class="col-md-6">
                                <input id="req_id" type="text" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400  mt-2" name="req_id"
                                    value="{{ $request->id }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="peminjam" class="col-md-4 col-form-label text-md-end">{{ __('Peminjam') }}</label>

                            <div class="col-md-6">
                                <input id="peminjam" type="text" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400  mt-2" name="peminjam"
                                    value="{{ $request->User->name }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="binusianid"
                                class="col-md-4 col-form-label text-md-end">{{ __('Binusian ID') }}</label>

                            <div class="col-md-6">
                                <input id="binusianid" type="text" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400  mt-2" name="binusianid"
                                    value="{{ $request->User->binusianid }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Periode Peminjaman') }}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400  mt-2"
                                    value="{{ date('l, d M Y H:i', strtotime($request->book_date)) . ' - ' . date('l, d M Y H:i', strtotime($request->return_date)) }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="realize_return_date"
                                class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Pengembalian') }}</label>

                            <div class="col-md-6">
                                <input id="realize_return_date" type="text" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400  mt-2"
                                    name="realize_return_date"
                                    value="{{ date('l, d M Y H:i', strtotime($request->realize_return_date)) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="purpose"
                                class="col-form-label text-md-end"><b>{{ __('Tujuan Peminjaman') }}</b></label>

                            <div>
                                <textarea class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 " id="purpose" name="purpose" required readonly>{{ $request->purpose }}</textarea>
                            </div>
                        </div>


                        <div class="mb-3">
                            <label class="col-form-label text-md-end">{{ __('Barang yang dikembalikan') }}</label>

                            <div class="md-6">
                                <div class="relative overflow-x-auto">
                                    <table class="display table w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th class="px-6 py-3">No</th>
                                                <th class="px-6 py-3">Nomor Seri</th>
                                                <th class="px-6 py-3">Jenis</th>
                                                <th class="px-6 py-3">Spesifikasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($assets as $index => $item)
                                                <tr>
                                                    <td class="px-6 py-3" scope="row">{{ $index + 1 }}</td>
                                                    <td>{{ $item->serial_number }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->brand }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="return_status"
                                class="col-md-4 col-form-label text-md-end">{{ __('Kondisi Barang') }}</label>

                            <div class="col-md-6">
                                <input id="return_status" type="text" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400  mt-2" name="return_status"
                                    value="{{ $request->return_status }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label text-md-end"><b>{{ __('Deskripsi Pengembalian') }}</b></label>

                            <div>
                                <textarea class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 " readonly>{{ $request->return_notes }}</textarea>
                            </div>
                        </div>

                        @if ($request->return_status == 'rusak')
                            <div class="mb-3">
                                <div>
                                    <input class="form-check-input mt-0" type="checkbox" value="isu_rusak"
                                        name="isu_kerusakan" id="isu_kerusakan">
                                    <label for="isu_kerusakan" class="text-md-end">Isu kerusakan barang akan dibahas lebih
                                        lanjut dengan BM [contact BM]</label>
                                </div>
                            </div>
                        @endif

                        <div class="mb-0">
                            <div class="md-6">
                                <button type="button" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 shadow-lg shadow-green-500/50 dark:shadow-lg dark:shadow-green-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 approveBtn"
                                    value="{{ $request->id }}">Setuju</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
