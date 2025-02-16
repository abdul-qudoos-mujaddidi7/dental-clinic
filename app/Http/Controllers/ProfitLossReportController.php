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
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;

            $totalEarnings = CurePayment::whereNull('deleted_at')
                ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                    $query->whereBetween('date', [$fromDate, $toDate]);
                })
                ->sum('amount');

            $totalExpenses = Expense::whereNull('deleted_at')
                ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                    $query->whereBetween('date', [$fromDate, $toDate]);
                })
                ->sum('amount');

            $totalBillableExpenses = BillExpense::whereNull('deleted_at')
                ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                    $query->whereBetween('date', [$fromDate, $toDate]);
                })
                ->sum('grand_total');

            $totalPickups = OwnerPickup::whereNull('deleted_at')
                ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                    $query->whereBetween('date', [$fromDate, $toDate]);
                })
                ->sum('amount');

            $totalAllExpense = $totalExpenses + $totalBillableExpenses;
            $totalAllProfit = $totalEarnings - $totalAllExpense;

            return response()->json([
                'totalAllExpense' => $totalAllExpense,
                'totalAllProfit'  => $totalAllProfit,
                'totalAllPickup'  => $totalPickups
            ]);
        }
    }

