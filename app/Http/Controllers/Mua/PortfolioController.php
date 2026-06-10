<?php

namespace App\Http\Controllers\Mua;

use App\Http\Controllers\Controller;
use App\Models\MuaPortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        $mua = auth()->user()->mua;
        $portfolios = $mua->portfolios()->get();
        return view('mua.portfolio', compact('mua', 'portfolios'));
    }

    public function store(Request $request)
    {
        $mua = auth()->user()->mua;

        $request->validate([
            'files.*'   => 'required|file|mimes:jpg,jpeg,png,webp,mp4,mov|max:20480',
            'caption'   => 'nullable|string|max:255',
        ]);

        $sort = $mua->portfolios()->max('sort_order') ?? 0;

        foreach ($request->file('files', []) as $file) {
            $ext  = strtolower($file->getClientOriginalExtension());
            $type = in_array($ext, ['mp4', 'mov']) ? 'video' : 'photo';
            $path = $file->store("portfolios/{$mua->id}", 'public');

            MuaPortfolio::create([
                'mua_id'     => $mua->id,
                'file_path'  => $path,
                'file_type'  => $type,
                'caption'    => $request->input('caption'),
                'sort_order' => ++$sort,
            ]);
        }

        return back()->with('success', 'Portofolio berhasil diunggah.');
    }

    public function destroy(MuaPortfolio $portfolio)
    {
        abort_if($portfolio->mua_id !== auth()->user()->mua->id, 403);
        Storage::disk('public')->delete($portfolio->file_path);
        $portfolio->delete();
        return back()->with('success', 'Item portofolio dihapus.');
    }
}
