@extends('layouts.app')

@section('js')
    <script defer src="{{ asset('js/datatable.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('Silahkan cek peminjaman Anda!') }}</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('approver.storeRequest') }}">
                            @csrf

                            <table id="myTable" class="display table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nomor Seri</th>
                                        <th scope="col">Jenis</th>
                                        <th scope="col">Spesifikasi</th>
                                        @if (\Illuminate\Support\Facades\Auth::user()->role->name == 'staff')
                                            <th scope="col">Milik</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assets as $index => $item)
                                        <tr>
                                            {{--                masukin kolom --}}
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $item->serial_number }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->brand }}</td>
                                            @if (\Illuminate\Support\Facades\Auth::user()->role->name == 'staff')
                                                <td>{{ \App\Models\Division::getName($item->division_id) }}</td>
                                            @endif
                                            <input type="hidden" name="assets[]" value="{{ $item->id }}">
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mb-3">
                                <label for="binusian_id_peminjam"
                                    class="col-sm-5 col-md-6"><b>{{ __('Binusian ID Peminjam') }}</b></label>
                                <div class="col-sm-5 col-md-6"><input type="text" class="form-control mt-2" readonly
                                        name="binusian_id_peminjam" value="{{ $binusian_id_peminjam }}" />
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="row">
                                    <label for="nama_peminjam"
                                        class="col-sm-5 col-md-6"><b>{{ __('Nama Peminjam') }}</b></label>
                                    <label for="nohp_peminjam"
                                        class="col-sm-5 col-md-6"><b>{{ __('No. Handphone Peminjam') }}</b></label>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5 col-md-6"><input type="text" class="form-control mt-2" readonly
                                            name="nama_peminjam" value="{{ $nama_peminjam }}" />
                                    </div>
                                    <div class="col-sm-5 col-md-6"><input type="text" class="form-control mt-2" readonly
                                            name="nohp_peminjam" value="{{ $nohp_peminjam }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="row">
                                    <label for="prodi_peminjam"
                                        class="col-sm-5 col-md-6"><b>{{ __('Prodi/Unit Peminjam') }}</b></label>
                                    <label for="email_peminjam"
                                        class="col-sm-5 col-md-6"><b>{{ __('Email Peminjam') }}</b></label>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5 col-md-6"><input type="text" class="form-control mt-2" readonly
                                            name="prodi_peminjam" value="{{ $prodi_peminjam }}" />
                                    </div>
                                    <div class="col-sm-5 col-md-6"><input type="text" class="form-control mt-2" readonly
                                            name="email_peminjam" value="{{ $email_peminjam }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="purpose"
                                    class="col-form-label text-md-end"><b>{{ __('Tujuan Peminjaman') }}</b></label>

                                <div>
                                    <textarea class="form-control" id="purpose" name="purpose" required readonly>{{ $purpose }}</textarea>
                                </div>
                            </div>

                            {{--                            lokasi --}}
                            <div class="mb-3">
                                <div class="row">
                                    <label for="lokasi"
                                        class="col-sm-5 col-md-6"><b>{{ __('Lokasi Peminjaman') }}</b></label>
                                    <label for="approver"
                                        class="col-sm-5 col-md-6"><b>{{ __('Approver Peminjaman') }}</b></label>
                                </div>

                                <div class="row">
                                    <div class="col-sm-5 col-md-6"><input type="text" class="form-control mt-2" readonly
                                            name="lokasi" value="{{ $lokasi }}" /></div>
                                    <div class="col-sm-5 col-md-6"><input type="text" class="form-control mt-2" readonly
                                            name="approver" value="{{ $approver }}" /></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-sm-5 col-md-6"><label
                                            class="col-form-label text-md-end"><b>{{ __('Tanggal Pinjam') }}</b></label>
                                    </div>
                                    <div class="col-sm-5 col-md-6"><label
                                            class="col-form-label text-md-end"><b>{{ __('Tanggal Kembali') }}</b></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5 col-md-6"><input type="text" class="form-control mt-2" readonly
                                            name="book_date" value="{{ date('l, d M Y H:i', $book_date) }}" /></div>
                                    <div class="col-sm-5 col-md-6"><input type="text" class="form-control mt-2"
                                            readonly name="return_date"
                                            value="{{ date('l, d M Y H:i', $return_date) }}" /></div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-0">
                                    <input type="hidden" name="division_id" value="{{ $division_id }}">
                                    <input type="hidden" name="binusian_id_peminjam"
                                        value="{{ $binusian_id_peminjam }}">
                                    <input type="hidden" name="approver" value="{{ $approver }}">
                                    <input type="hidden" name="approver_division_id"
                                        value="{{ $approver_division_id }}">
                                    <input type="hidden" name="nama_peminjam" value="{{ $nama_peminjam }}">
                                    <input type="hidden" name="prodi_peminjam" value="{{ $prodi_peminjam }}">
                                    <input type="hidden" name="email_peminjam" value="{{ $email_peminjam }}">
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
