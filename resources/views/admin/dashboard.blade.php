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
                        <span class="w-5 h-5 rounded-full bg-white border border-slate-200 flex items-center justify-center text-[10px] text-slate-400 cursor-pointer">‹</span>
                        <span class="w-5 h-5 rounded-full bg-white border border-slate-200 flex items-center justify-center text-[10px] text-slate-400 cursor-pointer">›</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <!-- Card 1 -->
                    <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs flex flex-col justify-between h-40">
                        <div class="flex items-start justify-between">
                            <div class="space-y-1">
                                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Total Mitra</span>
                                <h4 class="font-display font-black text-slate-800 text-lg leading-tight">Mitra MUA</h4>
                                <span class="block text-[10px] text-slate-400">Terdaftar: <strong>{{ $stats['total_mua'] }}</strong> MUA</span>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-lg">🤝</div>
                        </div>
                        <div class="space-y-1.5">
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-primary h-1.5 rounded-full" style="width: {{ $stats['total_mua'] > 0 ? '70%' : '0%' }}"></div>
                            </div>
                            <span class="block text-[9px] text-slate-400 font-medium">Batas maksimum: 50 Mitra</span>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs flex flex-col justify-between h-40">
                        <div class="flex items-start justify-between">
                            <div class="space-y-1">
                                <span class="block text-[9px] font-bold text-emerald-500 uppercase tracking-wider">Aktif</span>
                                <h4 class="font-display font-black text-slate-800 text-lg leading-tight">Mitra Aktif</h4>
                                <span class="block text-[10px] text-slate-400">Aktif: <strong>{{ $stats['active_mua'] }}</strong> MUA</span>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-lg">💚</div>
                        </div>
                        <div class="space-y-1.5">
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $stats['total_mua'] > 0 ? (($stats['active_mua'] / max($stats['total_mua'], 1)) * 100) . '%' : '0%' }}"></div>
                            </div>
                            <span class="block text-[9px] text-slate-400 font-medium">Rasio aktif: {{ $stats['total_mua'] > 0 ? round(($stats['active_mua'] / $stats['total_mua']) * 100) : 0 }}%</span>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs flex flex-col justify-between h-40">
                        <div class="flex items-start justify-between">
                            <div class="space-y-1">
                                <span class="block text-[9px] font-bold text-amber-500 uppercase tracking-wider">Persetujuan</span>
                                <h4 class="font-display font-black text-slate-800 text-lg leading-tight">Mitra Pending</h4>
                                <span class="block text-[10px] text-slate-400">Belum disetujui: <strong>{{ $stats['inactive_mua'] }}</strong></span>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-lg">⏳</div>
                        </div>
                        <div class="space-y-1.5">
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $stats['total_mua'] > 0 ? (($stats['inactive_mua'] / max($stats['total_mua'], 1)) * 100) . '%' : '0%' }}"></div>
                            </div>
                            <span class="block text-[9px] text-slate-400 font-medium">Memerlukan verifikasi admin</span>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs flex flex-col justify-between h-40">
                        <div class="flex items-start justify-between">
                            <div class="space-y-1">
                                <span class="block text-[9px] font-bold text-primary uppercase tracking-wider">Kunjungan</span>
                                <h4 class="font-display font-black text-slate-800 text-lg leading-tight">Cari Hari Ini</h4>
                                <span class="block text-[10px] text-slate-400">Pencarian klien: <strong>{{ $stats['search_today'] }}</strong></span>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-lg">🔍</div>
                        </div>
                        <div class="space-y-1.5">
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-primary h-1.5 rounded-full" style="width: {{ $stats['search_today'] > 0 ? '50%' : '0%' }}"></div>
                            </div>
                            <span class="block text-[9px] text-slate-400 font-medium">Beban server: Normal</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Recent Search Logs Table (resembles My Courses / Listings) -->
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
                
                <div class="space-y-4 text-[11px] text-slate-500">
                    <div class="flex gap-3">
                        <span class="text-primary font-bold">✔</span>
                        <div>
                            <span class="font-bold text-slate-800 block">Sesi Admin Diotorisasi</span>
                            <span class="text-[9px] text-slate-400 block mt-0.5">Baru saja</span>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="text-emerald-500 font-bold">✔</span>
                        <div>
                            <span class="font-bold text-slate-800 block">Kompilasi Vektor Sukses</span>
                            <span class="text-[9px] text-slate-400 block mt-0.5">1 jam yang lalu</span>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="text-amber-500 font-bold">✔</span>
                        <div>
                            <span class="font-bold text-slate-800 block">Pendafaran MUA Masuk</span>
                            <span class="text-[9px] text-slate-400 block mt-0.5">Kemarin</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Administrative Checks List (resembles Upcoming Assignments) -->
            <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs text-left space-y-4">
                <h3 class="font-display font-bold text-slate-800 text-xs tracking-wide">Audit Data Master</h3>
                
                <div class="space-y-3">
                    <!-- Check 1 -->
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-between text-xs font-sans">
                        <div>
                            <span class="font-bold text-slate-800 block text-[11px]">Master Wilayah (Kecamatan)</span>
                            <span class="text-[9px] text-slate-400 block mt-0.5">Terdaftar: 20 Kecamatan</span>
                        </div>
                        <span class="text-emerald-500 font-bold text-sm">✔</span>
                    </div>

                    <!-- Check 2 -->
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-between text-xs font-sans">
                        <div>
                            <span class="font-bold text-slate-800 block text-[11px]">Master Kategori Acara</span>
                            <span class="text-[9px] text-slate-400 block mt-0.5">Terdaftar: 5 jenis acara</span>
                        </div>
                        <span class="text-emerald-500 font-bold text-sm">✔</span>
                    </div>

                    <!-- Check 3 -->
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-between text-xs font-sans">
                        <div>
                            <span class="font-bold text-slate-800 block text-[11px]">Mitra Pending Verifikasi</span>
                            <span class="text-[9px] text-slate-400 block mt-0.5">Menunggu: {{ $stats['inactive_mua'] }} Mitra</span>
                        </div>
                        @if($stats['inactive_mua'] > 0)
                            <a href="{{ route('admin.mua.index') }}"
                               class="text-amber-500 font-bold text-[10px] hover:underline flex items-center gap-1">
                                Tinjau →
                            </a>
                        @else
                            <span class="text-emerald-500 font-bold text-sm">✔</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
