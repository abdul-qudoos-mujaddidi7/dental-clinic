<?php

namespace App\Http\Controllers;

use App\Http\Requests\StageRequest;
use App\Http\Resources\StageResource;
use App\Models\Stage;
use Illuminate\Http\Request;

class StageController extends Controller
{

    private $model = Stage::class;
    private $resource = StageResource::class;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        return $this->resource::collection($this->listRecord($request,$this->model,['name']));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StageRequest $request)
    {
        $lead = $this->storeRecord($request, Stage::class);
        return new $this->resource($lead);
    }

    /**
     * Display the specified resource.
     */
    public function show(Stage $stage)
    {
        return new $this->resource($stage);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(StageRequest $request, Stage $stage)
    {
        
        $stage = $this->updateRecord($request, $stage);
        return new $this->resource($stage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stage $stage)
    {
        $this->deleteRecord($stage);
        return new $this->resource($stage);
    }
}
