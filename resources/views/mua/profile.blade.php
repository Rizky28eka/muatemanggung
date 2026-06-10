@extends('layouts.dashboard')
@section('title', 'Profil Saya')

@section('content')
<div class="space-y-5">

    {{-- ── Page Header ── --}}
    <div>
        <h1 class="font-display font-bold text-xl text-slate-900">Profil Saya</h1>
        <p class="text-xs text-slate-500 mt-0.5">Kelola identitas, kontak, dan spesialisasi Anda. Data ini digunakan sistem untuk mencocokkan rekomendasi.</p>
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

    <form action="{{ route('mua.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        {{-- Preserve fields managed on the Lokasi page so this form doesn't wipe them --}}
        @if($mua->is_home_service)
            <input type="hidden" name="is_home_service" value="1">
        @endif
        <input type="hidden" name="service_radius_km" value="{{ $mua->service_radius_km }}">
        <input type="hidden" name="address" value="{{ $mua->address }}">
        @foreach($mua->serviceDistricts as $d)
            <input type="hidden" name="service_district_ids[]" value="{{ $d->id }}">
        @endforeach

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 items-start">

            {{-- ── Logo Card ── --}}
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-5 space-y-4 lg:col-span-1">
                <h3 class="text-xs font-bold text-slate-700">Logo / Foto Profil</h3>
                <div class="flex flex-col items-center gap-3">
                    <img id="logo-preview" src="{{ $mua->logo_url }}" alt="{{ $mua->name }}"
                         class="w-28 h-28 rounded-2xl object-cover border border-slate-200 bg-slate-50">
                    <label class="w-full">
                        <input type="file" name="logo" accept="image/*" onchange="previewLogo(event)"
                               class="block w-full text-[11px] text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-primary-soft file:text-primary hover:file:bg-primary/20 cursor-pointer">
                    </label>
                    <p class="text-[10px] text-slate-400 text-center">Format JPG/PNG/WEBP, maksimal 2MB.</p>
                </div>

                <div class="pt-3 border-t border-slate-100 space-y-1.5">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Usaha / Mitra</span>
                    <p class="text-sm font-display font-extrabold text-slate-800">{{ $mua->name }}</p>
                    <p class="text-[10px] text-slate-400">Hubungi admin untuk mengubah nama mitra.</p>
                </div>
            </div>

            {{-- ── Description & Contact Card ── --}}
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-5 space-y-4 lg:col-span-2">
                <h3 class="text-xs font-bold text-slate-700">Deskripsi & Kontak</h3>

                <div class="space-y-1.5">
                    <label class="block text-[11px] font-semibold text-slate-600">Deskripsi Usaha</label>
                    <textarea name="description" rows="4" placeholder="Ceritakan keahlian, pengalaman, dan keunggulan layanan rias Anda..."
                              class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition resize-none">{{ old('description', $mua->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-semibold text-slate-600">Nomor WhatsApp</label>
                        <div class="relative">
                            <i data-lucide="message-circle" class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $mua->whatsapp_number) }}" placeholder="08123456789"
                                   class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-semibold text-slate-600">Username Instagram</label>
                        <div class="relative">
                            <i data-lucide="instagram" class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input type="text" name="instagram_username" value="{{ old('instagram_username', $mua->instagram_username) }}" placeholder="namamua_makeup"
                                   class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                        </div>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100">
                    <a href="{{ route('mua.location.edit') }}" class="inline-flex items-center gap-1.5 text-[11px] font-bold text-primary hover:underline">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                        Atur lokasi & area layanan di halaman Lokasi
                        <i data-lucide="arrow-right" class="w-3 h-3"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- ── Specialization Card ── --}}
        <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-5 space-y-5">
            <div>
                <h3 class="text-xs font-bold text-slate-700">Spesialisasi & Kategori</h3>
                <p class="text-[10px] text-slate-400 mt-0.5">Pilih kategori yang sesuai dengan keahlian Anda. Data ini menjadi dasar perhitungan rekomendasi (Cosine Similarity).</p>
            </div>

            {{-- Event Types --}}
            <div class="space-y-2">
                <span class="block text-[11px] font-bold text-slate-600">Jenis Acara yang Dilayani</span>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                    @foreach($eventTypes as $et)
                        <label class="flex items-center gap-2 px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-semibold text-slate-600 cursor-pointer hover:border-primary/40 has-[:checked]:border-primary has-[:checked]:bg-primary-soft has-[:checked]:text-primary transition">
                            <input type="checkbox" name="event_type_ids[]" value="{{ $et->id }}"
                                   {{ $mua->eventTypes->contains($et->id) ? 'checked' : '' }}
                                   class="rounded border-slate-300 text-primary focus:ring-primary/30">
                            {{ $et->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Themes & Theme Types --}}
            <div class="space-y-3 pt-2 border-t border-slate-100">
                <span class="block text-[11px] font-bold text-slate-600">Tema & Jenis Tema</span>
                @foreach($themes as $theme)
                    <div class="p-3 bg-slate-50/60 border border-slate-100 rounded-xl space-y-2">
                        <label class="flex items-center gap-2 text-[11px] font-bold text-slate-700 cursor-pointer">
                            <input type="checkbox" name="theme_ids[]" value="{{ $theme->id }}"
                                   {{ $mua->themes->contains($theme->id) ? 'checked' : '' }}
                                   class="rounded border-slate-300 text-primary focus:ring-primary/30">
                            {{ $theme->name }}
                        </label>
                        @if($theme->themeTypes->isNotEmpty())
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 pl-5">
                                @foreach($theme->themeTypes as $type)
                                    <label class="flex items-center gap-2 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-[10px] font-semibold text-slate-600 cursor-pointer hover:border-primary/40 has-[:checked]:border-primary has-[:checked]:bg-primary-soft has-[:checked]:text-primary transition">
                                        <input type="checkbox" name="theme_type_ids[]" value="{{ $type->id }}"
                                               {{ $mua->themeTypes->contains($type->id) ? 'checked' : '' }}
                                               class="rounded border-slate-300 text-primary focus:ring-primary/30">
                                        {{ $type->name }}
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Makeup Looks --}}
            <div class="space-y-2 pt-2 border-t border-slate-100">
                <span class="block text-[11px] font-bold text-slate-600">Look Riasan yang Dikuasai</span>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                    @foreach($makeupLooks as $look)
                        <label class="flex items-center gap-2 px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-semibold text-slate-600 cursor-pointer hover:border-primary/40 has-[:checked]:border-primary has-[:checked]:bg-primary-soft has-[:checked]:text-primary transition">
                            <input type="checkbox" name="makeup_look_ids[]" value="{{ $look->id }}"
                                   {{ $mua->makeupLooks->contains($look->id) ? 'checked' : '' }}
                                   class="rounded border-slate-300 text-primary focus:ring-primary/30">
                            {{ $look->name }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="flex items-center gap-2 px-6 py-2.5 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary/90 active:scale-95 transition">
                <i data-lucide="save" class="w-3.5 h-3.5"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    function previewLogo(event) {
        const file = event.target.files[0];
        if (!file) return;
        document.getElementById('logo-preview').src = URL.createObjectURL(file);
    }
</script>
@endsection
