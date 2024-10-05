<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $perPage=$request->input('perPage');
       $search=$request->input('search');
       
       $Suppliers=Supplier::search($search)->latest()->paginate($perPage);
       return SupplierResource::collection($Suppliers);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        $validated = $request->validated();
        Supplier::create($validated);
        return response()->json(['message'=>'record stored succefully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return SupplierResource::make($supplier);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierRequest $request,Supplier $supplier)
    {
        $validated=$request->validated();
        $supplier->update($validated);

        return response()->json(['message'=>'Supplier updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return response()->json(['message'=>'Supplier deleted successfully.']);


    }
}
