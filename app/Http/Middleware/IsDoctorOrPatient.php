<?php

namespace App\Http\Middleware;

use App\Sd;
use Closure;

class IsDoctorOrPatient
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
        if ($request->user() && ($request->user()->hasType(Sd::$doctorRole) ||$request->user()->hasType(Sd::$userRole))){
            return $next($request);
        }
        return Response(view('error')->with(['message' => 'You Dont Has Permission To Access This URl', 'code' => 403]));
    }
}
