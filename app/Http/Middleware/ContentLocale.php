<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentLocale
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->isMethod('GET')) return $next($request);
        $request->validate(['locale' => 'sometimes|in:id,en']);
        $previous = app()->getLocale();
        app()->setLocale($request->query('locale', 'id'));
        try {
            $response = $next($request);
            $response->headers->set('Content-Language', app()->getLocale());
            return $response;
        } finally {
            app()->setLocale($previous);
        }
    }
}
