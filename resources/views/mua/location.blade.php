@extends('layouts.dashboard')
@section('title', 'Lokasi & Area Layanan')

@section('content')
<div class="space-y-5">

    {{-- ── Page Header ── --}}
    <div>
        <h1 class="font-display font-bold text-xl text-slate-900">Lokasi & Area Layanan</h1>
        <p class="text-xs text-slate-500 mt-0.5">Atur domisili usaha dan kecamatan yang dapat Anda layani.</p>
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

    <form action="{{ route('mua.location.update') }}" method="POST" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 items-start">

            {{-- ── Domisili Card ── --}}
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-5 space-y-4">
                <h3 class="text-xs font-bold text-slate-700">Domisili Usaha</h3>

                <div class="space-y-1.5">
                    <label class="block text-[11px] font-semibold text-slate-600">Kecamatan Domisili</label>
                    <select name="district_id" required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ old('district_id', $mua->district_id) == $district->id ? 'selected' : '' }}>
                                Kec. {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-[11px] font-semibold text-slate-600">Alamat Lengkap</label>
                    <textarea name="address" rows="3" placeholder="Nama jalan, dusun/RT-RW, dsb."
                              class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition resize-none">{{ old('address', $mua->address) }}</textarea>
                </div>
            </div>

            {{-- ── Home Service Card ── --}}
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-5 space-y-4">
                <h3 class="text-xs font-bold text-slate-700">Layanan Panggilan (Home Service)</h3>

                <label class="flex items-center justify-between gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer">
                    <div>
                        <span class="block text-[11px] font-bold text-slate-700">Sediakan Home Service</span>
                        <span class="block text-[10px] text-slate-400 mt-0.5">MUA datang ke lokasi acara klien.</span>
                    </div>
                    <input type="checkbox" name="is_home_service" value="1"
                           {{ old('is_home_service', $mua->is_home_service) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary/30">
                </label>

                <div class="space-y-1.5">
                    <label class="block text-[11px] font-semibold text-slate-600">Radius Jangkauan (km)</label>
                    <input type="number" name="service_radius_km" min="0" placeholder="mis. 15"
                           value="{{ old('service_radius_km', $mua->service_radius_km) }}"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                    <p class="text-[10px] text-slate-400">Perkiraan jarak maksimal yang dapat Anda jangkau dari domisili.</p>
                </div>
            </div>
        </div>

        {{-- ── Service Districts Card ── --}}
        <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-5 space-y-3">
            <div>
                <h3 class="text-xs font-bold text-slate-700">Kecamatan yang Dilayani</h3>
                <p class="text-[10px] text-slate-400 mt-0.5">Pilih semua kecamatan yang dapat Anda jangkau untuk layanan rias.</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2">
                @foreach($districts as $district)
                    <label class="flex items-center gap-2 px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-[11px] font-semibold text-slate-600 cursor-pointer hover:border-primary/40 has-[:checked]:border-primary has-[:checked]:bg-primary-soft has-[:checked]:text-primary transition">
                        <input type="checkbox" name="service_district_ids[]" value="{{ $district->id }}"
                               {{ $mua->serviceDistricts->contains($district->id) ? 'checked' : '' }}
                               class="rounded border-slate-300 text-primary focus:ring-primary/30">
                        Kec. {{ $district->name }}
                    </label>
                @endforeach
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
@endsection
