@extends('layouts.app')

@section('js')
    <script defer src="{{ asset('js/datatable.js')}}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('Pinjam Aset') }}</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('createRequestDetail') }}" id="checkGroup">
                            @csrf

                            <table id="myTable" class="table">
                                <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nomor Seri</th>
                                    <th scope="col">Jenis</th>
                                    <th scope="col">Merek</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($assets as $index => $item)
                                    <tr>
                                        {{--                masukin kolom--}}
                                        <th scope="row">{{$index+1}}</th>
                                        <td>{{$item->serial_number}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->brand}}</td>
                                        <td>
                                            <input class="form-check-input mt-0 required_group" type="checkbox" value="{{$item->id}}" name="assets[]">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-0">
                                    <input type="hidden" name="return_date" value="{{$return_date }}">
                                    <input type="hidden" name="book_date" value="{{$book_date }}">

                                    @if($assets)
                                        <button type="submit" name="submit" class="btn btn-primary">
                                            {{ __('Next') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateGroup(){
            let things = document.querySelectorAll('.required_group');
            let checked = 0;
            for(let thing of things){
                thing.checked && checked++;
            }
            if(checked){
                things[things.length - 1].setCustomValidity("");
                document.getElementById('checkGroup').submit();
            }
            else{
                things[things.length - 1].setCustomValidity("Please check at least one item");
                things[things.length - 1].reportValidity();
            }
        }

        document.querySelector('[name=submit]').addEventListener('click', () => {
            validateGroup();
        });
    </script>
@endsection
