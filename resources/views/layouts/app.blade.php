<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EMS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Modern layout styling -->
    <style>
        :root {
            --brand-primary: #4f46e5;
            --brand-secondary: #22d3ee;
            --bg-base: #0f172a;
        }
        body {
            background: radial-gradient(circle at 20% 20%, rgba(79, 70, 229, 0.12), transparent 35%),
                        radial-gradient(circle at 80% 0%, rgba(34, 211, 238, 0.14), transparent 32%),
                        radial-gradient(circle at 50% 80%, rgba(79, 70, 229, 0.10), transparent 35%),
                        var(--bg-base);
            color: #e2e8f0;
            min-height: 100vh;
            font-family: {{ app()->getLocale() === 'ar' ? "'Tajawal', sans-serif" : "'Figtree', sans-serif" }};
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(12px);
        }
        .pill-btn {
            border-radius: 999px;
            transition: all 150ms ease;
        }
        .pill-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.18);
        }
    </style>

    {{-- Toast Notifications --}}
    <div
        x-data="{ show: false, message: '', type: 'success' }"
        x-show="show"
        x-transition
        x-init="
            @if(session('success'))
                message = '{{ session('success') }}';
                type = 'success';
                show = true;
                setTimeout(() => show = false, 3000);
            @elseif($errors->any())
                message = '{{ $errors->first() }}';
                type = 'error';
                show = true;
                setTimeout(() => show = false, 4000);
            @endif
        "
        class="fixed top-6 right-6 z-50"
    >
        <div
            :class="type === 'success'
                ? 'bg-emerald-500'
                : 'bg-rose-500'"
            class="text-white px-5 py-3 rounded-xl shadow-xl glass-panel"
        >
            <span x-text="message"></span>
        </div>
    </div>
</head>

<body class="antialiased">
    <div class="min-h-screen relative overflow-hidden">

        <!-- Decorative orbs -->
        <span class="pointer-events-none absolute -top-20 -left-20 h-64 w-64 rounded-full bg-indigo-500 blur-3xl opacity-20"></span>
        <span class="pointer-events-none absolute top-40 -right-10 h-56 w-56 rounded-full bg-cyan-400 blur-3xl opacity-20"></span>

        <!-- Navigation -->
        <nav class="sticky top-0 z-40 border-b border-white/10 glass-panel">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">

                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-2xl bg-gradient-to-br from-indigo-500 to-cyan-400 flex items-center justify-center text-white font-bold shadow-lg">
                        {{ strtoupper(substr(config('app.name', 'EMS'), 0, 2)) }}
                    </div>
                    <div>
                        <div class="text-lg font-semibold text-white">{{ config('app.name', 'EMS') }}</div>
                        <p class="text-xs text-slate-300">Smart equipment lifecycle</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 text-sm">
                    <div class="flex items-center gap-2 bg-white/5 border border-white/10 rounded-full px-2 py-1">
                        <a href="/lang/en" class="px-3 py-1 pill-btn {{ app()->getLocale() === 'en' ? 'bg-white text-slate-900' : 'text-slate-100 hover:bg-white/10' }}">EN</a>
                        <a href="/lang/ar" class="px-3 py-1 pill-btn {{ app()->getLocale() === 'ar' ? 'bg-white text-slate-900' : 'text-slate-100 hover:bg-white/10' }}">AR</a>
                    </div>

                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="pill-btn px-4 py-2 bg-white/10 text-slate-100 border border-white/20 hover:bg-white/20">
                                {{ __('app.logout') }}
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @isset($header)
            <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="glass-panel rounded-3xl px-6 py-4 flex items-center justify-between">
                    <div class="text-xl font-semibold text-white">{{ $header }}</div>
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="glass-panel rounded-3xl p-6">
                {{ $slot }}
            </div>
        </main>

    </div>

</body>
</html>
