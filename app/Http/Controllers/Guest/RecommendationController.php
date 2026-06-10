<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\EventType;
use App\Models\MakeupLook;
use App\Models\PriceRange;
use App\Models\Theme;
use App\Models\ThemeType;
use App\Services\RecommendationService;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function form()
    {
        return view('guest.recommendation.form', [
            'eventTypes'  => EventType::orderBy('sort_order')->get(),
            'themes'      => Theme::with('themeTypes')->orderBy('id')->get(),
            'themeTypes'  => ThemeType::with('theme')->orderBy('id')->get(),
            'makeupLooks' => MakeupLook::orderBy('id')->get(),
            'districts'   => District::orderBy('name')->get(),
            'priceRanges' => PriceRange::orderBy('sort_order')->get(),
        ]);
    }

    public function recommend(Request $request, RecommendationService $rs)
    {
        $data = $request->validate([
            'event_type_id'      => 'required|exists:event_types,id',
            'theme_id'           => 'nullable|exists:themes,id',
            'theme_type_id'      => 'nullable|exists:theme_types,id',
            'makeup_look_id'     => 'nullable|exists:makeup_looks,id',
            'district_id'        => 'required|exists:districts,id',
            'price_range_id'     => 'nullable|exists:price_ranges,id',
            'wants_home_service' => 'nullable|boolean',
        ]);

        $eventType = EventType::find($data['event_type_id']);
        $data['is_siraman'] = ($eventType && strtolower($eventType->slug ?? '') === 'siraman');

        $session = session()->getId();
        ['results' => $results, 'log' => $log] = $rs->recommend($data, $session);

        session(['last_results' => $results, 'last_log_id' => $log->id]);

        return redirect()->route('guest.recommendation.results');
    }

    public function results()
    {
        $results = session('last_results', []);

        if (empty($results)) {
            return redirect()->route('guest.recommendation.form')
                ->with('error', 'Sesi telah berakhir. Silakan cari ulang.');
        }

        return view('guest.recommendation.results', compact('results'));
    }
}
