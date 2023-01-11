@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script defer src="{{ asset('js/datatable.js')}}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <a class="btn btn-small btn-success mb-3" href="{{ route('readDivision') }}">Lihat Departemen</a>

                <div class="card">
                    <div class="card-header">{{ __('Dashboard Super Admin') }}</div>

                    <div class="card-body">



                        @if(session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <table id="myTable" class="table">
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Binusian ID</th>
                                <th scope="col">Email</th>
                                <th scope="col">No. HP</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Departemen</th>
                                <th scope="col">Role</th>
                                <th scope="col">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $index => $item)
                                <tr>
{{--                                masukin kolom--}}
                                    <th scope="row">{{$index+1}}</th>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->binusianid}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->phone}}</td>
                                    <td>{{$item->address}}</td>
                                    <td>{{$item->division->name}}</td>
                                    <td>{{$item->role->name}}</td>
                                    <td>
{{--                                        DONE: tambahin delete button disini direct ke edit usernya--}}
                                        <a class="btn btn-small btn-info" href="{{ URL::to('superadmin/editUser/' . $item->id) }}"><span class="material-symbols-outlined">edit_square</span></a>
                                        <a class="btn btn-small btn-danger" href="{{ URL::to('superadmin/editUser/' . $item->id) }}"><span class="material-symbols-outlined">delete</span></a>
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
