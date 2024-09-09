<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\Product\StoreProductRequest;
use App\Http\Requests\Seller\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Auth::user()->products()->paginate(Config::integer('general.default_pagination_limit'));

        return response()->json([
            'message' => 'Get products successfully.',
            'data' => ProductResource::collection($products),
        ]);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = Product::create($request->validated());

        return response()->json([
            'message' => 'Product created successfully.',
            'data' => new ProductResource($product),
        ]);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json([
            'message' => 'Get product successfully.',
            'data' => new ProductResource($product),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());

        return response()->json([
            'message' => 'Product updated successfully.',
            'data' => new ProductResource($product),
        ]);
    }
}
