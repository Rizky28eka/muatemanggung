@extends('layouts.app')

@section('title', 'Daftar Kemitraan MUA — MUA Temanggung')

@section('content')
<div class="relative overflow-hidden bg-slate-50 py-16 min-h-[85vh] flex items-center justify-center">
    <!-- Glows -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-[10%] left-[10%] w-[400px] h-[400px] rounded-full bg-primary/5 blur-[100px]"></div>
        <div class="absolute bottom-[10%] right-[10%] w-[400px] h-[400px] rounded-full bg-accent/5 blur-[100px]"></div>
    </div>

    <div class="max-w-[540px] w-full mx-auto px-4 relative z-10">
        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl p-8 space-y-6">
            
            <!-- Header -->
            <div class="text-center space-y-2">
                <span class="text-[10px] font-mono uppercase tracking-[0.2em] text-accent">Kemitraan Baru</span>
                <h2 class="text-2xl font-display font-extrabold text-ink">Registrasi Pengelola MUA</h2>
                <p class="text-xs text-muted">Daftarkan profil bisnis MUA Anda untuk bergabung dalam sistem rekomendasi.</p>
            </div>

            <!-- Errors -->
            @if($errors->any())
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-800 text-xs space-y-1 text-left">
                    @foreach($errors->all() as $error)
                        <p class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            {{ $error }}
                        </p>
                    @endforeach
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('mua.register.process') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Section 1: Akun User -->
                <div class="space-y-3">
                    <div class="border-b border-hairline pb-1 text-left">
                        <h3 class="text-xs font-mono uppercase tracking-wider text-[#6E7191]">1. Informasi Akun Pengguna</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5 text-left">
                            <label for="name" class="text-xs font-bold text-ink">Nama Pengelola</label>
                            <input id="name" 
                                   type="text" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   placeholder="Nama Lengkap"
                                   class="w-full px-4 py-3 rounded-xl border border-hairline text-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 bg-slate-50/50 @error('name') border-rose-500 @enderror">
                            @error('name')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-1.5 text-left">
                            <label for="email" class="text-xs font-bold text-ink">Alamat Email</label>
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   placeholder="nama@email.com"
                                   class="w-full px-4 py-3 rounded-xl border border-hairline text-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 bg-slate-50/50 @error('email') border-rose-500 @enderror">
                            @error('email')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5 text-left" x-data="{ show: false }">
                            <label for="password" class="text-xs font-bold text-ink">Password</label>
                            <div class="relative">
                                <input id="password" 
                                       :type="show ? 'text' : 'password'" 
                                       name="password" 
                                       required 
                                       placeholder="Minimal 8 karakter"
                                       class="w-full pl-4 pr-10 py-3 rounded-xl border border-hairline text-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 bg-slate-50/50 @error('password') border-rose-500 @enderror">
                                <button type="button" 
                                        @click="show = !show" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-muted hover:text-ink focus:outline-none">
                                    <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!show">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="show" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-1.5 text-left" x-data="{ show: false }">
                            <label for="password_confirmation" class="text-xs font-bold text-ink">Konfirmasi Password</label>
                            <div class="relative">
                                <input id="password_confirmation" 
                                       :type="show ? 'text' : 'password'" 
                                       name="password_confirmation" 
                                       required 
                                       placeholder="Ketik ulang password"
                                       class="w-full pl-4 pr-10 py-3 rounded-xl border border-hairline text-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 bg-slate-50/50">
                                <button type="button" 
                                        @click="show = !show" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-muted hover:text-ink focus:outline-none">
                                    <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!show">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="show" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Info MUA -->
                <div class="space-y-3 pt-2">
                    <div class="border-b border-hairline pb-1 text-left">
                        <h3 class="text-xs font-mono uppercase tracking-wider text-[#6E7191]">2. Informasi Bisnis MUA</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5 text-left">
                            <label for="mua_name" class="text-xs font-bold text-ink">Nama MUA / Salon</label>
                            <input id="mua_name" 
                                   type="text" 
                                   name="mua_name" 
                                   value="{{ old('mua_name') }}" 
                                   required 
                                   placeholder="Contoh: Zahra MUA"
                                   class="w-full px-4 py-3 rounded-xl border border-hairline text-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 bg-slate-50/50 @error('mua_name') border-rose-500 @enderror">
                            @error('mua_name')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-1.5 text-left">
                            <label for="district_id" class="text-xs font-bold text-ink">Kecamatan Domisili</label>
                            <select id="district_id" 
                                    name="district_id" 
                                    required 
                                    class="w-full px-4 py-3 rounded-xl border border-hairline text-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 bg-slate-50/50 @error('district_id') border-rose-500 @enderror">
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>Kec. {{ $district->name }}</option>
                                @endforeach
                            </select>
                            @error('district_id')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5 text-left">
                            <label for="whatsapp_number" class="text-xs font-bold text-ink">Nomor WhatsApp</label>
                            <input id="whatsapp_number" 
                                   type="text" 
                                   name="whatsapp_number" 
                                   value="{{ old('whatsapp_number') }}" 
                                   required 
                                   placeholder="Contoh: 08123456789"
                                   class="w-full px-4 py-3 rounded-xl border border-hairline text-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 bg-slate-50/50 @error('whatsapp_number') border-rose-500 @enderror">
                            @error('whatsapp_number')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="space-y-1.5 text-left">
                            <label for="instagram_username" class="text-xs font-bold text-ink">Username Instagram</label>
                            <input id="instagram_username" 
                                   type="text" 
                                   name="instagram_username" 
                                   value="{{ old('instagram_username') }}" 
                                   placeholder="Contoh: zahra.makeup"
                                   class="w-full px-4 py-3 rounded-xl border border-hairline text-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 bg-slate-50/50 @error('instagram_username') border-rose-500 @enderror">
                            @error('instagram_username')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full py-3.5 rounded-full bg-gradient-to-r from-primary to-accent hover:from-primary-active hover:to-accent-active text-white text-xs font-bold shadow-md shadow-primary/10 transition-all duration-200 active:scale-95 active:translate-y-0.5 mt-4">
                    Kirim Permohonan Registrasi
                </button>
            </form>

            <!-- Login redirect -->
            <div class="pt-4 border-t border-hairline text-center">
                <p class="text-xs text-muted">
                    Sudah memiliki akun pengelola?
                </p>
                <a href="{{ route('mua.login') }}" 
                   class="inline-block mt-2 text-xs font-bold text-primary hover:text-primary-active transition-colors">
                    Masuk Portal MUA ➜
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
