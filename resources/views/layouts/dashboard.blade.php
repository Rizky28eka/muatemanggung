<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — MUA Temanggung</title>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fc;
        }
        h1, h2, h3, h4, h5, h6, .font-display {
            font-family: 'Outfit', sans-serif;
        }

        /* ── Sidebar width token ── */
        :root {
            --sidebar-w: 220px;
            --navbar-h: 56px;
        }
        @media (min-width: 640px) {
            :root { --navbar-h: 64px; }
        }

        /* ── Desktop sidebar ── */
        #desktop-sidebar {
            width: var(--sidebar-w);
            flex-shrink: 0;
        }

        /* ── Mobile drawer transition ── */
        #mobile-drawer {
            transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
            transform: translateX(-100%);
            width: var(--sidebar-w);
        }
        #mobile-drawer.open { transform: translateX(0); }

        /* ── Nav active indicator ── */
        .nav-link-active { position: relative; }
        .nav-link-active::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 22px;
            background: var(--color-primary, #7c3aed);
            border-radius: 0 3px 3px 0;
        }

        /* ── Fixed navbar ── */
        #dashboard-navbar {
            position: fixed;
            top: 0;
            /* On desktop: offset by sidebar width */
            right: 0;
            height: var(--navbar-h);
            z-index: 30;
            transition: box-shadow 0.2s ease;
        }
        /* Default: full width (mobile, no sidebar) */
        #dashboard-navbar { left: 0; }
        /* Desktop: start after sidebar */
        @media (min-width: 1024px) {
            #dashboard-navbar { left: var(--sidebar-w); }
        }
        /* Scroll shadow — added via JS */
        #dashboard-navbar.scrolled {
            box-shadow: 0 1px 12px 0 rgba(30, 27, 75, 0.07);
        }

        /* ── Content top padding to clear fixed navbar ── */
        #main-content {
            padding-top: calc(var(--navbar-h) + 1rem);
        }
        @media (min-width: 640px) {
            #main-content { padding-top: calc(var(--navbar-h) + 1.5rem); }
        }
        @media (min-width: 1024px) {
            #main-content { padding-top: calc(var(--navbar-h) + 2rem); }
        }

        /* Alpine cloak */
        [x-cloak] { display: none !important; }

        /* Scrollbar thin */
        #desktop-sidebar nav::-webkit-scrollbar,
        #mobile-drawer nav::-webkit-scrollbar { width: 3px; }
        #desktop-sidebar nav::-webkit-scrollbar-track,
        #mobile-drawer nav::-webkit-scrollbar-track { background: transparent; }
        #desktop-sidebar nav::-webkit-scrollbar-thumb,
        #mobile-drawer nav::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#f8f9fc] text-slate-800 antialiased min-h-screen">

    <div class="flex min-h-screen">

        {{-- ══════════════════════════════════════════════
             DESKTOP SIDEBAR (hidden on mobile)
        ══════════════════════════════════════════════ --}}
        <aside id="desktop-sidebar"
               class="hidden lg:flex flex-col bg-white text-slate-700 border-r border-slate-200/60 sticky top-0 h-screen overflow-y-auto">

            {{-- Branding --}}
            <div class="h-16 flex items-center px-5 border-b border-slate-100 flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group min-w-0">
                    <div class="w-7 h-7 rounded-lg bg-primary flex items-center justify-center text-white shadow shadow-primary/20 group-hover:scale-105 transition-transform duration-300 flex-shrink-0">
                        <span class="font-display font-black text-xs">MT</span>
                    </div>
                    <div class="flex flex-col text-left min-w-0">
                        <span class="font-display font-black text-xs text-slate-900 tracking-tight leading-none truncate">
                            MUA<span class="text-primary">Temanggung</span>
                        </span>
                        <span class="text-[8px] text-slate-400 font-semibold tracking-widest uppercase mt-0.5">Dashboard</span>
                    </div>
                </a>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 px-3 py-5 space-y-5 overflow-y-auto">
                @include('layouts.partials.sidebar-nav')
            </nav>

            {{-- Bottom user card --}}
            <div class="p-3 border-t border-slate-100 flex-shrink-0">
                <div class="flex items-center gap-2.5 bg-slate-50 rounded-xl p-2.5">
                    <div class="w-7 h-7 rounded-lg bg-primary/10 text-primary font-bold flex items-center justify-center text-xs flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-[11px] font-bold text-slate-900 truncate leading-tight">{{ auth()->user()->name }}</span>
                        <span class="block text-[9px] text-slate-500 truncate leading-none mt-0.5">{{ auth()->user()->email }}</span>
                    </div>
                </div>
            </div>
        </aside>

        {{-- ══════════════════════════════════════════════
             MOBILE SIDEBAR DRAWER (overlay)
        ══════════════════════════════════════════════ --}}
        {{-- Backdrop --}}
        <div id="mobile-backdrop"
             class="lg:hidden fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm hidden"
             onclick="closeMobileSidebar()"></div>

        {{-- Drawer panel --}}
        <aside id="mobile-drawer"
               class="lg:hidden fixed top-0 left-0 z-50 h-full flex flex-col bg-white text-slate-700 shadow-2xl">

            {{-- Drawer Header --}}
            <div class="h-16 flex items-center justify-between px-4 border-b border-slate-100 flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-xs">MT</div>
                    <span class="font-display font-black text-xs text-slate-900 tracking-tight">
                        MUA<span class="text-primary">Temanggung</span>
                    </span>
                </a>
                <button onclick="closeMobileSidebar()"
                        class="w-7 h-7 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- User card --}}
            <div class="px-4 py-3 border-b border-slate-100 flex-shrink-0">
                <div class="flex items-center gap-2.5 bg-slate-50 p-2.5 rounded-xl">
                    <div class="w-7 h-7 rounded-lg bg-primary/10 text-primary font-bold flex items-center justify-center text-xs flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <span class="block text-[11px] font-bold text-slate-900 truncate leading-tight">{{ auth()->user()->name }}</span>
                        <span class="block text-[9px] text-slate-500 truncate leading-none mt-0.5">{{ auth()->user()->email }}</span>
                    </div>
                </div>
            </div>

            {{-- Nav (shared partial) --}}
            <nav class="flex-1 px-3 py-5 space-y-5 overflow-y-auto">
                @include('layouts.partials.sidebar-nav')
            </nav>

            {{-- Logout button inside mobile sidebar --}}
            <div class="p-3 border-t border-slate-100 flex-shrink-0">
                <form action="{{ auth()->user()->role === 'admin' ? route('admin.logout') : route('mua.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-xs font-bold text-rose-500 hover:bg-rose-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- ══════════════════════════════════════════════
             MAIN LAYOUT WRAPPER
        ══════════════════════════════════════════════ --}}
        {{-- Main wrapper: no overflow-hidden so sticky/fixed works correctly --}}
        <div class="flex-grow flex flex-col min-w-0">

            {{-- ── FIXED TOP NAVBAR ── --}}
            <header id="dashboard-navbar"
                    class="bg-white/90 backdrop-blur-md px-4 sm:px-6 flex items-center justify-between border-b border-slate-200/60">

                <div class="flex items-center gap-3">
                    {{-- Hamburger (mobile only) --}}
                    <button type="button" onclick="openMobileSidebar()"
                            class="lg:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 transition-colors -ml-1"
                            aria-label="Buka menu">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    {{-- Page title / breadcrumb area --}}
                    <div class="text-left">
                        <span class="hidden sm:block text-[9px] font-bold text-slate-400 uppercase tracking-widest">Portal Panel</span>
                        <h2 class="text-sm sm:text-base font-display font-bold text-slate-800 leading-tight">
                            Halo, <span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">{{ explode(' ', auth()->user()->name)[0] }}</span>
                            <span class="ml-0.5">👋</span>
                        </h2>
                    </div>
                </div>

                {{-- Right side actions --}}
                <div class="flex items-center gap-2">

                    {{-- Bell / Notifications --}}
                    @php
                        $unreadNotifications = auth()->user()->unreadNotifications()->take(8)->get();
                        $unreadCount = auth()->user()->unreadNotifications()->count();
                        $notifColorClasses = [
                            'amber'   => 'bg-amber-50 text-amber-500',
                            'emerald' => 'bg-emerald-50 text-emerald-500',
                            'rose'    => 'bg-rose-50 text-rose-500',
                            'sky'     => 'bg-sky-50 text-sky-500',
                            'primary' => 'bg-primary/10 text-primary',
                            'slate'   => 'bg-slate-50 text-slate-500',
                        ];
                    @endphp
                    <div class="relative" x-data="{ open: false }" @keydown.escape.window="open = false">
                        <button @click="open = !open" @click.outside="open = false"
                                class="relative w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 transition-colors"
                                aria-label="Notifikasi">
                            <i data-lucide="bell" class="w-4 h-4"></i>
                            @if($unreadCount > 0)
                                <span class="absolute -top-0.5 -right-0.5 min-w-[16px] h-4 px-1 rounded-full bg-rose-500 text-white text-[9px] font-bold flex items-center justify-center leading-none">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            @endif
                        </button>

                        <div x-show="open" x-transition x-cloak
                             class="absolute right-0 mt-2 w-80 max-w-[90vw] bg-white rounded-2xl border border-slate-200/60 shadow-lg z-50 overflow-hidden">
                            <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
                                <span class="text-xs font-bold text-slate-800">Notifikasi</span>
                                @if($unreadCount > 0)
                                    <form action="{{ route('notifications.read-all') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-[10px] font-bold text-primary hover:underline">Tandai semua dibaca</button>
                                    </form>
                                @endif
                            </div>

                            <div class="max-h-80 overflow-y-auto divide-y divide-slate-50">
                                @forelse($unreadNotifications as $notification)
                                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left flex items-start gap-3 px-4 py-3 hover:bg-slate-50/80 transition-colors">
                                            <div class="w-8 h-8 rounded-xl {{ $notifColorClasses[$notification->data['color'] ?? 'slate'] ?? $notifColorClasses['slate'] }} flex items-center justify-center flex-shrink-0">
                                                <i data-lucide="{{ $notification->data['icon'] ?? 'bell' }}" class="w-4 h-4"></i>
                                            </div>
                                            <div class="min-w-0">
                                                <span class="block text-[11px] font-bold text-slate-800 leading-tight">{{ $notification->data['title'] ?? 'Notifikasi' }}</span>
                                                <span class="block text-[10px] text-slate-500 mt-0.5 leading-snug">{{ $notification->data['message'] ?? '' }}</span>
                                                <span class="block text-[9px] text-slate-300 mt-1">{{ $notification->created_at->diffForHumans() }}</span>
                                            </div>
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0 mt-1.5"></span>
                                        </button>
                                    </form>
                                @empty
                                    <div class="px-4 py-8 text-center text-[11px] text-slate-400">
                                        Tidak ada notifikasi baru.
                                    </div>
                                @endforelse
                            </div>

                            <div class="px-4 py-2.5 border-t border-slate-100">
                                <a href="{{ route('notifications.index') }}" class="block text-center text-[10px] font-bold text-primary hover:underline">
                                    Lihat Semua Notifikasi
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Logout --}}
                    <form action="{{ auth()->user()->role === 'admin' ? route('admin.logout') : route('mua.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white hover:bg-rose-50 border border-slate-200 text-slate-600 hover:text-rose-600 text-xs font-bold transition-all active:scale-95">
                            <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>

                </div>
            </header>

            {{-- MAIN CONTENT — top padding accounts for fixed navbar height --}}
            <main id="main-content" class="flex-1 px-4 pb-8 sm:px-6 sm:pb-10 lg:px-8 lg:pb-10 bg-[#f8f9fc]">
                @yield('content')
            </main>

        </div>{{-- /main wrapper --}}
    </div>{{-- /flex --}}

    {{-- ── Scripts ── --}}
    <script>
        // Init Lucide icons after DOM is ready
        document.addEventListener('DOMContentLoaded', () => lucide.createIcons());

        // Scroll shadow on navbar
        const navbar = document.getElementById('dashboard-navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 4);
        }, { passive: true });

        const drawer   = document.getElementById('mobile-drawer');
        const backdrop = document.getElementById('mobile-backdrop');

        function openMobileSidebar() {
            drawer.classList.add('open');
            backdrop.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            // Re-init icons inside the drawer in case they haven't rendered yet
            lucide.createIcons({ nameAttr: 'data-lucide', nodes: [drawer] });
        }

        function closeMobileSidebar() {
            drawer.classList.remove('open');
            backdrop.classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Close on ESC key
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeMobileSidebar();
        });

        // Swipe-left to close
        let touchStartX = 0;
        drawer.addEventListener('touchstart', e => { touchStartX = e.touches[0].clientX; }, { passive: true });
        drawer.addEventListener('touchend', e => {
            if (touchStartX - e.changedTouches[0].clientX > 60) closeMobileSidebar();
        }, { passive: true });
    </script>

</body>
</html>
