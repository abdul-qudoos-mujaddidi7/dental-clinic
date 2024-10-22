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
        $patientPayment= DB::table('patients')->selectRaw('patients.id ,patients.name,patients.phone,Sum(grand_total) - Sum(paid) as due')
        ->join('cures','cures.patient_id','=','patients.id')->groupBy('patients.id','patients.name','patients.phone')->get();

        return $patientPayment;
    }
}
