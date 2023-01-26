<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// TODO: ini klo udh login gabisa ke dashboard page / nya malah ke login mesti cek user session
Route::get('/', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Auth::routes();

//HISTORI REQUEST
Route::get('/requests-history', [\App\Http\Controllers\RequestController::class, 'show'])->name('admin.historiRequest')->middleware('cekRole:admin,approver');
Route::get('/requests-history/{id}', [\App\Http\Controllers\BookingController::class, 'show2'])->name('rejectedbookings.show')->middleware('cekRole:admin,approver');
//GENERATE PDF
Route::post('download', [\App\Http\Controllers\PdfController::class, 'index'])->name('download')->middleware('cekRole:student,staff,admin,approver');

//TEST THIS
Route::get('/see/{user}/dashboard/{id}', [\App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show')->middleware('cekRole:student,staff,admin,approver');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/update-request', [\App\Http\Controllers\RequestController::class, 'update'])->name('updateRequest')->middleware('cekRole:admin,approver');

//Student & Staff Routes
Route::middleware(['auth', 'cekRole:student,staff'])->group(function(){
    Route::get('/dashboard', [\App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
    //CHECK TGL
    Route::get('/check-request', [\App\Http\Controllers\RequestController::class, 'check'])->name('checkRequest');
    //CREATE
    Route::post('/create-request', [\App\Http\Controllers\RequestController::class, 'createRequest'])->name('createRequest');
    Route::post('/create-request-detail', [\App\Http\Controllers\RequestController::class, 'create'])->name('createRequestDetail');
    //CONFIRM
    Route::post('/confirm-request', [\App\Http\Controllers\RequestController::class, 'confirm'])->name('confirmRequest');
    Route::post('/save-request', [\App\Http\Controllers\BookingController::class, 'store'])->name('storeRequest');
    //DELETE
    Route::post('/cancel-request', [\App\Http\Controllers\RequestController::class, 'destroy'])->name('deleteRequest');
    Route::post('/return', [\App\Http\Controllers\RequestController::class, 'kembali'])->name('kembali');
    Route::post('/update-return', [\App\Http\Controllers\RequestController::class, 'updateReturn'])->name('storeReturn');
    Route::post('/asset-taken', [\App\Http\Controllers\RequestController::class, 'updateStatus'])->name('updateStatus');
});


//Admin Routes
Route::middleware(['auth', 'cekRole:admin'])->group(function(){
    Route::get('/admin/dashboard', [\App\Http\Controllers\HomeController::class, 'adminDashboard'])->name('admin.dashboard');

    //ASSET
    //READ
    Route::get('/search-asset/{id}', [\App\Http\Controllers\AssetController::class, 'index']);
    Route::get('/move-asset/{id}', [\App\Http\Controllers\AssetController::class, 'pick']);
    Route::get('/deleted-asset/', [\App\Http\Controllers\DeletedAssetController::class, 'index']);
    Route::get('/move-asset-history/{id}', [\App\Http\Controllers\AssetLocationController::class, 'show']);
    //CREATE
    Route::get('/create-asset', [\App\Http\Controllers\AssetController::class, 'create'])->name('admin.createAsset');
    Route::get('/create-repair-asset/{id}', [\App\Http\Controllers\RepairAssetController::class, 'create']);
    Route::post('/store-new-asset', [\App\Http\Controllers\AssetController::class, 'store'])->name('storeAsset');
    Route::post('/store-repair-asset', [\App\Http\Controllers\RepairAssetController::class, 'store'])->name('storeRepairAsset');
    Route::post('/new-move-asset', [\App\Http\Controllers\AssetLocationController::class, 'create'])->name('admin.createMovedAsset');
    Route::post('/store-move-asset', [\App\Http\Controllers\AssetLocationController::class, 'store'])->name('storePemindahan');

    //UPDATE
    Route::get('/edit-asset/{id}', [\App\Http\Controllers\AssetController::class, 'edit']);
    Route::get('/repair-asset-history/{id}', [\App\Http\Controllers\RepairAssetController::class, 'index']);
    Route::put('update-asset/{id}', [\App\Http\Controllers\AssetController::class, 'update']);
    Route::post('/update-asset', [\App\Http\Controllers\RepairAssetController::class, 'update'])->name('updateFixedAsset');
    //DELETE
    Route::post('/delete-asset', [\App\Http\Controllers\AssetController::class, 'destroy']);
    //DOWNLOAD XLSX
    Route::get('export-asset', [\App\Http\Controllers\AssetController::class, 'export'])->name('downloadAsset');
    Route::get('export-deleted-asset', [\App\Http\Controllers\DeletedAssetController::class, 'export'])->name('downloadDeletedAsset');

    Route::post('/approve-return', [\App\Http\Controllers\RequestController::class, 'approvePengembalian'])->name('approve-return');
    Route::post('/reject-return', [\App\Http\Controllers\RequestController::class, 'rejectPengembalian'])->name('reject-return');
    Route::post('/return-form', [\App\Http\Controllers\RequestController::class, 'cekPengembalian'])->name('admin.formKembali');

    Route::post('/check-date', [\App\Http\Controllers\RequestController::class, 'checkTanggal'])->name('takenBooking');
});


//Approver Routes
Route::middleware(['auth', 'cekRole:approver'])->group(function(){
    Route::get('/approver/dashboard', [\App\Http\Controllers\HomeController::class, 'approverDashboard'])->name('approver.dashboard');



});


//Superadmin Routes
Route::middleware(['auth', 'cekRole:superadmin'])->group(function(){
    Route::get('/superadmin/dashboard', [\App\Http\Controllers\HomeController::class, 'superadminDashboard'] )->name('superadmin.dashboard');
    //LOCATION
    Route::post('/store-location', [\App\Http\Controllers\LocationController::class, 'store'])->name('store-location');
    Route::get('/location', [\App\Http\Controllers\LocationController::class, 'index'])->name('superadmin.location');
    Route::post('/delete-location', [\App\Http\Controllers\LocationController::class, 'destroy']);
    //DIVISION
    //CREATE
    Route::post('/store-division', [\App\Http\Controllers\DivisionController::class, 'store'])->name('storeDivision');
    //READ
    Route::get('/division', [\App\Http\Controllers\DivisionController::class, 'index'])->name('superadmin.division');
    //DELETE
    Route::post('/delete-division', [\App\Http\Controllers\DivisionController::class, 'destroy']);
    //USER
    //UPDATE
    Route::get('/edit-user/{id}', [\App\Http\Controllers\UserController::class, 'edit']);
    Route::put('/update-user/{id}', [\App\Http\Controllers\UserController::class, 'update']);
    Route::post('/reset-password', [\App\Http\Controllers\UserController::class, 'reset']);
    //DELETE
    Route::post('/delete-user', [\App\Http\Controllers\UserController::class, 'destroy']);
});
