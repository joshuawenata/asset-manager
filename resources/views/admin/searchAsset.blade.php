@extends('layouts.app')

@section('js')
    <script defer src="{{ asset('js/datatable.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if ($mode == 'current')
                    <a title="Penambahan Barang" class="btn btn-outline-success mb-3"
                        href="{{ route('admin.createAsset') }}"><span style="display: flex"
                            class="material-symbols-outlined">add</span></a>
                @endif

                <div class="card">
                    <div class="card-header">{{ __('Kelola Barang') }}</div>

                    <div class="card-body">

                        @if (session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif

                        <table class="display nowrap table" id="myTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kode Barang</th>
                                    <th scope="col">Kategori Barang</th>
                                    <th scope="col">Spesifikasi</th>
                                    @if ($mode == 'current')
                                        <th scope="col">Lokasi</th>
                                    @endif
                                    <th scope="col">Pemilik Barang</th>
                                    @if ($mode == 'current')
                                        <th scope="col">Status</th>
                                        <th scope="col">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        {{--                masukin kolom --}}
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $item->serial_number }}</td>
                                        <td>{{ $item->assetCategory->name }}</td>
                                        <td>{{ $item->brand }}</td>
                                        @if ($mode == 'current')
                                            <td>{{ $item->current_location }}</td>
                                        @endif
                                        <td>{{ $item->pemilik_barang }}</td>
                                        @if ($mode == 'current')
                                            @if ($item->status == 'dipinjam')
                                                <td>{{ $item->status . ' oleh ' . $item->getNamaPeminjam($item->id) }}</td>
                                            @else
                                                <td>{{ $item->status }}</td>
                                            @endif

                                            <td>
                                                <a title="edit barang" class="btn btn-small btn-info"
                                                    href="{{ URL::to('/edit-asset/' . $item->id) }}"><span
                                                        class="material-symbols-outlined">edit_square</span></a>
                                                {{--                                        <form action="{{ url('deleteAsset/' . $item->id) }}" method="post"> --}}
                                                {{--                                            <button class="btn btn-small btn-info" type="submit"><span class="material-symbols-outlined">delete</span></button> --}}
                                                {{--                                            <input type="hidden" name="_method" value="delete" /> --}}
                                                {{--                                            <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
                                                {{--                                        </form> --}}
                                                @if ($item->status != 'dipinjam')
                                                    <a title="hapus barang" class="btn btn-small btn-danger"
                                                        href="{{ URL::to('/edit-asset/' . $item->id) }}"><span
                                                            class="material-symbols-outlined">delete</span></a>
                                                @endif
                                                <a title="barang rusak" class="btn btn-small btn-info"
                                                    href="{{ URL::to('/repair-asset-history/' . $item->id) }}"><span
                                                        class="material-symbols-outlined">build</span></a>
                                                <a title="riwayat pemindahan" class="btn btn-small btn-info"
                                                    href="{{ URL::to('/move-asset-history/' . $item->id) }}"><span
                                                        class="material-symbols-outlined">trolley</span></a>
                                            </td>
                                        @endif
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
