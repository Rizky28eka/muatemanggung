<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Temukan Make Up Artist (MUA) terbaik di Kabupaten Temanggung menggunakan sistem rekomendasi cerdas berbasis preferensi Anda. Akad, Resepsi, Wisuda, Tari, dan lainnya.">
    <meta name="keywords" content="MUA Temanggung, Make Up Artist Temanggung, Rekomendasi MUA, MUA Terbaik Temanggung, Jasa Makeup Temanggung">
    <meta name="author" content="MUA Temanggung">
    <title>@yield('title', 'Sistem Rekomendasi MUA Temanggung — Temukan MUA Impian Anda')</title>
    
    <!-- Vite Assets (Tailwind CSS v4 & JS/Alpine/AOS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6, .font-display {
            font-family: 'Outfit', sans-serif;
        }
        .glow-accent {
            text-shadow: 0 0 20px rgba(16, 185, 129, 0.4);
        }
        .glow-primary {
            text-shadow: 0 0 20px rgba(124, 58, 237, 0.4);
        }
    </style>
</head>
<body class="bg-slate-50 text-body antialiased min-h-screen flex flex-col">

    <!-- Header / Navigation (Floating Pill Layout with scroll and load animations) -->
    <div class="sticky top-0 z-50 w-full px-4 sm:px-6 lg:px-8 transition-all duration-500 pointer-events-none"
         x-data="{ mobileMenuOpen: false, scrolled: false, loaded: false }"
         x-init="setTimeout(() => loaded = true, 50)"
         @scroll.window="scrolled = window.scrollY > 30"
         :class="scrolled ? 'pt-2' : 'pt-4'">
        <header class="max-w-7xl mx-auto w-full bg-white/80 backdrop-blur-md border border-slate-200/50 shadow-lg shadow-primary/5 pointer-events-auto transform transition-all duration-500"
                :class="[
                    mobileMenuOpen ? 'rounded-3xl' : 'rounded-full',
                    scrolled ? 'shadow-md shadow-primary/10 border-slate-200/80 max-w-5xl scale-[0.98] bg-white/95 px-4' : 'shadow-lg shadow-primary/5 border-slate-200/50 px-6',
                    loaded ? 'translate-y-0 opacity-100' : '-translate-y-12 opacity-0'
                ]">
            <div class="flex items-center justify-between transition-all duration-500"
                 :class="scrolled ? 'h-13' : 'h-16'">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <img src="{{ asset('images/logo.png') }}" class="w-8 h-8 object-contain group-hover:scale-105 transition-transform duration-300" alt="MUA Temanggung Logo">
                        <div class="flex flex-col">
                            <span class="font-display font-extrabold text-sm leading-none text-ink tracking-tight">
                                MUA<span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">Temanggung</span>
                            </span>
                            <span class="text-[8px] text-muted tracking-wider uppercase font-semibold">Sistem Rekomendasi</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Nav (Tabbed pill hover effects) -->
                <nav class="hidden md:flex items-center gap-1.5">
                    <a href="{{ route('home') }}" class="text-xs font-semibold px-3 py-1.5 rounded-full text-ink hover:bg-slate-100/50 hover:text-primary transition-all duration-200">Beranda</a>
                    <a href="#cara-kerja" class="text-xs font-semibold px-3 py-1.5 rounded-full text-muted hover:bg-slate-100/50 hover:text-primary transition-all duration-200">Cara Kerja</a>
                    <a href="#featured-mua" class="text-xs font-semibold px-3 py-1.5 rounded-full text-muted hover:bg-slate-100/50 hover:text-primary transition-all duration-200">MUA Terpopuler</a>
                    <a href="#testimoni" class="text-xs font-semibold px-3 py-1.5 rounded-full text-muted hover:bg-slate-100/50 hover:text-primary transition-all duration-200">Testimoni</a>
                </nav>

                <!-- Action CTA & Portal shortcut -->
                <div class="hidden md:flex items-center gap-3">
                    <a href="/mua/login" class="text-xs font-semibold text-muted hover:text-primary transition-colors">Portal MUA</a>
                    <span class="h-4 w-px bg-slate-200"></span>
                    <a href="{{ route('recommendation.form') }}" 
                       class="inline-flex items-center justify-center px-4.5 py-2 rounded-full bg-gradient-to-r from-primary to-accent hover:from-primary-active hover:to-accent-active text-white text-xs font-bold shadow-md shadow-primary/10 transition-all duration-200 active:scale-95 active:translate-y-0.5">
                        Cari Rekomendasi
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex md:hidden">
                    <button type="button" 
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="inline-flex items-center justify-center p-1.5 rounded-full text-muted hover:text-ink hover:bg-slate-100 transition-colors"
                            aria-controls="mobile-menu" 
                            aria-expanded="false">
                        <span class="sr-only">Buka menu utama</span>
                        <svg class="h-5 w-5" x-show="!mobileMenuOpen" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="h-5 w-5" x-show="mobileMenuOpen" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="md:hidden border-t border-slate-100 bg-white/95 backdrop-blur-md rounded-2xl mt-2 py-4 px-2 space-y-2" 
                 id="mobile-menu"
                 x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 style="display: none;">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-primary bg-primary-soft">Beranda</a>
                <a href="#cara-kerja" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-xl text-sm font-medium text-muted hover:text-ink hover:bg-slate-50">Cara Kerja</a>
                <a href="#featured-mua" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-xl text-sm font-medium text-muted hover:text-ink hover:bg-slate-50">MUA Terpopuler</a>
                <a href="#testimoni" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-xl text-sm font-medium text-muted hover:text-ink hover:bg-slate-50">Testimoni</a>
                <a href="/mua/login" class="block px-3 py-2 rounded-xl text-sm font-medium text-muted hover:text-ink hover:bg-slate-50">Portal MUA</a>
                <div class="pt-2 border-t border-slate-100">
                    <a href="{{ route('recommendation.form') }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2.5 rounded-full bg-gradient-to-r from-primary to-accent text-white text-xs font-bold shadow shadow-primary/10">
                        Cari Rekomendasi MUA
                    </a>
                </div>
            </div>
        </header>
    </div>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    @if(!Route::is('login') && !Route::is('mua.register') && !Route::is('mua.login') && !Route::is('admin.login'))
    <!-- Footer -->
    <footer class="bg-surface-dark text-on-dark pt-16 pb-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- Branding Info -->
                <div class="md:col-span-2 space-y-6">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" class="w-10 h-10 object-contain" alt="MUA Temanggung Logo">
                        <span class="font-display font-extrabold text-xl leading-none text-white tracking-tight">
                            MUA<span class="text-accent">Temanggung</span>
                        </span>
                    </a>
                    <p class="text-on-dark-soft type-body-sm max-w-[360px]">
                        Menghubungkan Anda dengan Make Up Artist (MUA) profesional terbaik di Kabupaten Temanggung menggunakan sistem pencocokan berbasis algoritma Cosine Similarity yang cerdas.
                    </p>
                    <!-- Badges -->
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1.5 rounded-lg bg-slate-800 text-[11px] font-semibold text-accent border border-slate-700/60 uppercase tracking-wider">Temanggung-based</span>
                        <span class="px-3 py-1.5 rounded-lg bg-slate-800 text-[11px] font-semibold text-primary border border-slate-700/60 uppercase tracking-wider">Cosine Similarity</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="space-y-4">
                    <h3 class="font-display font-bold text-white text-sm uppercase tracking-wider">Navigasi</h3>
                    <ul class="space-y-2.5 text-on-dark-soft text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-accent transition-colors">Beranda</a></li>
                        <li><a href="#cara-kerja" class="hover:text-accent transition-colors">Cara Kerja</a></li>
                        <li><a href="#featured-mua" class="hover:text-accent transition-colors">MUA Terpopuler</a></li>
                        <li><a href="{{ route('recommendation.form') }}" class="hover:text-accent transition-colors">Cari Rekomendasi</a></li>
                    </ul>
                </div>

                <!-- Contact & Access Info -->
                <div class="space-y-4">
                    <h3 class="font-display font-bold text-white text-sm uppercase tracking-wider">Akses Cepat</h3>
                    <ul class="space-y-2.5 text-on-dark-soft text-sm">
                        <li><a href="/mua/login" class="hover:text-accent transition-colors">Login Pengelola MUA</a></li>
                        <li><a href="/admin/login" class="hover:text-accent transition-colors">Portal Admin</a></li>
                        <li class="pt-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>support@muatemanggung.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Line -->
            <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-on-dark-soft">
                <p>&copy; {{ date('Y') }} MUA Temanggung. Hak Cipta Dilindungi. Dikembangkan untuk MUA Kabupaten Temanggung.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>
    @endif

</body>
</html>
