<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Resources\BillExpenseResource;
use App\Http\Resources\PaymentResource;
use App\Models\BillExpense;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage= $request->input("perPage");
        $search= $request->input("search");

        $payments= Payment::with(["billExpense","user"])->search($search)->latest()->paginate($perPage);
        return PaymentResource::collection($payments);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $request)
    {
        $validated= $request->validated();
        $validated['user_id'] = Auth()->id() ?? 1;
        $billPayment = DB::transaction(function () use ($validated) {
            // Find the cure related to the payment
            $billExpense = BillExpense::findOrFail($validated['bill_expense_id']);

            $paid = $billExpense->paid + $validated['amount'];
            $billExpense->update(['paid' => $paid]);
    
            // Create the new CurePayment entry
            return Payment::create($validated); 
        });

        

        return new PaymentResource($billPayment);


    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return PaymentResource::make($payment);
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Payment $payment, PaymentRequest $request)
    {
        $validated= $request->validated();
        $validated['user_id'] = Auth()->id() ?? 1;
        $billExpense = $payment->billExpense; 
        $paid =$billExpense->paid + $validated['amount'] - $payment->amount;
        $billExpense->update(['paid' => $paid]);
        $payment->update($validated);
        return new PaymentResource($payment);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $billExpense = $payment->billExpense; 
        if ($billExpense) {
            // Update the 'paid' column of the Cure
            $billExpense->paid -= $payment->amount;
            $billExpense->save();
        }
        $payment->delete();
        return new PaymentResource($payment);
    }
}
