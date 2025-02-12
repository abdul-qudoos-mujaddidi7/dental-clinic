<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerPickupReportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Get the date filters from the request
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;

        // Fetch owner pickup records with optional date range filter
        $ownerPickup = DB::table('owner_pickups')
            ->selectRaw('owners.name, SUM(amount) as totalAmount')
            ->leftJoin('owners', 'owner_pickups.owner_id', '=', 'owners.id')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                // Apply date filter if provided
                $query->whereBetween('owner_pickups.created_at', [$fromDate, $toDate]);
            })
            ->groupBy('owner_pickups.owner_id', 'owners.name')
            ->paginate(5);

        return response()->json([
            'ownerPickup' => $ownerPickup
        ]);
    }
}
