<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckSuperadmin
{
    /**
     * Handle an incoming request.
     *
     * This middleware ensures that only users with the 'superadmin' role can access a route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if a user is authenticated AND if that user's role is 'superadmin'.
        // This is more direct than checking Auth::check() and then Auth::user() separately.
        if (Auth::user()?->role === 'superadmin') {
            // If yes, allow the request to proceed.
            return $next($request);
        }

        // If the user is not authenticated or not a superadmin,
        // deny access with a "403 Forbidden" error.
        abort(403, 'Unauthorized action.');
    }
}