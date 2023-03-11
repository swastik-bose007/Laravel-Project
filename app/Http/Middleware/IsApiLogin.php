<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsApiLogin {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        if(Auth::guard('api')->check()) :
            return $next($request);
        else:
            $response = [
                'status'        => false,
                'status_code'   => 401,
                'message'       => "Authentication error.",
                'data'          => [],
                'request_data'  => $request->all()
            ];
    
            return response()->json($response);
        endif;
    }

}
