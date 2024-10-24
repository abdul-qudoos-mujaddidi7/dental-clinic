<?php

namespace App\Http\Controllers;


use App\Http\Requests\OwnerRequest;
use App\Http\Resources\OwnerResource;
use Illuminate\Http\Request;
use App\Models\Owner;
use App\Traits\ImageHandler;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    use ImageHandler;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $perPage = $request->input("perPage",5);
    $search = $request->input("search");

    // Query for owner pickups with total amounts
    $ownerPickup = DB::table('owner_pickups')
        ->selectRaw('owners.first_name, owners.phone, SUM(amount) as totalAmount')
        ->leftJoin('owners', 'owner_pickups.owner_id', '=', 'owners.id')
        ->groupBy('owner_pickups.owner_id', 'owners.first_name','owners.phone');

        if($search){
            $ownerPickup->search($search);
        }

        $ownerPickupPaginated=$ownerPickup->latest('owner_pickups.created_at')->paginate($perPage);

    return  $ownerPickupPaginated;
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(OwnerRequest $request)
    {
        $validated= $request->validated();
        $validated['image'] = $request->hasFile('image') ? $this->storeImage($request,'owner'):null;
        $owner= Owner::create($validated);
        return new OwnerResource($owner);
    }

    /**
     * Display the specified resource.
     */
    public function show(Owner $owner)
    {
        return OwnerResource::make($owner);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateOwner(OwnerRequest $request, Owner $owner)
    {
        $validated= $request->validated();
        $validated['image'] = $request->hasFile('image') ? $this->updateImage($request,$$owner,'owner'): null;
        $owner->update($validated);
        return new OwnerResource($owner);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Owner $owner)
    {
        $this->deleteImage($owner);
        $owner->delete();
        return new OwnerResource($owner);
    }
}
