<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mua;
use App\Models\SearchLog;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
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

        return view('admin.dashboard', compact('stats', 'recentSearches'));
    }
}
