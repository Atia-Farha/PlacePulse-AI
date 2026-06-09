@extends('layouts.app')

@section('content')

<!-- ═══════════════ HERO SECTION ═══════════════ -->
<section id="heroSection" class="relative min-h-[85vh] flex items-center justify-center py-20 px-4 border-b border-slate-200/60 dark:border-slate-800/60 bg-white dark:bg-slate-950">
    <!-- Clean grid line overlay for tech/architectural feel -->
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#e2e8f0_1px,transparent_1px),linear-gradient(to_bottom,#e2e8f0_1px,transparent_1px)] dark:bg-[linear-gradient(to_right,#1e293b_1px,transparent_1px),linear-gradient(to_bottom,#1e293b_1px,transparent_1px)] bg-size-[4rem_4rem] mask-[radial-gradient(ellipse_60%_50%_at_50%_50%,#000_70%,transparent_100%)] opacity-30 dark:opacity-20 pointer-events-none"></div>

    <div class="relative z-10 text-center px-4 max-w-3xl mx-auto">
        <!-- Minimalist Monospace Badge -->
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded border border-primary-200 dark:border-primary-900 text-primary-600 text-xs font-mono uppercase tracking-wider mb-8 animate-fade-in-up">
            <span class="w-1.5 h-1.5 bg-primary-600 rounded-full animate-pulse"></span>
            System Engine Active
        </div>

        <!-- Title -->
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-primary-600 mb-6 animate-fade-in-up delay-100 uppercase">
            Map the Untold
        </h1>

        <!-- Subtitle -->
        <p class="text-base sm:text-lg text-slate-500 dark:text-slate-400 mb-12 max-w-xl mx-auto animate-fade-in-up delay-200 leading-relaxed font-light font-sans">
            Enter any global location to extract a highly structured intelligence report including historical timelines, local insights, and geographical analysis.
        </p>

        <!-- Input Area -->
        <div class="animate-fade-in-up delay-300 space-y-6">
            <!-- Scan Location Button -->
            <button
                id="scanLocationBtn"
                type="button"
                class="group relative inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold rounded active:scale-[0.98] transition-all duration-200 cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                <span>Scan Geolocation</span>
            </button>

            <!-- Divider -->
            <div class="flex items-center gap-4 max-w-xs mx-auto">
                <div class="flex-1 h-px bg-slate-200 dark:bg-slate-800"></div>
                <span class="text-slate-400 dark:text-slate-600 text-xs font-mono uppercase tracking-wider">or query</span>
                <div class="flex-1 h-px bg-slate-200 dark:bg-slate-800"></div>
            </div>

            <!-- Manual Input -->
            <form id="manualForm" class="flex flex-col sm:flex-row items-stretch gap-3 max-w-lg mx-auto">
                <div class="flex-1 relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input
                        id="locationInput"
                        type="text"
                        placeholder="City, landmark, or region..."
                        class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all"
                        autocomplete="off"
                    >
                </div>
                <button
                    id="generateBtn"
                    type="submit"
                    class="px-5 py-3 bg-primary-600 hover:bg-primary-700 text-white text-sm font-semibold rounded transition-all duration-200 flex items-center gap-2 justify-center cursor-pointer"
                >
                    Analyze
                </button>
            </form>
        </div>
    </div>
</section>

<!-- ═══════════════ LOADING STATE ═══════════════ -->
<section id="loadingSection" class="hidden py-24 px-4 bg-slate-50 dark:bg-slate-950">
    <div class="max-w-4xl mx-auto text-center">
        <!-- Spinner -->
        <div class="w-12 h-12 border-2 border-slate-300 dark:border-slate-700 border-t-primary-600 dark:border-t-primary-500 rounded-full animate-spin mx-auto mb-8"></div>

        <!-- Loading Message -->
        <h2 class="text-xl font-bold uppercase tracking-wider text-slate-900 dark:text-white mb-2" id="loadingTitle">Analyzing Coordinates...</h2>
        <p class="text-sm font-mono text-slate-500 dark:text-slate-400" id="loadingMessage">Generating target data stream</p>

        <!-- Skeleton Preview -->
        <div class="mt-12 space-y-6 max-w-2xl mx-auto text-left opacity-60">
            <div class="skeleton h-8 w-1/3"></div>
            <div class="skeleton h-4 w-1/4"></div>
            <div class="space-y-2.5 mt-8">
                <div class="skeleton h-4 w-full"></div>
                <div class="skeleton h-4 w-5/6"></div>
                <div class="skeleton h-4.5 w-4/5"></div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════ REPORT SECTION ═══════════════ -->
<section id="reportSection" class="hidden pb-24 bg-slate-50 dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800">
    <!-- Dashboard Header -->
    <div class="border-b border-slate-200 dark:border-slate-800 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-end md:justify-between gap-6">
            <div>
                <p class="text-xs font-mono uppercase tracking-widest text-primary-600 mb-2" id="reportBadge">PlacePulse Intelligence Dossier</p>
                <h1 class="text-3xl sm:text-4xl font-bold text-primary-600 tracking-tight uppercase" id="reportTitle"></h1>
                <p class="text-md text-slate-500 dark:text-slate-400 font-light mt-2 max-w-2xl" id="reportSubtitle"></p>
            </div>
            <div class="flex items-center gap-2 border border-primary-200 dark:border-primary-900/40 rounded bg-primary-50/20 dark:bg-primary-950/20 px-3 py-1.5 text-xs font-mono text-primary-600">
                <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                <span id="reportLocation"></span>
            </div>
        </div>
    </div>

    <!-- Structured Dashboard Layout Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 space-y-8">
        
        <!-- Contextual Narrative (Soul) -->
        <div id="reportSoul" class="report-section bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-8 sm:p-10 shadow-sm">
            <div class="flex items-center gap-2 mb-6 border-b border-slate-100 dark:border-slate-800/60 pb-4">
                <svg class="w-4 h-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
                <h2 class="text-xs font-mono uppercase tracking-wider text-primary-600">Contextual Narrative</h2>
            </div>
            <div class="prose prose-slate dark:prose-invert max-w-none text-base leading-relaxed font-light text-slate-600 dark:text-slate-300 space-y-4" id="soulContent"></div>
        </div>

        <!-- Timeline & Spots (2-Column Grid) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
            <!-- Timeline / History -->
            <div id="reportHistory" class="report-section delay-200 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-8 shadow-sm h-full">
                <div class="flex items-center gap-2 mb-6 border-b border-slate-100 dark:border-slate-800/60 pb-4">
                    <svg class="w-4 h-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h2 class="text-xs font-mono uppercase tracking-wider text-primary-600">Chronological Milestones</h2>
                </div>
                <div class="space-y-6 relative border-l border-slate-200 dark:border-slate-800 pl-4 ml-2 animate-fade-in-up" id="historyContent"></div>
            </div>

            <!-- Must Visit Spots -->
            <div id="reportMustVisit" class="report-section delay-300 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-8 shadow-sm h-full">
                <div class="flex items-center gap-2 mb-6 border-b border-slate-100 dark:border-slate-800/60 pb-4">
                    <svg class="w-4 h-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8m-3-12.5A2.25 2.25 0 1 1 9.75 3h4.5A2.25 2.25 0 1 1 12 5.25Z" />
                    </svg>
                    <h2 class="text-xs font-mono uppercase tracking-wider text-primary-600">Curated Points of Interest</h2>
                </div>
                <div class="space-y-4" id="mustVisitContent"></div>
            </div>
        </div>

        <!-- Local Flavors & Tips (2-Column Grid) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
            <!-- Local Flavors -->
            <div id="reportFlavors" class="report-section delay-400 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-8 shadow-sm h-full">
                <div class="flex items-center gap-2 mb-6 border-b border-slate-100 dark:border-slate-800/60 pb-4">
                    <svg class="w-4 h-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                    </svg>
                    <h2 class="text-xs font-mono uppercase tracking-wider text-primary-600">Cultural & Flavor Profiles</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="flavorsContent"></div>
            </div>

            <!-- Practical Tips -->
            <div id="reportTips" class="report-section delay-500 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-8 shadow-sm h-full">
                <div class="flex items-center gap-2 mb-6 border-b border-slate-100 dark:border-slate-800/60 pb-4">
                    <svg class="w-4 h-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                    </svg>
                    <h2 class="text-xs font-mono uppercase tracking-wider text-primary-600">Operational Guidelines</h2>
                </div>
                <div class="space-y-3.5" id="tipsContent"></div>
            </div>
        </div>

        <!-- Fun Facts (Full Width) -->
        <div id="reportFacts" class="report-section delay-600 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-8 shadow-sm">
            <div class="flex items-center gap-2 mb-6 border-b border-slate-100 dark:border-slate-800/60 pb-4">
                <svg class="w-4 h-4 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z" />
                </svg>
                <h2 class="text-xs font-mono uppercase tracking-wider text-primary-600">Trivia Matrix</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="factsContent"></div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div id="reportActions" class="report-section delay-700 flex flex-wrap items-center justify-center gap-4 pt-12 pb-4 border-t border-slate-200 dark:border-slate-800 mt-12">
        <button
            id="regenerateBtn"
            type="button"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-xs font-mono uppercase tracking-wider rounded transition-all duration-200 cursor-pointer"
        >
            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182" />
            </svg>
            Regenerate
        </button>

        <button
            id="exportPdfBtn"
            type="button"
            class="inline-flex items-center gap-2 px-5 py-2.5 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-xs font-mono uppercase tracking-wider rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200 cursor-pointer"
        >
            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            Download PDF
        </button>

        <button
            id="newReportBtn"
            type="button"
            class="inline-flex items-center gap-2 px-5 py-2.5 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-xs font-mono uppercase tracking-wider rounded hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200 cursor-pointer"
        >
            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Reset Dossier
        </button>
    </div>
</section>

<!-- ═══════════════ FOOTER ═══════════════ -->
<footer class="py-10 text-center text-xs font-mono uppercase tracking-wider text-slate-400 dark:text-slate-600 border-t border-slate-200/60 dark:border-slate-800/60 bg-white dark:bg-slate-950">
    <p>PlacePulse Engine &middot; Powered by OpenAI &middot; &copy; {{ date('Y') }}</p>
</footer>

@endsection
