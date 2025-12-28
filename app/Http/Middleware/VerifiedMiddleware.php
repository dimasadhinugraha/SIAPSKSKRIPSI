<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Skip verification for RT and RW roles
        if (in_array($user->role, ['rt', 'rw', 'admin'])) {
            return $next($request);
        }

        // Check email verification
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        // Check admin approval
        if (isset($user->is_approved) && !$user->is_approved) {
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
