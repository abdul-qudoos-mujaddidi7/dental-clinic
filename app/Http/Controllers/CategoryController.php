<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    private $model = Category::class;
    private $resource = CategoryResource::class;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->resource::collection($this->listRecord($request, $this->model, ['name']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->storeRecord($request, Category::class);
        return new $this->resource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new $this->resource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category = $this->updateRecord($request, $category);
        return new $this->resource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->deleteRecord($category);
        return new $this->resource($category);
    }
}
