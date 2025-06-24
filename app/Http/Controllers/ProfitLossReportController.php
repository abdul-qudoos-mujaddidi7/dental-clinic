<?php

namespace App\Http\Controllers;

use App\Models\BillExpense;
use App\Models\CurePayment;
use App\Models\Expense;
use App\Models\MoneyAccountTransaction;
use App\Models\OwnerPickup;
use Illuminate\Http\Request;

class ProfitLossReportController extends Controller
{
    public function __invoke(Request $request)
    {
        // Check if date range is provided
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;

             $totalEarnings = MoneyAccountTransaction::where('payment_type', 'received')->sum('amount');
             $totalAllExpenses = MoneyAccountTransaction::where('payment_type', 'paid')->sum('amount');

            $totalPickups = OwnerPickup::whereNull('deleted_at')
                ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                    $query->whereBetween('date', [$fromDate, $toDate]);
                })
                ->sum('amount');

            
            $totalNetProfit = $totalEarnings - $totalAllExpenses;

            return response()->json([
                'totalAllExpense' => $totalAllExpenses,
                'totalAllProfit'  => $totalNetProfit,
                'totalAllPickup'  => $totalPickups
            ]);
        }
    }

