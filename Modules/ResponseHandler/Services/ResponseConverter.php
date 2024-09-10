<?php

namespace Modules\ResponseHandler\Services;

use Illuminate\Http\JsonResponse;
use Modules\ResponseHandler\Contracts\ConvertsToJsonResponse;

class ResponseConverter
{
    public static function convert(ConvertsToJsonResponse $response): JsonResponse|array
    {
        return response()->json(
            data: [
                'action' => __($response->getAction()),
                'message' => __($response->getMessage()),
                'data' => $response->getData(),
                'api_version' => $response->getApiVersion(),
            ],
            status: $response->getStatusCode()
        );
    }
}
