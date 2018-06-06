<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Prologue\Alerts\Facades\Alert;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            if (Auth::guard($guard)->user()->role_id!=1) {
                Auth::logout();
                Alert::error("Permission Denied.")->flash();
//                flash()->error("Permission Denied.");
                return redirect()->guest(config('backpack.base.route_prefix', 'admin') . '/login');
            }
            if ($request->path() == config('backpack.base.route_prefix', 'admin').'/login') {
                return redirect()->guest(config('backpack.base.route_prefix', 'admin') . '/dashboard');
            }
        } else {
            if ($request->path() != config('backpack.base.route_prefix', 'admin').'/login') {
                Alert::error("Permission Denied.")->flash();
                return redirect()->guest(config('backpack.base.route_prefix', 'admin') . '/login');
            }
        }

        return $next($request);
    }
}
