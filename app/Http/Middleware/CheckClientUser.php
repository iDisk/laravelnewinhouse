<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckClientUser
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

        if (Auth::user() && Auth::user()->perfil_id == 2) {
            $user = auth()->user();
            $path = $request->getPathInfo();
            if($path != '/user/change-password')
            {
                if(!$user->password_changed)
                {
                    return redirect()->route('change_password');
                }
            }
            return $next($request);
        }else{
            return redirect()->route('client_login');
        }
        abort(404);
    }
}
