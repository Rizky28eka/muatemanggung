<?php

namespace App\Http\Controllers\Mua;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\EventType;
use App\Models\MakeupLook;
use App\Models\Theme;
use App\Models\ThemeType;
use App\Services\VectorBuilderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $mua = auth()->user()->mua()->with(
            'eventTypes', 'themes', 'themeTypes', 'makeupLooks', 'serviceDistricts', 'district'
        )->firstOrFail();

        return view('mua.profile', [
            'mua'         => $mua,
            'districts'   => District::orderBy('name')->get(),
            'eventTypes'  => EventType::orderBy('sort_order')->get(),
            'themes'      => Theme::with('themeTypes')->get(),
            'themeTypes'  => ThemeType::with('theme')->orderBy('id')->get(),
            'makeupLooks' => MakeupLook::orderBy('id')->get(),
        ]);
    }

    public function update(Request $request, VectorBuilderService $vbs)
    {
        $mua = auth()->user()->mua;

        $data = $request->validate([
            'description'        => 'nullable|string',
            'address'            => 'nullable|string|max:255',
            'whatsapp_number'    => 'nullable|string|max:20',
            'instagram_username' => 'nullable|string|max:100',
            'is_home_service'    => 'boolean',
            'service_radius_km'  => 'nullable|integer|min:0',
            'logo'               => 'nullable|image|max:2048',
            'event_type_ids'     => 'nullable|array',
            'theme_ids'          => 'nullable|array',
            'theme_type_ids'     => 'nullable|array',
            'makeup_look_ids'    => 'nullable|array',
            'service_district_ids' => 'nullable|array',
        ]);

        if ($request->hasFile('logo')) {
            if ($mua->logo) Storage::disk('public')->delete($mua->logo);
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $mua->update([
            'description'        => $data['description'] ?? null,
            'address'            => $data['address'] ?? null,
            'whatsapp_number'    => $data['whatsapp_number'] ?? null,
            'instagram_username' => $data['instagram_username'] ?? null,
            'is_home_service'    => $request->boolean('is_home_service'),
            'service_radius_km'  => $data['service_radius_km'] ?? 0,
            'logo'               => $data['logo'] ?? $mua->logo,
        ]);

        $mua->eventTypes()->sync($request->input('event_type_ids', []));
        $mua->themes()->sync($request->input('theme_ids', []));
        $mua->themeTypes()->sync($request->input('theme_type_ids', []));
        $mua->makeupLooks()->sync($request->input('makeup_look_ids', []));
        $mua->serviceDistricts()->sync($request->input('service_district_ids', []));

        $vbs->saveForMua($mua->fresh());

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
