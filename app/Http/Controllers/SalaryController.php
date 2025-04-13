<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryRequest;
use App\Http\Resources\SalaryResource;
use App\Models\Salary;
use App\Http\Resources\SalaryResource;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    private $model = Salary::class;
    private $resource = SalaryResource::class;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        return $this->resource::collection($this->listRecord($request,$this->model,['name']));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(SalaryRequest $request)
    {
        $lead = $this->storeRecord($request, Salary::class);
        return new $this->resource($lead);
    }

    /**
     * Display the specified resource.
     */
    public function show(Salary $salary)
    {
        return new $this->resource($salary);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(SalaryRequest $request, Salary $salary)
    {
        
        $salary = $this->updateRecord($request, $salary);
        return new $this->resource($salary);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salary $salary)
    {
        $this->deleteRecord($salary);
        return new $this->resource($salary);
    }
}
