<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\RepairAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class RepairAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $data = RepairAsset::where('asset_id', $id)->get();

        $fixed_id = DB::table('repair_assets')->max('id');
        $fixed = RepairAsset::find($fixed_id);
        if($fixed == null) $fixed = 1;
        else $fixed = $fixed->flag_fixed;

        return view('admin.repairAssetHistory', [
            'data' => $data,
            'asset' => $id,
            'fixed' => $fixed
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return View::make('admin.createRepairAsset', [
            'asset' => $id
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
        $data = $request->input();
        $new = new RepairAsset();
        $new->asset_id = $data['asset_id'];
        $new->reported_by = $data['pelapor'];
        $new->description = $data['description'];
        $new->flag_fixed = 0;

        $aset = Asset::find($data['asset_id']);
        $aset->status = 'tidak tersedia';
        $aset->update();

        $new->save();
        return redirect('admin/repairAssetHistory/' . $data['asset_id'])->with('message', "Riwayat kerusakan berhasil dicatat.");
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
    public function update(Request $request)
    {
        $data = $request->input();
        $repair = RepairAsset::find($data['repair_id']);
        $repair->pic_repair = $data['pic'];
        $repair->repaired_by = $data['repaired-by'];
        $repair->flag_fixed = 1;

        $aset = Asset::find($repair->asset_id);
        $aset->status = 'tersedia';
        $aset->update();

        $repair->update();
        return redirect('admin/repairAssetHistory/' . $repair->asset_id)->with('message', "Riwayat perbaikan berhasil dicatat.");
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
}
