<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // return $next($request);
        $user = Auth::user();

        if ($user && in_array($user->role, $roles)) {
            return $next($request);
        }

        // Cek apakah request berasal dari AJAX
        if ($request->ajax()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        } else {
            // Kembalikan tampilan error sebagai Response
            return response()->view('errors.403', [], 403); // Ganti dengan view yang sesuai

        }
    }
}