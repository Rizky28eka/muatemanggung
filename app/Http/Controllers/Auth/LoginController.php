<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            if (auth()->user()->isMua()) {
                return redirect()->route('mua.dashboard');
            }
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = auth()->user();

            if ($user->isAdmin()) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }

            if ($user->isMua()) {
                if (!$user->is_active) {
                    Auth::logout();
                    return back()
                        ->withErrors(['email' => 'Akun Anda belum aktif. Hubungi admin.'])
                        ->withInput($request->only('email'));
                }

                $request->session()->regenerate();
                return redirect()->intended(route('mua.dashboard'));
            }

            // Unknown role fallback
            Auth::logout();
            return back()->withErrors(['email' => 'Peran pengguna tidak dikenali.']);
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

        return redirect()->route('login');
    }
}
