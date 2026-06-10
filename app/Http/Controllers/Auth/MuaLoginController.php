<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MuaLoginController extends Controller
{
    public function showLogin()
    {
        if (auth()->check() && auth()->user()->isMua()) {
            return redirect()->route('mua.dashboard');
        }

        return view('auth.mua-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(array_merge($credentials, ['role' => 'mua']))) {
            $user = auth()->user();

            if (! $user->is_active) {
                Auth::logout();
                return back()
                    ->withErrors(['email' => 'Akun Anda belum aktif. Hubungi admin.'])
                    ->withInput($request->only('email'));
            }

            $request->session()->regenerate();
            return redirect()->intended(route('mua.dashboard'));
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/mua/login');
    }
}
