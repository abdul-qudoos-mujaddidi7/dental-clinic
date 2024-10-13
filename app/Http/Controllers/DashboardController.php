<?php

namespace App\Http\Controllers;


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

        // Earnings and Expenses for Today
        $todayEarning = CurePayment::whereDay('date', $today)
            ->whereNull('deleted_at')
            ->sum('amount');

        $todayExpense = Expense::whereDay('date', $today)
            ->whereNull('deleted_at')
            ->sum('amount');

        $todayBillExpense = Payment::whereDay('date', $today)
            ->whereNull('deleted_at')
            ->sum('amount');

        // Total today's expenses (including billable)
        $totalTodayExpense = $todayExpense + $todayBillExpense;

        // All earnings (total)
        $totalEarnings = CurePayment::whereNull('deleted_at')->sum('amount');

        // All expenses (total)
        $totalExpenses = Expense::whereNull('deleted_at')->sum('amount');
        $totalBillableExpenses = Payment::whereNull('deleted_at')->sum('amount');
        $totalAllExpenses = $totalExpenses + $totalBillableExpenses;

        // Calculate net profit
        $netProfit = $totalEarnings - $totalAllExpenses;

        $monthlyEarnings = CurePayment::whereBetween('date', [$startOfMonth, $endOfMonth])
            ->whereNull('deleted_at')
            ->sum('amount');

        // Monthly Expenses

        $monthlyExpenses = Expense::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereNull('deleted_at')
            ->sum('amount');

        $monthlyBillableExpenses = Payment::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereNull('deleted_at')
            ->sum('amount');

        // Total Monthly Expenses
        $totalMonthlyExpenses = $monthlyExpenses + $monthlyBillableExpenses;

        // Calculate Monthly Profit
        $monthlyProfit = $monthlyEarnings - $totalMonthlyExpenses;

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
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
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

        // Return the results
        return [
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
            'monthlyProfit' => $monthlyProfit
        ];
    }
}
