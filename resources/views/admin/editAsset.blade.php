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
                        <button type="button" class="text-white text-gray-900 bg-gray-500 border border-gray-500 focus:outline-none hover:bg-gray-300 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Hapus</button>
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

                        <form method="POST" action="{{ url('perbaharui-asset/' . $data->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label for="serial_number"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Kode Barang') }}</label>

                                <div class="col-md-6">
                                    <input id="serial_number" type="text"
                                        class="form-control @error('serial_number') is-invalid @enderror"
                                        name="serial_number" value="{{ $data->serial_number }}" required
                                        autocomplete="serial_number" autofocus>

                                    @error('serial_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="asset_jenis"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Jenis Barang') }}</label>

                                <div class="col-md-6">
                                    <select class="form-select" name="asset_jenis" id="asset_jenis">
                                        @foreach ($show as $index => $item)
                                            @if ($data->asset_jenis_id == $item->id)
                                                <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                            @else
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="kategori_barang"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Kategori Barang') }}</label>

                                <div class="col-md-6">
                                    <input id="kategori_barang" type="text"
                                        class="form-control @error('kategori_barang') is-invalid @enderror" name="kategori_barang"
                                        value="{{ $data->kategori_barang }}" required autocomplete="kategori_barang" autofocus>

                                    @error('brand')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                                    class="col-md-4 col-form-label text-md-end">{{ __('Brand') }}</label>

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
                                <label for="spesifikasi_barang"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Spesifikasi Barang') }}</label>

                                <div class="col-md-6">
                                    <input id="spesifikasi_barang" type="text"
                                        class="form-control @error('spesifikasi_barang') is-invalid @enderror" name="spesifikasi_barang"
                                        value="{{ $data->spesifikasi_barang }}" required autocomplete="spesifikasi_barang" autofocus>

                                    @error('spesifikasi_barang')
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
                                        <button type="button" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 deleteAssetBtn"
                                            value="{{ $data->id }}">
                                            Hapus Barang
                                        </button>
                                    @endif
                                    <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                        {{ __('perbaharui Data') }}
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
