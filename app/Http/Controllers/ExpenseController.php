<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Resources\ExpenseResource;
use Illuminate\Support\Facades\Auth;


class ExpenseController extends Controller
{
    function __construct()
    {
        $this->middleware("can:viewExpense")->only(["index", "show"]);
        $this->middleware("can:addExpense")->only('store');
        $this->middleware("can:updateExpense")->only('update');
        $this->middleware("can:deleteExpense")->only('destroy');

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage=$request->input('perPage');
        $search=$request->input('search');

        $Expenses=Expense::with('expenseCategory')->search($search)->latest()->paginate($perPage);
        return ExpenseResource::collection($Expenses);

        
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id()?? 1;
        Expense::create($validated);

        return response()->json(["message"=>"record stored successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
         return ExpenseResource::make($expense);
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseRequest $request, Expense $expense)
    {
        $validated=$request->validated();
        $validated['user_id'] = Auth::id()?? 1;
        $expense->update($validated);
        return response()->json(["message" => "record updated successfully"]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return response()->json(["message" => "record deleted successfully"]);
    }
}
