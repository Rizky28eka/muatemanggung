<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureIsMua
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check() || ! auth()->user()->isMua()) {
            return redirect('/mua/login')->with('error', 'Silakan login sebagai pengelola MUA.');
        }

        if (! auth()->user()->is_active) {
            auth()->logout();
            $request->session()->invalidate();
            return redirect('/mua/login')->with('error', 'Akun Anda belum aktif. Hubungi admin.');
        }

        return $next($request);
    }
}
