<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceReportController extends Controller
{
    public function __invoke(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Default to 10 items per page if not provided

        // Check if date range is provided
        $fromDate = $request->start_date;
        $toDate = $request->end_date;
       
        // Default calculations (All Records)
        $allData = DB::table('services')
            ->selectRaw('services.name, SUM(cure_services.quantity) as totalApplied')
            ->join('cure_services', 'cure_services.service_id', '=', 'services.id')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('cure_services.created_at', [$fromDate, $toDate]);
            })
            ->groupBy('services.id', 'services.name')
            ->paginate($perPage);

        // Return all data with pagination
        return response()->json($allData);
    }
}
