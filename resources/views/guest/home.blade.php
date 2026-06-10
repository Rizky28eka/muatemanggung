@extends('layouts.app')

@section('title', 'MUA Temanggung — Temukan MUA Impian Anda')

@section('content')
<!-- Design Read: Reading this as: landing page for MUA customers and service providers in Temanggung, with a pitch-style minimalist dark and slide-forward visual language, leaning toward purple & mint accents, customized layouts, and polished typography. -->

<!-- Hero Section -->
<div class="relative overflow-hidden bg-slate-50 pt-16 pb-20 border-b border-hairline min-h-[90vh] flex items-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Column: Copy -->
            <div class="lg:col-span-6 space-y-6 text-left" data-aos="fade-right">
                <span class="text-[11px] font-mono uppercase tracking-[0.22em] text-primary">Sistem Rekomendasi</span>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-extrabold tracking-tight text-ink leading-[1.08]">
                    Temukan MUA Terbaik Anda.
                </h1>
                
                <p class="text-base md:text-lg text-muted max-w-[45ch] leading-relaxed">
                    Cari, bandingkan, dan hubungi Make Up Artist di Kabupaten Temanggung menggunakan sistem rekomendasi Cosine Similarity secara instan.
                </p>
                
                <div class="flex items-center gap-4 pt-2">
                    <a href="{{ route('recommendation.form') }}" 
                       class="inline-flex items-center justify-center px-6 py-3.5 rounded-full bg-primary hover:bg-primary-active text-white text-sm font-bold shadow-lg shadow-primary/20 transition-all duration-200 active:scale-95 active:translate-y-0.5">
                        Cari Rekomendasi MUA
                    </a>
                    <a href="#featured-mua" 
                       class="inline-flex items-center justify-center px-6 py-3.5 rounded-full bg-white border border-hairline hover:border-primary text-ink hover:text-primary text-sm font-semibold transition-all duration-200 active:scale-95 active:translate-y-0.5">
                        Lihat Semua Profil
                    </a>
                </div>
            </div>
            
            <!-- Right Column: Pitch Editor Mockup -->
            <div class="lg:col-span-6" data-aos="fade-left">
                <!-- Pitch Editor Canvas container -->
                <div class="w-full aspect-[16/11] rounded-2xl bg-[#13111C] p-4 border border-[#2C293A] shadow-2xl relative flex flex-col justify-between overflow-hidden">
                    
                    <!-- Editor Chrome Top Bar -->
                    <div class="flex items-center justify-between pb-3 border-b border-[#2C293A] text-[10px] font-mono text-[#6E7191]">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500/80"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-yellow-500/80"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500/80"></span>
                            <span class="ml-2 font-semibold">mua_curator_canvas.pitch</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-2 py-0.5 rounded bg-[#1A1825] text-accent font-bold">LIVE CO-EDIT</span>
                            <div class="flex -space-x-1">
                                <span class="w-4.5 h-4.5 rounded-full bg-primary flex items-center justify-center text-[7px] text-white font-bold border border-[#13111C]">K</span>
                                <span class="w-4.5 h-4.5 rounded-full bg-accent flex items-center justify-center text-[7px] text-white font-bold border border-[#13111C]">M</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Editor Workspace: Slide Hero (Centered White Slide Canvas) -->
                    <div class="flex-grow flex items-center justify-center p-3 relative">
                        
                        <!-- Slide Canvas (16:9) -->
                        <div class="w-full aspect-[16/9] rounded-xl bg-white p-4 shadow-xl border border-white/20 relative flex flex-col justify-between overflow-hidden">
                            <!-- Slide Header -->
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="text-[8px] font-bold text-primary uppercase tracking-widest leading-none">Rekomendasi Teratas</span>
                                    <h3 class="text-sm font-display font-extrabold text-ink leading-tight">Zahra MUA</h3>
                                </div>
                                <span class="text-[9px] font-bold text-accent bg-accent-soft px-2 py-0.5 rounded-full">96.3% Match</span>
                            </div>
                            
                            <!-- Slide Body: Makeup Sample and specs -->
                            <div class="grid grid-cols-12 gap-3 items-center flex-grow py-2">
                                <div class="col-span-5 aspect-square rounded-lg bg-slate-100 overflow-hidden relative border border-hairline">
                                    <img src="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=300&fit=crop&q=80" class="w-full h-full object-cover" alt="Makeup Look">
                                </div>
                                <div class="col-span-7 space-y-1 text-left">
                                    <p class="text-[9px] font-semibold text-ink">Spesialisasi: <span class="text-primary">Akad & Resepsi</span></p>
                                    <p class="text-[8px] text-muted leading-relaxed">
                                        Look makeup soft & natural, free transport radius 30km Temanggung.
                                    </p>
                                    <div class="flex flex-wrap gap-1 pt-1">
                                        <span class="text-[7px] px-1 py-0.2 rounded font-semibold bg-accent-soft text-accent">Soft Look</span>
                                        <span class="text-[7px] px-1 py-0.2 rounded font-semibold bg-primary-soft text-primary">Natural</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Slide Footer -->
                            <div class="flex justify-between items-center border-t border-hairline pt-2 text-[8px] text-muted">
                                <span>📍 Kec. Temanggung</span>
                                <span class="font-bold text-ink">Mulai Rp 1.500.000</span>
                            </div>
                        </div>
                        
                        <!-- Pointers overlays (Collaborative live cursors) -->
                        <div class="absolute top-[35%] right-[25%] flex items-center gap-1 pointer-events-none">
                            <svg class="w-3.5 h-3.5 text-primary drop-shadow" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4 0l16 12.22-8.55 1.56 4.8 9.38-3.57 1.83-4.74-9.43-4.04 3.75z"/>
                            </svg>
                            <span class="px-2 py-0.5 rounded-md bg-primary text-[8px] font-bold text-white shadow">Klien</span>
                        </div>
                        <div class="absolute bottom-[20%] left-[30%] flex items-center gap-1 pointer-events-none">
                            <svg class="w-3.5 h-3.5 text-accent drop-shadow" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4 0l16 12.22-8.55 1.56 4.8 9.38-3.57 1.83-4.74-9.43-4.04 3.75z"/>
                            </svg>
                            <span class="px-2 py-0.5 rounded-md bg-accent text-[8px] font-bold text-white shadow">Zahra MUA</span>
                        </div>

                    </div>
                    
                    <!-- Editor Chrome Bottom Bar -->
                    <div class="flex items-center justify-between pt-2 border-t border-[#2C293A] text-[9px] font-mono text-[#6E7191]">
                        <span>Slide 1 of 3 (Top MUA)</span>
                        <span>Scale 100%</span>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Logo Wall Section (Directly below Hero) -->
<div class="bg-white py-8 border-b border-hairline">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-center gap-12 md:gap-20 opacity-45 grayscale">
            <!-- Logo-only rule: No labels, only clean vector brands for communication channels -->
            <svg class="h-6 w-auto text-ink" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
            <svg class="h-6 w-auto text-ink" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
            </svg>
            <svg class="h-6 w-auto text-ink" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 .02c-6.627 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
            </svg>
            <svg class="h-6 w-auto text-ink" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19.009 21.393h2.998V24h-2.998zM24 4.887v.03c0 2.213-1.79 4.01-4.004 4.01h-2.997a4.013 4.013 0 01-4.005-4.01v-.03c0-2.214 1.79-4.011 4.005-4.011h2.997A4.011 4.011 0 0124 4.887zm-16.993 1.5h2.998V24H7.007zm7.994 0h2.998V24H15.001z"/>
            </svg>
        </div>
    </div>
</div>

<!-- Step Timeline Section (How it works - pitch slide navigation format) -->
<div id="cara-kerja" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-[640px] mx-auto mb-16 space-y-3">
            <h2 class="text-3xl font-display font-extrabold tracking-tight text-ink">Langkah Mudah Menemukan MUA Anda</h2>
            <p class="text-sm text-muted">Bagaimana sistem pencocokan preferensi mencarikan 3 MUA terbaik secara real-time.</p>
        </div>

        <!-- Horizontal Slide Timeline -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            
            <!-- Step card 1 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-hairline relative flex flex-col justify-between aspect-square hover:border-primary/50 transition-colors duration-300">
                <div class="text-xs font-mono text-muted">SLIDE 01</div>
                <div class="space-y-2 py-4">
                    <h3 class="text-base font-display font-bold text-ink">Tentukan Kebutuhan</h3>
                    <p class="text-xs text-muted leading-relaxed">Masukkan preferensi jenis acara, tema dekorasi, look makeup, range budget, dan radius lokasi di Temanggung.</p>
                </div>
                <span class="text-4xl font-display font-black text-slate-200">01</span>
            </div>

            <!-- Step card 2 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-hairline relative flex flex-col justify-between aspect-square hover:border-primary/50 transition-colors duration-300">
                <div class="text-xs font-mono text-muted">SLIDE 02</div>
                <div class="space-y-2 py-4">
                    <h3 class="text-base font-display font-bold text-ink">Binerisasi Vektor</h3>
                    <p class="text-xs text-muted leading-relaxed">Sistem memetakan preferensi Anda ke dalam 48 dimensi vektor biner atribut secara sistematis.</p>
                </div>
                <span class="text-4xl font-display font-black text-slate-200">02</span>
            </div>

            <!-- Step card 3 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-hairline relative flex flex-col justify-between aspect-square hover:border-primary/50 transition-colors duration-300">
                <div class="text-xs font-mono text-muted">SLIDE 03</div>
                <div class="space-y-2 py-4">
                    <h3 class="text-base font-display font-bold text-ink">Kalkulasi Cosine</h3>
                    <p class="text-xs text-muted leading-relaxed">Persamaan Cosine Similarity menghitung derajat kedekatan antara preferensi Anda dengan seluruh data MUA.</p>
                </div>
                <span class="text-4xl font-display font-black text-slate-200">03</span>
            </div>

            <!-- Step card 4 -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-hairline relative flex flex-col justify-between aspect-square hover:border-primary/50 transition-colors duration-300">
                <div class="text-xs font-mono text-muted">SLIDE 04</div>
                <div class="space-y-2 py-4">
                    <h3 class="text-base font-display font-bold text-ink">Terhubung Langsung</h3>
                    <p class="text-xs text-muted leading-relaxed">Pilih salah satu dari Top 3 rekomendasi, lalu langsung hubungi kontak WhatsApp atau Instagram resmi MUA.</p>
                </div>
                <span class="text-4xl font-display font-black text-slate-200">04</span>
            </div>

        </div>
    </div>
</div>

<!-- Featured MUA Section (Pitch template gallery style) -->
<div id="featured-mua" class="py-20 bg-slate-50 border-t border-b border-hairline">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="space-y-3">
                <h2 class="text-3xl font-display font-extrabold tracking-tight text-ink">Koleksi MUA Unggulan</h2>
                <p class="text-sm text-muted">Jelajahi portofolio & ulasan MUA profesional terverifikasi di Kabupaten Temanggung.</p>
            </div>
            <a href="{{ route('recommendation.form') }}" 
               class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-primary hover:text-primary-active transition-colors">
                Cari Rekomendasi ➜
            </a>
        </div>
        
        <!-- Grid layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($featuredMuas as $mua)
                <!-- Card -->
                <div class="bg-white rounded-2xl border border-hairline overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full group">
                    
                    <!-- Top Portofolio Image Frame -->
                    <div class="aspect-[4/3] w-full bg-slate-100 relative overflow-hidden border-b border-hairline">
                        @if($mua->portfolios->isNotEmpty())
                            <img src="{{ $mua->portfolios->first()->url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $mua->name }} Portfolio">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-primary-soft to-accent-soft flex items-center justify-center text-primary font-bold text-xs uppercase">
                                No Portfolio
                            </div>
                        @endif
                        
                        <!-- Radius Badge overlay -->
                        <div class="absolute top-3 left-3">
                            <span class="px-2 py-0.5 rounded bg-white/90 backdrop-blur-sm text-[8px] font-bold text-ink uppercase tracking-wider shadow-sm">
                                Kec. {{ $mua->district ? $mua->district->name : 'Temanggung' }}
                            </span>
                        </div>
                    </div>

                    <!-- Card details -->
                    <div class="p-5 flex-grow flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2.5">
                                <img src="{{ $mua->logo_url }}" class="w-8 h-8 rounded-full object-cover border border-hairline" alt="{{ $mua->name }} Logo">
                                <h3 class="text-sm font-display font-bold text-ink leading-tight truncate">{{ $mua->name }}</h3>
                            </div>
                            <p class="text-xs text-muted leading-relaxed line-clamp-2">{{ $mua->description }}</p>
                            
                            <!-- Badges -->
                            <div class="flex flex-wrap gap-1">
                                @foreach($mua->makeupLooks->take(2) as $look)
                                    <span class="text-[8px] font-bold uppercase tracking-wider px-1.5 py-0.5 rounded bg-accent-soft text-accent">
                                        {{ $look->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Card footer pricing & social links -->
                        <div class="pt-4 border-t border-hairline space-y-3">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-muted">Estimasi Tarif</span>
                                <span class="font-bold text-ink text-xs">
                                    @if($mua->packages->isNotEmpty())
                                        {{ rupiah_range($mua->packages->min('price'), $mua->packages->max('price')) }}
                                    @else
                                        Rp -
                                    @endif
                                </span>
                            </div>

                            <!-- Buttons action grid -->
                            <div class="grid grid-cols-2 gap-2">
                                @if($mua->whatsapp_number)
                                    <a href="{{ wa_link($mua->whatsapp_number) }}" 
                                       target="_blank" 
                                       class="inline-flex items-center justify-center py-2 rounded-full bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-[10px] font-bold border border-emerald-100 transition-all active:scale-95 active:translate-y-0.5">
                                        WhatsApp
                                    </a>
                                @endif
                                @if($mua->instagram_username)
                                    <a href="{{ ig_link($mua->instagram_username) }}" 
                                       target="_blank" 
                                       class="inline-flex items-center justify-center py-2 rounded-full bg-pink-50 hover:bg-pink-100 text-pink-700 text-[10px] font-bold border border-pink-100 transition-all active:scale-95 active:translate-y-0.5">
                                        Instagram
                                    </a>
                                @endif
                            </div>

                            <a href="{{ route('mua.show', $mua->slug) }}" 
                               class="w-full inline-flex items-center justify-center py-2.5 rounded-full bg-primary hover:bg-primary-active text-white text-xs font-bold transition-all active:scale-95 active:translate-y-0.5">
                                Lihat Detail Profil
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-sm text-muted">
                    Belum ada data MUA yang terdaftar.
                </div>
            @endforelse
        </div>

    </div>
</div>

<!-- Interactive Engine Bento Section (Cosine Similarity demonstration) -->
<div class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-[640px] mx-auto mb-16 space-y-3">
            <span class="text-[11px] font-mono uppercase tracking-[0.22em] text-primary">Cosine Similarity Engine</span>
            <h2 class="text-3xl font-display font-extrabold tracking-tight text-ink">Bagaimana Sistem Melakukan Rekomendasi</h2>
        </div>

        <!-- Bento Grid with exactly 3 cells -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Cell 1 (col-span-8): Dark Vector Console (Navy Dark background) -->
            <div class="lg:col-span-8 bg-[#13111C] rounded-2xl p-6 border border-[#2C293A] shadow-xl flex flex-col justify-between space-y-6 text-left" data-aos="fade-right">
                <div class="space-y-2">
                    <span class="text-[9px] font-mono uppercase tracking-widest text-primary">Vektor Representasi Atribut</span>
                    <h3 class="text-xl font-display font-bold text-white leading-tight">48-Dimensi Atribut Biner</h3>
                    <p class="text-xs text-[#6E7191] max-w-[55ch]">
                        Sistem memetakan preferensi pengguna dan profil MUA ke dalam format data biner `[0,1]` pada dimensi: Jenis Acara, Tema, Look Makeup, Lokasi Kecamatan, dan Range Budget.
                    </p>
                </div>
                
                <!-- Binarized Vector Code display -->
                <div class="p-4 rounded-xl bg-[#1A1825] border border-[#2C293A] font-mono text-[10px] space-y-2 text-[#E8EAF6] overflow-x-auto">
                    <div><span class="text-accent">// Preferensi User</span></div>
                    <div class="text-primary-light">v_user  = [1, 0, 0, 1, 0, 0, 0, 1, 0, 1, 0, 1, 0, 0, 1, 0, 0, 0, 0, 1, 0...]</div>
                    <div class="pt-2"><span class="text-accent">// Atribut Zahra MUA</span></div>
                    <div class="text-[#8F8CA3]">v_mua01 = [1, 1, 0, 1, 0, 0, 0, 1, 0, 1, 0, 1, 0, 0, 1, 1, 0, 1, 0, 1, 0...]</div>
                </div>
            </div>

            <!-- Cell 2 (col-span-4): Soft Mint Parameters Input -->
            <div class="lg:col-span-4 bg-accent-soft rounded-2xl p-6 border border-accent-light/40 flex flex-col justify-between space-y-6 text-left" data-aos="fade-left">
                <div class="space-y-2">
                    <span class="text-[9px] font-mono uppercase tracking-widest text-accent">Dimensi Filter</span>
                    <h3 class="text-xl font-display font-bold text-ink leading-tight">Parameter Pencarian</h3>
                    <p class="text-xs text-muted">Atribut utama yang digunakan untuk merekomendasikan profil MUA kepada Anda.</p>
                </div>
                
                <ul class="space-y-2 text-[11px] font-semibold text-ink">
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                        Jenis Acara (Akad, Wisuda, dll)
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                        Tema & Jenis Tema (Adat / Modern)
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                        Ketersediaan Jasa Home Service
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                        Look Makeup & Budget Acara
                    </li>
                </ul>
            </div>

            <!-- Cell 3 (col-span-12): White Formula Calculator (Full width border box) -->
            <div class="lg:col-span-12 bg-white rounded-2xl p-6 border border-hairline shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 text-left" data-aos="fade-up">
                <div class="space-y-2">
                    <h3 class="text-base font-display font-bold text-ink">Formula Cosine Similarity</h3>
                    <p class="text-xs text-muted max-w-[480px]">
                        Kecocokan dihitung dengan membagi dot product kedua vektor dengan perkalian panjang vektor masing-masing. Hasil berkisar dari 0% hingga 100% kecocokan.
                    </p>
                </div>
                
                <!-- Math Box -->
                <div class="p-4 rounded-xl bg-slate-50 border border-hairline font-mono text-xs text-ink flex items-center justify-center gap-3">
                    <span class="font-bold text-primary">Sim(A, B) = </span>
                    <div class="flex flex-col items-center">
                        <span class="border-b border-ink pb-0.5">A &middot; B</span>
                        <span class="pt-0.5">||A|| &times; ||B||</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- Testimonial Section (Single Showcase layout - no grid cards duplication) -->
<div id="testimoni" class="py-20 bg-slate-50 border-t border-b border-hairline">
    <div class="max-w-[800px] mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="zoom-in">
        <span class="text-3xl text-primary block mb-6">“</span>
        
        <p class="text-lg md:text-xl font-display font-medium text-ink leading-relaxed max-w-[70ch] mx-auto italic">
            "Sistem rekomendasi ini sangat mempermudah saya dalam mencari MUA untuk acara siraman. Karena siraman mewajibkan adat, sistem otomatis menyesuaikan preferensi dan merekomendasikan Zahra MUA yang ternyata layanannya sangat memuaskan!"
        </p>
        
        <div class="mt-8 flex items-center justify-center gap-3">
            <div class="w-10 h-10 rounded-full bg-primary-soft text-primary font-bold flex items-center justify-center text-sm">AN</div>
            <div class="text-left">
                <h4 class="text-xs font-bold text-ink leading-tight">Anindya N.</h4>
                <span class="text-[10px] text-muted">Kec. Kranggan, Temanggung</span>
            </div>
        </div>
    </div>
</div>

<!-- Settings-panel Style FAQ Section -->
<div class="py-20 bg-white">
    <div class="max-w-[768px] mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12 space-y-3">
            <h2 class="text-3xl font-display font-extrabold tracking-tight text-ink">Pertanyaan Umum (FAQ)</h2>
            <p class="text-sm text-muted">Segala hal yang perlu Anda ketahui mengenai platform MUA Temanggung.</p>
        </div>
        
        <!-- Accordion container -->
        <div class="space-y-3" x-data="{ activeTab: null }">
            
            <!-- Item 1 -->
            <div class="border border-hairline rounded-xl overflow-hidden transition-colors"
                 :class="activeTab === 1 ? 'bg-slate-50' : 'bg-white'">
                <button type="button" 
                        @click="activeTab = (activeTab === 1 ? null : 1)"
                        class="w-full px-5 py-4 flex items-center justify-between text-left font-display font-bold text-ink text-sm hover:text-primary transition-colors focus:outline-none">
                    <span>Apakah saya dikenakan biaya untuk mencari rekomendasi MUA?</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="activeTab === 1 ? 'rotate-180 text-primary' : 'text-muted'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="activeTab === 1" 
                     x-transition 
                     class="px-5 pb-4 text-xs text-muted leading-relaxed" 
                     style="display: none;">
                    Tidak. Sistem rekomendasi ini dapat diakses secara gratis oleh seluruh klien (Guest) tanpa harus mendaftar akun atau membayar biaya administrasi.
                </div>
            </div>

            <!-- Item 2 -->
            <div class="border border-hairline rounded-xl overflow-hidden transition-colors"
                 :class="activeTab === 2 ? 'bg-slate-50' : 'bg-white'">
                <button type="button" 
                        @click="activeTab = (activeTab === 2 ? null : 2)"
                        class="w-full px-5 py-4 flex items-center justify-between text-left font-display font-bold text-ink text-sm hover:text-primary transition-colors focus:outline-none">
                    <span>Bagaimana cara menghubungi MUA hasil rekomendasi?</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="activeTab === 2 ? 'rotate-180 text-primary' : 'text-muted'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="activeTab === 2" 
                     x-transition 
                     class="px-5 pb-4 text-xs text-muted leading-relaxed" 
                     style="display: none;">
                    Pada halaman detail MUA atau kartu hasil rekomendasi, sistem menyediakan tombol pintasan langsung menuju nomor WhatsApp resmi MUA atau link ke halaman profil Instagram mereka.
                </div>
            </div>

            <!-- Item 3 -->
            <div class="border border-hairline rounded-xl overflow-hidden transition-colors"
                 :class="activeTab === 3 ? 'bg-slate-50' : 'bg-white'">
                <button type="button" 
                        @click="activeTab = (activeTab === 3 ? null : 3)"
                        class="w-full px-5 py-4 flex items-center justify-between text-left font-display font-bold text-ink text-sm hover:text-primary transition-colors focus:outline-none">
                    <span>Bagaimana jika data MUA yang dicari belum sesuai?</span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="activeTab === 3 ? 'rotate-180 text-primary' : 'text-muted'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="activeTab === 3" 
                     x-transition 
                     class="px-5 pb-4 text-xs text-muted leading-relaxed" 
                     style="display: none;">
                    Anda dapat mengisi ulang form pencarian dengan mengubah preferensi parameter (misalnya memperluas radius lokasi atau melonggarkan kriteria look makeup) untuk mendapatkan hasil pencocokan yang baru.
                </div>
            </div>

        </div>

    </div>
</div>

<!-- CTA Slide Banner Section (Deep Slate dark bg) -->
<div class="py-16 bg-[#13111C] border-t border-[#2C293A] text-white">
    <div class="max-w-[800px] mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6" data-aos="zoom-in">
        <h2 class="text-3xl font-display font-extrabold tracking-tight leading-tight">Siap Tampil Cantik di Momen Spesial Anda?</h2>
        <p class="text-xs text-[#8F8CA3] max-w-[420px] mx-auto">
            Hanya butuh 1 menit untuk mengisi preferensi Anda dan temukan 3 rekomendasi Make Up Artist terbaik.
        </p>
        <div class="flex justify-center pt-2">
            <a href="{{ route('recommendation.form') }}" 
               class="inline-flex items-center justify-center px-8 py-3.5 rounded-full bg-gradient-to-r from-primary to-accent hover:from-primary-active hover:to-accent-active text-white text-sm font-bold shadow-lg shadow-primary/20 hover:scale-105 transition-transform duration-200 active:scale-95 active:translate-y-0.5">
                Cari Rekomendasi MUA
            </a>
        </div>
    </div>
</div>
@endsection
