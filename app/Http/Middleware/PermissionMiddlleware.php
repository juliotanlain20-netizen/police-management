<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddlleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
       
        $user = $request->user();
        if (!$user) {
            abort(403, 'kamu harus login');
        }
        if (!$user->hasPermission($permission)) {
            abort(403, 'kamu tidak memiliki permission untuk melakukan aksi ini');
        }
        return $next($request);
    }
}
