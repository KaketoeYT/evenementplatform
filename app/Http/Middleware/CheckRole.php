<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response //...$roles maakt van admin:admin,worker een array ['admin', 'worker']
    {
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) { //heeft foutmeldingen maar werkt wel?
            return abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
