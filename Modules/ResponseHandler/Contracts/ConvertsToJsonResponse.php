<?php

namespace Modules\ResponseHandler\Contracts;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

interface ConvertsToJsonResponse
{
    public function getStatusCode(): int;

    public function getApiVersion(): string;

    public function getMessage(): string;

    public function getData(): array|Collection|JsonResource;

    public function getAction(): string;

    public function getMeta(): ?array;
}
