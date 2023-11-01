<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/js/app.js')

    <title>Inventory Management BDG</title>

    @yield('js')
    @yield('css')

    <!-- Jquery -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

    <!-- Data Table -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">

    <link type="text/css" rel="stylesheet"
        href="https://cdn.datatables.net/buttons/2.3.4/css/buttons.dataTables.min.css">

    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>

    <!-- Date Time -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Bootstraps-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous" defer>
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- icons -->
    

</head>

<body>
    <script>
        // Wait for the document to be ready
        $(document).ready(function() {
            // Handle the click event on the button
            $("#MenuButton").click(function() {
            // Toggle the visibility of the dropdown when the button is clicked
                $("#dropdownMenu").toggleClass("hidden");
            });

            $("#AccountButton").click(function() {
            // Toggle the visibility of the dropdown when the button is clicked
                $("#dropdownAccount").toggleClass("hidden");
            });

        });
    </script>
    <div id="app">
        <nav class="bg-white shadow-sm">
            <div class="container mx-auto px-4">
                <div class="flex items-center py-4">
                    <div class="flex-shrink-0 mr-5">
                        @guest
                            <a class="text-lg font-semibold no-underline text-black" href="{{ url('/') }}">
                                Management Inventory
                            </a>
                            <p class="text-xs font-bold">
                                <span class="text-blue-700">created by LCBDG</span>
                                <span class="text-blue-500 bg-blue-200">LB001</span>
                                <span class="text-green-500 bg-green-200">LB003</span>
                                <span class="text-red-500 bg-red-200">LB009</span>
                            </p>
                        @else
                            <a class="text-lg font-semibold no-underline text-black" href="{{ url('/home') }}">
                                Management Inventory
                            </a>
                            <p class="text-xs font-bold">
                                <span class="text-blue-700">created by LCBDG</span>
                                <span class="text-blue-500 bg-blue-200">LB001</span>
                                <span class="text-green-500 bg-green-200">LB003</span>
                                <span class="text-red-500 bg-red-200">LB009</span>
                            </p>
                        @endguest
                    </div>
                    @guest
                    @else
                        <button id="MenuButton" data-dropdown-toggle="dropdownMenu" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 px-5 py-2.5 text-center inline-flex items-center" type="button">Action Menu<svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        @guest
                        @else
                            @if (auth()->user()->role->name == 'staff')
                                <div id="dropdownMenu" class="absolute hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 mt-[25rem] w-40 ml-[21.5rem] left-0 z-10">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200 p-0 pt-4" aria-labelledby="dropdownDefaultButton">
                                        <li><a href="{{ url('/search-asset-staff/' . \Illuminate\Support\Facades\Auth::user()->division->id) }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Lihat Inventory</a></li>
                                        <li><a href="{{ route('staff.createAsset') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Tambah Barang</a></li>
                                        <li><a href="{{ route('staff.createAssetExcel') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Tambah Barang Melalui Excel</a></li>
                                        <li><a href="{{ route('historyAddAsset') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Riwayat Tambah Barang</a></li>
                                        <li><a href="{{ route('historyDetail') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Detil Riwayat</a></li>
                                        <li><a href="{{ route('historiRequest') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Riwayat Peminjaman</a></li>
                                    </ul>
                                </div>
                            @elseif(auth()->user()->role->name == 'admin')
                                <div id="dropdownMenu" class="absolute hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 mt-[36rem] w-40 ml-[21.5rem] left-0 z-10">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200 p-0 pt-4" aria-labelledby="dropdownDefaultButton">
                                        <li><a href="{{ url('/search-asset/' . \Illuminate\Support\Facades\Auth::user()->division->id) }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Lihat Inventory</a></li>
                                        <li><a href="{{ route('admin.createAssetExcel') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Tambah Barang Melalui Excel</a></li>
                                        <li><a href="{{ route('historyAddAsset') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Riwayat Tambah Barang</a></li>
                                        <li><a href="{{ route('historyDetail') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Detil Riwayat</a></li>
                                        <li><a href="{{ url('/deleted-asset/') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Riwayat Pemusnahan Barang</a></li>
                                        <li><a href="{{ route('admin.riwayat-perbaharui') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Riwayat Perbaharui Barang</a></li>
                                        <li><a href="{{ url('/move-asset/' . \Illuminate\Support\Facades\Auth::user()->division->id) }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Pemindahan Barang</a></li>
                                        <li><a href="{{ route('historiRequest') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Riwayat Peminjaman</a></li>
                                    </ul>
                                </div>
                            @elseif(auth()->user()->role->name == 'approver')
                                <div id="dropdownMenu" class="absolute hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 mt-[16rem] w-40 ml-[21.5rem] left-0 z-10">    
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200 p-0 pt-4" aria-labelledby="dropdownDefaultButton">
                                        <li><a href="{{ route('approver.checkRequest') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Pinjam Inventory</a></li>
                                        <li><a href="{{ route('historiRequest') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Riwayat Peminjaman</a></li>
                                        <li><a href="{{ route('approver.historiDetail') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Detil Riwayat</a></li>
                                    </ul>
                                </div>
                            @elseif(auth()->user()->role->name == 'superadmin')
                                <div id="dropdownMenu" class="absolute hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 mt-[24rem] w-40 ml-[21.5rem] left-0 z-10">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200 p-0 pt-4" aria-labelledby="dropdownDefaultButton">    
                                        <li><a href="{{ route('superadmin.division') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white dark:hover:text-white">Lihat Departemen</a></li>
                                        <li><a href="{{ route('superadmin.location') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white dark:hover:text-white">Kelola Lokasi</a></li>
                                        <li><a href="{{ route('superadmin.register-show') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white dark:hover:text-white">{{ __('Daftarkan akun') }}</a></li>
                                        <li><a href="{{ route('superadmin.kategori') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white dark:hover:text-white">{{ __('Kelola Kategori Barang') }}</a></li>
                                        <li><a href="{{ route('superadmin.pemilikbarang') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white dark:hover:text-white">{{ __('Kelola Pemilik Barang') }}</a></li>
                                        <li><a href="{{ route('superadmin.historyAkun') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white dark:hover:text-white">{{ __('History Akun') }}</a></li>
                                    </ul>
                                </div>
                            @endif
                        @endguest
                    @guest
                        @else
                            <button id="AccountButton" data-dropdown-toggle="dropdownAccount" class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 px-5 py-2.5 text-center inline-flex items-center ml-auto" type="button">{{ Auth::user()->name }}<svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                        @endguest
                        <div id="dropdownAccount" class="absolute hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 mt-40 w-40 mr-[8.75rem] right-0 z-10">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200 p-0 pt-4" aria-labelledby="dropdownDefaultButton">
                            @guest
                            @else
                                <li><a href="{{ route('logout') }}" class="text-black no-underline block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Keluar</a></li>
                            @endguest
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
