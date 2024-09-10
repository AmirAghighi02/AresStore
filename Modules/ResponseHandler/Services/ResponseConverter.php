<?php

namespace Modules\ResponseHandler\Services;

use Illuminate\Http\JsonResponse;
use Modules\ResponseHandler\Contracts\ConvertsToJsonResponse;

class ResponseConverter
{
    public function __construct(public ConvertsToJsonResponse $response) {}

    public function response(): JsonResponse|array
    {
        return response()->json(
            data: [
                'action' => __($this->response->getAction()),
                'message' => __($this->response->getMessage()),
                'data' => $this->response->getData(),
                'api_version' => $this->response->getApiVersion(),
            ],
            status: $this->response->getStatusCode()
        );
    }
}
