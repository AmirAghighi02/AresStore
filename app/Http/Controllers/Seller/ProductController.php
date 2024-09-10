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
use Modules\ResponseHandler\Services\ResponseConverter;
use Modules\ResponseHandler\Utils\ResponseUtil;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Auth::user()->products()->paginate(Config::integer('general.default_pagination_limit'));

        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setAction(__FUNCTION__)
                ->setMessage('product.index.successful')
                ->setData(ProductResource::collection($products))
        );
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = Product::create($request->validated());

        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setMessage('product.store.successful')
                ->setData(new ProductResource($product))
                ->setStatusCode(Response::HTTP_CREATED)
                ->setAction(__FUNCTION__)
        );
    }

    public function show(Product $product): JsonResponse
    {
        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setMessage('product.show.successful')
                ->setData(new ProductResource($product))
                ->setAction(__FUNCTION__)
        );
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());

        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setMessage('product.update.successful')
                ->setData(new ProductResource($product))
                ->setAction(__FUNCTION__)
        );
    }
}
