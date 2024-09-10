<?php

namespace App\Exceptions\Cart;

use App\Exceptions\ApiBaseException;
use Illuminate\Support\Collection;

class UserCartException extends ApiBaseException
{
    public function setMetaData(string|array|Collection $metaData): static
    {
        $this->meta = $metaData;

        return $this;
    }

    public function getMetaData(): string|array|Collection
    {
        return $this->meta;
    }
}
