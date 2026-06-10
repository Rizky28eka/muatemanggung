<?php

namespace App\Http\Controllers\Mua;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $mua = auth()->user()->mua()->with([
            'packages', 'portfolios', 'vector',
            'eventTypes', 'serviceDistricts',
        ])->firstOrFail();

        $stats = [
            'packages'      => $mua->packages->count(),
            'available_pkg' => $mua->packages->where('is_available', true)->count(),
            'portfolios'    => $mua->portfolios->count(),
            'has_vector'    => $mua->vector !== null,
            'is_active'     => $mua->is_active,
        ];

        return view('mua.dashboard', compact('mua', 'stats'));
    }
}
