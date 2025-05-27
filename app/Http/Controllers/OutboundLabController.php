<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutboundLabRequest;
use App\Http\Resources\outboundLabResource;
use App\Models\LaboratoryDetail;
use App\Models\OutboundLab;
use App\Models\PeopleAccount;
use Illuminate\Http\Request;

class OutboundLabController extends Controller
{
    private $model=OutboundLab::class;
    private $request=OutboundLabRequest::class;
    private $resource=outboundLabResource::class;

    

    public function index(Request $request)
    {

        $outboundLab = $this->listRecord($request, $this->model, ['issue_at']);

        return $this->resource::collection($outboundLab);
    }

    public function store(Request $request)
    {
        
        $validated = app($this->request)->validated();
        $supplier = $validated['supplier_id'];

        $peopleAccount = PeopleAccount::where('people_id', $supplier)->first();
        if(!$peopleAccount){
           $peopleAccount = PeopleAccount::create([
                'name' => 'حساب افغانی',
                'people_id' => $supplier,
                'balance' => 0,
            ]);
        };

        $validated['people_account_id'] = $peopleAccount->id ;
        $outboundLab = $this->model::create($validated);

        // Handle services if provided
        if ($request->has('tooths')) {
            foreach ($validated['tooths'] as $tooth) {
                LaboratoryDetail::create([
                    'outbound_lab_id' => $outboundLab->id,
                    'cost' => $tooth['cost'],
                    'tooth_id' => $tooth['toothId'],
                    'quantity' => $tooth['quantity'],
                    'total' => $tooth['total'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }


        return new $this->resource($outboundLab->load('laboratoryDetails'));
    }

    public function show(OutboundLab $outboundLab)
    {
        $outboundLab->load(['laboratoryDetails']);
        return new $this->resource($outboundLab);
    }

    public function update(Request $request, OutboundLab $outboundLab)
    {
        $validated = app($this->request)->validated();

        // Delete old services
        $outboundLab->laboratoryDetails()->delete();

        // Update services (if provided)
        if ($request->has('tooths')) {
            $details = [];
            foreach ($validated['tooths'] as $tooth) {
                $details[] = [
                    'outbound_lab_id' => $outboundLab->id,
                    'tooth_id' => $tooth['toothId'],
                    'cost' => $tooth['cost'],
                    'quantity' => $tooth['quantity'],
                    'total' => $tooth['total'],
                    'updated_at' => now()
                ];
            }
            LaboratoryDetail::insert($details);
        }

        $outboundLab->update($validated);

        // Update or create payment information
        // CurePayment::updateOrCreate(
        //     ['cure_id' => $cure->id],
        //     ['amount' => $validated['paid'], 'date' => $validated['start_date']]
        // );

        return response()->json(['message' => 'Record Updated successfully!'], 204);
    }

    public function destroy(OutboundLab $outboundLab)
    {
        // Delete the related services first
        $outboundLab->laboratoryDetails()->delete();

        // Delete the Cure itself
        $outboundLab->delete();

        return response()->json(['message' => 'Record deleted successfully!'], 204);
    }
}