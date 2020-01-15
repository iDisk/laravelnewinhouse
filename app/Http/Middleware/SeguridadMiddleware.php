<?php

namespace App\Http\Middleware;

use Closure;
use App\Support\Util;
use Auth;
use Log;

class SeguridadMiddleware
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
        //Obtener rutas validas desde la sesion
        $rutas = session('menusValidos');
        
        $user = auth()->user();

        if($user && $user->isActive)
        {
            if($rutas->search($request->path()))
            {
                return $next($request);            
            }else{
                return redirect('error');
            }   
        }else{
            
            return redirect('error');
        }

        
    }
}
