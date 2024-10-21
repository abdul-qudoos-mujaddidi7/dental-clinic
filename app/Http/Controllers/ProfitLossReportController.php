<?php

namespace App\Http\Controllers;

use App\Models\BillExpense;
use App\Models\CurePayment;
use App\Models\Expense;
use App\Models\OwnerPickup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfitLossReportController extends Controller
{
   
    public function __invoke(Request $request)
    {
        // Calculate total earnings from CurePayments
        $totalEarnings = CurePayment::whereNull('deleted_at')->sum('amount');

        // Calculate total expenses and total billable expenses
        $totalExpenses = Expense::whereNull('deleted_at')->sum('amount');
        $totalBillableExpenses = BillExpense::whereNull('deleted_at')->sum('grand_total');
        $totalAllExpense = $totalExpenses + $totalBillableExpenses;

        // Calculate total profit
        $totalAllProfit = $totalEarnings - $totalAllExpense;

        // Calculate total pickups by owners
        $totalPickups = OwnerPickup::whereNull('deleted_at')->sum('amount');

        // Return calculated data as an array
        return [
            'totalAllExpense' => $totalAllExpense,
            'totalAllProfit'   => $totalAllProfit,
            'totalAllPickup'   => $totalPickups
        ];
    }
}
