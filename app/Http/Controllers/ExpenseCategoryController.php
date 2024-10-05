<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseCategoryRequest;
use App\Http\Resources\ExpenseCategoryResource;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input("perPage");
        $search = $request->input("search");

        $ExpCategories = ExpenseCategory::search($search)->latest()->paginate($perPage);
        return ExpenseCategoryResource::collection($ExpCategories);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseCategoryRequest $request)
    {
        $validated = $request->validated();
        ExpenseCategory::create($validated);
        return response()->json(["message" => "record stored successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        return ExpenseCategoryResource::make($expenseCategory);
    }

  
    /**
     * Update the specified resource in storage.
     */
    public function update(ExpenseCategoryRequest $request, ExpenseCategory $expenseCategory)
    {
        $validated = $request->validated();
        $expenseCategory->update($validated);
        
        return response()->json(['message'=>'ExpenseCategory updated successfully.']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();
        return response()->json(["message" => "record deleted successfully"]);
    }
}
