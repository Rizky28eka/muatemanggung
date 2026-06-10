@extends('layouts.dashboard')

@section('title', 'Monitoring — MUA Temanggung')

@section('content')
<div class="space-y-6 text-left">

    <!-- Header -->
    <div>
        <h3 class="font-display font-bold text-slate-800 text-sm tracking-wide">Ringkasan Monitoring</h3>
        <span class="text-[10px] text-slate-400 block mt-1">
            Pantau aktivitas pencarian rekomendasi dan performa mitra MUA secara real-time.
        </span>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500 flex-shrink-0">
                <i data-lucide="trending-up" class="w-5 h-5"></i>
            </div>
            <div class="min-w-0">
                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Total</span>
                <span class="block text-lg font-display font-black text-slate-800 leading-tight">{{ $stats['total_search'] }}</span>
                <span class="block text-[9px] text-slate-400">Pencarian</span>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-500 flex-shrink-0">
                <i data-lucide="search" class="w-5 h-5"></i>
            </div>
            <div class="min-w-0">
                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Hari Ini</span>
                <span class="block text-lg font-display font-black text-slate-800 leading-tight">{{ $stats['search_today'] }}</span>
                <span class="block text-[9px] text-slate-400">Pencarian</span>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500 flex-shrink-0">
                <i data-lucide="calendar-days" class="w-5 h-5"></i>
            </div>
            <div class="min-w-0">
                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">7 Hari Terakhir</span>
                <span class="block text-lg font-display font-black text-slate-800 leading-tight">{{ $stats['search_week'] }}</span>
                <span class="block text-[9px] text-slate-400">Pencarian</span>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 flex-shrink-0">
                <i data-lucide="alert-triangle" class="w-5 h-5"></i>
            </div>
            <div class="min-w-0">
                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Tanpa Hasil</span>
                <span class="block text-lg font-display font-black text-slate-800 leading-tight">{{ $stats['no_match'] }}</span>
                <span class="block text-[9px] text-slate-400">Pencarian</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Recent Logs Preview -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/50 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-xs font-display font-bold text-slate-800 uppercase tracking-wider">Log Pencarian Teranyar</h3>
                    <span class="text-[10px] text-slate-400 block mt-1">5 penelusuran preferensi teranyar dari calon pengantin.</span>
                </div>
                <a href="{{ route('admin.monitoring.searches') }}" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                    Lihat Semua Log <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
            </div>

            @if($recentLogs->isNotEmpty())
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
                            @foreach($recentLogs as $log)
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

        <!-- Top Recommended MUAs -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs text-left space-y-4">
            <h3 class="font-display font-bold text-slate-800 text-xs tracking-wide">Mitra Paling Sering Direkomendasikan</h3>

            @if($topMuas->isNotEmpty())
                <div class="space-y-2.5">
                    @foreach($topMuas as $row)
                        <div class="flex items-center justify-between gap-2 p-2.5 bg-slate-50 border border-slate-100 rounded-xl">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-7 h-7 rounded-lg bg-primary/10 text-primary font-bold flex items-center justify-center text-[10px] flex-shrink-0">
                                    #{{ $loop->iteration }}
                                </div>
                                <span class="block text-[11px] font-bold text-slate-800 truncate">{{ $row['mua']->name }}</span>
                            </div>
                            <span class="flex-shrink-0 text-[10px] font-bold text-primary">{{ $row['total'] }}x</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-[11px] text-slate-400 text-center py-4">Belum ada data rekomendasi.</div>
            @endif
        </div>

    </div>

</div>
@endsection
