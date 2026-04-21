<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next,  ...$roles): Response //...$roles maakt van admin:admin,worker een array ['admin', 'worker']
    {
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            return abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
