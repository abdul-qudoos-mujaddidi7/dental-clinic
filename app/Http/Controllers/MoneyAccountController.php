<?php

namespace App\Http\Controllers;

use App\Models\MoneyAccount;
use App\Http\Requests\MoneyAccountRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\MoneyAccountResource;


class MoneyAccountController extends AdminController
{

    protected $model = MoneyAccount::class;
    protected $resource = MoneyAccountResource::class;


    public function index(PaginateRequest $request)
    {
        return $this->resource::collection($this->listRecord($request, $this->model,[MoneyAccount::COLUMN_NAME]));
    }

    public function show($id)
    {
        return new $this->resource($this->showRecord($this->model,$id));
    }

    public function store(MoneyAccountRequest $request)
    {
        return new $this->resource($this->storeRecord($request,$this->model));
    }

    public function update(MoneyAccountRequest $request,$id)
    {
        return new $this->resource($this->updateRecord($request,$this->model,$id));
    }

    public function destroy($id)
    {
        return $this->deleteRecord($this->model,$id);
    }
}
