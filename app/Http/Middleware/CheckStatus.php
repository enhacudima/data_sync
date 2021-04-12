<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckStatus
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

        $response = $next($request);
        //If the status is not approved redirect to login
        if(Auth::guard('api')->check() && Auth::guard('api')->user()->status != '1'){
            Auth::logout();
            return response()->json(
                ['error' => 'You must be active to login.'], 422);
        }
        return $response;
    }
}
