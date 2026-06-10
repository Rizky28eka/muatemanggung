<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — MUA Temanggung</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 min-h-screen flex items-center justify-center px-4">

<div class="w-full max-w-sm">
    {{-- Logo --}}
    <div class="text-center mb-8">
        <div class="inline-flex w-14 h-14 rounded-full bg-primary items-center justify-center mb-4">
            <span class="text-white font-bold text-lg">MUA</span>
        </div>
        <h1 class="text-xl font-bold text-white">Admin Panel</h1>
        <p class="text-sm text-gray-400 mt-1">MUA Temanggung</p>
    </div>

    {{-- Card --}}
    <div class="bg-gray-900 rounded-2xl p-8 border border-gray-800">

        @if(session('error'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/admin/login" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-2.5 rounded-xl bg-gray-800 border text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition
                       {{ $errors->has('email') ? 'border-red-500' : 'border-gray-700' }}"
                       placeholder="admin@muatemanggung.com">
                @error('email')
                    <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-2.5 rounded-xl bg-gray-800 border border-gray-700 text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition"
                       placeholder="••••••••">
            </div>

            <button type="submit"
                    class="w-full bg-primary hover:bg-primary-active text-white font-bold py-3 rounded-xl text-sm transition-colors">
                Masuk sebagai Admin
            </button>
        </form>
    </div>

    <p class="text-center text-xs text-gray-600 mt-6">
        <a href="/" class="hover:text-gray-400 transition-colors">← Kembali ke halaman utama</a>
    </p>
</div>

</body>
</html>
