<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use Auth;

class UserType
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
        
        if(Auth::check() && Auth::user()->type == null){

            return response()->json(
                ['error' => 'Contact the administrator about user type'], 422);
        }

        return $next($request);
    }
}
