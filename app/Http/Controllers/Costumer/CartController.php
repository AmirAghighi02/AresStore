<?php

namespace App\Http\Controllers\Costumer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddOrDeleteItemCartRequest;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Modules\ResponseHandler\Services\ResponseConverter;
use Modules\ResponseHandler\Utils\ResponseUtil;

class CartController extends Controller
{
    public function store(AddOrDeleteItemCartRequest $request)
    {
        $validated = $request->validated();
        $cartService = new CartService(Auth::id());
        $cartService->addToCart($validated['product_id'], $validated['quantity']);

        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setAction(__FUNCTION__)
                ->setMessage('cart.store.successful')
                ->setData($cartService->getCart())
        );
    }

    public function destroy(AddOrDeleteItemCartRequest $request)
    {
        $validated = $request->validated();
        $cartService = new CartService(Auth::id());
        $cartService->removeFromCart($validated['product_id'], $validated['quantity']);

        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setAction(__FUNCTION__)
                ->setMessage('cart.store.successful')
                ->setData($cartService->getCart())
        );
    }
}
