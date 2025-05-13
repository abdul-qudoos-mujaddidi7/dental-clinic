<?php

namespace App\Http\Controllers;

use Exception;
use App\Enums\PaymentType;
use App\Enums\OperationType;
use App\Models\MoneyTransfer;
use App\Enums\TransactionType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\PaginateRequest;
use App\Models\PeopleAccountTransaction;
use Illuminate\Http\Request;
use App\Http\Requests\PeopleAccountExchangeRequest;
use App\Http\Requests\PeopleAccountTransactionRequest;
use App\Http\Resources\PeopleAccountTransactionResource;
use App\Http\Services\PaymentService;

class PeopleAccountTransactionController extends Controller
{
    protected $model = PeopleAccountTransaction::class;
    protected $resource = PeopleAccountTransactionResource::class;
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }


    public function index(Request $request)
    {
        return $this->resource::collection($this->listRecord($request, $this->model,['people_id']));
    }

//     public function index(Request $request)
// {
//     $query = PeopleAccountTransaction::query();

//      if ($request->has('people_id')) {
//         $query->where('people_id', $request->input('people_id'));
//     }

//     return PeopleAccountTransactionResource::collection(
//         $query->paginate($request->get('per_page', 10))
//     );
// }


    public function show($id)
    {
        return new $this->resource($this->showRecord($this->model,$id));
    }

    public function store(PeopleAccountTransactionRequest $request)
    {
        return new $this->resource($this->storeRecord($request,$this->model));
    }

    public function update(PeopleAccountTransactionRequest $request,$id)
    {
        return new $this->resource($this->updateRecord($request,$this->model,$id));
    }

    public function destroy($id)
    {
        return $this->deleteRecord($this->model,$id);
    }

  
    public function generatePaySlip(PeopleAccountTransactionRequest $request)
    {
        return new $this->resource($this->paymentService->generatePaySlip($request->validated()));
    }

    public function paySalary(PeopleAccountTransactionRequest $request)
    {
        return new $this->resource($this->paymentService->paySalary($request->validated()));
    }
    public function payCureCycle(PeopleAccountTransactionRequest $request)
    {
        return new $this->resource($this->paymentService->payCureCycle($request->validated()));
    }
    public function inBoundLabPayment(PeopleAccountTransactionRequest $request)
    {
        return new $this->resource($this->paymentService->inBoundLabPayment($request->validated()));
    }

    public function outBoundLabPayment(PeopleAccountTransactionRequest $request)
    {
        return new $this->resource($this->paymentService->outBoundLabPayment($request->validated()));
    }
}
