{{--
    Shared sidebar navigation partial.
    Used by both desktop (#desktop-sidebar) and mobile (#mobile-drawer).
    Icons: Lucide (loaded via CDN in dashboard.blade.php).
--}}

@php
    $isAdmin = auth()->user()->isAdmin();
    $isMua   = auth()->user()->isMua();

    $navClass = fn(bool $active) => 'flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-colors relative '
        . ($active
            ? 'bg-primary/10 text-primary nav-link-active'
            : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800');
@endphp

@if($isAdmin)
    {{-- ── ADMIN MENU ── --}}
    <div class="space-y-0.5">
        <span class="block px-3 text-[9px] font-bold uppercase tracking-widest text-slate-400/80 mb-1.5 mt-1">Main Menu</span>

        <a href="{{ route('admin.dashboard') }}" class="{{ $navClass(Route::is('admin.dashboard')) }}">
            <i data-lucide="layout-dashboard" class="w-4 h-4 flex-shrink-0"></i>
            <span class="truncate">Dashboard</span>
        </a>

        <a href="{{ route('admin.mua.index') }}" class="{{ $navClass(Request::is('admin/mua*')) }}">
            <i data-lucide="users" class="w-4 h-4 flex-shrink-0"></i>
            <span class="truncate">Mitra MUA</span>
        </a>

        <a href="{{ route('admin.master.index') }}" class="{{ $navClass(Route::is('admin.master.*')) }}">
            <i data-lucide="database" class="w-4 h-4 flex-shrink-0"></i>
            <span class="truncate">Master Data</span>
        </a>
    </div>

    <div class="space-y-0.5" x-data="{ open: {{ Route::is('admin.monitoring.*') ? 'true' : 'false' }} }">
        <span class="block px-3 text-[9px] font-bold uppercase tracking-widest text-slate-400/80 mb-1.5 mt-1">Monitoring</span>

        <button type="button" @click="open = !open" class="{{ $navClass(Route::is('admin.monitoring.*')) }} w-full justify-between">
            <span class="flex items-center gap-3">
                <i data-lucide="activity" class="w-4 h-4 flex-shrink-0"></i>
                <span class="truncate">Monitoring</span>
            </span>
            <i data-lucide="chevron-down" class="w-3.5 h-3.5 flex-shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
        </button>

        <div x-show="open" x-transition class="pl-4 space-y-0.5">
            <a href="{{ route('admin.monitoring.index') }}" class="{{ $navClass(Route::is('admin.monitoring.index')) }}">
                <i data-lucide="layout-grid" class="w-4 h-4 flex-shrink-0"></i>
                <span class="truncate">Ringkasan</span>
            </a>

            <a href="{{ route('admin.monitoring.searches') }}" class="{{ $navClass(Route::is('admin.monitoring.searches')) }}">
                <i data-lucide="search" class="w-4 h-4 flex-shrink-0"></i>
                <span class="truncate">Log Pencarian</span>
            </a>
        </div>
    </div>

@elseif($isMua)
    {{-- ── MUA MENU ── --}}
    <div class="space-y-0.5">
        <span class="block px-3 text-[9px] font-bold uppercase tracking-widest text-slate-400/80 mb-1.5 mt-1">Main Menu</span>

        <a href="{{ route('mua.dashboard') }}" class="{{ $navClass(Route::is('mua.dashboard')) }}">
            <i data-lucide="home" class="w-4 h-4 flex-shrink-0"></i>
            <span class="truncate">Dashboard</span>
        </a>

        <a href="{{ route('mua.profile.edit') }}" class="{{ $navClass(Route::is('mua.profile.edit')) }}">
            <i data-lucide="user-circle" class="w-4 h-4 flex-shrink-0"></i>
            <span class="truncate">Edit Profil</span>
        </a>

        <a href="{{ route('mua.location.edit') }}" class="{{ $navClass(Route::is('mua.location.edit')) }}">
            <i data-lucide="map" class="w-4 h-4 flex-shrink-0"></i>
            <span class="truncate">Radius Jangkauan</span>
        </a>
    </div>

    <div class="space-y-0.5">
        <span class="block px-3 text-[9px] font-bold uppercase tracking-widest text-slate-400/80 mb-1.5 mt-1">Manajemen Jasa</span>

        <a href="{{ route('mua.packages.index') }}" class="{{ $navClass(Request::is('mua/paket*')) }}">
            <i data-lucide="package" class="w-4 h-4 flex-shrink-0"></i>
            <span class="truncate">Paket Layanan</span>
        </a>

        <a href="{{ route('mua.portfolio.index') }}" class="{{ $navClass(Request::is('mua/portofolio*')) }}">
            <i data-lucide="image" class="w-4 h-4 flex-shrink-0"></i>
            <span class="truncate">Portofolio</span>
        </a>
    </div>
@endif
