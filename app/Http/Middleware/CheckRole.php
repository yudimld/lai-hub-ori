<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $userRole = Auth::user()->role;
    
        // Jika ada pengecualian role (dimulai dengan "!")
        $excludedRoles = array_filter($roles, fn($role) => str_starts_with($role, '!'));
        foreach ($excludedRoles as $excludedRole) {
            $role = ltrim($excludedRole, '!');
            if ($userRole === $role) {
                abort(403, 'Forbidden'); // Role yang dikecualikan
            }
        }
    
        return $next($request);
    }
    
    
    
}
