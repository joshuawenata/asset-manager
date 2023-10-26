@extends('layouts.app')

@section('js')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@endsection

@section('css')
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Pinjam Aset') }}
                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('approver.createRequest') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="datetimes"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Peminjaman') }}</label>

                                <div class="col-md-6">
                                    <input id="datetimes" type="text" class="form-control" name="datetimes" required
                                        autofocus>

                                    <script>
                                        $(function() {
                                            $('input[name="datetimes"]').daterangepicker({
                                                timePicker: true,
                                                startDate: moment().startOf('hour'),
                                                minDate: moment().startOf('hour'),
                                                endDate: moment().startOf('hour').add(32, 'hour'),
                                                timePicker24Hour: true,
                                                locale: {
                                                    format: 'DD MMM YYYY HH:mm'
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="division_id"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Divisi Barang') }}</label>

                                    <div class="col-md-6">
                                        @if ($data)
                                            <select class="form-select" name="division_id" id="division_id">
                                                @foreach ($data as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>

                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="hidden" name="division_id"
                                        value="{{ \Illuminate\Support\Facades\Auth::user()->division->id }}">
                                    <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                        {{ __('Lanjut') }}
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
