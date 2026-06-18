@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-slate-50 dark:bg-slate-950 min-h-[90vh]">
    <!-- Header -->
    <div class="mb-12 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 border-b border-slate-200 dark:border-slate-800 pb-8">
        <div>
            <h1 class="text-2xl font-bold uppercase tracking-tight text-primary-600">
                Dossier History
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 font-light">
                Revisit and manage your previously compiled geographical analysis reports.
            </p>
        </div>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-xs font-mono uppercase tracking-wider rounded transition-all duration-200 cursor-pointer">
            New Scan
        </a>
    </div>

    <!-- History Grid -->
    @if($reports->isEmpty())
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded p-12 text-center max-w-md mx-auto mt-12">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-800 dark:text-white">Empty History Log</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 mb-6 font-light">No entries found. Compile your first analytical scan from the control panel.</p>
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-4 py-2 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-xs font-mono uppercase tracking-wider rounded hover:bg-slate-50 dark:hover:bg-slate-800 transition-all cursor-pointer">
                Run Engine
            </a>
        </div>
@else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($reports as $report)
                @php
                    $data = $report->report_data;
                    $title = $data['title'] ?? 'Location Report';
                    $catchphrase = Str::limit($data['soul'] ?? 'Dossier Entry', 80);
                @endphp
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded p-6 flex flex-col justify-between hover:border-primary-400 dark:hover:border-primary-800 transition-all duration-200 group" id="report-card-{{ $report->id }}">
                    <div>
                        <!-- Location & Date -->
                        <div class="flex items-center justify-between text-[10px] font-mono uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-4 pb-3 border-b border-slate-100 dark:border-slate-800/60">
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                {{ $report->location_display }}
                            </span>
                            <span>{{ $report->created_at->diffForHumans() }}</span>
                        </div>

                        <!-- Catchy Title -->
                        <h3 class="text-base font-bold text-slate-800 dark:text-white uppercase tracking-tight line-clamp-1 mb-2">
                            {{ $title }}
                        </h3>

                        <!-- Short Description -->
                        <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mb-6 font-light leading-relaxed">
                            {{ $catchphrase }}
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-800">
                        <a href="{{ route('home') }}?load_report_id={{ $report->id }}" class="inline-flex items-center gap-1.5 text-xs font-mono uppercase tracking-wider text-primary-600 hover:text-primary-700 font-bold transition-colors cursor-pointer" aria-label="Open this dossier"
                            <span>Open Log</span>
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>

                        <button
                            type="button"
                            data-delete-report-id="{{ $report->id }}"
                            class="delete-report-btn w-7 h-7 rounded border border-slate-200 dark:border-slate-800 flex items-center justify-center text-slate-400 hover:text-rose-500 dark:hover:text-rose-400 hover:bg-rose-500/5 dark:hover:bg-rose-500/10 transition-all cursor-pointer"
                            aria-label="Delete dossier" title="Delete Dossier"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $reports->links() }}
        </div>
    @endif
</section>
@endsection
