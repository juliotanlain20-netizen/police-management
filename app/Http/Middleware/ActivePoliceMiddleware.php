<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivePoliceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(401, 'Unauthenticated');
        }

        // Admin boleh bypass
        $isAdmin = $user->roles()
            ->where('roles.name', 'admin')
            ->exists();

        if ($isAdmin) {
            return $next($request);
        }

        $officer = $user->officer;

        if (!$officer) {
            abort(403, 'User bukan Police Officer');
        }

        if ($officer->status !== 'Active') {
            abort(403, 'Police Officer sudah tidak aktif');
        }

        return $next($request);
    }
}
