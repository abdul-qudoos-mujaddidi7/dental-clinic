<?php

namespace App\Http\Controllers;

use App\Models\MoneyAccount;
use App\Http\Requests\MoneyAccountRequest;
use Illuminate\Http\Request;

use App\Http\Resources\MoneyAccountResource;


class MoneyAccountController extends Controller
{

    protected $model = MoneyAccount::class;
    protected $resource = MoneyAccountResource::class;


    public function index(Request $request)
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

    public function update(MoneyAccountRequest $request, MoneyAccount $moneyAccount)
    {
        return new $this->resource($this->updateRecord($request,$moneyAccount,));
    }

    public function destroy( MoneyAccount $moneyAccount)
    {
        return $this->deleteRecord( $moneyAccount);
    }
}
