<?php

namespace App\Http\Middleware;

use Closure;

class TelefonoMiddleware
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
        if(auth()->user()->telefono)
            return $next($request);

        $notificacion= "Es necesario asociar un numero de telefono para registrar citas";
            
        return redirect('/perfil')->with(compact('notificacion'));
    }
}
