<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {

        if (Auth::check()) {
            $userRoles = Auth::user()->roles->pluck('name')->toArray();

            foreach ($roles as $role) {
                if (in_array($role, $userRoles)) {
                    return $next($request);
                }
            }
        }
        return redirect('/');
    }
}
