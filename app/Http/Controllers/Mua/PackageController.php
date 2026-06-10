<?php

namespace App\Http\Controllers\Mua;

use App\Http\Controllers\Controller;
use App\Models\MuaPackage;
use App\Models\PackageTemplate;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $mua = auth()->user()->mua;

        $packages = $mua->packages()
            ->with('template.eventType')
            ->orderBy('id')
            ->get();

        $templates = PackageTemplate::with('eventType', 'includes')
            ->orderBy('sort_order')
            ->get();

        $existing = $packages->pluck('package_template_id')->toArray();

        return view('mua.packages', compact('mua', 'packages', 'templates', 'existing'));
    }

    public function store(Request $request)
    {
        $mua = auth()->user()->mua;

        $data = $request->validate([
            'package_template_id' => 'required|exists:package_templates,id',
            'price'               => 'required|integer|min:0',
            'custom_description'  => 'nullable|string',
            'notes'               => 'nullable|string',
            'is_available'        => 'boolean',
        ]);

        MuaPackage::updateOrCreate(
            ['mua_id' => $mua->id, 'package_template_id' => $data['package_template_id']],
            [
                'price'              => $data['price'],
                'custom_description' => $data['custom_description'] ?? null,
                'notes'              => $data['notes'] ?? null,
                'is_available'       => $request->boolean('is_available', true),
            ]
        );

        return back()->with('success', 'Paket berhasil disimpan.');
    }

    public function update(Request $request, MuaPackage $package)
    {
        abort_if($package->mua_id !== auth()->user()->mua->id, 403);

        $data = $request->validate([
            'price'              => 'required|integer|min:0',
            'custom_description' => 'nullable|string',
            'notes'              => 'nullable|string',
            'is_available'       => 'boolean',
        ]);

        $package->update([
            'price'              => $data['price'],
            'custom_description' => $data['custom_description'] ?? null,
            'notes'              => $data['notes'] ?? null,
            'is_available'       => $request->boolean('is_available'),
        ]);

        return back()->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(MuaPackage $package)
    {
        abort_if($package->mua_id !== auth()->user()->mua->id, 403);
        $package->delete();
        return back()->with('success', 'Paket dihapus.');
    }
}
