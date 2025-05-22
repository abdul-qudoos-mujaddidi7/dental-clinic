<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeopleRequest;
use App\Http\Resources\PeopleResource;
use App\Models\People;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeopleController extends Controller
{
    private $model = People::class;
    private $resource = PeopleResource::class;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // Fetch paginated records, applying search and type filters
        $people = $this->listRecord($request, $this->model, ['name','type']);

        return $this->resource::collection($people);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PeopleRequest $request)
    {
        $people = $this->storeRecord($request, $this->model);
        if (in_array($people->type, ['employee', 'doctor'])) {
             Salary::create([
                'people_id' => $people->id,
                'amount' => 0,
            ]);
        };

        return response()->json(["message" => "record stored successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(People $people)
    {
        return new $this->resource($people);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PeopleRequest $request, People $people)
    {
        $people = $this->updateRecord($request, $people);


        return new $this->resource($people);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(People $people)
    {
        $this->deleteRecord($people);

        return response()->json(["message" => "Record deleted successfully"]);
    }

    
}
