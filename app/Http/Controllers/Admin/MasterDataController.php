<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\EventType;
use App\Models\Theme;
use App\Models\MakeupLook;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterDataController extends Controller
{
    // Districts
    public function districtsIndex()
    {
        $items = District::orderBy('name')->get();
        return view('admin.master.districts', compact('items'));
    }

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
    public function eventTypesIndex()
    {
        $items = EventType::orderBy('sort_order')->orderBy('name')->get();
        return view('admin.master.event-types', compact('items'));
    }

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
    public function themesIndex()
    {
        $items = Theme::orderBy('name')->get();
        return view('admin.master.themes', compact('items'));
    }

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

    // Makeup Looks
    public function makeupLooksIndex()
    {
        $items = MakeupLook::orderBy('name')->get();
        return view('admin.master.makeup-looks', compact('items'));
    }

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
}
