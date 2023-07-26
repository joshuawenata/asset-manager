<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
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
            ->where('status', '=', 'waiting approval')
            ->where('requests.return_date', '<=', $current_date_time)
            ->update(['status' => 'rejected']);

        $p = Auth::user()->role->name;

        if($p == 'staff'){
            $user_div_id = \Illuminate\Support\Facades\Auth::user()->division_id;
            $data = DB::table('requests')
                ->orderBy('id', 'asc')
                ->where('requests.track_approver', '=', 0)
                ->where('requests.division_id', '=', $user_div_id)
                ->where('status', '=', 'waiting approval')
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
        return view('approver/checkRequest');
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
            ->join('asset_categories', 'bookings.asset_category_id', '=', 'asset_categories.id')
            ->select('assets.serial_number', 'assets.brand', 'asset_categories.name')
            ->where('bookings.request_id', '=', $id)
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

    public function updateReturn(Request $request){
        $req = \App\Models\Request::find($request->input('request_id'));
        $req->return_status = $request->input('kondisi_aset');
        $req->return_notes = $request->input('return_condition');
        $req->flag_return = 1;
        $req->realize_return_date = date("Y-m-d H:i:s", strtotime($request->input('realize_return_date')));
        $req->update();

        $email = new SendEmailController();
        $receiver = DB::table('users')
            ->select('email')
            // ->where('division_id', '=', $req->division_id)
            ->where('role_id', 3)
            ->get();
        $receiver = $receiver[0]->email;
        $message = $req->User->name . ' mengajukan pengembalian barang.';;
        $subjek = 'PENGAJUAN PENGEMBALIAN BARANG';
        $email->index($receiver, $message, $subjek);

        return redirect('/dashboard')->with('message', 'Berhasil mengajukan pengembalian.');
    }

    public function cekPengembalian(Request $request){
        $id = $request->input('request_id');
        $req = \App\Models\Request::find($id);

        $assets = DB::table('bookings')
            ->join('assets', 'bookings.asset_id', '=', 'assets.id')
            ->join('asset_categories', 'bookings.asset_category_id', '=', 'asset_categories.id')
            ->select('assets.serial_number', 'assets.brand', 'asset_categories.name')
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
            //barang bisa diambil = update bookings
            $bookings = new BookingController();
            $bookings->update($req_id);

            $email = new SendEmailController();
            $subjek = 'BARANG SUDAH DIAMBIL';
            $message = 'Pemberitahuan bahwa barang sudah anda ambil!';
            $receiver = \App\Models\Request::find($req_id);
            $receiver = $receiver->User->email;
            $email->index($receiver, $message, $subjek);

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
            ->join('asset_categories', 'assets.asset_category_id', '=', 'asset_categories.id')
            ->select('assets.*', 'asset_categories.name')
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
                ->join('asset_categories', 'assets.asset_category_id', '=', 'asset_categories.id')
                ->select('assets.*', 'asset_categories.name')
                ->where('assets.id', '=', $i)
                ->get();
            foreach ($asset as $a){
                array_push($bookings, $a);
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
            ->select('requests.*', 'users.id AS userid', 'users.name', 'users.binusianid')
            ->where('requests.division_id', '=', $user_div_id)
            ->get();
        return view('admin.historiRequest', [
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->input('user');
        $req = \App\Models\Request::find($request->request_update_id);

        if($request->request_update == 'rejected'){
            $req->status = $request->request_update;
            $req->notes = $request->input('pesan') . "\n";
            $req->update();
            $message = 'Request berhasil ditolak.';

            $subyek = 'PEMINJAMAN REJECTED';
            $pesan = 'Mohon maaf, peminjaman anda tidak disetujui oleh approver. Silahkan pilih tanggal lain untuk meminjam.';
            $receiver = $req->email_peminjam;
        }
        else if ($request->request_update == 'approved'){
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
                $req->notes = $req->notes . "\n" . $request->input('pesan');
                $approver = $request->approver_num;

                $req->status = $request->request_update;

                $subyek = 'PEMINJAMAN APPROVED';
                $pesan = 'Selamat peminjaman anda berhasil di approve! silahkan ambil barang sesuai dengan tanggal peminjaman.';
                $pesan_bm = 'Peminjaman barang oleh ' . $req->email_peminjam . ' berhasil di approve.';
                $receiver = $req->email_peminjam;
                $email = new SendEmailController();
                // $email->index("bmopr.bdg@binus.edu", $pesan_bm , $subyek);

                $req->update();
            }else{
                $req->track_approver = $req->track_approver++;
                $req->notes = $req->notes . "\n" . $request->input('pesan');
                $approver = $request->approver_num;

                $req->status = "waiting approval lanjutan";

                $subyek = 'PEMINJAMAN PENDING';
                $pesan = 'Peminjaman anda hanya di approve sebagian! apabila jadi melakukan peminjaman harap mengirimkan email lanjutan kepada ';
                $receiver = $req->email_peminjam;
                $email = new SendEmailController();
                // $email->index("bmopr.bdg@binus.edu", $pesan_bm , $subyek);

                $req->update();
            }

        }else if ($request->request_update == 'approved all'){
            $message = 'Request berhasil diapprove.';

            $req->track_approver = $req->track_approver+1;
            $req->notes = $req->notes . "\n" . $request->input('pesan');
            $approver = $request->approver_num;

            $req->status = $request->request_update;

            $subyek = 'PEMINJAMAN APPROVED';
            $pesan = 'Selamat peminjaman anda berhasil di approve! silahkan ambil barang sesuai dengan tanggal peminjaman.';
            $pesan_bm = 'Peminjaman barang oleh ' . $req->email_peminjam . ' berhasil di approve.';
            $receiver = $req->email_peminjam;
            $email = new SendEmailController();
            // $email->index("bmopr.bdg@binus.edu", $pesan_bm , $subyek);

            $req->update();

        }

        $email = new SendEmailController();
        $email->index($receiver, $pesan, $subyek);

        //DONE: ini kembali ke dashboard/approvernya gimana
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

    public function approvePengembalian(Request $request){
        $id = $request->input('request_return_id');
        $req = \App\Models\Request::find($id);

        $req->return_notice = $request->input('isu_rusak');
        $req->status = 'done';
        $bookings = new BookingController();
        $bookings->updateReturn($id, $req->realize_return_date);

        $req->update();

        $email = new SendEmailController();
        $message = 'Selamat pengembalian anda di approve!';
        $subjek = 'PENGEMBALIAN DI APPROVE';
        $receiver = $req->User->email;
        $email->index($receiver, $message, $subjek);

        return redirect('requests-history')->with('message', 'Peminjaman berhasil dikembalikan.');
    }

    public function rejectPengembalian(Request $request){
        $id = $request->input('request_return_id');
        $req = \App\Models\Request::find($id);

        $req->return_notice = $request->input('pesan') . "\n";
        $req->flag_return = null;
        $req->realize_return_date = null;
        $req->update();

        $email = new SendEmailController();
        $message = 'Mohon maaf pengembalian anda di reject silahkan isi kembali!';
        $subjek = 'PENGEMBALIAN DI REJECT';
        $receiver = $req->User->email;
        $email->index($receiver, $message, $subjek);

        return redirect('admin/dashboard')->with('message', 'Pengembalian berhasil ditolak.');
    }
}
