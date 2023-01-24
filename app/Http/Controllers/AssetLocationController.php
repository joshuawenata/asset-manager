<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\assetLocation;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetLocationController extends Controller
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
    public function create(Request $request)
    {
        $data = Location::all();
        $assets = $request->input('assets');

        return view('admin.createMovedAsset', [
            'assets' => $assets,
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
        $data = $request->input();
        $assets = unserialize($data['assets']);

        foreach ($assets as $a){
            $new = new assetLocation();
            $new->asset_id = $a;
            $new->responsible = $data['responsible'];
            $new->to_location = $data['to_location'];

            $asset = Asset::find($a);
            $asset->current_location = $data['to_location'];
            $asset->update();
            $new->save();
        }

        return redirect('searchAsset/' . Auth::user()->division->id)->with('message', "Asset berhasil dipindahkan!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pemindahan = assetLocation::where('asset_id', $id)->get();

        return view('admin.moveAssetHistory', [
            'data' => $pemindahan
        ]);
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
}
