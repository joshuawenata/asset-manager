<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Role;
use App\Models\Division;
use Illuminate\Support\Facades\Validator;

// TODO: ini klo udh login gabisa ke dashboard page / nya malah ke login mesti cek user session
Route::get('/', function () {
    return view('auth.pickrole');
})->name('login')->middleware('guest');

// Import the necessary classes at the beginning of the file
use App\Http\Controllers\Auth\ResetPasswordController;

// Add the following lines to your routes file
Route::get('password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/perbaharui', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.perbaharui');

Route::post('login', [App\Http\Controllers\AuthenticationController::class, 'login'])->name('logincheck');
Route::get('login/detail', [App\Http\Controllers\AuthenticationController::class, 'logindetail'])->name('logindetail');
Route::post('checkrole', [App\Http\Controllers\AuthenticationController::class, 'checkrole'])->name('checkrole');
Route::get('logout', [App\Http\Controllers\AuthenticationController::class, 'logout'])->name('logout');


//HISTORI REQUEST
Route::get('/requests-history', [\App\Http\Controllers\RequestController::class, 'show'])->name('historiRequest')->middleware(['auth', 'cekRole:approver,staff,admin']);
Route::get('/requests-history-pengembalian', [\App\Http\Controllers\RequestController::class, 'showDetail'])->name('approver.historiDetail')->middleware(['auth', 'cekRole:approver']);
Route::get('/requests-history/{id}', [\App\Http\Controllers\BookingController::class, 'show2'])->name('rejectedbookings.show')->middleware(['auth', 'cekRole:admin,approver']);
//GENERATE PDF
Route::post('unduh', [\App\Http\Controllers\PdfController::class, 'index'])->name('unduh')->middleware(['auth', 'cekRole:staff,admin,approver,superadmin']);
Route::get('unduh-excel', [\App\Http\Controllers\ExcelController::class, 'index'])->name('unduhExcel')->middleware(['auth', 'cekRole:staff,admin,approver']);

//TEST THIS
Route::get('register-show', function (Request $request) {
    $role_id = $request->input('role_id');
    $data = DB::table('divisions')->get();
    return view('auth.registerDetail', [
        'data' => $data,
    ])->with('role_id', $role_id);
})->name('superadmin.register-show');
Route::post('insert-account',function(Request $request){
    $validator = Validator::make(
        $request->all(),
        [
            'role' => 'array|min:1',
        ],
        [
            'role.min' => 'At least one role must be selected.',
        ]
    );

    if ($validator->fails()) {
        return redirect()->route('superadmin.register-show')->with('errors', 'Please pick at least 1 role');
    }    

    $selectedRoles = $request->input('role', []); // Retrieve the selected roles as an array.

    // You can then check which roles are selected by checking if their values are in the array.
    $isStaffSelected = in_array('1', $selectedRoles);
    $isAdminSelected = in_array('2', $selectedRoles);
    $isApproverSelected = in_array('3', $selectedRoles);

    DB::table('users')->insert([
        'name' => $request->input('name'),
        'binusianid' => $request->input('binusianid'),
        'phone' => $request->input('phone'),
        'division_id' => $request->input('division_id'),
        'email' => $request->input('email'),
        'password' => bcrypt($request->input('password')),
        'role_id' => $isStaffSelected ? 1 : ($isAdminSelected ? 2 : 3),
        'active_status' => 1,
        'created_at' => now(),
        'updated_at' => now(),
        'isStaff' => $isStaffSelected ? 1 : 0,
        'isAdmin' => $isAdminSelected ? 1 : 0,
        'isApprover' => $isApproverSelected ? 1 : 0,
    ]);

    $role = Role::where('id',$isStaffSelected ? 1 : ($isAdminSelected ? 2 : 3))->pluck('name')[0];
    $division = Division::where('id',$request->input('division_id'))->pluck('name')[0];
    
    DB::table('history_akuns')->insert([
        'aksi' => 'superadmin menambahkan akun '.$role.' dengan data nama: '.$request->input('name').', binusian_id: '.$request->input('binusianid').', phone: '.$request->input('phone').', departemen: '.$division.', email: '.$request->input('email'),
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return redirect()->route('superadmin.dashboard');
});

Route::get('/see/{user}/dashboard/{id}', [\App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show')->middleware(['auth', 'cekRole:staff,admin,approver,superadmin']);
Route::get('/approve/{user}/dashboard/{id}', [\App\Http\Controllers\BookingController::class, 'showApprove'])->name('bookings.showApprove')->middleware(['auth', 'cekRole:staff,admin']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/perbaharui-request/{request_perbaharui_id}', [\App\Http\Controllers\RequestController::class, 'perbaharui'])->name('perbaharuiRequest')->middleware(['auth', 'cekRole:admin,staff,approver']);
Route::post('/cancel/{request_delete_id}', [\App\Http\Controllers\RequestController::class, 'cancel'])->name('cancel')->middleware(['auth', 'cekRole:admin,staff,approver']);
Route::post('/reject/{request_perbaharui_id}', [\App\Http\Controllers\RequestController::class, 'reject'])->name('reject')->middleware(['auth', 'cekRole:admin,staff,approver']);
Route::post('/approve/{request_perbaharui_id}', [\App\Http\Controllers\RequestController::class, 'approve'])->name('approve')->middleware(['auth', 'cekRole:admin,staff,approver']);
Route::post('/approveonly/{request_perbaharui_id}', [\App\Http\Controllers\RequestController::class, 'approveonly'])->name('approveonly')->middleware(['auth', 'cekRole:admin,staff,approver']);
Route::post('/repair', [\App\Http\Controllers\RequestController::class, 'repair'])->name('repair')->middleware(['auth', 'cekRole:admin']);

// Staff Routes

Route::middleware(['auth', 'cekRole:staff,admin'])->group(function(){
    Route::redirect('/Halaman', '/dashboard');
    Route::post('/approve-return', [\App\Http\Controllers\RequestController::class, 'approvePengembalian'])->name('approve-return');
    Route::post('/reject-return', [\App\Http\Controllers\RequestController::class, 'rejectPengembalian'])->name('reject-return');
    Route::post('/return-form', [\App\Http\Controllers\RequestController::class, 'cekPengembalian'])->name('admin.formKembali');
    Route::post('/check-date', [\App\Http\Controllers\RequestController::class, 'checkTanggal'])->name('takenBooking');
    //HISTORY
    Route::get('/history-add-asset', [\App\Http\Controllers\HomeController::class, 'historyAddAsset'])->name('historyAddAsset');
    Route::get('/history-detail', [\App\Http\Controllers\HomeController::class, 'historyDetail'])->name('historyDetail');
    Route::post('/return', [\App\Http\Controllers\RequestController::class, 'kembali'])->name('kembali');
    Route::post('/perbaharui-return', [\App\Http\Controllers\RequestController::class, 'perbaharuiReturn'])->name('storeReturn');
});

Route::middleware(['auth', 'cekRole:staff'])->group(function(){
    Route::get('/dashboard', [\App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
    //CREATE
    Route::get('/create-asset-staff', [\App\Http\Controllers\AssetController::class, 'createForStaff'])->name('staff.createAsset');
    Route::get('/create-asset-excel-staff', [\App\Http\Controllers\AssetController::class, 'createAssetExcelForStaff'])->name('staff.createAssetExcel');
    Route::post('/store-asset-excel-staff', [\App\Http\Controllers\AssetController::class, 'storeAssetExcelForStaff'])->name('staff.storeAssetExcel');
    Route::post('/store-new-asset-staff', [\App\Http\Controllers\AssetController::class, 'storeForStaff'])->name('staff.storeAsset');
    Route::get('/search-asset-staff/{id}', [\App\Http\Controllers\AssetController::class, 'search']);
});

//Admin Routes
Route::middleware(['auth', 'cekRole:admin'])->group(function(){
    Route::get('/search-asset/{id}', [\App\Http\Controllers\AssetController::class, 'index']);
    Route::get('/admin/dashboard', [\App\Http\Controllers\HomeController::class, 'admindashboard'])->name('admin.dashboard');
    Route::get('/admin/location', [\App\Http\Controllers\LocationAdminController::class, 'index'])->name('admin.location');
    Route::get('/admin/pemilikBarang', [\App\Http\Controllers\PemilikBarangController::class, 'index'])->name('admin.pemilik-barang');
    Route::get('/admin/kategoriBarang', [\App\Http\Controllers\AssetJenisController::class, 'index'])->name('admin.kategori-barang');
    Route::post('/delete-location-admin', [\App\Http\Controllers\LocationAdminController::class, 'destroy'])->name('delete-location-admin');
    Route::post('/store-location-admin', [\App\Http\Controllers\LocationAdminController::class, 'store'])->name('store-location-admin');
    Route::get('/admin/riwayat-perbaharui', [\App\Http\Controllers\AssetController::class, 'riwayat'])->name('admin.riwayat-perbaharui');

    //ASSET
    //READ
    Route::get('/move-asset/{id}', [\App\Http\Controllers\AssetController::class, 'pick']);
    Route::get('/deleted-asset/', [\App\Http\Controllers\DeletedAssetController::class, 'index']);
    Route::get('/move-asset-history/{id}', [\App\Http\Controllers\AssetLocationController::class, 'show']);
    //CREATE
    Route::get('/create-asset', [\App\Http\Controllers\AssetController::class, 'create'])->name('admin.createAsset');
    Route::get('/create-asset-excel', [\App\Http\Controllers\AssetController::class, 'createAssetExcel'])->name('admin.createAssetExcel');
    Route::post('/store-asset-excel', [\App\Http\Controllers\AssetController::class, 'storeAssetExcel'])->name('admin.storeAssetExcel');
    Route::get('/create-repair-asset/{id}', [\App\Http\Controllers\RepairAssetController::class, 'create']);
    Route::post('/store-new-asset', [\App\Http\Controllers\AssetController::class, 'store'])->name('storeAsset');
    Route::post('/store-repair-asset', [\App\Http\Controllers\RepairAssetController::class, 'store'])->name('storeRepairAsset');
    Route::post('/new-move-asset', [\App\Http\Controllers\AssetLocationController::class, 'create'])->name('admin.createMovedAsset');
    Route::post('/store-move-asset', [\App\Http\Controllers\AssetLocationController::class, 'store'])->name('storePemindahan');

    //perbaharui
    Route::get('/edit-asset/{id}', [\App\Http\Controllers\AssetController::class, 'edit']);
    Route::get('/repair-asset-history/{id}', [\App\Http\Controllers\RepairAssetController::class, 'index']);
    Route::put('perbaharui-asset/{id}', [\App\Http\Controllers\AssetController::class, 'perbaharui']);
    Route::post('/perbaharui-asset', [\App\Http\Controllers\RepairAssetController::class, 'perbaharui'])->name('perbaharuiFixedAsset');
    //DELETE
    Route::get('/delete-asset/{id}', [\App\Http\Controllers\AssetController::class, 'destroy'])->name('delete-asset');
    Route::get('/delete-asset-pop-up/{id}', [\App\Http\Controllers\AssetController::class, 'destroypopup'])->name('delete-asset-pop-up');
    //unduh XLSX
    Route::get('export-asset', [\App\Http\Controllers\AssetController::class, 'export'])->name('unduhAsset');
    Route::get('export-deleted-asset', [\App\Http\Controllers\DeletedAssetController::class, 'export'])->name('unduhDeletedAsset');
});

//Approver Routes
Route::middleware(['auth', 'cekRole:approver'])->group(function(){
    Route::post('/cancel-request', [\App\Http\Controllers\RequestController::class, 'destroy'])->name('deleteRequest');
    Route::post('/choose-division', [\App\Http\Controllers\DivisionController::class, 'index2'])->name('chooseDivision');
    Route::get('/approver/check-request', [\App\Http\Controllers\RequestController::class, 'check'])->name('approver.checkRequest');
    Route::get('/approver/dashboard', [\App\Http\Controllers\HomeController::class, 'approverdashboard'])->name('approver.dashboard');
    Route::post('/approver/create-request', [\App\Http\Controllers\RequestController::class, 'createRequest'])->name('approver.createRequest');
    Route::post('/approver/create-request-detail', [\App\Http\Controllers\RequestController::class, 'create'])->name('approver.createRequestDetail');
    Route::post('/approver/confirm-request', [\App\Http\Controllers\RequestController::class, 'confirm'])->name('approver.confirmRequest');
    Route::post('/approver/save-request', [\App\Http\Controllers\BookingController::class, 'store'])->name('approver.storeRequest');
});

//Superadmin Routes
Route::middleware(['auth', 'cekRole:superadmin'])->group(function(){
    Route::get('/superadmin/dashboard', [\App\Http\Controllers\HomeController::class, 'superadmindashboard'] )->name('superadmin.dashboard');
    Route::get('/superadmin/kategori', [\App\Http\Controllers\AssetJenisController::class, 'superadminKategori'] )->name('superadmin.kategori');
    Route::get('/superadmin/pemilik-barang', [\App\Http\Controllers\PemilikBarangController::class, 'superadminPemilikBarang'] )->name('superadmin.pemilikbarang');
    Route::get('/edit-pemilik-barang/{id}', [\App\Http\Controllers\PemilikBarangController::class, 'destroy']);
    //HISTORY
    Route::get('/superadmin/history-departemen', [\App\Http\Controllers\DivisionController::class, 'historySuperadmin'])->name('superadmin.historyDepartemen');
    Route::get('/superadmin/history-lokasi', [\App\Http\Controllers\LocationController::class, 'historySuperadmin'])->name('superadmin.historyLocation');
    Route::get('/superadmin/history-kategori-barang', [\App\Http\Controllers\AssetJenisController::class, 'historySuperadmin'])->name('superadmin.historyAssetJenis');
    Route::get('/superadmin/history-pemilik-barang', [\App\Http\Controllers\PemilikBarangController::class, 'historySuperadmin'])->name('superadmin.historyPemilikBarang');
    Route::get('/superadmin/history-akun', [\App\Http\Controllers\UserController::class, 'historySuperadmin'])->name('superadmin.historyAkun');
    Route::get('/superadmin/history-akun-staff/{id}', [\App\Http\Controllers\UserController::class, 'historyStaff'])->name('superadmin.historyAkunStaff');
    Route::get('/superadmin/history-akun-admin/{id}', [\App\Http\Controllers\UserController::class, 'historyAdmin'])->name('superadmin.historyAkunAdmin');
    Route::get('/superadmin/history-akun-approver/{id}', [\App\Http\Controllers\UserController::class, 'historyApprover'])->name('superadmin.historyAkunApprover');

    //LOCATION
    Route::post('/create-new-asset-Jenis', [\App\Http\Controllers\AssetJenisController::class, 'createNewAssetJenis'])->name('createNewAssetJenis');
    Route::post('/create-new-pemilik-barang', [\App\Http\Controllers\PemilikBarangController::class, 'createNewPemilikBarang'])->name('createNewPemilikBarang');
    Route::post('/store-location', [\App\Http\Controllers\LocationController::class, 'store'])->name('store-location');
    Route::get('/location', [\App\Http\Controllers\LocationController::class, 'index'])->name('superadmin.location');
    Route::post('/delete-location', [\App\Http\Controllers\LocationController::class, 'destroy']);
    //DIVISION
    //CREATE
    Route::post('/store-division', [\App\Http\Controllers\DivisionController::class, 'store'])->name('storeDivision');
    //READ
    Route::get('/division', [\App\Http\Controllers\DivisionController::class, 'index'])->name('superadmin.division');
    //DELETE
    Route::get('/delete-kategori-barang/{id}', [\App\Http\Controllers\AssetJenisController::class, 'destroy']);
    Route::post('/delete-division', [\App\Http\Controllers\DivisionController::class, 'destroy']);
    //USER
    //perbaharui
    Route::post('/edit-kategori-barang/{id}', [\App\Http\Controllers\AssetJenisController::class, 'perbaharui'])->name('perbaharuiKategoriBarang');
    Route::get('/edit-user/{id}', [\App\Http\Controllers\UserController::class, 'edit']);
    Route::get('/edit-user-active-status/{id}', [\App\Http\Controllers\UserController::class, 'editActive']);
    Route::put('/perbaharui-user/{id}', [\App\Http\Controllers\UserController::class, 'perbaharui']);
    Route::post('/reset-password', [\App\Http\Controllers\UserController::class, 'reset']);
    Route::post('/edit-division', [\App\Http\Controllers\DivisionController::class, 'edit']);
    Route::post('/edit-location', [\App\Http\Controllers\LocationController::class, 'edit']);
    //DELETE
    Route::post('/delete-user', [\App\Http\Controllers\UserController::class, 'destroy']);
});
