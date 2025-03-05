<?php

namespace App\Http\Controllers;


use App\Models\PeopleAccount;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\PeopleAccountRequest;
use App\Http\Resources\PeopleAccountResource;

class PeopleAccountController extends AdminController
{


    protected $model = PeopleAccount::class;
    protected $resource = PeopleAccountResource::class;


    public function index(PaginateRequest $request)
    {
        return $this->resource::collection($this->listRecord($request, $this->model,['name']));
    }

    public function show($id)
    {
        return new $this->resource($this->showRecord($this->model,$id));
    }

    public function store(PeopleAccountRequest $request)
    {
        return new $this->resource($this->storeRecord($request,$this->model));
    }

    public function update(PeopleAccountRequest $request,$id)
    {
        return new $this->resource($this->updateRecord($request,$this->model,$id));
    }

    public function destroy($id)
    {
        return $this->deleteRecord($this->model,$id);
    }

}
