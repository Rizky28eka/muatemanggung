@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    @php
        $cards = [
            ['label' => 'Total MUA',       'value' => $stats['total_mua'],    'color' => 'bg-violet-100 text-violet-700'],
            ['label' => 'MUA Aktif',        'value' => $stats['active_mua'],   'color' => 'bg-emerald-100 text-emerald-700'],
            ['label' => 'MUA Non-aktif',    'value' => $stats['inactive_mua'], 'color' => 'bg-red-100 text-red-700'],
            ['label' => 'Total Pencarian',  'value' => $stats['total_search'], 'color' => 'bg-blue-100 text-blue-700'],
            ['label' => 'Pencarian Hari Ini','value'=> $stats['search_today'], 'color' => 'bg-amber-100 text-amber-700'],
        ];
    @endphp
    @foreach($cards as $card)
    <div class="bg-white rounded-xl p-5 border border-gray-200">
        <div class="text-3xl font-bold {{ $card['color'] }} inline-block px-3 py-1 rounded-lg mb-2">
            {{ $card['value'] }}
        </div>
        <p class="text-sm text-gray-500 mt-1">{{ $card['label'] }}</p>
    </div>
    @endforeach
</div>

{{-- Shortcuts --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
    <a href="{{ route('admin.mua.create') }}"
       class="flex items-center gap-3 bg-violet-600 hover:bg-violet-700 text-white rounded-xl p-5 transition-colors no-underline">
        <span class="text-2xl">➕</span>
        <div>
            <div class="font-bold">Tambah MUA Baru</div>
            <div class="text-sm text-violet-200">Buat akun pengelola MUA</div>
        </div>
    </a>
    <a href="{{ route('admin.monitoring.searches') }}"
       class="flex items-center gap-3 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl p-5 transition-colors no-underline">
        <span class="text-2xl">📊</span>
        <div>
            <div class="font-bold text-gray-700">Lihat Log Pencarian</div>
            <div class="text-sm text-gray-400">Riwayat rekomendasi tamu</div>
        </div>
    </a>
</div>

{{-- Recent searches --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-semibold text-gray-700">Pencarian Terbaru</h3>
    </div>
    @if($recentSearches->isEmpty())
        <div class="px-6 py-8 text-center text-gray-400 text-sm">Belum ada data pencarian.</div>
    @else
    <div class="divide-y divide-gray-50">
        @foreach($recentSearches as $log)
        <div class="px-6 py-4 flex items-center justify-between">
            <div>
                <div class="text-sm font-medium text-gray-700">
                    {{ $log->top1?->name ?? '—' }}
                    @if($log->top2) <span class="text-gray-400">· {{ $log->top2->name }}</span> @endif
                    @if($log->top3) <span class="text-gray-400">· {{ $log->top3->name }}</span> @endif
                </div>
                <div class="text-xs text-gray-400 mt-0.5">
                    Session: {{ substr($log->session_id, 0, 12) }}...
                </div>
            </div>
            <span class="text-xs text-gray-400">{{ $log->searched_at->diffForHumans() }}</span>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
