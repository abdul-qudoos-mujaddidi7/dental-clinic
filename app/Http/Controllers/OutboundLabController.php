<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutboundLabRequest;
use App\Http\Resources\outboundLabResource;
use App\Models\LaboratoryDetail;
use App\Models\OutboundLab;
use Illuminate\Http\Request;

class OutboundLabController extends Controller
{
    private $model=OutboundLab::class;
    private $request=OutboundLabRequest::class;
    private $resource=outboundLabResource::class;

    

    public function index(Request $request)
    {

        $outboundLab = $this->listRecord($request, $this->model, ['name']);

        return $this->resource::collection($outboundLab);
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
                    'tooth_id' => $tooth['toothId'],
                    'quantity' => $tooth['quantity'],
                    'total' => $tooth['total'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }


        return new $this->resource($laboratory->load('laboratoryDetails'));
    }

    public function show(OutboundLab $laboratory)
    {
        $laboratory->load(['laboratoryDetails']);
        return new $this->resource($laboratory);
    }

    public function update(Request $request, OutboundLab $laboratory)
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
                    'tooth_id' => $tooth['toothId'],
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

    public function destroy(OutboundLab $laboratory)
    {
        // Delete the related services first
        $laboratory->laboratoryDetails()->delete();

        // Delete the Cure itself
        $laboratory->delete();

        return response()->json(['message' => 'Record deleted successfully!'], 204);
    }
}
