@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Daftar') }}</div>

                    <div class="card-body">
                        <form method="GET" action="register-show">
                            @csrf

                            {{--                        4. Role (Dropdown) --}}
                            <div class="row mb-3">
                                <label for="role_id"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Role Anda') }}</label>

                                <div class="col-md-6">
                                    <select class="form-select" name="role_id" id="role_id">
                                        <option value="2">Staff/Karyawan</option>
                                        <option value="3">Admin</option>
                                        <option value="4">Approver</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Selanjutnya') }}
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
