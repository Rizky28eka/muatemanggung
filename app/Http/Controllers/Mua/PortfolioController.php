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
            'files'     => 'nullable|array',
            'files.*'   => 'file|mimes:jpg,jpeg,png,webp,mp4,mov|max:51200',
            'embed_url' => 'nullable|url|max:500',
            'caption'   => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $ext = strtolower($file->getClientOriginalExtension());
                $size = $file->getSize();
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                    if ($size > 5242880) { // 5MB
                        return back()->withErrors(['files' => 'Ukuran file gambar tidak boleh lebih dari 5MB.'])->withInput();
                    }
                }
                if (in_array($ext, ['mp4', 'mov'])) {
                    if ($size > 52428800) { // 50MB
                        return back()->withErrors(['files' => 'Ukuran file video tidak boleh lebih dari 50MB.'])->withInput();
                    }
                }
            }
        }

        $sort = $mua->portfolios()->max('sort_order') ?? 0;

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
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
        }

        if ($request->filled('embed_url')) {
            MuaPortfolio::create([
                'mua_id'     => $mua->id,
                'embed_url'  => $request->input('embed_url'),
                'file_type'  => 'video',
                'caption'    => $request->input('caption'),
                'sort_order' => ++$sort,
            ]);
        }

        return back()->with('success', 'Portofolio berhasil ditambahkan.');
    }

    public function destroy(MuaPortfolio $portfolio)
    {
        abort_if($portfolio->mua_id !== auth()->user()->mua->id, 403);
        Storage::disk('public')->delete($portfolio->file_path);
        $portfolio->delete();
        return back()->with('success', 'Item portofolio dihapus.');
    }
}
