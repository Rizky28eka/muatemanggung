@extends('layouts.dashboard')
@section('title', 'Paket Layanan')

@section('content')
<div class="space-y-5">

    {{-- ── Page Header ── --}}
    <div>
        <h1 class="font-display font-bold text-xl text-slate-900">Paket Layanan</h1>
        <p class="text-xs text-slate-500 mt-0.5">Pilih template paket dari admin, lalu sesuaikan harga dan deskripsi sesuai layanan Anda.</p>
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

    @if($templates->isEmpty())
        <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-8 text-center text-xs text-slate-400">
            Belum ada template paket dari admin. Hubungi admin untuk menambahkan template paket.
        </div>
    @endif

    @foreach($templates->groupBy('event_type_id') as $group)
        @php $eventType = $group->first()->eventType; @endphp
        <div class="space-y-3">
            <h3 class="font-display font-bold text-slate-800 text-sm tracking-wide flex items-center gap-2">
                <i data-lucide="party-popper" class="w-4 h-4 text-primary"></i>
                {{ $eventType?->name ?? 'Umum' }}
            </h3>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                @foreach($group as $template)
                    @php $package = $packages->firstWhere('package_template_id', $template->id); @endphp
                    <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-5 space-y-3">

                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <h4 class="font-display font-extrabold text-slate-800 text-sm leading-tight">{{ $template->name }}</h4>
                                @if($template->description)
                                    <p class="text-[10px] text-slate-400 mt-1">{{ $template->description }}</p>
                                @endif
                            </div>
                            @if($package)
                                <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[9px] font-bold flex-shrink-0">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-400 text-[9px] font-bold flex-shrink-0">Belum Ditambahkan</span>
                            @endif
                        </div>

                        @if($template->includes->isNotEmpty())
                            <ul class="space-y-1 bg-slate-50/60 border border-slate-100 rounded-xl p-3">
                                @foreach($template->includes as $include)
                                    <li class="text-[10px] text-slate-500 flex items-center gap-1.5">
                                        <i data-lucide="check" class="w-3 h-3 text-emerald-500 flex-shrink-0"></i>
                                        {{ $include->include_item }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <form action="{{ $package ? route('mua.packages.update', $package) : route('mua.packages.store') }}" method="POST" class="space-y-3 pt-2 border-t border-slate-100">
                            @csrf
                            @if($package)
                                @method('PUT')
                            @else
                                <input type="hidden" name="package_template_id" value="{{ $template->id }}">
                            @endif

                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-semibold text-slate-600">Harga Paket (Rp)</label>
                                <input type="number" name="price" min="0" required placeholder="mis. 1500000"
                                       value="{{ old('price', $package->price ?? '') }}"
                                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-semibold text-slate-600">Deskripsi Tambahan</label>
                                <textarea name="custom_description" rows="2" placeholder="Tambahkan detail/keterangan khusus paket Anda (opsional)"
                                          class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition resize-none">{{ old('custom_description', $package->custom_description ?? '') }}</textarea>
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-semibold text-slate-600">Catatan</label>
                                <textarea name="notes" rows="2" placeholder="Catatan internal (opsional)"
                                          class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition resize-none">{{ old('notes', $package->notes ?? '') }}</textarea>
                            </div>

                            <label class="flex items-center justify-between gap-3 p-2.5 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer">
                                <span class="text-[11px] font-bold text-slate-700">Tampilkan paket ini ke calon klien</span>
                                <input type="checkbox" name="is_available" value="1"
                                       {{ old('is_available', $package->is_available ?? true) ? 'checked' : '' }}
                                       class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary/30">
                            </label>

                            <div class="flex items-center gap-2 pt-1">
                                <button type="submit"
                                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary/90 active:scale-95 transition">
                                    <i data-lucide="save" class="w-3.5 h-3.5"></i>
                                    {{ $package ? 'Simpan Perubahan' : 'Tambahkan Paket' }}
                                </button>
                            </div>
                        </form>

                        @if($package)
                            <form action="{{ route('mua.packages.destroy', $package) }}" method="POST"
                                  onsubmit="return confirm('Hapus paket {{ addslashes($template->name) }} dari layanan Anda?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-rose-50 text-rose-500 text-xs font-bold rounded-xl hover:bg-rose-500 hover:text-white active:scale-95 transition">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    Hapus Paket
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

</div>
@endsection
