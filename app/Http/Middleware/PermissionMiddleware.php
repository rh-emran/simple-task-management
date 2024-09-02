<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        // Check if the user has all the required permissions
        // foreach ($permissions as $permission) {
        //     if (!auth()->user()->hasPermission($permission)) {
        //         return abort(401);
        //     }
        // }

        if (!auth()->check() || !auth()->user()->hasAnyPermission($permissions)) {
            // Redirect or abort with a 403 error if the user lacks any of the required permissions
            return abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
