<?php

namespace App\Http\Controllers;

use App\Http\Requests\StageRequest;
use App\Http\Resources\StageResource;
use App\Models\Stage;
use Illuminate\Http\Request;

class StageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input("perPage", 5);
        $search = $request->input("search");
        // $stages = Stage::with('leads')
        $stages = Stage::selectRaw("stages.name, MAX(stages.id) as id, COUNT(leads.id) as leads_count")
            ->leftJoin('leads', 'stages.id', '=', 'leads.stage_id')
            ->groupBy('stages.name');




        $stages=$stages->search($search)->orderBy('stages.name', 'asc')->paginate($perPage);    

        return StageResource::collection($stages);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StageRequest $request)
    {
        $validated = $request->validated();
        $lead = Stage::create($validated);
        return new StageResource($lead);
    }

    /**
     * Display the specified resource.
     */
    public function show(Stage $stage)
    {
        return StageResource::make($stage);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(StageRequest $request, Stage $stage)
    {
        $validated = $request->validated();
        $stage->update($validated);
        return new StageResource($stage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stage $stage)
    {
        $stage->delete();
        return new StageResource($stage);
    }
}
