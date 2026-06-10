<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MUA Temanggung') — Rekomendasi Make Up Artist</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <nav class="bg-white shadow-sm border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold text-amber-600">
                MUA Temanggung
            </a>
            <a href="{{ route('recommendation.form') }}"
               class="bg-amber-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-amber-700 transition">
                Cari Rekomendasi
            </a>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-100 mt-16">
        <div class="max-w-6xl mx-auto px-4 py-6 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} MUA Temanggung — Sistem Rekomendasi Make Up Artist Kabupaten Temanggung
        </div>
    </footer>

</body>
</html>
