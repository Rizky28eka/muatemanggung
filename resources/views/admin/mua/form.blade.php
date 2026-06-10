@extends('layouts.admin')
@section('title', isset($mua) ? 'Edit MUA' : 'Tambah MUA')
@section('page-title', isset($mua) ? 'Edit MUA: ' . $mua->name : 'Tambah MUA Baru')

@section('content')
<form method="POST" action="{{ isset($mua) ? route('admin.mua.update', $mua) : route('admin.mua.store') }}" class="space-y-6">
    @csrf
    @if(isset($mua)) @method('PUT') @endif

    {{-- Error summary --}}
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
        <p class="text-sm font-semibold text-red-700 mb-2">Terdapat {{ $errors->count() }} kesalahan:</p>
        <ul class="list-disc pl-5 text-sm text-red-600 space-y-0.5">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-sm text-emerald-700">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left (main info) --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Basic info --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-700">Informasi Dasar</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama MUA <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $mua->name ?? '') }}"
                               class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300 @error('name') border-red-400 @enderror">
                        @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan Utama <span class="text-red-500">*</span></label>
                        <select name="district_id"
                                class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300 @error('district_id') border-red-400 @enderror">
                            <option value="">Pilih Kecamatan</option>
                            @foreach($districts as $d)
                            <option value="{{ $d->id }}" {{ old('district_id', $mua->district_id ?? '') == $d->id ? 'selected' : '' }}>
                                {{ $d->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('district_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
                        <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $mua->whatsapp_number ?? '') }}"
                               placeholder="628xxxxxxxxxx"
                               class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                        <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-violet-300">
                            <span class="px-3 py-2 bg-gray-50 text-gray-400 text-sm border-r border-gray-200">@</span>
                            <input type="text" name="instagram_username" value="{{ old('instagram_username', $mua->instagram_username ?? '') }}"
                                   class="flex-1 px-3 py-2 text-sm focus:outline-none">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <input type="text" name="address" value="{{ old('address', $mua->address ?? '') }}"
                               class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300 resize-none">{{ old('description', $mua->description ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Home service --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-700">Home Service</h3>
                </div>
                <div class="p-6">
                    <label class="flex items-center gap-3 cursor-pointer" x-data="{ hs: {{ old('is_home_service', ($mua->is_home_service ?? false) ? 'true' : 'false') }} }">
                        <input type="hidden" name="is_home_service" value="0">
                        <input type="checkbox" name="is_home_service" value="1"
                               {{ old('is_home_service', ($mua->is_home_service ?? false)) ? 'checked' : '' }}
                               @change="hs = $event.target.checked"
                               class="w-4 h-4 rounded accent-violet-600">
                        <span class="text-sm font-medium text-gray-700">MUA ini menyediakan layanan home service</span>
                    </label>
                    <div class="mt-3" x-show="hs" x-cloak>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Radius Layanan (km)</label>
                        <input type="number" name="service_radius_km" min="0"
                               value="{{ old('service_radius_km', $mua->service_radius_km ?? '') }}"
                               class="w-32 px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300">
                    </div>
                </div>
            </div>

            {{-- Services --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-700">Layanan & Spesialisasi</h3>
                </div>
                <div class="p-6 space-y-5">
                    {{-- Event Types --}}
                    <div>
                        <p class="text-sm font-semibold text-gray-700 mb-2">Jenis Acara</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($eventTypes as $et)
                            @php $checked = collect(old('event_type_ids', $mua->eventTypes->pluck('id')->toArray() ?? []))->contains($et->id); @endphp
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" name="event_type_ids[]" value="{{ $et->id }}"
                                       {{ $checked ? 'checked' : '' }}
                                       class="rounded accent-violet-600">
                                <span class="text-sm text-gray-700">{{ $et->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Makeup Looks --}}
                    <div>
                        <p class="text-sm font-semibold text-gray-700 mb-2">Makeup Look</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($makeupLooks as $ml)
                            @php $checked = collect(old('makeup_look_ids', $mua->makeupLooks->pluck('id')->toArray() ?? []))->contains($ml->id); @endphp
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" name="makeup_look_ids[]" value="{{ $ml->id }}"
                                       {{ $checked ? 'checked' : '' }}
                                       class="rounded accent-violet-600">
                                <span class="text-sm text-gray-700">{{ $ml->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Themes --}}
                    <div>
                        <p class="text-sm font-semibold text-gray-700 mb-2">Tema</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($themes as $t)
                            @php $checked = collect(old('theme_ids', $mua->themes->pluck('id')->toArray() ?? []))->contains($t->id); @endphp
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" name="theme_ids[]" value="{{ $t->id }}"
                                       {{ $checked ? 'checked' : '' }}
                                       class="rounded accent-violet-600">
                                <span class="text-sm text-gray-700">{{ $t->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Theme Types --}}
                    <div>
                        <p class="text-sm font-semibold text-gray-700 mb-2">Tipe Tema</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($themeTypes as $tt)
                            @php $checked = collect(old('theme_type_ids', $mua->themeTypes->pluck('id')->toArray() ?? []))->contains($tt->id); @endphp
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" name="theme_type_ids[]" value="{{ $tt->id }}"
                                       {{ $checked ? 'checked' : '' }}
                                       class="rounded accent-violet-600">
                                <span class="text-sm text-gray-700">{{ $tt->name }}
                                    <span class="text-gray-400 text-xs">({{ $tt->theme->name }})</span>
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Service Districts --}}
                    <div>
                        <p class="text-sm font-semibold text-gray-700 mb-2">Area Layanan (Kecamatan)</p>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                            @foreach($districts as $d)
                            @php $checked = collect(old('service_district_ids', $mua->serviceDistricts->pluck('id')->toArray() ?? []))->contains($d->id); @endphp
                            <label class="flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" name="service_district_ids[]" value="{{ $d->id }}"
                                       {{ $checked ? 'checked' : '' }}
                                       class="rounded accent-violet-600">
                                <span class="text-sm text-gray-700">{{ $d->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right (account + status) --}}
        <div class="space-y-6">

            {{-- Account --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-700">Akun Login</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $mua->user->email ?? '') }}"
                               class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300 @error('email') border-red-400 @enderror">
                        @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Password {{ isset($mua) ? '(kosongkan jika tidak diubah)' : '' }}
                            @if(!isset($mua)) <span class="text-red-500">*</span> @endif
                        </label>
                        <input type="password" name="password"
                               class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300 @error('password') border-red-400 @enderror"
                               placeholder="Min. 6 karakter">
                        @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-700">Status</h3>
                </div>
                <div class="p-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', ($mua->is_active ?? true)) ? 'checked' : '' }}
                               class="w-4 h-4 rounded accent-violet-600">
                        <div>
                            <div class="text-sm font-medium text-gray-700">Aktif</div>
                            <div class="text-xs text-gray-400">MUA dapat tampil di hasil rekomendasi</div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col gap-3">
                <button type="submit"
                        class="w-full px-6 py-3 bg-violet-600 hover:bg-violet-700 text-white rounded-xl font-semibold text-sm transition-colors">
                    {{ isset($mua) ? 'Simpan Perubahan' : 'Buat MUA' }}
                </button>
                <a href="{{ route('admin.mua.index') }}"
                   class="w-full px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold text-sm text-center transition-colors no-underline">
                    Batal
                </a>
            </div>
        </div>
    </div>
</form>
@endsection
