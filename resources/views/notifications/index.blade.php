@extends('layouts.dashboard')
@section('title', 'Notifikasi')

@section('content')
@php
    $notifColorClasses = [
        'amber'   => 'bg-amber-50 text-amber-500',
        'emerald' => 'bg-emerald-50 text-emerald-500',
        'rose'    => 'bg-rose-50 text-rose-500',
        'sky'     => 'bg-sky-50 text-sky-500',
        'primary' => 'bg-primary/10 text-primary',
        'slate'   => 'bg-slate-50 text-slate-500',
    ];
@endphp
<div class="space-y-5">

    {{-- ── Page Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="font-display font-bold text-xl text-slate-900">Notifikasi</h1>
            <p class="text-xs text-slate-500 mt-0.5">Riwayat pemberitahuan terkait akun dan aktivitas Anda.</p>
        </div>

        @if($notifications->where('read_at', null)->isNotEmpty())
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit"
                        class="flex items-center gap-1.5 px-3 py-2 bg-white border border-slate-200 text-slate-600 hover:text-primary hover:border-primary/30 text-xs font-bold rounded-xl transition-colors">
                    <i data-lucide="check-check" class="w-3.5 h-3.5"></i>
                    Tandai Semua Dibaca
                </button>
            </form>
        @endif
    </div>

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold px-4 py-3 rounded-xl">
            <i data-lucide="check-circle-2" class="w-4 h-4 flex-shrink-0"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Notification List ── --}}
    <div class="bg-white border border-slate-200/60 rounded-2xl shadow-xs overflow-hidden">
        @if($notifications->isEmpty())
            <div class="py-16 text-center">
                <i data-lucide="bell-off" class="w-10 h-10 text-slate-200 mx-auto mb-3"></i>
                <p class="text-sm font-semibold text-slate-400">Belum ada notifikasi</p>
                <p class="text-xs text-slate-300 mt-1">Pemberitahuan baru akan muncul di sini.</p>
            </div>
        @else
            <div class="divide-y divide-slate-50">
                @foreach($notifications as $notification)
                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-start gap-3 px-5 py-4 hover:bg-slate-50/60 transition-colors {{ $notification->read_at ? '' : 'bg-primary/[0.03]' }}">
                            <div class="w-10 h-10 rounded-xl {{ $notifColorClasses[$notification->data['color'] ?? 'slate'] ?? $notifColorClasses['slate'] }} flex items-center justify-center flex-shrink-0">
                                <i data-lucide="{{ $notification->data['icon'] ?? 'bell' }}" class="w-4.5 h-4.5"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="block text-xs font-bold text-slate-800 leading-tight">{{ $notification->data['title'] ?? 'Notifikasi' }}</span>
                                <span class="block text-[11px] text-slate-500 mt-1 leading-snug">{{ $notification->data['message'] ?? '' }}</span>
                                <span class="block text-[10px] text-slate-300 mt-1.5">{{ $notification->created_at->diffForHumans() }} &middot; {{ $notification->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            @if(is_null($notification->read_at))
                                <span class="w-2 h-2 rounded-full bg-primary flex-shrink-0 mt-1.5" title="Belum dibaca"></span>
                            @endif
                        </button>
                    </form>
                @endforeach
            </div>

            @if($notifications->hasPages())
                <div class="px-5 py-4 border-t border-slate-100">
                    {{ $notifications->links() }}
                </div>
            @endif
        @endif
    </div>

</div>
@endsection
