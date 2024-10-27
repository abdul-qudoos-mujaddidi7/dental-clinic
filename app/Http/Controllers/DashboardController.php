<?php

namespace App\Http\Controllers;

use App\Models\BillExpense;
use App\Models\CurePayment;
use App\Models\Expense;
use App\Models\Patient;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Earnings and Expenses for Today
        $todayEarning = CurePayment::whereDay('date', $today)
            ->whereNull('deleted_at')
            ->sum('amount');

        $todayExpense = Expense::whereDay('date', $today)
            ->whereNull('deleted_at')
            ->sum('amount');

        // Total today's expenses including bill expenses
        $todayBillExpense = DB::table('bill_expenses')
            ->whereDay('created_at', $today)
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
        $monthlyEarnings = CurePayment::whereBetween('date', [$startOfMonth, $endOfMonth])
            ->whereYear('created_at', $currentYear)
            ->whereNull('deleted_at')
            ->sum('amount');

        $monthlyExpenses = Expense::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereYear('created_at', $currentYear)
            ->whereNull('deleted_at')
            ->sum('amount');

        $monthlyBillableExpenses = BillExpense::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereYear('created_at', $currentYear)
            ->whereNull('deleted_at')
            ->sum('grand_total');

        $totalMonthlyExpenses = $monthlyExpenses + $monthlyBillableExpenses;
        $thisMonthProfit = $monthlyEarnings - $totalMonthlyExpenses;


        // Get the first and last day of the previous month
        

        // Earnings for Last Month
        $lastMonthEarnings = CurePayment::whereBetween('date', [$startOfLastMonth, $endOfLastMonth])
            ->whereYear('created_at', $currentYear)
            ->whereNull('deleted_at')
            ->sum('amount');

        // Expenses for Last Month
        $lastMonthExpenses = Expense::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->whereYear('created_at', $currentYear)
            ->whereNull('deleted_at')
            ->sum('amount');

        // Billable Expenses for Last Month
        $lastMonthBillableExpenses = BillExpense::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->whereYear('created_at', $currentYear)
            ->whereNull('deleted_at')
            ->sum('grand_total');

        // Total Expenses for Last Month
        $totalLastMonthExpenses = $lastMonthExpenses + $lastMonthBillableExpenses;

        // Calculate Last Month's Profit
        $lastMonthProfit = $lastMonthEarnings - $totalLastMonthExpenses;


        // Count new patients added today
        $newPatients = Patient::whereDay('created_at', $today)->count();

        // Total number of patients
        $totalPatients = Patient::count();

        // Daily Expenses
        $dailyExpenses = DB::table('expenses')
            ->selectRaw('expense_category_id, SUM(amount) as totalExpense')
            ->whereDate('created_at', $today)
            ->groupBy('expense_category_id')
            ->orderBy('created_at', 'desc')
            ->get();

        // Monthly Expenses
        $monthlyExpenses = DB::table('expenses')
            ->selectRaw('expense_category_id, SUM(amount) as totalExpense')
            ->whereYear('created_at', now()->year) // Filter for the current year
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth]) // Filter for the current month range
            ->groupBy('expense_category_id')
            ->orderBy('created_at', 'desc')
            ->get();


        // Yearly Expenses
        $yearlyExpenses = DB::table('expenses')
            ->selectRaw('expense_category_id, SUM(amount) as totalExpense')
            ->whereYear('created_at', $currentYear)
            ->groupBy('expense_category_id')
            ->orderBy('created_at', 'desc')
            ->get();

        // Upcoming Appointments
        $upcomingAppointments = DB::table('appointments')
            ->join('patients', 'appointments.patient_id', '=', 'patients.id') // Join with the patients table
            ->select('patients.name', 'patients.phone', 'appointments.time') // Select the patient's name and appointment time
            ->whereDate('appointments.created_at', $today) // Filter by today's date
            ->orderBy('appointments.time', 'asc') // Order by appointment time
            ->limit(5) // Limit to 5 appointments
            ->get();

        $everyMonthExpenses = [];
        $everyMonthIncomes = []; // Array to hold monthly data

        for ($i = 0; $i < 12; $i++) {
            // Calculate total expenses for the month
            $expenseAmount = DB::table('expenses')
                ->whereMonth('date', $i + 1)
                ->whereYear('date', $currentYear) // Filter by current year
                ->sum('amount');

            // Calculate total bill expenses for the month
            $billExpenseAmount = DB::table('bill_expenses')
                ->whereMonth('created_at', $i + 1)
                ->whereYear('bill_date', $currentYear) // Filter by current year
                ->sum('grand_total');

            // Calculate total income for the month
            $incomeAmount = DB::table('cure_payments') // Assuming you have an 'incomes' table
                ->whereMonth('date', $i + 1)
                ->whereYear('date', $currentYear) // Filter by current year
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
            'totalAllEarnings' => $totalEarnings,
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
