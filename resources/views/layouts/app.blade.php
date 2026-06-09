<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PlacePulse AI') }} — AI Location Reports</title>
    <meta name="description" content="One-click instant deep-dive location reports. Discover the soul, history, and local flavor of any place.">
    <meta name="keywords" content="AI, location reports, city guide, minimalist traveler">

    <!-- Favicon (Clean SVG Location Icon) -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z'/><circle cx='12' cy='10' r='3'/></svg>">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 font-sans min-h-screen transition-colors duration-300">

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/85 dark:bg-slate-950/85 backdrop-blur-md border-b border-slate-200/60 dark:border-slate-800/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2.5 group">
                    <div class="w-8 h-8 rounded-lg border border-primary-200 dark:border-primary-900/50 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </div>
                    <span class="text-sm font-mono tracking-wider text-primary-600">
                        PlacePulse
                    </span>
                </a>

                <!-- Right Navigation Area -->
                <div class="flex items-center gap-5">
                    @auth
                        <a href="{{ route('history.index') }}" class="text-xs font-mono uppercase tracking-wider text-slate-500 dark:text-slate-400 hover:text-primary-600 transition-colors">
                            History
                        </a>
                        <span class="text-xs font-mono uppercase text-slate-400 hidden sm:inline">
                            [{{ Auth::user()->name }}]
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs font-mono uppercase tracking-wider text-slate-400 hover:text-rose-550 dark:hover:text-rose-450 transition-colors cursor-pointer">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-mono uppercase tracking-wider text-slate-500 dark:text-slate-400 hover:text-primary-600 transition-colors">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="text-xs font-mono uppercase tracking-wider bg-primary-600 hover:bg-primary-700 text-white px-3.5 py-1.5 rounded transition-all duration-200">
                            Register
                        </a>
                    @endauth

                    <!-- Divider -->
                    <div class="h-4 w-px bg-slate-200 dark:bg-slate-800"></div>

                    <!-- Dark Mode Toggle -->
                    <button id="darkModeToggle" type="button" class="relative w-8 h-8 rounded-lg border border-slate-200 dark:border-slate-800 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200 flex items-center justify-center group cursor-pointer" aria-label="Toggle dark mode">
                        <!-- Sun -->
                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 absolute transition-all duration-250 dark:opacity-0 dark:scale-50 opacity-100 scale-100" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                        </svg>
                        <!-- Moon -->
                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 absolute transition-all duration-250 dark:opacity-100 dark:scale-100 opacity-0 scale-50" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Toast Notification -->
    <div id="toast" class="toast pointer-events-none">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg px-4 py-3 shadow-xl flex items-center gap-3 w-full max-w-sm sm:max-w-md pointer-events-auto">
            <div id="toastIcon" class="flex-shrink-0"></div>
            <p id="toastMessage" class="text-xs text-slate-700 dark:text-slate-350 font-sans leading-normal"></p>
        </div>
    </div>

</body>
</html>
