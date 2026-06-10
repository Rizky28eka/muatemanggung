@extends('layouts.dashboard')

@section('title', 'Log Pencarian — MUA Temanggung')

@section('content')
<div class="space-y-6 text-left">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h3 class="font-display font-bold text-slate-800 text-sm tracking-wide">Log Pencarian Klien</h3>
            <span class="text-[10px] text-slate-400 block mt-1">
                Menampilkan {{ $logs->firstItem() ?? 0 }}–{{ $logs->lastItem() ?? 0 }} dari {{ $logs->total() }} total pencarian preferensi.
            </span>
        </div>
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-slate-200 text-slate-600 hover:text-primary hover:border-primary/30 text-xs font-bold transition-colors">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Kembali ke Dashboard
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200/50 shadow-xs overflow-hidden">
        @if($logs->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs divide-y divide-slate-100">
                    <thead class="bg-slate-50 font-mono text-slate-400 uppercase text-[9px] tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4">Preferensi Klien</th>
                            <th class="px-6 py-4">Top 1</th>
                            <th class="px-6 py-4">Top 2</th>
                            <th class="px-6 py-4">Top 3</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($logs as $log)
                            <tr class="hover:bg-slate-50/50 align-top">
                                <td class="px-6 py-4 whitespace-nowrap text-[11px] font-mono text-slate-400">
                                    {{ $log->searched_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1.5 max-w-[320px]">
                                        <span class="px-2 py-0.5 rounded-full bg-violet-50 text-violet-600 text-[9px] font-bold">
                                            📍 {{ $log->district_name ?? '-' }}
                                        </span>
                                        <span class="px-2 py-0.5 rounded-full bg-sky-50 text-sky-600 text-[9px] font-bold">
                                            🎉 {{ $log->event_type_name ?? '-' }}
                                        </span>
                                        @if($log->theme_name)
                                            <span class="px-2 py-0.5 rounded-full bg-pink-50 text-pink-600 text-[9px] font-bold">
                                                🎨 {{ $log->theme_name }}
                                            </span>
                                        @endif
                                        @if($log->theme_type_name)
                                            <span class="px-2 py-0.5 rounded-full bg-fuchsia-50 text-fuchsia-600 text-[9px] font-bold">
                                                {{ $log->theme_type_name }}
                                            </span>
                                        @endif
                                        @if($log->makeup_look_name)
                                            <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[9px] font-bold">
                                                💄 {{ $log->makeup_look_name }}
                                            </span>
                                        @endif
                                        @if($log->price_range_label)
                                            <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 text-[9px] font-bold">
                                                💰 {{ $log->price_range_label }}
                                            </span>
                                        @endif
                                        @if($log->wants_home_service)
                                            <span class="px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-600 text-[9px] font-bold">
                                                🏠 Home Service
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($log->top1)
                                        <span class="font-bold text-primary text-[11px] block">{{ $log->top1->name }}</span>
                                        <span class="text-[9px] text-slate-400">{{ $log->score1 }}% match</span>
                                    @else
                                        <span class="text-slate-300 text-[11px]">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($log->top2)
                                        <span class="font-bold text-slate-700 text-[11px] block">{{ $log->top2->name }}</span>
                                        <span class="text-[9px] text-slate-400">{{ $log->score2 }}% match</span>
                                    @else
                                        <span class="text-slate-300 text-[11px]">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($log->top3)
                                        <span class="font-bold text-slate-700 text-[11px] block">{{ $log->top3->name }}</span>
                                        <span class="text-[9px] text-slate-400">{{ $log->score3 }}% match</span>
                                    @else
                                        <span class="text-slate-300 text-[11px]">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $logs->links() }}
                </div>
            @endif
        @else
            <div class="p-10 text-center text-xs text-slate-400">
                Belum ada log pencarian klien terekam.
            </div>
        @endif
    </div>

</div>
@endsection
