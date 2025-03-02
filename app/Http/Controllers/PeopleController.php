<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeopleRequest;
use App\Http\Resources\PeopleResource;
use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input("perPage", 10);
        $search = $request->input("search");
        $type = $request->input("type");
    
        $peoples = People::where('type', $type)
            ->search($search)
            ->latest()
            ->paginate($perPage);
    
        return PeopleResource::collection($peoples);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PeopleRequest $request)
    {
        $people=$this->storeRecord($request,People::class);
        return response()->json(["message"=>"record stored successfully"]);

    }

    /**
     * Display the specified resource.
     */
    public function show(People $people)
    {
        return new PeopleResource($people);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PeopleRequest $request, People $people)
    {
        $validated = $request->validated();
        $people->update($validated);
        return new PeopleResource($people);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(People $people)
    {
        $people->delete();

        return response()->json(["message"=>"record deleted successfully"]);;
    }
}
