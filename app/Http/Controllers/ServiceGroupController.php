<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceGroupRequest;
use App\Http\Resources\ServiceGroupResource;
use App\Models\Service;
use App\Models\Service_ServiceGroup;
use App\Models\ServiceGroup;
use App\Models\ServiceServiceGroup;
use Illuminate\Http\Request;

class ServiceGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input("perPage");
        $search = $request->input("search",);

        $serviceGroups = ServiceGroup::search($search)->latest()->paginate($perPage);
        return ServiceGroupResource::collection($serviceGroups);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceGroupRequest $request)
    {
        $validated = $request->validated();
        $validated=$request->validated();
        $serviceGroup = ServiceGroup::create($validated);
        foreach($validated['services'] as $service){

                ServiceServiceGroup::create([
                    'service_group_id' => $serviceGroup->id,
                    'service_id'=> $service['serviceId'],
                ]);

            };
            return new ServiceGroupResource($serviceGroup);
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceGroup $serviceGroup)
    {
        $serviceGroup->load('services');
        return ServiceGroupResource::make($serviceGroup);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceGroupRequest $request, ServiceGroup $serviceGroup)
    {
        $validated = $request->validated();
        $serviceGroup->update($validated);
        foreach($validated['services'] as $service){

            ServiceServiceGroup::updateOrCreate([
                'service_group_id' => $serviceGroup->id,
                'service_id'=> $service['serviceID'],
            ]);

        };

        if ($request['deletedIds']){
            foreach($request['deletedIds'] as $id){
                ServiceServiceGroup::destroy($id);
            }}

        return new ServiceGroupResource($serviceGroup);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceGroup $serviceGroup)
    {
        ServiceServiceGroup::where('service_group_id', $serviceGroup->id)->delete();

        $serviceGroup->delete();
        return new ServiceGroupResource($serviceGroup);
    }
}
