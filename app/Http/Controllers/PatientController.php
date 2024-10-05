<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage= $request->input("perPage");
        $search= $request->input("search");

        $patient= Patient::search($search)->latest()->paginate($perPage);
        return PatientResource::collection($patient);
    }

  

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientRequest $request)
    {
        $validated= $request->validated();
        $patient= Patient::create($validated);
        return new PatientResource($patient);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return dd($patient->diseases_history);
    
    }

  

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientRequest $request, Patient $patient)
    {
        $validated= $request->validated();
        $patient->update($validated);
        return new PatientResource($patient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return new PatientResource($patient);
    }
}
