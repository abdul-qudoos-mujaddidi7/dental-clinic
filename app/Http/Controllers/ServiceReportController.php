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
        if ($request->has(['from_date', 'to_date']) && !empty($request->from_date) && !empty($request->to_date)) {
            $fromDate = $request->from_date;
            $toDate = $request->to_date;

            // Filtered calculations (Custom Data)
            $filteredData = DB::table('services')
                ->selectRaw('services.name, COUNT(cure_services.id) as totalApplied')
                ->join('cure_services', 'cure_services.service_id', '=', 'services.id')
                ->join('cures', 'cures.id', '=', 'cure_services.cure_id')
                ->whereBetween('cures.created_at', [$fromDate, $toDate])
                ->groupBy('services.id', 'services.name')
                ->paginate($perPage);

            // Return filtered data with pagination
            return response()->json($filteredData);
        }

        // Default calculations (All Records)
        $allData = DB::table('services')
            ->selectRaw('services.name, COUNT(cure_services.id) as totalApplied')
            ->join('cure_services', 'cure_services.service_id', '=', 'services.id')
            ->join('cures', 'cures.id', '=', 'cure_services.cure_id')
            ->groupBy('services.id', 'services.name')
            ->paginate($perPage);

        // Return all data with pagination
        return response()->json($allData);
    }
}
