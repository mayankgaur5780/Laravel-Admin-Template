<?php

namespace App\Http\Middleware;

use Closure;

class DetectAdminLocale
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
        if (!(\Session::has('admin_lang') && in_array(\Session::get('admin_lang'), getLocales()))) {
            $locale = 'ar';
            \Session::put('admin_lang', 'ar');
        } else {
            $locale = \Session::get('admin_lang');
        }

        \App::setLocale($locale);
        return $next($request);
    }
}
