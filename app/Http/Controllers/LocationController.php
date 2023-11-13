<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\HistoryLocation;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Location::all();
        return view('superadmin.location', [
           'data' => $data
        ]);
    }

    public function historySuperadmin()
    {
        $data = HistoryLocation::all();
        return view('superadmin.historyLokasi', [
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $location = new Location();
        $location->name = $request->input('location-name');
        $history = new HistoryLocation;
        $history->aksi = "Superadmin menambahkan lokasi ".$request->input('location-name');
        $history->save();
        $location->save();
        return redirect('location')->with('message', 'Lokasi baru berhasil ditambahkan');
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
    public function edit(Request $request)
    {
        $id = $request->input("location_id");
        $location = Location::find($id);
        $name = $request->input("location_name");
        $history = new HistoryLocation;
        $history->aksi = "Superadmin memperbaharui lokasi ".$location->name." menjadi ".$name;
        $history->save();
        $location->name = $name;
        $location->save();
        return redirect('location')->with('message', 'Lokasi Berhasil Diperbaharui');
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
    public function destroy(Request $request)
    {
        $loct = Location::find($request->location_id);
        $history = new HistoryLocation;
        $history->aksi = "Superadmin menghapus lokasi ".$loct->name;
        $history->save();
        $loct->delete();
        return redirect('location')->with('message', 'Lokasi berhasil dihapus');
    }
}
