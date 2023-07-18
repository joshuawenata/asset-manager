<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Role;
use App\Models\User;
use App\Models\HistoryAkun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all()->diff(User::whereIn('role_id', [1, 4])->get());
        return $data;
    }

    public function historySuperadmin()
    {
        $data = HistoryAkun::all();
        return view('superadmin.historyAkun', [
            'data' => $data
        ]);
    }

    public function historyStaff()
    {
        $data = HistoryAkun::all();
        return view('superadmin.historyAkunStaff', [
            'data' => $data
        ]);
    }

    public function historyAdmin()
    {
        $data = HistoryAkun::all();
        return view('superadmin.historyAkunAdmin', [
            'data' => $data
        ]);
    }

    public function historyApprover()
    {
        $data = HistoryAkun::all();
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
        $roles = Role::all()->except([1, 5]);
        $dept = Division::all();
        return View::make('superadmin.editUser', [
            'data' => $data,
            'roles' => $roles,
            'dept' => $dept
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $history = new HistoryAkun;
        $history->aksi = 'superadmin mengupdate akun '.Role::where('id',$user->role_id)->pluck('name')[0].' dengan data nama: '.$user->name.', binusian_id: '.$user->binusianid.', phone: '.$user->phone.', departemen: '.Division::where('id',$user->division_id)->pluck('name')[0].', email: '.$user->email.' menjadi '.'departemen baru: '.Division::where('id',$request->input('department'))->pluck('name')[0].', '.'role baru: '.Role::where('id',$request->input('role'))->pluck('name')[0].', '.'email baru: '.$request->input('email');
        $history->save();
        $user->division_id = $request->input('department');
        $user->role_id = $request->input('role');
        $user->email = $request->input('email');
        $user->update();
        return redirect('superadmin/dashboard')->with('message', 'Data User Berhasil Diperbaharui');
    }

    public function reset(Request $request)
    {
        $user = User::find($request->user_reset_id);
        $user->password = Hash::make('B1nu$-' . $user->binusianid);
        $history = new HistoryAkun;
        $history->aksi = 'superadmin mereset password akun '.Role::where('id',$user->role_id)->pluck('name')[0].' dengan data nama: '.$user->name.', binusian_id: '.$user->binusianid.', phone: '.$user->phone.', departemen: '.Division::where('id',$user->division_id)->pluck('name')[0].', email: '.$user->email;
        $history->save();
        $user->update();
        return redirect('superadmin/dashboard')->with('message', 'Data User Berhasil Diperbaharui');
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
