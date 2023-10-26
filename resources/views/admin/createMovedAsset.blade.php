@extends('layouts.app')

@section('js')
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
                    <div class="card-header">{{ __('Pindah Barang') }}</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('storePemindahan') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="responsible"
                                    class="col-form-label text-md-end"><b>{{ __('Dipindahkan oleh: ') }}</b></label>

                                <div>
                                    <div class="col-sm-5 col-md-6">
                                        <input type="text" class="form-control mt-2" required id="responsible"
                                            name="responsible" />
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="to_location"
                                    class="col-form-label text-md-end"><b>{{ __('Dipindahkan ke: ') }}</b></label>

                                <div>
                                    <select class="form-select" name="to_location" id="to_location">
                                        @foreach ($data as $index => $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{--                            keterangan barang saat dipindahkan --}}
                            <div class="mb-3">
                                <label for="notes" class="col-form-label"><b>Catatan Pemindahan: </b></label>
                                <textarea class="form-control" id="notes" name="notes" autofocus></textarea>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-0">
                                    <input type="hidden" name="assets" value="{{ serialize($assets) }}">

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
