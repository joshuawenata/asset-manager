@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script defer src="{{ asset('js/datatable.js') }}"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@endsection

@section('content')
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('perbaharuiRequest') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Reject Request</h1>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="request_perbaharui_id" value="{{ $request_delete_id }}">
                    <input type="hidden" name="request_perbaharui" value="rejected">
                    <input type="hidden" name="user" value="approver">
                    <input type="hidden" name="approver_num"
                        value="{{ \Illuminate\Support\Facades\Auth::user()->division->approver }}">
                    <h5>Apakah anda yakin ingin me-reject request peminjaman?</h5>
                    <div class="mb-3">
                        <label for="pesan" class="col-form-label">Pesan:</label>
                        <textarea class="form-control" id="pesan" name="pesan" autofocus required>{{ '' }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Ya</button>
                </div>
            </form>

        </div>
    </div>
@endsection