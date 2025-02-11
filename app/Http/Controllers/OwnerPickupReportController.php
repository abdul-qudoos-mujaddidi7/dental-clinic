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
        // Check if date filters are provided
        if ($request->has(['from_date', 'to_date']) && !empty($request->from_date) && !empty($request->to_date)) {
            // Fetch filtered owner pickup records
            $customOwnerPickup = DB::table('owner_pickups')
                ->selectRaw('owners.name, SUM(amount) as totalAmount')
                ->leftJoin('owners', 'owner_pickups.owner_id', '=', 'owners.id')
                ->whereBetween('owner_pickups.created_at', [$request->from_date, $request->to_date])
                ->groupBy('owner_pickups.owner_id', 'owners.name')
                ->get();

            return response()->json([
                'customOwnerPickup' => $customOwnerPickup
            ]);
        }

        // Default: Fetch all owner pickup records (paginated)
        $ownerPickup = DB::table('owner_pickups')
            ->selectRaw('owners.name, SUM(amount) as totalAmount')
            ->leftJoin('owners', 'owner_pickups.owner_id', '=', 'owners.id')
            ->groupBy('owner_pickups.owner_id', 'owners.name')
            ->paginate(5);

        return response()->json([
            'ownerPickup' => $ownerPickup
        ]);
    }
}
