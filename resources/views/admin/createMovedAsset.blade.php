@extends('layouts.app')

@section('js')

@endsection

@section('css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('Pindah Aset') }}</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('storePemindahan') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="responsible" class="col-form-label text-md-end"><b>{{ __('Dipindahkan oleh: ') }}</b></label>

                                <div>
                                    <div class="col-sm-5 col-md-6">
                                        <input type="text" class="form-control mt-2" required id="responsible" name="responsible" />
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="to_location" class="col-form-label text-md-end"><b>{{ __('Dipindahkan ke: ') }}</b></label>

                                <div>
                                    <div class="col-sm-5 col-md-6">
                                        <input type="text" class="form-control mt-2" required id="to_location" name="to_location" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-0">
                                    <input type="hidden" name="assets" value="{{serialize($assets)}}">

                                    <button type="submit" name="submit" class="btn btn-primary">
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
