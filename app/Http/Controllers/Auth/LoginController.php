<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RolePageMapping;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))){


            for($i = 1; $i <= 5; $i++){
                $res = $this->validateUser($i);
                if($res->count()){
                    foreach ($res as $r){
                        $role = $r->role_id;
                    }

                    $pages = DB::table('role_page_mappings')
                        ->join('pages', 'role_page_mappings.page_id', '=', 'pages.id')
                        ->select('pages.name')
                        ->where('role_id', $role)
                        ->where('page_id', $i)
                        ->get();

                    foreach ($pages as $page){
                        $p = $page->name;
                    }

                    return redirect()->route($p);
                }
            }

        }
        else{
            return redirect()->route('login')->with('error', 'Email-Address And Password Are Wrong.');
        }
    }

    public function validateUser(int $page_id){
        $user_role_id = auth()->user()->role->id;
        $role = RolePageMapping::where('role_id', $user_role_id)->where('page_id', $page_id)->get();

        return $role;
    }
}
