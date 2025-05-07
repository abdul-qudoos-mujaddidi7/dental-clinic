<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaginateRequest;
use App\Models\MoneyAccountTransaction;
use App\Http\Requests\MoneyAccountTransactionRequest;
use App\Http\Resources\MoneyAccountTransactionResource;

class MoneyAccountTransactionController extends AdminController
{

    protected $model = MoneyAccountTransaction::class;
    protected $resource = MoneyAccountTransactionResource::class;


    public function index(PaginateRequest $request)
    {
        return $this->resource::collection($this->listRecord($request, $this->model,[MoneyAccount::COLUMN_NAME]));
    }

    public function show($id)
    {
        return new $this->resource($this->showRecord($this->model,$id));
    }

    public function store(MoneyAccountTransactionRequest $request)
    {
        return new $this->resource($this->storeRecord($request,$this->model));
    }

    public function update(MoneyAccountTransactionRequest $request,$id)
    {
        return new $this->resource($this->updateRecord($request,$this->model,$id));
    }

    public function destroy($id)
    {
        return $this->deleteRecord($this->model,$id);
    }

 

}
