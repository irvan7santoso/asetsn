<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Cek apakah user sudah login dan apakah role-nya admin
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }
        
        // Jika bukan admin, arahkan ke halaman lain (misalnya dashboard)
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
