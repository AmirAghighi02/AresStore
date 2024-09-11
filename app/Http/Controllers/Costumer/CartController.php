<?php

namespace App\Http\Controllers\Costumer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddOrDeleteItemCartRequest;
use App\Http\Requests\Cart\PayCartRequest;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Modules\ResponseHandler\Services\ResponseConverter;
use Modules\ResponseHandler\Utils\ResponseUtil;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function storeItem(AddOrDeleteItemCartRequest $request)
    {
        $validated = $request->validated();
        $cartService = new CartService(Auth::id());
        $cartService->addToCart($validated['product_id'], $validated['quantity']);

        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setAction(__FUNCTION__)
                ->setMessage('cart.store_item.successful')
                ->setData($cartService->getCart())
        );
    }

    public function destroyItem(AddOrDeleteItemCartRequest $request)
    {
        $validated = $request->validated();
        $cartService = new CartService(Auth::id());
        $cartService->removeFromCart($validated['product_id'], $validated['quantity']);

        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setAction(__FUNCTION__)
                ->setMessage('cart.destroy_item.successful')
                ->setData($cartService->getCart())
        );
    }

    public function pay(PayCartRequest $request)
    {
        $cartService = new CartService(Auth::id());
        $payment = $cartService->payCart($request->validated('address_id'));

        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setAction(__FUNCTION__)
                ->setMessage('cart.pay.created')
                ->setData([
                    'payment_id' => $payment->id,
                    'total_price' => $payment->price,
                ])
                ->setStatusCode(Response::HTTP_CREATED)
        );
    }

    public function destroy()
    {
        (new CartService(Auth::id()))->deleteCart();

        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setAction(__FUNCTION__)
                ->setMessage('cart.destroy.successful')
        );
    }
}
