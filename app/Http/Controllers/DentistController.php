<?php

namespace App\Http\Controllers;

use App\Http\Requests\DentistRequest;
use App\Http\Resources\DentistResource;
use App\Models\Dentist;
use Illuminate\Http\Request;

class DentistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage= $request->input("perPage");
        $search= $request->input("search");

        $dentists= Dentist::search($search)->latest()->paginate($perPage);
        return DentistResource::collection($dentists);
        
    }

  

    /**
     * Store a newly created resource in storage.
     */
    public function store(DentistRequest $request)
    {
        $validated= $request->validated();
        $dentist= Dentist::create($validated);
        return new DentistResource($dentist);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dentist $dentist)
    {
        return  DentistResource::make($dentist);
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(DentistRequest $request, Dentist $dentist)
    {
        $validated= $request->validated();
        $dentist->update($validated);
        return new DentistResource($dentist);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dentist $dentist)
    {
        $dentist->delete();
        return new DentistResource($dentist);
    }
}
