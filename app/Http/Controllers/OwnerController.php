<?php

namespace App\Http\Controllers;


use App\Http\Requests\OwnerRequest;
use App\Http\Resources\OwnerResource;
use Illuminate\Http\Request;
use App\Models\Owner;
use App\Traits\ImageHandler;

class OwnerController extends Controller
{
    use ImageHandler;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage= $request->input("perPage");
        $search= $request->input("search");

        $owners= Owner::search($search)->latest()->paginate($perPage);
        return OwnerResource::collection($owners);
        
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
