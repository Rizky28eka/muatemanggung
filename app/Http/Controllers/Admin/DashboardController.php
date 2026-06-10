<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\EventType;
use App\Models\MakeupLook;
use App\Models\Mua;
use App\Models\SearchLog;
use App\Models\Theme;

class DashboardController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        $stats = [
            'total_mua'    => Mua::count(),
            'active_mua'   => Mua::where('is_active', true)->count(),
            'inactive_mua' => Mua::where('is_active', false)->count(),
            'total_search' => SearchLog::count(),
            'search_today' => SearchLog::whereDate('searched_at', today())->count(),
        ];

        $recentSearches = SearchLog::with(['top1', 'top2', 'top3'])
            ->latest('searched_at')
            ->limit(5)
            ->get();

        $masterCounts = [
            'districts'    => District::count(),
            'event_types'  => EventType::count(),
            'themes'       => Theme::count(),
            'makeup_looks' => MakeupLook::count(),
        ];

        $pendingMuas = Mua::with('user')
            ->where('is_active', false)
            ->latest()
            ->limit(5)
            ->get();

        // Unified recent activity feed: new MUA registrations + recent searches
        $activity = collect();

        foreach (Mua::latest()->limit(5)->get() as $mua) {
            $activity->push([
                'type'  => $mua->is_active ? 'mua_active' : 'mua_pending',
                'title' => $mua->is_active
                    ? "Mitra \"{$mua->name}\" terdaftar & aktif"
                    : "Pendaftaran mitra baru: \"{$mua->name}\"",
                'time'  => $mua->created_at,
            ]);
        }

        foreach (SearchLog::with('top1')->latest('searched_at')->limit(5)->get() as $log) {
            $activity->push([
                'type'  => 'search',
                'title' => $log->top1
                    ? "Klien mencari rekomendasi, hasil teratas: \"{$log->top1->name}\""
                    : 'Klien mencari rekomendasi, belum ada hasil cocok',
                'time'  => $log->searched_at,
            ]);
        }

        $activity = $activity
            ->filter(fn ($a) => $a['time'] !== null)
            ->sortByDesc('time')
            ->take(5)
            ->values();

        return view('admin.dashboard', compact('stats', 'recentSearches', 'masterCounts', 'pendingMuas', 'activity'));
    }
}
