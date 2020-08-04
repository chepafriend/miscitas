<?php

namespace App\Http\Middleware;

use Closure;

class DoctorMiddleware
{
  
    public function handle($request, Closure $next)
    {
        if(auth()->user()->rol=='doctor')
        return $next($request);
        
    return redirect('/');
    }
}
