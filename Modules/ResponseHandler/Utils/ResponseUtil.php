<?php

namespace Modules\ResponseHandler\Utils;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Modules\ResponseHandler\Contracts\ConvertsToJsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseUtil implements ConvertsToJsonResponse
{
    private int $statusCode = Response::HTTP_OK;

    private array|Collection|JsonResource|AnonymousResourceCollection $data = [];

    private string $message;

    private string $apiVersion;

    private string $action = '';

    public static function builder(): static
    {
        return new static;
    }

    public function __construct()
    {
        $this->apiVersion = config('app.api_version');
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getData(): array|Collection|JsonResource|AnonymousResourceCollection
    {
        return $this->data;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function setData(Collection|array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function setApiVersion(string $apiVersion): static
    {
        $this->apiVersion = $apiVersion;

        return $this;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): static
    {
        $this->action = $action;

        return $this;
    }
}
