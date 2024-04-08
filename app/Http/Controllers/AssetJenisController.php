<?php

namespace App\Http\Controllers;

use App\Models\AssetJenis;
use App\Models\HistoryAssetJenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetJenisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('asset_jenis')->where('status',1)->get();
        return view('admin.kategoriBarang', [
           'data' => $data
        ]);
    }

    public function superadminKategori(){
        $data = DB::table('asset_jenis')->where('status',1)->get();
        return view('superadmin.kategori', [
           'data' => $data
        ]);
    }

    public function historySuperadmin()
    {
        $data = HistoryAssetJenis::all();
        return view('superadmin.historyAssetJenis', [
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
        //
    }

    public function createNewAssetJenis(Request $request)
    {
        $new_jenis = new AssetJenisController();
        $new_cat_id = $new_jenis->store($request->input('new-asset-jenis'));
        $data = DB::table('asset_jenis')->where('status',1)->get();
        return view('superadmin.kategori', [
           'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(String $new_jenis)
    {
        $cat = new AssetJenis;
        $cat->name = $new_jenis;
        $cat->status = 1;
        $cat->save();
        $history = new HistoryAssetJenis;
        $history->aksi = "Superadmin menambahkan kategori barang ".$new_jenis;
        $history->save();

        return DB::table('asset_jenis')->max('id');
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
        //
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
        $Kategori_barang = AssetJenis::find($id);
        if ($request->has('name') && $request->name !== null) {
            $Kategori_barang->name = $request->name;
            $Kategori_barang->update();
        } else {
            return back()->with('error', 'Name cannot be empty.'); // Redirect back with an error message
        }

        $data = DB::table('asset_jenis')->where('status',1)->get();
        return view('superadmin.kategori', [
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Kategori_barang = AssetJenis::find($id);
        $Kategori_barang->status = 0;
        $Kategori_barang->update();
        $history = new HistoryAssetJenis;
        $history->aksi = "Superadmin menghapus kategori barang ".$Kategori_barang->name;
        $history->save();
        $data = DB::table('asset_jenis')->where('status',1)->get();
        return view('superadmin.kategori', [
            'data' => $data
         ]);
    }
}
