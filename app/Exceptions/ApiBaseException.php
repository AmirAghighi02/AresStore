<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Collection;

abstract class ApiBaseException extends Exception
{
    protected array|Collection $body = [];

    protected string|array|Collection $meta = [];

    public function setBody(array|Collection $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getBody(): array|Collection
    {
        return $this->body;
    }

    abstract public function getMetaData(): string|array|Collection;
}
