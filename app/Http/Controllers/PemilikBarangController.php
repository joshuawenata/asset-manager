<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PemilikBarang;
use App\Models\Division;
use App\Models\HistoryPemilikBarang;

class PemilikBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('pemilik_barangs')->where('division_id', \Illuminate\Support\Facades\Auth::user()->division->id )->get();
        return view('admin.pemilikBarang', [
           'data' => $data
        ]);
    }

    public function historySuperadmin()
    {
        $data = HistoryPemilikBarang::all();
        return view('superadmin.historyPemilikBarang', [
            'data' => $data
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function superadminPemilikBarang(){
        $data = DB::table('pemilik_barangs')->get();
        $divisi = DB::table('divisions')->get();
        return view('superadmin.pemilikbarang', [
           'data' => $data,
           'divisi' => $divisi
        ]);
    }

    public function createNewPemilikBarang(Request $request)
    {
        $new_pemilik_barang = new PemilikBarangController();
        $new_cat_id = $new_pemilik_barang->store($request->input('new-pemilik-barang'), $request->input('division-id'));
        $data = DB::table('pemilik_barangs')->get();
        $divisi = DB::table('divisions')->get();
        return view('superadmin.pemilikbarang', [
           'data' => $data,
           'divisi' => $divisi,
        ])->with('message', 'Pemilik Barang Berhasil Ditambahkan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(String $new_nama, int $new_division_id)
    {
        $cat = new PemilikBarang;
        $cat->nama = $new_nama;
        $cat->division_id = $new_division_id;
        $cat->save();
        $division_new_pemilik_barang = Division::where('id',$new_division_id)->pluck('name')[0];
        $history = new HistoryPemilikBarang;
        $history->aksi = "Superadmin menambahkan pemilik barang baru ".$new_nama." pada departemen ".$division_new_pemilik_barang;
        $history->save();

        return $new_nama;
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pemilik_barang = PemilikBarang::find($id);
        $divisi_pemilik_barang = Division::where('id',$pemilik_barang->division_id)->pluck('name')[0];
        $history = new HistoryPemilikBarang;
        $history->aksi = "Superadmin menghapus pemilik barang ".$pemilik_barang->pluck('nama')[0]." pada departemen ".$divisi_pemilik_barang;
        $history->save();
        $pemilik_barang->delete();
        return redirect('superadmin/pemilik-barang')->with('message', 'Pemilik Barang Berhasil Dihapus');
    }
}
