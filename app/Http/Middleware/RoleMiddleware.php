<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($request->user() && $request->user()->hasRole($role)) {
            // If authenticated and has the required role, proceed with the request
            return $next($request);
        }
        // If not authenticated or does not have the required role, handle the error
        // For example, redirect to the home page with an error message
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
}
