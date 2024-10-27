<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseCategoryReportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $productCategory = DB::table('expenses')
        ->selectRaw('expense_categories.name, SUM(expenses.amount) as totalAmount')
        ->join('expense_categories', 'expense_categories.id', '=', 'expenses.expense_category_id')
        ->whereNull('expenses.deleted_at')
        ->groupBy('expense_categories.name')
        ->get();


        return $productCategory;
        }

        
}
