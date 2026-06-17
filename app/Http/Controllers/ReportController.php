<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Services\OpenAIReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function __construct(
        private OpenAIReportService $reportService
    ) {}

    /**
     * Show the main page.
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Generate a location report.
     */
    public function generate(Request $request): JsonResponse
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'fresh' => 'sometimes|boolean',
        ]);

        $location = trim($request->input('location'));
        $fresh = $request->boolean('fresh', false);
        $normalizedQuery = Str::lower(Str::squish($location));
        $userId = auth()->id();

        // Check cache unless fresh generation requested
        if (!$fresh) {
            $cached = Report::where('location_query', $normalizedQuery)
                ->when($userId, function ($query) use ($userId) {
                    $query->orderByRaw('user_id = ? DESC', [$userId]);
                })
                ->latest()
                ->first();

            if ($cached) {
                // If logged in, but this cached report does not belong to the user, copy it to their history
                if ($userId && $cached->user_id !== $userId) {
                    Report::create([
                        'user_id' => $userId,
                        'location_query' => $normalizedQuery,
                        'location_display' => $cached->location_display,
                        'report_data' => $cached->report_data,
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'cached' => true,
                    'data' => $cached->report_data,
                    'location' => $cached->location_display,
                ]);
            }
        }

        try {
            $reportData = $this->reportService->generateReport($location);

            // Cache the report
            Report::create([
                'user_id' => $userId,
                'location_query' => $normalizedQuery,
                'location_display' => $location,
                'report_data' => $reportData,
            ]);

            return response()->json([
                'success' => true,
                'cached' => false,
                'data' => $reportData,
                'location' => $location,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate report. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Reverse geocode coordinates to a place name using OpenStreetMap Nominatim.
     */
    public function reverseGeocode(Request $request): JsonResponse
    {
        $request->validate([
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
        ]);

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'PlacePulseAI/1.0',
                'Accept-Language' => 'en',
            ])->get('https://nominatim.openstreetmap.org/reverse', [
                'lat' => $request->input('lat'),
                'lon' => $request->input('lng'),
                'format' => 'json',
                'addressdetails' => 1,
                'accept-language' => 'en',
                'zoom' => 16,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $address = $data['address'] ?? [];
                $locationName = $this->formatReverseGeocodeLocation($address, $data['display_name'] ?? null);

                return response()->json([
                    'success' => true,
                    'location' => $locationName,
                    'display_name' => $data['display_name'] ?? $locationName,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Could not determine location from coordinates.',
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Geocoding service unavailable.',
            ], 503);
        }
    }

    /**
     * Build a district + country label from Nominatim address parts.
     */
    private function formatReverseGeocodeLocation(array $address, ?string $displayName): string
    {
        $district = $address['state_district']
            ?? $address['district']
            ?? $address['county']
            ?? null;

        $country = $address['country'] ?? null;

        if ($district && $country) {
            return "{$district}, {$country}";
        }

        if ($country) {
            return $country;
        }

        if ($displayName) {
            $segments = array_values(array_filter(
                array_map('trim', explode(',', $displayName)),
                fn (string $segment) => ! preg_match('/^\d+$/', $segment)
            ));

            $districtSegment = collect($segments)->first(
                fn (string $segment) => preg_match('/\b(district|county)\b/i', $segment)
            );

            $countrySegment = $segments[count($segments) - 1] ?? null;

            if ($districtSegment && $countrySegment && $districtSegment !== $countrySegment) {
                return "{$districtSegment}, {$countrySegment}";
            }

            if ($countrySegment) {
                return $countrySegment;
            }
        }

        return 'Unknown Location';
    }

/**
      * Export a report as PDF.
      */
    public function exportPdf(Request $request): \Illuminate\Http\Response
    {
        $request->validate([
            'location' => 'required|string|max:255',
        ]);

        $normalizedQuery = Str::lower(Str::squish($request->input('location')));

        // Build query - include user reports if authenticated, or public reports
        $query = Report::where('location_query', $normalizedQuery);

        if ($userId = auth()->id()) {
            $query->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->orWhereNull('user_id');
            });
        } else {
            $query->whereNull('user_id');
        }

        $report = $query->latest()->first();

        if (!$report) {
            abort(404, 'Report not found. Generate a report first.');
        }

        $pdf = Pdf::loadView('pdf.report', [
            'report' => $report->report_data,
            'location' => $report->location_display,
        ]);

        $filename = Str::slug($report->location_display) . '-placepulse-report.pdf';

        return $pdf->download($filename);
    }
}
