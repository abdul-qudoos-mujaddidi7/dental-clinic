<?php

namespace App\Http\Controllers;

use App\Models\BillExpense;
use App\Models\CurePayment;
use App\Models\Expense;
use App\Models\Patient;
use App\Models\People;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        // Initialize date variables
        $today = Carbon::today();
        $currentYear = Carbon::now()->year;
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        // Jalali equivalents
        $jalaliToday = Jalalian::fromCarbon($today)->format('Y-m-d');
        $jalaliStartOfMonth = Jalalian::fromCarbon($startOfMonth)->format('Y-m-d');
        $jalaliEndOfMonth = Jalalian::fromCarbon($endOfMonth)->format('Y-m-d');
        $jalaliStartOfLastMonth = Jalalian::fromCarbon($startOfLastMonth)->format('Y-m-d');
        $jalaliEndOfLastMonth = Jalalian::fromCarbon($endOfLastMonth)->format('Y-m-d');
        $currentJalaliYear = Jalalian::now()->format('Y-m-d');


        // Earnings and Expenses for Today
        $todayEarning = CurePayment::whereDay('date', $jalaliToday)
            ->whereNull('deleted_at')
            ->sum('amount');

        $todayExpense = Expense::whereDay('date', $jalaliToday)
            ->whereNull('deleted_at')
            ->sum('amount');

        // Total today's expenses including bill expenses
        $todayBillExpense = DB::table('bill_expenses')
            ->whereDay('created_at', $jalaliToday)
            ->whereNull('deleted_at')
            ->sum('grand_total');

        $totalTodayExpense = $todayExpense + $todayBillExpense;

        // Calculate today's net profit
        $netProfitToday = $todayEarning - $totalTodayExpense;

        // All-time earnings and expenses
        $totalEarnings = CurePayment::whereNull('deleted_at')->sum('amount');

        $totalExpenses = Expense::whereNull('deleted_at')->sum('amount');
        $totalBillableExpenses = BillExpense::whereNull('deleted_at')->sum('grand_total');

        $totalAllExpenses = $totalExpenses + $totalBillableExpenses;

        // Calculate total net profit
        $netProfit = $totalEarnings - $totalAllExpenses;

        // Monthly Earnings and Expenses
        $monthlyEarnings = CurePayment::whereBetween('date', [$jalaliStartOfMonth, $jalaliEndOfMonth])
            ->whereYear('created_at', $currentJalaliYear)
            ->whereNull('deleted_at')
            ->sum('amount');

        $monthlyExpenses = Expense::whereBetween('date', [$jalaliStartOfMonth, $jalaliEndOfMonth])
            ->whereYear('date',  $currentJalaliYear)
            ->whereNull('deleted_at')
            ->sum('amount');

        $monthlyBillableExpenses = BillExpense::whereBetween('bill_date', [$jalaliStartOfMonth, $jalaliEndOfMonth])
            ->whereYear('bill_date', $currentJalaliYear)
            ->whereNull('deleted_at')
            ->sum('grand_total');

        $totalMonthlyExpenses = $monthlyExpenses + $monthlyBillableExpenses;
        $thisMonthProfit = $monthlyEarnings - $totalMonthlyExpenses;


        // Get the first and last day of the previous month


        // Earnings for Last Month
        $lastMonthEarnings = CurePayment::whereBetween('date', [$jalaliStartOfMonth, $endOfLastMonth])
            ->whereYear('created_at', $currentYear)
            ->whereNull('deleted_at')
            ->sum('amount');

        // Expenses for Last Month
        $lastMonthExpenses = Expense::whereBetween('date', [$jalaliStartOfMonth, $endOfLastMonth])
            ->whereYear('created_at', $currentJalaliYear)
            ->whereNull('deleted_at')
            ->sum('amount');

        // Billable Expenses for Last Month
        $lastMonthBillableExpenses = BillExpense::whereBetween('bill_date', [$jalaliStartOfMonth, $endOfLastMonth])
            ->whereYear('bill_date',  $currentJalaliYear)
            ->whereNull('deleted_at')
            ->sum('grand_total');

        // Total Expenses for Last Month
        $totalLastMonthExpenses = $lastMonthExpenses + $lastMonthBillableExpenses;

        // Calculate Last Month's Profit
        $lastMonthProfit = $lastMonthEarnings - $totalLastMonthExpenses;


        // Count new patients added today
        $newPatients = People::where('type', 'patient')->whereDay('created_at', $today)->count();
        // Total number of patients
        $totalPatients = People::where('type', 'patient')->count();

        $dailyExpenses = DB::table('expenses')
            ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->selectRaw('expense_categories.name as categoryName, SUM(expenses.amount) as totalExpense, 
         (SUM(expenses.amount) / (SELECT SUM(amount) FROM expenses WHERE DATE(created_at) = ?)) * 100 as percentage', [$jalaliToday])
            ->whereDate('expenses.date', $jalaliToday)
            ->groupBy('expense_categories.name')
            ->orderBy('totalExpense', 'desc')
            ->get();

        // Monthly Expenses
        $monthlyExpenses = DB::table('expenses')
            ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->selectRaw('expense_categories.name as categoryName, SUM(expenses.amount) as totalExpense, 
         (SUM(expenses.amount) / (SELECT SUM(amount) FROM expenses WHERE YEAR(created_at) = ? AND created_at BETWEEN ? AND ?)) * 100 as percentage', [now()->year, $jalaliStartOfMonth, $jalaliEndOfMonth])
            ->whereYear('expenses.created_at',  $currentJalaliYear)
            ->whereBetween('expenses.date', [$jalaliStartOfMonth, $jalaliEndOfMonth])
            ->groupBy('expense_categories.name')
            ->orderBy('totalExpense', 'desc')
            ->get();

        // Yearly Expenses
        $yearlyExpenses = DB::table('expenses')
            ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->selectRaw('expense_categories.name as categoryName, SUM(expenses.amount) as totalExpense, 
         (SUM(expenses.amount) / (SELECT SUM(amount) FROM expenses WHERE YEAR(created_at) = ?)) * 100 as percentage', [$currentJalaliYear])
            ->whereYear('expenses.date',  $currentJalaliYear)
            ->groupBy('expense_categories.name')
            ->orderBy('totalExpense', 'desc')
            ->get();

        // Upcoming Appointments
        $upcomingAppointments = DB::table('appointments')
            ->join('people', 'appointments.people_id', '=', 'people.id')
            ->select('people.name', 'people.phone', DB::raw('TIME(appointments.date_time) as time'))
            ->whereDate('appointments.date_time', '>=', $currentJalaliYear)
            ->orderBy('time', 'asc')
            ->limit(5)
            ->get();


        $everyMonthExpenses = [];
        $everyMonthIncomes = []; // Array to hold monthly data

        for ($i = 0; $i < 12; $i++) {
            // Calculate total expenses for the month
            $expenseAmount = DB::table('expenses')
                ->whereMonth('date', $i + 1)
                ->whereYear('date',  $currentJalaliYear) // Filter by current year
                ->sum('amount');

            // Calculate total bill expenses for the month
            $billExpenseAmount = DB::table('bill_expenses')
                ->whereMonth('created_at', $i + 1)
                ->whereYear('bill_date', $currentJalaliYear) // Filter by current year
                ->sum('grand_total');

            // Calculate total income for the month
            $incomeAmount = DB::table('cure_payments') // Assuming you have an 'incomes' table
                ->whereMonth('date', $i + 1)
                ->whereYear('date',  $currentJalaliYear) // Filter by current year
                ->sum('amount');

            $everyMonthIncomes[$i] = $incomeAmount;
            $everyMonthExpenses[$i] = $expenseAmount + $billExpenseAmount;
        }


        // Return the results
        return [
            'thisMonthProfit' => $thisMonthProfit,
            'lastMonthProfit' => $lastMonthProfit,
            'todayEarning' => $todayEarning,
            'totalTodayExpense' => $totalTodayExpense,
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
            'monthIncomes' => $everyMonthIncomes
        ];
    }
}
