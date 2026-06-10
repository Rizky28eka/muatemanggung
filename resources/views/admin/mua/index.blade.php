@extends('layouts.admin')
@section('title', 'Data MUA')
@section('page-title', 'Data MUA')

@section('content')
{{-- Toolbar --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <form method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama MUA..."
               class="px-4 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-violet-300 w-56">
        <select name="status" class="px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none">
            <option value="">Semua Status</option>
            <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Non-aktif</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm transition-colors">Filter</button>
    </form>
    <a href="{{ route('admin.mua.create') }}"
       class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-lg text-sm font-medium transition-colors no-underline">
        + Tambah MUA
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">MUA</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Kecamatan</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Email</th>
                <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($muas as $mua)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-violet-100 flex items-center justify-center text-violet-600 font-bold text-sm shrink-0">
                            {{ strtoupper(substr($mua->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-medium text-gray-700">{{ $mua->name }}</div>
                            @if($mua->is_home_service)
                                <span class="text-[11px] text-emerald-600 font-medium">Home Service</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4 text-gray-500 hidden md:table-cell">{{ $mua->district?->name ?? '—' }}</td>
                <td class="px-5 py-4 text-gray-500 hidden lg:table-cell">{{ $mua->user?->email ?? '—' }}</td>
                <td class="px-5 py-4 text-center">
                    <form method="POST" action="{{ route('admin.mua.toggle', $mua) }}" class="inline">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="px-2.5 py-1 rounded-full text-[11px] font-bold transition-colors
                                {{ $mua->is_active ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'bg-red-100 text-red-600 hover:bg-red-200' }}">
                            {{ $mua->is_active ? 'Aktif' : 'Non-aktif' }}
                        </button>
                    </form>
                </td>
                <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.mua.edit', $mua) }}"
                           class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 rounded-lg text-xs font-medium text-gray-600 transition-colors no-underline">Edit</a>
                        <form method="POST" action="{{ route('admin.mua.destroy', $mua) }}"
                              onsubmit="return confirm('Hapus MUA {{ $mua->name }}? Ini tidak dapat dibatalkan.')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1.5 bg-red-50 hover:bg-red-100 rounded-lg text-xs font-medium text-red-600 transition-colors">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-12 text-center text-gray-400 text-sm">
                    Belum ada data MUA.
                    <a href="{{ route('admin.mua.create') }}" class="text-violet-600 hover:underline ml-1">Tambah sekarang</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($muas->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">{{ $muas->links() }}</div>
    @endif
</div>
@endsection
