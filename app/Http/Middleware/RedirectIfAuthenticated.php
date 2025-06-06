<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // return redirect(RouteServiceProvider::HOME);
                $user = Auth::guard($guard)->user();
                // Redirect berdasarkan role user
                switch ($user->role) {
                    case 'petugas_emis':
                        return redirect()->route('main.dashboard-ppdb.index');
                    case 'petugas_ppdb':
                        return redirect()->route('ppdb.index');
                    case 'kepsek':
                    case 'petugas_pembayaran':
                    case 'bendahara':
                    case 'developer':
                        return redirect()->route('main.dashboard.index');
                    default:
                        return redirect('/'); // Fallback jika role tidak dikenali
                }
            }
        }

        return $next($request);
    }
}
