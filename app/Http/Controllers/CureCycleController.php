<?php

namespace App\Http\Controllers;

use App\Http\Requests\CureCycleRequest;
use App\Http\Resources\CureCycleResource;
use App\Models\Cure;
use App\Models\CureCycle;
use Illuminate\Http\Request;

class CureCycleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input("perPage");
        $search = $request->input("search");
        $cure = $request->input("cure");

        $cycles = CureCycle::with("cure")->search($search, $cure)->latest()->paginate($perPage);
        return CureCycleResource::collection($cycles);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(CureCycleRequest $request)
    {
        $validated = $request->validated();
        $cure = Cure::findOrFail($validated["cure_id"]);

        // Get the latest appointment for the patient associated with the cure
        $appointment = $cure->patient->appointments()->latest()->first();
        $validated['appointment_id'] = $appointment->id;

        $cureCycle = CureCycle::create($validated);
        return new CureCycleResource($cureCycle);
    }


    /**
     * Display the specified resource.
     */
    public function show($cure)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(CureCycleRequest $request, CureCycle $cureCycle)
    {
        $validated = $request->validated();
        $cure = Cure::findOrFail($validated["cure_id"]);

        // Get the latest appointment for the patient associated with the cure
        $appointment = $cure->patient->appointments()->latest()->first();
        $validated['appointment_id'] = $appointment->id;
        $cureCycle->update($validated);
        return new CureCycleResource($cureCycle);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CureCycle $cycle)
    {
        $cycle->delete();
        return new CureCycleResource($cycle);
        
    }
}
