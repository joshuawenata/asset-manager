{{--{{ dd($assets, $request) }}--}}
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script defer>
        $(document).ready(function (){
            $('.rejectBtn').click(function (e){
                e.preventDefault();
                var request_id = $(this).val();
                $('#request_id').val(request_id);
                $('#rejectModal').modal('show');
            });

            $('.approveBtn').click(function (e){
                e.preventDefault();
                var request_id = $(this).val();
                $('#request_id2').val(request_id);
                $('#approveModal').modal('show');
            });
        });
    </script>
@endsection

@section('content')

    {{--    modal reject: kalo di reject update flag_return = null realize_return_date = null return_notes = null--}}
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('rejectPengembalian') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Reject Pengembalian</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="request_return_id" id="request_id">
                        <h5>Apakah anda yakin ingin me-reject request pengembalian peminjam?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger">Ya</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{--    modal approve: kalo di approve update realize_return_date di bookings, aset status jadi tersedia--}}
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{route('approvePengembalian')}}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Approve Pengembalian</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="request_return_id" id="request_id2">
                        <h5>Apakah anda yakin ingin meng-approve request pengembalian?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-success">Ya</button>
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
                            <label for="req_id" class="col-md-4 col-form-label text-md-end">{{ __('Pinjaman nomor') }}</label>

                            <div class="col-md-6">
                                <input id="req_id" type="text" class="form-control mt-2" name="req_id" value="{{ $request->id }}" readonly>
                            </div>
                        </div>
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
                        <div class="row mb-3">
                            <label for="realize_return_date" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Pengembalian') }}</label>

                            <div class="col-md-6">
                                <input id="realize_return_date" type="text" class="form-control mt-2" name="realize_return_date" value="{{ date("l, d M Y H:i", strtotime($request->realize_return_date)) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="purpose" class="col-form-label text-md-end"><b>{{ __('Tujuan Peminjaman') }}</b></label>

                            <div>
                                <textarea class="form-control" id="purpose" name="purpose" required readonly>{{$request->purpose}}</textarea>
                            </div>
                        </div>


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
                                    @foreach($assets as $index => $item)
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

                        <div class="mb-0">
                            <div class="md-6">
                                <button type="button" class="btn btn-danger rejectBtn" value="{{ $request->id }}">Tolak</button>
                                <button type="button" class="btn btn-success approveBtn" value="{{ $request->id }}">Setuju</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
