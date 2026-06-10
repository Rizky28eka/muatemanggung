<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Mua;

class MuaDetailController extends Controller
{
    public function show(string $slug)
    {
        $mua = Mua::where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'district',
                'serviceDistricts',
                'eventTypes',
                'themes',
                'themeTypes',
                'makeupLooks',
                'portfolios',
                'packages' => fn ($q) => $q->where('is_available', true)->with('template.eventType'),
            ])
            ->firstOrFail();

        return view('guest.mua.detail', compact('mua'));
    }
}
