@extends('layouts.app')

@section('css')
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script defer>
        $(document).ready(function() {
            $('.deleteUserBtn').click(function(e) {
                e.preventDefault();
                var user_id = $(this).val();
                $('#user_id').val(user_id);
                $('#deleteModal').modal('show');
            });

            $('.ResetPassBtn').click(function(e) {
                e.preventDefault();
                var user_id = $(this).val();
                $('#user_reset_id').val(user_id);
                $('#resetModal').modal('show');
            });
        });
    </script>
@endsection

@section('content')
    {{-- <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ url('delete-user') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="user_delete_id" id="user_id">
                        <h5>Apakah anda yakin ingin menghapus user?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="text-white text-gray-900 bg-gray-500 border border-gray-500 focus:outline-none hover:bg-gray-300 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Hapus</button>
                    </div>
                </form>

            </div>
        </div>
    </div> --}}

    <!-- <div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ url('reset-password') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Reset Password User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="user_reset_id" id="user_reset_id">
                        <h5>Apakah anda yakin ingin me-reset password user?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="text-white text-gray-900 bg-gray-500 border border-gray-500 focus:outline-none hover:bg-gray-300 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Ya</button>
                    </div>
                </form>

            </div>
        </div>
    </div> -->

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Edit Role User') }}
                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ url('perbaharui-user/' . $data->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Nama') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ $data->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="binusianid"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Binusian ID') }}</label>

                                <div class="col-md-6">
                                    <input id="binusianid" type="text"
                                        class="form-control @error('binusianid') is-invalid @enderror" name="binusianid"
                                        value="{{ $data->binusianid }}" required autocomplete="binusianid" autofocus
                                    >

                                    @error('binusianid')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $data->email }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone"
                                    class="col-md-4 col-form-label text-md-end">{{ __('No HP') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ $data->phone }}" required autocomplete="phone" autofocus>

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="department"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Departemen') }}</label>

                                <div class="col-md-6">
                                    <select class="form-select" name="department" id="department">
                                        @foreach ($dept as $index => $item)
                                            @if ($data->division_id == $item->id)
                                                <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                            @else
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="form-group row">
                                    <label for="role_id" class="col-md-4 col-form-label text-md-end">{{ __('Role Anda') }}</label>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input mt-2" name="role[]" type="checkbox" id="isStaff" name="isStaff" value="1" {{ $isStaff ? 'checked' : '' }}>
                                            <label class="form-check-label mt-2" for="isStaff">Staff</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input mt-2" name="role[]" type="checkbox" id="isAdmin" name="isAdmin" value="2" {{ $isAdmin ? 'checked' : '' }}>
                                            <label class="form-check-label mt-2" for="isAdmin">Admin</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input mt-2" name="role[]" type="checkbox" id="isApprover" name="isApprover" value="3" {{ $isApprover ? 'checked' : '' }}>
                                            <label class="form-check-label mt-2" for="isApprover">Approver</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">

                                    <!-- <button type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 ResetPassBtn"
                                        value="{{ $data->id }}">Reset Password</button> -->

                                    <!-- <button type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 deleteUserBtn"
                                        value="{{ $data->id }}">Hapus User</button>  -->

                                    <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                        {{ __('perbaharui Data') }}
                                    </button>
                                </div>
                                <!-- <div class="col-md-6 offset-md-4">Format password default : B1nu$-[Binusian ID]</div> -->
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
