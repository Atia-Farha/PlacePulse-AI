<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HistoryController extends Controller
{
    /**
     * Display a listing of the user's reports.
     */
    public function index(Request $request)
    {
        $reports = $request->user()
            ->reports()
            ->paginate(12);

        return view('history', compact('reports'));
    }

    /**
     * Show details of a specific report (returns JSON for re-viewing).
     */
    public function show(Request $request, $id): JsonResponse
    {
        $report = $request->user()
            ->reports()
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $report->report_data,
            'location' => $report->location_display,
        ]);
    }

    /**
     * Remove the specified report from history.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $report = $request->user()
            ->reports()
            ->findOrFail($id);

        $report->delete();

        return response()->json([
            'success' => true,
            'message' => 'Report deleted successfully.',
        ]);
    }
}
