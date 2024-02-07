@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script defer src="{{ asset('js/datatable7.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('dashboard Super Admin') }}</div>

                    <div class="card-body">

                        @if (session('message'))
                            <div id="alert-border-1" class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
                                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                </svg>
                                <div class="ml-3 text-sm font-medium">
                                    {{ session('message') }}
                                </div>
                                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-border-1" aria-label="Close">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                </button>
                            </div>
                        @endif

                        <table id="myTable7" class="display table w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
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
