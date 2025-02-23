<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaboratoryRequest;
use App\Http\Resources\LaboratoryResource;
use App\Models\Laboratory;
use App\Models\LaboratoryDetail;
use Illuminate\Http\Request;

class LaboratoryController extends Controller
{

    protected $model;
    protected $request;
    protected $resource;

    public function __construct()
    {
        $this->model = Laboratory::class;
        $this->request = LaboratoryRequest::class;
        $this->resource = LaboratoryResource::class;
    }

    public function index(Request $request)
    {

        $perPage = $request->input("perPage", 10);
        $search = $request->input("search");

        $laboratories = $this->model::search($search)->latest()->paginate($perPage);

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
                    'tooth_id' => $tooth['toothId'],
                    'cost' => $tooth['cost'],
                    'quantity' => $tooth['quantity'],
                    'total' => $tooth['total'],
                    'status' => $tooth['status'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        // Handle payment if provided
        // if ($request->has('paid')) {
        //     CurePayment::create([
        //         'cure_id' => $cure->id,
        //         'amount' => $validated['paid'],
        //         'date' => $validated['start_date']
        //     ]);
        // }

        return new $this->resource($laboratory->load('details'));
    }

    public function show(Laboratory $laboratory)
    {
        $laboratory->load(['details']);
        return new $this->resource($laboratory);
    }

    public function update(Request $request, Laboratory $laboratory)
    {
        $validated = app($this->request)->validated();

        // Delete old services
        $laboratory->details()->delete();

        // Update services (if provided)
        if ($request->has('tooths')) {
            $services = [];
            foreach ($validated['tooths'] as $tooth) {
                $details[] = [
                    'laboratory_id' => $laboratory->id,
                    'tooth_id' => $tooth['toothId'],
                    'cost' => $tooth['cost'],
                    'quantity' => $tooth['quantity'],
                    'total' => $tooth['total'],
                    'status' => $tooth['status'],
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
        $laboratory->details()->delete();

        // Delete the Cure itself
        $laboratory->delete();

        return response()->json(['message' => 'Record deleted successfully!'], 204);
    }
}
