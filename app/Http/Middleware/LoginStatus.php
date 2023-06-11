<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Providers\RouteServiceProvider;

class LoginStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = DB::table('users')->where('email',$request->email)->first();
        if (!$user || !property_exists($user, 'active_status') || $user->active_status == 2) {
            abort(403, 'AKUN TIDAK AKTIF SILAKAN MENGHUBUNGI ext. 7826');
        }
        return $next($request);
    }
}
