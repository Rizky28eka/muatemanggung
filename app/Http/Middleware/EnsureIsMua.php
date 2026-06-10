<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureIsMua
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (! auth()->user()->isMua()) {
            abort(403, 'Access denied. MUA role required.');
        }

        if (! auth()->user()->is_active) {
            auth()->logout();
            $request->session()->invalidate();
            return redirect()->route('login')->with('error', 'Akun Anda belum aktif. Hubungi admin.');
        }

        return $next($request);
    }
}
