<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientPaymentReportController extends Controller
{
    public function __invoke(Request $request)
    {
        // Get the date filters from the request
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;

        // Fetch patient payments with optional date range filter
        $patientPayments = DB::table('patients')
            ->selectRaw('patients.id, patients.name, patients.phone, patients.address, SUM(grand_total) - SUM(paid) as due')
            ->join('cures', 'cures.patient_id', '=', 'patients.id')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                // Apply date filter if provided
                $query->whereBetween('cures.created_at', [$fromDate, $toDate]);
            })
            ->groupBy('patients.id', 'patients.name', 'patients.phone', 'patients.address')
            ->paginate(5);

        return response()->json([
            'patientPayments' => $patientPayments
        ]);
    }
}
