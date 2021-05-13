<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App;

class SetLocaleDynamically
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
        $locale='en';
        if (Auth::guard('api')->check()) {
            $locale = Auth::guard('api')->user()->locale;
        }
        if ($locale == 'pt'){
            $locale = 'pt_BR';
        }
        app()->setLocale($locale);

        return $next($request);
    }
}
