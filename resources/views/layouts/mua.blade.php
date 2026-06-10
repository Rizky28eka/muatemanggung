<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel MUA') — MUA Temanggung</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 antialiased">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r border-gray-200 flex-shrink-0 flex flex-col">
            <div class="px-6 py-5 border-b border-gray-100">
                <span class="text-base font-bold text-amber-600">MUA Temanggung</span>
                <p class="text-xs text-gray-500 mt-0.5">Panel Pengelola MUA</p>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-1 text-sm">
                <a href="{{ route('mua.dashboard') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700 {{ request()->routeIs('mua.dashboard') ? 'bg-amber-50 text-amber-700 font-medium' : 'text-gray-600' }}">
                    Dashboard
                </a>
                <a href="{{ route('mua.profile.edit') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700 {{ request()->routeIs('mua.profile.*') ? 'bg-amber-50 text-amber-700 font-medium' : 'text-gray-600' }}">
                    Profil Usaha
                </a>
                <a href="{{ route('mua.packages.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700 {{ request()->routeIs('mua.packages.*') ? 'bg-amber-50 text-amber-700 font-medium' : 'text-gray-600' }}">
                    Paket Layanan
                </a>
                <a href="{{ route('mua.portfolio.index') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700 {{ request()->routeIs('mua.portfolio.*') ? 'bg-amber-50 text-amber-700 font-medium' : 'text-gray-600' }}">
                    Portofolio
                </a>
                <a href="{{ route('mua.location.edit') }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-amber-50 hover:text-amber-700 {{ request()->routeIs('mua.location.*') ? 'bg-amber-50 text-amber-700 font-medium' : 'text-gray-600' }}">
                    Lokasi & Layanan
                </a>
            </nav>
            <div class="px-4 py-4 border-t border-gray-100">
                <div class="px-3 pb-2">
                    <p class="text-xs font-medium text-gray-700 truncate">{{ auth()->user()->mua->name ?? auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('mua.logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 text-sm text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <h1 class="text-lg font-semibold text-gray-700">@yield('page-title', 'Dashboard')</h1>
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
