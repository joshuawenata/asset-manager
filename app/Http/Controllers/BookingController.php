<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetLocation;
use App\Models\Booking;
use App\Models\User;
use App\Models\HistoryDetail;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class BookingController extends Controller
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
    public function store(Request $request)
    {
        $new_request = new RequestController();
        $request_id = $new_request->store($request);

        $data = $request->input();
        $assets = $data['assets'];

        foreach ($assets as $i){
            $asset = DB::table('assets')
                ->join('asset_jenis', 'assets.asset_jenis_id', '=', 'asset_jenis.id')
                ->select('assets.*', 'asset_jenis.name')
                ->where('assets.id', '=', $i)
                ->get();
            foreach ($asset as $a){
                DB::table('assets')->where('id', $a->id)->update(['status' => 'tidak']);
            }
        }

        foreach ($assets as $asset){
            $as = Asset::find($asset);
            $booking = new Booking();
            $booking->request_id = $request_id;
            $booking->asset_id = $asset;
            $booking->asset_jenis_id = $as->asset_jenis_id;
            $booking->status = NULL;
            $booking->save();
        }

        $div_id = $data['division_id'];

        $email = new SendEmailController();
        $message ='REQUEST PEMINJAMAN ALAT';
        $subyek = 'Ada request peminjaman alat baru dari ' . Auth::user()->name . ' ' . Auth::user()->email;

        // Retrieve users with role_id = 1
        $receiversRole1 = DB::table('users')
        ->select('email')
        ->where('division_id', $div_id)
        ->where('role_id', 1)
        ->get();

        // Extract email addresses from the result and store them in an array
        $receiverEmailsRole1 = [];
        foreach ($receiversRole1 as $receiverRole1) {
            $receiverEmailsRole1[] = $receiverRole1->email;
        }

        // Send emails to users with role_id = 2
        $receiverRole2 = DB::table('users')
        ->select('email')
        ->where('division_id', $div_id)
        ->where('isAdmin', 1)
        ->get();

        $receiverEmailRole2 = $receiverRole2[0]->email;

        // Send emails to users with role_id = 2
        $email->index($receiverEmailRole2, $subyek, $message);

        // Send emails to users with role_id = 1
        foreach ($receiverEmailsRole1 as $receiverEmailRole1) {
            $email->index($receiverEmailRole1, $subyek, $message);
        }

        return redirect('/dashboard')->with('message', "Request Berhasil Ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user, $id)
    {
        $request = \App\Models\Request::find($id);
        $stat = $request->status;
        $request = $request->notes;

        if($stat == 'waiting next approval'||$stat == 'approved sebagian'){
            $assets = DB::table('bookings')
                ->join('assets', 'bookings.asset_id', '=', 'assets.id')
                ->join('asset_jenis', 'bookings.asset_jenis_id', '=', 'asset_jenis.id')
                ->select('bookings.id','assets.serial_number', 'assets.brand', 'asset_jenis.name', 'bookings.status', 'assets.division_id', 'assets.kategori_barang', 'assets.spesifikasi_barang')
                ->where('bookings.request_id', '=', $id)
                ->where(function ($query) {
                    $query->where('bookings.status', '=', 'approved')
                          ->orWhereNull('bookings.status');
                })
                ->get();
        }else{
            $assets = DB::table('bookings')
                ->join('assets', 'bookings.asset_id', '=', 'assets.id')
                ->join('asset_jenis', 'bookings.asset_jenis_id', '=', 'asset_jenis.id')
                ->select('bookings.id','assets.serial_number', 'assets.brand', 'asset_jenis.name', 'bookings.status', 'assets.division_id', 'assets.kategori_barang', 'assets.spesifikasi_barang')
                ->where('bookings.request_id', '=', $id)
                ->where(function ($query) {
                    $query->where('bookings.status', '=', 'approved')
                          ->orWhereNull('bookings.status');
                })
                ->get();
        }

        session(['bookings' => $assets]);
        session(['request' => $request]);
        session(['stat' => $stat]);
        
        return View::make('see');
    }

    public function show2($id)
    {
        $assets = DB::table('bookings')
            ->join('assets', 'bookings.asset_id', '=', 'assets.id')
            ->join('asset_jenis', 'bookings.asset_jenis_id', '=', 'asset_jenis.id')
            ->select('assets.serial_number', 'assets.brand', 'asset_jenis.name', 'assets.status')
            ->where('bookings.request_id', '=', $id)
            ->get();
        $request = \App\Models\Request::find($id);
        $stat = $request->status;
        $request = $request->notes;

        return Redirect::to('requests-history#see')->with(['bookings' => $assets, 'request' => $request, 'stat' => $stat]);
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

    public function update($req_id)
    {
        $current_date_time = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
        $current_date_time = $current_date_time->format('Y-m-d H:i:s');

        DB::table('bookings')
            ->where('request_id', '=', $req_id)
            ->update(['taken_date' => $current_date_time]);

        $bookings = DB::table('bookings')
            ->where('request_id', '=', $req_id)
            ->get();

        $request = \App\Models\Request::find($req_id);
        $request->status = 'on use';
        $request->update();

        foreach ($bookings as $b){
            $aset = Asset::find($b->asset_id);

            $loc = new AssetLocation();
            $loc->asset_id = $b->asset_id;
            $loc->responsible = $request->User->name . " (" . Auth::user()->name . ")";
            $loc->responsible_id = $request->User->id;
            $loc->to_location = $request->lokasi;
            $loc->notes = 'peminjaman';
            $loc->save();

            $aset->current_location = $request->lokasi;
            $aset->status = 'dipinjam';
            $aset->update();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bookings = DB::table('bookings')
            ->where('request_id', '=', $id)
            ->get();

        $request = \App\Models\Request::find($id);

        foreach ($bookings as $b){
            $aset = Asset::find($b->asset_id);

            $prev_pos = AssetLocation::orderBy('id', 'desc')
                ->where('asset_id', '=', $b->asset_id)
                ->offset(1)->limit(1)
                ->get();

            foreach ($prev_pos as $p){
                $lok = $p->to_location;
            }

            $aset->status = 'tersedia';
            $aset->update();
        }
        DB::table('bookings')->where('request_id', '=', $id)->delete();
    }

    public function updateReturn($id, $date){
        DB::table('bookings')
            ->where('request_id', '=', $id)
            ->update(['realize_return_date' => $date]);

        $bookings = DB::table('bookings')
            ->where('request_id', '=', $id)
            ->get();

        $request = \App\Models\Request::find($id);

        foreach ($bookings as $b){
            $aset = Asset::find($b->asset_id);

            $prev_pos = AssetLocation::orderBy('id', 'desc')
                ->where('asset_id', '=', $b->asset_id)
                ->offset(1)->limit(1)
                ->get();
            foreach ($prev_pos as $p){
                $lok = $p->to_location;
            }

            $loc = new AssetLocation();
            $loc->asset_id = $b->asset_id;
            $loc->responsible = $request->User->name . " (" . Auth::user()->name . ")";
            $loc->responsible_id = $request->User->id;
            $loc->to_location = $lok;
            $loc->notes = 'pengembalian';
            $loc->save();

            $aset->current_location = $lok;
            $aset->status = 'tersedia';
            $aset->update();
        }
    }
}
