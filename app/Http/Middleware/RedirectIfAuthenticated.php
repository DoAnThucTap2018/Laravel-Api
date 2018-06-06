<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            if ($request->path() == config('backpack.base.route_prefix', 'admin') . '/login') {
                return redirect()->guest(config('backpack.base.route_prefix', 'admin') . '/dashboard');
            }
        }
        return $next($request);
    }
}
