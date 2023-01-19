@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script defer src="{{ asset('js/datatable.js')}}"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script defer>
        $(document).ready(function (){
            $('.perbaikiBtn').click(function (e){
                e.preventDefault();
                var repair_id = $(this).val();
                $('#repair_id').val(repair_id);
                $('#exampleModal').modal('show');
            });
        });
    </script>
@endsection

@section('content')


    {{--    update perbaikan (pic, repaired by, fixed boolean)--}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('updateRepairAsset') }}">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Aset Diperbaiki</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">

                            <label for="pic" class="col-form-label">{{ __('PIC reparasi') }}</label>
                            <input type="text" class="form-control" id="pic" name="pic" autocomplete="pic" autofocus>

                        </div>
                        <div class="mb-3">

                            <label for="repaired-by" class="col-form-label">{{ __('Diperbaiki oleh') }}</label>
                            <input type="text" class="form-control" id="repaired-by" name="repaired-by" autocomplete="repaired-by" autofocus>
                            <input type="hidden" name="repair_id" id="repair_id">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if($fixed)
                    <a class="btn btn-small btn-success mb-3" href="{{ url('admin/createRepairAsset/' . $asset) }}">Lapor Kerusakan</a>
                @endif

                <div class="card">
                    <div class="card-header">{{ __('Riwayat Reparasi Aset') }}</div>

                    <div class="card-body">

                        @if(session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <table id="myTable" class="table">
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Description</th>
                                <th scope="col">Pelapor</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $index => $item)
                                <tr>
                                    {{--                masukin kolom--}}
                                    <td scope="row">{{$index+1}}</td>
                                    <td>{{date("l, d M Y", $item->create_at)}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>{{$item->reported_by}}</td>
                                    <td>
                                        @if(!$item->flag_fixed)
                                            <button type="button" class="btn btn-small btn-success mb-3 perbaikiBtn" value="{{ $item->id }}" >Sudah diperbaiki</button>
                                        @else
                                            Sudah diperbaiki pada tanggal: {{date("l, d M Y", $item->update_at)}}
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
