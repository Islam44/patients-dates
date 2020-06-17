<?php

namespace App\Http\Middleware;

use App\Sd;
use Closure;

class IsPatient
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
        if(auth()->user()->hasType(Sd::$userRole)) {
            return $next($request);
        }
        return redirect('/')->with('message','You Dont Has Permission To Access This URl');
    }
}
