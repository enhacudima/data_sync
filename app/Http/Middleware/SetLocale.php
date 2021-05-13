<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public $locale= 'en';
    public function handle($request, Closure $next)
    {
        if (Auth::guard('api')->check()) {
            $this->locale = Auth::guard('api')->user()->locale;
        }
        if ($this->locale == 'pt'){
            $this->locale = 'pt_BR';
        }
        app()->setLocale($this->locale);
        return $next($request);
    }
}
