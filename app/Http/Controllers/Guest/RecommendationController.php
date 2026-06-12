<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\EventType;
use App\Models\MakeupLook;
use App\Models\Mua;
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
        $isSiraman = ($eventType && strtolower($eventType->slug ?? '') === 'siraman');
        $data['is_siraman'] = $isSiraman;

        if ($isSiraman) {
            $adatTheme = Theme::where('slug', 'adat')->first();
            if ($adatTheme) {
                if (!empty($data['theme_id']) && $data['theme_id'] != $adatTheme->id) {
                    return back()->withErrors(['theme_id' => 'Acara Siraman hanya boleh menggunakan Tema Adat.'])->withInput();
                }
                $data['theme_id'] = $adatTheme->id;

                if (!empty($data['theme_type_id'])) {
                    $typeBelongsToAdat = ThemeType::where('id', $data['theme_type_id'])
                        ->where('theme_id', $adatTheme->id)
                        ->exists();
                    if (!$typeBelongsToAdat) {
                        return back()->withErrors(['theme_type_id' => 'Jenis tema tidak cocok dengan acara Siraman.'])->withInput();
                    }
                } else {
                    $data['theme_type_id'] = ThemeType::where('theme_id', $adatTheme->id)->where('slug', 'jawa')->value('id');
                }
            }
        }

        $session = session()->getId();
        ['results' => $results, 'log' => $log] = $rs->recommend($data, $session);

        $sessionResults = array_map(fn($r) => [
            'mua_id' => $r['mua']->id,
            'score' => $r['score']
        ], $results);

        session(['last_results' => $sessionResults, 'last_log_id' => $log->id]);

        return redirect()->route('guest.recommendation.results');
    }

    public function results()
    {
        $sessionResults = session('last_results', []);

        if (empty($sessionResults)) {
            return redirect()->route('recommendation.form')
                ->with('error', 'Sesi telah berakhir. Silakan cari ulang.');
        }

        $results = [];
        $muaIds = [];
        $scores = [];

        foreach ($sessionResults as $item) {
            if (is_array($item)) {
                $id = $item['mua_id'] ?? ($item['mua']['id'] ?? null);
                $score = $item['score'] ?? 0;
            } else if (is_object($item)) {
                $id = $item->mua_id ?? ($item->mua->id ?? null);
                $score = $item->score ?? 0;
            } else {
                continue;
            }
            if ($id) {
                $muaIds[] = $id;
                $scores[$id] = $score;
            }
        }

        if (empty($muaIds)) {
            return redirect()->route('recommendation.form')
                ->with('error', 'Sesi telah berakhir atau tidak valid. Silakan cari ulang.');
        }

        $muas = Mua::with(['district', 'makeupLooks', 'eventTypes', 'packages', 'portfolios'])
            ->whereIn('id', $muaIds)
            ->get()
            ->keyBy('id');

        foreach ($muaIds as $id) {
            if (isset($muas[$id])) {
                $results[] = [
                    'mua' => $muas[$id],
                    'score' => $scores[$id],
                ];
            }
        }

        return view('guest.recommendation.results', compact('results'));
    }
}
