<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    public function index()
    {
        return new ProductCollection(Product::paginate(5));
    }

    public function store(ProductRequest $request)
    {
        return Product::create($request->all());
    }

    public function show(Product $product)
    {
        return new ProductResource($product);;
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->all());

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json();
    }
}
