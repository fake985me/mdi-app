<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = Session::get('language', $request->header('Accept-Language', 'en'));
        
        // Ensure the locale is in our supported languages
        $supportedLocales = ['en', 'id'];
        $locale = in_array($locale, $supportedLocales) ? $locale : 'en';
        
        App::setLocale($locale);

        return $next($request);
    }
}