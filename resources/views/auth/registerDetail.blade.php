@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Daftar') }}</div>

                    <div class="card-body">
                        <form method="POST" action="insert-account" onsubmit="tambah()">
                            @csrf

                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Nama') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{--                        customized filed --}}

                            {{--                        1. BINUSIAN ID --}}
                            <div class="row mb-3">
                                <label for="binusianid" class="col-md-4 col-form-label text-md-end">
                                    {{ __('Binusian ID') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="binusianid" type="text"
                                        class="form-control @error('binusianid') is-invalid @enderror" name="binusianid"
                                        value="{{ old('binusianid') }}" required autocomplete="binusianid" autofocus>

                                    @error('binusianid')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{--                        3. PHONE NUMBER --}}
                            <div class="row mb-3">
                                <label for="phone"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Nomor HP') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{--                        4. PRODI (Dropdown) --}}
                            <div class="row mb-3">
                                <label for="division_id"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Prodi/Divisi') }}</label>

                                <div class="col-md-6">
                                    <select class="form-select" name="division_id" id="division_id">
                                        @foreach ($data as $index => $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{--                        end of customized field --}}

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                                <div class="col-md-6 input-group">
                                    <input id="email" type="text" class="form-control" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">@binus.edu</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Konfirmasi Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">

                                    <input type="hidden" id="role_id" name="role_id" value="{{ $role_id }}">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Daftar') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var elem = document.getElementById('email');
            elem.value = "";
        });

        function tambah() {
            var elem = document.getElementById('email');
            var old = elem.value;
            var tambahan = document.getElementById('basic-addon2');
            elem.value = old + tambahan.innerHTML;
        }
    </script>
@endsection
