<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input("perPage");
        $search = $request->input("search");

        $Products=Product::search($search)->latest()->paginate($perPage);
        return ProductResource::collection($Products);

    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $validated=$request->validated();
        Product::create($validated);
        return response()->json(["message"=>"record stored successfully"]);

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return ProductResource::make($product);
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $validated=$request->validated();
        $product->update($validated);
        return response()->json(['message'=>'Product updated successfully.']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
       $product->delete();
       return response()->json(['message'=>'Product deleted successfully.']);

    }
}
