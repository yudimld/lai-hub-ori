<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $roles)
    {
        if (Auth::check()) {
            $userRole = Auth::user()->role;

            // Jika user memiliki salah satu role yang diizinkan
            $allowedRoles = explode('|', $roles);
            if (in_array($userRole, $allowedRoles)) {
                return $next($request);
            }
        }

        // Redirect jika tidak memiliki izin
        return redirect('/')->with('error', 'Unauthorized access.');
    }
}
