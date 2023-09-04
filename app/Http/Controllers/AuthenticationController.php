<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticationController extends Controller
{
    public function checkrole(Request $request){
        $role_id = $request->input('role_id');
        $users = User::where('email', $request->input('email'))->first(); 

        if ($role_id == 1) { 
            if($users->isStaff){
                $users->role_id = 1;
                $users->save();
                return redirect()->route('logindetail');
            }else {
                Auth::logout();
                session()->flush();
                return redirect('/')->with('error', 'Invalid credentials');
            }
        }else if ($role_id == 2) {
            if($users->isAdmin){
                $users->role_id = 2;
                $users->save();
                return redirect()->route('logindetail');
            }else {
                Auth::logout();
                session()->flush();
                return redirect('/')->with('error', 'Invalid credentials');
            }
        }else if ($role_id == 3) {
            if($users->isApprover){
                $users->role_id = 3;
                $users->save();
                return redirect()->route('logindetail');
            }else {
                Auth::logout();
                session()->flush();
                return redirect('/')->with('error', 'Invalid credentials');
            }
        }else if ($role_id == 4) {
            return redirect()->route('logindetail');
        }else {
            Auth::logout();
            session()->flush();
            return redirect('/')->with('error', 'Invalid credentials');
        }

    }

    public function logindetail(Request $request){
        return view('auth.login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $users = User::where('email', $request->input('email'))->first(); 

        if($users){
            $role_id = $users->role_id;
        }else{
            Auth::logout();
            session()->flush();
            return redirect('/')->with('error', 'Invalid credentials');
        }

        if(Auth::attempt($credentials) && $role_id == 4){
            return redirect()->route('superadmin.dashboard');
        }else if ($role_id == 1) { 
            if(Auth::attempt($credentials)){
                return redirect()->route('dashboard');
            }else {
                Auth::logout();
                session()->flush();
                return redirect('/')->with('error', 'Invalid credentials');
            }
        }else if ($role_id == 2) {
            if(Auth::attempt($credentials)){
                return redirect()->route('admin.dashboard');
            }else {
                Auth::logout();
                session()->flush();
                return redirect('/')->with('error', 'Invalid credentials');
            }
        }else if ($role_id == 3) {
            if(Auth::attempt($credentials)){
                return redirect()->route('approver.dashboard');
            }else {
                Auth::logout();
                session()->flush();
                return redirect('/')->with('error', 'Invalid credentials');
            }
        }else {
            Auth::logout();
            session()->flush();
            return redirect('/')->with('error', 'Invalid credentials');
        }

    }

    public function logout(){
        Auth::logout();
        session()->flush();
        return redirect('/');
    }

}
