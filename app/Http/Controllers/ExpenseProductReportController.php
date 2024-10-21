<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseProductReportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $expenseProduct= DB::table('products')
        ->selectRaw('products.name, Sum(total) as totalAmount')
        ->join('bill_expense_details','bill_expense_details.product_id','=','products.id')
        ->groupBy('products.name')->get();

        return $expenseProduct;
    }
}
