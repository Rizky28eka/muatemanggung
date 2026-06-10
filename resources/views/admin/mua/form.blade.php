@extends('layouts.dashboard')
@section('title', isset($mua) ? 'Edit MUA — ' . $mua->name : 'Tambah Mitra MUA')

@section('content')
@php
    $mua    ??= null;          // null on create, Mua model on edit
    $isEdit = $mua !== null;
@endphp

<div class="space-y-6">

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-xs text-slate-400">
        <a href="{{ route('admin.mua.index') }}" class="hover:text-primary transition-colors">Mitra MUA</a>
        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
        @if($isEdit)
            <a href="{{ route('admin.mua.show', $mua) }}" class="hover:text-primary transition-colors">{{ $mua->name }}</a>
            <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            <span class="text-slate-700 font-semibold">Edit</span>
        @else
            <span class="text-slate-700 font-semibold">Tambah Mitra</span>
        @endif
    </div>

    {{-- ── Page Header ── --}}
    <div>
        <h1 class="font-display font-bold text-xl text-slate-900">
            {{ $isEdit ? 'Edit Data MUA' : 'Tambah Mitra MUA Baru' }}
        </h1>
        <p class="text-xs text-slate-500 mt-0.5">
            {{ $isEdit ? 'Perbarui informasi akun dan profil mitra MUA.' : 'Buat akun baru untuk mitra make-up artist.' }}
        </p>
    </div>

    {{-- ── Validation Errors ── --}}
    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 rounded-2xl p-4">
            <div class="flex items-start gap-3">
                <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-500 flex-shrink-0 mt-0.5"></i>
                <div>
                    <p class="text-xs font-bold text-rose-700 mb-1">Mohon perbaiki kesalahan berikut:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li class="text-xs text-rose-600">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Form ── --}}
    <form action="{{ $isEdit ? route('admin.mua.update', $mua) : route('admin.mua.store') }}"
          method="POST" class="space-y-6">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ── LEFT: Identitas & Akun ── --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Identitas MUA --}}
                <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-6">
                    <h3 class="font-display font-bold text-sm text-slate-800 mb-5 flex items-center gap-2">
                        <i data-lucide="user-circle" class="w-4 h-4 text-primary"></i>
                        Identitas MUA
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- Nama --}}
                        <div class="sm:col-span-2">
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">
                                Nama Studio / Seniman MUA <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" id="name"
                                   value="{{ old('name', $mua->name ?? '') }}"
                                   placeholder="Contoh: Rizky MUA Studio"
                                   required
                                   class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition
                                          @error('name') border-rose-300 bg-rose-50 @else border-slate-200 @enderror">
                            @error('name') <p class="mt-1 text-[10px] text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Kecamatan --}}
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">
                                Kecamatan <span class="text-rose-500">*</span>
                            </label>
                            <select name="district_id" id="district_id" required
                                    class="w-full px-4 py-2.5 bg-slate-50 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition
                                           @error('district_id') border-rose-300 bg-rose-50 @else border-slate-200 @enderror">
                                <option value="">— Pilih Kecamatan —</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}"
                                        {{ old('district_id', $mua->district_id ?? '') == $district->id ? 'selected' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('district_id') <p class="mt-1 text-[10px] text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Alamat</label>
                            <input type="text" name="address" id="address"
                                   value="{{ old('address', $mua->address ?? '') }}"
                                   placeholder="Jl. Contoh No.1, Temanggung"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                        </div>

                        {{-- WhatsApp --}}
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Nomor WhatsApp</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-xs text-slate-400 font-mono">+62</span>
                                <input type="text" name="whatsapp_number" id="whatsapp_number"
                                       value="{{ old('whatsapp_number', $mua->whatsapp_number ?? '') }}"
                                       placeholder="8123456789"
                                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                            </div>
                        </div>

                        {{-- Instagram --}}
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Username Instagram</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2.5 text-xs text-slate-400">@</span>
                                <input type="text" name="instagram_username" id="instagram_username"
                                       value="{{ old('instagram_username', $mua->instagram_username ?? '') }}"
                                       placeholder="username_mua"
                                       class="w-full pl-7 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="sm:col-span-2">
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">Deskripsi Singkat</label>
                            <textarea name="description" id="description" rows="3"
                                      placeholder="Ceritakan keunggulan dan spesialisasi MUA ini..."
                                      class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm resize-none focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">{{ old('description', $mua->description ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Home Service --}}
                <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-6">
                    <h3 class="font-display font-bold text-sm text-slate-800 mb-5 flex items-center gap-2">
                        <i data-lucide="map" class="w-4 h-4 text-primary"></i>
                        Jangkauan Layanan
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="inline-flex items-center gap-3 cursor-pointer group">
                                <div class="relative">
                                    <input type="hidden" name="is_home_service" value="0">
                                    <input type="checkbox" name="is_home_service" id="is_home_service" value="1"
                                           {{ old('is_home_service', $mua->is_home_service ?? false) ? 'checked' : '' }}
                                           class="sr-only peer"
                                           onchange="document.getElementById('radius-field').classList.toggle('hidden', !this.checked)">
                                    <div class="w-10 h-6 bg-slate-200 peer-checked:bg-primary rounded-full transition-colors"></div>
                                    <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                                </div>
                                <span class="text-sm font-semibold text-slate-700 group-hover:text-slate-900">Melayani Home Service (ke lokasi klien)</span>
                            </label>
                        </div>
                        <div id="radius-field" class="{{ old('is_home_service', $mua->is_home_service ?? false) ? '' : 'hidden' }}">
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">
                                Radius Layanan (km)
                            </label>
                            <input type="number" name="service_radius_km" id="service_radius_km"
                                   value="{{ old('service_radius_km', $mua->service_radius_km ?? '') }}"
                                   min="0" max="100" placeholder="Contoh: 15"
                                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                        </div>
                    </div>
                </div>

                {{-- Jenis Acara --}}
                <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-6">
                    <h3 class="font-display font-bold text-sm text-slate-800 mb-1 flex items-center gap-2">
                        <i data-lucide="calendar" class="w-4 h-4 text-primary"></i>
                        Jenis Acara Yang Dilayani
                    </h3>
                    <p class="text-[10px] text-slate-400 mb-4">Pilih satu atau lebih jenis acara.</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach($eventTypes as $et)
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" name="event_type_ids[]" value="{{ $et->id }}"
                                       {{ in_array($et->id, old('event_type_ids', $mua?->eventTypes?->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                                       class="w-4 h-4 rounded accent-primary">
                                <span class="text-xs text-slate-700 group-hover:text-primary transition-colors">{{ $et->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Tema --}}
                <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-6">
                    <h3 class="font-display font-bold text-sm text-slate-800 mb-1 flex items-center gap-2">
                        <i data-lucide="palette" class="w-4 h-4 text-primary"></i>
                        Konsep Tema
                    </h3>
                    <p class="text-[10px] text-slate-400 mb-4">Pilih tema-tema yang dikuasai MUA.</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach($themes as $theme)
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" name="theme_ids[]" value="{{ $theme->id }}"
                                       {{ in_array($theme->id, old('theme_ids', $mua?->themes?->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                                       class="w-4 h-4 rounded accent-primary">
                                <span class="text-xs text-slate-700 group-hover:text-primary transition-colors">{{ $theme->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Look Riasan --}}
                <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-6">
                    <h3 class="font-display font-bold text-sm text-slate-800 mb-1 flex items-center gap-2">
                        <i data-lucide="sparkles" class="w-4 h-4 text-primary"></i>
                        Look Riasan
                    </h3>
                    <p class="text-[10px] text-slate-400 mb-4">Pilih gaya riasan yang dikuasai.</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach($makeupLooks as $look)
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" name="makeup_look_ids[]" value="{{ $look->id }}"
                                       {{ in_array($look->id, old('makeup_look_ids', $mua?->makeupLooks?->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                                       class="w-4 h-4 rounded accent-primary">
                                <span class="text-xs text-slate-700 group-hover:text-primary transition-colors">{{ $look->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Wilayah Layanan --}}
                <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-6">
                    <h3 class="font-display font-bold text-sm text-slate-800 mb-1 flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-4 h-4 text-primary"></i>
                        Wilayah Kecamatan yang Dilayani
                    </h3>
                    <p class="text-[10px] text-slate-400 mb-4">Pilih kecamatan-kecamatan yang dapat dijangkau.</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 max-h-48 overflow-y-auto">
                        @foreach($districts as $d)
                            <label class="flex items-center gap-2.5 cursor-pointer group">
                                <input type="checkbox" name="service_district_ids[]" value="{{ $d->id }}"
                                       {{ in_array($d->id, old('service_district_ids', $mua?->serviceDistricts?->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                                       class="w-4 h-4 rounded accent-primary">
                                <span class="text-xs text-slate-700 group-hover:text-primary transition-colors">{{ $d->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- ── RIGHT SIDEBAR: Akun & Status ── --}}
            <div class="lg:col-span-1 space-y-5">

                {{-- Akun Login --}}
                <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-5 sticky top-20">
                    <h3 class="font-display font-bold text-sm text-slate-800 mb-4 flex items-center gap-2">
                        <i data-lucide="key-round" class="w-4 h-4 text-primary"></i>
                        Akun Login
                    </h3>
                    <div class="space-y-3">

                        {{-- Email --}}
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">
                                Email <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="email" id="email"
                                   value="{{ old('email', $mua->user?->email ?? '') }}"
                                   placeholder="mua@email.com"
                                   required
                                   class="w-full px-3 py-2 bg-slate-50 border rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition
                                          @error('email') border-rose-300 bg-rose-50 @else border-slate-200 @enderror">
                            @error('email') <p class="mt-1 text-[10px] text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1.5">
                                Password {{ $isEdit ? '(Kosongkan jika tidak diubah)' : '*' }}
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="password"
                                       placeholder="{{ $isEdit ? '••••••••' : 'Min. 6 karakter' }}"
                                       {{ $isEdit ? '' : 'required' }}
                                       class="w-full px-3 py-2 pr-9 bg-slate-50 border rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition
                                              @error('password') border-rose-300 bg-rose-50 @else border-slate-200 @enderror">
                                <button type="button" onclick="togglePwd(this)"
                                        class="absolute right-2.5 top-2 text-slate-400 hover:text-slate-700 transition-colors">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </button>
                            </div>
                            @error('password') <p class="mt-1 text-[10px] text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Status Aktif --}}
                        <div class="pt-2">
                            <label class="inline-flex items-center gap-3 cursor-pointer group">
                                <div class="relative">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" id="is_active" value="1"
                                           {{ old('is_active', $mua->is_active ?? true) ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-10 h-6 bg-slate-200 peer-checked:bg-emerald-500 rounded-full transition-colors"></div>
                                    <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                                </div>
                                <span class="text-xs font-semibold text-slate-700">Akun Aktif</span>
                            </label>
                            <p class="text-[10px] text-slate-400 mt-1 ml-14">MUA dapat login dan tampil di direktori publik.</p>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-slate-100 mt-5 pt-5 space-y-2.5">
                        <button type="submit"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-primary text-white text-xs font-bold rounded-xl shadow shadow-primary/20 hover:bg-primary/90 active:scale-95 transition-all">
                            <i data-lucide="{{ $isEdit ? 'save' : 'plus' }}" class="w-4 h-4"></i>
                            {{ $isEdit ? 'Simpan Perubahan' : 'Buat Akun MUA' }}
                        </button>
                        <a href="{{ $isEdit ? route('admin.mua.show', $mua) : route('admin.mua.index') }}"
                           class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 text-slate-600 text-xs font-semibold rounded-xl hover:bg-slate-200 transition-all">
                            <i data-lucide="x" class="w-4 h-4"></i>
                            Batal
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    function togglePwd(btn) {
        const input = btn.previousElementSibling;
        const isText = input.type === 'text';
        input.type = isText ? 'password' : 'text';
        btn.innerHTML = isText
            ? '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>'
            : '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>';
    }
</script>
@endsection
