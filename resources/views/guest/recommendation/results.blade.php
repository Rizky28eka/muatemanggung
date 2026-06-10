@extends('layouts.app')

@section('title', 'Hasil Rekomendasi MUA Terpopuler')

@section('content')
<!-- Design Read: Reading this as: recommendation results page displaying a curated deck of Top 3 MUAs with percentage matching, using an artsy-professional layout, leaning toward purple & mint accents. -->

<div class="relative overflow-hidden bg-slate-50 py-16 min-h-[90vh] flex items-center">
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-[30%] -right-[10%] w-[600px] h-[600px] rounded-full bg-gradient-to-tr from-primary/10 to-accent/5 blur-[120px] opacity-70"></div>
        <div class="absolute -bottom-[20%] -left-[10%] w-[500px] h-[500px] rounded-full bg-gradient-to-br from-accent/10 to-primary/5 blur-[100px] opacity-60"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative space-y-12">
        
        <!-- Section Header -->
        <div class="text-center max-w-[600px] mx-auto space-y-3" data-aos="fade-up">
            <span class="text-[11px] font-mono uppercase tracking-[0.22em] text-primary">Kalkulasi Selesai</span>
            <h2 class="text-3xl font-display font-extrabold tracking-tight text-ink">Top 3 Rekomendasi MUA</h2>
            <p class="text-sm text-muted">Berikut 3 MUA yang memiliki indeks kecocokan tertinggi berdasarkan preferensi Anda.</p>
        </div>

        <!-- Recommendations Showcase -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Top 1 MUA (Big Hero card on Left, occupies 7 columns) -->
            @if(isset($results[0]))
                @php $top1 = $results[0]['mua']; $score1 = $results[0]['score']; @endphp
                <div class="lg:col-span-7 bg-white rounded-2xl border border-hairline shadow-lg overflow-hidden group flex flex-col justify-between h-full" 
                     data-aos="fade-right">
                    
                    <!-- Cover image of portfolio -->
                    <div class="aspect-[16/9] w-full bg-slate-100 overflow-hidden relative">
                        @if($top1->portfolios->isNotEmpty())
                            <img src="{{ $top1->portfolios->first()->url }}" class="w-full h-full object-cover group-hover:scale-102 transition-transform duration-500" alt="{{ $top1->name }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-primary-soft to-accent-soft flex items-center justify-center text-primary font-bold text-xs uppercase">
                                No Portfolio
                            </div>
                        @endif
                        
                        <!-- Rank Badge -->
                        <div class="absolute top-4 left-4 flex gap-2">
                            <span class="px-3.5 py-1.5 rounded-full bg-slate-900/90 text-white text-xs font-bold shadow flex items-center gap-1.5 backdrop-blur-sm">
                                <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span>
                                Rekomendasi #1
                            </span>
                        </div>

                        <!-- Match score badge -->
                        <div class="absolute top-4 right-4">
                            <span class="px-4 py-1.5 rounded-full bg-accent text-white text-xs font-extrabold shadow-md">
                                {{ $score1 }}% Cocok
                            </span>
                        </div>
                    </div>

                    <!-- Card details -->
                    <div class="p-8 space-y-6">
                        <div class="flex items-center gap-4">
                            <img src="{{ $top1->logo_url }}" class="w-12 h-12 rounded-full object-cover border border-hairline" alt="{{ $top1->name }} Logo">
                            <div>
                                <h3 class="text-xl font-display font-extrabold text-ink leading-tight">{{ $top1->name }}</h3>
                                <span class="text-xs text-muted flex items-center gap-1 mt-1">
                                    <svg class="w-3.5 h-3.5 text-primary-active/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Domisili: Kec. {{ $top1->district ? $top1->district->name : 'Temanggung' }}
                                </span>
                            </div>
                        </div>

                        <p class="text-sm text-body leading-relaxed max-w-[55ch]">
                            {{ $top1->description }}
                        </p>

                        <!-- Looks -->
                        <div class="flex flex-wrap gap-2">
                            @foreach($top1->makeupLooks as $look)
                                <span class="text-[9px] font-bold uppercase tracking-wider px-2.5 py-1 rounded bg-accent-soft text-accent border border-accent-light/50">
                                    {{ $look->name }}
                                </span>
                            @endforeach
                        </div>

                        <!-- Price summary & Quick WA/IG CTAs -->
                        <div class="pt-6 border-t border-hairline flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div>
                                <span class="block text-xs text-muted">Rentang Tarif</span>
                                <span class="text-base font-bold text-ink">
                                    @if($top1->packages->isNotEmpty())
                                        {{ rupiah_range($top1->packages->min('price'), $top1->packages->max('price')) }}
                                    @else
                                        Rp -
                                    @endif
                                </span>
                            </div>

                            <div class="flex items-center gap-2 w-full sm:w-auto">
                                @if($top1->whatsapp_number)
                                    <a href="{{ wa_link($top1->whatsapp_number) }}" 
                                       target="_blank" 
                                       class="inline-flex items-center justify-center px-4 py-2.5 rounded-full bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-bold border border-emerald-100/50 transition-all active:scale-95 active:translate-y-0.5">
                                        WhatsApp
                                    </a>
                                @endif
                                @if($top1->instagram_username)
                                    <a href="{{ ig_link($top1->instagram_username) }}" 
                                       target="_blank" 
                                       class="inline-flex items-center justify-center px-4 py-2.5 rounded-full bg-pink-50 hover:bg-pink-100 text-pink-700 text-xs font-bold border border-pink-100/50 transition-all active:scale-95 active:translate-y-0.5">
                                        Instagram
                                    </a>
                                @endif
                                <a href="{{ route('mua.show', $top1->slug) }}" 
                                   class="inline-flex items-center justify-center px-5 py-2.5 rounded-full bg-primary hover:bg-primary-active text-white text-xs font-bold transition-all active:scale-95 active:translate-y-0.5">
                                    Lihat Profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Top 2 & Top 3 MUA (Vertical list on Right, occupies 5 columns) -->
            <div class="lg:col-span-5 space-y-6">
                
                @if(isset($results[1]))
                    @php $top2 = $results[1]['mua']; $score2 = $results[1]['score']; @endphp
                    <div class="bg-white rounded-2xl border border-hairline p-6 shadow-sm hover:shadow-md transition-shadow duration-300 relative flex flex-col justify-between gap-4" 
                         data-aos="fade-left" data-aos-delay="100">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ $top2->logo_url }}" class="w-10 h-10 rounded-full object-cover border border-hairline" alt="{{ $top2->name }}">
                                <div>
                                    <span class="text-[9px] font-mono uppercase tracking-widest text-muted">Rekomendasi #2</span>
                                    <h4 class="text-sm font-display font-bold text-ink leading-tight">{{ $top2->name }}</h4>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-accent/15 text-accent text-[10px] font-extrabold">{{ $score2 }}% Match</span>
                        </div>
                        
                        <p class="text-xs text-muted line-clamp-2 leading-relaxed">
                            {{ $top2->description }}
                        </p>

                        <div class="flex items-center justify-between pt-2 border-t border-hairline">
                            <span class="text-xs font-bold text-ink">
                                @if($top2->packages->isNotEmpty())
                                    Mulai {{ rupiah($top2->packages->min('price')) }}
                                @else
                                    Rp -
                                @endif
                            </span>
                            <a href="{{ route('mua.show', $top2->slug) }}" 
                               class="inline-flex items-center text-xs font-bold text-primary hover:text-primary-active">
                                Detail Profil ➜
                            </a>
                        </div>
                    </div>
                @endif

                @if(isset($results[2]))
                    @php $top3 = $results[2]['mua']; $score3 = $results[2]['score']; @endphp
                    <div class="bg-white rounded-2xl border border-hairline p-6 shadow-sm hover:shadow-md transition-shadow duration-300 relative flex flex-col justify-between gap-4" 
                         data-aos="fade-left" data-aos-delay="200">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ $top3->logo_url }}" class="w-10 h-10 rounded-full object-cover border border-hairline" alt="{{ $top3->name }}">
                                <div>
                                    <span class="text-[9px] font-mono uppercase tracking-widest text-muted">Rekomendasi #3</span>
                                    <h4 class="text-sm font-display font-bold text-ink leading-tight">{{ $top3->name }}</h4>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-accent/15 text-accent text-[10px] font-extrabold">{{ $score3 }}% Match</span>
                        </div>
                        
                        <p class="text-xs text-muted line-clamp-2 leading-relaxed">
                            {{ $top3->description }}
                        </p>

                        <div class="flex items-center justify-between pt-2 border-t border-hairline">
                            <span class="text-xs font-bold text-ink">
                                @if($top3->packages->isNotEmpty())
                                    Mulai {{ rupiah($top3->packages->min('price')) }}
                                @else
                                    Rp -
                                @endif
                            </span>
                            <a href="{{ route('mua.show', $top3->slug) }}" 
                               class="inline-flex items-center text-xs font-bold text-primary hover:text-primary-active">
                                Detail Profil ➜
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Redirection block to search again -->
                <div class="p-6 rounded-2xl bg-slate-900 text-white flex flex-col gap-4 text-left shadow" data-aos="fade-left" data-aos-delay="300">
                    <h4 class="text-sm font-display font-bold leading-tight">Belum Menemukan yang Cocok?</h4>
                    <p class="text-[11px] text-[#8F8CA3] leading-relaxed">
                        Anda dapat menyesuaikan preferensi parameter Anda untuk menghitung kembali skor pencocokan.
                    </p>
                    <a href="{{ route('recommendation.form') }}" 
                       class="inline-flex items-center justify-center py-2.5 rounded-full bg-gradient-to-r from-primary to-accent hover:from-primary-active hover:to-accent-active text-white text-xs font-bold transition-all active:scale-95">
                        Cari Ulang Preferensi
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
