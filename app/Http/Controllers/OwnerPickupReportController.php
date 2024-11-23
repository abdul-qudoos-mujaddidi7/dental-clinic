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
        $ownerPickup= DB::table('owner_pickups')->selectRaw('owners.name, Sum(amount) as totalAmount')
                    ->leftJoin('owners','owner_pickups.owner_id', '=', 'owners.id')
                    ->groupBy('owner_pickups.owner_id','owners.name')->paginate(5);


        return $ownerPickup;
    }
}
