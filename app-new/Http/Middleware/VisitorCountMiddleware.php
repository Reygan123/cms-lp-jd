<?php

namespace App\Http\Middleware;

use App\Models\VisitorCount;
use Closure;
use Illuminate\Http\Request;

class VisitorCountMiddleware
{
    public function handle($request, Closure $next)
    {
        $ipAddress = $request->ip();

        $visitorCount = VisitorCount::first();
        if ($visitorCount) {
            $visitorCount->count++;
            $visitorCount->save();
        } else {
            VisitorCount::create(['count' => 1]);
        }

        return $next($request);
    }
}
