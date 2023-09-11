<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use App\Models\HistoryDetail;
use App\Models\Division;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Seblhaire\DateRangePickerHelper\DateRangePickerHelper;
use function PHPUnit\Framework\isEmpty;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_date_time = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
        $current_date_time = $current_date_time->format('Y-m-d H:i:s');

//        kalau tgl bookingnya dah lewat (return date < current) otomatis ke reject
        DB::table('requests')
            ->where(function ($query) {
                $query->where('status', '=', 'waiting approval')
                    ->orWhere('status', '=', 'waiting next approval');
            })
            ->where('return_date', '<=', $current_date_time)
            ->update(['status' => 'rejected']);

        $p = Auth::user()->role->name;

        if($p == 'staff'){
            $user_div_id = \Illuminate\Support\Facades\Auth::user()->division_id;
            $data = DB::table('requests')
                ->orderBy('id', 'asc')
                ->where('requests.track_approver', '=', 0)
                ->where('requests.division_id', '=', $user_div_id)
                ->where('status', '=', 'waiting approval')
                ->orWhere('status', '=', 'approved sebagian')
                ->orWhere('status', '=', 'waiting next approval')
                ->orWhere('status', '=', 'approved')
                ->orWhere('status', '=', 'on use')
                ->orWhere('status', '=', 'taken')
                ->join('users', 'requests.user_id', '=', 'users.id')
                ->select('requests.*', 'users.id AS userid', 'users.name', 'users.binusianid')
                ->where('requests.division_id', '=', $user_div_id)
                ->get();
            $approver = \Illuminate\Support\Facades\Auth::user()->division->approver;
        }
        else if($p == 'admin'){
            $user_div_id = \Illuminate\Support\Facades\Auth::user()->division_id;
            $data = DB::table('requests')
                ->orderBy('id', 'asc')
                ->where('requests.track_approver', '=', 0)
                ->where('requests.division_id', '=', $user_div_id)
                ->where('status', '=', 'waiting approval')
                ->orWhere('status', '=', 'approved sebagian')
                ->orWhere('status', '=', 'waiting next approval')
                ->orWhere('status', '=', 'approved')
                ->orWhere('status', '=', 'on use')
                ->orWhere('status', '=', 'taken')
                ->join('users', 'requests.user_id', '=', 'users.id')
                ->select('requests.*', 'users.id AS userid', 'users.name', 'users.binusianid')
                ->where('requests.division_id', '=', $user_div_id)
                ->get();
            $approver = \Illuminate\Support\Facades\Auth::user()->division->approver;
        }
        else if($p == 'approver'){
            $user_id = \Illuminate\Support\Facades\Auth::user()->id;
            $data = \App\Models\Request::orderBy('id', 'desc')->where('user_id', $user_id)->get();
            $approver = null;
        }
        return [$data, $approver];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function check()
    {
        $data = Division::all();
        return view('approver/checkRequest', [
            'data' => $data,
        ]);
    }

    public function kembali(Request $request){
        $id = $request->input('request_return_id');
        $req = \App\Models\Request::find($id);
        if($req->flag_return == null){
            //balikin form utk kembaliin
            $returned = null;
        }
        else{
            //balikin form utk tampilin kembalian
            $returned = 1;
        }

        $aset = DB::table('bookings')
            ->join('assets', 'bookings.asset_id', '=', 'assets.id')
            ->join('asset_jenis', 'bookings.asset_jenis_id', '=', 'asset_jenis.id')
            ->select('bookings.id', 'assets.serial_number', 'assets.brand', 'asset_jenis.name', 'bookings.return_conditions')
            ->where('bookings.request_id', '=', $id)
            ->where('bookings.status', '=', 'approved')
            ->get();

        $current_date_time = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
        $current_date_time = $current_date_time->format('l, d M Y H:i');

        return view('kembali', [
            'returned' => $returned,
            'aset' => $aset,
            'request' => $req,
            'current_date' => $current_date_time
        ]);
    }

    public function perbaharuiReturn(Request $request){
        $id = $request->input('request_id');
        $req = \App\Models\Request::find($request->input('request_id'));
        $req->return_notes = $request->input('return_condition');
        $req->flag_return = 1;
        $req->realize_return_date = date("Y-m-d H:i:s", strtotime($request->input('realize_return_date')));
        $req->update();

        $returnApproval = $request->input('return_approval');
        $returnIds = $request->input('return_id', []);
        $message = 'Request berhasil diapprove.';

        $counting = 0;
        foreach ($returnIds as $index => $returnId) {
            if (isset($returnApproval[$index]) && $returnApproval[$index] === "1") {
                // If the checkbox is checked, mark the return as approved
                $return = \App\Models\Booking::find($returnId);
                $return->return_conditions = 'baik';
                $return->save();
            } else {
                // If the checkbox is not checked, mark the return as rejected
                $return = \App\Models\Booking::find($returnId);
                $return->return_conditions = 'tidak baik';
                $return->save();
                $counting++;
            }
        }

        $email = new SendEmailController();
        $receiver = DB::table('users')
            ->select('email')
            // ->where('division_id', '=', $req->division_id)
            ->where('role_id', 3)
            ->get();
        $receiver = $receiver[0]->email;
        $message = $req->User->name . ' mengajukan pengembalian barang.';
        $subjek = 'PENGAJUAN PENGEMBALIAN BARANG';
        $email->index($receiver, $message, $subjek);

        $history = new HistoryDetail();
        $history->user_id = \Illuminate\Support\Facades\Auth::user()->id;
        $history->aksi = \Illuminate\Support\Facades\Auth::user()->name . ' mengajukan pengembalian barang dari '.$req->nama_peminjam.'['.$req->prodi_peminjam.']'.' dengan kondisi '.$request->input('kondisi_aset').' dengan deskripsi '.$request->input('return_condition');
        $history->save();

        $history = new HistoryDetail();
        $history->user_id = \Illuminate\Support\Facades\Auth::user()->id;
        $history->aksi = \Illuminate\Support\Facades\Auth::user()->name . ' mengapprove pengembalian dari '.$req->nama_peminjam.'['.$req->prodi_peminjam.']'.' dengan pesan '.$request->input('pesan');
        $history->save();

        $req->return_notice = $request->input('isu_rusak');
        $req->status = 'done';
        $bookings = new BookingController();
        $bookings->updateReturn($id, $req->realize_return_date);

        $req->update();

        $email = new SendEmailController();
        $message = 'Selamat pengembalian anda di approve!';
        $subjek = 'PENGEMBALIAN DI APPROVE';
        $receiver = $req->email_peminjam;
        $email->indexPeminjamApprove($receiver, $message, $subjek, $req->id);

        if(\Illuminate\Support\Facades\Auth::user()->role_id == 1){
            return redirect('dashboard')->with('message', 'Peminjaman berhasil dikembalikan.');
        }else if(\Illuminate\Support\Facades\Auth::user()->role_id == 2){
            return redirect('/admin/dashboard')->with('message', 'Peminjaman berhasil dikembalikan.');
        }
    }

    public function cekPengembalian(Request $request){
        $id = $request->input('request_id');
        $req = \App\Models\Request::find($id);

        $assets = DB::table('bookings')
            ->join('assets', 'bookings.asset_id', '=', 'assets.id')
            ->join('asset_jenis', 'bookings.asset_jenis_id', '=', 'asset_jenis.id')
            ->select('assets.serial_number', 'assets.brand', 'asset_jenis.name')
            ->where('bookings.request_id', '=', $id)
            ->get();

        return view('admin.formKembali', [
            'request' => $req,
            'assets' => $assets
        ]);
    }

    public function checkTanggal(Request $request)
    {
        $req_id = $request->request_taken_id;
        $current_date_time = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
        $current_date_time = $current_date_time->format('Y-m-d H:i:s');

        $req = DB::table('requests')
            ->where('id', '=', $req_id)
            ->where('book_date', '<=', $current_date_time)
            ->get();

        $id = null;
        foreach ($req as $r){
            $id = $r->id;
        }

        if($id != null){

            $req = \App\Models\Request::find($request->request_taken_id);
            //barang bisa diambil = update bookings
            $bookings = new BookingController();
            $bookings->update($req_id);

            $email = new SendEmailController();
            $subjek = 'BARANG SUDAH DIAMBIL';
            $message = 'Pemberitahuan bahwa barang sudah anda ambil!';
            $receiver = \App\Models\Request::find($req_id);
            $receiver = $receiver->User->email;
            $email->index($receiver, $message, $subjek);

            $history = new HistoryDetail();
            $history->user_id = \Illuminate\Support\Facades\Auth::user()->id;
            $history->aksi = \Illuminate\Support\Facades\Auth::user()->name . ' memberikan barang kepada '.$req->nama_peminjam.'['.$req->prodi_peminjam.']'.' dengan tujuan '.$req->purpose;
            $history->save();

            if(\Illuminate\Support\Facades\Auth::user()->role_id == 1){
                return redirect('/dashboard')->with('message', "Barang berhasil diambil.");
            }
            return redirect('/admin/dashboard')->with('message', "Barang berhasil diambil.");
        }
        else{
            //TODO: gabisa diambil dulu = alert
            echo 'alert';
        }
    }

    public function createRequest(Request $request){
        $res = $request->input('datetimes');
        $res = explode(" - ", $res);
        $book_date = strtotime($res[0]);
        $return_date = strtotime($res[1]);

        $div_id = $request->input('division_id');

        $assets = DB::table('assets')
            ->join('asset_jenis', 'assets.asset_jenis_id', '=', 'asset_jenis.id')
            ->select('assets.*', 'asset_jenis.name')
            ->where('assets.status', 'tersedia')
            ->where('assets.division_id', '=', $div_id)
            ->orWhere('assets.status', 'dipinjam')
            ->get();

        $avail_items = array();

        foreach ($assets as $asset){
            $id = $asset->id;
            $bookings = DB::table('bookings')
                ->join('requests', 'bookings.request_id', '=', 'requests.id')
                ->select('requests.book_date', 'requests.return_date')
                ->where('bookings.asset_id', '=', $id)
                ->where('requests.status', '!=', 'rejected')
                ->where('requests.status', '!=', 'done')
                ->where('bookings.status', '!=', 'rejected')
                ->get();

            if($bookings->isEmpty()){
                array_push($avail_items, $asset);
            }
            else{
                $available = true;
                foreach ($bookings as $booking){
                    $test_book_date = strtotime($booking->book_date);
                    $test_return_date = strtotime($booking->return_date);

                    if($book_date > $test_return_date || $return_date < $test_book_date){
                        $available = true;
                    }
                    else{
                        $available = false;
                        break;
                    }
                }
                if($available){
                    array_push($avail_items, $asset);
                }
            }
        }

        return view('approver/createRequest', [
            'book_date' => $book_date,
            'return_date' => $return_date,
            'assets' => $avail_items,
            'division_id' => $div_id,
        ]);
    }

    public function create(Request $request)
    {
        $data = Location::all();
        $return_date = $request->input('return_date');
        $book_date = $request->input('book_date');
        $assets = $request->input('assets');
        $division_id = $request->input('division_id');
        $approver = User::all()->where('role_id', 3);

        return view('approver.createRequestDetail', [
            'assets' => $assets,
            'book_date' => $book_date,
            'return_date' => $return_date,
            'data' => $data,
            'division_id' => $division_id,
            'approver' => $approver
        ]);
    }

    public function confirm(Request $request){

        $assets = unserialize($request->input('assets'));
        $bookings = array();

        foreach ($assets as $i){
            $asset = DB::table('assets')
                ->join('asset_jenis', 'assets.asset_jenis_id', '=', 'asset_jenis.id')
                ->select('assets.*', 'asset_jenis.name')
                ->where('assets.id', '=', $i)
                ->get();
            foreach ($asset as $a){
                array_push($bookings, $a);
                DB::table('assets')->where('id', $a->id)->update(['status' => 'tidak tersedia']);
            }
        }

        if($request->input('lokasi') != null){
            $lokasi = $request->input('lokasi');
        }
        else if ($request->input('new-lokasi') != null){
            $lokasi = $request->input('new-lokasi');
        }
        $purpose = $request->input('purpose');
        $return_date = $request->input('return_date');
        $book_date = $request->input('book_date');
        $division_id = $request->input('division_id');
        $binusian_id_peminjam = $request->input('binusian_id_peminjam');
        $approver_id = explode('|', $request->input('approver'))[0];
        $approver = explode('|', $request->input('approver'))[1];
        $approver_division_id = explode('|', $request->input('approver'))[2];
        $nama_peminjam = $request->input('nama_peminjam');
        $prodi_peminjam = $request->input('prodi_peminjam');
        $email_peminjam = $request->input('email_peminjam');
        $nohp_peminjam = $request->input('nohp_peminjam');

        return view('approver.confirmRequest', [
            'assets' => $bookings,
            'book_date' => $book_date,
            'return_date' => $return_date,
            'purpose' => $purpose,
            'lokasi' => $lokasi,
            'division_id' => $division_id,
            'binusian_id_peminjam' => $binusian_id_peminjam,
            'approver_id' => $approver_id,
            'approver' => $approver,
            'approver_division_id' => $approver_division_id,
            'nama_peminjam' => $nama_peminjam,
            'prodi_peminjam' => $prodi_peminjam,
            'email_peminjam' => $email_peminjam,
            'nohp_peminjam' => $nohp_peminjam,
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
        $request = new \App\Models\Request();

        $request->purpose = $data['purpose'];
        $request->lokasi = $data['lokasi'];
        $request->user_id = Auth::user()->id;
        $request->division_id = $data['division_id'];
        $request->binusian_id_peminjam = $data['binusian_id_peminjam'];
        $request->approver_id = $data['approver_id'];
        $request->approver = $data['approver'];
        $request->approver_division_id = $data['approver_division_id'];
        $request->nama_peminjam = $data['nama_peminjam'];
        $request->prodi_peminjam = $data['prodi_peminjam'];
        $request->email_peminjam = $data['email_peminjam'];
        $request->nohp_peminjam = $data['nohp_peminjam'];

        $request->book_date = date("Y-m-d H:i:s", strtotime($data['book_date']));
        $request->return_date = date("Y-m-d H:i:s", strtotime($data['return_date']));

        $request->save();

        return DB::table('requests')->max('id');

//        dd($request->purpose, $request->lokasi, $request->user_id, $request->book_date, $request->return_date);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user_div_id = \Illuminate\Support\Facades\Auth::user()->division->id;
        $data = DB::table('requests')
            ->orderBy('id', 'desc')
            ->where('status', '=', 'done')
            ->orWhere('status', '=', 'rejected')
            ->join('users', 'requests.user_id', '=', 'users.id')
            ->select('requests.*', 'users.id AS userid', 'users.binusianid')
            ->where('requests.division_id', '=', $user_div_id)
            ->get();
        return view('approver.historiRequest', [
            'data' => $data
        ]);
    }

    public function showDetail()
    {
        $data = HistoryDetail::where('user_id',auth()->user()->id)->get();
        return view('approver.historiDetail', [
            'data' => $data
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
     * update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perbaharui(Request $request)
    {
        var_dump($request->request_perbaharui_id);
        $user = $request->input('user');
        $req = \App\Models\Request::find($request->request_perbaharui_id);

        if($request->request_perbaharui == 'rejected'){
            $req->status = $request->request_perbaharui;
            $req->notes = $request->input('pesan') . "<br>";
            $req->update();
            $message = 'Request berhasil ditolak.';

            $subyek = 'PEMINJAMAN REJECTED';
            $pesan = 'Mohon maaf, peminjaman anda tidak disetujui oleh approver. Silahkan pilih tanggal lain untuk meminjam.';
            $receiver = $req->email_peminjam;
            $history = new HistoryDetail();
            $history->user_id = \Illuminate\Support\Facades\Auth::user()->id;
            $history->aksi = \Illuminate\Support\Facades\Auth::user()->name . ' menolak peminjaman dari '.$req->nama_peminjam.'['.$req->prodi_peminjam.']'.' dengan tujuan '.$req->purpose.' dengan alasan '.$request->input('pesan');
            $history->save();

            $email = new SendEmailController();
            $email->indexPeminjam($receiver, $pesan, $subyek);
        }
        else if ($request->request_perbaharui == 'approved'){
            $bookingApproval = $request->input('booking_approval', []);

            // Check if at least one checkbox is checked
            if (count($bookingApproval) === 0) {
                return redirect()->back()->withErrors(['error' => 'Please select at least one item to approve.']);
            }

            $bookingApproval = $request->input('booking_approval');
            $bookingIds = $request->input('booking_id', []);
            $message = 'Request berhasil diapprove.';

            $counting = 0;
            foreach ($bookingIds as $index => $bookingId) {
                if (isset($bookingApproval[$index]) && $bookingApproval[$index] === "1") {
                    // If the checkbox is checked, mark the booking as approved
                    $booking = \App\Models\Booking::find($bookingId);
                    $booking->status = 'approved';
                    $booking->save();
                } else {
                    // If the checkbox is not checked, mark the booking as rejected
                    $booking = \App\Models\Booking::find($bookingId);
                    $booking->status = 'rejected';
                    $booking->save();
                    $counting++;
                }
            }

            if($counting == 0) {
                $req->track_approver = $req->track_approver++;
                $req->notes = $req->notes . "<br>" . $request->input('pesan');
                $approver = $request->approver_num;

                $req->status = $request->request_perbaharui;

                $subyek = 'PEMINJAMAN APPROVED';
                $pesan = 'Selamat peminjaman anda berhasil di approve! silakan menghubungi staff ' . \App\Models\Division::find($req->division_id)->name .  ' untuk pengambilan barang sesuai dengan tanggal peminjaman';
                $pesan_bm = 'Peminjaman barang oleh <b>' . $req->email_peminjam . '</b> berhasil di approve.';
                $receiver = $req->email_peminjam;
                $email = new SendEmailController();
                // $email->index("bmopr.bdg@binus.edu", $pesan_bm , $subyek);
                $email->indexPeminjamApprove($receiver, $pesan, $subyek, $req->id);

                $req->update();

                $history = new HistoryDetail();
                $history->user_id = \Illuminate\Support\Facades\Auth::user()->id;
                $history->aksi = \Illuminate\Support\Facades\Auth::user()->name . ' menyetujui peminjaman dari '.$req->nama_peminjam.'['.$req->prodi_peminjam.']'.' dengan tujuan '.$req->purpose.' dengan alasan '.$request->input('pesan');
                $history->save();
            }else{
                $req->track_approver = $req->track_approver++;
                $req->notes = $req->notes . "<br>" . $request->input('pesan');
                $approver = $request->approver_num;

                $req->status = "waiting next approval";

                $subyek = 'PEMINJAMAN PENDING';
                $pesan = "<b>Berikut approval rincian barang yang anda pinjam: </b><br><br>";
                foreach ($bookingIds as $index => $bookingId) {
                    $booking = \App\Models\Booking::find($bookingId);
                    $barang = \App\Models\Asset::find($booking->asset_id);
                    $pesan .= "- <b>" . $barang->serial_number . '</b> dengan spesifikasi <b>' . $barang->brand . '</b> dengan status <b>' . $booking->status . "</b><br>";
                }

                // Continue with the rest of the message
                $pesan .= "<br>" . 'Apabila anda tetap akan melakukan peminjaman barang yang approve harap mengirimkan email lanjutan kepada approver <b>' . $req->approver . '</b> ('. \App\Models\User::find($req->approver_id)->email .')';
                $receiver = $req->email_peminjam;
                $email = new SendEmailController();
                // $email->index("bmopr.bdg@binus.edu", $pesan_bm , $subyek);
                $email->indexPeminjam($receiver, $pesan, $subyek);

                $req->update();
            }

        }else if ($request->request_perbaharui == 'approved sebagian'){
            $message = 'Request berhasil diapprove.';

            $req->track_approver = $req->track_approver+1;
            $req->notes = $req->notes . "<br>" . $request->input('pesan');
            $approver = $request->approver_num;

            $req->status = $request->request_perbaharui;

            $subyek = 'PEMINJAMAN APPROVED';
            $pesan = 'Selamat peminjaman anda berhasil di approve! silahkan ambil barang sesuai dengan tanggal peminjaman.';
            $pesan_bm = 'Peminjaman barang oleh ' . $req->email_peminjam . ' berhasil di approve.';
            $receiver = $req->email_peminjam;
            $email = new SendEmailController();
            // $email->index("bmopr.bdg@binus.edu", $pesan_bm , $subyek);
            $email->indexPeminjamApprove($receiver, $pesan, $subyek, $req->id);

            $req->update();

        }

        // DONE: ini kembali ke dashboard/approvernya gimana
        if(Auth::user()->role_id == 1){
            return redirect('/dashboard')->with('message', $message);
        }
        return redirect('/'. $user . '/dashboard')->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $id)
    {
//        DONE: ini gimana yak delete requestny pas cancel?
        $request = \App\Models\Request::find($id->request_delete_id);
        if($request->status == 'waiting approval'){

            $bookings = new BookingController();
            $bookings->destroy($id->request_delete_id);

            $request->delete();
            $message = 'Request peminjaman berhasil dihapus';
        }
        else{
            $message = 'Request peminjaman tidak bisa dicancel karena sudah diapprove admin.';
        }
        return redirect('/dashboard')->with('message', $message);
    }



}
