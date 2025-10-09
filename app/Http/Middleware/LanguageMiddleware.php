<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the locale from the request header or session
        $locale = $request->header('Accept-Language');
        
        if (!$locale) {
            $locale = Session::get('locale', config('app.locale'));
        }

        // Validate if the locale is in the available locales
        $availableLocales = array_keys(config('app.available_locales'));
        if (in_array($locale, $availableLocales)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            // Fallback to default locale if not supported
            App::setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
