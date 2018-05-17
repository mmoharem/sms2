<?php

namespace App\Http\Middleware;

use Closure;

class Language
{
    public function handle($request, Closure $next)
    {
        if (session()->has('applocale') && array_key_exists(session('applocale'), config('languages'))) {
            app()->setLocale(session('applocale'));
        }
        else { // This is optional as Laravel will automatically set the fallback language if there is none specified
            app()->setLocale(session('app.fallback_locale'));
        }
        return $next($request);
    }
}