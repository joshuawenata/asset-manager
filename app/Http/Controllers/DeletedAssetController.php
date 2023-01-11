<?php

namespace App\Http\Controllers;

use App\Exports\DeletedAssetExport;
use App\Models\Asset;
use App\Models\DeletedAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DeletedAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Asset $aset)
    {
        $d_aset = new DeletedAsset;
        $d_aset->serial_number = $aset->serial_number;
        $d_aset->brand = $aset->brand;
        $d_aset->assigned_location = $aset->assigned_location;
        $d_aset->division_id = $aset->division_id;
        $d_aset->asset_category_id = $aset->asset_category_id;
        $d_aset->save();
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
        //
    }

    /**
     * Export database table to excel .xlsx file
     *
     * @return \Illuminate\Http\Response
     */
    public function export(){
        $d_aset = DB::table('deleted_assets')
            ->where('division_id', '=', \Illuminate\Support\Facades\Auth::user()->division->id)
            ->join('divisions', 'deleted_assets.division_id', '=', 'divisions.id')
            ->join('asset_categories', 'deleted_assets.asset_category_id', '=', 'asset_categories.id')
            ->select('deleted_assets.id', 'deleted_assets.serial_number', 'deleted_assets.brand', 'deleted_assets.assigned_location', 'divisions.name as divisi', 'asset_categories.name as jenis')
            ->get();

        return Excel::download(new DeletedAssetExport($d_aset), 'rekap_aset_musnah.xlsx');
    }

}
