<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillExpenseRequest;
use App\Http\Resources\BillExpenseResource;
use App\Models\BillExpense;
use App\Models\BillExpenseDetail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage=$request->input('perPage');
        $search=$request->input('search');

        $BillExp=BillExpense::with(['supplier','user','billExpenseDetails'])->search($search)->latest()->paginate($perPage);
        return BillExpenseResource::collection($BillExp);
    }

  

    /**
     * Store a newly created resource in storage.
     */
    public function store(BillExpenseRequest $request)
    {

        $validated=$request->validated();
        $validated['user_id'] = Auth::id()?? 1;
        $billExpense = BillExpense::create($validated);
        foreach($validated['billable_details'] as $detail){

                BillExpenseDetail::create([
                    'bill_expense_id' => $billExpense->id,
                    'product_id' => $detail['product_id'],
                    'quantity' => $detail['quantity'],
                    'cost' => $detail['cost'],
                    'total' => $detail['total'],
                ]);

            };
          
        return response()->json(['message'=>'record stored successfully.']);
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
    public function update(BillExpenseRequest $request,BillExpense $billExpense)
    {
        
        $validated=$request->validated();
        $validated['user_id'] = Auth::id()?? 1;
        $billExpense->update($validated);
        foreach($validated['billable_details'] as $detail){

            BillExpenseDetail::updateOrCreate(
                [
                    'bill_expense_id' => $billExpense->id,
                    'product_id' => $detail['product_id'],
                ],
                [
                    'quantity' => $detail['quantity'],
                    'cost' => $detail['cost'],
                    'total' => $detail['total'],
                ]
            );
            // First Array: The code looks for an existing record that matches these values.
            // Second Array:These are the values to update if a matching record is found. If
            // no matching record is found, these values will be used to create a new record.
            };


            if ($request['deletedIds']){
                foreach($request['deletedIds'] as $id){
                    BillExpenseDetail::destroy($id);
                }}


        return response()->json(['message'=>'record updated successfully.']);



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillExpense $billExpense)
{
    // Step 1: Delete associated BillExpenseDetail records
    BillExpenseDetail::where('bill_expense_id', $billExpense->id)->delete();

    // Step 2: Delete the BillExpense record itself
    $billExpense->delete();

    // Step 3: Return a JSON response indicating the deletion was successful
    return response()->json(['message' => 'Record deleted successfully.']);
}

}
