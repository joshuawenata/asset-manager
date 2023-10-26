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
                    <div class="card-header">{{ __('Pinjam Barang') }}</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('approver.createRequestDetail') }}" id="checkGroup">
                            @csrf

                            <table id="myTable" class="display table w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th class="px-6 py-3" scope="col">No</th>
                                        <th class="px-6 py-3" scope="col">Kode Barang</th>
                                        <th class="px-6 py-3" scope="col">Jenis Barang</th>
                                        <th class="px-6 py-3" scope="col">Kategori Barang</th>
                                        <th class="px-6 py-3" scope="col">Spesifikasi Barang</th>
                                        <th class="px-6 py-3" scope="col">Brand</th>
                                        @if (\Illuminate\Support\Facades\Auth::user()->role->name == 'staff')
                                            <th class="px-6 py-3" scope="col">Milik</th>
                                        @endif
                                        <th class="px-6 py-3" scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assets as $index => $item)
                                        <tr>
                                            <td class="px-6 py-3" scope="row">{{ $index + 1 }}</td>
                                            <td>{{ $item->serial_number }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->kategori_barang }}</td>
                                            <td>{{ $item->spesifikasi_barang }}</td>
                                            <td>{{ $item->brand }}</td>
                                            @if (\Illuminate\Support\Facades\Auth::user()->role->name == 'staff')
                                                <td>{{ \App\Http\Controllers\DivisionController::show($item->division_id) }}
                                                </td>
                                            @endif
                                            <td>
                                                <input class="form-check-input mt-0 required_group" type="checkbox"
                                                    value="{{ $item->id }}" name="assets[]">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-0">
                                    <input class="form-check-input mt-1 mb-3" type="checkbox" name="select-all"
                                        id="select-all">
                                    <label for="select-all">pilih semua</label>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-0">
                                    <input type="hidden" name="return_date" value="{{ $return_date }}">
                                    <input type="hidden" name="book_date" value="{{ $book_date }}">
                                    <input type="hidden" name="division_id" value="{{ $division_id }}">

                                    @if ($assets)
                                        <button type="submit" name="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                            {{ __('Next') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateGroup() {
            let things = document.querySelectorAll('.required_group');
            let checked = 0;
            for (let thing of things) {
                thing.checked && checked++;
            }
            if (checked) {
                things[things.length - 1].setCustomValidity("");
                document.getElementById('checkGroup').submit();
            } else {
                things[things.length - 1].setCustomValidity("Please check at least one item");
                things[things.length - 1].reportValidity();
            }
        }

        document.querySelector('[name=submit]').addEventListener('click', () => {
            validateGroup();
        });
    </script>

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
