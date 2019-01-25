<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()) {// check user is logged in
            if(Auth::user()->isAdmin()) { //check user is admin or superuser
                return $next($request);
            } else {
                // return redirect(404);
                return redirect('/');
            }
        }
    }
}
