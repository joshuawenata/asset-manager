@extends('layouts.app')

@section('js')

@endsection

@section('css')

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



                        <form method="POST" action="{{ route('createRequest') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="datetimes" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Peminjaman') }}</label>

                                <div class="col-md-6">
                                    <input id="datetimes" type="text" class="form-control" name="datetimes" required autofocus>

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

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Lihat') }}
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
