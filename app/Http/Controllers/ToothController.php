<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToothRequest;
use App\Http\Resources\ToothResource;
use App\Models\Tooth;
use Illuminate\Http\Request;

class ToothController extends Controller
{
    protected $model;
    protected $request;
    protected $resource;

    public function __construct()
    {
        $this->model = Tooth::class;
        $this->request = ToothRequest::class;
        $this->resource = ToothResource::class;
    }

    public function index(Request $request)
    {
        $perPage = $request->input("perPage", 10);
        $search = $request->input("search");

        $tooths = $this->model::search($search)->latest()->paginate($perPage);
        return $this->resource::collection($tooths);
    }

    public function store()
    {
        
        $validated = app($this->request)->validated();
        $tooth = $this->model::create($validated);
        return new $this->resource($tooth);
    }

    public function show(Tooth $tooth)
    {
        return new $this->resource($tooth);
    }

    public function update(Tooth $tooth)
    {
        $validated = app($this->request)->validated();
        $tooth->update($validated);
        return new $this->resource($tooth);
    }

    public function destroy(Tooth $tooth)
    {
        $tooth->delete();
        return response()->json(['message' => 'Record deleted successfully!']);
    }
}
