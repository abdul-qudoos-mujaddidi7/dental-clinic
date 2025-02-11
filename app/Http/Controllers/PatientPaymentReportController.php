<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientPaymentReportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Check if date filters are provided
        if ($request->has(['from_date', 'to_date']) && !empty($request->from_date) && !empty($request->to_date)) {
            // Fetch filtered patient payments
            $customPatientPayments = DB::table('patients')
                ->selectRaw('patients.id, patients.name, patients.phone, patients.address, SUM(grand_total) - SUM(paid) as due')
                ->join('cures', 'cures.patient_id', '=', 'patients.id')
                ->whereBetween('cures.created_at', [$request->from_date, $request->to_date])
                ->groupBy('patients.id', 'patients.name', 'patients.phone', 'patients.address')
                ->get();

            return response()->json([
                'custom_patients' => $customPatientPayments
            ]);
        }

        // Default: Fetch all patient payments (paginated)
        $patientPayment = DB::table('patients')
            ->selectRaw('patients.id, patients.name, patients.phone, patients.address, SUM(grand_total) - SUM(paid) as due')
            ->join('cures', 'cures.patient_id', '=', 'patients.id')
            ->groupBy('patients.id', 'patients.name', 'patients.phone', 'patients.address')
            ->paginate(5);

        return response()->json([
            'patientPayment' => $patientPayment
        ]);
    }
}
