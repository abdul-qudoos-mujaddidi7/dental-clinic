<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaboratoryRequest;
use App\Http\Resources\LaboratoryResource;
use App\Models\Laboratory;
use App\Models\LaboratoryDetail;
use Illuminate\Http\Request;

class LaboratoryController extends Controller
{

    private $model=Laboratory::class;
    private $request=LaboratoryRequest::class;
    private $resource=LaboratoryResource::class;

    

    public function index(Request $request)
    {

        $perPage = $request->input("perPage", 10);
        $search = $request->input("search");
        $type = $request->input("type");

        $laboratories = $this->model::where('type',$type)->search($search)->latest()->paginate($perPage);

        return $this->resource::collection($laboratories);
    }

    public function store(Request $request)
    {
        
        $validated = app($this->request)->validated();
        $laboratory = $this->model::create($validated);

        // Handle services if provided
        if ($request->has('tooths')) {
            foreach ($validated['tooths'] as $tooth) {
                LaboratoryDetail::create([
                    'laboratory_id' => $laboratory->id,
                    'cost' => $tooth['cost'],
                    'tooth_type' => $tooth['name'],
                    'quantity' => $tooth['quantity'],
                    'total' => $tooth['total'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }


        return new $this->resource($laboratory->load('laboratoryDetails'));
    }

    public function show(Laboratory $laboratory)
    {
        $laboratory->load(['laboratoryDetails']);
        return new $this->resource($laboratory);
    }

    public function update(Request $request, Laboratory $laboratory)
    {
        $validated = app($this->request)->validated();

        // Delete old services
        $laboratory->laboratoryDetails()->delete();

        // Update services (if provided)
        if ($request->has('tooths')) {
            $details = [];
            foreach ($validated['tooths'] as $tooth) {
                $details[] = [
                    'laboratory_id' => $laboratory->id,
                    'tooth_type' => $tooth['name'],
                    'cost' => $tooth['cost'],
                    'quantity' => $tooth['quantity'],
                    'total' => $tooth['total'],
                    'updated_at' => now()
                ];
            }
            LaboratoryDetail::insert($details);
        }

        $laboratory->update($validated);

        // Update or create payment information
        // CurePayment::updateOrCreate(
        //     ['cure_id' => $cure->id],
        //     ['amount' => $validated['paid'], 'date' => $validated['start_date']]
        // );

        return response()->json(['message' => 'Record Updated successfully!'], 204);
    }

    public function destroy(Laboratory $laboratory)
    {
        // Delete the related services first
        $laboratory->laboratoryDetails()->delete();

        // Delete the Cure itself
        $laboratory->delete();

        return response()->json(['message' => 'Record deleted successfully!'], 204);
    }
}
