<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Exceptions\Cart\UserCartException;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CartService
{
    private string $cartCacheKey;

    public function __construct(public int $userId)
    {
        $this->cartCacheKey = 'cart-'.$this->userId;
    }

    public function getCart(bool $createIfNull = false): array
    {
        $cart = Cache::get($this->cartCacheKey);
        if ($createIfNull && $cart === null) {
            Cache::put($this->cartCacheKey, $cart = [], 3600);
        }

        return $cart ?? [];
    }

    public function addToCart(int $productId, int $quantity): void
    {
        $productCount = $this->getProductCount($productId);
        if ($this->isProductAvailable($productId, $quantity + $productCount) === false) {
            throw (new UserCartException('Product is not available'))->setAction(__FUNCTION__);
        }

        $productCount += $quantity;
        $cart = $this->getCart();
        $cart[$productId] = $productCount;
        $this->updateCart($cart);
    }

    public function removeFromCart(int $productId, int $quantity): bool
    {
        $productCount = $this->getProductCount($productId);
        $productCount -= $quantity;

        if ($productCount < 0) {
            $productCount = 0;
        }

        $cart = $this->getCart();
        $cart[$productId] = $productCount;

        if ($productCount === 0) {
            unset($cart[$productId]);
        }
        $this->updateCart($cart);
        $this->deleteCartIfEmpty($cart);

        return true;
    }

    public function deleteCart(): void
    {
        Cache::forget($this->cartCacheKey);
    }

    private function getProductCount(int $productId): int
    {
        $cart = $this->getCart(true);

        return $cart[$productId] ?? 0;
    }

    private function deleteCartIfEmpty(array $cart): void
    {
        if (empty($cart)) {
            $this->deleteCart();
        }
    }

    private function updateCart(array $cart): void
    {
        Cache::put($this->cartCacheKey, $cart, 3600);
    }

    public function payCart(int $address_id)
    {
        try {
            DB::beginTransaction();

            $products = $this->getProductModelsInCartTransformed();
            $unavailable_product_ids = $this->getUnavailableProducts($products);

            if (! empty($unavailable_product_ids)) {
                throw (new UserCartException('some products are not available.'))
                    ->setBody($unavailable_product_ids)
                    ->setAction(__FUNCTION__);

            }

            $payment = $this->createOrderAndProduct($address_id, $products);
            DB::commit();

            return $payment;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    private function getUnavailableProducts(Collection $products): array
    {
        if ($products->isEmpty()) {
            throw (new UserCartException('Empty cart'))->setAction(__FUNCTION__);
        }

        $cart = $this->getCart();

        $unavailable_products = [];
        foreach ($products as $productData) {
            if ($productData['quantity'] < $cart[$productData['product_id']]) {
                $unavailable_products[] = $productData['product_id'];
            }
        }

        return $unavailable_products;
    }

    private function isProductAvailable(int $productId, int $quantity): bool
    {
        return $quantity < Product::find($productId)->quantity;
    }

    public function getTotalCartPrice(Collection $products): int
    {
        return $products->map(fn ($productData) => $productData['final_cost'] * $productData['count_in_cart'])->sum();
    }

    public function getProductModelsInCartTransformed(): Collection
    {
        $cart = $this->getCart();
        $product_ids = array_keys($cart);

        return Product::whereIn('id', $product_ids)->get()->map(function (Product $product) use ($cart) {
            return
                [
                    'count_in_cart' => $cart[$product->id],
                    'quantity' => $product->quantity,
                    'final_cost' => $product->price,
                    'product_id' => $product->id,
                ];
        });
    }

    private function createOrderAndProduct(int $address_id, Collection $products)
    {
        $total_price = $this->getTotalCartPrice($products);
        $payment = Payment::create([
            'price' => $total_price,
            'user_id' => $this->userId,
            'status' => PaymentStatus::PENDING,
        ]);

        $order = $payment->order()->create([
            'address_id' => $address_id,
            'user_id' => $this->userId,
            'status' => OrderStatus::PENDING,
            'tax' => Order::calculateTax(),
            'shipping_cost' => Order::calculateShippingCost(),
            'total_price' => $total_price,
        ]);

        $transformedProducts = [];
        foreach ($products->toArray() as $productData) {
            $product_id = Arr::pull($productData, 'product_id');
            $transformedProducts[$product_id] = [
                'count' => $productData['count_in_cart'],
                'final_cost' => $productData['final_cost'],
            ];
        }

        $order->products()->sync($transformedProducts);

        return $payment;
    }
}
