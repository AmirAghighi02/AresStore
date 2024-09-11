<?php

namespace App\Exceptions\Wallet;

use App\Exceptions\ApiBaseException;
use Illuminate\Support\Collection;

class UserWalletException extends ApiBaseException
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
