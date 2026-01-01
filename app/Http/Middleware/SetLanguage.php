<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App; // <-- ይህች መስመር መኖሯን አረጋግጥ!

class SetLanguage
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('locale')) {
            // አሁን App በትክክል ይታወቃል
            App::setLocale(session()->get('locale'));
        }
        
        return $next($request);
    }
}