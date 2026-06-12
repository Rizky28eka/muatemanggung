@extends('layouts.dashboard')
@section('title', 'Paket Layanan')

@section('content')
<div x-data="{
    showModal: false,
    modalTitle: '',
    actionUrl: '',
    deleteUrl: '',
    isEdit: false,
    
    // Form fields
    packageTemplateId: '',
    price: '',
    customDescription: '',
    notes: '',
    isAvailable: true,
    
    // Helper to open edit modal
    openEdit(packageId, templateId, templateName, price, customDesc, notes, isAvailable) {
        this.isEdit = true;
        this.modalTitle = 'Edit Paket: ' + templateName;
        this.packageTemplateId = templateId;
        this.price = price;
        this.customDescription = customDesc;
        this.notes = notes;
        this.isAvailable = !!isAvailable;
        this.actionUrl = '{{ route('mua.packages.update', ':id') }}'.replace(':id', packageId);
        this.deleteUrl = '{{ route('mua.packages.destroy', ':id') }}'.replace(':id', packageId);
        this.showModal = true;
    },
    
    // Helper to open create modal
    openCreate(templateId, templateName) {
        this.isEdit = false;
        this.modalTitle = 'Atur Harga: ' + templateName;
        this.packageTemplateId = templateId;
        this.price = '';
        this.customDescription = '';
        this.notes = '';
        this.isAvailable = true;
        this.actionUrl = '{{ route('mua.packages.store') }}';
        this.deleteUrl = '';
        this.showModal = true;
    }
}" class="space-y-6">

    {{-- ── Page Header ── --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="font-display font-bold text-xl text-slate-900">Paket Layanan</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pilih template paket dari admin, lalu sesuaikan harga dan deskripsi sesuai layanan Anda.</p>
        </div>
    </div>

    {{-- ── Stats Cards ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white border border-slate-200/60 rounded-2xl p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                <i data-lucide="package" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Paket Aktif Anda</span>
                <span class="text-lg font-black text-slate-800">
                    {{ $packages->where('is_available', true)->count() }} 
                    <span class="text-xs font-semibold text-slate-400">dari {{ $templates->count() }} template</span>
                </span>
            </div>
        </div>
        
        <div class="bg-white border border-slate-200/60 rounded-2xl p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                <i data-lucide="eye-off" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Paket Disembunyikan</span>
                <span class="text-lg font-black text-slate-800">
                    {{ $packages->where('is_available', false)->count() }}
                </span>
            </div>
        </div>
        
        <div class="bg-white border border-slate-200/60 rounded-2xl p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <i data-lucide="sparkles" class="w-5 h-5"></i>
            </div>
            <div>
                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400">Harga Termurah</span>
                <span class="text-lg font-black text-slate-800">
                    {{ $packages->isNotEmpty() ? 'Rp ' . number_format($packages->min('price'), 0, ',', '.') : '—' }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold px-4 py-3 rounded-xl shadow-xs">
            <i data-lucide="check-circle-2" class="w-4 h-4 flex-shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="flex items-start gap-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold px-4 py-3 rounded-xl shadow-xs">
            <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0 mt-0.5"></i>
            <ul class="space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($templates->isEmpty())
        <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-8 text-center text-xs text-slate-400">
            Belum ada template paket dari admin. Hubungi admin untuk menambahkan template paket.
        </div>
    @endif

    {{-- ── Templates Grouped by Event Type ── --}}
    @foreach($templates->groupBy('event_type_id') as $group)
        @php $eventType = $group->first()->eventType; @endphp
        <div class="space-y-4">
            <div class="flex items-center gap-3 border-b border-slate-100 pb-2">
                <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                    <i data-lucide="party-popper" class="w-4 h-4"></i>
                </div>
                <div>
                    <h3 class="font-display font-extrabold text-slate-800 text-sm tracking-wide">
                        Layanan {{ $eventType?->name ?? 'Umum' }}
                    </h3>
                    <p class="text-[10px] text-slate-400">Atur harga paket penawaran khusus Anda untuk kategori {{ strtolower($eventType?->name ?? 'umum') }}.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($group as $template)
                    @php $package = $packages->firstWhere('package_template_id', $template->id); @endphp
                    
                    <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs p-5 flex flex-col justify-between hover:shadow-md hover:border-slate-300/80 transition duration-200">
                        <div class="space-y-3.5">
                            
                            {{-- Card Header --}}
                            <div class="flex items-start justify-between gap-2.5">
                                <div class="min-w-0">
                                    <h4 class="font-display font-extrabold text-slate-800 text-xs sm:text-sm leading-tight">{{ $template->name }}</h4>
                                    @if($template->description)
                                        <p class="text-[10px] text-slate-400 mt-1 leading-snug">{{ $template->description }}</p>
                                    @endif
                                </div>
                                
                                @if($package)
                                    @if($package->is_available)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[9px] font-bold flex-shrink-0">
                                            <span class="w-1 h-1 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 text-[9px] font-bold flex-shrink-0">
                                            <span class="w-1 h-1 rounded-full bg-slate-400"></span> Nonaktif
                                        </span>
                                    @endif
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-400 text-[9px] font-semibold flex-shrink-0">Belum Ditambahkan</span>
                                @endif
                            </div>

                            {{-- Includes checklist --}}
                            @if($template->includes->isNotEmpty())
                                <div class="bg-slate-50/50 border border-slate-100/80 rounded-xl p-3 space-y-1.5">
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none">Termasuk:</p>
                                    <div class="flex flex-wrap gap-x-3 gap-y-1.5">
                                        @foreach($template->includes as $include)
                                            <div class="text-[10px] text-slate-500 flex items-center gap-1">
                                                <i data-lucide="check" class="w-3 h-3 text-emerald-500 flex-shrink-0"></i>
                                                <span>{{ $include->include_item }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            {{-- Package Details --}}
                            @if($package)
                                <div class="pt-2.5 border-t border-slate-100 flex items-baseline justify-between">
                                    <span class="text-[10px] text-slate-400 font-medium">Tarif Layanan</span>
                                    <span class="text-sm font-bold text-primary">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                                </div>
                                
                                @if($package->custom_description)
                                    <p class="text-[10px] text-slate-500 bg-slate-50 border border-slate-100 rounded-lg p-2.5 leading-relaxed">
                                        <span class="font-bold text-slate-700 block text-[9px] uppercase tracking-wider mb-0.5">Keterangan:</span>
                                        {{ $package->custom_description }}
                                    </p>
                                @endif
                                
                                @if($package->notes)
                                    <p class="text-[9px] text-slate-400 italic">
                                        * Catatan: {{ $package->notes }}
                                    </p>
                                @endif
                            @else
                                <div class="pt-2.5 border-t border-slate-100 flex items-baseline justify-between text-slate-300">
                                    <span class="text-[10px] font-medium">Tarif Layanan</span>
                                    <span class="text-xs font-semibold italic">Belum diatur</span>
                                </div>
                            @endif
                        </div>

                        {{-- Action Button --}}
                        <div class="mt-4 pt-2.5 border-t border-slate-50">
                            @if($package)
                                <button type="button"
                                        @click="openEdit({{ $package->id }}, {{ $template->id }}, '{{ addslashes($template->name) }}', '{{ $package->price }}', '{{ addslashes($package->custom_description ?? '') }}', '{{ addslashes($package->notes ?? '') }}', {{ $package->is_available ? 'true' : 'false' }})"
                                        class="w-full flex items-center justify-center gap-1.5 px-4 py-2 bg-slate-50 border border-slate-200 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-100 hover:border-slate-300 active:scale-98 transition">
                                    <i data-lucide="settings" class="w-3.5 h-3.5 text-slate-400"></i>
                                    Atur Ulang Paket
                                </button>
                            @else
                                <button type="button"
                                        @click="openCreate({{ $template->id }}, '{{ addslashes($template->name) }}')"
                                        class="w-full flex items-center justify-center gap-1.5 px-4 py-2 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary/90 active:scale-98 transition-all shadow-xs">
                                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                                    Aktifkan Paket
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    {{-- ══════════════════════════════════════════════
         ALPINE MODAL FOR CONFIGURE PACKAGE
    ══════════════════════════════════════════════ --}}
    <div x-show="showModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs"
         x-cloak>
         
        <div x-show="showModal"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             @click.outside="showModal = false"
             class="bg-white rounded-2xl max-w-md w-full border border-slate-200/60 shadow-2xl overflow-hidden flex flex-col">
             
            {{-- Modal Header --}}
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="font-display font-bold text-sm text-slate-800" x-text="modalTitle">Atur Paket</h3>
                <button type="button" @click="showModal = false" class="w-8 h-8 rounded-lg hover:bg-slate-200/50 flex items-center justify-center text-slate-400 hover:text-slate-600 transition">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            
            {{-- Modal Form --}}
            <form :action="actionUrl" method="POST" class="p-5 space-y-4">
                @csrf
                {{-- Method override if editing --}}
                <input type="hidden" name="_method" value="PUT" :disabled="!isEdit">
                {{-- Template ID if creating --}}
                <input type="hidden" name="package_template_id" :value="packageTemplateId" :disabled="isEdit">
                
                {{-- Price Input --}}
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Harga Paket (Rp) <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">Rp</span>
                        <input type="number" name="price" min="0" required placeholder="mis. 1500000" x-model="price"
                               class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition font-mono">
                    </div>
                </div>
                
                {{-- Description Input --}}
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Keterangan Khusus</label>
                    <textarea name="custom_description" rows="3" placeholder="Tambahkan rincian paket, busana, retouch, atau item lainnya (opsional)" x-model="customDescription"
                              class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition resize-none"></textarea>
                </div>
                
                {{-- Notes Input --}}
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider">Catatan Tambahan</label>
                    <textarea name="notes" rows="2" placeholder="Catatan internal atau ketentuan tambahan (opsional)" x-model="notes"
                              class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition resize-none"></textarea>
                </div>
                
                {{-- Toggle Availability --}}
                <label class="flex items-center justify-between gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer">
                    <div class="text-left">
                        <span class="block text-[11px] font-bold text-slate-700">Tampilkan Paket</span>
                        <span class="block text-[9px] text-slate-400">Tampilkan paket ini agar dapat dicari oleh klien</span>
                    </div>
                    <input type="checkbox" name="is_available" value="1" :checked="isAvailable"
                           class="w-4.5 h-4.5 rounded border-slate-300 text-primary focus:ring-primary/30">
                </label>
                
                {{-- Action Buttons --}}
                <div class="flex items-center gap-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="showModal = false"
                            class="px-4 py-2.5 border border-slate-200 text-slate-500 text-xs font-bold rounded-xl hover:bg-slate-50 active:scale-95 transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary/90 active:scale-95 transition shadow-sm">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan Layanan
                    </button>
                </div>
            </form>
            
            {{-- Hapus Button (Only when editing) --}}
            <div x-show="isEdit && deleteUrl" class="px-5 pb-4">
                <form :action="deleteUrl" method="POST"
                      onsubmit="return confirm('Hapus paket ini dari daftar layanan Anda?')">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white text-xs font-bold rounded-xl active:scale-95 transition">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                        Hapus Paket dari Layanan
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
