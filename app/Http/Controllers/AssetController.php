<?php

namespace App\Http\Controllers;

use App\Exports\AssetExport;
use App\Models\Asset;
use App\Models\AssetLocation;
use App\Models\Booking;
use App\Models\AssetJenis;
use App\Models\DeletedAsset;
use App\Models\Location;
use App\Models\User;
use App\Models\PemilikBarang;
use App\Models\HistoryUpdateAsset;
use App\Models\HistoryAddAsset;
use App\Imports\AssetsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Exceptions\UnreadableFileException;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $data = Asset::orderBy('id', 'desc')
            ->where('division_id', $id)
            ->get();
        //tarik user saat ini Auth::user
        //tarik rolenya juga pake where role_id = id
        //tarik data dari role_page_mappings kolom CRUDD (ditambahkan), tarik CRUDD pake where role_id, role_id = id
        //lempar data ke viewnya
        //di view tinggal selection
        return view('admin.searchAsset', [
            'data' => $data,
            'mode' => 'current'
        ]);
    }

    public function search($id)
    {
        $data = Asset::orderBy('id', 'desc')
            ->where('division_id', $id)
            ->get();
        //tarik user saat ini Auth::user
        //tarik rolenya juga pake where role_id = id
        //tarik data dari role_page_mappings kolom CRUDD (ditambahkan), tarik CRUDD pake where role_id, role_id = id
        //lempar data ke viewnya
        //di view tinggal selection
        return view('searchAsset', [
            'data' => $data,
            'mode' => 'current'
        ]);
    }

    public function pick($id){
        $data = Asset::orderBy('id', 'desc')
            ->where('division_id', $id)
            ->where('status', 'tersedia')
            ->orWhere('status', 'tidak tersedia')
            ->orWhere('status', 'rusak')
            ->get();
        return view('admin.selectMoveAsset', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Location::all();
        $show = DB::table('asset_jenis')->where('status',1)->get();
        $pemilik = DB::table('pemilik_barangs')->select('nama')->where('division_id',\Illuminate\Support\Facades\Auth::user()->division->id)->get();

        return View::make('admin.createAsset', [
            'show' => $show,
            'pemilik' => $pemilik,
            'data' => $data
        ]);
    }

    public function createAssetExcelForStaff(Request $request){
        return View::make('createAssetExcel');
    }

    public function createAssetExcel(Request $request){
        return View::make('admin.createAssetExcel');
    }

    public function storeAssetExcelForStaff(Request $request){
        request()->validate([
            'excel' => 'required|mimes:xlsx'
        ]);

        try {
            if ($request->file('excel')) {
                $import = Excel::import(new AssetsImport, request()->file('excel'));

                $msg_success = "Data Uploaded Successfully!";
                $msg_danger = "Data Upload Failed!";

                if ($import) {
                    return redirect('/create-asset-excel-staff')->with('message', $msg_success);
                } else {
                    return redirect('/create-asset-excel-staff')->with('message', $msg_danger);
                }
            } else {
                $msge = "Please choose your file!";
                return redirect('/create-asset-excel-staff')->with('message', $msge);
            }
        } catch (UnreadableFileException $e) {
            $msg_error = "Error: The file is unreadable or corrupted. Please upload a valid Excel file.";
            return redirect('/create-asset-excel-staff')->with('message', $msg_error);
        } catch (NoTypeDetectedException $e) {
            $msg_error = "Error: No file type detected. Please upload a valid Excel file with the .xlsx extension.";
            return redirect('/create-asset-excel-staff')->with('message', $msg_error);
        } catch (\Exception $e) {
            $msg_error = $e->getMessage();
            return redirect('/create-asset-excel-staff')->with('message', $msg_error);
        }
    }

    public function storeAssetExcel(Request $request){
        request()->validate([
            'excel' => 'required|mimes:xlsx'
        ]);

        try {
            if ($request->file('excel')) {
                $import = Excel::import(new AssetsImport, request()->file('excel'));
                
                $msg_success = "Data Uploaded Successfully!";
                $msg_danger = "Data Upload Failed!";

                if ($import) {
                    return redirect('/create-asset-excel')->with('message', $msg_success);
                } else {
                    return redirect('/create-asset-excel')->with('message', $msg_danger);
                }
            } else {
                $msge = "Please choose your file!";
                return redirect('/create-asset-excel')->with('message', $msge);
            }
        } catch (UnreadableFileException $e) {
            $msg_error = "Error: The file is unreadable or corrupted. Please upload a valid Excel file.";
            return redirect('/create-asset-excel')->with('message', $msg_error);
        } catch (NoTypeDetectedException $e) {
            $msg_error = "Error: No file type detected. Please upload a valid Excel file with the .xlsx extension.";
            return redirect('/create-asset-excel')->with('message', $msg_error);
        } catch (\Exception $e) {
            $msg_error = $e->getMessage();
            return redirect('/create-asset-excel')->with('message', $msg_error);
        }
    }

    public function createForStaff()
    {
        $data = Location::all();
        $show = DB::table('asset_jenis')->where('status',1)->get();
        $pemilik = DB::table('pemilik_barangs')->select('nama')->where('division_id',\Illuminate\Support\Facades\Auth::user()->division->id)->get();

        return View::make('createAsset', [
            'show' => $show,
            'pemilik' => $pemilik,
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validasi usernya apakah boleh nyimpen ato ga
        $validator = Validator::make($request->all(), [
            'serial_number' => 'required|unique:assets',
            'location' => 'required',
            'kategori_barang' => 'required',
            'brand' => 'required',
            'spesifikasi_barang' => 'required',
        ]);
        
        if($validator->fails()){
            return redirect('create-asset')
                ->withErrors($validator)
                ->withInput();
        }
        else{
            //store
            $data = $request->input();
            $aset = new Asset;
            $aset->serial_number = $data['serial_number'];
            $aset->brand = $data['brand'];
            $aset->current_location = $data['location'];

            if($data['pemilik-barang'] != null){
                $aset->pemilik_barang = $data['pemilik-barang'];
            }

            if($data['asset-status'] == 'tersedia'){
                $aset->status = $data['asset-status'];
            }

            if($data['asset-jenis'] != null){
                $aset->asset_jenis_id = $data['asset-jenis'];
            }

            if($data['kategori_barang'] != null){
                $aset->kategori_barang = $data['kategori_barang'];
            }

            if($data['spesifikasi_barang'] != null){
                $aset->spesifikasi_barang = $data['spesifikasi_barang'];
            }

            $aset->division_id = $data['division_id'];
            $aset->save();

            $history = new HistoryAddAsset;
            $history->user_id = \Illuminate\Support\Facades\Auth::user()->id;
            $history->aksi = \Illuminate\Support\Facades\Auth::user()->name." menambahkan barang dengan nomor seri ".$data['serial_number'].", brand ".$data['brand'].", lokasi ".$data['location'].", pemilik barang ".$data['pemilik-barang'].", jenis barang ".$data['asset-jenis'].", kategori barang ".$data['kategori_barang'].", spesifikasi barang ".$data['spesifikasi_barang'];
            $history->save();

            $this->storeLoc();

            return redirect('search-asset/' . $data['division_id'])->with('message', "Aset Berhasil Ditambahkan");
        }
    }

    public function storeForStaff(Request $request)
    {
        //validasi usernya apakah boleh nyimpen ato ga
        $validator = Validator::make($request->all(), [
            'serial_number' => 'required|unique:assets',
            'location' => 'required',
            'kategori_barang' => 'required',
            'brand' => 'required',
            'spesifikasi_barang' => 'required',
        ]);

        if($validator->fails()){
            return redirect('create-asset-staff')
                ->withErrors($validator)
                ->withInput();
        }
        else{
            //store
            $data = $request->input();
            $aset = new Asset;
            $aset->serial_number = $data['serial_number'];
            $aset->brand = $data['brand'];
            $aset->current_location = $data['location'];

            if($data['pemilik-barang'] != null){
                $aset->pemilik_barang = $data['pemilik-barang'];
            }

            if($data['asset-status'] == 'tersedia'){
                $aset->status = $data['asset-status'];
            }

            if($data['asset-jenis'] != null){
                $aset->asset_jenis_id = $data['asset-jenis'];
            }

            if($data['kategori_barang'] != null){
                $aset->kategori_barang = $data['kategori_barang'];
            }

            if($data['spesifikasi_barang'] != null){
                $aset->spesifikasi_barang = $data['spesifikasi_barang'];
            }

            $aset->division_id = $data['division_id'];
            $aset->save();

            $history = new HistoryAddAsset;
            $history->user_id = \Illuminate\Support\Facades\Auth::user()->id;
            $history->aksi = \Illuminate\Support\Facades\Auth::user()->name." menambahkan barang dengan nomor seri ".$data['serial_number'].", brand ".$data['brand'].", lokasi ".$data['location'].", pemilik barang ".$data['pemilik-barang'].", jenis barang ".$data['asset-jenis'].", kategori barang ".$data['kategori_barang'].", spesifikasi barang ".$data['spesifikasi_barang'];
            $history->save();

            $this->storeLoc();

            return redirect('dashboard')->with('message', "Aset Berhasil Ditambahkan");
        }
    }

    public function storeLoc(){
        $aset = Asset::max('id');
        $aset = Asset::find($aset);
        $save_loc = new AssetLocationController();
        $save_loc->initialize($aset);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Asset::find($id);
        $show = AssetJenis::all();
        $pemilik = DB::table('pemilik_barangs')->select('nama')->where('division_id',\Illuminate\Support\Facades\Auth::user()->division->id)->get();

        return View::make('admin.editAsset', [
            'data' => $data,
            'show' => $show,
            'pemilik' => $pemilik
        ]);
    }

    /**
     * update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perbaharui(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'serial_number' => 'required',
            'brand' => 'required',
            'asset_jenis' => 'required'
        ]);

        if($validator->fails()){
            return redirect('edit-asset/' . $id)
                ->withErrors($validator)
                ->withInput();
        }else {
            $aset = Asset::find($id);
            $history_update = new HistoryUpdateAsset;
            $history_update->id_pengubah = \Illuminate\Support\Facades\Auth::id();
            $history_update->kode_barang = $aset->serial_number;
            $history_update->jenis_barang = AssetJenis::where('id',$aset->asset_jenis_id)->pluck('name')[0];
            $history_update->kategori_barang = $aset->kategori_barang;
            $history_update->status_barang = $aset->status;
            $history_update->brand = $aset->brand;
            $history_update->spesifikasi_barang = $aset->spesifikasi_barang;
            $history_update->pemilik_barang = $aset->pemilik_barang;
            $history_update->new_kode_barang = $request->input('serial_number');
            $history_update->new_jenis_barang = AssetJenis::where('id',$request->input('asset_jenis'))->pluck('name')[0];
            $history_update->new_kategori_barang = $request->input('kategori_barang');
            $history_update->new_status_barang = $request->input('asset-status');
            $history_update->new_spesifikasi_barang = $request->input('spesifikasi_barang');
            $history_update->new_brand = $request->input('brand');
            $aset->serial_number = $request->input('serial_number');
            $aset->kategori_barang = $request->input('kategori_barang');
            $aset->spesifikasi_barang = $request->input('spesifikasi_barang');
            $aset->brand = $request->input('brand');

            if($request->input('pemilik-barang') != null){
                $aset->pemilik_barang = $request->input('pemilik-barang');
                $history_update->new_pemilik_barang = $request->input('pemilik-barang');
            }else if ($request->input('new-pemilik-barang') != null){
                $new_pemilik_barang = new PemilikBarangController();
                $new_pemilik_barang = $new_pemilik_barang->store($request->input('new-pemilik-barang'), \Illuminate\Support\Facades\Auth::user()->division_id);
                $history_update->new_pemilik_barang = $request->input('new-pemilik-barang');

                $aset->pemilik_barang = $new_pemilik_barang;
            }

            $aset->asset_jenis_id = $request->input('asset_jenis');

            if($request->input('asset-status')){
                $aset->status = $request->input('asset-status');
            }

            $history_update->save();
            $aset->update();
            return redirect('search-asset/' . \Illuminate\Support\Facades\Auth::user()->division_id)->with('message', 'Aset Berhasil Diperbaharui');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $aset = Asset::find($request->asset_delete_id);
        $asetloc = AssetLocation::where('asset_id',$request->asset_delete_id);
        $bookingsloc = Booking::where('asset_id',$request->asset_delete_id);
        $d_aset = new DeletedAsset;
        $d_aset->user_id = \Illuminate\Support\Facades\Auth::user()->id;
        $d_aset->serial_number = $aset->serial_number;
        $d_aset->brand = $aset->brand;
        $d_aset->location = $aset->current_location;
        $d_aset->pemilik_barang = $aset->pemilik_barang;
        $d_aset->division_id = $aset->division_id;
        $d_aset->asset_jenis_id = $aset->asset_jenis_id;
        $d_aset->kategori_barang = $aset->kategori_barang;
        $d_aset->spesifikasi_barang = $aset->spesifikasi_barang;
        $d_aset->save();

        $asetloc->delete();
        $bookingsloc->delete();
        $aset->delete();
        return redirect('search-asset/' . \Illuminate\Support\Facades\Auth::user()->division->id)->with('message', 'Aset Berhasil Dihapus');

    }

    /**
     * Export database table to excel .xlsx file
     *
     * @return \Illuminate\Http\Response
     */
    public function export(){
        $aset = DB::table('assets')
            ->orderBy('id', 'desc')
            ->where('division_id', '=', \Illuminate\Support\Facades\Auth::user()->division->id)
            ->join('divisions', 'assets.division_id', '=', 'divisions.id')
            ->join('asset_jenis', 'assets.asset_jenis_id', '=', 'asset_jenis.id')
            ->select('assets.id', 'assets.serial_number', 'assets.status', 'assets.brand', 'assets.current_location', 'divisions.name as divisi', 'asset_jenis.name as jenis')
            ->get();

        return Excel::download(new AssetExport($aset), 'rekap_aset.xlsx');
    }

    public function riwayat(){
        $data = HistoryUpdateAsset::where('id_pengubah',\Illuminate\Support\Facades\Auth::id())->get();
        return View::make('admin.historyUpdate', [
            'data' => $data
        ]);
    }

    public function see(){
        return View::make('admin.see');
    }
}
