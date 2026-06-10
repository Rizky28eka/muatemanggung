@extends('layouts.dashboard')
@section('title', 'Master Data')

@section('content')
<div class="space-y-5">

    {{-- ── Page Header ── --}}
    <div>
        <h1 class="font-display font-bold text-xl text-slate-900">Master Data</h1>
        <p class="text-xs text-slate-500 mt-0.5">Kelola data acuan yang digunakan sistem rekomendasi & form pendaftaran mitra.</p>
    </div>

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold px-4 py-3 rounded-xl">
            <i data-lucide="check-circle-2" class="w-4 h-4 flex-shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="flex items-center gap-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold px-4 py-3 rounded-xl">
            <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
            {{ $errors->first() }}
        </div>
    @endif

    {{-- ══════════════════════════════════════════
         TAB CONTAINER
    ══════════════════════════════════════════ --}}
    <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs overflow-hidden">

        {{-- ── Tab Bar ── --}}
        <div class="flex flex-wrap border-b border-slate-100 px-1 pt-1 gap-1 bg-slate-50/60">
            <button id="tab-districts" onclick="switchMasterTab('districts')" data-active="true"
                    class="tab-btn flex items-center gap-2 px-4 py-3 text-xs font-bold rounded-t-xl transition-all
                           text-primary bg-white border border-b-0 border-slate-200">
                <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                Wilayah
                <span class="px-1.5 py-0.5 rounded-full bg-slate-200 text-slate-600 text-[9px] font-black leading-none">{{ $districts->count() }}</span>
            </button>

            <button id="tab-event-types" onclick="switchMasterTab('event-types')"
                    class="tab-btn flex items-center gap-2 px-4 py-3 text-xs font-bold rounded-t-xl transition-all
                           text-slate-500 hover:text-slate-700 hover:bg-white/60">
                <i data-lucide="party-popper" class="w-3.5 h-3.5"></i>
                Kategori Acara
                <span class="px-1.5 py-0.5 rounded-full bg-slate-200 text-slate-600 text-[9px] font-black leading-none">{{ $eventTypes->count() }}</span>
            </button>

            <button id="tab-themes" onclick="switchMasterTab('themes')"
                    class="tab-btn flex items-center gap-2 px-4 py-3 text-xs font-bold rounded-t-xl transition-all
                           text-slate-500 hover:text-slate-700 hover:bg-white/60">
                <i data-lucide="palette" class="w-3.5 h-3.5"></i>
                Tema
                <span class="px-1.5 py-0.5 rounded-full bg-slate-200 text-slate-600 text-[9px] font-black leading-none">{{ $themes->count() }}</span>
            </button>

            <button id="tab-theme-types" onclick="switchMasterTab('theme-types')"
                    class="tab-btn flex items-center gap-2 px-4 py-3 text-xs font-bold rounded-t-xl transition-all
                           text-slate-500 hover:text-slate-700 hover:bg-white/60">
                <i data-lucide="shapes" class="w-3.5 h-3.5"></i>
                Jenis Tema
                <span class="px-1.5 py-0.5 rounded-full bg-slate-200 text-slate-600 text-[9px] font-black leading-none">{{ $themeTypes->count() }}</span>
            </button>

            <button id="tab-makeup-looks" onclick="switchMasterTab('makeup-looks')"
                    class="tab-btn flex items-center gap-2 px-4 py-3 text-xs font-bold rounded-t-xl transition-all
                           text-slate-500 hover:text-slate-700 hover:bg-white/60">
                <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                Look Riasan
                <span class="px-1.5 py-0.5 rounded-full bg-slate-200 text-slate-600 text-[9px] font-black leading-none">{{ $makeupLooks->count() }}</span>
            </button>

            <button id="tab-price-ranges" onclick="switchMasterTab('price-ranges')"
                    class="tab-btn flex items-center gap-2 px-4 py-3 text-xs font-bold rounded-t-xl transition-all
                           text-slate-500 hover:text-slate-700 hover:bg-white/60">
                <i data-lucide="wallet" class="w-3.5 h-3.5"></i>
                Rentang Harga
                <span class="px-1.5 py-0.5 rounded-full bg-slate-200 text-slate-600 text-[9px] font-black leading-none">{{ $priceRanges->count() }}</span>
            </button>

            <button id="tab-package-templates" onclick="switchMasterTab('package-templates')"
                    class="tab-btn flex items-center gap-2 px-4 py-3 text-xs font-bold rounded-t-xl transition-all
                           text-slate-500 hover:text-slate-700 hover:bg-white/60">
                <i data-lucide="package" class="w-3.5 h-3.5"></i>
                Template Paket
                <span class="px-1.5 py-0.5 rounded-full bg-slate-200 text-slate-600 text-[9px] font-black leading-none">{{ $packageTemplates->count() }}</span>
            </button>
        </div>

        {{-- ══════════════════════════════════════════
             PANEL: WILAYAH (DISTRICTS)
        ══════════════════════════════════════════ --}}
        <div id="panel-districts" class="p-5">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <form action="{{ route('admin.master.districts.store') }}" method="POST" class="space-y-3 lg:col-span-1">
                    @csrf
                    <h3 class="text-xs font-bold text-slate-700">Tambah Kecamatan</h3>
                    <input type="text" name="name" required placeholder="Nama kecamatan"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                    <button type="submit" class="w-full px-3 py-2 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary/90 active:scale-95 transition flex items-center justify-center gap-1.5">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah
                    </button>
                </form>

                <div class="lg:col-span-2">
                    @if($districts->isEmpty())
                        <p class="text-xs text-slate-400 text-center py-8">Belum ada data kecamatan.</p>
                    @else
                        <div class="divide-y divide-slate-100 border border-slate-100 rounded-xl overflow-hidden">
                            @foreach($districts as $item)
                                <div class="flex items-center justify-between px-4 py-2.5 hover:bg-slate-50/60 transition-colors">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="text-xs font-semibold text-slate-700 truncate">{{ $item->name }}</span>
                                        <span class="text-[10px] text-slate-400 flex-shrink-0">{{ $item->muas_count }} mitra</span>
                                    </div>
                                    <form action="{{ route('admin.master.districts.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Hapus kecamatan {{ addslashes($item->name) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Hapus"
                                                class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-rose-500 hover:text-white text-slate-500 flex items-center justify-center transition-colors flex-shrink-0">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             PANEL: KATEGORI ACARA (EVENT TYPES)
        ══════════════════════════════════════════ --}}
        <div id="panel-event-types" class="p-5 hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <form action="{{ route('admin.master.event-types.store') }}" method="POST" class="space-y-3 lg:col-span-1">
                    @csrf
                    <h3 class="text-xs font-bold text-slate-700">Tambah Kategori Acara</h3>
                    <input type="text" name="name" required placeholder="Nama acara (mis. Akad Nikah)"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                    <input type="number" name="sort_order" required min="0" value="0" placeholder="Urutan tampil"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                    <label class="flex items-center gap-2 text-[11px] font-semibold text-slate-600">
                        <input type="checkbox" name="is_siraman" value="1" class="rounded border-slate-300 text-primary focus:ring-primary/30">
                        Termasuk acara Siraman
                    </label>
                    <button type="submit" class="w-full px-3 py-2 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary/90 active:scale-95 transition flex items-center justify-center gap-1.5">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah
                    </button>
                </form>

                <div class="lg:col-span-2">
                    @if($eventTypes->isEmpty())
                        <p class="text-xs text-slate-400 text-center py-8">Belum ada data kategori acara.</p>
                    @else
                        <div class="divide-y divide-slate-100 border border-slate-100 rounded-xl overflow-hidden">
                            @foreach($eventTypes as $item)
                                <div class="flex items-center justify-between px-4 py-2.5 hover:bg-slate-50/60 transition-colors">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="w-6 h-6 flex-shrink-0 flex items-center justify-center rounded-lg bg-slate-100 text-[9px] font-bold text-slate-500">{{ $item->sort_order }}</span>
                                        <span class="text-xs font-semibold text-slate-700 truncate">{{ $item->name }}</span>
                                        @if($item->is_siraman)
                                            <span class="px-2 py-0.5 rounded-full bg-sky-50 text-sky-600 text-[9px] font-bold flex-shrink-0">Siraman</span>
                                        @endif
                                        <span class="text-[10px] text-slate-400 flex-shrink-0">{{ $item->muas_count }} mitra</span>
                                    </div>
                                    <form action="{{ route('admin.master.event-types.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Hapus kategori acara {{ addslashes($item->name) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Hapus"
                                                class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-rose-500 hover:text-white text-slate-500 flex items-center justify-center transition-colors flex-shrink-0">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             PANEL: TEMA (THEMES)
        ══════════════════════════════════════════ --}}
        <div id="panel-themes" class="p-5 hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <form action="{{ route('admin.master.themes.store') }}" method="POST" class="space-y-3 lg:col-span-1">
                    @csrf
                    <h3 class="text-xs font-bold text-slate-700">Tambah Tema</h3>
                    <input type="text" name="name" required placeholder="Nama tema (mis. Adat, Modern)"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                    <button type="submit" class="w-full px-3 py-2 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary/90 active:scale-95 transition flex items-center justify-center gap-1.5">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah
                    </button>
                </form>

                <div class="lg:col-span-2">
                    @if($themes->isEmpty())
                        <p class="text-xs text-slate-400 text-center py-8">Belum ada data tema.</p>
                    @else
                        <div class="divide-y divide-slate-100 border border-slate-100 rounded-xl overflow-hidden">
                            @foreach($themes as $item)
                                <div class="flex items-center justify-between px-4 py-2.5 hover:bg-slate-50/60 transition-colors">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="text-xs font-semibold text-slate-700 truncate">{{ $item->name }}</span>
                                        <span class="text-[10px] text-slate-400 flex-shrink-0">{{ $item->themeTypes->count() }} jenis tema · {{ $item->muas_count }} mitra</span>
                                    </div>
                                    <form action="{{ route('admin.master.themes.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Hapus tema {{ addslashes($item->name) }}? Jenis tema turunannya akan ikut terhapus.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Hapus"
                                                class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-rose-500 hover:text-white text-slate-500 flex items-center justify-center transition-colors flex-shrink-0">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             PANEL: JENIS TEMA (THEME TYPES)
        ══════════════════════════════════════════ --}}
        <div id="panel-theme-types" class="p-5 hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <form action="{{ route('admin.master.theme-types.store') }}" method="POST" class="space-y-3 lg:col-span-1">
                    @csrf
                    <h3 class="text-xs font-bold text-slate-700">Tambah Jenis Tema</h3>
                    <select name="theme_id" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                        <option value="">Pilih tema induk</option>
                        @foreach($themes as $theme)
                            <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="name" required placeholder="Nama jenis tema (mis. Jawa, Sunda)"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                    <button type="submit" class="w-full px-3 py-2 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary/90 active:scale-95 transition flex items-center justify-center gap-1.5">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah
                    </button>
                </form>

                <div class="lg:col-span-2">
                    @if($themeTypes->isEmpty())
                        <p class="text-xs text-slate-400 text-center py-8">Belum ada data jenis tema.</p>
                    @else
                        <div class="divide-y divide-slate-100 border border-slate-100 rounded-xl overflow-hidden">
                            @foreach($themeTypes as $item)
                                <div class="flex items-center justify-between px-4 py-2.5 hover:bg-slate-50/60 transition-colors">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="text-xs font-semibold text-slate-700 truncate">{{ $item->name }}</span>
                                        <span class="px-2 py-0.5 rounded-full bg-violet-50 text-violet-600 text-[9px] font-bold flex-shrink-0">{{ $item->theme?->name ?? '-' }}</span>
                                        <span class="text-[10px] text-slate-400 flex-shrink-0">{{ $item->muas_count }} mitra</span>
                                    </div>
                                    <form action="{{ route('admin.master.theme-types.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Hapus jenis tema {{ addslashes($item->name) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Hapus"
                                                class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-rose-500 hover:text-white text-slate-500 flex items-center justify-center transition-colors flex-shrink-0">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             PANEL: LOOK RIASAN (MAKEUP LOOKS)
        ══════════════════════════════════════════ --}}
        <div id="panel-makeup-looks" class="p-5 hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <form action="{{ route('admin.master.makeup-looks.store') }}" method="POST" class="space-y-3 lg:col-span-1">
                    @csrf
                    <h3 class="text-xs font-bold text-slate-700">Tambah Look Riasan</h3>
                    <input type="text" name="name" required placeholder="Nama look (mis. Soft, Bold, Korean)"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                    <button type="submit" class="w-full px-3 py-2 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary/90 active:scale-95 transition flex items-center justify-center gap-1.5">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah
                    </button>
                </form>

                <div class="lg:col-span-2">
                    @if($makeupLooks->isEmpty())
                        <p class="text-xs text-slate-400 text-center py-8">Belum ada data look riasan.</p>
                    @else
                        <div class="divide-y divide-slate-100 border border-slate-100 rounded-xl overflow-hidden">
                            @foreach($makeupLooks as $item)
                                <div class="flex items-center justify-between px-4 py-2.5 hover:bg-slate-50/60 transition-colors">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="text-xs font-semibold text-slate-700 truncate">{{ $item->name }}</span>
                                        <span class="text-[10px] text-slate-400 flex-shrink-0">{{ $item->muas_count }} mitra</span>
                                    </div>
                                    <form action="{{ route('admin.master.makeup-looks.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Hapus look riasan {{ addslashes($item->name) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Hapus"
                                                class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-rose-500 hover:text-white text-slate-500 flex items-center justify-center transition-colors flex-shrink-0">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             PANEL: RENTANG HARGA (PRICE RANGES)
        ══════════════════════════════════════════ --}}
        <div id="panel-price-ranges" class="p-5 hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <form action="{{ route('admin.master.price-ranges.store') }}" method="POST" class="space-y-3 lg:col-span-1">
                    @csrf
                    <h3 class="text-xs font-bold text-slate-700">Tambah Rentang Harga</h3>
                    <input type="text" name="label" required placeholder="Label (mis. Ekonomis, Premium)"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" name="min_price" min="0" placeholder="Harga min (Rp)"
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                        <input type="number" name="max_price" min="0" placeholder="Harga maks (Rp)"
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                    </div>
                    <input type="number" name="sort_order" required min="0" value="0" placeholder="Urutan tampil"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                    <button type="submit" class="w-full px-3 py-2 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary/90 active:scale-95 transition flex items-center justify-center gap-1.5">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah
                    </button>
                </form>

                <div class="lg:col-span-2">
                    @if($priceRanges->isEmpty())
                        <p class="text-xs text-slate-400 text-center py-8">Belum ada data rentang harga.</p>
                    @else
                        <div class="divide-y divide-slate-100 border border-slate-100 rounded-xl overflow-hidden">
                            @foreach($priceRanges as $item)
                                <div class="flex items-center justify-between px-4 py-2.5 hover:bg-slate-50/60 transition-colors">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="w-6 h-6 flex-shrink-0 flex items-center justify-center rounded-lg bg-slate-100 text-[9px] font-bold text-slate-500">{{ $item->sort_order }}</span>
                                        <span class="text-xs font-semibold text-slate-700 truncate">{{ $item->label }}</span>
                                        <span class="text-[10px] text-slate-400 flex-shrink-0">
                                            @if($item->min_price && $item->max_price)
                                                Rp {{ number_format($item->min_price, 0, ',', '.') }} – Rp {{ number_format($item->max_price, 0, ',', '.') }}
                                            @elseif($item->max_price)
                                                &lt; Rp {{ number_format($item->max_price, 0, ',', '.') }}
                                            @elseif($item->min_price)
                                                &gt; Rp {{ number_format($item->min_price, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </div>
                                    <form action="{{ route('admin.master.price-ranges.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Hapus rentang harga {{ addslashes($item->label) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Hapus"
                                                class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-rose-500 hover:text-white text-slate-500 flex items-center justify-center transition-colors flex-shrink-0">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             PANEL: TEMPLATE PAKET (PACKAGE TEMPLATES)
        ══════════════════════════════════════════ --}}
        <div id="panel-package-templates" class="p-5 hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <form action="{{ route('admin.master.package-templates.store') }}" method="POST" class="space-y-3 lg:col-span-1">
                    @csrf
                    <h3 class="text-xs font-bold text-slate-700">Tambah Template Paket</h3>
                    <select name="event_type_id" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                        <option value="">Pilih jenis acara</option>
                        @foreach($eventTypes as $eventType)
                            <option value="{{ $eventType->id }}">{{ $eventType->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="name" required placeholder="Nama paket (mis. Paket Silver)"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                    <textarea name="description" rows="2" placeholder="Deskripsi singkat paket (opsional)"
                              class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition resize-none"></textarea>
                    <textarea name="includes" rows="4" placeholder="Daftar item termasuk (1 baris = 1 item), mis:&#10;Makeup pengantin&#10;Makeup keluarga 2 orang&#10;Dokumentasi foto"
                              class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition resize-none"></textarea>
                    <input type="number" name="sort_order" required min="0" value="0" placeholder="Urutan tampil"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                    <button type="submit" class="w-full px-3 py-2 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary/90 active:scale-95 transition flex items-center justify-center gap-1.5">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah
                    </button>
                </form>

                <div class="lg:col-span-2">
                    @if($packageTemplates->isEmpty())
                        <p class="text-xs text-slate-400 text-center py-8">Belum ada template paket.</p>
                    @else
                        <div class="space-y-2">
                            @foreach($packageTemplates as $item)
                                <div class="px-4 py-3 border border-slate-100 rounded-xl hover:bg-slate-50/60 transition-colors">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span class="px-2 py-0.5 rounded-full bg-primary-soft text-primary text-[9px] font-bold flex-shrink-0">{{ $item->eventType?->name ?? '-' }}</span>
                                                <span class="text-xs font-semibold text-slate-700">{{ $item->name }}</span>
                                                <span class="text-[10px] text-slate-400 flex-shrink-0">{{ $item->mua_packages_count }} mitra pakai</span>
                                            </div>
                                            @if($item->description)
                                                <p class="text-[10px] text-slate-400 mt-1">{{ $item->description }}</p>
                                            @endif
                                            @if($item->includes->isNotEmpty())
                                                <ul class="mt-1.5 space-y-0.5">
                                                    @foreach($item->includes as $include)
                                                        <li class="text-[10px] text-slate-500 flex items-center gap-1.5">
                                                            <i data-lucide="check" class="w-2.5 h-2.5 text-emerald-500 flex-shrink-0"></i>
                                                            {{ $include->include_item }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                        <form action="{{ route('admin.master.package-templates.destroy', $item) }}" method="POST"
                                              onsubmit="return confirm('Hapus template paket {{ addslashes($item->name) }}?')" class="flex-shrink-0">
                                            @csrf @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                    class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-rose-500 hover:text-white text-slate-500 flex items-center justify-center transition-colors">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>{{-- /tab container --}}
</div>

<script>
    function switchMasterTab(tab) {
        const tabs = ['districts', 'event-types', 'themes', 'theme-types', 'makeup-looks', 'price-ranges', 'package-templates'];

        tabs.forEach(t => {
            const btn   = document.getElementById('tab-' + t);
            const panel = document.getElementById('panel-' + t);

            if (t === tab) {
                btn.classList.add('bg-white', 'border', 'border-b-0', 'border-slate-200', 'text-primary');
                btn.classList.remove('hover:bg-white/60', 'text-slate-500', 'hover:text-slate-700');
                panel.classList.remove('hidden');
            } else {
                btn.classList.remove('bg-white', 'border', 'border-b-0', 'border-slate-200', 'text-primary');
                btn.classList.add('text-slate-500', 'hover:text-slate-700', 'hover:bg-white/60');
                panel.classList.add('hidden');
            }
        });

        history.replaceState(null, '', '#' + tab);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const hash = location.hash.replace('#', '');
        const tabs = ['districts', 'event-types', 'themes', 'theme-types', 'makeup-looks', 'price-ranges', 'package-templates'];
        switchMasterTab(tabs.includes(hash) ? hash : 'districts');
    });
</script>
@endsection
