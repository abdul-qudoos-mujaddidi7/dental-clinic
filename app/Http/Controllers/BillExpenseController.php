<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillExpenseRequest;
use App\Http\Resources\BillExpenseResource;
use App\Models\BillExpense;
use App\Models\BillExpenseDetail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\PeopleAccount;

class BillExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage');
        $search = $request->input('search');

        $BillExp = BillExpense::with(['supplier', 'user', 'billExpenseDetails'])
                              ->search($search)
                              ->latest()
                              ->paginate($perPage);
        return BillExpenseResource::collection($BillExp);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BillExpenseRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id() ?? 1;  // Use Auth for user identification
        
        // Use transaction to ensure atomicity
        DB::transaction(function () use ($validated,$request) {

            // Create BillExpense
            $supplier = $validated['supplier_id'];
            $peopleAccount = PeopleAccount::where('people_id', $supplier)->first();
        if(!$peopleAccount){
           $peopleAccount = PeopleAccount::create([
                'name' => 'حساب افغانی',
                'people_id' => $supplier,
                'balance' => 0,
            ]);
        };

        $validated['people_account_id'] = $peopleAccount->id ;
        $billExpense = billExpense::create($validated);

            // Insert BillExpenseDetails
            foreach ($validated['billable_details'] as $detail) {
                BillExpenseDetail::create([
                    'bill_expense_id' => $billExpense->id,
                    'product_id' => $detail['expenseProduct'],
                    'quantity' => $detail['quantity'],
                    'cost' => $detail['cost'],
                    'total' => $detail['total'],
                ]);
            }

            // If 'paid' is set in request, create Payment
            if ($request->has('paid')) {
                Payment::create([
                    'bill_expense_id' => $billExpense->id,
                    'amount' => $validated['paid'],
                    'date' => $validated['bill_date'],
                    'user_id' => Auth::id() ?? 1  // Add user_id to payment
                ]);
            }
        });

        return response()->json(['message' => 'Record stored successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(BillExpense $billExpense)
    {
        // Eager load the 'billExpenseDetails' relationship
        $billExpense->load('billExpenseDetails');

        return BillExpenseResource::make($billExpense);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BillExpenseRequest $request, BillExpense $billExpense)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id() ?? 1;  // Use Auth for user identification

        // Use transaction to ensure atomicity
        DB::transaction(function () use ($validated, $billExpense,$request) {
            // Update BillExpense
            $billExpense->update($validated);

            // Update or create BillExpenseDetails
            foreach ($validated['billable_details'] as $detail) {
                BillExpenseDetail::updateOrCreate(
                    ['id' => $detail['id'] ?? null],
                    [
                        'bill_expense_id' => $billExpense->id,
                        'quantity' => $detail['quantity'],
                        'product_id' => $detail['productId'],
                        'cost' => $detail['cost'],
                        'total' => $detail['total'],
                    ]
                );
            }
            // Update or create Payment
            Payment::updateOrCreate(
                ['bill_expense_id' => $billExpense->id], // Search condition
                [
                    'amount' => $validated['paid'],
                    'date' => $validated['bill_date'],
                    'user_id' => Auth::id() ?? 1  // Add user_id to payment
                ]
            );

            // $cure->update($validated);
            // CurePayment::updateOrCreate(
            //     ['cure_id' => $cure->id], // Search condition
            //     ['amount' => $validated['paid'], 'date' => $validated['start_date']] // Data to update or insert
            // );
            

            // Handle deleted BillExpenseDetails
            if ($request['deletedIds']) {
                foreach ($request['deletedIds'] as $id) {
                    BillExpenseDetail::destroy($id);
                }
            }
        });

        return response()->json(['message' => 'Record updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillExpense $billExpense)
    {
        // Step 1: Use transaction to ensure atomicity
        DB::transaction(function () use ($billExpense) {
            // Delete associated BillExpenseDetail records
            BillExpenseDetail::where('bill_expense_id', $billExpense->id)->delete();

            // Step 2: Delete the BillExpense record itself
            $billExpense->delete();
        });

        return response()->json(['message' => 'Record deleted successfully.']);
    }

    /**
     * Bulk delete BillExpense records.
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'billExpenseIds' => 'required|array',
            'billExpenseIds.*' => 'required|exists:bill_expenses,id'
        ]);

        DB::transaction(function () use ($validated) {
            // Bulk delete BillExpense and associated details
            BillExpense::whereIn('id', $validated['billExpenseIds'])->delete();
        });

        return response()->noContent();
    }
}
