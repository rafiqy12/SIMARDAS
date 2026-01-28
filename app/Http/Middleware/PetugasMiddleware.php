<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PetugasMiddleware
{
    /**
     * Handle an incoming request.
     * User dengan role Admin atau Petugas yang bisa akses.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login.page')->with('error', 'Silakan login terlebih dahulu.');
        }

        $allowedRoles = ['Admin', 'Petugas', 'Petugas Arsip'];
        
        if (!in_array(Auth::user()->role, $allowedRoles)) {
            return redirect()->route('home.page')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
