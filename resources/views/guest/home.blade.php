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
<body class="bg-canvas text-ink font-sans">

{{-- ══════════════════════════════════════════════
     TOP NAVIGATION — sticky, mobile-first
══════════════════════════════════════════════ --}}
<header x-data="{ open: false }" class="bg-canvas border-b border-hairline sticky top-0 z-50">
    <div class="max-w-[1440px] mx-auto px-4 md:px-8 h-16 flex items-center justify-between gap-3">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 no-underline shrink-0">
            <div class="w-9 h-9 bg-primary rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-[11px] tracking-[0.5px]">MUA</span>
            </div>
            <span class="text-sm font-bold text-ink tracking-[0.3px]">Temanggung</span>
        </a>

        {{-- Desktop nav --}}
        <nav class="hidden md:flex items-center gap-8">
            <a href="#cara-kerja"   class="type-nav text-ink no-underline hover:text-primary transition-colors">Cara Kerja</a>
            <a href="#mua-unggulan" class="type-nav text-ink no-underline hover:text-primary transition-colors">MUA Unggulan</a>
            <a href="#jenis-acara"  class="type-nav text-ink no-underline hover:text-primary transition-colors">Jenis Acara</a>
        </nav>

        {{-- Right actions --}}
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('recommendation.form') }}"
               class="bg-primary text-white type-button px-4 sm:px-6 md:px-8 h-10 md:h-12 inline-flex items-center no-underline">
                <span class="md:hidden">Cari MUA</span>
                <span class="hidden md:inline">Cari Rekomendasi</span>
            </a>
            {{-- Hamburger --}}
            <button @click="open = !open"
                    class="md:hidden p-1.5 text-ink -mr-1.5 rounded"
                    aria-label="Toggle navigation">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile dropdown menu --}}
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="md:hidden bg-canvas border-t border-hairline">
        <nav class="px-4 py-5 flex flex-col gap-1">
            <a href="#cara-kerja"   @click="open=false" class="type-nav text-ink no-underline py-2.5 border-b border-hairline last:border-0">Cara Kerja</a>
            <a href="#mua-unggulan" @click="open=false" class="type-nav text-ink no-underline py-2.5 border-b border-hairline last:border-0">MUA Unggulan</a>
            <a href="#jenis-acara"  @click="open=false" class="type-nav text-ink no-underline py-2.5">Jenis Acara</a>
            <a href="{{ route('recommendation.form') }}" @click="open=false"
               class="mt-3 bg-primary text-white type-button h-12 flex items-center justify-center no-underline">
                Cari Rekomendasi MUA
            </a>
        </nav>
    </div>
</header>


{{-- ══════════════════════════════════════════════
     HERO BAND — dark navy, stacked layout
══════════════════════════════════════════════ --}}
<section class="bg-surface-dark relative overflow-hidden">

    {{-- Decorative grid --}}
    <div class="absolute inset-0 opacity-[0.04] pointer-events-none"
         style="background-image:repeating-linear-gradient(0deg,#fff 0,#fff 1px,transparent 1px,transparent 60px),repeating-linear-gradient(90deg,#fff 0,#fff 1px,transparent 1px,transparent 60px);">
    </div>

    {{-- Main copy --}}
    <div class="max-w-[1440px] mx-auto px-4 md:px-8 pt-14 md:pt-20 pb-12 md:pb-16 relative">
        <p class="type-label-up text-primary m-0 mb-5"
           data-aos="fade-up">Kabupaten Temanggung</p>
        <h1 class="type-display-xl text-white m-0 mb-6 max-w-[680px]"
            data-aos="fade-up" data-aos-delay="100">
            Temukan Make Up Artist Terbaik untuk Hari Istimewa Anda
        </h1>
        <p class="type-body-md text-on-dark-soft m-0 mb-10 max-w-[520px]"
           data-aos="fade-up" data-aos-delay="200">
            Sistem rekomendasi cerdas berbasis
            <strong class="text-white font-bold">Content-Based Filtering</strong>.
            Isi preferensi, sistem mencocokkan — temukan Top 3 MUA yang paling sesuai secara real-time.
        </p>
        <div class="flex flex-wrap gap-4"
             data-aos="fade-up" data-aos-delay="300">
            <a href="{{ route('recommendation.form') }}"
               class="bg-primary text-white type-button px-8 h-12 inline-flex items-center no-underline">
                Cari Rekomendasi MUA
            </a>
            <a href="#cara-kerja"
               class="type-label-up text-white px-6 h-12 inline-flex items-center no-underline"
               style="border:1px solid rgba(255,255,255,0.4);">
                Cara Kerja ›
            </a>
        </div>
    </div>

    {{-- Stats strip — full width, 4-col separator --}}
    <div class="border-t border-[#262e38]">
        <div class="max-w-[1440px] mx-auto px-4 md:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-[#262e38]">
                @php
                    $stats = [
                        ['value' => '20+',  'label' => 'MUA Profesional'],
                        ['value' => '9',    'label' => 'Jenis Acara'],
                        ['value' => '20',   'label' => 'Kecamatan'],
                        ['value' => '100%', 'label' => 'Gratis Digunakan'],
                    ];
                @endphp
                @foreach($stats as $stat)
                <div class="py-6 md:py-8 px-0 md:px-2 first:pl-0 last:pr-0
                            flex items-center gap-4 md:gap-5
                            {{ !$loop->first && $loop->index % 2 === 0 ? 'border-t border-[#262e38] md:border-t-0' : '' }}"
                     data-aos="fade-up" data-aos-delay="{{ ($loop->index + 1) * 80 }}">
                    <div class="type-display-sm md:type-display-md text-white shrink-0">{{ $stat['value'] }}</div>
                    <div class="type-body-sm text-on-dark-soft leading-snug">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</section>


{{-- ══════════════════════════════════════════════
     HOW IT WORKS — white canvas
══════════════════════════════════════════════ --}}
<section id="cara-kerja" class="bg-canvas py-14 md:py-20">
    <div class="max-w-[1440px] mx-auto px-4 md:px-8">

        <p class="type-label-up text-primary m-0 mb-3"
           data-aos="fade-up">Cara Kerja</p>
        <div class="flex items-end justify-between mb-10 md:mb-14 flex-wrap gap-4">
            <h2 class="type-display-md text-ink m-0 max-w-[400px]"
                data-aos="fade-up" data-aos-delay="100">Tiga Langkah Mudah</h2>
            <a href="{{ route('recommendation.form') }}"
               class="type-label-up text-ink no-underline whitespace-nowrap hidden sm:block"
               data-aos="fade-left" data-aos-delay="100">
                MULAI SEKARANG ›
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-px bg-hairline">
            @php
                $steps = [
                    [
                        'num'   => '01',
                        'title' => 'Isi Form Preferensi',
                        'body'  => 'Pilih jenis acara, tema, look makeup, lokasi, dan budget. Tanpa perlu daftar atau login — cukup isi form 7 langkah.',
                    ],
                    [
                        'num'   => '02',
                        'title' => 'Sistem Mencocokkan',
                        'body'  => 'Algoritma Cosine Similarity menghitung kemiripan antara preferensi Anda dengan profil setiap MUA secara real-time.',
                    ],
                    [
                        'num'   => '03',
                        'title' => 'Temukan Top 3 MUA',
                        'body'  => 'Lihat 3 MUA terbaik yang paling sesuai, cek portofolio & paket layanan, lalu hubungi langsung via WhatsApp atau Instagram.',
                    ],
                ];
            @endphp
            @foreach($steps as $step)
            <div class="bg-canvas p-8 md:p-10"
                 data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
                <div class="type-display-lg text-hairline leading-none m-0 mb-6">{{ $step['num'] }}</div>
                <h3 class="type-title-md text-ink m-0 mb-3">{{ $step['title'] }}</h3>
                <p class="type-body-md text-body m-0">{{ $step['body'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Mobile-only CTA below steps --}}
        <div class="sm:hidden mt-6">
            <a href="{{ route('recommendation.form') }}"
               class="type-label-up text-ink no-underline block text-center border border-hairline-strong py-3.5">
                MULAI SEKARANG ›
            </a>
        </div>

    </div>
</section>


{{-- ══════════════════════════════════════════════
     FEATURED MUA — surface-soft
══════════════════════════════════════════════ --}}
<section id="mua-unggulan" class="bg-surface-soft py-14 md:py-20">
    <div class="max-w-[1440px] mx-auto px-4 md:px-8">

        <p class="type-label-up text-primary m-0 mb-3"
           data-aos="fade-up">Makeup Artist Unggulan</p>
        <div class="flex items-end justify-between mb-10 md:mb-14 flex-wrap gap-4">
            <h2 class="type-display-md text-ink m-0"
                data-aos="fade-up" data-aos-delay="100">Temui Para Profesional</h2>
            <a href="{{ route('recommendation.form') }}"
               class="type-label-up text-ink no-underline whitespace-nowrap hidden sm:block"
               data-aos="fade-left" data-aos-delay="100">
                LIHAT SEMUA ›
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-px bg-hairline">
            @forelse($featuredMuas as $mua)
            <div class="bg-canvas flex flex-col"
                 data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                {{-- Photo plate --}}
                <div class="bg-surface-card aspect-[16/10] flex items-center justify-center overflow-hidden">
                    @if($mua->logo)
                        <img src="{{ $mua->logo_url }}" alt="{{ $mua->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-14 h-14 bg-primary rounded-full flex items-center justify-center">
                            <span class="text-white text-lg font-bold">
                                {{ strtoupper(substr($mua->name, 0, 1)) }}
                            </span>
                        </div>
                    @endif
                </div>
                {{-- Card body --}}
                <div class="p-5 md:p-6 flex flex-col flex-1">
                    <h3 class="type-title-md text-ink m-0 mb-1.5">{{ $mua->name }}</h3>
                    <p class="type-body-sm text-muted m-0 mb-3">
                        📍 {{ $mua->district?->name ?? 'Temanggung' }}
                        @if($mua->is_home_service)
                            &nbsp;·&nbsp; Home Service
                        @endif
                    </p>
                    @if($mua->makeupLooks->count())
                    <div class="flex flex-wrap gap-1 mb-5">
                        @foreach($mua->makeupLooks->take(3) as $look)
                        <span class="text-[11px] font-bold text-ink tracking-[0.5px] border border-hairline-strong bg-canvas px-2 py-0.5">
                            {{ $look->name }}
                        </span>
                        @endforeach
                    </div>
                    @endif
                    <a href="{{ route('mua.show', $mua->slug) }}"
                       class="type-label-up text-ink no-underline mt-auto">
                        LIHAT PROFIL ›
                    </a>
                </div>
            </div>
            @empty
            {{-- Skeleton placeholder --}}
            @for($i = 0; $i < 4; $i++)
            <div class="bg-canvas">
                <div class="bg-surface-card aspect-[16/10]"></div>
                <div class="p-5 md:p-6">
                    <div class="h-[18px] bg-surface-strong mb-2 w-[70%]"></div>
                    <div class="h-[14px] bg-surface-soft w-1/2"></div>
                </div>
            </div>
            @endfor
            @endforelse
        </div>

        {{-- Mobile-only CTA --}}
        <div class="sm:hidden mt-6">
            <a href="{{ route('recommendation.form') }}"
               class="type-label-up text-ink no-underline block text-center border border-hairline-strong py-3.5 bg-canvas">
                LIHAT SEMUA MUA ›
            </a>
        </div>

    </div>
</section>


{{-- ══════════════════════════════════════════════
     EVENT TYPES — white canvas
══════════════════════════════════════════════ --}}
<section id="jenis-acara" class="bg-canvas py-14 md:py-20">
    <div class="max-w-[1440px] mx-auto px-4 md:px-8">

        <p class="type-label-up text-primary m-0 mb-3"
           data-aos="fade-up">Jenis Acara</p>
        <h2 class="type-display-md text-ink m-0 mb-10 md:mb-14 max-w-[480px]"
            data-aos="fade-up" data-aos-delay="100">
            Semua Momen, Satu Platform
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-px bg-hairline">
            @php
                $eventTypes = [
                    ['icon' => '💍', 'name' => 'Akad',                   'desc' => 'Makeup pengantin untuk momen sakral ijab kabul'],
                    ['icon' => '✨', 'name' => 'Resepsi',                 'desc' => 'Tampil memukau di hari pesta pernikahan'],
                    ['icon' => '💐', 'name' => 'Lamaran',                 'desc' => 'Pertama kali tampil di hadapan keluarga calon'],
                    ['icon' => '🌸', 'name' => 'Siraman',                 'desc' => 'Khusus adat — tema otomatis tersedia'],
                    ['icon' => '📸', 'name' => 'Prewed',                  'desc' => 'Makeup sesi foto sebelum hari pernikahan'],
                    ['icon' => '🎓', 'name' => 'Wisuda & Yearbook',       'desc' => 'Untuk semua jenjang pendidikan'],
                    ['icon' => '🎭', 'name' => 'Character & Penokohan',   'desc' => 'Makeup karakter untuk pentas & karnaval'],
                    ['icon' => '💃', 'name' => 'Makeup Tari',             'desc' => 'Makeup tari tradisional & modern'],
                ];
            @endphp
            @foreach($eventTypes as $event)
            <div class="bg-canvas p-6 md:p-8 flex gap-4 items-start"
                 data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <span class="text-3xl shrink-0 leading-none mt-0.5">{{ $event['icon'] }}</span>
                <div>
                    <h3 class="type-title-sm text-ink m-0 mb-1.5">{{ $event['name'] }}</h3>
                    <p class="type-body-sm text-muted m-0">{{ $event['desc'] }}</p>
                </div>
            </div>
            @endforeach
            {{-- CTA cell --}}
            <div class="bg-surface-dark p-6 md:p-8 flex flex-col justify-center min-h-[120px]"
                 data-aos="fade-up" data-aos-delay="200">
                <p class="type-title-sm text-white m-0 mb-4">Cocok untuk semua momen Anda</p>
                <a href="{{ route('recommendation.form') }}"
                   class="type-label-up text-white no-underline px-5 py-3 w-fit"
                   style="border:1px solid rgba(255,255,255,0.4);">
                    MULAI CARI ›
                </a>
            </div>
        </div>

    </div>
</section>


{{-- ══════════════════════════════════════════════
     CTA BAND — dark navy, pre-footer
══════════════════════════════════════════════ --}}
<section class="bg-surface-dark py-14 md:py-20 text-center">
    <div class="max-w-[640px] mx-auto px-4 md:px-8">
        <p class="type-label-up text-primary m-0 mb-4"
           data-aos="fade-up">Gratis, Tanpa Login</p>
        <h2 class="type-display-md text-white m-0 mb-5"
            data-aos="fade-up" data-aos-delay="100">
            Siap Menemukan MUA yang Tepat?
        </h2>
        <p class="type-body-md text-on-dark-soft m-0 mb-10"
           data-aos="fade-up" data-aos-delay="200">
            Isi form preferensi dalam 2 menit. Sistem langsung menghitung kemiripan
            dan menampilkan rekomendasi terbaik untuk Anda.
        </p>
        <div class="flex justify-center flex-wrap gap-4"
             data-aos="fade-up" data-aos-delay="300">
            <a href="{{ route('recommendation.form') }}"
               class="bg-primary text-white type-button px-10 h-12 inline-flex items-center no-underline">
                Cari Rekomendasi MUA
            </a>
            <a href="#mua-unggulan"
               class="text-white type-button px-8 h-12 inline-flex items-center no-underline"
               style="border:1px solid rgba(255,255,255,0.35);">
                Lihat MUA Unggulan
            </a>
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════
     FOOTER — surface-soft
══════════════════════════════════════════════ --}}
<footer class="bg-surface-soft border-t border-hairline pt-12 md:pt-16 pb-8">
    <div class="max-w-[1440px] mx-auto px-4 md:px-8">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-[2fr_1fr_1fr_1fr] gap-8 md:gap-12 mb-10 md:mb-12">

            {{-- Brand --}}
            <div class="sm:col-span-2 lg:col-span-1">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center shrink-0">
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
                    <li><a href="{{ route('recommendation.form') }}" class="type-body-sm text-muted no-underline hover:text-ink transition-colors">Cari Rekomendasi</a></li>
                    <li><a href="#mua-unggulan" class="type-body-sm text-muted no-underline hover:text-ink transition-colors">MUA Unggulan</a></li>
                    <li><a href="#cara-kerja"   class="type-body-sm text-muted no-underline hover:text-ink transition-colors">Cara Kerja</a></li>
                </ul>
            </div>

            {{-- MUA --}}
            <div>
                <p class="type-label-up text-ink m-0 mb-4">MUA</p>
                <ul class="list-none p-0 m-0 flex flex-col gap-2.5">
                    <li><a href="/mua/login" class="type-body-sm text-muted no-underline hover:text-ink transition-colors">Login MUA</a></li>
                    <li><a href="#"          class="type-body-sm text-muted no-underline hover:text-ink transition-colors">Kelola Profil</a></li>
                </ul>
            </div>

            {{-- Admin --}}
            <div>
                <p class="type-label-up text-ink m-0 mb-4">Admin</p>
                <ul class="list-none p-0 m-0 flex flex-col gap-2.5">
                    <li><a href="/admin/login" class="type-body-sm text-muted no-underline hover:text-ink transition-colors">Login Admin</a></li>
                </ul>
            </div>

        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-hairline pt-6 flex items-center justify-between flex-wrap gap-2">
            <p class="type-caption text-muted-soft m-0">
                &copy; {{ date('Y') }} MUA Temanggung — Kabupaten Temanggung, Jawa Tengah
            </p>
            <p class="type-caption text-muted-soft m-0">
                Content-Based Filtering &middot; Cosine Similarity
            </p>
        </div>

    </div>
</footer>

</body>
</html>
