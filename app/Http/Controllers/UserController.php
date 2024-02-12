<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Role;
use App\Models\User;
use App\Models\HistoryAkun;
use App\Models\HistoryDetail;
use App\Models\HistoryAddAsset;
use App\Models\HistoryUpdateAsset;
use App\Models\DeletedAsset;
use App\Models\RepairAsset;
use App\Models\AssetLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::whereIn('role_id', [1, 2, 3])->get();
        return $data;
    }

    public function historySuperadmin()
    {
        $data = HistoryAkun::all();
        return view('superadmin.historyAkun', [
            'data' => $data
        ]);
    }

    public function historyStaff($id)
    {
        $dataHistoryAddAsset = HistoryAddAsset::where('user_id',$id)->get();
        $data = HistoryDetail::where('user_id',$id)->get();
        return view('superadmin.historyAkunStaff', [
            'dataHistoryAddAsset' => $dataHistoryAddAsset,
            'data' => $data
        ]);
    }

    public function historyAdmin($id)
    {
        $dataHistoryAddAsset = HistoryAddAsset::where('user_id',$id)->get();
        $dataHistoryPemusnahanBarang = DeletedAsset::where('user_id',$id)->get();
        $dataHistoryPembaharuanBarang = HistoryUpdateAsset::where('id_pengubah',$id)->get();
        $dataHistoryPemindahanBarang = AssetLocation::where('responsible_id',$id)->get();
        $dataHistoryBarangRusak = RepairAsset::where('reported_by_id',$id)->get();
        $dataHistoryPerbaikanBarang = RepairAsset::where('reported_by_id',$id)->get();
        $data = HistoryDetail::where('user_id',$id)->get();
        $user = User::where('id',$id)->get();
        $division = Division::where('id',$user[0]['division_id'])->get('name')[0]['name'];
        return view('superadmin.historyAkunAdmin', [
            'dataHistoryAddAsset' => $dataHistoryAddAsset,
            'dataHistoryPemusnahanBarang' => $dataHistoryPemusnahanBarang,
            'dataHistoryPembaharuanBarang' => $dataHistoryPembaharuanBarang,
            'dataHistoryPemindahanBarang' => $dataHistoryPemindahanBarang,
            'dataHistoryBarangRusak' => $dataHistoryBarangRusak,
            'dataHistoryPerbaikanBarang' => $dataHistoryPerbaikanBarang,
            'data' => $data,
            'user' => $user,
            'division' => $division
        ]);
    }

    public function historyApprover($id)
    {
        $data = DB::table('requests')
            ->orderBy('id', 'desc')
            ->where('status', '=', 'done')
            ->orWhere('status', '=', 'rejected')
            ->join('users', 'requests.user_id', '=', 'users.id')
            ->select('requests.*', 'users.id AS userid', 'users.name', 'users.binusianid')
            ->where('requests.approver_id', '=', $id)
            ->get();
        return view('superadmin.historyAkunApprover', [
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
        //
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
        $data = User::find($id);
        $dept = Division::all();
        $isStaff = $data->isStaff;
        $isAdmin = $data->isAdmin;
        $isApprover = $data->isApprover;

        return View::make('superadmin.editUser', [
            'data' => $data,
            'dept' => $dept,
            'isStaff' => $isStaff,
            'isAdmin' => $isAdmin,
            'isApprover' => $isApprover,
        ]);
    }

    public function editActive($id)
    {
        $user = User::find($id);
        if($user->active_status==1){
            $user->active_status = 2;
            $history = new HistoryAkun;
            $history->aksi = 'superadmin menonaktifkan akun '.Role::where('id',$user->role_id)->pluck('name')[0].' dengan data nama: '.$user->name.', binusian_id: '.$user->binusianid.', phone: '.$user->phone.', departemen: '.Division::where('id',$user->division_id)->pluck('name')[0].', email: '.$user->email;
            $history->save();
        }else{
            $user->active_status = 1;
            $history = new HistoryAkun;
            $history->aksi = 'superadmin mengaktifkan akun '.Role::where('id',$user->role_id)->pluck('name')[0].' dengan data nama: '.$user->name.', binusian_id: '.$user->binusianid.', phone: '.$user->phone.', departemen: '.Division::where('id',$user->division_id)->pluck('name')[0].', email: '.$user->email;
            $history->save();
        }
        $user->update();

        return redirect('superadmin/dashboard');
    }

    /**
     * update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perbaharui(Request $request, $id)
    {
        $selectedRoles = $request->input('role', []); // Retrieve the selected roles as an array.

        // You can then check which roles are selected by checking if their values are in the array.
        $isStaffSelected = in_array('1', $selectedRoles);
        $isAdminSelected = in_array('2', $selectedRoles);
        $isApproverSelected = in_array('3', $selectedRoles);

        $user = User::find($id);
        $history = new HistoryAkun;
        $history->aksi = 'superadmin mengupdate akun '.Role::where('id',$user->role_id)->pluck('name')[0].' dengan data nama: '.$user->name.', binusian_id: '.$user->binusianid.', phone: '.$user->phone.', departemen: '.Division::where('id',$user->division_id)->pluck('name')[0].', email: '.$user->email.' menjadi '.'departemen baru: '.Division::where('id',$request->input('department'))->pluck('name')[0].', '.'role baru: '.Role::where('id',$request->input('role'))->pluck('name')[0].', '.'email baru: '.$request->input('email');
        $history->save();
        $user->name = $request->input('name');
        $user->division_id = $request->input('department');
        $user->binusianid = $request->input('binusianid');
        $user->phone = $request->input('phone');
        $user->role_id = $isStaffSelected ? 1 : ($isAdminSelected ? 2 : 3);
        $user->email = $request->input('email');
        $user->isStaff = $isStaffSelected ? 1 : 0;
        $user->isAdmin = $isAdminSelected ? 1 : 0;
        $user->isApprover = $isApproverSelected ? 1 : 0;
        $user->update();
        return redirect('superadmin/dashboard')->with('message', 'Data User Berhasil Diupdate');
    }

    public function reset(Request $request)
    {
        $user = User::find($request->user_reset_id);
        $user->password = Hash::make('B1nu$-' . $user->binusianid);
        $history = new HistoryAkun;
        $history->aksi = 'superadmin mereset password akun '.Role::where('id',$user->role_id)->pluck('name')[0].' dengan data nama: '.$user->name.', binusian_id: '.$user->binusianid.', phone: '.$user->phone.', departemen: '.Division::where('id',$user->division_id)->pluck('name')[0].', email: '.$user->email;
        $history->save();
        $user->update();
        return redirect('superadmin/dashboard')->with('message', 'Data User Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->user_delete_id);
        $history = new HistoryAkun;
        $history->aksi = 'superadmin menghapus akun '.Role::where('id',$user->role_id)->pluck('name')[0].' dengan data nama: '.$user->name.', binusian_id: '.$user->binusianid.', phone: '.$user->phone.', departemen: '.Division::where('id',$user->division_id)->pluck('name')[0].', email: '.$user->email;
        $history->save();
        $user->delete();
        return redirect('superadmin/dashboard')->with('message', 'User Berhasil Dihapus');
    }
}
