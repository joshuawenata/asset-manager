@extends('layouts.app')

@section('js')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script defer>
        $(document).ready(function() {

            if (window.location.href.indexOf('#see') != -1) {
                $('#see').modal('show');
            }

        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('content')

    {{--    modal divs --}}
    <div class="modal fade" id="see" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Divisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('createRequest') }}">
                    <div class="modal-body">
                        @csrf
                        @if (session('datetimes'))
                            <input type="hidden" name="datetimes" value="{{ session('datetimes') }}">
                        @else
                        @endif
                        @if (session('data'))
                            <select class="form-select" name="division_id" id="division_id">
                                @foreach (session('data') as $index => $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        @endif


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">OK</button>
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
                        {{ __('Pinjam Aset') }}
                    </div>

                    <div class="card-body">



                        <form method="POST" action="{{ route(\App\Models\User::getRolePage()) }}">
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

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="hidden" name="division_id"
                                        value="{{ \Illuminate\Support\Facades\Auth::user()->division->id }}">
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
