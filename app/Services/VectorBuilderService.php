<?php

namespace App\Services;

use App\Models\District;
use App\Models\EventType;
use App\Models\MakeupLook;
use App\Models\Mua;
use App\Models\MuaVector;
use App\Models\PriceRange;
use App\Models\Theme;
use App\Models\ThemeType;

/**
 * Builds 48-dim binary vector for a MUA.
 * Layout:
 *   [0–8]   event_types  (ordered by sort_order)
 *   [9–10]  themes       (ordered by id: Adat, Modern)
 *   [11–15] theme_types  (ordered by id)
 *   [16–21] makeup_looks (ordered by id)
 *   [22–41] districts    (ordered by id — service districts)
 *   [42–46] price_ranges (ordered by sort_order)
 *   [47]    home_service (boolean)
 */
class VectorBuilderService
{
    private array $eventTypeIds;
    private array $themeIds;
    private array $themeTypeIds;
    private array $lookIds;
    private array $districtIds;
    private array $priceRanges;

    public function __construct()
    {
        $this->eventTypeIds = EventType::orderBy('sort_order')->pluck('id')->toArray();
        $this->themeIds     = Theme::orderBy('id')->pluck('id')->toArray();
        $this->themeTypeIds = ThemeType::orderBy('id')->pluck('id')->toArray();
        $this->lookIds      = MakeupLook::orderBy('id')->pluck('id')->toArray();
        $this->districtIds  = District::orderBy('id')->pluck('id')->toArray();
        $this->priceRanges  = PriceRange::orderBy('sort_order')->get()->toArray();
    }

    public function buildForMua(Mua $mua): array
    {
        $mua->loadMissing([
            'eventTypes', 'themes', 'themeTypes',
            'makeupLooks', 'serviceDistricts',
            'packages' => fn ($q) => $q->where('is_available', true),
        ]);

        $vector = [];

        // event_types
        $mueIds = $mua->eventTypes->pluck('id')->toArray();
        foreach ($this->eventTypeIds as $id) {
            $vector[] = in_array($id, $mueIds) ? 1 : 0;
        }

        // themes
        $mthIds = $mua->themes->pluck('id')->toArray();
        foreach ($this->themeIds as $id) {
            $vector[] = in_array($id, $mthIds) ? 1 : 0;
        }

        // theme_types
        $mttIds = $mua->themeTypes->pluck('id')->toArray();
        foreach ($this->themeTypeIds as $id) {
            $vector[] = in_array($id, $mttIds) ? 1 : 0;
        }

        // makeup_looks
        $mlIds = $mua->makeupLooks->pluck('id')->toArray();
        foreach ($this->lookIds as $id) {
            $vector[] = in_array($id, $mlIds) ? 1 : 0;
        }

        // service_districts
        $sdIds = $mua->serviceDistricts->pluck('id')->toArray();
        foreach ($this->districtIds as $id) {
            $vector[] = in_array($id, $sdIds) ? 1 : 0;
        }

        // price_ranges — based on available package prices
        $prices = $mua->packages->pluck('price')->filter()->values();
        foreach ($this->priceRanges as $range) {
            $min = $range['min_price'] ?? 0;
            $max = $range['max_price'] ?? PHP_INT_MAX;
            $has = $prices->contains(fn ($p) => $p >= $min && $p <= $max);
            $vector[] = $has ? 1 : 0;
        }

        // home_service
        $vector[] = $mua->is_home_service ? 1 : 0;

        return $vector;
    }

    public function buildFromPreferences(array $prefs): array
    {
        $vector = [];

        $selectedEventId = $prefs['event_type_id'] ?? null;
        foreach ($this->eventTypeIds as $id) {
            $vector[] = $id == $selectedEventId ? 1 : 0;
        }

        $selectedThemeId = $prefs['theme_id'] ?? null;
        foreach ($this->themeIds as $id) {
            $vector[] = $id == $selectedThemeId ? 1 : 0;
        }

        // For Siraman: all adat theme_types get 1
        $isSiraman     = $prefs['is_siraman'] ?? false;
        $adatThemeId   = Theme::where('slug', 'adat')->value('id');
        $adatTypeIds   = $isSiraman
            ? ThemeType::where('theme_id', $adatThemeId)->pluck('id')->toArray()
            : [];
        $selectedTypeId = $prefs['theme_type_id'] ?? null;
        foreach ($this->themeTypeIds as $id) {
            $vector[] = ($id == $selectedTypeId || in_array($id, $adatTypeIds)) ? 1 : 0;
        }

        $selectedLookId = $prefs['makeup_look_id'] ?? null;
        foreach ($this->lookIds as $id) {
            $vector[] = $id == $selectedLookId ? 1 : 0;
        }

        $selectedDistrictId = $prefs['district_id'] ?? null;
        foreach ($this->districtIds as $id) {
            $vector[] = $id == $selectedDistrictId ? 1 : 0;
        }

        // price range — user selects one range (their budget max)
        $selectedPriceId = $prefs['price_range_id'] ?? null;
        foreach ($this->priceRanges as $range) {
            $vector[] = $range['id'] == $selectedPriceId ? 1 : 0;
        }

        // home_service preference
        $vector[] = ! empty($prefs['wants_home_service']) ? 1 : 0;

        return $vector;
    }

    public function saveForMua(Mua $mua): MuaVector
    {
        $vector = $this->buildForMua($mua);

        return MuaVector::updateOrCreate(
            ['mua_id' => $mua->id],
            ['vector_data' => $vector, 'updated_at' => now()]
        );
    }
}
