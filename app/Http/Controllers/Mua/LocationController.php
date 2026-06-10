<?php

namespace App\Http\Controllers\Mua;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Services\VectorBuilderService;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function edit()
    {
        $mua = auth()->user()->mua()->with('district', 'serviceDistricts')->firstOrFail();
        $districts = District::orderBy('name')->get();
        return view('mua.location', compact('mua', 'districts'));
    }

    public function update(Request $request, VectorBuilderService $vbs)
    {
        $mua = auth()->user()->mua;

        $data = $request->validate([
            'district_id'          => 'required|exists:districts,id',
            'address'              => 'nullable|string|max:255',
            'is_home_service'      => 'boolean',
            'service_radius_km'    => 'nullable|integer|min:0',
            'service_district_ids' => 'nullable|array',
            'service_district_ids.*' => 'exists:districts,id',
        ]);

        $mua->update([
            'district_id'       => $data['district_id'],
            'address'           => $data['address'] ?? null,
            'is_home_service'   => $request->boolean('is_home_service'),
            'service_radius_km' => $data['service_radius_km'] ?? 0,
        ]);

        $mua->serviceDistricts()->sync($request->input('service_district_ids', []));

        $vbs->saveForMua($mua->fresh());

        return back()->with('success', 'Data lokasi & layanan berhasil disimpan.');
    }
}
