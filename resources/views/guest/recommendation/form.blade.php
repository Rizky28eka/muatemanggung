@extends('layouts.app')

@section('title', 'Cari Rekomendasi MUA — Preferensi Acara Anda')

@section('content')
<!-- Design Read: Reading this as: multi-step form for user preferences, using a minimal slide-forward presentation layout, leaning toward purple & mint accents and precise input spacing. -->

<div class="relative overflow-hidden bg-slate-50 py-12 min-h-[85vh] flex items-center">
    <!-- Background glows -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-[20%] -right-[10%] w-[500px] h-[500px] rounded-full bg-gradient-to-tr from-primary/5 to-accent/5 blur-[100px] opacity-70"></div>
        <div class="absolute -bottom-[20%] -left-[10%] w-[500px] h-[500px] rounded-full bg-gradient-to-br from-accent/5 to-primary/5 blur-[100px] opacity-70"></div>
    </div>

    <div class="max-w-[640px] mx-auto px-4 sm:px-6 lg:px-8 w-full relative">
        <!-- Main Form Wrapper Card -->
        <div class="bg-white rounded-2xl border border-slate-200/60 shadow-xl overflow-hidden" 
             x-data="{ 
                step: 1, 
                eventType: '', 
                isSiraman: false,
                theme: '', 
                themeType: '',
                look: '',
                homeService: '1',
                district: '',
                priceRange: '',
                selectEvent(id, slug) {
                    this.eventType = id;
                    this.isSiraman = (slug === 'siraman');
                    if (this.isSiraman) {
                        this.theme = '{{ $themes->where('slug', 'adat')->first()->id ?? '' }}';
                        this.themeType = '{{ $themeTypes->where('slug', 'jawa')->first()->id ?? '' }}'; // Default Jawa for adat
                        this.step = 4; // Skip theme choice step (step 2 & 3)
                    } else {
                        this.step = 2;
                    }
                },
                nextStep() {
                    if (this.step === 2 && this.isSiraman) {
                        this.step = 4; // Skip theme and type selections for siraman
                    } else {
                        this.step++;
                    }
                },
                prevStep() {
                    if (this.step === 4 && this.isSiraman) {
                        this.step = 1;
                    } else {
                        this.step--;
                    }
                }
             }">

            <!-- Progress Bar -->
            <div class="w-full bg-slate-100 h-1 flex overflow-hidden">
                <div class="bg-gradient-to-r from-primary to-accent transition-all duration-300" 
                     :style="'width: ' + ((step / 7) * 100) + '%'"></div>
            </div>

            <!-- Header of Card -->
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <span class="text-[9px] font-mono uppercase tracking-widest text-[#6E7191]">Cari Rekomendasi MUA</span>
                    <h2 class="text-lg font-display font-extrabold text-ink leading-tight mt-1">Form Preferensi</h2>
                </div>
                <span class="text-xs font-mono text-muted" x-text="'Langkah ' + step + ' / 7'"></span>
            </div>

            <!-- Form Content -->
            <form action="{{ route('recommendation.process') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <!-- Store variables in hidden inputs so standard submit works -->
                <input type="hidden" name="event_type_id" x-model="eventType">
                <input type="hidden" name="theme_id" x-model="theme">
                <input type="hidden" name="theme_type_id" x-model="themeType">
                <input type="hidden" name="makeup_look_id" x-model="look">
                <input type="hidden" name="wants_home_service" x-model="homeService">
                <input type="hidden" name="district_id" x-model="district">
                <input type="hidden" name="price_range_id" x-model="priceRange">

                <!-- STEP 1: Jenis Acara -->
                <div x-show="step === 1" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-sm font-display font-bold text-ink">Apa jenis acara yang Anda laksanakan?</label>
                        <p class="text-xs text-muted">Pilih satu jenis acara utama untuk pencarian MUA.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        @foreach($eventTypes as $event)
                            <button type="button" 
                                    @click="selectEvent('{{ $event->id }}', '{{ $event->slug }}')"
                                    class="p-4 rounded-xl border border-hairline hover:border-primary hover:bg-primary-soft text-left transition-all duration-200 group active:scale-98"
                                    :class="eventType == '{{ $event->id }}' ? 'border-primary bg-primary-soft text-primary' : 'bg-white text-ink'">
                                <span class="block text-xs font-bold leading-tight group-hover:text-primary">{{ $event->name }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- STEP 2: Tema Acara -->
                <div x-show="step === 2" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-sm font-display font-bold text-ink">Apa tema dekorasi / konsep acara Anda?</label>
                        <p class="text-xs text-muted">Memilih konsep membantu menyaring MUA dengan spesialisasi konsep tersebut.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        @foreach($themes as $theme)
                            <button type="button" 
                                    @click="theme = '{{ $theme->id }}'; step = 3"
                                    class="p-5 rounded-xl border border-hairline hover:border-primary hover:bg-primary-soft text-left transition-all duration-200 active:scale-98"
                                    :class="theme == '{{ $theme->id }}' ? 'border-primary bg-primary-soft text-primary' : 'bg-white text-ink'">
                                <span class="block text-xs font-bold">{{ $theme->name }}</span>
                                <span class="block text-[10px] text-muted mt-1">Gaya makeup & busana tradisional maupun modern.</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- STEP 3: Jenis Tema Acara (Tradisional/Adat Details or Modern) -->
                <div x-show="step === 3" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-sm font-display font-bold text-ink">Pilih gaya spesifik untuk acara Anda</label>
                        <p class="text-xs text-muted">Pilih detail adat atau modern kontemporer.</p>
                    </div>
                    
                    <div class="space-y-3 pt-2">
                        <!-- Show Traditional Styles if theme is Adat -->
                        <div x-show="theme == '{{ $themes->where('slug', 'adat')->first()->id ?? '' }}'" class="grid grid-cols-2 gap-3">
                            @foreach($themeTypes->where('theme.slug', 'adat') as $type)
                                <button type="button" 
                                        @click="themeType = '{{ $type->id }}'; step = 4"
                                        class="p-4 rounded-xl border border-hairline hover:border-primary hover:bg-primary-soft text-left transition-all duration-200 active:scale-98"
                                        :class="themeType == '{{ $type->id }}' ? 'border-primary bg-primary-soft text-primary' : 'bg-white text-ink'">
                                    <span class="block text-xs font-bold uppercase tracking-wider">{{ $type->name }}</span>
                                </button>
                            @endforeach
                        </div>

                        <!-- Show Modern Styles if theme is Modern -->
                        <div x-show="theme == '{{ $themes->where('slug', 'modern')->first()->id ?? '' }}'" class="grid grid-cols-2 gap-3">
                            @foreach($themeTypes->where('theme.slug', 'modern') as $type)
                                <button type="button" 
                                        @click="themeType = '{{ $type->id }}'; step = 4"
                                        class="p-4 rounded-xl border border-hairline hover:border-primary hover:bg-primary-soft text-left transition-all duration-200 active:scale-98"
                                        :class="themeType == '{{ $type->id }}' ? 'border-primary bg-primary-soft text-primary' : 'bg-white text-ink'">
                                    <span class="block text-xs font-bold uppercase tracking-wider">{{ $type->name }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- STEP 4: Home Service (Ya / Tidak) -->
                <div x-show="step === 4" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-sm font-display font-bold text-ink">Apakah Anda membutuhkan Home Service (layanan dipanggil ke lokasi)?</label>
                        <p class="text-xs text-muted">Ya jika Anda ingin MUA datang ke rumah/gedung Anda, Tidak jika Anda mendatangi studio MUA.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <button type="button" 
                                @click="homeService = '1'; step = 5"
                                class="p-5 rounded-xl border border-hairline hover:border-primary hover:bg-primary-soft text-left transition-all duration-200 active:scale-98"
                                :class="homeService == '1' ? 'border-primary bg-primary-soft text-primary' : 'bg-white text-ink'">
                            <span class="block text-xs font-bold">Ya, Butuh Home Service</span>
                            <span class="block text-[10px] text-muted mt-1">MUA akan mendatangi lokasi acara Anda.</span>
                        </button>
                        <button type="button" 
                                @click="homeService = '0'; step = 5"
                                class="p-5 rounded-xl border border-hairline hover:border-primary hover:bg-primary-soft text-left transition-all duration-200 active:scale-98"
                                :class="homeService == '0' ? 'border-primary bg-primary-soft text-primary' : 'bg-white text-ink'">
                            <span class="block text-xs font-bold">Tidak (Layanan di Studio)</span>
                            <span class="block text-[10px] text-muted mt-1">Anda akan mendatangi lokasi studio milik MUA.</span>
                        </button>
                    </div>
                </div>

                <!-- STEP 5: Look Makeup -->
                <div x-show="step === 5" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-sm font-display font-bold text-ink">Look makeup apa yang Anda inginkan?</label>
                        <p class="text-xs text-muted">Sesuaikan riasan dengan karakter wajah dan konsep busana.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        @foreach($makeupLooks as $look)
                            <button type="button" 
                                    @click="look = '{{ $look->id }}'; step = 6"
                                    class="p-4 rounded-xl border border-hairline hover:border-primary hover:bg-primary-soft text-left transition-all duration-200 active:scale-98"
                                    :class="look == '{{ $look->id }}' ? 'border-primary bg-primary-soft text-primary' : 'bg-white text-ink'">
                                <span class="block text-xs font-bold">{{ $look->name }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- STEP 6: Lokasi Acara (Kecamatan) -->
                <div x-show="step === 6" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-sm font-display font-bold text-ink" for="district_select">Di mana lokasi acara diselenggarakan?</label>
                        <p class="text-xs text-muted">Pilih kecamatan di Kabupaten Temanggung untuk menghitung jangkauan pelayanan.</p>
                    </div>
                    <div class="pt-2">
                        <select id="district_select" 
                                x-model="district" 
                                class="w-full px-4 py-3 rounded-xl border border-hairline text-xs font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 bg-white">
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}">Kec. {{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- STEP 7: Budget / Range Harga -->
                <div x-show="step === 7" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-sm font-display font-bold text-ink">Berapa kisaran anggaran maksimal Anda?</label>
                        <p class="text-xs text-muted">Menyaring MUA dengan ketersediaan paket dalam rentang harga ini.</p>
                    </div>
                    <div class="grid grid-cols-1 gap-2.5 pt-2">
                        @foreach($priceRanges as $range)
                            <button type="button" 
                                    @click="priceRange = '{{ $range->id }}'"
                                    class="p-4 rounded-xl border border-hairline hover:border-primary hover:bg-primary-soft text-left transition-all duration-200 flex justify-between items-center active:scale-98"
                                    :class="priceRange == '{{ $range->id }}' ? 'border-primary bg-primary-soft text-primary' : 'bg-white text-ink'">
                                <span class="text-xs font-bold">{{ $range->label }}</span>
                                <span class="text-[10px] text-muted">
                                    {{ rupiah_range($range->min_price, $range->max_price) }}
                                </span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Navigation Buttons inside the Form -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                    <button type="button" 
                            x-show="step > 1" 
                            @click="prevStep()" 
                            class="px-5 py-2.5 rounded-full border border-hairline text-xs font-semibold hover:bg-slate-50 transition-colors active:scale-95">
                        Kembali
                    </button>
                    <div x-show="step === 1" class="text-[10px] text-muted font-semibold">Pilih acara untuk memulai</div>

                    <button type="button" 
                            x-show="step > 1 && step < 7" 
                            @click="nextStep()" 
                            :disabled="step === 6 && !district"
                            class="px-6 py-2.5 rounded-full bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 disabled:opacity-50 transition-colors active:scale-95 ml-auto">
                        Lanjutkan
                    </button>
                    
                    <button type="submit" 
                            x-show="step === 7" 
                            :disabled="!district || !priceRange"
                            class="px-8 py-3 rounded-full bg-gradient-to-r from-primary to-accent hover:from-primary-active hover:to-accent-active disabled:opacity-50 text-white text-xs font-bold shadow-md shadow-primary/10 transition-all active:scale-95 ml-auto">
                        Cari Rekomendasi MUA
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
