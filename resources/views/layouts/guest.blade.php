<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EEMS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

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
    </head>
    <body class="antialiased">
        <div class="min-h-screen relative overflow-hidden flex flex-col items-center justify-center p-4">

            <!-- Decorative orbs -->
            <span class="pointer-events-none absolute -top-20 -left-20 h-64 w-64 rounded-full bg-indigo-500 blur-3xl opacity-20"></span>
            <span class="pointer-events-none absolute bottom-40 -right-10 h-56 w-56 rounded-full bg-cyan-400 blur-3xl opacity-20"></span>

            <div class="mb-8 flex flex-col items-center gap-4">
                <div class="h-16 w-16 rounded-3xl bg-gradient-to-br from-indigo-500 to-cyan-400 flex items-center justify-center text-white text-2xl font-bold shadow-2xl rotate-3">
                    EEMS
                </div>
                <div class="text-center">
                    <h1 class="text-3xl font-bold tracking-tight text-white italic">EEMS</h1>
                    <p class="text-sm text-slate-400 mt-1">Smart equipment lifecycle</p>
                </div>
            </div>

            <div class="w-full sm:max-w-md glass-panel rounded-[2rem] p-8">
                {{ $slot }}
            </div>

            <div class="mt-8 flex gap-4 text-xs">
                <a href="/lang/en" class="px-3 py-1 bg-white/5 border border-white/10 rounded-full hover:bg-white/10 {{ app()->getLocale()==='en'?'text-indigo-400':'' }}">English</a>
                <a href="/lang/ar" class="px-3 py-1 bg-white/5 border border-white/10 rounded-full hover:bg-white/10 {{ app()->getLocale()==='ar'?'text-indigo-400':'' }}">العربية</a>
            </div>
        </div>
    </body>
</html>
