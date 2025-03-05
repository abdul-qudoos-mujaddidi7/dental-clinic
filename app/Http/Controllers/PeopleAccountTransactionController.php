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
use App\Http\Requests\PeopleAccountExchangeRequest;
use App\Http\Requests\PeopleAccountTransactionRequest;
use App\Http\Resources\PeopleAccountTransactionResource;

class PeopleAccountTransactionController extends AdminController
{
    protected $model = PeopleAccountTransaction::class;
    protected $resource = PeopleAccountTransactionResource::class;


    public function index(PaginateRequest $request)
    {
        return $this->resource::collection($this->listRecord($request, $this->model,['name']));
    }

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

  

}
