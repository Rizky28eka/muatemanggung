@extends('layouts.app')

@section('title', 'Login Portal Pengelola & Admin — MUA Temanggung')

@section('content')
<div class="relative overflow-hidden bg-slate-50 py-16 min-h-[80vh] flex items-center justify-center">
    <!-- Glows -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-[10%] left-[20%] w-[300px] h-[300px] rounded-full bg-primary/10 blur-[80px]"></div>
        <div class="absolute bottom-[10%] right-[20%] w-[300px] h-[300px] rounded-full bg-accent/10 blur-[80px]"></div>
    </div>

    <div class="max-w-[420px] w-full mx-auto px-4 relative z-10">
        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl p-8 space-y-6">
            
            <!-- Header -->
            <div class="text-center space-y-2">
                <span class="text-[10px] font-mono uppercase tracking-[0.2em] text-primary">Portal Akses</span>
                <h2 class="text-2xl font-display font-extrabold text-ink">Login Pengguna</h2>
                <p class="text-xs text-muted">Portal masuk terpadu untuk Mitra MUA dan Administrator.</p>
            </div>

            <!-- Session Status / Errors -->
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-xs leading-relaxed">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-800 text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <p class="flex items-center gap-1.5 text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 flex-shrink-0"></span>
                            <span>{{ $error }}</span>
                        </p>
                    @endforeach
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div class="space-y-1.5 text-left">
                    <label for="email" class="text-xs font-bold text-ink">Alamat Email</label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           placeholder="nama@email.com"
                           class="w-full px-4 py-3 rounded-xl border border-hairline text-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 bg-slate-50/50 @error('email') border-rose-500 @enderror">
                    @error('email')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-1.5 text-left" x-data="{ showPassword: false }">
                    <div class="flex justify-between items-center">
                        <label for="password" class="text-xs font-bold text-ink">Password</label>
                        <a href="#" class="text-[10px] text-primary hover:underline font-semibold">Lupa Password?</a>
                    </div>
                    <div class="relative">
                        <input id="password" 
                               :type="showPassword ? 'text' : 'password'" 
                               name="password" 
                               required 
                               placeholder="••••••••"
                               class="w-full pl-4 pr-10 py-3 rounded-xl border border-hairline text-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 bg-slate-50/50 @error('password') border-rose-500 @enderror">
                        <button type="button" 
                                @click="showPassword = !showPassword" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-muted hover:text-ink focus:outline-none">
                            <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!showPassword">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="showPassword" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center text-left">
                    <input id="remember_me" 
                           type="checkbox" 
                           name="remember" 
                           class="w-4 h-4 text-primary border-hairline rounded focus:ring-primary/20">
                    <label for="remember_me" class="ml-2 text-[11px] text-muted font-medium">Ingat saya di perangkat ini</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full py-3 rounded-full bg-primary hover:bg-primary-active text-white text-xs font-bold shadow-md shadow-primary/10 transition-all duration-200 active:scale-95 active:translate-y-0.5 mt-2">
                    Masuk
                </button>
            </form>

            <!-- Registration trigger -->
            <div class="pt-4 border-t border-hairline text-center">
                <p class="text-xs text-muted">
                    Belum mendaftarkan usaha MUA Anda?
                </p>
                <a href="{{ route('mua.register') }}" 
                   class="inline-block mt-2 text-xs font-bold text-primary hover:text-primary-active transition-colors">
                    Daftar Mitra MUA Baru ➜
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
