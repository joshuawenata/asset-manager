<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\User;
use App\Models\RolePageMapping;
use App\Models\HistoryAddAsset;
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

        for($i = 1; $i <= 4; $i++){
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

                return redirect($p);
            }
        }

    }

    public function validateUser(int $page_id){
        $user_role_id = auth()->user()->role->id;
        $role = RolePageMapping::where('role_id', $user_role_id)->where('page_id', $page_id)->get();

        return $role;
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

    public function historyAddAsset(){
        $data = historyAddAsset::where('user_id',auth()->user()->id)->get();
        return view('historyAddAsset', [
            'data' => $data
        ]);
    }
}
