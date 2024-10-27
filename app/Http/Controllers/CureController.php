<?php

namespace App\Http\Controllers;

use App\Http\Requests\CureRequest;
use App\Http\Resources\CureResource;
use App\Models\Cure;
use App\Models\CureService;
use App\Models\Patient;
use Illuminate\Http\Request;

class CureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input("perPage");
        $search = $request->input("search");

        $cures = Cure::with("patient")->search($search)->latest()->paginate($perPage);
        return CureResource::collection($cures);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(CureRequest $request)
    {

        $validated = $request->validated();

        // $patient = Patient::findOrFail($validated['patient_id']);
        // $patient->fill($request->only(['diseases_history', 'particular_to_female']))->save();
        //  The fill() method is flexible. It only updates the fields that are present in the request.
        //  If a field is missing, it won’t be changed in the database. This is useful when you're dealing
        //  with optional fields that may not always be provided.


        // Prepare an array for patient store
        // $updateData = [];

        // // Check for diseases_history and add to the update array if present
        // if ($request->has('diseases_history')) {
        //     $updateData['diseases_history'] = $validated['diseases_history'];
        // }

        // // Check for particular_to_female and add to the update array if present
        // if ($request->has('particular_to_female')) {
        //     $updateData['particular_to_female'] = $validated['particular_to_female'];
        // }

        // // Update the patient with the prepared data if there's any data to update
        // if (!empty($updateData)) {
        //     $patient->update($updateData);
        // }


        $cure = Cure::create($validated);

        if ($request->has('services')) {
            foreach ($validated['services'] as $service) {
                CureService::create([
                    'cure_id' => $cure->id,
                    'service_id' => $service['serviceId'],
                    'cost' => $service['cost'],
                    'discount' => $service['discount'],
                    'total' => $service['total'],
                    'status' => $service['status']
                ]);
            }
        }
        return new CureResource($cure->load('cureServices'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Cure $cure)
    {
        $cure->load(['patient', 'cureService']);
        return new CureResource($cure);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(CureRequest $request, Cure $cure)
    {
        $validated = $request->validated();
        // $patient = Patient::findOrFail($validated['patient_id']);
        // $patient->fill($request->only(['diseases_history', 'particular_to_female']))->save();


        // $updateData = [];
        // if ($request->has('diseases_history')) {
        //     $updateData['diseases_history'] = $validated['diseases_history'];
        // }
        // if ($request->has('particular_to_female')) {
        //     $updateData['particular_to_female'] = $validated['particular_to_female'];
        // }
        // if (!empty($updateData)) {
        //     $patient->update($updateData);
        // }

        $cure->update($validated);

        // Update services (if provided)
            if ($request->has('services')) {
                $cure->cureServices()->delete();


                $services = [];
                foreach ($validated['services'] as $service) {
                    $services[] = [  #is appending a new associative array (representing a service)
                        #to the $services array in each iteration of the loop
                        'cure_id' => $cure->id,
                        'service_id' => $service['serviceId'],
                        'cost' => $service['cost'],
                        'discount' => $service['discount'],
                        'total' => $service['total'],
                        'status' => $service['status']
                    ];
                }
                CureService::insert($services);
            }
        

        // Return the updated Cure with services
        return new CureResource($cure->load('cureServices'));
    }



    public function destroy(Cure $cure)
    {
        // Delete the related services first
        $cure->CureServices()->delete();

        // Delete the Cure itself
        $cure->delete();

        // Return a successful response (204 No Content)
        return response()->json(null, 204);
    }
}
