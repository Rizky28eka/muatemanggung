<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\EventType;
use App\Models\PackageTemplate;
use App\Models\Theme;
use App\Models\ThemeType;
use App\Models\MakeupLook;
use App\Models\PriceRange;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterDataController extends Controller
{
    public function index()
    {
        $districts   = District::withCount('muas')->orderBy('name')->get();
        $eventTypes  = EventType::withCount('muas')->orderBy('sort_order')->orderBy('name')->get();
        $themes      = Theme::withCount('muas')->with('themeTypes')->orderBy('name')->get();
        $themeTypes  = ThemeType::withCount('muas')->with('theme')->orderBy('name')->get();
        $makeupLooks = MakeupLook::withCount('muas')->orderBy('name')->get();
        $priceRanges = PriceRange::orderBy('sort_order')->orderBy('min_price')->get();
        $packageTemplates = PackageTemplate::with('eventType', 'includes')->withCount('muaPackages')->orderBy('event_type_id')->orderBy('sort_order')->get();

        return view('admin.master.index', compact(
            'districts', 'eventTypes', 'themes', 'themeTypes', 'makeupLooks', 'priceRanges', 'packageTemplates'
        ));
    }

    // Districts
    public function districtsStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:districts,name',
        ]);

        District::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);

        return back()->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    public function districtsDestroy(District $district)
    {
        $district->delete();
        return back()->with('success', 'Kecamatan berhasil dihapus.');
    }

    // Event Types
    public function eventTypesStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:event_types,name',
            'is_siraman' => 'boolean',
            'sort_order' => 'required|integer|min:0',
        ]);

        EventType::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'is_siraman' => $request->boolean('is_siraman'),
            'sort_order' => $data['sort_order'],
        ]);

        return back()->with('success', 'Jenis acara berhasil ditambahkan.');
    }

    public function eventTypesDestroy(EventType $eventType)
    {
        $eventType->delete();
        return back()->with('success', 'Jenis acara berhasil dihapus.');
    }

    // Themes
    public function themesStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:themes,name',
        ]);

        Theme::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);

        return back()->with('success', 'Konsep tema berhasil ditambahkan.');
    }

    public function themesDestroy(Theme $theme)
    {
        $theme->delete();
        return back()->with('success', 'Konsep tema berhasil dihapus.');
    }

    // Theme Types
    public function themeTypesStore(Request $request)
    {
        $data = $request->validate([
            'theme_id' => 'required|exists:themes,id',
            'name'     => 'required|string|max:255|unique:theme_types,name',
        ]);

        ThemeType::create([
            'theme_id' => $data['theme_id'],
            'name'     => $data['name'],
            'slug'     => Str::slug($data['name']),
        ]);

        return back()->with('success', 'Jenis tema berhasil ditambahkan.');
    }

    public function themeTypesDestroy(ThemeType $themeType)
    {
        $themeType->delete();
        return back()->with('success', 'Jenis tema berhasil dihapus.');
    }

    // Makeup Looks
    public function makeupLooksStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:makeup_looks,name',
        ]);

        MakeupLook::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);

        return back()->with('success', 'Look riasan berhasil ditambahkan.');
    }

    public function makeupLooksDestroy(MakeupLook $makeupLook)
    {
        $makeupLook->delete();
        return back()->with('success', 'Look riasan berhasil dihapus.');
    }

    // Price Ranges
    public function priceRangesStore(Request $request)
    {
        $data = $request->validate([
            'label'      => 'required|string|max:255|unique:price_ranges,label',
            'min_price'  => 'nullable|integer|min:0',
            'max_price'  => 'nullable|integer|min:0',
            'sort_order' => 'required|integer|min:0',
        ]);

        PriceRange::create($data);

        return back()->with('success', 'Rentang harga berhasil ditambahkan.');
    }

    public function priceRangesDestroy(PriceRange $priceRange)
    {
        $priceRange->delete();
        return back()->with('success', 'Rentang harga berhasil dihapus.');
    }

    // Package Templates
    public function packageTemplatesStore(Request $request)
    {
        $data = $request->validate([
            'event_type_id' => 'required|exists:event_types,id',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'sort_order'    => 'required|integer|min:0',
            'includes'      => 'nullable|string',
        ]);

        $template = PackageTemplate::create([
            'event_type_id' => $data['event_type_id'],
            'name'          => $data['name'],
            'description'   => $data['description'] ?? null,
            'sort_order'    => $data['sort_order'],
        ]);

        $lines = array_filter(array_map('trim', explode("\n", $data['includes'] ?? '')));
        foreach (array_values($lines) as $i => $line) {
            $template->includes()->create([
                'include_item' => $line,
                'sort_order'   => $i,
            ]);
        }

        return back()->with('success', 'Template paket berhasil ditambahkan.');
    }

    public function packageTemplatesDestroy(PackageTemplate $packageTemplate)
    {
        $packageTemplate->delete();
        return back()->with('success', 'Template paket berhasil dihapus.');
    }
}
