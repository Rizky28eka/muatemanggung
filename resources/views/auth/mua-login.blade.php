<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login MUA — MUA Temanggung</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-primary-soft min-h-screen flex items-center justify-center px-4">

<div class="w-full max-w-sm">
    {{-- Logo --}}
    <div class="text-center mb-8">
        <a href="/" class="inline-flex items-center gap-2.5 justify-center mb-2 no-underline">
            <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center">
                <span class="text-white font-bold text-sm">MUA</span>
            </div>
            <span class="text-xl font-bold text-ink">Temanggung</span>
        </a>
        <p class="text-sm text-muted mt-2">Panel Pengelola MUA</p>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-2xl p-8 shadow-sm border border-primary-border">

        @if(session('error'))
            <div class="mb-4 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <h2 class="text-lg font-bold text-ink mb-6">Masuk ke Akun MUA</h2>

        <form method="POST" action="/mua/login" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-ink mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-2.5 rounded-xl border text-sm text-ink placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition
                       {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-primary-border bg-primary-soft' }}"
                       placeholder="email@example.com">
                @error('email')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-1.5">Password</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-2.5 rounded-xl border border-primary-border bg-primary-soft text-sm text-ink placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition"
                       placeholder="••••••••">
            </div>

            <button type="submit"
                    class="w-full bg-primary hover:bg-primary-active text-white font-bold py-3 rounded-xl text-sm transition-colors">
                Masuk
            </button>
        </form>
    </div>

    <p class="text-center text-xs text-muted mt-6">
        <a href="/" class="hover:text-primary transition-colors">← Kembali ke halaman utama</a>
    </p>
</div>

</body>
</html>
