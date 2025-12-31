<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class lang
{

    public function handle($request, Closure $next)
    {
        Config::set('auth.defaults.guard', 'api');
        if(request()->header('Accept-Language')){
            $lang = request()->header('Accept-Language');
             if(in_array($lang,["ar","en"])){
                 app()->setlocale($lang);
                 return $next($request);
             }
        }
        app()->setlocale('ar');
        return $next($request);
    }

}
