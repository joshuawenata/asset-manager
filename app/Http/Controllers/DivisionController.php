<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\HistoryDepartemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Division::all();
        return View::make('superadmin.division', [
            'data' => $data
        ]);
    }

    public function index2(Request $request){
        $data = Division::all();
        $datetimes = $request->input('datetimes');
        $binusian_id_peminjam = $request->input('binusian_id_peminjam');

        return Redirect::to('/approver/check-request#see')->with([
            'datetimes' => $datetimes,
            'data' => $data,
            'binusian_id_peminjam' => $binusian_id_peminjam
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

    public function historySuperadmin()
    {
        $data = HistoryDepartemen::all();
        return view('superadmin.historyDepartemen', [
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
        $division = new Division;
        $division->name = $request->input('division-name');
        $division->approver = $request->input('approver');
        $history = new HistoryDepartemen;
        $history->aksi = "Superadmin menambahkan departemen ".$request->input('division-name');
        $history->save();
        $division->save();
        return redirect('division')->with('message', 'Departemen Baru Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public static function show($id)
    {
        $div = Division::find($id);
        return $div->name;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->input("division_id");
        $division = Division::find($id);
        $name = $request->input("division_name");
        $history = new HistoryDepartemen;
        $history->aksi = "Superadmin memperbaharui departemen ".$division->name." menjadi ".$name;
        $history->save();
        $division->name = $name;
        $division->save();
        return redirect('division')->with('message', 'Departemen Berhasil Diperbaharui');
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
    public function destroy(Request $req)
    {
        $dept = Division::find($req->division_id);
        $history = new HistoryDepartemen;
        $history->aksi = "Superadmin menghapus departemen ".$dept->name;
        $history->save();
        $dept->delete();
        return redirect('division')->with('message', 'Departemen Berhasil Dihapus');
    }
}
