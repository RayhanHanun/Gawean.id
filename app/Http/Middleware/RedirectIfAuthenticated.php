<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'hrd' => redirect()->route('hrd.dashboard'),
                'pelamar' => redirect()->route('pelamar.dashboard'),
                default => redirect()->route('home')
            };
        }

        return $next($request);
    }
}
