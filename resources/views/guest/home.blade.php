<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Temukan Make Up Artist terbaik di Kabupaten Temanggung. Rekomendasi berbasis Content-Based Filtering sesuai preferensi acara, tema, dan budget Anda.">
    <title>MUA Temanggung — Rekomendasi Make Up Artist</title>
    <style>[x-cloak]{display:none!important}</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans" style="color:#1a1a1a;">

{{-- ══════════════════════════════════════════════
     NAVIGATION
══════════════════════════════════════════════ --}}
<header x-data="{ open: false }" class="bg-white sticky top-0 z-50 border-b border-primary-border">
    <div class="max-w-[1440px] mx-auto px-4 md:px-8 h-16 flex items-center justify-between gap-3">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 no-underline shrink-0">
            <div class="w-9 h-9 rounded-full flex items-center justify-center bg-primary">
                <span class="text-white font-bold text-[11px] tracking-[0.5px]">MUA</span>
            </div>
            <span class="text-sm font-bold text-ink tracking-[0.3px]">Temanggung</span>
        </a>

        {{-- Desktop nav --}}
        <nav class="hidden md:flex items-center gap-8">
            <a href="#cara-kerja"   class="type-nav text-body no-underline hover:text-primary transition-colors">Cara Kerja</a>
            <a href="#mua-unggulan" class="type-nav text-body no-underline hover:text-primary transition-colors">MUA Unggulan</a>
            <a href="#jenis-acara"  class="type-nav text-body no-underline hover:text-primary transition-colors">Jenis Acara</a>
        </nav>

        {{-- Right actions --}}
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('recommendation.form') }}"
               class="bg-primary text-white type-button px-4 sm:px-6 md:px-8 h-10 md:h-12 inline-flex items-center no-underline rounded-full transition-all hover:bg-primary-active">
                <span class="md:hidden">Cari MUA</span>
                <span class="hidden md:inline">Cari Rekomendasi</span>
            </a>
            <button @click="open = !open" class="md:hidden p-1.5 -mr-1.5 text-ink" aria-label="Menu">
                <svg x-show="!open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="md:hidden bg-white border-t border-primary-border">
        <nav class="px-4 py-5 flex flex-col gap-1">
            <a href="#cara-kerja"   @click="open=false" class="type-nav text-body no-underline py-2.5 border-b border-primary-light">Cara Kerja</a>
            <a href="#mua-unggulan" @click="open=false" class="type-nav text-body no-underline py-2.5 border-b border-primary-light">MUA Unggulan</a>
            <a href="#jenis-acara"  @click="open=false" class="type-nav text-body no-underline py-2.5">Jenis Acara</a>
            <a href="{{ route('recommendation.form') }}" @click="open=false"
               class="bg-primary text-white type-button h-12 flex items-center justify-center no-underline mt-3 rounded-full hover:bg-primary-active transition-colors">
                Cari Rekomendasi MUA
            </a>
        </nav>
    </div>
</header>


{{-- ══════════════════════════════════════════════
     HERO — purple gradient, split layout
══════════════════════════════════════════════ --}}
<section class="relative overflow-hidden" style="background:linear-gradient(135deg,#7c3aed 0%,#5b21b6 100%); min-height:580px;">

    {{-- Decorative blobs --}}
    <div class="absolute -top-24 -right-16 w-96 h-96 rounded-full pointer-events-none opacity-20" style="background:radial-gradient(circle,#a78bfa,transparent);"></div>
    <div class="absolute bottom-0 left-1/3 w-80 h-80 rounded-full pointer-events-none opacity-10" style="background:radial-gradient(circle,#10b981,transparent);"></div>
    <div class="absolute -bottom-20 -left-20 w-64 h-64 rounded-full pointer-events-none opacity-15" style="background:radial-gradient(circle,#c4b5fd,transparent);"></div>

    <div class="max-w-[1440px] mx-auto px-4 md:px-8 relative">
        <div class="grid grid-cols-1 lg:grid-cols-[3fr_2fr] items-center" style="min-height:580px;">

            {{-- Left: copy --}}
            <div class="py-16 md:py-24">
                <p class="type-label-up m-0 mb-5" style="color:rgba(196,181,253,0.9);"
                   data-aos="fade-up">Kabupaten Temanggung</p>
                <h1 class="type-display-xl text-white m-0 mb-6 max-w-[580px]"
                    data-aos="fade-up" data-aos-delay="100">
                    Temukan Make Up Artist Terbaik untuk Hari Istimewa Anda
                </h1>
                <p class="type-body-md m-0 mb-10 max-w-[480px]" style="color:rgba(221,214,254,0.85);"
                   data-aos="fade-up" data-aos-delay="200">
                    Rekomendasi berbasis <strong class="text-white font-bold">Content-Based Filtering</strong>.
                    Isi preferensi dalam 2 menit — temukan Top 3 MUA yang paling sesuai, tanpa login.
                </p>
                <div class="flex flex-wrap gap-4" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('recommendation.form') }}"
                       class="bg-white type-button px-8 h-12 inline-flex items-center no-underline rounded-full transition-opacity hover:opacity-90 text-primary">
                        Cari Rekomendasi MUA
                    </a>
                    <a href="#cara-kerja"
                       class="text-white type-button px-6 h-12 inline-flex items-center no-underline rounded-full"
                       style="border:1px solid rgba(196,181,253,0.5);">
                        Cara Kerja ›
                    </a>
                </div>
            </div>

            {{-- Right: floating result cards --}}
            <div class="hidden lg:flex flex-col justify-center items-center gap-3 py-16"
                 data-aos="fade-left" data-aos-delay="350">
                @php
                    $previewCards = [
                        ['name' => 'Zahra MUA Studio',  'sub' => 'Akad · Adat Jawa · Soft Look',   'score' => '98%', 'alpha' => '0.97'],
                        ['name' => 'Elly Neisya MUA',   'sub' => 'Resepsi · Modern · Natural Look', 'score' => '94%', 'alpha' => '0.82'],
                        ['name' => 'Cissy Rhy MUA',     'sub' => 'Akad · Adat Sunda · Bold Look',  'score' => '91%', 'alpha' => '0.65'],
                    ];
                @endphp
                @foreach($previewCards as $card)
                <div class="w-full max-w-[340px] flex items-center gap-3.5 px-5 py-4 rounded-2xl"
                     style="background:rgba(255,255,255,{{ $card['alpha'] }}); backdrop-filter:blur(12px); box-shadow:0 4px 24px rgba(91,33,182,0.15);">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 text-white font-bold text-sm"
                         style="background:linear-gradient(135deg,#7c3aed,#10b981);">
                        {{ strtoupper(substr($card['name'], 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[13px] font-bold leading-tight text-ink">{{ $card['name'] }}</div>
                        <div class="text-[11px] mt-0.5 truncate text-muted">{{ $card['sub'] }}</div>
                    </div>
                    <div class="text-[13px] font-bold shrink-0 text-accent">{{ $card['score'] }}</div>
                </div>
                @endforeach
                <p class="type-caption mt-1 text-center" style="color:rgba(196,181,253,0.7); letter-spacing:1px; text-transform:uppercase;">
                    Contoh Hasil Rekomendasi
                </p>
            </div>

        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════
     STATS STRIP
══════════════════════════════════════════════ --}}
<div class="bg-white border-b border-primary-border">
    <div class="max-w-[1440px] mx-auto px-4 md:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4">
            @php
                $stats = [
                    ['value' => '20+',  'label' => 'MUA Profesional', 'icon' => '💄', 'color' => 'text-primary'],
                    ['value' => '9',    'label' => 'Jenis Acara',      'icon' => '✨', 'color' => 'text-accent'],
                    ['value' => '20',   'label' => 'Kecamatan',        'icon' => '📍', 'color' => 'text-primary'],
                    ['value' => '100%', 'label' => 'Gratis Digunakan', 'icon' => '🎁', 'color' => 'text-accent'],
                ];
            @endphp
            @foreach($stats as $stat)
            <div class="py-6 md:py-7 px-4 flex items-center gap-3 md:justify-center border-primary-border"
                 style="{{ !$loop->last ? 'border-right:1px solid #ddd6fe;' : '' }}{{ $loop->index >= 2 ? 'border-top:1px solid #ddd6fe;' : '' }} {{ !$loop->last && $loop->index < 2 ? '' : '' }}"
                 data-aos="fade-up" data-aos-delay="{{ ($loop->index + 1) * 80 }}">
                <span class="text-2xl hidden sm:block">{{ $stat['icon'] }}</span>
                <div>
                    <div class="type-display-sm font-bold m-0 {{ $stat['color'] }}">{{ $stat['value'] }}</div>
                    <div class="type-body-sm text-muted">{{ $stat['label'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════
     MUA UNGGULAN
══════════════════════════════════════════════ --}}
<section id="mua-unggulan" class="py-14 md:py-20 bg-primary-soft">
    <div class="max-w-[1440px] mx-auto px-4 md:px-8">

        <p class="type-label-up text-primary m-0 mb-3" data-aos="fade-up">Makeup Artist Unggulan</p>
        <div class="flex items-end justify-between mb-10 md:mb-12 flex-wrap gap-4">
            <h2 class="type-display-md text-ink m-0" data-aos="fade-up" data-aos-delay="100">Temui Para Profesional</h2>
            <a href="{{ route('recommendation.form') }}"
               class="type-label-up text-ink no-underline whitespace-nowrap hidden sm:block hover:text-primary transition-colors"
               data-aos="fade-left" data-aos-delay="100">LIHAT SEMUA ›</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 md:gap-6">
            @forelse($featuredMuas as $mua)
            <div class="bg-white rounded-2xl overflow-hidden flex flex-col transition-transform hover:-translate-y-1"
                 style="box-shadow:0 2px 20px rgba(124,58,237,0.08);"
                 data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                {{-- Photo plate --}}
                <div class="aspect-[4/3] flex items-center justify-center overflow-hidden relative"
                     style="background:linear-gradient(135deg,#ede9fe 0%,#ddd6fe 100%);">
                    @if($mua->logo)
                        <img src="{{ $mua->logo_url }}" alt="{{ $mua->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-16 h-16 rounded-full flex items-center justify-center"
                             style="background:linear-gradient(135deg,#7c3aed,#10b981);">
                            <span class="text-white text-2xl font-bold">{{ strtoupper(substr($mua->name, 0, 1)) }}</span>
                        </div>
                    @endif
                    @if($mua->is_home_service)
                    <div class="absolute top-3 right-3 px-2.5 py-1 text-white text-[11px] font-bold tracking-[0.5px] rounded-full bg-accent">
                        Home Service
                    </div>
                    @endif
                </div>
                {{-- Body --}}
                <div class="p-5 flex flex-col flex-1">
                    <h3 class="type-title-md text-ink m-0 mb-1">{{ $mua->name }}</h3>
                    <p class="type-body-sm text-muted m-0 mb-3">📍 {{ $mua->district?->name ?? 'Temanggung' }}</p>
                    @if($mua->makeupLooks->count())
                    <div class="flex flex-wrap gap-1.5 mb-4">
                        @foreach($mua->makeupLooks->take(3) as $look)
                        <span class="text-[11px] font-bold px-2.5 py-1 rounded-full text-accent bg-accent-soft">
                            {{ $look->name }}
                        </span>
                        @endforeach
                    </div>
                    @endif
                    <a href="{{ route('mua.show', $mua->slug) }}"
                       class="type-label-up text-primary no-underline mt-auto hover:text-primary-active transition-colors">
                        LIHAT PROFIL ›
                    </a>
                </div>
            </div>
            @empty
            @for($i = 0; $i < 4; $i++)
            <div class="bg-white rounded-2xl overflow-hidden" style="box-shadow:0 2px 20px rgba(124,58,237,0.08);">
                <div class="aspect-[4/3] animate-pulse" style="background:linear-gradient(135deg,#ede9fe,#ddd6fe);"></div>
                <div class="p-5">
                    <div class="h-5 bg-primary-light rounded-lg mb-2 w-3/4"></div>
                    <div class="h-4 bg-primary-soft rounded-lg w-1/2"></div>
                </div>
            </div>
            @endfor
            @endforelse
        </div>

        <div class="sm:hidden mt-6">
            <a href="{{ route('recommendation.form') }}"
               class="type-label-up text-primary no-underline block text-center py-3.5 rounded-xl bg-primary-light">
                LIHAT SEMUA MUA ›
            </a>
        </div>

    </div>
</section>


{{-- ══════════════════════════════════════════════
     CARA KERJA
══════════════════════════════════════════════ --}}
<section id="cara-kerja" class="bg-white py-14 md:py-20">
    <div class="max-w-[1440px] mx-auto px-4 md:px-8">

        <p class="type-label-up text-primary m-0 mb-3" data-aos="fade-up">Cara Kerja</p>
        <div class="flex items-end justify-between mb-10 md:mb-14 flex-wrap gap-4">
            <h2 class="type-display-md text-ink m-0 max-w-[400px]"
                data-aos="fade-up" data-aos-delay="100">Tiga Langkah Mudah</h2>
            <a href="{{ route('recommendation.form') }}"
               class="type-label-up text-ink no-underline whitespace-nowrap hidden sm:block hover:text-primary transition-colors"
               data-aos="fade-left" data-aos-delay="100">MULAI SEKARANG ›</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-10">
            @php
                $steps = [
                    ['num' => '01', 'icon' => '📝', 'bg' => 'bg-primary-light',  'title' => 'Isi Form Preferensi',
                     'body' => 'Pilih jenis acara, tema, look makeup, lokasi, dan budget. Tanpa perlu daftar atau login — cukup isi form 7 langkah.'],
                    ['num' => '02', 'icon' => '⚡', 'bg' => 'bg-accent-light',   'title' => 'Sistem Mencocokkan',
                     'body' => 'Algoritma Cosine Similarity menghitung kemiripan antara preferensi Anda dengan profil setiap MUA secara real-time.'],
                    ['num' => '03', 'icon' => '💄', 'bg' => 'bg-primary-light',  'title' => 'Temukan Top 3 MUA',
                     'body' => 'Lihat 3 MUA terbaik yang paling sesuai, cek portofolio & paket, lalu hubungi langsung via WhatsApp atau Instagram.'],
                ];
            @endphp
            @foreach($steps as $step)
            <div class="relative" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
                @if(!$loop->last)
                <div class="hidden md:block absolute top-8 left-full w-full h-px pointer-events-none"
                     style="background:linear-gradient(90deg,#ddd6fe,transparent); transform:translateX(20px); width:calc(100% - 56px);"></div>
                @endif
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-5 text-2xl {{ $step['bg'] }}">
                    {{ $step['icon'] }}
                </div>
                <div class="type-label-up text-primary m-0 mb-2">{{ $step['num'] }}</div>
                <h3 class="type-title-md text-ink m-0 mb-3">{{ $step['title'] }}</h3>
                <p class="type-body-md text-body m-0">{{ $step['body'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="sm:hidden mt-8">
            <a href="{{ route('recommendation.form') }}"
               class="type-label-up text-primary no-underline block text-center py-3.5 rounded-xl bg-primary-soft border border-primary-border">
                MULAI SEKARANG ›
            </a>
        </div>

    </div>
</section>


{{-- ══════════════════════════════════════════════
     KENAPA KAMI? — split section
══════════════════════════════════════════════ --}}
<section class="py-14 md:py-20 bg-primary-soft">
    <div class="max-w-[1440px] mx-auto px-4 md:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

            {{-- Left: content --}}
            <div data-aos="fade-right">
                <p class="type-label-up text-accent m-0 mb-4">Kenapa Platform Ini?</p>
                <h2 class="type-display-md text-ink m-0 mb-5 max-w-[440px]">
                    Rekomendasi Cerdas untuk Momen Spesial Anda
                </h2>
                <p class="type-body-md text-body m-0 mb-8 max-w-[460px]">
                    Kami hadir untuk membantu Anda menemukan MUA yang benar-benar sesuai — bukan sekedar yang terdekat, tapi yang paling cocok dengan acara, tema, dan selera Anda.
                </p>
                <div class="flex flex-col gap-5">
                    @php
                        $features = [
                            ['icon' => '🎯', 'bg' => 'bg-primary-light', 'color' => 'text-primary',
                             'title' => 'Rekomendasi Akurat',
                             'body'  => 'Algoritma Cosine Similarity mencocokkan preferensi Anda dengan data lengkap setiap MUA secara real-time.'],
                            ['icon' => '🔓', 'bg' => 'bg-accent-soft',   'color' => 'text-accent',
                             'title' => 'Tanpa Login, Gratis',
                             'body'  => 'Tidak perlu daftar akun. Langsung isi form, dapatkan rekomendasi, dan hubungi MUA pilihan Anda.'],
                            ['icon' => '🏠', 'bg' => 'bg-primary-light', 'color' => 'text-primary',
                             'title' => 'Ada yang Home Service',
                             'body'  => 'Banyak MUA tersedia untuk datang ke lokasi Anda. Filter berdasarkan kecamatan dan area jangkauan.'],
                        ];
                    @endphp
                    @foreach($features as $feat)
                    <div class="flex gap-4 items-start">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 text-xl {{ $feat['bg'] }}">
                            {{ $feat['icon'] }}
                        </div>
                        <div>
                            <h3 class="type-title-sm text-ink m-0 mb-1">{{ $feat['title'] }}</h3>
                            <p class="type-body-sm text-muted m-0">{{ $feat['body'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Right: collage placeholder --}}
            <div class="grid grid-cols-2 gap-3 md:gap-4 max-w-[480px] mx-auto lg:mx-0 w-full"
                 data-aos="fade-left" data-aos-delay="150">
                <div class="flex flex-col gap-3 md:gap-4">
                    <div class="aspect-[3/4] rounded-2xl flex items-center justify-center overflow-hidden"
                         style="background:linear-gradient(160deg,#ede9fe,#c4b5fd);">
                        <div class="text-center px-4">
                            <div class="text-4xl mb-2">💍</div>
                            <div class="type-caption font-bold uppercase tracking-widest text-primary">Akad</div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-3 md:gap-4 pt-8">
                    <div class="aspect-square rounded-2xl flex items-center justify-center overflow-hidden"
                         style="background:linear-gradient(160deg,#d1fae5,#a7f3d0);">
                        <div class="text-center px-4">
                            <div class="text-4xl mb-2">✨</div>
                            <div class="type-caption font-bold uppercase tracking-widest text-accent">Resepsi</div>
                        </div>
                    </div>
                    <div class="aspect-[4/3] rounded-2xl flex items-center justify-center overflow-hidden"
                         style="background:linear-gradient(160deg,#f5f0ff,#ede9fe);">
                        <div class="text-center px-4">
                            <div class="text-4xl mb-2">📸</div>
                            <div class="type-caption font-bold uppercase tracking-widest text-primary">Prewed</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════
     JENIS ACARA
══════════════════════════════════════════════ --}}
<section id="jenis-acara" class="bg-white py-14 md:py-20">
    <div class="max-w-[1440px] mx-auto px-4 md:px-8">

        <p class="type-label-up text-primary m-0 mb-3" data-aos="fade-up">Jenis Acara</p>
        <h2 class="type-display-md text-ink m-0 mb-10 md:mb-12 max-w-[480px]"
            data-aos="fade-up" data-aos-delay="100">Semua Momen, Satu Platform</h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-5">
            @php
                $eventTypes = [
                    ['icon' => '💍', 'name' => 'Akad',               'desc' => 'Makeup sakral ijab kabul'],
                    ['icon' => '✨', 'name' => 'Resepsi',             'desc' => 'Pesta hari pernikahan'],
                    ['icon' => '💐', 'name' => 'Lamaran',             'desc' => 'Pertemuan keluarga calon'],
                    ['icon' => '🌸', 'name' => 'Siraman',             'desc' => 'Khusus adat — tema otomatis'],
                    ['icon' => '📸', 'name' => 'Prewed',              'desc' => 'Sesi foto sebelum menikah'],
                    ['icon' => '🎓', 'name' => 'Wisuda & Yearbook',   'desc' => 'Semua jenjang pendidikan'],
                    ['icon' => '🎭', 'name' => 'Character',           'desc' => 'Pentas & karnaval'],
                    ['icon' => '💃', 'name' => 'Makeup Tari',         'desc' => 'Tari tradisional & modern'],
                ];
            @endphp
            @foreach($eventTypes as $event)
            <a href="{{ route('recommendation.form') }}"
               class="no-underline group p-5 md:p-6 rounded-2xl flex flex-col gap-3 border border-primary-border bg-primary-soft transition-all duration-200 hover:-translate-y-0.5 hover:border-primary hover:shadow-sm"
               data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 80 }}">
                <span class="text-3xl">{{ $event['icon'] }}</span>
                <div>
                    <h3 class="type-title-sm text-ink m-0 mb-1 group-hover:text-primary transition-colors">{{ $event['name'] }}</h3>
                    <p class="type-body-sm text-muted m-0">{{ $event['desc'] }}</p>
                </div>
            </a>
            @endforeach
        </div>

    </div>
</section>


{{-- ══════════════════════════════════════════════
     CTA BAND
══════════════════════════════════════════════ --}}
<section class="py-14 md:py-20 text-center relative overflow-hidden"
         style="background:linear-gradient(135deg,#7c3aed 0%,#5b21b6 100%);">
    <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full pointer-events-none opacity-20" style="background:radial-gradient(circle,#a78bfa,transparent);"></div>
    <div class="absolute bottom-0 left-1/4 w-48 h-48 rounded-full pointer-events-none opacity-15" style="background:radial-gradient(circle,#10b981,transparent);"></div>

    <div class="max-w-[640px] mx-auto px-4 md:px-8 relative">
        <p class="type-label-up m-0 mb-4" style="color:rgba(196,181,253,0.9);"
           data-aos="fade-up">Gratis, Tanpa Login</p>
        <h2 class="type-display-md text-white m-0 mb-5"
            data-aos="fade-up" data-aos-delay="100">Siap Menemukan MUA yang Tepat?</h2>
        <p class="type-body-md m-0 mb-10" style="color:rgba(221,214,254,0.85);"
           data-aos="fade-up" data-aos-delay="200">
            Isi form preferensi dalam 2 menit. Sistem langsung menghitung kemiripan
            dan menampilkan rekomendasi terbaik untuk Anda.
        </p>
        <div class="flex justify-center flex-wrap gap-4" data-aos="fade-up" data-aos-delay="300">
            <a href="{{ route('recommendation.form') }}"
               class="bg-white type-button px-10 h-12 inline-flex items-center no-underline rounded-full hover:opacity-90 transition-opacity text-primary">
                Cari Rekomendasi MUA
            </a>
            <a href="#mua-unggulan"
               class="text-white type-button px-8 h-12 inline-flex items-center no-underline rounded-full"
               style="border:1px solid rgba(196,181,253,0.5);">
                Lihat MUA Unggulan
            </a>
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════
     FOOTER
══════════════════════════════════════════════ --}}
<footer class="bg-white border-t border-primary-border pt-12 md:pt-16 pb-8">
    <div class="max-w-[1440px] mx-auto px-4 md:px-8">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-[2fr_1fr_1fr_1fr] gap-8 md:gap-12 mb-10 md:mb-12">

            {{-- Brand --}}
            <div class="sm:col-span-2 lg:col-span-1">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-primary shrink-0">
                        <span class="text-white font-bold text-[10px] tracking-[0.5px]">MUA</span>
                    </div>
                    <span class="text-sm font-bold text-ink">MUA Temanggung</span>
                </div>
                <p class="type-body-sm text-muted max-w-[280px] m-0">
                    Sistem rekomendasi Make Up Artist berbasis
                    <em class="not-italic text-body">Content-Based Filtering</em>
                    untuk Kabupaten Temanggung.
                </p>
            </div>

            {{-- Platform --}}
            <div>
                <p class="type-label-up text-ink m-0 mb-4">Platform</p>
                <ul class="list-none p-0 m-0 flex flex-col gap-2.5">
                    <li><a href="{{ route('recommendation.form') }}" class="type-body-sm text-muted no-underline hover:text-primary transition-colors">Cari Rekomendasi</a></li>
                    <li><a href="#mua-unggulan" class="type-body-sm text-muted no-underline hover:text-primary transition-colors">MUA Unggulan</a></li>
                    <li><a href="#cara-kerja"   class="type-body-sm text-muted no-underline hover:text-primary transition-colors">Cara Kerja</a></li>
                </ul>
            </div>

            {{-- MUA --}}
            <div>
                <p class="type-label-up text-ink m-0 mb-4">MUA</p>
                <ul class="list-none p-0 m-0 flex flex-col gap-2.5">
                    <li><a href="/mua/login" class="type-body-sm text-muted no-underline hover:text-primary transition-colors">Login MUA</a></li>
                    <li><a href="#"          class="type-body-sm text-muted no-underline hover:text-primary transition-colors">Kelola Profil</a></li>
                </ul>
            </div>

            {{-- Admin --}}
            <div>
                <p class="type-label-up text-ink m-0 mb-4">Admin</p>
                <ul class="list-none p-0 m-0 flex flex-col gap-2.5">
                    <li><a href="/admin/login" class="type-body-sm text-muted no-underline hover:text-primary transition-colors">Login Admin</a></li>
                </ul>
            </div>

        </div>

        <div class="border-t border-primary-border pt-6 flex items-center justify-between flex-wrap gap-2">
            <p class="type-caption text-muted-soft m-0">&copy; {{ date('Y') }} MUA Temanggung — Kabupaten Temanggung, Jawa Tengah</p>
            <p class="type-caption text-muted-soft m-0">Content-Based Filtering &middot; Cosine Similarity</p>
        </div>

    </div>
</footer>

</body>
</html>
