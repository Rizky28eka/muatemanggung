<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SearchLog;

class SearchLogController extends Controller
{
    public function index()
    {
        $logs = SearchLog::with(['top1', 'top2', 'top3'])
            ->latest('searched_at')
            ->paginate(20);

        return view('admin.monitoring.searches', compact('logs'));
    }
}
