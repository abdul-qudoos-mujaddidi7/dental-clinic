<?php

namespace App\Http\Controllers;

use App\Models\BillExpense;
use App\Models\CurePayment;
use App\Models\Expense;
use App\Models\OwnerPickup;
use Illuminate\Http\Request;

class ProfitLossReportController extends Controller
{
    public function __invoke(Request $request)
    {
        // Check if date range is provided
        if ($request->has(['from_date', 'to_date']) && !empty($request->from_date) && !empty($request->to_date)) {
            $fromDate = $request->from_date;
            $toDate = $request->to_date;

            // Filtered calculations (Custom Data)
            $totalEarnings = CurePayment::whereNull('deleted_at')
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->sum('amount');

            $totalExpenses = Expense::whereNull('deleted_at')
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->sum('amount');

            $totalBillableExpenses = BillExpense::whereNull('deleted_at')
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->sum('grand_total');

            $totalAllExpense = $totalExpenses + $totalBillableExpenses;
            $totalAllProfit = $totalEarnings - $totalAllExpense;

            $totalPickups = OwnerPickup::whereNull('deleted_at')
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->sum('amount');

            return response()->json([
                'totalAllExpense' => $totalAllExpense,
                'totalAllProfit'  => $totalAllProfit,
                'totalAllPickup'  => $totalPickups
            ]);
        }

        // Default calculations (All Records)
        $totalEarnings = CurePayment::whereNull('deleted_at')->sum('amount');
        $totalExpenses = Expense::whereNull('deleted_at')->sum('amount');
        $totalBillableExpenses = BillExpense::whereNull('deleted_at')->sum('grand_total');
        $totalAllExpense = $totalExpenses + $totalBillableExpenses;
        $totalAllProfit = $totalEarnings - $totalAllExpense;
        $totalPickups = OwnerPickup::whereNull('deleted_at')->sum('amount');

        return response()->json([
            'totalAllExpense' => $totalAllExpense,
            'totalAllProfit'  => $totalAllProfit,
            'totalAllPickup'  => $totalPickups
        ]);
    }
}
