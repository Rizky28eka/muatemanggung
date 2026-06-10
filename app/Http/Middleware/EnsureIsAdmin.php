<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) {
            return redirect('/admin/login')->with('error', 'Silakan login sebagai admin.');
        }

        return $next($request);
    }
}
