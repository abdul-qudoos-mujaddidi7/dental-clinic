<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientPaymentReportController extends Controller
{
   public function __invoke(Request $request)
{
    $fromDate = $request->start_date;
    $toDate = $request->end_date;

    $patientPayments = DB::table('people')
        ->selectRaw('people.id, people.name, people.phone, people.address, SUM(grand_total) - SUM(paid) as due')
        ->join('cures', 'cures.patient_id', '=', 'people.id')
        ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            return $query->whereBetween('cures.start_date', [$fromDate, $toDate]);
        })
        ->groupBy('people.id', 'people.name', 'people.phone', 'people.address')
        ->paginate(5);

    return response()->json([
        'patientPayments' => $patientPayments
    ]);
}

}
