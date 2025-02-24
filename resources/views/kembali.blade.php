@extends('layouts.app')

@section('css')
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('Kembali Pinjaman') }}
                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('storeReturn') }}">
                            @csrf

                            @if ($returned)
                                <div class="row mb-3">
                                    <label for="peminjam"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Peminjam') }}</label>

                                    <div class="col-md-6">
                                        <input id="peminjam" type="text" class="form-control mt-2" name="peminjam"
                                            value="{{ $request->User->name }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="binusianid"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Binusian ID') }}</label>

                                    <div class="col-md-6">
                                        <input id="binusianid" type="text" class="form-control mt-2" name="binusianid"
                                            value="{{ $request->User->binusianid }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label
                                        class="col-md-4 col-form-label text-md-end">{{ __('Periode Peminjaman') }}</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control mt-2"
                                            value="{{ date('l, d M Y H:i', strtotime($request->book_date)) . ' - ' . date('l, d M Y H:i', strtotime($request->return_date)) }}"
                                            readonly>
                                    </div>
                                </div>
                            @endif

                            <div class="row mb-3">
                                <label for="realize_return_date"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Pengembalian') }}</label>

                                <div class="col-md-6">
                                    <input id="realize_return_date" type="text" class="form-control rounded-md"
                                        name="realize_return_date" value="{{ $current_date }}" readonly>
                                </div>
                            </div>

                            @if ($returned)
                                <div class="mb-3">
                                    <label for="purpose"
                                        class="col-form-label text-md-end"><b>{{ __('Tujuan Peminjaman') }}</b></label>

                                    <div>
                                        <textarea class="form-control" id="purpose" name="purpose" required readonly>{{ $request->purpose }}</textarea>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="col-form-label text-md-end">{{ __('Barang yang dikembalikan') }}</label>

                                <div class="md-6">
                                    <div class="relative overflow-x-auto">
                                        <table class="display table w-full text-sm text-left text-gray-500 dark:text-gray-400" width="100%">
                                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                <tr>
                                                    <th class="px-6 py-3">No</th>
                                                    <th class="px-6 py-3">Nomor Seri</th>
                                                    <th class="px-6 py-3">Jenis</th>
                                                    <th class="px-6 py-3">Spesifikasi</th>
                                                    <th class="px-6 py-3">Kondisi Barang Baik</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($aset as $index => $item)
                                                    <tr>
                                                        <td class="px-6 py-3" scope="row">{{ $index + 1 }}</td>
                                                        <td>{{ $item->serial_number }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->brand }}</td>
                                                        <td><input type="checkbox" name="return_approval[{{ $index }}]"
                                                                value="1" />
                                                        </td>
                                                        <input type="hidden"
                                                            name="return_id[{{ $index }}]"value="{{ $item->id }}">
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            @if ($returned)
                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-0">
                                        <input class="form-check-input mb-2" type="checkbox" name="select-all"
                                            id="select-all">
                                        <label for="select-all" class="mx-2">pilih semua</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label
                                        class="col-form-label text-md-end"><b>{{ __('Deskripsi Pengembalian') }}</b></label>

                                    <div>
                                        <textarea class="form-control" readonly>{{ $request->return_notes }}</textarea>
                                    </div>
                                </div>
                            @endif

                            @if (!$returned)
                                <div class="mb-3">
                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-0">
                                            <input class="form-check-input mb-2" type="checkbox" name="select-all"
                                                id="select-all">
                                            <label for="select-all" class="mx-2">pilih semua</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="return_condition"
                                        class="col-form-label text-md-end">{{ __('Deskripsi Kondisi Barang') }}</label>

                                    <div>
                                        <textarea class="form-control" id="return_condition" name="return_condition" required></textarea>
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <div class="md-6">
                                        <input type="hidden" name="request_id" value="{{ $request->id }}">
                                        <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                            {{ __('Submit') }}
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @if (!empty($request->return_notice))
                                <div class="mb-3">
                                    <label for="return_notice"
                                        class="col-form-label text-md-end">{{ __('Pesan pengembalian:') }}</label>

                                    <div>
                                        <textarea class="form-control" id="return_notice" name="return_notice" autofocus readonly>{{ $request->return_notice }}</textarea>
                                    </div>
                                </div>
                            @endif

                        </form>




                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#select-all').click(function(event) {
            if (this.checked) {
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    </script>
@endsection
