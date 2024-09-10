<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

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

    private function getProductCount(int $productId): int
    {
        $cart = $this->getCart(true);

        return $cart[$productId] ?? 0;
    }

    private function deleteCartIfEmpty(array $cart): void
    {
        if (empty($cart)) {
            Cache::forget($this->cartCacheKey);
        }
    }

    private function updateCart(array $cart): void
    {
        Cache::put($this->cartCacheKey, $cart, 3600);
    }
}
