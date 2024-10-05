<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurePaymentRequest;

use App\Http\Resources\CurePaymentResource;
use App\Models\Cure;
use App\Models\CurePayment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input("perPage");
        $search = $request->input("search");
        $cure = $request->input("cure");

        $curePayments = CurePayment::with('cure')->search($search,$cure)->latest()->paginate($perPage);
        return CurePaymentResource::collection($curePayments);
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(CurePaymentRequest $request)
    {
        $validated = $request->validated();

        $curePayment = DB::transaction(function () use ($validated) {
            // Find the cure related to the payment
            $cure = Cure::findOrFail($validated['cure_id']);

            $paid = $cure->paid + $validated['amount'];
            $cure->update(['paid' => $paid]);
    
            // Create the new CurePayment entry
            return CurePayment::create($validated); 
        });

        // A database transaction is a sequence of one or more SQL operations
        //  that are treated as a single unit of work.
        // Using DB::transaction() is a best practice when performing multiple 
        // related database operations that should be treated as a single unit 
        // of work. It helps maintain data integrity, ensures consistent application
        //  of changes, and simplifies error handling, making your application more robust.

        return new CurePaymentResource($curePayment);
        

       
    }

    public function show(CurePayment $curePayment)
    {
        return CurePaymentResource::make($curePayment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CurePaymentRequest $request, CurePayment $curePayment)
    {
        
        $validated = $request->validated();
    
        // Perform the update within a transaction
        DB::transaction(function () use ($validated, $curePayment) {
            // Find the cure related to the payment
            $cure = Cure::findOrFail($validated['cure_id']);
    
            // Update the paid amount
            $paid = $cure->paid + $validated['amount'];
            $cure->update(['paid' => $paid]);
    
            // Update the CurePayment entry
            $curePayment->update($validated); 
        });
    
        // Return the updated CurePayment with the resource
        return new CurePaymentResource($curePayment);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CurePayment $curePayment)
    {

        // Delete the CurePayment
        $curePayment->delete();

        return new CurePaymentResource($curePayment);
    }
}
