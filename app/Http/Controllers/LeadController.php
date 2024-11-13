<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadRequest;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage= $request->input("perPage");
        $search= $request->input("search");

        $lead= Lead::with(['category','stage'])->search($search)->latest()->paginate($perPage);
        return LeadResource::collection($lead);
    }

  

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeadRequest $request)
    {
        $validated= $request->validated();
        $lead= Lead::create($validated);
        return new LeadResource($lead);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        return LeadResource::make($lead);
    }

  

    /**
     * Update the specified resource in storage.
     */
    public function update(LeadRequest $request, Lead $lead)
    {
        $validated= $request->validated();
        $lead->update($validated);
        return new LeadResource($lead);
    }

    public function updateStage(Request $request, Lead $lead)
{
    // Validate the request
    $validated = $request->validate([
        'stageId'=>'required|exists:stages,id'
    ]);
    if ($lead) {
        $lead->stage_id = $validated['stageId'];
        $lead->save();
    }

    return new LeadResource($lead);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();
        return new LeadResource($lead);
    }
}
