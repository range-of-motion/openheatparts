<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@hasSection('title')@yield('title') · @endif OpenHeatParts</title>
    <link rel="canonical" href="{{ url()->current() }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-screen bg-[#FBF8F4] text-stone-900 antialiased">
    <header class="sticky top-0 z-10 border-b border-stone-200/70 bg-[#FBF8F4]/80 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 font-semibold tracking-tight">
                <span class="grid size-8 place-items-center rounded-lg bg-gradient-to-br from-orange-500 to-amber-500 text-white">
                    <svg viewBox="0 0 24 24" class="size-4" fill="currentColor"><path d="M12 2s6 6.2 6 11a6 6 0 0 1-12 0c0-2.4 1.4-4.8 3-6.6 0 2.2 1.2 3.6 3 3.6-1.4-2.6-.6-5.6 0-8z"/></svg>
                </span>
                OpenHeatParts
            </a>
            <nav class="text-sm text-stone-600">
                <a href="{{ route('home') }}" class="hover:text-stone-900">Models</a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-6 pb-20">
        @yield('content')
    </main>

    <footer class="border-t border-stone-200 bg-white/50">
        <div class="mx-auto max-w-6xl px-6 py-8 text-sm text-stone-500">
            OpenHeatParts is a community project and is not affiliated with any heat pump manufacturer.
        </div>
    </footer>
</body>
</html>
