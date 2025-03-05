<?php

namespace App\Http\Controllers;

use App\Models\MoneyTransfer;
use App\Http\Requests\MoneyTransferRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\MoneyTransferResource;


class MoneyTransferController extends AdminController
{

    protected $model = MoneyTransfer::class;
    protected $resource = MoneyTransferResource::class;


    public function index(PaginateRequest $request)
    {
        return $this->resource::collection($this->listRecord($request, $this->model,[
            MoneyTransfer::COLUMN_FROM_ACCOUNT_ID,
            MoneyTransfer::COLUMN_TO_ACCOUNT_ID
        ]));
    }

    public function show($id)
    {
        return new $this->resource($this->showRecord($this->model,$id));
    }

    public function store(MoneyTransferRequest $request)
    {
        return new $this->resource($this->storeRecord($request,$this->model));
    }

    public function update(MoneyTransferRequest $request,$id)
    {
        return new $this->resource($this->updateRecord($request,$this->model,$id));
    }

    public function destroy($id)
    {
        return $this->deleteRecord($this->model,$id);
    }
}
