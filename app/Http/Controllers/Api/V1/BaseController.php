<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Countable;

class BaseController extends Controller
{
    /**
     * Successful response handler
     *
     * @param Countable $data
     * @param string $message
     * @param integer $responseCode
     * @param integer $statusCode
     * @return void
     */
    public function responseSuccess( $data = [], string $message = '', int $responseCode = 0, int $statusCode = 200)
    {
        $response = [
            'success' => true,
            'data' => $data,
            'message' => $message,
            'code' => $responseCode,
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * Failed response handler
     *
     * @param array $data
     * @param string $message
     * @param integer $responseCode
     * @param integer $statusCode
     * @return void
     */
    public function responseFailure(array $data = [], string $message = '', int $responseCode = 0, int $statusCode = 400)
    {
        $response = [
            'success' => false,
            'data' => $data,
            'message' => $message,
            'code' => $responseCode,
        ];

        return response()->json($response, $statusCode);
    }
}
