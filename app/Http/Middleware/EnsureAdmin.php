<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Pārbauda, vai lietotājs ir administrators, un bloķē piekļuvi, ja nav.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ja lietotājs nav autentificēts vai nav admins, atgriež 403.
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403);
        }

        // Lietotājs ir admins, turpinām pieprasījuma apstrādi.
        return $next($request);
    }
}
