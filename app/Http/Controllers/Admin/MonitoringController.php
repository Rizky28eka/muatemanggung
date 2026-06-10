<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mua;
use App\Models\SearchLog;

class MonitoringController extends Controller
{
    public function index()
    {
        $stats = [
            'total_search'  => SearchLog::count(),
            'search_today'  => SearchLog::whereDate('searched_at', today())->count(),
            'search_week'   => SearchLog::where('searched_at', '>=', now()->subDays(7))->count(),
            'no_match'      => SearchLog::whereNull('top1_mua_id')->count(),
        ];

        $topMuas = SearchLog::query()
            ->selectRaw('top1_mua_id, count(*) as total')
            ->whereNotNull('top1_mua_id')
            ->groupBy('top1_mua_id')
            ->orderByDesc('total')
            ->limit(5)
            ->with('top1')
            ->get()
            ->map(fn ($row) => [
                'mua'   => $row->top1,
                'total' => $row->total,
            ])
            ->filter(fn ($row) => $row['mua'] !== null)
            ->values();

        $recentLogs = SearchLog::with(['top1', 'top2', 'top3'])
            ->latest('searched_at')
            ->limit(5)
            ->get();

        return view('admin.monitoring.index', compact('stats', 'topMuas', 'recentLogs'));
    }
}
