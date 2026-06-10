<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Mua;

class HomeController extends Controller
{
    public function index()
    {
        $featuredMuas = Mua::with(['makeupLooks', 'district', 'portfolios'])
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('guest.home', compact('featuredMuas'));
    }
}
