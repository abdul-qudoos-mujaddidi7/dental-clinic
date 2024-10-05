<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;

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
        $payment=Payment::create($validated);
        return new PaymentResource($payment);

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

        $payment->update($validated);
        return new PaymentResource($payment);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return new PaymentResource($payment);
    }
}
