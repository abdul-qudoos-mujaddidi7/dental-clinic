<?php

namespace App\Http\Controllers;
use App\Http\Requests\InboundLabRequest;
use App\Http\Resources\InboundLabResource;
use App\Models\InboundLab;
use App\Models\LaboratoryDetail;
use App\Models\PeopleAccount;
use Illuminate\Http\Request;

class InboundLabController extends Controller
{

    private $model=InboundLab::class;
    private $request=InboundLabRequest::class;
    private $resource=InboundLabResource::class;

    

    public function index(Request $request)
    {

        $InboundLab = $this->listRecord($request, $this->model, ['name']);

        return $this->resource::collection($InboundLab);
    }

    public function store(Request $request)
    {
        
        $validated = app($this->request)->validated();
        $customer = $validated['customer_id'];

        $peopleAccount = PeopleAccount::where('people_id', $customer)->first();
        if(!$peopleAccount){
           $peopleAccount = PeopleAccount::create([
                'name' => 'حساب افغانی',
                'people_id' => $customer,
                'balance' => 0,
            ]);
        };

        $validated['people_account_id'] = $peopleAccount->id ;
        $InboundLab = $this->model::create($validated);

        // Handle services if provided
        if ($request->has('tooths')) {
            foreach ($validated['tooths'] as $tooth) {
                LaboratoryDetail::create([
                    'inbound_lab_id' => $InboundLab->id,
                    'cost' => $tooth['cost'],
                    'tooth_id' => $tooth['toothId'],
                    'quantity' => $tooth['quantity'],
                    'total' => $tooth['total'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }


        return new $this->resource($InboundLab->load('mainLaboratoryDetails'));
    }

    public function show(InboundLab $InboundLab)
    {
        $InboundLab->load(['mainLaboratoryDetails']);
        return new $this->resource($InboundLab);
    }

    public function update(Request $request, InboundLab $InboundLab)
    {
        $validated = app($this->request)->validated();

        // Delete old services
        $InboundLab->mainLaboratoryDetails()->delete();

        // Update services (if provided)
        if ($request->has('tooths')) {
            $details = [];
            foreach ($validated['tooths'] as $tooth) {
                $details[] = [
                    'inbound_lab_id' => $InboundLab->id,
                    'tooth_id' => $tooth['toothId'],
                    'cost' => $tooth['cost'],
                    'quantity' => $tooth['quantity'],
                    'total' => $tooth['total'],
                    'updated_at' => now()
                ];
            }
            LaboratoryDetail::insert($details);
        }

        $InboundLab->update($validated);

        // Update or create payment information
        // CurePayment::updateOrCreate(
        //     ['cure_id' => $cure->id],
        //     ['amount' => $validated['paid'], 'date' => $validated['start_date']]
        // );

        return response()->json(['message' => 'Record Updated successfully!'], 204);
    }

    public function destroy(InboundLab $InboundLab)
    {
        // Delete the related services first
        $InboundLab->mainLaboratoryDetails()->delete();

        // Delete the Cure itself
        $InboundLab->delete();

        return response()->json(['message' => 'Record deleted successfully!'], 204);
    }
}
