<?php

namespace App\Http\Controllers;

use App\Models\MoneyAccountTransaction;
use App\Models\People;
use Carbon\Carbon;
use Carbon\Traits\ToStringFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        // Gregorian Dates
        $today = Carbon::today();
        $currentYear = Carbon::now()->year;
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        // Hijri Dates
        $jalaliToday = Jalalian::fromCarbon($today)->format('Y-m-d');
        $jalaliStartOfMonth = Jalalian::fromCarbon($startOfMonth)->format('Y-m-d');
        $jalaliEndOfMonth = Jalalian::fromCarbon($endOfMonth)->format('Y-m-d');
        $jalaliStartOfLastMonth = Jalalian::fromCarbon($startOfLastMonth)->format('Y-m-d');
        $jalaliEndOfLastMonth = Jalalian::fromCarbon($endOfLastMonth)->format('Y-m-d');
        $currentJalaliYear = Jalalian::now()->format('Y-m-d');


        // All-time earnings and expenses
        $totalEarnings = MoneyAccountTransaction::where('payment_type', 'received')->sum('amount');
        $totalAllExpenses = MoneyAccountTransaction::where('payment_type', 'paid')->sum('amount');
        $netProfit = $totalEarnings - $totalAllExpenses;

        // Monthly Earnings and Expenses (this month)
        $monthlyEarnings = MoneyAccountTransaction::whereBetween('date', [$startOfMonth, $endOfMonth])
            ->where('payment_type', 'received')->sum('amount');

        $totalMonthlyExpenses = MoneyAccountTransaction::whereBetween('date', [$startOfMonth, $endOfMonth])
            ->where('payment_type', 'paid')->sum('amount');

        $thisMonthProfit = $monthlyEarnings - $totalMonthlyExpenses;

        // Last Month Profit
        $lastMonthEarnings = MoneyAccountTransaction::whereBetween('date', [$startOfLastMonth, $endOfLastMonth])
            ->where('payment_type', 'received')->sum('amount');

        $totalLastMonthExpenses = MoneyAccountTransaction::whereBetween('date', [$startOfLastMonth, $endOfLastMonth])
            ->where('payment_type', 'paid')->sum('amount');

        $lastMonthProfit = $lastMonthEarnings - $totalLastMonthExpenses;

        // New Patients Today
        $newPatients = People::where('type', 'patient')->whereDate('created_at', $today)->count();
        $totalPatients = People::where('type', 'patient')->count();

        // Daily Expenses
        $dailyExpenses = DB::table('expenses')
            ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->selectRaw(
                'expense_categories.name as categoryName, 
                 SUM(expenses.amount) as totalExpense,
                 (SUM(expenses.amount) / (SELECT SUM(amount) FROM expenses WHERE DATE(date) = ?)) * 100 as percentage',
                [$today->format('Y-m-d')]
            )
            ->whereDate('expenses.date', $today)
            ->groupBy('expense_categories.name')
            ->orderByDesc('totalExpense')
            ->get();

        // Monthly Expenses
        $monthlyExpenses = DB::table('expenses')
            ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->selectRaw(
                'expense_categories.name as categoryName,
                 SUM(expenses.amount) as totalExpense,
                 (SUM(expenses.amount) / 
                  (SELECT SUM(amount) FROM expenses WHERE date BETWEEN ? AND ?)) * 100 as percentage',
                [$startOfMonth, $endOfMonth]
            )
            ->whereBetween('expenses.date', [$startOfMonth, $endOfMonth])
            ->groupBy('expense_categories.name')
            ->orderByDesc('totalExpense')
            ->get();

        // Yearly Expenses
        $yearlyExpenses = DB::table('expenses')
            ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->selectRaw(
                'expense_categories.name as categoryName,
                 SUM(expenses.amount) as totalExpense,
                 (SUM(expenses.amount) / 
                  (SELECT SUM(amount) FROM expenses WHERE YEAR(date) = ?)) * 100 as percentage',
                [$currentYear]
            )
            ->whereYear('expenses.date', $currentYear)
            ->groupBy('expense_categories.name')
            ->orderByDesc('totalExpense')
            ->get();

        // Upcoming Appointments
        $upcomingAppointments = DB::table('appointments')
            ->join('people', 'appointments.people_id', '=', 'people.id')
            ->select('people.name', 'people.phone', DB::raw('TIME(appointments.date_time) as time'))
            ->whereDate('appointments.date_time', '>=', $today)
            ->orderBy('appointments.date_time', 'asc')
            ->limit(5)
            ->get();

        // Income and Expense per month for chart
        $everyMonthExpenses = [];
$everyMonthIncomes = [];
$everyMonthProfits = [];

for ($i = 1; $i <= 12; $i++) {
    $expenseAmount = DB::table('money_account_transactions')
        ->whereMonth('date', $i)
        ->whereYear('date', $currentYear)
        ->where('payment_type', 'paid')
        ->sum('amount');

    $incomeAmount = DB::table('money_account_transactions')
        ->whereMonth('date', $i)
        ->whereYear('date', $currentYear)
        ->where('payment_type', 'received')
        ->sum('amount');


    $everyMonthExpenses[$i - 1] = $expenseAmount;
    $everyMonthIncomes[$i - 1] = $incomeAmount;
    $everyMonthProfits[$i - 1] =$incomeAmount - $expenseAmount;
}


        return [
            'thisMonthProfit' => $thisMonthProfit,
            'lastMonthProfit' => $lastMonthProfit,
            'newPatients' => $newPatients,
            'totalPatients' => $totalPatients,
            'totalEarnings' => $totalEarnings,
            'totalAllExpenses' => $totalAllExpenses,
            'netProfit' => $netProfit,
            'dailyExpenses' => $dailyExpenses,
            'monthlyExpenses' => $monthlyExpenses,
            'yearlyExpenses' => $yearlyExpenses,
            'upcomingAppointments' => $upcomingAppointments,
            'monthExpenses' => $everyMonthExpenses,
            'monthIncomes' => $everyMonthIncomes,
            'monthProfits' => $everyMonthProfits
        ];
    }
}

