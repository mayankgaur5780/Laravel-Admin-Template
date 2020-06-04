<?php

namespace App\Http\Controllers;

class WebController extends Controller
{
    protected $locale;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->locale = getCustomSessionLang();
            return $next($request);
        });
    }
}
