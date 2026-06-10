@extends('layouts.dashboard')
@section('title', 'Manajemen Mitra MUA')

@section('content')
<div class="space-y-5">

    {{-- ── Page Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="font-display font-bold text-xl text-slate-900">Manajemen Mitra MUA</h1>
            <p class="text-xs text-slate-500 mt-0.5">Tinjau pendaftaran baru dan kelola mitra aktif.</p>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.mua.index') }}" class="flex items-center gap-2">
            <div class="relative">
                <i data-lucide="search" class="absolute left-3 top-2.5 w-3.5 h-3.5 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama / email..."
                       class="w-48 pl-8 pr-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
            </div>
            <button type="submit"
                    class="px-3 py-2 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary/90 active:scale-95 transition">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.mua.index') }}"
                   class="w-8 h-8 flex items-center justify-center bg-slate-100 rounded-xl hover:bg-slate-200 transition text-slate-500">
                    <i data-lucide="x" class="w-3.5 h-3.5"></i>
                </a>
            @endif
        </form>
    </div>

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold px-4 py-3 rounded-xl">
            <i data-lucide="check-circle-2" class="w-4 h-4 flex-shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold px-4 py-3 rounded-xl">
            <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- ══════════════════════════════════════════
         TAB CONTAINER
    ══════════════════════════════════════════ --}}
    <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs overflow-hidden">

        {{-- ── Tab Bar ── --}}
        <div class="flex border-b border-slate-100 px-1 pt-1 gap-1 bg-slate-50/60">

            {{-- Tab: Pending --}}
            <button id="tab-pending" onclick="switchTab('pending')"
                    class="tab-btn relative flex items-center gap-2 px-4 py-3 text-xs font-bold rounded-t-xl transition-all
                           text-amber-600 bg-white border border-b-0 border-slate-200"
                    data-active="true">
                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                Menunggu Persetujuan
                @if($pending->count() > 0)
                    <span id="badge-pending"
                          class="px-1.5 py-0.5 rounded-full bg-amber-500 text-white text-[9px] font-black leading-none">
                        {{ $pending->count() }}
                    </span>
                @endif
            </button>

            {{-- Tab: Aktif --}}
            <button id="tab-approved" onclick="switchTab('approved')"
                    class="tab-btn flex items-center gap-2 px-4 py-3 text-xs font-bold rounded-t-xl transition-all
                           text-slate-500 hover:text-slate-700 hover:bg-white/60">
                <i data-lucide="users" class="w-3.5 h-3.5"></i>
                Mitra Aktif
                <span class="px-1.5 py-0.5 rounded-full bg-slate-200 text-slate-600 text-[9px] font-black leading-none">
                    {{ $approved->total() }}
                </span>
            </button>
        </div>

        {{-- ══════════════════════════════════════════
             PANEL: PENDING
        ══════════════════════════════════════════ --}}
        <div id="panel-pending">
            @if($pending->isEmpty())
                <div class="py-16 text-center">
                    <i data-lucide="check-circle-2" class="w-10 h-10 text-emerald-200 mx-auto mb-3"></i>
                    <p class="text-sm font-semibold text-slate-400">Tidak ada pendaftaran yang menunggu</p>
                    <p class="text-xs text-slate-300 mt-1">Semua pendaftaran sudah diproses.</p>
                </div>
            @else
                <div class="divide-y divide-slate-50">
                    @foreach($pending as $mua)
                        <div class="px-5 py-4 flex flex-col sm:flex-row sm:items-center gap-4
                                    hover:bg-amber-50/30 transition-colors">

                            {{-- Avatar + Info --}}
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <div class="w-10 h-10 rounded-2xl bg-amber-100 flex items-center justify-center
                                            text-amber-700 font-display font-black text-sm flex-shrink-0">
                                    {{ strtoupper(substr($mua->name, 0, 2)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-900 leading-tight">{{ $mua->name }}</p>
                                    <p class="text-[10px] text-slate-500">{{ $mua->user?->email ?? '—' }}</p>
                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-0.5 mt-1">
                                        @if($mua->district)
                                            <span class="inline-flex items-center gap-1 text-[9px] text-slate-400">
                                                <i data-lucide="map-pin" class="w-2.5 h-2.5"></i>
                                                {{ $mua->district->name }}
                                            </span>
                                        @endif
                                        @if($mua->whatsapp_number)
                                            <span class="inline-flex items-center gap-1 text-[9px] text-slate-400">
                                                <i data-lucide="phone" class="w-2.5 h-2.5"></i>
                                                {{ $mua->whatsapp_number }}
                                            </span>
                                        @endif
                                        @if($mua->instagram_username)
                                            <span class="inline-flex items-center gap-1 text-[9px] text-slate-400">
                                                <i data-lucide="at-sign" class="w-2.5 h-2.5"></i>
                                                {{ $mua->instagram_username }}
                                            </span>
                                        @endif
                                        <span class="inline-flex items-center gap-1 text-[9px] text-slate-300">
                                            <i data-lucide="clock" class="w-2.5 h-2.5"></i>
                                            {{ $mua->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-2 flex-shrink-0 sm:ml-auto">
                                <a href="{{ route('admin.mua.show', $mua) }}"
                                   title="Lihat Detail"
                                   class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center
                                          justify-center text-slate-500 transition-colors">
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                </a>

                                <form action="{{ route('admin.mua.approve', $mua) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-500
                                                   hover:bg-emerald-600 text-white text-[10px] font-bold rounded-xl
                                                   transition-colors active:scale-95">
                                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                        Setujui
                                    </button>
                                </form>

                                <form action="{{ route('admin.mua.reject', $mua) }}" method="POST"
                                      onsubmit="return confirm('Tolak dan hapus pendaftaran MUA {{ addslashes($mua->name) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white
                                                   hover:bg-rose-50 text-rose-500 text-[10px] font-bold rounded-xl
                                                   border border-rose-200 transition-colors active:scale-95">
                                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                                        Tolak
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ══════════════════════════════════════════
             PANEL: APPROVED / ACTIVE
        ══════════════════════════════════════════ --}}
        <div id="panel-approved" class="hidden">
            @if($approved->isEmpty())
                <div class="py-16 text-center">
                    <i data-lucide="users" class="w-10 h-10 text-slate-200 mx-auto mb-3"></i>
                    <p class="text-sm font-semibold text-slate-400">Belum ada mitra aktif</p>
                    <p class="text-xs text-slate-300 mt-1">Setujui pendaftaran MUA di tab Menunggu.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-[9px] font-bold uppercase tracking-widest
                                      text-slate-400 border-b border-slate-100">
                            <tr>
                                <th class="px-5 py-3.5">#</th>
                                <th class="px-5 py-3.5">Nama MUA</th>
                                <th class="px-5 py-3.5">Email</th>
                                <th class="px-5 py-3.5">Kecamatan</th>
                                <th class="px-5 py-3.5">Home Service</th>
                                <th class="px-5 py-3.5">Bergabung</th>
                                <th class="px-5 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($approved as $mua)
                                <tr class="hover:bg-slate-50/60 transition-colors">

                                    <td class="px-5 py-4 text-[11px] text-slate-400 font-mono">
                                        {{ $approved->firstItem() + $loop->index }}
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl bg-primary/10 flex items-center
                                                        justify-center text-primary text-xs font-bold flex-shrink-0">
                                                {{ strtoupper(substr($mua->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <span class="font-semibold text-slate-800 block leading-tight">
                                                    {{ $mua->name }}
                                                </span>
                                                @if($mua->instagram_username)
                                                    <span class="text-[10px] text-slate-400">@{{ $mua->instagram_username }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4 text-[11px] text-slate-500">
                                        {{ $mua->user?->email ?? '—' }}
                                    </td>

                                    <td class="px-5 py-4 text-[11px] text-slate-600">
                                        {{ $mua->district?->name ?? '—' }}
                                    </td>

                                    <td class="px-5 py-4">
                                        @if($mua->is_home_service)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full
                                                         bg-sky-50 text-sky-600 text-[10px] font-semibold">
                                                <i data-lucide="check" class="w-3 h-3"></i> Ya
                                            </span>
                                        @else
                                            <span class="text-slate-300 text-[10px]">Tidak</span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 text-[10px] text-slate-400">
                                        {{ $mua->created_at->format('d M Y') }}
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('admin.mua.show', $mua) }}"
                                               title="Lihat Detail"
                                               class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-primary hover:text-white
                                                      text-slate-500 flex items-center justify-center transition-colors">
                                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                            </a>

                                            <a href="{{ route('admin.mua.edit', $mua) }}"
                                               title="Edit"
                                               class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-amber-500 hover:text-white
                                                      text-slate-500 flex items-center justify-center transition-colors">
                                                <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                            </a>

                                            <form action="{{ route('admin.mua.toggle', $mua) }}" method="POST">
                                                @csrf
                                                <button type="submit" title="Nonaktifkan"
                                                        class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-rose-100
                                                               hover:text-rose-600 text-slate-500 flex items-center
                                                               justify-center transition-colors">
                                                    <i data-lucide="toggle-right" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.mua.destroy', $mua) }}" method="POST"
                                                  onsubmit="return confirm('Hapus MUA {{ addslashes($mua->name) }} secara permanen?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" title="Hapus"
                                                        class="w-7 h-7 rounded-lg bg-slate-100 hover:bg-rose-500
                                                               hover:text-white text-slate-500 flex items-center
                                                               justify-center transition-colors">
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($approved->hasPages())
                    <div class="px-5 py-4 border-t border-slate-100">
                        {{ $approved->links() }}
                    </div>
                @endif
            @endif
        </div>

    </div>{{-- /tab container --}}
</div>

<script>
    function switchTab(tab) {
        const tabs    = ['pending', 'approved'];
        const pending = {{ $pending->count() }};

        tabs.forEach(t => {
            const btn   = document.getElementById('tab-' + t);
            const panel = document.getElementById('panel-' + t);

            if (t === tab) {
                // Active tab style
                btn.classList.add('bg-white', 'border', 'border-b-0', 'border-slate-200');
                btn.classList.remove('hover:bg-white/60', 'text-slate-500', 'hover:text-slate-700');

                if (t === 'pending') {
                    btn.classList.add('text-amber-600');
                    btn.classList.remove('text-primary');
                } else {
                    btn.classList.add('text-primary');
                    btn.classList.remove('text-amber-600');
                }

                panel.classList.remove('hidden');
            } else {
                // Inactive tab style
                btn.classList.remove('bg-white', 'border', 'border-b-0', 'border-slate-200', 'text-amber-600', 'text-primary');
                btn.classList.add('text-slate-500', 'hover:text-slate-700', 'hover:bg-white/60');
                panel.classList.add('hidden');
            }
        });

        // Persist active tab in URL hash
        history.replaceState(null, '', '#' + tab);
    }

    // On load: restore tab from hash or default to pending if there are pending items
    document.addEventListener('DOMContentLoaded', () => {
        const hash    = location.hash.replace('#', '');
        const pending = {{ $pending->count() }};

        if (hash === 'approved') {
            switchTab('approved');
        } else if (hash === 'pending' || pending > 0) {
            switchTab('pending');
        } else {
            switchTab('approved');
        }
    });
</script>
@endsection
