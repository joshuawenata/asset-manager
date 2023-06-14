@extends('layouts.app')

@section('css')
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('js')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script defer>
        $(document).ready(function() {
            $('.deleteAssetBtn').click(function(e) {
                e.preventDefault();
                var asset_id = $(this).val();
                $('#asset_id').val(asset_id);
                $('#deleteModal').modal('show');
            });
        });
    </script>
    <script defer src="{{ asset('js/newpemilikbarang.js') }}"></script>
@endsection

@section('content')
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ url('delete-asset') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Barang</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="asset_delete_id" id="asset_id">
                        <h5>Apakah anda yakin ingin menghapus barang?</h5>
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
                        {{ __('Edit Data Barang') }}
                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ url('update-asset/' . $data->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label for="serialnumber"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Kode Barang') }}</label>

                                <div class="col-md-6">
                                    <input id="serialnumber" type="text"
                                        class="form-control @error('serialnumber') is-invalid @enderror" name="serialnumber"
                                        value="{{ $data->serial_number }}" required autocomplete="serialnumber" autofocus>

                                    @error('serialnumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="asset_category"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Kategori Barang') }}</label>

                                <div class="col-md-6">
                                    <select class="form-select" name="asset_category" id="asset_category">
                                        @foreach ($show as $index => $item)
                                            @if ($data->asset_category_id == $item->id)
                                                <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                            @else
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @if ($data->status != 'dipinjam' and $data->status != 'rusak')
                                <div class="row mb-3">
                                    <label for="asset-status"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Status Barang') }}</label>

                                    <div class="col-md-6">
                                        <select class="form-select" name="asset-status" id="asset-status">
                                            @if ($data->status == 'tersedia')
                                                <option value="tersedia" selected>Tersedia di penyimpanan</option>
                                                <option value="tidak tersedia">Tidak tersedia/unavailable</option>
                                            @elseif($data->status == 'tidak tersedia')
                                                <option value="tersedia">Tersedia di penyimpanan</option>
                                                <option value="tidak tersedia" selected>Tidak tersedia/unavailable</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="row mb-3">
                                <label for="brand"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Spesifikasi') }}</label>

                                <div class="col-md-6">
                                    <input id="brand" type="text"
                                        class="form-control @error('brand') is-invalid @enderror" name="brand"
                                        value="{{ $data->brand }}" required autocomplete="brand" autofocus>

                                    @error('brand')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="pemilik-barang"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Pemilik Barang') }}</label>

                                <div class="col-md-6">
                                    <select class="form-select @error('pemilik-barang') is-invalid @enderror"
                                        name="pemilik-barang" id="pemilik-barang" autofocus>
                                        @foreach ($pemilik as $index => $item)
                                            <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>

                                    @error('pemilik-barang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    @if ($data->status != 'dipinjam')
                                        <button type="button" class="btn btn-danger deleteAssetBtn"
                                            value="{{ $data->id }}">
                                            Hapus Barang
                                        </button>
                                    @endif
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
