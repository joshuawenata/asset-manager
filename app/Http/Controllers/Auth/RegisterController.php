<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'binusianid' => ['required', 'string', 'min:11'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function show(Request $request){

        $role_id = $request->input('role_id');
        //staff
        if($role_id == 2){
            $data = Division::all();
        }
        //student
        else if($role_id == 1){
            $data = Division::where('role_id', 1)->get();
        }

        return view('auth.registerDetail', [
            'data' => $data,
            'role_id' => $role_id
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $mail = explode('@', $data['email']);
        $role = $data['role_id'];

        //HELP ini TODO bedain page student regist & login
        if($mail[1] == 'binus.edu'){
            if($role == 2){
                return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'binusianid' => $data['binusianid'],
                    'address' => $data['address'],
                    'phone' => $data['phone'],
                    'division_id' => $data['division_id'],
                    'role_id' => $role,
                    'password' => Hash::make($data['password']),
                ]);
            }
        }
        else if($mail[1] == 'binus.ac.id'){
            if($role == 1){
                return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'binusianid' => $data['binusianid'],
                    'address' => $data['address'],
                    'phone' => $data['phone'],
                    'division_id' => $data['division_id'],
                    'role_id' => $role,
                    'password' => Hash::make($data['password']),
                ]);
            }
        }
    }
}
