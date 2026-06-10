@extends('layouts.dashboard')

@section('title', 'Admin Panel Dashboard — MUA Temanggung')

@section('content')
<div class="space-y-8 text-left">
    
    <!-- MAIN GRID LAYOUT -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- LEFT PANEL (Occupies 9 columns, main dashboard elements) -->
        <div class="lg:col-span-9 space-y-8">
            
            <!-- Section 1: Highlights Row (resembles Today's Schedule) -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display font-bold text-slate-800 text-sm tracking-wide">Statistik Monitoring Sistem</h3>
                    <div class="flex items-center gap-1.5">
                        <button type="button" onclick="document.getElementById('admin-stats-scroll').scrollBy({left: -260, behavior: 'smooth'})"
                                class="w-5 h-5 rounded-full bg-white border border-slate-200 flex items-center justify-center text-[10px] text-slate-400 hover:text-primary hover:border-primary/30 cursor-pointer transition-colors">‹</button>
                        <button type="button" onclick="document.getElementById('admin-stats-scroll').scrollBy({left: 260, behavior: 'smooth'})"
                                class="w-5 h-5 rounded-full bg-white border border-slate-200 flex items-center justify-center text-[10px] text-slate-400 hover:text-primary hover:border-primary/30 cursor-pointer transition-colors">›</button>
                    </div>
                </div>

                <div id="admin-stats-scroll" class="grid grid-flow-col auto-cols-[85%] sm:auto-cols-[60%] md:auto-cols-[calc((100%-2.5rem)/3)] gap-5 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-2 -mb-2 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                    <!-- Card 1 -->
                    <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs flex flex-col justify-between h-40 snap-start">
                        <div class="flex items-start justify-between">
                            <div class="space-y-1">
                                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Total Mitra</span>
                                <h4 class="font-display font-black text-slate-800 text-lg leading-tight">Mitra MUA</h4>
                                <span class="block text-[10px] text-slate-400">Terdaftar: <strong>{{ $stats['total_mua'] }}</strong> MUA</span>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-500">
                                <i data-lucide="users" class="w-5 h-5"></i>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-primary h-1.5 rounded-full" style="width: {{ $stats['total_mua'] > 0 ? '100%' : '0%' }}"></div>
                            </div>
                            <span class="block text-[9px] text-slate-400 font-medium">{{ $stats['active_mua'] }} aktif, {{ $stats['inactive_mua'] }} pending</span>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs flex flex-col justify-between h-40 snap-start">
                        <div class="flex items-start justify-between">
                            <div class="space-y-1">
                                <span class="block text-[9px] font-bold text-emerald-500 uppercase tracking-wider">Aktif</span>
                                <h4 class="font-display font-black text-slate-800 text-lg leading-tight">Mitra Aktif</h4>
                                <span class="block text-[10px] text-slate-400">Aktif: <strong>{{ $stats['active_mua'] }}</strong> MUA</span>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500">
                                <i data-lucide="user-check" class="w-5 h-5"></i>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $stats['total_mua'] > 0 ? (($stats['active_mua'] / max($stats['total_mua'], 1)) * 100) . '%' : '0%' }}"></div>
                            </div>
                            <span class="block text-[9px] text-slate-400 font-medium">Rasio aktif: {{ $stats['total_mua'] > 0 ? round(($stats['active_mua'] / $stats['total_mua']) * 100) : 0 }}%</span>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs flex flex-col justify-between h-40 snap-start">
                        <div class="flex items-start justify-between">
                            <div class="space-y-1">
                                <span class="block text-[9px] font-bold text-amber-500 uppercase tracking-wider">Persetujuan</span>
                                <h4 class="font-display font-black text-slate-800 text-lg leading-tight">Mitra Pending</h4>
                                <span class="block text-[10px] text-slate-400">Belum disetujui: <strong>{{ $stats['inactive_mua'] }}</strong></span>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500">
                                <i data-lucide="hourglass" class="w-5 h-5"></i>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $stats['total_mua'] > 0 ? (($stats['inactive_mua'] / max($stats['total_mua'], 1)) * 100) . '%' : '0%' }}"></div>
                            </div>
                            @if($stats['inactive_mua'] > 0)
                                <a href="{{ route('admin.mua.index') }}" class="block text-[9px] text-amber-600 font-bold hover:underline">Memerlukan verifikasi admin →</a>
                            @else
                                <span class="block text-[9px] text-slate-400 font-medium">Tidak ada antrean verifikasi</span>
                            @endif
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs flex flex-col justify-between h-40 snap-start">
                        <div class="flex items-start justify-between">
                            <div class="space-y-1">
                                <span class="block text-[9px] font-bold text-primary uppercase tracking-wider">Kunjungan</span>
                                <h4 class="font-display font-black text-slate-800 text-lg leading-tight">Cari Hari Ini</h4>
                                <span class="block text-[10px] text-slate-400">Pencarian klien: <strong>{{ $stats['search_today'] }}</strong></span>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-500">
                                <i data-lucide="search" class="w-5 h-5"></i>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-primary h-1.5 rounded-full" style="width: {{ $stats['total_search'] > 0 ? round(($stats['search_today'] / max($stats['total_search'], 1)) * 100) . '%' : '0%' }}"></div>
                            </div>
                            <span class="block text-[9px] text-slate-400 font-medium">Total sepanjang waktu: {{ $stats['total_search'] }}</span>
                        </div>
                    </div>

                    <!-- Card 5 -->
                    <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs flex flex-col justify-between h-40 snap-start">
                        <div class="flex items-start justify-between">
                            <div class="space-y-1">
                                <span class="block text-[9px] font-bold text-rose-500 uppercase tracking-wider">Total</span>
                                <h4 class="font-display font-black text-slate-800 text-lg leading-tight">Pencarian</h4>
                                <span class="block text-[10px] text-slate-400">Sepanjang waktu: <strong>{{ $stats['total_search'] }}</strong></span>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500">
                                <i data-lucide="trending-up" class="w-5 h-5"></i>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-rose-500 h-1.5 rounded-full" style="width: {{ $stats['total_search'] > 0 ? '100%' : '0%' }}"></div>
                            </div>
                            <a href="{{ route('admin.monitoring.searches') }}" class="block text-[9px] text-rose-500 font-bold hover:underline">Lihat seluruh log →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Master Data Audit Strip -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <a href="{{ route('admin.master.index') }}#districts" class="bg-white rounded-2xl border border-slate-200/50 p-4 shadow-xs flex items-center gap-3 hover:border-violet-200 hover:bg-violet-50/30 transition-colors">
                    <div class="w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center text-violet-500 flex-shrink-0">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                    </div>
                    <div class="min-w-0">
                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider truncate">Wilayah</span>
                        <span class="block text-sm font-display font-extrabold text-slate-800 leading-tight">{{ $masterCounts['districts'] }} <span class="text-[10px] font-semibold text-slate-400">Kecamatan</span></span>
                    </div>
                </a>
                <a href="{{ route('admin.master.index') }}#event-types" class="bg-white rounded-2xl border border-slate-200/50 p-4 shadow-xs flex items-center gap-3 hover:border-sky-200 hover:bg-sky-50/30 transition-colors">
                    <div class="w-9 h-9 rounded-xl bg-sky-50 flex items-center justify-center text-sky-500 flex-shrink-0">
                        <i data-lucide="party-popper" class="w-4 h-4"></i>
                    </div>
                    <div class="min-w-0">
                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider truncate">Kategori Acara</span>
                        <span class="block text-sm font-display font-extrabold text-slate-800 leading-tight">{{ $masterCounts['event_types'] }} <span class="text-[10px] font-semibold text-slate-400">Jenis Acara</span></span>
                    </div>
                </a>
                <a href="{{ route('admin.master.index') }}#themes" class="bg-white rounded-2xl border border-slate-200/50 p-4 shadow-xs flex items-center gap-3 hover:border-pink-200 hover:bg-pink-50/30 transition-colors">
                    <div class="w-9 h-9 rounded-xl bg-pink-50 flex items-center justify-center text-pink-500 flex-shrink-0">
                        <i data-lucide="palette" class="w-4 h-4"></i>
                    </div>
                    <div class="min-w-0">
                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider truncate">Tema & Look</span>
                        <span class="block text-sm font-display font-extrabold text-slate-800 leading-tight">{{ $masterCounts['themes'] }} <span class="text-[10px] font-semibold text-slate-400">Tema</span> · {{ $masterCounts['makeup_looks'] }} <span class="text-[10px] font-semibold text-slate-400">Look</span></span>
                    </div>
                </a>
                <a href="{{ route('admin.mua.index') }}" class="bg-white rounded-2xl border border-slate-200/50 p-4 shadow-xs flex items-center gap-3 hover:border-amber-200 hover:bg-amber-50/30 transition-colors">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 flex-shrink-0">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                    </div>
                    <div class="min-w-0">
                        <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider truncate">Verifikasi</span>
                        <span class="block text-sm font-display font-extrabold text-slate-800 leading-tight">{{ $stats['inactive_mua'] }} <span class="text-[10px] font-semibold text-slate-400">Mitra Pending</span></span>
                    </div>
                </a>
            </div>

            <!-- Section 3: Recent Search Logs Table (resembles My Courses / Listings) -->
            <div class="bg-white rounded-2xl border border-slate-200/50 shadow-xs overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-display font-bold text-slate-800 uppercase tracking-wider">Log Pencarian Teranyar</h3>
                        <span class="text-[10px] text-slate-400 block mt-1">5 penelusuran preferensi teranyar dari calon pengantin.</span>
                    </div>
                    <a href="{{ route('admin.monitoring.searches') }}" class="text-xs font-bold text-primary hover:underline">
                        Lihat Semua Log ➜
                    </a>
                </div>

                @if($recentSearches->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs divide-y divide-slate-100">
                            <thead class="bg-slate-50 font-mono text-slate-400 uppercase text-[9px] tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Waktu</th>
                                    <th class="px-6 py-4">Preferensi Klien</th>
                                    <th class="px-6 py-4">Top 1 Hasil</th>
                                    <th class="px-6 py-4">Top 2 & 3</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @foreach($recentSearches as $log)
                                    <tr class="hover:bg-slate-50/50">
                                        <td class="px-6 py-4 whitespace-nowrap text-[11px] font-mono text-slate-400">
                                            {{ $log->searched_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="max-w-[280px] truncate font-medium text-[11px]" title="{{ json_encode($log->preference_data) }}">
                                                Kec. {{ $log->district_name ?? 'Temanggung' }} | Acara: {{ $log->event_type_name ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="font-bold text-primary text-[11px]">{{ $log->top1 ? $log->top1->name : '-' }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-[11px] text-slate-400">
                                            {{ $log->top2 ? $log->top2->name : '-' }}, {{ $log->top3 ? $log->top3->name : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center text-xs text-slate-400">
                        Belum ada log pencarian klien terekam.
                    </div>
                @endif
            </div>

        </div>

        <!-- RIGHT PANEL (Occupies 3 columns, resembles Recent Activity & Tasks) -->
        <div class="lg:col-span-3 space-y-8">
            
            <!-- System Status Banner (StudyGo banner-like mockup card) -->
            <div class="bg-gradient-to-r from-primary to-accent rounded-3xl p-5 text-white relative overflow-hidden shadow-sm">
                <div class="absolute inset-0 bg-white/10 opacity-20 pointer-events-none"></div>
                <div class="relative z-10 space-y-3">
                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-white/20 text-[9px] font-bold uppercase tracking-wider">Status Sistem</span>
                    <h4 class="font-display font-black text-sm leading-tight text-left">Algoritma Cosine Similarity</h4>
                    <p class="text-[10px] text-white/80 leading-relaxed text-left">
                        Kompilasi matriks representasi biner jangkauan MUA serta preferensi look riasan sinkron secara real-time.
                    </p>
                </div>
            </div>

            <!-- Recent Activity Panel (resembles Recent Activity log) -->
            <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs text-left space-y-4">
                <h3 class="font-display font-bold text-slate-800 text-xs tracking-wide">Aktivitas Sistem</h3>

                @if($activity->isNotEmpty())
                    <div class="space-y-4 text-[11px] text-slate-500">
                        @foreach($activity as $item)
                            @php
                                $icon = match($item['type']) {
                                    'mua_active'  => ['user-check', 'text-emerald-500'],
                                    'mua_pending' => ['hourglass', 'text-amber-500'],
                                    'search'      => ['search', 'text-primary'],
                                    default       => ['circle', 'text-slate-400'],
                                };
                            @endphp
                            <div class="flex gap-3">
                                <i data-lucide="{{ $icon[0] }}" class="{{ $icon[1] }} w-4 h-4 flex-shrink-0 mt-0.5"></i>
                                <div class="min-w-0">
                                    <span class="font-bold text-slate-800 block leading-snug">{{ $item['title'] }}</span>
                                    <span class="text-[9px] text-slate-400 block mt-0.5">{{ $item['time']->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-[11px] text-slate-400 text-center py-4">Belum ada aktivitas terekam.</div>
                @endif
            </div>

            <!-- Pending MUA Quick Approve List -->
            <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs text-left space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-display font-bold text-slate-800 text-xs tracking-wide">Mitra Menunggu Persetujuan</h3>
                    @if($pendingMuas->isNotEmpty())
                        <a href="{{ route('admin.mua.index') }}" class="text-[10px] font-bold text-primary hover:underline">Lihat Semua</a>
                    @endif
                </div>

                @if($pendingMuas->isNotEmpty())
                    <div class="space-y-2.5">
                        @foreach($pendingMuas as $mua)
                            <div class="flex items-center justify-between gap-2 p-2.5 bg-slate-50 border border-slate-100 rounded-xl">
                                <div class="min-w-0">
                                    <span class="block text-[11px] font-bold text-slate-800 truncate">{{ $mua->name }}</span>
                                    <span class="block text-[9px] text-slate-400 truncate mt-0.5">{{ $mua->user->email ?? '-' }} &middot; {{ $mua->created_at->diffForHumans() }}</span>
                                </div>
                                <a href="{{ route('admin.mua.show', $mua) }}"
                                   class="flex-shrink-0 text-[10px] font-bold text-primary hover:underline">
                                    Tinjau →
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-[11px] text-slate-400 text-center py-4">Tidak ada mitra yang menunggu persetujuan.</div>
                @endif
            </div>

        </div>

    </div>

</div>
@endsection
