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
    //TO ASK: ini perlu pake controller?? utk ke login pagenya
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//REQUEST PEMINJAMAN
//READ
Route::get('dashboard/{p}', [\App\Http\Controllers\RequestController::class, 'index']);
Route::get('riwayat', [\App\Http\Controllers\RequestController::class, 'show'])->name('riwayat');
//CHECK TGL
Route::get('student/checkRequest', [\App\Http\Controllers\RequestController::class, 'check'])->name('checkRequest');
//CREATE
Route::post('student/createRequest', [\App\Http\Controllers\RequestController::class, 'createRequestDetail'])->name('createRequest');
Route::post('student/createRequestDetail', [\App\Http\Controllers\RequestController::class, 'create'])->name('createRequestDetail');
//CONFIRM
Route::post('student/confirmRequest', [\App\Http\Controllers\RequestController::class, 'confirm'])->name('confirmRequest');
Route::post('student/storeRequest', [\App\Http\Controllers\BookingController::class, 'store'])->name('storeRequest');
//DELETE
Route::post('deleteRequest', [\App\Http\Controllers\RequestController::class, 'destroy']);
//GENERATE PDF
Route::post('download', [\App\Http\Controllers\PdfController::class, 'index'])->name('download');

Route::get('dashboard/{user}/{id}', [\App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show');
Route::get('riwayat/{id}', [\App\Http\Controllers\BookingController::class, 'show2'])->name('rejectedbookings.show');
//UPDATE
Route::post('updateRequests', [\App\Http\Controllers\RequestController::class, 'update']);
//KEMBALI PINJAMAN
Route::post('kembaliRequest', [\App\Http\Controllers\RequestController::class, 'kembali'])->name('kembaliRequests');
Route::post('simpanKembali', [\App\Http\Controllers\RequestController::class, 'simpanKembali'])->name('simpanKembali');
Route::post('cekPengembalian', [\App\Http\Controllers\RequestController::class, 'cekPengembalian'])->name('cekPengembalian');
Route::post('approvePengembalian', [\App\Http\Controllers\RequestController::class, 'approvePengembalian'])->name('approvePengembalian');
Route::post('rejectPengembalian', [\App\Http\Controllers\RequestController::class, 'rejectPengembalian'])->name('rejectPengembalian');

//BOOKINGS
Route::post('', [\App\Http\Controllers\RequestController::class, 'checkTanggal'])->name('takenBookings');
Route::post('updateStatus', [\App\Http\Controllers\RequestController::class, 'updateStatus'])->name('updateStatus');

//ASSET
//READ
Route::get('searchAsset/{id}', [\App\Http\Controllers\AssetController::class, 'index']);
Route::get('lookAtMovedAsset/{id}', [\App\Http\Controllers\AssetController::class, 'pick']);
Route::get('searchDeletedAsset', [\App\Http\Controllers\DeletedAssetController::class, 'index']);
Route::get('admin/moveAssetHistory/{id}', [\App\Http\Controllers\AssetLocationController::class, 'show']);
//CREATE
Route::get('admin/createAsset', [\App\Http\Controllers\AssetController::class, 'create'])->name('createAsset');
Route::get('admin/createRepairAsset/{id}', [\App\Http\Controllers\RepairAssetController::class, 'create']);
Route::post('admin/searchAsset', [\App\Http\Controllers\AssetController::class, 'store'])->name('storeAsset');
Route::post('admin/storeRepair', [\App\Http\Controllers\RepairAssetController::class, 'store'])->name('storeRepairAsset');
Route::post('admin/addDetailMovedAsset', [\App\Http\Controllers\AssetLocationController::class, 'create'])->name('addDetailMovedAsset');
Route::post('admin/storePemindahan', [\App\Http\Controllers\AssetLocationController::class, 'store'])->name('storePemindahan');

//UPDATE
Route::get('admin/editAsset/{id}', [\App\Http\Controllers\AssetController::class, 'edit']);
Route::get('admin/repairAssetHistory/{id}', [\App\Http\Controllers\RepairAssetController::class, 'index']);
Route::put('updateAsset/{id}', [\App\Http\Controllers\AssetController::class, 'update']);
Route::post('admin/updateRepairAsset', [\App\Http\Controllers\RepairAssetController::class, 'update'])->name('updateRepairAsset');
//DELETE
Route::post('deleteAsset', [\App\Http\Controllers\AssetController::class, 'destroy']);
//DOWNLOAD XLSX
Route::get('exportasset', [\App\Http\Controllers\AssetController::class, 'export'])->name('downloadAsset');
Route::get('exportdeletedasset', [\App\Http\Controllers\DeletedAssetController::class, 'export'])->name('downloadDeletedAsset');

//USER
//READ
Route::get('superadmin/home', [\App\Http\Controllers\UserController::class, 'index']);
//UPDATE
Route::get('superadmin/editUser/{id}', [\App\Http\Controllers\UserController::class, 'edit']);
Route::put('updateUser/{id}', [\App\Http\Controllers\UserController::class, 'update']);
Route::post('resetPassword', [\App\Http\Controllers\UserController::class, 'reset']);
//DELETE
Route::post('deleteUser', [\App\Http\Controllers\UserController::class, 'destroy']);

//DIVISION
//CREATE
Route::post('superadmin/division', [\App\Http\Controllers\DivisionController::class, 'store'])->name('storeDivision');
//READ
Route::get('superadmin/division', [\App\Http\Controllers\DivisionController::class, 'index'])->name('readDivision');
//DELETE
Route::post('deleteDivision', [\App\Http\Controllers\DivisionController::class, 'destroy']);

//LOCATION
Route::post('superadmin/location', [\App\Http\Controllers\LocationController::class, 'store'])->name('storeLocation');
Route::get('superadmin/location', [\App\Http\Controllers\LocationController::class, 'index'])->name('readLocation');
Route::post('deleteLocation', [\App\Http\Controllers\LocationController::class, 'destroy']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
