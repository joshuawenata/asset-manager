@extends('layouts.app')

@section('js')
    <script defer src="{{ asset('js/datatable.js') }}"></script>
    <script defer src="{{ asset('js/newassetJenis.js') }}"></script>
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
                    <div class="card-header">{{ __('Pinjam Barang') }}</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('approver.confirmRequest') }}" id="checkGroup">
                            @csrf

                            <div class="mb-3">
                                <label for="binusianid_peminjam"
                                    class="col-form-label text-md-end">{{ __('Binusian ID Peminjam') }}</label>

                                <div>
                                    <input id="binusian_id_peminjam" type="text" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 "
                                        name="binusian_id_peminjam" required>
                                </div>

                                <label for="nama_peminjam"
                                    class="col-form-label text-md-end">{{ __('Nama Peminjam') }}</label>

                                <div>
                                    <input id="nama_peminjam" type="text" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 " name="nama_peminjam"
                                        required>
                                </div>

                                <label for="prodi_peminjam"
                                    class="col-form-label text-md-end">{{ __('Prodi/Unit Peminjam') }}</label>

                                <div>
                                    <input id="prodi_peminjam" type="text" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 " name="prodi_peminjam"
                                        required>
                                </div>

                                <label for="email_peminjam"
                                    class="col-form-label text-md-end">{{ __('Email Peminjam') }}</label>

                                <div>
                                    <input id="email_peminjam" type="text" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 " name="email_peminjam"
                                        required>
                                </div>

                                <label for="nohp_peminjam"
                                    class="col-form-label text-md-end">{{ __('No. Handphone Peminjam') }}</label>

                                <div>
                                    <input id="nohp_peminjam" type="text" class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 " name="nohp_peminjam"
                                        required>
                                </div>

                                <input type="hidden" name="approver" id="approver"
                                    value="{{ \Illuminate\Support\Facades\Auth::user()->id }}|{{ \Illuminate\Support\Facades\Auth::user()->name }}|{{ \Illuminate\Support\Facades\Auth::user()->division_id }}" />
                            </div>

                            <div class="mb-3">
                                <label for="purpose"
                                    class="col-form-label text-md-end">{{ __('Tujuan Peminjaman') }}</label>

                                <div>
                                    <textarea class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 " id="purpose" name="purpose" required autofocus></textarea>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="col-form-label text-md-end">{{ __('Lokasi Peminjaman') }}</label>

                                <div>
                                    <input class="form-check-input mt-1" type="radio" id="hide" name="lokasi" value="{{ 'keluar kampus BINUS' }}" checked />
                                    <label for="hide">keluar kampus BINUS</label>

                                    <div class="mt-2">
                                        <input class="form-check-input mt-1" type="radio" id="show" name="lokasi" value="" />
                                        <label for="show">dalam lingkungan kampus BINUS</label>
                                    </div>

                                    <div class="col-sm-5 col-md-6">
                                        <select class="form-input w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400  mt-2" name="new-lokasi" id="new-lokasi">
                                            @foreach ($data as $index => $item)
                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p>**abaikan lokasi ruangan apabila keluar kampus**</p>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-0">
                                    <input type="hidden" name="return_date" value="{{ $return_date }}">
                                    <input type="hidden" name="book_date" value="{{ $book_date }}">
                                    <input type="hidden" name="assets" value="{{ serialize($assets) }}">
                                    <input type="hidden" name="division_id" value="{{ $division_id }}">

                                    <button type="submit" name="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                        {{ __('Next') }}
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
