@extends('layouts.dashboard')
@section('title', 'Portofolio')

@section('content')
<div class="space-y-5">

    {{-- ── Page Header ── --}}
    <div>
        <h1 class="font-display font-bold text-xl text-slate-900">Portofolio</h1>
        <p class="text-xs text-slate-500 mt-0.5">Unggah foto dan video hasil karya rias Anda untuk ditampilkan kepada calon klien.</p>
    </div>

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold px-4 py-3 rounded-xl">
            <i data-lucide="check-circle-2" class="w-4 h-4 flex-shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="flex items-start gap-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold px-4 py-3 rounded-xl">
            <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0 mt-0.5"></i>
            <ul class="space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ── Upload Form ── --}}
    <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-5 space-y-3">
        <h3 class="text-xs font-bold text-slate-700">Tambah Karya Baru</h3>
        <form action="{{ route('mua.portfolio.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-semibold text-slate-600">Unggah File (Foto / Video)</label>
                    <input type="file" name="files[]" multiple accept="image/jpeg,image/png,image/webp,video/mp4,video/quicktime"
                           class="block w-full text-[11px] text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-primary-soft file:text-primary hover:file:bg-primary/20 cursor-pointer">
                    <p class="text-[10px] text-slate-400">Format JPG, PNG, WEBP, MP4, MOV. Maksimal 20MB per file. Anda dapat memilih beberapa file sekaligus.</p>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-semibold text-slate-600">ATAU Link Video Embed (YouTube/Instagram)</label>
                    <input type="url" name="embed_url" placeholder="https://www.youtube.com/embed/... atau link video Instagram"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                    <p class="text-[10px] text-slate-400">Masukkan link video eksternal (menghemat ruang storage server).</p>
                </div>
            </div>
            <div class="space-y-1.5 text-left">
                <label class="block text-[11px] font-semibold text-slate-600 font-display">Caption (opsional)</label>
                <input type="text" name="caption" placeholder="mis. Makeup wisuda - Soft Glam" maxlength="255"
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                <p class="text-[10px] text-slate-400">Caption yang sama akan diterapkan ke file/link yang diunggah.</p>
            </div>
            <button type="submit"
                    class="flex items-center gap-2 px-6 py-2.5 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary/90 active:scale-95 transition">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                Tambah Karya
            </button>
        </form>
    </div>

    {{-- ── Gallery ── --}}
    <div class="space-y-3">
        <h3 class="font-display font-bold text-slate-800 text-sm tracking-wide">Galeri Portofolio ({{ $portfolios->count() }})</h3>

        @if($portfolios->isEmpty())
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-8 text-center text-xs text-slate-400">
                Belum ada karya portofolio. Tambah karya pertama Anda di atas.
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($portfolios as $item)
                    <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs overflow-hidden group relative flex flex-col justify-between">
                        <div class="aspect-square bg-slate-100 overflow-hidden relative">
                            @if($item->embed_url)
                                <iframe src="{{ $item->embed_url }}" class="w-full h-full object-cover" frameborder="0" allowfullscreen></iframe>
                            @elseif($item->isVideo())
                                <video src="{{ $item->url }}" class="w-full h-full object-cover" controls preload="metadata"></video>
                            @else
                                <img src="{{ $item->url }}" alt="{{ $item->caption ?? 'Portofolio' }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="p-3 space-y-2 text-left">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[10px] font-semibold text-slate-600 truncate">{{ $item->caption ?? '—' }}</span>
                                <span class="px-1.5 py-0.5 rounded-full bg-slate-100 text-slate-400 text-[8px] font-bold uppercase flex-shrink-0">{{ $item->embed_url ? 'embed' : $item->file_type }}</span>
                            </div>
                            <form action="{{ route('mua.portfolio.destroy', $item) }}" method="POST"
                                  onsubmit="return confirm('Hapus item portofolio ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-full flex items-center justify-center gap-1.5 px-2 py-1.5 bg-rose-50 text-rose-500 text-[10px] font-bold rounded-lg hover:bg-rose-500 hover:text-white active:scale-95 transition">
                                    <i data-lucide="trash-2" class="w-3 h-3"></i>
                                     Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
