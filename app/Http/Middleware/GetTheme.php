<?php

namespace App\Http\Middleware;

// use View;
use Closure;
use Auth;
use App\Util\HelperUtil;

class GetTheme 
{
    public function handle($request, Closure $next)
    {
    	if (Auth::user() && Auth::user()->perfil_id == 2){

	        $settings = HelperUtil::broker_setting();
	        $settings->font_color_primary = isset($settings->font_color_primary) ? $settings->font_color_primary : '';
	        $settings->font_color_secondary = isset($settings->font_color_secondary) ? $settings->font_color_secondary : '';
	        view()->share('themeSettings', $settings);

    	}else
    	{
    		$settings = HelperUtil::broker_setting_using_domain($request);
    		if($settings){
		        $settings->font_color_primary = isset($settings->font_color_primary) ? $settings->font_color_primary : '';
		        $settings->font_color_secondary = isset($settings->font_color_secondary) ? $settings->font_color_secondary : '';
		        view()->share('themeSettings', $settings);
		    }else{
		    	abort(404);
		    }
    	}
        return $next($request);
    }
    
}
