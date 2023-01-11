@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script defer>
        $(document).ready(function (){
            $('.deleteAssetBtn').click(function (e){
                e.preventDefault();
                var asset_id = $(this).val();
                $('#asset_id').val(asset_id);
                $('#deleteModal').modal('show');
            });
        });
    </script>
@endsection

@section('content')
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ url('deleteAsset') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Aset</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="asset_delete_id" id="asset_id">
                        <h5>Apakah anda yakin ingin menghapus aset?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Edit Data Aset') }}
                    </div>

                    <div class="card-body">



                        <form method="POST" action="{{ url('updateAsset/' . $data->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label for="serialnumber" class="col-md-4 col-form-label text-md-end">{{ __('Nomor Seri') }}</label>

                                <div class="col-md-6">
                                    <input id="serialnumber" type="text" class="form-control @error('serialnumber') is-invalid @enderror" name="serialnumber" value="{{ $data->serial_number }}" required autocomplete="serialnumber" autofocus>

                                    @error('serialnumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="asset_category" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Aset') }}</label>

                                <div class="col-md-6">
                                    <select class="form-select" name="asset_category" id="asset_category">
                                        @foreach($show as $index => $item)
                                            @if($data->asset_category_id == $item->id)
                                                <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                            @else
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="asset-status" class="col-md-4 col-form-label text-md-end">{{ __('Status Aset') }}</label>

                                <div class="col-md-6">
                                    <select class="form-select" name="asset-status" id="asset-status">
                                        @if($data->status == 'tersedia')
                                            <option value="tersedia" selected>Tersedia di penyimpanan</option>
                                            <option value="tidak tersedia">Tidak tersedia/rusak</option>
                                            <option value="dalam perbaikan">Dalam perbaikan</option>
                                        @elseif($data->status == 'tidak tersedia')
                                            <option value="tersedia">Tersedia di penyimpanan</option>
                                            <option value="tidak tersedia" selected>Tidak tersedia/rusak</option>
                                            <option value="dalam perbaikan">Dalam perbaikan</option>
                                        @elseif($data->status == 'dalam perbaikan')
                                            <option value="tersedia">Tersedia di penyimpanan</option>
                                            <option value="tidak tersedia">Tidak tersedia/rusak</option>
                                            <option value="dalam perbaikan" selected>Dalam perbaikan</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="location" class="col-md-4 col-form-label text-md-end">{{ __('Lokasi Penyimpanan') }}</label>

                                <div class="col-md-6">
                                    <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ $data->assigned_location }}" required autocomplete="location" autofocus>

                                    @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="brand" class="col-md-4 col-form-label text-md-end">{{ __('Merek') }}</label>

                                <div class="col-md-6">
                                    <input id="brand" type="text" class="form-control @error('brand') is-invalid @enderror" name="brand" value="{{ $data->brand }}" required autocomplete="brand" autofocus>

                                    @error('brand')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="button" class="btn btn-danger deleteAssetBtn" value="{{ $data->id }}"><span class="material-symbols-outlined">delete</span>Hapus Aset</button>

                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Perbarui Data') }}
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
