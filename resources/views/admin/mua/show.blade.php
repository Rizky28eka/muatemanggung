@extends('layouts.dashboard')
@section('title', 'Detail MUA — ' . $mua->name)

@section('content')
<div class="space-y-6">

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ route('admin.mua.index') }}" class="hover:text-primary transition-colors">Mitra MUA</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
        <span class="text-slate-700 font-semibold">{{ $mua->name }}</span>
    </div>

    {{-- ── Top Actions ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display font-bold text-xl text-slate-900">{{ $mua->name }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">Detail lengkap profil mitra MUA.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <form action="{{ route('admin.mua.toggle', $mua) }}" method="POST">
                @csrf
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2.5 text-xs font-bold rounded-xl border transition active:scale-95
                               {{ $mua->is_active
                                  ? 'bg-slate-100 border-slate-200 text-slate-600 hover:bg-rose-50 hover:border-rose-200 hover:text-rose-600'
                                  : 'bg-emerald-50 border-emerald-200 text-emerald-700 hover:bg-emerald-100' }}">
                    <i data-lucide="{{ $mua->is_active ? 'toggle-left' : 'toggle-right' }}" class="w-4 h-4"></i>
                    {{ $mua->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </form>
            <a href="{{ route('admin.mua.edit', $mua) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-xs font-bold rounded-xl shadow shadow-primary/20 hover:bg-primary/90 active:scale-95 transition-all">
                <i data-lucide="pencil" class="w-4 h-4"></i>
                Edit Data
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── LEFT: Identity Card ── --}}
        <div class="lg:col-span-1 space-y-5">

            {{-- Profile Card --}}
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs overflow-hidden">
                <div class="h-20 bg-gradient-to-br from-primary/80 to-accent/80"></div>
                <div class="px-5 pb-5 -mt-8">
                    <div class="w-16 h-16 rounded-2xl bg-white border-4 border-white shadow-md flex items-center justify-center text-primary font-display font-black text-xl mb-3">
                        {{ strtoupper(substr($mua->name, 0, 2)) }}
                    </div>
                    <h2 class="font-display font-bold text-slate-900 text-base">{{ $mua->name }}</h2>
                    @if($mua->description)
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $mua->description }}</p>
                    @endif

                    <div class="mt-4 space-y-2.5">
                        {{-- Status --}}
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400 font-medium">Status</span>
                            @if($mua->is_active)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Non-Aktif
                                </span>
                            @endif
                        </div>

                        {{-- District --}}
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400 font-medium">Kecamatan</span>
                            <span class="text-slate-800 font-semibold">{{ $mua->district?->name ?? '—' }}</span>
                        </div>

                        {{-- Email --}}
                        <div class="flex items-center justify-between text-xs gap-2">
                            <span class="text-slate-400 font-medium flex-shrink-0">Email</span>
                            <span class="text-slate-800 font-semibold text-right truncate">{{ $mua->user?->email ?? '—' }}</span>
                        </div>

                        {{-- WA --}}
                        @if($mua->whatsapp_number)
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400 font-medium">WhatsApp</span>
                            <a href="{{ $mua->wa_link }}" target="_blank"
                               class="text-emerald-600 font-semibold hover:underline">
                                {{ $mua->whatsapp_number }}
                            </a>
                        </div>
                        @endif

                        {{-- Instagram --}}
                        @if($mua->instagram_username)
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400 font-medium">Instagram</span>
                            <a href="{{ $mua->ig_link }}" target="_blank"
                               class="text-pink-600 font-semibold hover:underline">
                                @{{ $mua->instagram_username }}
                            </a>
                        </div>
                        @endif

                        {{-- Home Service --}}
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400 font-medium">Home Service</span>
                            @if($mua->is_home_service)
                                <span class="text-sky-600 font-semibold">Ya, {{ $mua->service_radius_km }} km</span>
                            @else
                                <span class="text-slate-400">Tidak</span>
                            @endif
                        </div>

                        {{-- Registered --}}
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-400 font-medium">Terdaftar</span>
                            <span class="text-slate-600">{{ $mua->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-4 space-y-2">
                <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-3">Aksi Cepat</p>

                <a href="{{ route('admin.mua.edit', $mua) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-primary/5 hover:text-primary transition-colors">
                    <i data-lucide="pencil" class="w-4 h-4"></i> Edit Data MUA
                </a>

                @if($mua->whatsapp_number)
                <a href="{{ $mua->wa_link }}" target="_blank"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                    <i data-lucide="message-circle" class="w-4 h-4"></i> Hubungi via WhatsApp
                </a>
                @endif

                <form action="{{ route('admin.mua.destroy', $mua) }}" method="POST"
                      onsubmit="return confirm('Hapus MUA ini secara permanen?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold text-rose-500 hover:bg-rose-50 transition-colors">
                        <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus Akun MUA
                    </button>
                </form>
            </div>
        </div>

        {{-- ── RIGHT: Detail Panels ── --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Layanan & Preferensi --}}
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-5">
                <h3 class="font-display font-bold text-sm text-slate-800 mb-4 flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-4 h-4 text-primary"></i>
                    Layanan & Preferensi
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- Jenis Acara --}}
                    <div>
                        <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-2">Jenis Acara</p>
                        @forelse($mua->eventTypes as $et)
                            <span class="inline-block mr-1 mb-1 px-2.5 py-1 rounded-full bg-violet-50 text-violet-700 text-[10px] font-semibold">{{ $et->name }}</span>
                        @empty
                            <span class="text-xs text-slate-300">Belum diisi</span>
                        @endforelse
                    </div>

                    {{-- Tema --}}
                    <div>
                        <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-2">Tema</p>
                        @forelse($mua->themes as $theme)
                            <span class="inline-block mr-1 mb-1 px-2.5 py-1 rounded-full bg-pink-50 text-pink-700 text-[10px] font-semibold">{{ $theme->name }}</span>
                        @empty
                            <span class="text-xs text-slate-300">Belum diisi</span>
                        @endforelse
                    </div>

                    {{-- Look Riasan --}}
                    <div>
                        <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-2">Look Riasan</p>
                        @forelse($mua->makeupLooks as $look)
                            <span class="inline-block mr-1 mb-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-[10px] font-semibold">{{ $look->name }}</span>
                        @empty
                            <span class="text-xs text-slate-300">Belum diisi</span>
                        @endforelse
                    </div>

                    {{-- Kecamatan Layanan --}}
                    <div>
                        <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-2">Wilayah Layanan</p>
                        @forelse($mua->serviceDistricts as $district)
                            <span class="inline-block mr-1 mb-1 px-2.5 py-1 rounded-full bg-sky-50 text-sky-700 text-[10px] font-semibold">{{ $district->name }}</span>
                        @empty
                            <span class="text-xs text-slate-300">Belum diisi</span>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Paket Layanan --}}
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-5">
                <h3 class="font-display font-bold text-sm text-slate-800 mb-4 flex items-center gap-2">
                    <i data-lucide="package" class="w-4 h-4 text-primary"></i>
                    Paket Layanan
                    <span class="ml-auto px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold">{{ $mua->packages->count() }} paket</span>
                </h3>

                @forelse($mua->packages as $pkg)
                    <div class="flex items-center justify-between py-3 border-b border-slate-50 last:border-0">
                        <div>
                            <span class="text-xs font-semibold text-slate-800">{{ $pkg->name }}</span>
                            @if($pkg->description)
                                <p class="text-[10px] text-slate-400 mt-0.5 line-clamp-1">{{ $pkg->description }}</p>
                            @endif
                        </div>
                        <div class="text-right flex-shrink-0 ml-4">
                            <span class="text-xs font-bold text-primary">Rp {{ number_format($pkg->price, 0, ',', '.') }}</span>
                            @if(!$pkg->is_available)
                                <span class="block text-[9px] text-slate-400">Tidak tersedia</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-6 text-center">
                        <i data-lucide="package" class="w-8 h-8 text-slate-200 mx-auto mb-2"></i>
                        <p class="text-xs text-slate-300">Belum ada paket layanan</p>
                    </div>
                @endforelse
            </div>

            {{-- Portofolio --}}
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-5">
                <h3 class="font-display font-bold text-sm text-slate-800 mb-4 flex items-center gap-2">
                    <i data-lucide="image" class="w-4 h-4 text-primary"></i>
                    Portofolio
                    <span class="ml-auto px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold">{{ $mua->portfolios->count() }} item</span>
                </h3>

                @if($mua->portfolios->isNotEmpty())
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                        @foreach($mua->portfolios->take(8) as $portfolio)
                            <div class="aspect-square rounded-xl overflow-hidden bg-slate-100">
                                @if($portfolio->file_type === 'photo')
                                    <img src="{{ asset('storage/' . $portfolio->file_path) }}"
                                         alt="{{ $portfolio->caption }}"
                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                         loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i data-lucide="film" class="w-6 h-6 text-slate-400"></i>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @if($mua->portfolios->count() > 8)
                        <p class="text-[10px] text-slate-400 mt-2 text-center">+{{ $mua->portfolios->count() - 8 }} foto lainnya</p>
                    @endif
                @else
                    <div class="py-6 text-center">
                        <i data-lucide="image" class="w-8 h-8 text-slate-200 mx-auto mb-2"></i>
                        <p class="text-xs text-slate-300">Belum ada portofolio</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
