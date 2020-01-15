<?php

namespace App\Http\Middleware;

use Closure;
use App;

class IdiomaMiddleware
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
        $lang = session('language');
         if($lang == null){
             $lang = App::getLocale();
             session(['language' => $lang]);
         }
         App::setLocale($lang);
        return $next($request);
    }
}
