<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsBazarmandiLogout {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        if(Auth::guard('bazarmandi')->check()) :
            return redirect('bazarmandi/dashboard');
        else:
            return $next($request);
        endif;
    }

}
