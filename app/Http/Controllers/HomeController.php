<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\RolePageMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){

        $user_role_name = auth()->user()->role->name;
        if($user_role_name == 'superadmin'){
            return redirect('superadmin/dashboard');
        }
        elseif ($user_role_name == 'admin'){
            return redirect('admin/dashboard');
        }
        elseif ($user_role_name == 'approver'){
            return redirect('approver/dashboard');
        }
        else{
            return redirect('dashboard');
        }

    }

    public function dashboard()
    {
        $view = new RequestController();
        list($data, $approver) = $view->index();
        return view('home', [
            'data' => $data,
            'approver' => $approver
        ]);
    }

    public function adminDashboard(){
        $view = new RequestController();
        list($data, $approver) = $view->index();
        return view('admin.home', [
            'data' => $data,
            'approver' => $approver
        ]);
    }

    public function approverDashboard(){
        $view = new RequestController();
        list($data, $approver) = $view->index();
        return view('approver.home', [
            'data' => $data,
            'approver' => $approver
        ]);
    }

    public function superadminDashboard(){
        $view = new UserController();
        $data = $view->index();
        return view('superadmin.home', [
            'data' => $data
        ]);
    }
}
