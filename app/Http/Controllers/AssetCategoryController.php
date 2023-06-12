<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('asset_categories')->where('status',1)->get();
        return view('admin.kategoriBarang', [
           'data' => $data
        ]);
    }

    public function superadminKategori(){
        $data = DB::table('asset_categories')->where('status',1)->get();
        return view('superadmin.kategori', [
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

    public function createNewAssetCategory(Request $request)
    {
        $new_category = new AssetCategoryController();
        $new_cat_id = $new_category->store($request->input('new-asset-category'));
        $data = DB::table('asset_categories')->where('status',1)->get();
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
    public function store(String $new_category)
    {
        $cat = new AssetCategory;
        $cat->name = $new_category;
        $cat->status = 1;
        $cat->save();

        return DB::table('asset_categories')->max('id');
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Kategori_barang = AssetCategory::find($id);
        $Kategori_barang->name = $request->name;
        $Kategori_barang->update();
        $data = DB::table('asset_categories')->where('status',1)->get();
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
        $Kategori_barang = AssetCategory::find($id);
        $Kategori_barang->status = 0;
        $Kategori_barang->update();
        $data = DB::table('asset_categories')->where('status',1)->get();
        return view('superadmin.kategori', [
            'data' => $data
         ]);
    }
}
