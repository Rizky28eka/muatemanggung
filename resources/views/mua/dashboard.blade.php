@extends('layouts.dashboard')

@section('title', 'Dashboard Mitra — MUA Temanggung')

@section('content')
<div class="space-y-8 text-left">
    
    <!-- MAIN GRID LAYOUT -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- LEFT PANEL (Occupies 9 columns, main dashboard elements) -->
        <div class="lg:col-span-9 space-y-8">
            
            <!-- Section 1: Highlights Row (resembles Today's Schedule) -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display font-bold text-slate-800 text-sm tracking-wide">Ringkasan Layanan Rias</h3>
                    <div class="flex items-center gap-1.5">
                        <span class="w-5 h-5 rounded-full bg-white border border-slate-200 flex items-center justify-center text-[10px] text-slate-400 cursor-pointer">‹</span>
                        <span class="w-5 h-5 rounded-full bg-white border border-slate-200 flex items-center justify-center text-[10px] text-slate-400 cursor-pointer">›</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Stat Card 1 -->
                    <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs flex flex-col justify-between h-40">
                        <div class="flex items-start justify-between">
                            <div class="space-y-1">
                                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Total Paket</span>
                                <h4 class="font-display font-black text-slate-800 text-lg leading-tight">Paket Layanan</h4>
                                <span class="block text-[10px] text-slate-400">Total terdaftar: <strong>{{ $stats['packages'] }}</strong></span>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-lg">💼</div>
                        </div>
                        <div class="space-y-1.5">
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-primary h-1.5 rounded-full" style="width: {{ $stats['packages'] > 0 ? '75%' : '0%' }}"></div>
                            </div>
                            <span class="block text-[9px] text-slate-400 font-medium">Batas pendaftaran: 14 paket</span>
                        </div>
                    </div>

                    <!-- Stat Card 2 -->
                    <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs flex flex-col justify-between h-40">
                        <div class="flex items-start justify-between">
                            <div class="space-y-1">
                                <span class="block text-[9px] font-bold text-emerald-500 uppercase tracking-wider">Tersedia</span>
                                <h4 class="font-display font-black text-slate-800 text-lg leading-tight">Paket Aktif</h4>
                                <span class="block text-[10px] text-slate-400">Siap dipesan Klien: <strong>{{ $stats['available_pkg'] }}</strong></span>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-lg">⚡</div>
                        </div>
                        <div class="space-y-1.5">
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-accent h-1.5 rounded-full" style="width: {{ $stats['packages'] > 0 ? (($stats['available_pkg'] / max($stats['packages'], 1)) * 100) . '%' : '0%' }}"></div>
                            </div>
                            <span class="block text-[9px] text-slate-400 font-medium">Rasio aktif: {{ $stats['packages'] > 0 ? round(($stats['available_pkg'] / $stats['packages']) * 100) : 0 }}% dari total</span>
                        </div>
                    </div>

                    <!-- Stat Card 3 -->
                    <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs flex flex-col justify-between h-40">
                        <div class="flex items-start justify-between">
                            <div class="space-y-1">
                                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Portofolio</span>
                                <h4 class="font-display font-black text-slate-800 text-lg leading-tight">Galeri Karya</h4>
                                <span class="block text-[10px] text-slate-400">Total karya terunggah: <strong>{{ $stats['portfolios'] }}</strong></span>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-lg">📸</div>
                        </div>
                        <div class="space-y-1.5">
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-rose-500 h-1.5 rounded-full" style="width: {{ $stats['portfolios'] > 0 ? '60%' : '0%' }}"></div>
                            </div>
                            <span class="block text-[9px] text-slate-400 font-medium">Batas wajar: 20 item</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Recent Works Gallery (resembles Recent Files) -->
            <div>
                <h3 class="font-display font-bold text-slate-800 text-sm tracking-wide mb-4">Galeri Portofolio Terbaru</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @forelse($mua->portfolios->take(2) as $port)
                        <div class="bg-white rounded-2xl border border-slate-200/50 p-4 shadow-xs flex items-center gap-4">
                            <img src="{{ $port->url }}" class="w-20 h-14 rounded-xl object-cover border border-slate-100" alt="Portfolio Preview">
                            <div class="min-w-0 text-left">
                                <h4 class="font-bold text-xs text-slate-800 truncate">{{ $port->caption ?? 'Karya Rias MUA' }}</h4>
                                <span class="block text-[9px] text-slate-400 mt-1 uppercase font-mono">{{ $port->file_type }} • {{ $port->created_at ? $port->created_at->diffForHumans() : 'Baru saja' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="md:col-span-2 bg-white rounded-2xl border border-slate-200/50 p-8 text-center text-xs text-slate-400">
                            Belum ada karya portofolio. Silakan unggah karya rias Anda.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Section 3: Registered Custom Packages (resembles My Courses) -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display font-bold text-slate-800 text-sm tracking-wide">Daftar Paket Jasa Terdaftar</h3>
                    <a href="{{ route('mua.packages.index') }}" class="text-xs font-bold text-primary hover:underline">Kelola Paket ➜</a>
                </div>

                @if($mua->packages->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @foreach($mua->packages->take(4) as $pkg)
                            <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs flex flex-col justify-between">
                                <div class="space-y-2">
                                    <div class="flex items-start justify-between">
                                        <span class="text-[8px] font-bold uppercase tracking-wider bg-primary-soft text-primary px-2 py-0.5 rounded">
                                            {{ $pkg->template->eventType->name }}
                                        </span>
                                        <span class="w-2 h-2 rounded-full {{ $pkg->is_available ? 'bg-emerald-400' : 'bg-slate-300' }}"></span>
                                    </div>
                                    <h4 class="font-display font-extrabold text-slate-800 text-sm mt-1 leading-tight">{{ $pkg->template->name }}</h4>
                                    <p class="text-[10px] text-slate-400 leading-relaxed max-w-[32ch] truncate">{{ $pkg->custom_description }}</p>
                                </div>
                                <div class="pt-4 border-t border-slate-50 mt-4 flex items-center justify-between">
                                    <span class="text-xs font-black text-slate-800">{{ $pkg->price_formatted }}</span>
                                    <a href="{{ route('mua.packages.index') }}" class="text-[10px] font-bold text-slate-400 hover:text-primary">Detail</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-2xl border border-slate-200/50 p-8 text-center text-xs text-slate-400 shadow-xs">
                        Anda belum mendaftarkan paket jasa rias.
                    </div>
                @endif
            </div>

        </div>

        <!-- RIGHT PANEL (Occupies 3 columns, resembles Recent Activity & Upcoming Tasks) -->
        <div class="lg:col-span-3 space-y-8">
            
            <!-- Account Status Card (StudyGo banner-like mockup card) -->
            <div class="bg-gradient-to-r from-primary to-accent rounded-3xl p-5 text-white relative overflow-hidden shadow-sm">
                <div class="absolute inset-0 bg-white/10 opacity-20 pointer-events-none"></div>
                <div class="relative z-10 space-y-3">
                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-white/20 text-[9px] font-bold uppercase tracking-wider">Kemitraan</span>
                    <h4 class="font-display font-black text-sm leading-tight text-left">Optimalkan Pencocokan Klien Anda</h4>
                    <p class="text-[10px] text-white/80 leading-relaxed text-left">
                        Sistem Cosine Similarity mencocokkan profil dan kriteria MUA Anda secara otomatis. Lengkapi kelayakan akun sekarang.
                    </p>
                </div>
            </div>

            <!-- Recent Activity Panel (resembles Recent Activity log) -->
            <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs text-left space-y-4">
                <h3 class="font-display font-bold text-slate-800 text-xs tracking-wide">Aktivitas Terakhir</h3>
                
                <div class="space-y-4 text-[11px] text-slate-500">
                    <div class="flex gap-3">
                        <span class="text-emerald-500 font-bold">✔</span>
                        <div>
                            <span class="font-bold text-slate-800 block">Profil Diperbarui</span>
                            <span class="text-[9px] text-slate-400 block mt-0.5">2 jam yang lalu</span>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="text-primary font-bold">✔</span>
                        <div>
                            <span class="font-bold text-slate-800 block">Paket Rias Disinkronkan</span>
                            <span class="text-[9px] text-slate-400 block mt-0.5">4 jam yang lalu</span>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="text-rose-500 font-bold">✔</span>
                        <div>
                            <span class="font-bold text-slate-800 block">Portofolio Baru Ditambahkan</span>
                            <span class="text-[9px] text-slate-400 block mt-0.5">Kemarin</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcomming Tasks / Audit Checklist (resembles Upcoming Assignments) -->
            <div class="bg-white rounded-2xl border border-slate-200/50 p-5 shadow-xs text-left space-y-4">
                <h3 class="font-display font-bold text-slate-800 text-xs tracking-wide">Kelayakan Profil MUA</h3>
                
                <div class="space-y-3">
                    <!-- Item 1 -->
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-between text-xs">
                        <div>
                            <span class="font-bold text-slate-800 block text-[11px]">Nomor WhatsApp Valid</span>
                            <span class="text-[9px] text-slate-400 block mt-0.5">Berawalan kode '628'</span>
                        </div>
                        <span class="text-emerald-500 font-bold text-sm">✔</span>
                    </div>

                    <!-- Item 2 -->
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-between text-xs">
                        <div>
                            <span class="font-bold text-slate-800 block text-[11px]">Radius Jangkauan Lokasi</span>
                            <span class="text-[9px] text-slate-400 block mt-0.5">Sudah disetting: {{ $mua->service_radius_km ?? '0' }} KM</span>
                        </div>
                        <span class="text-emerald-500 font-bold text-sm">✔</span>
                    </div>

                    <!-- Item 3 -->
                    <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-between text-xs">
                        <div>
                            <span class="font-bold text-slate-800 block text-[11px]">Vektor Similarity Aktif</span>
                            <span class="text-[9px] text-slate-400 block mt-0.5">Tersinkronisasi otomatis</span>
                        </div>
                        @if($stats['has_vector'])
                            <span class="text-emerald-500 font-bold text-sm">✔</span>
                        @else
                            <span class="text-rose-500 font-bold text-xs">Pending</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
