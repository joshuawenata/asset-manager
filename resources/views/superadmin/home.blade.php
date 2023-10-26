@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script defer src="{{ asset('js/datatable.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('dashboard Super Admin') }}</div>

                    <div class="card-body">

                        @if (session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <table id="myTable" class="display table w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3" scope="col">No</th>
                                    <th class="px-6 py-3" scope="col">Nama</th>
                                    <th class="px-6 py-3" scope="col">Binusian ID</th>
                                    <th class="px-6 py-3" scope="col">Email</th>
                                    <th class="px-6 py-3" scope="col">No. HP</th>
                                    <th class="px-6 py-3" scope="col">Departemen</th>
                                    <th class="px-6 py-3" scope="col">Role</th>
                                    <th class="px-6 py-3" scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        {{--                                masukin kolom --}}
                                        <td class="px-6 py-3" scope="row">{{ $index + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->binusianid }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->division->name }}</td>
                                        <td>{{ $item->role->name }}</td>
                                        <td>
                                            {{--                                        DONE: tambahin delete button disini direct ke edit usernya --}}
                                            <a class="btn btn-small btn-info"
                                                href="{{ URL::to('edit-user/' . $item->id) }}"><span
                                                    class="material-symbols-outlined">edit_square</span></a>
                                            {{-- <a class="btn btn-small btn-danger"
                                                href="{{ URL::to('edit-user/' . $item->id) }}"><span
                                                    class="material-symbols-outlined">delete</span></a> --}}
                                            @if ($item->active_status == 1)
                                                <a class="btn btn-small btn-success"
                                                    href="{{ URL::to('edit-user-active-status/' . $item->id) }}">
                                                    <span class="material-symbols-outlined">check_circle</span>
                                                </a>
                                            @else
                                                <a class="btn btn-small btn-danger"
                                                    href="{{ URL::to('edit-user-active-status/' . $item->id) }}">
                                                    <span class="material-symbols-outlined">cancel</span>
                                                </a>
                                            @endif
                                            @if ($item->role->name == 'staff')
                                                <a class="btn btn-small btn-warning"
                                                    href="{{ URL::to('superadmin/history-akun-staff/' . $item->id) }}">
                                                    <span class="material-symbols-outlined">history</span></a>
                                            @elseif ($item->role->name == 'admin')
                                                <a class="btn btn-small btn-warning"
                                                    href="{{ URL::to('superadmin/history-akun-admin/' . $item->id) }}">
                                                    <span class="material-symbols-outlined">history</span></a>
                                            @elseif ($item->role->name == 'approver')
                                                <a class="btn btn-small btn-warning"
                                                    href="{{ URL::to('superadmin/history-akun-approver/' . $item->id) }}">
                                                    <span class="material-symbols-outlined">history</span></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
