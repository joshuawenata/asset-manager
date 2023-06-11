<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Role;
use App\Models\User;
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
        $data = User::all()->diff(User::whereIn('role_id', [1, 5])->get());
        return $data;
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
        }else{
            $user->active_status = 1;
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
        $user->delete();
        return redirect('superadmin/dashboard')->with('message', 'User Berhasil Dihapus');
    }
}
