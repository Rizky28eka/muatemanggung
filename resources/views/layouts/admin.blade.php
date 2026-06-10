<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — MUA Temanggung</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 antialiased">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-gray-900 text-gray-100 flex-shrink-0 flex flex-col">
            <div class="px-6 py-5 border-b border-gray-700">
                <span class="text-lg font-bold text-amber-400">MUA Temanggung</span>
                <p class="text-xs text-gray-400 mt-0.5">Panel Admin</p>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-1 text-sm">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">
                    Dashboard
                </a>

                <p class="px-3 pt-3 pb-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelola MUA</p>
                <a href="{{ route('admin.mua.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.mua.*') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">
                    Data MUA
                </a>

                <p class="px-3 pt-3 pb-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">Master Data</p>
                <a href="{{ route('admin.master.districts.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.master.districts.*') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">
                    Kecamatan
                </a>
                <a href="{{ route('admin.master.event-types.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.master.event-types.*') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">
                    Jenis Acara & Paket
                </a>
                <a href="{{ route('admin.master.themes.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.master.themes.*') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">
                    Tema & Jenis Tema
                </a>
                <a href="{{ route('admin.master.makeup-looks.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.master.makeup-looks.*') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">
                    Look Makeup
                </a>

                <p class="px-3 pt-3 pb-1 text-xs font-semibold text-gray-500 uppercase tracking-wider">Monitoring</p>
                <a href="{{ route('admin.monitoring.searches') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.monitoring.*') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">
                    Log Pencarian
                </a>
            </nav>
            <div class="px-4 py-4 border-t border-gray-700">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 text-sm text-gray-400 hover:text-white rounded-lg hover:bg-gray-700">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">
            <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                <h1 class="text-lg font-semibold text-gray-700">@yield('page-title', 'Dashboard')</h1>
                <span class="text-sm text-gray-500">{{ auth()->user()->name }}</span>
            </header>
            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                        {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>

    </div>

</body>
</html>
