<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadRequest;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeadController extends Controller
{

    private $model = Lead::class;
    private $resource = LeadResource::class;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $perPage= $request->input("perPage");
        // $search= $request->input("search");
        return $this->resource::collection($this->listRecord($request,$this->model,['name'],['category','stage']));

        // $lead= Lead::with(['category','stage'])->search($search)->latest()->paginate($perPage);
        // return LeadResource::collection($lead);
    }

  

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeadRequest $request)
    {
        $lead= $this->storeRecord($request,Lead::class);
        return new LeadResource($lead);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        return $this->resource::make($lead);
    }

  

    /**
     * Update the specified resource in storage.
     */
    public function update(LeadRequest $request, Lead $lead)
    {
        $validated= $request->validated();
        $lead=$this->updateRecord($request,$lead);
        return new $this->resource($lead);
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
        $this->deleteRecord($lead);
        return new LeadResource($lead);
    }


    public function bulkDelete(Request $request)
    {
        $validated= $request->validate([
            "leadIds"=>"required|array",
            "leadIds.*"=>"required|exists:leads,id"
        ]);

        Lead::whereIn('id',$validated['leadIds'])->delete();

        return response()->noContent();



    }
}
