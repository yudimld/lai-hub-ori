<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Debugging: Cek nilai role yang dikirim ke middleware
        dd($roles, Auth::user()->role); 
    
        if (!Auth::check()) {
            return redirect('/login');
        }
    
        $userRole = Auth::user()->role;
    
        if (empty($roles)) {
            return $next($request);
        }
    
        foreach ($roles as $role) {
            if (str_starts_with($role, '!') && $userRole === ltrim($role, '!')) {
                abort(403, 'Forbidden');
            }
        }
    
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized');
        }
    
        return $next($request);
    }
    
}
