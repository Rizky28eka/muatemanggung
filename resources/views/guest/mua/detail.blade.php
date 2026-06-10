@extends('layouts.app')

@section('title', $mua->name . ' — Profil MUA Temanggung')

@section('content')
<!-- Design Read: Reading this as: MUA detail profile page showing portfolio, packages and direct redirect CTAs, using a split asymmetric layout, leaning toward purple & mint accents. -->

<div class="relative overflow-hidden bg-slate-50 py-12 min-h-[90vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative space-y-8">
        
        <!-- Quick back link -->
        <div class="flex items-center gap-2 text-xs font-mono text-muted">
            <a href="{{ route('home') }}" class="hover:text-primary">Home</a>
            <span>/</span>
            <span class="text-ink">Detail MUA</span>
            <span>/</span>
            <span class="text-ink font-bold">{{ $mua->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Side: Profile Info (Occupies 4 columns) -->
            <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">
                
                <!-- Main Profile Info Card -->
                <div class="bg-white rounded-2xl border border-hairline p-6 shadow-sm space-y-6">
                    <div class="flex items-center gap-4">
                        <img src="{{ $mua->logo_url }}" class="w-16 h-16 rounded-xl object-cover border border-hairline" alt="{{ $mua->name }} Logo">
                        <div class="space-y-1">
                            <h2 class="text-lg font-display font-extrabold text-ink leading-tight">{{ $mua->name }}</h2>
                            <span class="text-xs text-muted flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Kec. {{ $mua->district ? $mua->district->name : 'Temanggung' }}
                            </span>
                        </div>
                    </div>

                    <!-- Looks Badges -->
                    <div class="flex flex-wrap gap-1.5 pt-2 border-t border-hairline">
                        @foreach($mua->makeupLooks as $look)
                            <span class="text-[9px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-accent-soft text-accent">
                                {{ $look->name }}
                            </span>
                        @endforeach
                    </div>

                    <!-- Description -->
                    <div class="space-y-2 text-left">
                        <h4 class="text-xs font-mono uppercase tracking-widest text-[#6E7191]">Tentang MUA</h4>
                        <p class="text-xs text-muted leading-relaxed">
                            {{ $mua->description }}
                        </p>
                    </div>

                    <!-- Address & Service Area -->
                    <div class="space-y-3 pt-4 border-t border-hairline text-left text-xs">
                        <div class="flex justify-between">
                            <span class="text-muted">Home Service:</span>
                            <span class="font-bold text-ink">{{ $mua->is_home_service ? 'Tersedia (Bisa dipanggil)' : 'Tidak Tersedia (Layanan di Studio)' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-muted">Radius Layanan:</span>
                            <span class="font-bold text-ink">±{{ $mua->service_radius_km ?? '30' }} km</span>
                        </div>
                    </div>

                    <!-- Social CTA Buttons -->
                    <div class="space-y-2 pt-4 border-t border-hairline">
                        @if($mua->whatsapp_number)
                            <a href="{{ wa_link($mua->whatsapp_number) }}" 
                               target="_blank" 
                               class="w-full inline-flex items-center justify-center py-3 rounded-full bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold shadow-md shadow-emerald-500/10 transition-all active:scale-95 active:translate-y-0.5">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.727-1.458L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.968C16.49 1.97 14.027 1.05 11.4 1.05c-5.44 0-9.866 4.372-9.87 9.802 0 1.972.517 3.896 1.5 5.614l-.997 3.64 3.734-.972zm12.193-6.52c-.31-.156-1.834-.894-2.115-1-.28-.103-.485-.156-.69.156-.206.31-.794.996-.973 1.203-.18.206-.357.23-.667.078-.31-.156-1.31-.476-2.493-1.543-.92-.81-1.54-1.812-1.72-2.115-.18-.31-.02-.477.136-.632.14-.138.31-.357.466-.537.156-.18.208-.31.31-.515.103-.206.05-.386-.025-.542-.075-.156-.69-1.637-.946-2.256-.25-.595-.503-.51-.69-.52-.18-.01-.385-.01-.59-.01-.205 0-.54.077-.822.385-.282.31-1.077 1.053-1.077 2.57 0 1.516 1.102 2.985 1.254 3.19.153.206 2.17 3.273 5.257 4.593.735.315 1.31.503 1.756.643.74.235 1.41.203 1.94.124.59-.088 1.834-.74 2.09-1.458.258-.717.258-1.33.18-1.458-.078-.125-.28-.205-.59-.36z"/></svg>
                                Konsultasi via WhatsApp
                            </a>
                        @endif
                        @if($mua->instagram_username)
                            <a href="{{ ig_link($mua->instagram_username) }}" 
                               target="_blank" 
                               class="w-full inline-flex items-center justify-center py-3 rounded-full bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold shadow-md shadow-slate-900/10 transition-all active:scale-95 active:translate-y-0.5">
                                Kunjungi Instagram
                            </a>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Right Side: Gallery & Packages (Occupies 8 columns) -->
            <div class="lg:col-span-8 space-y-8 text-left">
                
                <!-- Portfolio Section -->
                <div class="bg-white rounded-2xl border border-hairline p-8 shadow-sm space-y-6">
                    <h3 class="text-base font-display font-extrabold text-ink uppercase tracking-wider">Portofolio Riasan</h3>
                    
                    @if($mua->portfolios->isNotEmpty())
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($mua->portfolios as $portfolio)
                                <div class="aspect-square rounded-xl bg-slate-50 border border-hairline overflow-hidden relative group">
                                    <img src="{{ $portfolio->url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $portfolio->caption }}">
                                    <!-- Light overlay on hover -->
                                    <div class="absolute inset-0 bg-slate-950/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-3">
                                        <p class="text-[10px] text-white font-medium truncate w-full">{{ $portfolio->caption }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-muted">Belum ada portofolio riasan yang diunggah.</p>
                    @endif
                </div>

                <!-- Packages Section -->
                <div class="bg-white rounded-2xl border border-hairline p-8 shadow-sm space-y-6">
                    <h3 class="text-base font-display font-extrabold text-ink uppercase tracking-wider">Paket Layanan</h3>
                    
                    @if($mua->packages->isNotEmpty())
                        <div class="space-y-6 divide-y divide-hairline">
                            @foreach($mua->packages as $package)
                                <div class="pt-6 first:pt-0 space-y-4">
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                                        <div>
                                            <span class="text-[8px] font-bold uppercase tracking-widest text-primary">
                                                {{ $package->template && $package->template->eventType ? $package->template->eventType->name : 'Lainnya' }}
                                            </span>
                                            <h4 class="text-base font-display font-bold text-ink leading-tight">
                                                {{ $package->template ? $package->template->name : 'Custom Package' }}
                                            </h4>
                                        </div>
                                        <span class="text-base font-display font-extrabold text-primary bg-primary-soft px-3 py-1 rounded-lg">
                                            {{ $package->price_formatted }}
                                        </span>
                                    </div>
                                    
                                    <!-- Includes List -->
                                    @if(!empty($package->include_lines))
                                        <div class="space-y-2">
                                            <p class="text-[10px] font-mono uppercase tracking-widest text-[#6E7191]">Sudah Termasuk (Includes):</p>
                                            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                @foreach($package->include_lines as $line)
                                                    <li class="flex items-center gap-2 text-xs text-muted">
                                                        <svg class="w-4 h-4 text-accent flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                        <span>{{ $line }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <!-- Notes -->
                                    @if($package->notes)
                                        <div class="p-3.5 rounded-xl bg-slate-50 border border-hairline text-[11px] text-muted leading-relaxed">
                                            <span class="font-bold text-ink">Catatan tambahan:</span> {{ $package->notes }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-muted">Belum ada daftar paket layanan yang dikonfigurasi.</p>
                    @endif
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
