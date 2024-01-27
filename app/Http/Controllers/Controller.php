<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Send a Success JSON Response.
     */
    public function respond(mixed $payload = [], string $message = 'OK', int $code = 200): JsonResponse
    {
        $parameters = [
            'code' => $code,
            'success' => true,
            'message' => $message,
        ];

        if ($payload !== null) {
            $parameters['payload'] = $payload;
        }

        return response()->json($parameters, $code);
    }

    /**
     * Send a Failure JSON Response.
     */
    public function fail(string $message = 'Bad Request', int $code = 400, mixed $payload = []): JsonResponse
    {
        $parameters = [
            'code' => $code,
            'success' => false,
            'message' => $message,
        ];

        if ($payload !== null) {
            $parameters['payload'] = $payload;
        }

        throw new HttpResponseException(response()->json($parameters, $code));
    }
}
