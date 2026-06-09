<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>PlacePulse Intelligence Dossier — {{ $location }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        @page {
            padding: 60px 65px;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            line-height: 1.5;
            font-size: 11px;
            background: #ffffff;
        }

        /* Header block */
        .header {
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 18px;
            margin-bottom: 25px;
        }

        .header .brand {
            font-size: 9px;
            font-family: monospace;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #4f46e5;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: -0.5px;
            line-height: 1.2;
            margin-bottom: 4px;
        }

        .header .subtitle {
            font-size: 11px;
            color: #64748b;
            margin-bottom: 12px;
            font-style: italic;
        }

        /* Metadata Table */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
        }

        .meta-cell {
            vertical-align: middle;
        }

        .meta-label {
            font-size: 8px;
            font-family: monospace;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 1px;
        }

        .meta-value {
            font-size: 10px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            text-align: right;
        }

        /* Content block */
        .section {
            margin-bottom: 28px;
            page-break-inside: avoid;
        }

        .section-header {
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 4px;
            margin-bottom: 12px;
        }

        .section-title {
            font-size: 10.5px;
            font-family: monospace;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: bold;
            color: #4f46e5;
        }

        /* Soul of the Place */
        .soul-text {
            font-size: 11px;
            line-height: 1.6;
            color: #334155;
        }

        .soul-text p {
            margin-bottom: 10px;
        }

        /* Timeline Elements */
        .timeline-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .timeline-row {
            page-break-inside: avoid;
        }

        .timeline-left {
            width: 90px;
            vertical-align: top;
            padding-right: 12px;
            padding-bottom: 15px;
        }

        .timeline-year {
            display: inline-block;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            padding: 3px 6px;
            font-size: 9px;
            font-family: monospace;
            font-weight: bold;
            color: #334155;
            text-align: center;
        }

        .timeline-right {
            vertical-align: top;
            border-left: 1px solid #cbd5e1;
            padding-left: 15px;
            padding-bottom: 15px;
        }

        .timeline-title {
            font-weight: bold;
            color: #0f172a;
            font-size: 11.5px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .timeline-desc {
            color: #475569;
            font-size: 10.5px;
            line-height: 1.4;
        }

        /* Two Column Grid Structure via HTML Tables */
        .grid-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
            margin: -10px;
        }

        .grid-cell {
            width: 50%;
            vertical-align: top;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 14px;
        }

        .card-category {
            display: inline-block;
            border: 1px solid #cbd5e1;
            color: #64748b;
            font-size: 7.5px;
            font-family: monospace;
            font-weight: bold;
            padding: 1px 5px;
            text-transform: uppercase;
            margin-bottom: 6px;
            background: #ffffff;
        }

        .card-title {
            font-weight: bold;
            color: #0f172a;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .card-desc {
            color: #475569;
            font-size: 10px;
            line-height: 1.4;
            margin-bottom: 6px;
        }

        .card-meta-title {
            font-size: 7.5px;
            font-family: monospace;
            text-transform: uppercase;
            color: #94a3b8;
            margin-top: 6px;
            display: block;
        }

        .card-meta-value {
            color: #1e293b;
            font-size: 9.5px;
            font-style: italic;
        }

        /* Practical Tips */
        .tip-row {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px 14px;
            margin-bottom: 8px;
            page-break-inside: avoid;
        }

        .tip-category {
            font-family: monospace;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8.5px;
            color: #4f46e5;
            margin-bottom: 2px;
        }

        .tip-text {
            color: #334155;
            font-size: 10px;
            line-height: 1.4;
        }

        /* Fun Facts */
        .fact-badge {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px 14px;
            font-size: 10px;
            line-height: 1.4;
            color: #334155;
            margin-bottom: 6px;
            page-break-inside: avoid;
        }

        /* Footer block */
        .footer {
            text-align: center;
            font-size: 8px;
            font-family: monospace;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
            margin-top: 30px;
        }
    </style>
</head>

<body>

    <!-- Header Block -->
    <div class="header">
        <div class="brand">PlacePulse Intelligence Dossier</div>
        <h1>{{ $report['title'] ?? 'Location Report' }}</h1>
        <div class="subtitle">{{ $report['subtitle'] ?? '' }}</div>

        <table class="meta-table">
            <tr>
                <td class="meta-cell meta-label">Target Location</td>
                <td class="meta-cell meta-value">{{ $location }}</td>
            </tr>
        </table>
    </div>

    <!-- Contextual Narrative (Soul) -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Contextual Narrative</div>
        </div>
        <div class="soul-text">
            @foreach(explode("\n", $report['soul'] ?? '') as $paragraph)
                @if(trim($paragraph))
                    <p>{{ $paragraph }}</p>
                @endif
            @endforeach
        </div>
    </div>

    <!-- History Timeline -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Chronological Milestones</div>
        </div>
        <table class="timeline-table">
            @foreach(($report['history'] ?? []) as $item)
                <tr class="timeline-row">
                    <td class="timeline-left">
                        <span class="timeline-year">{{ $item['year'] }}</span>
                    </td>
                    <td class="timeline-right">
                        <div class="timeline-title">{{ $item['title'] }}</div>
                        <div class="timeline-desc">{{ $item['description'] }}</div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <!-- Curated Points of Interest -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Curated Points of Interest</div>
        </div>
        <table class="grid-table">
            @foreach(array_chunk($report['must_visit'] ?? [], 2) as $row)
                <tr>
                    @foreach($row as $spot)
                        <td class="grid-cell">
                            <span class="card-category">{{ $spot['category'] }}</span>
                            <div class="card-title">{{ $spot['name'] }}</div>
                            <div class="card-desc">{{ $spot['description'] }}</div>
                            <div>
                                <span class="card-meta-title">Why Visit</span>
                                <span class="card-meta-value">{{ $spot['why_visit'] }}</span>
                            </div>
                        </td>
                    @endforeach
                    @if(count($row) === 1)
                        <td style="width: 50%; border: none; background: none;"></td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>

    <!-- Local Flavors & Cultural Profiles -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Cultural & Flavor Profiles</div>
        </div>
        <table class="grid-table">
            @foreach(array_chunk($report['local_flavors'] ?? [], 2) as $row)
                <tr>
                    @foreach($row as $item)
                        <td class="grid-cell">
                            <span class="card-category">{{ $item['type'] }}</span>
                            <div class="card-title">{{ $item['title'] }}</div>
                            <div class="card-desc" style="margin-bottom: 0;">{{ $item['description'] }}</div>
                        </td>
                    @endforeach
                    @if(count($row) === 1)
                        <td style="width: 50%; border: none; background: none;"></td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>

    <!-- Practical Tips (Operational Guidelines) -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Operational Guidelines</div>
        </div>
        @foreach(($report['practical_tips'] ?? []) as $item)
            <div class="tip-row">
                <div class="tip-category">{{ $item['category'] ?? 'General' }}</div>
                <div class="tip-text">{{ $item['tip'] }}</div>
            </div>
        @endforeach
    </div>

    <!-- Fun Facts (Trivia Matrix) -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Trivia Matrix</div>
        </div>
        @foreach(($report['fun_facts'] ?? []) as $fact)
            <div class="fact-badge">{{ $fact }}</div>
        @endforeach
    </div>

    <!-- Footer Block -->
    <div class="footer">
        Generated via PlacePulse Engine &middot; {{ now()->format('F j, Y') }} &middot; Powered by AI
    </div>

</body>

</html>