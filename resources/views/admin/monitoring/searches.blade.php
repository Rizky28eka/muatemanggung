@extends('layouts.admin')
@section('title', 'Log Pencarian')
@section('page-title', 'Log Pencarian Rekomendasi')

@section('content')
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Session</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Rekomendasi Teratas</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Skor</th>
                <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($logs as $i => $log)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-5 py-4 text-gray-400 text-xs">{{ $logs->firstItem() + $i }}</td>
                <td class="px-5 py-4 font-mono text-xs text-gray-500">{{ substr($log->session_id, 0, 16) }}…</td>
                <td class="px-5 py-4">
                    <div class="space-y-0.5">
                        @if($log->top1)
                        <div class="flex items-center gap-1.5">
                            <span class="w-4 h-4 bg-yellow-100 text-yellow-700 rounded-full flex items-center justify-center text-[10px] font-bold shrink-0">1</span>
                            <span class="text-gray-700 font-medium">{{ $log->top1->name }}</span>
                        </div>
                        @endif
                        @if($log->top2)
                        <div class="flex items-center gap-1.5">
                            <span class="w-4 h-4 bg-gray-100 text-gray-500 rounded-full flex items-center justify-center text-[10px] font-bold shrink-0">2</span>
                            <span class="text-gray-500">{{ $log->top2->name }}</span>
                        </div>
                        @endif
                        @if($log->top3)
                        <div class="flex items-center gap-1.5">
                            <span class="w-4 h-4 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center text-[10px] font-bold shrink-0">3</span>
                            <span class="text-gray-500">{{ $log->top3->name }}</span>
                        </div>
                        @endif
                    </div>
                </td>
                <td class="px-5 py-4 hidden lg:table-cell">
                    <div class="space-y-0.5 text-xs text-gray-500">
                        @if($log->score1 !== null) <div>{{ number_format($log->score1, 1) }}%</div> @endif
                        @if($log->score2 !== null) <div>{{ number_format($log->score2, 1) }}%</div> @endif
                        @if($log->score3 !== null) <div>{{ number_format($log->score3, 1) }}%</div> @endif
                    </div>
                </td>
                <td class="px-5 py-4 text-right text-xs text-gray-400">
                    {{ $log->searched_at->format('d M Y, H:i') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-12 text-center text-gray-400 text-sm">Belum ada log pencarian.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($logs->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">{{ $logs->links() }}</div>
    @endif
</div>
@endsection
