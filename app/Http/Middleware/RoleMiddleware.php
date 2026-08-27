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
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();
        $hasRole= $user->roles()->whereIn('roles.name', $roles)->exists();
        if(!$hasRole){
            abort(403,'kamu tidak memiliki role yang di perlukan');
        }
        return $next($request);

    }
}
