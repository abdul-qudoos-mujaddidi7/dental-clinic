<?php

namespace App\Http\Controllers;


use App\Http\Requests\OwnerPickupRequest;
use App\Http\Resources\OwnerPickupResource;
use Illuminate\Http\Request;
use App\Models\OwnerPickup;

class OwnerPickupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage= $request->input("perPage");
        $search= $request->input("search");

        $ownerPickups= OwnerPickup::search($search)->latest()->paginate($perPage);
        return OwnerPickupResource::collection($ownerPickups);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OwnerPickupRequest $request)
    {
        $validated= $request->validated();
        $ownerPickup= OwnerPickup::create($validated);
        return new OwnerPickupResource($ownerPickup);
    }

    /**
     * Display the specified resource.
     */
    public function show(OwnerPickup $ownerPickup)
    {
        return OwnerPickupResource::make($ownerPickup);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OwnerPickupRequest $request, OwnerPickup $ownerPickup)
    {
        $validated= $request->validated();
        $ownerPickup->update($validated);
        return new OwnerPickupResource($ownerPickup);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OwnerPickup $ownerPickup)
    {
        $ownerPickup->delete();
        return new OwnerPickupResource($ownerPickup);
    }
}
