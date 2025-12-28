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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Skip verification check for RT, RW, and admin roles
        if (!in_array($user->role, ['rt', 'rw', 'admin'])) {
            // Check if user's email is verified
            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }
            
            // Check if user is approved by admin
            if (isset($user->is_approved) && !$user->is_approved) {
                return redirect()->route('verification.notice');
            }
        }

        // Check if user has required role
        if (!empty($roles) && !in_array($user->role, $roles)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
