<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use Auth;
use App\CV;

class CheckChefe
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

        if(Auth::check() && Auth::user()->type == '3'){

            $chefe = CV::where('user_id',Auth::user()->id)->first();
            
            if(!isset($chefe)){
                return response()->json(['error'=>'Please create your cv','id'=>Auth::user()->id,'description' => 'You can create your cv.' ,'message'=>'Chefe CV', 'url' => 'email/resend', 'button' => 'Create CV' ], 403);
            }


        }
        return $response;
    }
}
